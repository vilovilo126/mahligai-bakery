<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_routes(): void
    {
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
        $this->get('/admin/orders')->assertRedirect(route('login'));
        $this->get('/admin/customers')->assertRedirect(route('login'));
    }

    public function test_non_admin_user_is_blocked_from_admin_routes(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'user']));

        $this->get('/admin/dashboard')->assertForbidden();
    }

    public function test_customer_user_is_blocked_from_admin_routes(): void
    {
        $this->actingAs(User::factory()->customer()->create());

        $this->get('/admin/dashboard')->assertForbidden();

        Order::create([
            'customer_name' => 'Made Wijaya',
            'customer_phone' => '081234567890',
            'payment_method' => 'qris',
            'order_status' => 'menunggu_pembayaran',
            'payment_status' => 'belum_bayar',
            'queue_number' => 1,
            'pickup_date' => now()->addDay(),
            'pickup_time' => '14:00',
            'subtotal' => 14000,
            'add_ons_total' => 0,
            'qris_fee' => 0,
            'total' => 14000,
            'order_data' => [],
        ]);

        $this->patch('/admin/orders/1/status', [
            'order_status' => 'pesanan_diproses',
            'payment_status' => 'sukses',
        ])->assertForbidden();
    }

    public function test_admin_can_access_admin_routes(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $this->get('/admin/dashboard')->assertOk();
    }
}
