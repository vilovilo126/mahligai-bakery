<?php

namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '08113996988',
            'payment_method' => 'qris',
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

    public function test_order_can_be_created_without_login(): void
    {
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

    public function test_additional_is_stored_in_order_data(): void
    {
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
        $this->postJson('/orders', $this->validPayload(['customer_name' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('customer_name');
    }

    public function test_phone_is_required(): void
    {
        $this->postJson('/orders', $this->validPayload(['customer_phone' => '']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('customer_phone');
    }

    public function test_items_are_required(): void
    {
        $this->postJson('/orders', $this->validPayload(['items' => []]))
            ->assertStatus(422)
            ->assertJsonValidationErrors('items');
    }

    public function test_manipulated_price_is_recomputed_by_backend(): void
    {
        // Frontend berusaha menipu dengan harga sangat murah.
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
        $payload = $this->validPayload();
        $payload['items'][0]['variant'] = 'TIDAK ADA';

        $this->postJson('/orders', $payload)
            ->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_qris_image_is_returned_without_login(): void
    {
        $this->postJson('/orders', $this->validPayload())
            ->assertOk()
            ->assertJsonStructure(['order' => ['qris_image', 'total', 'qris_fee']]);
    }
}
