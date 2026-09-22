<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Notifications\AppNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CustomerChatController extends Controller
{
    /**
     * Tampilkan halaman chat pelanggan.
     */
    public function index(): JsonResponse
    {
        /** @var User $customer */
        $customer = auth()->user();

        $chat = $customer->chat;

        if (! $chat) {
            return response()->json([
                'messages' => [],
                'admin_name' => 'Admin Mahligai Bakery',
            ]);
        }

        $this->markCustomerRead($chat);

        return response()->json([
            'messages' => $this->serializeMessages($chat->messages),
            'admin_name' => 'Admin Mahligai Bakery',
        ]);
    }

    /**
     * Kirim pesan dari pelanggan (poll/send via POST).
     */
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        /** @var User $customer */
        $customer = auth()->user();

        $chat = $customer->chat()->firstOrCreate(
            ['customer_id' => $customer->id],
            ['admin_id' => null],
        );

        $message = $chat->messages()->create([
            'sender' => ChatMessage::SENDER_CUSTOMER,
            'message' => $validated['message'],
            'read_by_customer' => true,
            'read_by_admin' => false,
        ]);

        $chat->update(['last_message_at' => now()]);

        $this->notifyAdmins(new AppNotification(
            'Pesan Baru dari '.$customer->name,
            Str::limit($message->message, 120),
            route('admin.chat'),
        ));

        return response()->json([
            'success' => true,
            'message' => $this->serializeMessage($message),
        ], Response::HTTP_CREATED);
    }

    /**
     * Polling pesan baru setelah id tertentu.
     */
    public function poll(Request $request): JsonResponse
    {
        $afterId = (int) $request->input('after', 0);

        /** @var User $customer */
        $customer = auth()->user();

        $chat = $customer->chat;

        if (! $chat) {
            return response()->json(['messages' => []]);
        }

        $messages = $chat->messages()
            ->when($afterId > 0, fn ($query) => $query->where('id', '>', $afterId))
            ->get();

        if ($messages->isNotEmpty()) {
            $this->markCustomerRead($chat);
        }

        return response()->json([
            'messages' => $this->serializeMessages($messages),
        ]);
    }

    private function markCustomerRead(Chat $chat): void
    {
        $chat->messages()
            ->where('sender', ChatMessage::SENDER_ADMIN)
            ->where('read_by_customer', false)
            ->update(['read_by_customer' => true]);
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
            'sender_label' => $message->sender === ChatMessage::SENDER_ADMIN ? 'Admin Mahligai Bakery' : 'Anda',
            'message' => $message->message,
            'created_at' => $message->created_at?->format('H:i'),
        ];
    }

    private function notifyAdmins(AppNotification $notification): void
    {
        foreach (User::query()->where('role', 'admin')->get() as $admin) {
            $admin->notify($notification);
        }
    }
}
