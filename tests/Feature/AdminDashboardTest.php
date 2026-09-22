<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
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

    private function createOrderFor(User $customer, array $overrides = []): Order
    {
        return Order::create(array_merge([
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => '081234567890',
            'payment_method' => 'qris',
            'order_status' => 'pesanan_dibuat',
            'payment_status' => 'belum_bayar',
            'queue_number' => Order::whereNotNull('queue_number')->max('queue_number') + 1,
            'subtotal' => 14000,
            'add_ons_total' => 0,
            'qris_fee' => 0,
            'total' => 14000,
            'order_data' => [
                [
                    'group_id' => 'roti-sisir',
                    'group_title' => 'ROTI SISIR',
                    'variant' => 'ORIGINAL',
                    'package' => null,
                    'quantity' => 1,
                    'price' => 14000,
                    'qris_fee' => 0,
                    'subtotal' => 14000,
                    'add_ons' => [],
                    'add_ons_total' => 0,
                ],
            ],
        ], $overrides));
    }

    public function test_admin_dashboard_shows_stats(): void
    {
        $this->actingAsAdmin();

        $customer = User::factory()->customer()->create(['name' => 'Made Wijaya']);

        $this->createOrderFor($customer);
        $this->createOrderFor($customer, ['payment_status' => 'diproses', 'order_status' => 'pesanan_diproses']);
        $this->createOrderFor($customer, ['payment_status' => 'sukses', 'order_status' => 'pesanan_siap']);

        $this->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Total Pesanan')
            ->assertSee('Total Pelanggan')
            ->assertSee('Pesanan Hari Ini')
            ->assertSee('Menunggu Pembayaran')
            ->assertSee('Sedang Diproses')
            ->assertSee('Siap Diambil');
    }
}
