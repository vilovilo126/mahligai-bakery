<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrdersTest extends TestCase
{
    use RefreshDatabase;

    private function createOrder(): Order
    {
        return Order::create([
            'customer_name' => 'Made Wijaya',
            'customer_phone' => '081234567890',
            'payment_method' => 'qris',
            'order_status' => 'menunggu_pembayaran',
            'payment_status' => 'belum_bayar',
            'subtotal' => 14000,
            'add_ons_total' => 7000,
            'qris_fee' => 0,
            'total' => 21000,
            'order_data' => [
                [
                    'group_id' => 'roti-sisir',
                    'group_title' => 'ROTI SISIR',
                    'variant' => 'TIRAMISU CRUNCHY',
                    'package' => null,
                    'quantity' => 1,
                    'price' => 14000,
                    'qris_fee' => 0,
                    'subtotal' => 14000,
                    'add_ons' => [
                        ['name' => 'PITA, KARTU UCAPAN, & HANGTAG', 'price' => 7000],
                    ],
                    'add_ons_total' => 7000,
                ],
            ],
        ]);
    }

    public function test_admin_can_see_orders_list(): void
    {
        $this->createOrder();

        $this->get('/admin/orders')
            ->assertOk()
            ->assertSee('Made Wijaya')
            ->assertSee('Daftar Pesanan');
    }

    public function test_admin_can_see_order_detail(): void
    {
        $order = $this->createOrder();

        $this->get('/admin/orders/'.$order->id)
            ->assertOk()
            ->assertSee('TIRAMISU CRUNCHY')
            ->assertSee('Made Wijaya')
            ->assertSee('Rp21.000');
    }

    public function test_admin_can_update_order_status(): void
    {
        $order = $this->createOrder();

        $this->patch('/admin/orders/'.$order->id.'/status', [
            'order_status' => 'pesanan_diproses',
            'payment_status' => 'sukses',
        ])->assertRedirect();

        $order->refresh();

        $this->assertSame('pesanan_diproses', $order->order_status);
        $this->assertSame('sukses', $order->payment_status);
    }
}
