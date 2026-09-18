<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\Order\OrderCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class OrderController extends Controller
{
    /**
     * Simpan pesanan baru dari pelanggan.
     *
     * Backend menghitung ulang seluruh harga & biaya QRIS dari config/menu.php.
     * Mendukung metode pembayaran QRIS dan WhatsApp, tanpa memerlukan login.
     */
    public function store(StoreOrderRequest $request, OrderCalculatorService $calculator): JsonResponse
    {
        try {
            $calculated = $calculator->calculate($request->validated());

            $order = Order::create([
                'customer_name' => $request->input('customer_name'),
                'customer_phone' => $request->input('customer_phone'),
                'payment_method' => $request->input('payment_method', 'qris'),
                'order_status' => 'menunggu_pembayaran',
                'payment_status' => 'belum_bayar',
                'subtotal' => $calculated['subtotal'],
                'add_ons_total' => $calculated['add_ons_total'],
                'qris_fee' => $calculated['qris_fee'],
                'total' => $calculated['total'],
                'order_data' => $calculated['items'],
            ]);

            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'total' => $order->total,
                    'qris_fee' => $order->qris_fee,
                    'qris_image' => asset('images/payment/qris.svg'),
                    'payment_method' => $order->payment_method,
                ],
            ]);
        } catch (RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Daftar pesanan untuk admin.
     */
    public function index(): View
    {
        $orders = Order::latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail pesanan untuk admin.
     */
    public function show(Order $order): View
    {
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Perbarui status pesanan/pembayaran oleh admin.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'order_status' => ['required', 'string', 'in:'.implode(',', array_keys(Order::ORDER_STATUSES))],
            'payment_status' => ['required', 'string', 'in:'.implode(',', array_keys(Order::PAYMENT_STATUSES))],
        ]);

        $order->update($request->only(['order_status', 'payment_status']));

        return back()->with('status', 'Status pesanan berhasil diperbarui.');
    }
}
