<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerOrderTest extends TestCase
{
    use RefreshDatabase;

    private function createOrder(User $customer, array $overrides = []): Order
    {
        return Order::create(array_merge([
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_phone' => '08113996988',
            'payment_method' => 'qris',
            'order_status' => 'pesanan_dibuat',
            'payment_status' => 'belum_bayar',
            'queue_number' => 1,
            'pickup_date' => now()->addDay(),
            'pickup_time' => '12:00',
            'subtotal' => 14000,
            'add_ons_total' => 0,
            'qris_fee' => 0,
            'total' => 14000,
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
                    'add_ons' => [],
                    'add_ons_total' => 0,
                ],
            ],
        ], $overrides));
    }

    public function test_customer_can_see_own_orders_list(): void
    {
        $customer = User::factory()->customer()->create();
        $this->createOrder($customer);

        $this->actingAs($customer);

        $this->get(route('customer.orders'))
            ->assertOk()
            ->assertSee($customer->name)
            ->assertSee('Pesanan Saya');
    }

    public function test_customer_can_see_own_order_detail(): void
    {
        $customer = User::factory()->customer()->create();
        $order = $this->createOrder($customer);

        $this->actingAs($customer);

        $this->get(route('customer.orders.show', $order))
            ->assertOk()
            ->assertSee('MB-0001')
            ->assertSee('TIRAMISU CRUNCHY');
    }

    public function test_customer_cannot_see_others_order_detail(): void
    {
        $owner = User::factory()->customer()->create();
        $other = User::factory()->customer()->create();
        $order = $this->createOrder($owner);

        $this->actingAs($other);

        $this->get(route('customer.orders.show', $order))->assertForbidden();
        $this->getJson(route('customer.orders.json', $order))->assertForbidden();
    }

    public function test_order_json_contains_struk_data(): void
    {
        $customer = User::factory()->customer()->create();
        $order = $this->createOrder($customer);

        $this->actingAs($customer);

        $this->getJson(route('customer.orders.json', $order))
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('order.order_number', 'MB-0001')
            ->assertJsonPath('order.queue_number', 1)
            ->assertJsonPath('order.total', 14000)
            ->assertJsonStructure(['order' => ['wa_link', 'chat_wa_link', 'order_data']]);
    }

    public function test_order_list_only_shows_own_orders(): void
    {
        $customer = User::factory()->customer()->create();
        $other = User::factory()->customer()->create();
        $own = $this->createOrder($customer);
        $this->createOrder($other, ['customer_name' => $other->name, 'queue_number' => 2]);

        $this->actingAs($customer);

        $response = $this->get(route('customer.orders'))->assertOk();

        $response->assertSee($own->order_number);
        $response->assertDontSee('MB-0002');
    }
}
