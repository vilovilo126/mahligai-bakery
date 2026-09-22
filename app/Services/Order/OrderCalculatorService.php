<?php

namespace App\Services\Order;

use Illuminate\Support\Arr;
use RuntimeException;

/**
 * Menghitung ulang seluruh harga pesanan berdasarkan data di config/menu.php.
 *
 * Backend TIDAK pernah mempercayai total/harga yang dikirim dari frontend.
 * Harga produk, paket, additional, dan biaya QRIS selalu diambil ulang dari
 * config sehingga manipulasi harga dari browser tidak mungkin dilakukan.
 */
class OrderCalculatorService
{
    /**
     * @param  array<string, mixed>  $payload  struktur order yang dikirim frontend
     * @return array<string, mixed> hasil kalkulasi yang aman untuk disimpan
     */
    public function calculate(array $payload): array
    {
        $groups = config('menu.groups', []);
        $items = Arr::get($payload, 'items', []);

        $paymentMethod = Arr::get($payload, 'payment_method', 'qris');

        $validatedItems = [];
        $subtotal = 0;
        $addOnsTotal = 0;
        $qrisFee = 0;

        foreach ($items as $item) {
            $resolved = $this->resolveItem($item, $groups);

            $validatedItems[] = $resolved['item'];
            $subtotal += $resolved['subtotal'];
            $addOnsTotal += $resolved['add_ons_total'];
            $qrisFee += $resolved['qris_fee'];
        }

        // Biaya QRIS hanya berlaku untuk pembayaran QRIS.
        // Pembayaran WhatsApp tidak dikenakan biaya QRIS.
        if ($paymentMethod === 'wa') {
            $qrisFee = 0;

            $validatedItems = collect($validatedItems)->map(function ($item) {
                $item['qris_fee'] = 0;

                return $item;
            })->all();
        }

        $total = $subtotal + $addOnsTotal + $qrisFee;

        return [
            'items' => $validatedItems,
            'subtotal' => $subtotal,
            'add_ons_total' => $addOnsTotal,
            'qris_fee' => $qrisFee,
            'total' => $total,
        ];
    }

    /**
     * Menyelesaikan satu item order menjadi data yang tervalidasi.
     *
     * @param  array<string, mixed>  $item
     * @param  array<int, array<string, mixed>>  $groups
     * @return array<string, mixed>
     */
    private function resolveItem(array $item, array $groups): array
    {
        $quantity = max(1, (int) Arr::get($item, 'quantity', 1));
        $group = $this->findGroup(Arr::get($item, 'group_id'), $groups);

        $variantName = Arr::get($item, 'variant');
        $packageName = Arr::get($item, 'package');
        $addOnNames = (array) Arr::get($item, 'add_ons', []);

        // Satu item hanya boleh memilih varian ATAU paket (bukan keduanya)
        if (! $variantName && ! $packageName) {
            throw new RuntimeException('Setiap item harus memiliki varian atau paket.');
        }

        $variant = $variantName ? $this->findVariant($variantName, $group) : null;
        $package = $packageName ? $this->findPackage($packageName, $group) : null;

        $basePrice = 0;
        $qrisFeePerUnit = 0;

        if ($package) {
            $basePrice = (int) $package['price'];
            $qrisFeePerUnit = (int) ($package['qris_fee'] ?? 0);
        } elseif ($variant) {
            $basePrice = (int) $variant['price'];
            $qrisFeePerUnit = (int) ($variant['qris_fee'] ?? 0);
        }

        $lineTotal = $basePrice * $quantity;
        $qrisLine = $qrisFeePerUnit * $quantity;

        // Validasi additional terhadap daftar add_ons pada grup.
        $addOnsAvailable = $group['add_ons'] ?? [];
        $resolvedAddOns = [];
        $addOnsLineTotal = 0;

        foreach ($addOnNames as $addOnName) {
            $addOn = $this->findAddOn($addOnName, $addOnsAvailable);
            if (! $addOn) {
                continue;
            }

            $resolvedAddOns[] = [
                'name' => $addOn['name'],
                'price' => (int) $addOn['price'],
                'note' => $addOn['note'] ?? null,
            ];

            $addOnsLineTotal += (int) $addOn['price'];
        }

        return [
            'item' => [
                'group_id' => $group['id'],
                'group_title' => $group['title'],
                'variant' => $variant['name'] ?? null,
                'package' => $package['name'] ?? null,
                'quantity' => $quantity,
                'price' => $basePrice,
                'qris_fee' => $qrisLine,
                'subtotal' => $lineTotal,
                'add_ons' => $resolvedAddOns,
                'add_ons_total' => $addOnsLineTotal,
            ],
            'subtotal' => $lineTotal,
            'add_ons_total' => $addOnsLineTotal,
            'qris_fee' => $qrisLine,
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $groups
     * @return array<string, mixed>
     */
    private function findGroup(?string $groupId, array $groups): array
    {
        foreach ($groups as $group) {
            if (($group['id'] ?? null) === $groupId) {
                return $group;
            }
        }

        throw new RuntimeException("Grup menu '{$groupId}' tidak ditemukan.");
    }

    /**
     * @param  array<string, mixed>  $group
     * @return array<string, mixed>
     */
    private function findVariant(string $name, array $group): array
    {
        foreach ($group['variants'] ?? [] as $variant) {
            if (strcasecmp($variant['name'], $name) === 0) {
                return $variant;
            }
        }

        // Roti Sisir menyimpan varian dalam variant_groups[].items
        foreach ($group['variant_groups'] ?? [] as $variantGroup) {
            foreach ($variantGroup['items'] ?? [] as $variant) {
                if (strcasecmp($variant['name'], $name) === 0) {
                    return $variant;
                }
            }
        }

        throw new RuntimeException("Varian '{$name}' tidak ditemukan.");
    }

    /**
     * @param  array<string, mixed>  $group
     * @return array<string, mixed>
     */
    private function findPackage(string $name, array $group): array
    {
        foreach ($group['packages'] ?? [] as $package) {
            if (strcasecmp($package['name'], $name) === 0) {
                return $package;
            }
        }

        throw new RuntimeException("Paket '{$name}' tidak ditemukan.");
    }

    /**
     * @param  array<int, array<string, mixed>>  $addOns
     * @return array<string, mixed>|null
     */
    private function findAddOn(string $name, array $addOns): ?array
    {
        foreach ($addOns as $addOn) {
            if (strcasecmp($addOn['name'], $name) === 0) {
                return $addOn;
            }
        }

        return null;
    }
}
