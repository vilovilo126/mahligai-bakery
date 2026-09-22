<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCustomersTest extends TestCase
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

    private function createOrderFor(User $customer): Order
    {
        return Order::create([
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => '081234567890',
            'payment_method' => 'qris',
            'order_status' => 'pesanan_dibuat',
            'payment_status' => 'belum_bayar',
            'queue_number' => 1,
            'subtotal' => 14000,
            'add_ons_total' => 0,
            'qris_fee' => 0,
            'total' => 14000,
            'order_data' => [],
        ]);
    }

    public function test_guest_is_redirected_to_admin_login(): void
    {
        $this->get('/admin/customers')->assertRedirect(route('login'));
    }

    public function test_admin_can_see_customers_list(): void
    {
        $this->actingAsAdmin();

        $customer = User::factory()->customer()->create(['name' => 'Made Wijaya']);
        $this->createOrderFor($customer);

        User::factory()->customer()->create(['name' => 'Tanpa Pesanan']);

        $this->get('/admin/customers')
            ->assertOk()
            ->assertSee('Pelanggan')
            ->assertSee('Made Wijaya')
            ->assertSee('Hubungi WA')
            ->assertDontSee('Tanpa Pesanan');
    }
}
