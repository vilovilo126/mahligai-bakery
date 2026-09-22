<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrdersTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->create([
            'username' => 'admin',
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        return $admin;
    }

    private function createOrder(): Order
    {
        return Order::create([
            'customer_name' => 'Made Wijaya',
            'customer_phone' => '081234567890',
            'payment_method' => 'qris',
            'order_status' => 'menunggu_pembayaran',
            'payment_status' => 'belum_bayar',
            'queue_number' => 1,
            'pickup_date' => now()->addDay(),
            'pickup_time' => '14:00',
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

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/admin/orders')->assertRedirect(route('login'));
    }

    public function test_admin_can_see_orders_list(): void
    {
        $this->actingAsAdmin();
        $this->createOrder();

        $this->get('/admin/orders')
            ->assertOk()
            ->assertSee('Made Wijaya')
            ->assertSee('Daftar Pesanan');
    }

    public function test_admin_can_see_order_detail(): void
    {
        $this->actingAsAdmin();
        $order = $this->createOrder();

        $this->get('/admin/orders/'.$order->id)
            ->assertOk()
            ->assertSee('TIRAMISU CRUNCHY')
            ->assertSee('Made Wijaya')
            ->assertSee('Rp21.000')
            ->assertSee('Tanggal Pesan')
            ->assertSee('Jam Pesan')
            ->assertSee('Tgl Pengambilan')
            ->assertSee('Jam Pengambilan')
            ->assertSee('Struk Pesanan')
            ->assertSee('Cetak Struk');
    }

    public function test_admin_can_search_orders(): void
    {
        $this->actingAsAdmin();
        $this->createOrder();
        Order::create([
            'customer_name' => 'Siti Aminah',
            'customer_phone' => '0813999888777',
            'payment_method' => 'wa',
            'order_status' => 'menunggu_pembayaran',
            'payment_status' => 'belum_bayar',
            'queue_number' => 2,
            'pickup_date' => now()->addDay(),
            'pickup_time' => '15:00',
            'subtotal' => 14000,
            'add_ons_total' => 0,
            'qris_fee' => 0,
            'total' => 14000,
            'order_data' => [],
        ]);

        $this->get('/admin/orders?search=Siti')
            ->assertOk()
            ->assertSee('Siti Aminah')
            ->assertDontSee('Made Wijaya');

        $this->get('/admin/orders?search=MB-0001')
            ->assertOk()
            ->assertSee('Made Wijaya');
    }

    public function test_admin_can_update_order_status(): void
    {
        $this->actingAsAdmin();
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
