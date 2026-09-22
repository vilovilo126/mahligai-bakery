<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Dasbor admin: ringkasan pesanan, notifikasi, dan chat.
     */
    public function index(): View
    {
        $pendingOrders = Order::where('payment_status', '!=', 'sukses')
            ->latest()
            ->limit(8)
            ->get();

        $stats = [
            'total_orders' => Order::count(),
            'total_customers' => Order::query()->whereNotNull('customer_id')->distinct('customer_id')->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'pending_orders' => Order::where('payment_status', '!=', 'sukses')->count(),
            'in_progress_orders' => Order::where('order_status', 'pesanan_diproses')->count(),
            'ready_orders' => Order::where('order_status', 'pesanan_siap')->count(),
            'unread_chats' => Chat::whereHas('messages', function ($query) {
                $query->where('sender', 'customer')->where('read_by_admin', false);
            })->count(),
        ];

        /** @var User $admin */
        $admin = Auth::user();

        $unreadNotifications = $admin->unreadNotifications()->latest()->limit(10)->get();
        $recentNotifications = $admin->notifications()->latest()->limit(10)->get();

        return view('admin.dashboard', compact('pendingOrders', 'stats', 'unreadNotifications', 'recentNotifications'));
    }
}
