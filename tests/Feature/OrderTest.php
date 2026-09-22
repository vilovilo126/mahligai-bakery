<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Support\OrderHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsCustomer(string $name = 'Budi Santoso'): User
    {
        $customer = User::factory()->customer()->create(['name' => $name]);

        $this->actingAs($customer);

        return $customer;
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '08113996988',
            'payment_method' => 'qris',
            'pickup_date' => now()->addDay()->format('Y-m-d'),
            'pickup_time' => '10:00',
            'items' => [
                [
                    'group_id' => 'roti-sisir',
                    'variant' => 'TIRAMISU CRUNCHY',
                    'package' => null,
                    'add_ons' => ['PITA, KARTU UCAPAN, & HANGTAG'],
                    'quantity' => 1,
                ],
            ],
        ], $overrides);
    }

    public function test_order_requires_customer_login(): void
    {
        $this->postJson('/orders', $this->validPayload())
            ->assertStatus(401);
    }

    public function test_order_can_be_created_by_logged_in_customer(): void
    {
        $this->actingAsCustomer();

        $response = $this->postJson('/orders', $this->validPayload());

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('order.payment_method', 'qris');

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '08113996988',
            'total' => 21000,
        ]);
    }

    public function test_order_gets_queue_and_order_number(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload())->assertOk();

        $first = Order::firstOrFail();
        $this->assertSame(1, $first->queue_number);
        $this->assertSame('MB-0001', $first->order_number);

        $this->actingAs(User::factory()->customer()->create());
        $this->postJson('/orders', $this->validPayload())->assertOk();

        $second = Order::orderByDesc('id')->firstOrFail();
        $this->assertSame(2, $second->queue_number);
        $this->assertSame('MB-0002', $second->order_number);
    }

    public function test_pickup_fields_are_stored(): void
    {
        $this->actingAsCustomer();

        $pickupDate = now()->addDay()->format('Y-m-d');

        $this->postJson('/orders', $this->validPayload([
            'pickup_date' => $pickupDate,
            'pickup_time' => '15:30',
            'bakery_request' => 'Tolong jangan terlalu manis',
        ]))->assertOk();

        $order = Order::firstOrFail();
        $this->assertSame($pickupDate, $order->pickup_date->format('Y-m-d'));
        $this->assertSame('15:30', substr((string) $order->pickup_time, 0, 5));
        $this->assertSame('Tolong jangan terlalu manis', $order->bakery_request);
    }

    public function test_pickup_date_cannot_be_in_the_past(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload([
            'pickup_date' => now()->subDay()->format('Y-m-d'),
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('pickup_date');
    }

    public function test_additional_is_stored_in_order_data(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload());

        $order = Order::firstOrFail();

        $this->assertSame(7000, $order->add_ons_total);
        $this->assertSame(14000, $order->subtotal);
        $this->assertSame(21000, $order->total);

        $item = $order->order_data[0];
        $this->assertSame('TIRAMISU CRUNCHY', $item['variant']);
        $this->assertSame('PITA, KARTU UCAPAN, & HANGTAG', $item['add_ons'][0]['name']);
    }

    public function test_name_is_required(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload(['customer_name' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('customer_name');
    }

    public function test_phone_is_required(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload(['customer_phone' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('customer_phone');
    }

    public function test_items_are_required(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload(['items' => []]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('items');
    }

    public function test_manipulated_price_is_recomputed_by_backend(): void
    {
        // Frontend berusaha menipu dengan harga sangat murah.
        $this->actingAsCustomer();

        $payload = $this->validPayload();
        $payload['items'][0]['price'] = 1;
        $payload['items'][0]['add_ons'][0] = 'KARTU UCAPAN';
        $payload['items'][0]['add_ons'] = [];

        $this->postJson('/orders', $payload)->assertOk();

        $order = Order::firstOrFail();
        $this->assertSame(14000, $order->total);
    }

    public function test_invalid_variant_returns_422(): void
    {
        $this->actingAsCustomer();

        $payload = $this->validPayload();
        $payload['items'][0]['variant'] = 'TIDAK ADA';

        $this->postJson('/orders', $payload)
            ->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_qris_image_is_returned(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload())
            ->assertOk()
            ->assertJsonStructure(['order' => ['qris_image', 'total', 'qris_fee']]);
    }

    public function test_whatsapp_payment_does_not_charge_qris_fee(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload(['payment_method' => 'wa']))
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('order.payment_method', 'wa');

        $order = Order::firstOrFail();
        $this->assertSame('wa', $order->payment_method);
        $this->assertSame(0, $order->qris_fee);
        $this->assertSame(21000, $order->total);
    }

    public function test_multiple_items_are_stored_in_one_order(): void
    {
        $this->actingAsCustomer();

        $payload = $this->validPayload();
        $payload['items'] = [
            [
                'group_id' => 'roti-sisir',
                'variant' => 'TIRAMISU CRUNCHY',
                'package' => null,
                'add_ons' => [],
                'quantity' => 2,
            ],
            [
                'group_id' => 'roti-unyil',
                'variant' => null,
                'package' => 'PAKET ISI 10 PCS',
                'add_ons' => [],
                'quantity' => 1,
            ],
        ];

        $this->postJson('/orders', $payload)->assertOk()
            ->assertJsonPath('order.subtotal', 58000);

        $order = Order::firstOrFail();
        $this->assertSame(58000, $order->subtotal);
        $this->assertSame(0, $order->qris_fee);
        $this->assertSame(58000, $order->total);
        $this->assertCount(2, $order->order_data);
    }

    public function test_invalid_phone_format_is_rejected(): void
    {
        $this->actingAsCustomer();

        $this->postJson('/orders', $this->validPayload(['customer_phone' => '0811']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('customer_phone');
    }

    public function test_order_response_contains_whatsapp_link_with_order_details(): void
    {
        $this->actingAsCustomer();

        $response = $this->postJson('/orders', $this->validPayload(['payment_method' => 'wa']))
            ->assertOk();

        $order = Order::firstOrFail();
        $waLink = rawurlencode(OrderHelper::customerOrderMessage($order));

        $response->assertJsonPath('order.wa_link', 'https://wa.me/628113996988?text='.$waLink);

        $link = $response->json('order.wa_link');
        $this->assertStringStartsWith('https://wa.me/628113996988?text=', $link);
        $this->assertStringContainsString(rawurlencode('TIRAMISU CRUNCHY x 1'), $link);
        $this->assertStringContainsString(rawurlencode('Total: Rp21.000'), $link);
    }
}
