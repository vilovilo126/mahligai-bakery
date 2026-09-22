<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerNotificationController extends Controller
{
    /**
     * Halaman notifikasi pelanggan.
     */
    public function index(): View
    {
        /** @var User $customer */
        $customer = auth()->user();

        $notifications = $customer->notifications()->latest()->paginate(15);

        return view('customer.notifications', compact('notifications'));
    }

    /**
     * Daftar notifikasi ringan dalam JSON (untuk bell di navbar).
     */
    public function list(): JsonResponse
    {
        /** @var User $customer */
        $customer = auth()->user();

        $notifications = $customer->notifications()->latest()->limit(10)->get();

        return response()->json([
            'unread_count' => $customer->unreadNotifications()->count(),
            'notifications' => $notifications->map(function ($notification) {
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
     * Tandai satu atau semua notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(Request $request, ?string $notificationId = null): JsonResponse
    {
        /** @var User $customer */
        $customer = auth()->user();

        if ($notificationId) {
            $customer->notifications()
                ->where('id', $notificationId)
                ->first()
                ?->markAsRead();
        } else {
            $customer->unreadNotifications->markAsRead();
        }

        return response()->json([
            'success' => true,
            'unread_count' => $customer->unreadNotifications()->count(),
        ]);
    }
}
