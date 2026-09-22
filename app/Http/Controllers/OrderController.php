<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Notifications\AppNotification;
use App\Services\Order\OrderCalculatorService;
use App\Support\OrderHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RuntimeException;

class OrderController extends Controller
{
    /**
     * Simpan pesanan baru dari pelanggan.
     *
     * Backend menghitung ulang seluruh harga & biaya QRIS dari config/menu.php.
     * Mendukung metode pembayaran QRIS dan WhatsApp.
     */
    public function store(StoreOrderRequest $request, OrderCalculatorService $calculator): JsonResponse
    {
        try {
            $calculated = $calculator->calculate($request->validated());

            /** @var User|null $customer */
            $customer = auth()->user();

            $order = DB::transaction(function () use ($request, $customer, $calculated): Order {
                return Order::create([
                    'customer_id' => $customer?->id,
                    'customer_name' => $request->input('customer_name'),
                    'customer_phone' => $request->input('customer_phone'),
                    'payment_method' => $request->input('payment_method', 'qris'),
                    'order_status' => 'pesanan_dibuat',
                    'payment_status' => 'belum_bayar',
                    'pickup_date' => $request->input('pickup_date'),
                    'pickup_time' => $request->input('pickup_time'),
                    'bakery_request' => $request->input('bakery_request'),
                    'queue_number' => OrderHelper::nextQueueNumber(),
                    'subtotal' => $calculated['subtotal'],
                    'add_ons_total' => $calculated['add_ons_total'],
                    'qris_fee' => $calculated['qris_fee'],
                    'total' => $calculated['total'],
                    'order_data' => $calculated['items'],
                ]);
            });

            $this->notifyAdmins(new AppNotification(
                'Pesanan Baru '.$order->order_number,
                'Pesanan baru dari '.$order->customer_name.' dengan total Rp'.number_format($order->total, 0, ',', '.'),
                route('admin.orders.show', $order),
            ));

            return response()->json([
                'success' => true,
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'queue_number' => $order->queue_number,
                    'customer_name' => $order->customer_name,
                    'customer_phone' => $order->customer_phone,
                    'payment_method' => $order->payment_method,
                    'payment_status' => $order->payment_status,
                    'payment_status_label' => $order->payment_status_label,
                    'order_status' => $order->order_status,
                    'order_status_label' => $order->order_status_label,
                    'pickup_date' => $order->pickup_date?->format('Y-m-d'),
                    'pickup_time' => $order->pickup_time,
                    'pickup_label' => $order->pickup_label,
                    'bakery_request' => $order->bakery_request,
                    'subtotal' => $order->subtotal,
                    'add_ons_total' => $order->add_ons_total,
                    'qris_fee' => $order->qris_fee,
                    'total' => $order->total,
                    'order_data' => $order->order_data,
                    'qris_image' => asset('images/payment/qris.svg'),
                    'qris_logo' => asset('images/payment/qris-logo.svg'),
                    'wa_link' => OrderHelper::waOrderLink($order),
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
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->query('search'));

                $query->where(function ($query) use ($search) {
                    $query->where('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");

                    if (preg_match('/\d+/', $search, $matches) === 1) {
                        $query->orWhere('id', (int) $matches[0]);
                    }
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

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

        if ($order->customer) {
            $order->customer->notify(new AppNotification(
                'Pesanan '.$order->order_number,
                'Status pesanan Anda berubah menjadi "'.$order->order_status_label.'".',
                route('customer.orders'),
            ));
        }

        return back()->with('status', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Kirim notifikasi database ke seluruh admin.
     */
    private function notifyAdmins(AppNotification $notification): void
    {
        foreach (User::query()->where('role', 'admin')->get() as $admin) {
            $admin->notify($notification);
        }
    }
}
