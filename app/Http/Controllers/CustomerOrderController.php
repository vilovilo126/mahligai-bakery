<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\OrderHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    /**
     * Daftar pesanan milik pelanggan yang sedang login.
     */
    public function index(): View
    {
        /** @var User $customer */
        $customer = auth()->user();

        $orders = Order::forCustomer($customer)
            ->latest()
            ->paginate(10);

        return view('customer.orders', compact('orders', 'customer'));
    }

    /**
     * Detail satu pesanan milik pelanggan.
     */
    public function show(Order $order): View
    {
        /** @var User $customer */
        $customer = auth()->user();

        abort_unless($order->customer_id === $customer->id, 403);

        return view('customer.order-show', compact('order', 'customer'));
    }

    /**
     * Muat detail pesanan dalam bentuk JSON (untuk struk & notifikasi).
     */
    public function json(Order $order): JsonResponse
    {
        /** @var User $customer */
        $customer = auth()->user();

        abort_unless($order->customer_id === $customer->id, 403);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'queue_number' => $order->queue_number,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'payment_method' => $order->payment_method,
                'payment_method_label' => $order->payment_method_label,
                'payment_status' => $order->payment_status,
                'payment_status_label' => $order->payment_status_label,
                'order_status' => $order->order_status,
                'order_status_label' => $order->order_status_label,
                'pickup_date' => $order->pickup_date?->format('Y-m-d'),
                'pickup_time' => substr((string) $order->pickup_time, 0, 5),
                'pickup_label' => $order->pickup_label,
                'bakery_request' => $order->bakery_request,
                'subtotal' => $order->subtotal,
                'add_ons_total' => $order->add_ons_total,
                'qris_fee' => $order->qris_fee,
                'total' => $order->total,
                'order_data' => $order->order_data,
                'created_at' => $order->created_at?->format('d M Y H:i'),
                'wa_link' => OrderHelper::waOrderLink($order),
                'chat_wa_link' => OrderHelper::customerChatWhatsAppLink($order),
            ],
        ]);
    }
}
