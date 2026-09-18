<?php

namespace Tests\Unit;

use App\Services\Order\OrderCalculatorService;
use RuntimeException;
use Tests\TestCase;

class OrderCalculatorServiceTest extends TestCase
{
    public function test_it_calculates_variant_with_addon(): void
    {
        $result = app(OrderCalculatorService::class)->calculate([
            'items' => [
                [
                    'group_id' => 'roti-sisir',
                    'variant' => 'TIRAMISU CRUNCHY',
                    'package' => null,
                    'add_ons' => ['PITA, KARTU UCAPAN, & HANGTAG'],
                    'quantity' => 1,
                ],
            ],
        ]);

        $this->assertSame(14000, $result['subtotal']);
        $this->assertSame(7000, $result['add_ons_total']);
        $this->assertSame(0, $result['qris_fee']);
        $this->assertSame(21000, $result['total']);
    }

    public function test_it_calculates_package_price(): void
    {
        $result = app(OrderCalculatorService::class)->calculate([
            'items' => [
                [
                    'group_id' => 'roti-unyil',
                    'variant' => null,
                    'package' => 'PAKET ISI 25 PCS',
                    'add_ons' => ['KARTU UCAPAN', 'HAMPERS (PITA, KARTU UCAPAN, HANGTAG)'],
                    'quantity' => 1,
                ],
            ],
        ]);

        $this->assertSame(72500, $result['subtotal']);
        $this->assertSame(12000, $result['add_ons_total']);
        $this->assertSame(84500, $result['total']);
    }

    public function test_it_multiplies_quantity(): void
    {
        $result = app(OrderCalculatorService::class)->calculate([
            'items' => [
                [
                    'group_id' => 'aneka-roti',
                    'variant' => 'ROTI JAGUNG SUSU',
                    'package' => null,
                    'add_ons' => [],
                    'quantity' => 3,
                ],
            ],
        ]);

        $this->assertSame(30000, $result['subtotal']);
        $this->assertSame(0, $result['add_ons_total']);
        $this->assertSame(30000, $result['total']);
    }

    public function test_it_throws_when_variant_not_found(): void
    {
        $this->expectException(RuntimeException::class);

        app(OrderCalculatorService::class)->calculate([
            'items' => [
                [
                    'group_id' => 'roti-sisir',
                    'variant' => 'TIDAK ADA',
                    'package' => null,
                    'add_ons' => [],
                    'quantity' => 1,
                ],
            ],
        ]);
    }

    public function test_it_ignores_forced_low_price_from_frontend(): void
    {
        // Frontend mengirim harga rendah, backend harus menghitung ulang dari config.
        $result = app(OrderCalculatorService::class)->calculate([
            'items' => [
                [
                    'group_id' => 'roti-sisir',
                    'variant' => 'TIRAMISU CRUNCHY',
                    'package' => null,
                    'price' => 1,
                    'add_ons' => [],
                    'quantity' => 1,
                ],
            ],
        ]);

        $this->assertSame(14000, $result['subtotal']);
    }

    public function test_it_supports_multiple_items(): void
    {
        $result = app(OrderCalculatorService::class)->calculate([
            'items' => [
                ['group_id' => 'roti-sisir', 'variant' => 'BUTTER CREAM', 'package' => null, 'add_ons' => [], 'quantity' => 2],
                ['group_id' => 'roti-tawar', 'variant' => 'ROTI TAWAR', 'package' => null, 'add_ons' => [], 'quantity' => 1],
            ],
        ]);

        $this->assertSame(40000, $result['total']);
    }
}
