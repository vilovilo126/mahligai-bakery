<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminChatController extends Controller
{
    /**
     * Halaman chat admin (daftar percakapan + percakapan aktif).
     */
    public function index(): View
    {
        $chats = Chat::with('customer')
            ->withCount(['messages', 'unreadByAdmin'])
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.chat', compact('chats'));
    }

    /**
     * Daftar percakapan (untuk badge unread di sidebar/topbar).
     */
    public function overview(): JsonResponse
    {
        $chats = Chat::with('customer')
            ->withCount('unreadByAdmin')
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'chats' => $chats->map(function (Chat $chat) {
                return [
                    'id' => $chat->id,
                    'customer_name' => $chat->customer?->name ?? 'Konsumen',
                    'last_message' => $chat->messages()->latest('id')->value('message'),
                    'last_message_at' => $chat->last_message_at ? $chat->last_message_at->diffForHumans() : null,
                    'unread' => (int) $chat->unread_by_admin_count,
                ];
            }),
            'total_unread' => $chats->sum(fn (Chat $chat) => $chat->unread_by_admin_count),
        ]);
    }

    /**
     * Ambil pesan percakapan (sekaligus tandai sudah dibaca).
     */
    public function messages(Chat $chat): JsonResponse
    {
        abort_if($chat->admin_id !== null && $chat->admin_id !== Auth::id(), 403);

        $chat->messages()
            ->where('sender', ChatMessage::SENDER_CUSTOMER)
            ->where('read_by_admin', false)
            ->update(['read_by_admin' => true]);

        return response()->json([
            'messages' => $this->serializeMessages($chat->messages),
        ]);
    }

    /**
     * Kirim pesan balasan dari admin.
     */
    public function send(Request $request, Chat $chat): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        /** @var User $admin */
        $admin = Auth::user();

        $message = $chat->messages()->create([
            'sender' => ChatMessage::SENDER_ADMIN,
            'message' => $validated['message'],
            'read_by_customer' => false,
            'read_by_admin' => true,
        ]);

        $chat->update([
            'admin_id' => $admin->id,
            'last_message_at' => now(),
        ]);

        if ($chat->customer) {
            $chat->customer->notify(new AppNotification(
                'Balasan dari Admin',
                Str::limit($message->message, 120),
                '#chat',
            ));
        }

        return response()->json([
            'success' => true,
            'message' => $this->serializeMessage($message),
        ], 201);
    }

    /**
     * @param  Collection<int, ChatMessage>  $messages
     */
    private function serializeMessages($messages): array
    {
        return $messages->map(fn (ChatMessage $message) => $this->serializeMessage($message))->all();
    }

    private function serializeMessage(ChatMessage $message): array
    {
        return [
            'id' => $message->id,
            'sender' => $message->sender,
            'sender_label' => $message->sender === ChatMessage::SENDER_ADMIN ? 'Admin Mahligai Bakery' : $message->chat?->customer?->name ?? 'Konsumen',
            'message' => $message->message,
            'created_at' => $message->created_at?->format('H:i'),
        ];
    }
}
