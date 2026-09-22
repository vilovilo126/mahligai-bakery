<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminNotificationController extends Controller
{
    /**
     * Halaman notifikasi admin.
     */
    public function index(): View
    {
        /** @var User $admin */
        $admin = Auth::user();

        $notifications = $admin->notifications()->latest()->paginate(15);

        return view('admin.notifications', compact('notifications'));
    }

    /**
     * Daftar notifikasi terbaru dalam JSON (untuk bell di layout admin).
     */
    public function list(): JsonResponse
    {
        /** @var User $admin */
        $admin = Auth::user();

        return response()->json([
            'unread_count' => $admin->unreadNotifications()->count(),
            'notifications' => $admin->notifications()->latest()->limit(10)->get()->map(function ($notification) {
                $data = $notification->data;

                return [
                    'id' => $notification->id,
                    'title' => $data['title'] ?? 'Notifikasi',
                    'body' => $data['body'] ?? '',
                    'url' => $data['url'] ?? null,
                    'read' => $notification->read(),
                    'created_at' => $notification->created_at?->diffForHumans(),
                ];
            }),
        ]);
    }

    /**
     * Tandai satu atau semua notifikasi admin sebagai sudah dibaca.
     */
    public function markAsRead(Request $request, ?string $notificationId = null): JsonResponse
    {
        /** @var User $admin */
        $admin = Auth::user();

        if ($notificationId) {
            $admin->notifications()
                ->where('id', $notificationId)
                ->first()
                ?->markAsRead();
        } else {
            $admin->unreadNotifications->markAsRead();
        }

        return response()->json([
            'success' => true,
            'unread_count' => $admin->unreadNotifications()->count(),
        ]);
    }
}
