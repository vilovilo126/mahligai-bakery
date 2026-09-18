<?php

namespace App\Support;

use App\Models\Order;

class OrderHelper
{
    /**
     * Normalisasi nomor WhatsApp ke format internasional tanpa "+", spasi,
     * atau strip. Contoh "0811-3996-988" -> "628113996988".
     */
    public static function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone);

        // Ganti awalan "0" dengan "62"
        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        // Jika sudah diawali "62", biarkan; selain itu tambahkan "62"
        elseif (! str_starts_with($digits, '62')) {
            $digits = '62'.$digits;
        }

        return $digits;
    }

    /**
     * Bangun link WhatsApp ke suatu nomor dengan pesan otomatis.
     *
     * @param  string  $phone  nomor pelanggan/bisnis dalam format apa pun
     * @param  string|null  $message  pesan otomatis (prefilled)
     */
    public static function waLink(string $phone, ?string $message = null): string
    {
        $url = 'https://wa.me/'.self::normalizePhone($phone);

        if ($message) {
            $url .= '?text='.rawurlencode($message);
        }

        return $url;
    }

    /**
     * Buat pesan otomatis ringkasan pesanan untuk admin.
     */
    public static function adminOrderMessage(Order $order): string
    {
        $summary = collect($order->order_data ?? [])
            ->map(fn ($item) => trim(($item['variant'] ?? '').' '.($item['package'] ?? '')).' x'.($item['quantity'] ?? 1))
            ->filter()
            ->join(', ');

        return sprintf(
            'Halo Kak, kami dari Mahligai Bakery. Kami ingin mengonfirmasi pesanan Kakak: %s. Total Rp%s. Terima kasih.',
            $summary,
            number_format($order->total, 0, ',', '.'),
        );
    }
}
