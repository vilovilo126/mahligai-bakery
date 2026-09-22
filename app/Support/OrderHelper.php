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

    /**
     * Buat pesan otomatis dari pelanggan yang memuat ringkasan pesanan.
     *
     * Pesan dibangun dari snapshot order tersimpan, sehingga isinya selalu
     * sesuai dengan data yang benar di database.
     */
    public static function customerOrderMessage(Order $order): string
    {
        $lines = [];

        foreach ($order->order_data ?? [] as $item) {
            $label = trim(($item['variant'] ?? '').' '.($item['package'] ?? ''));

            if (empty($label)) {
                continue;
            }

            $line = '- '.$label.' x '.$item['quantity'].' = Rp'.number_format($item['subtotal'], 0, ',', '.');

            if (! empty($item['add_ons'])) {
                $addOns = collect($item['add_ons'])
                    ->map(fn ($addOn) => '+ '.$addOn['name'].' Rp'.number_format($addOn['price'], 0, ',', '.'))
                    ->join("\n");

                $line .= "\n".$addOns;
            }

            $lines[] = $line;
        }

        $paymentLabel = $order->payment_method === 'qris' ? 'QRIS' : 'WhatsApp';

        $pickup = $order->pickup_label;

        $message = "Halo Mahligai Bakery,\n\n"
            ."Saya ingin melakukan pemesanan.\n\n"
            .'Nomor Urut: #'.$order->queue_number."\n"
            .'Nomor Pesanan: '.$order->order_number."\n\n"
            ."Nama:\n".$order->customer_name."\n\n"
            ."Nomor WhatsApp:\n".$order->customer_phone."\n\n"
            ."Pesanan:\n".implode("\n", $lines)."\n\n"
            .'Subtotal: Rp'.number_format($order->subtotal, 0, ',', '.')."\n"
            .'Metode Pembayaran: '.$paymentLabel."\n"
            .'Biaya QRIS: Rp'.number_format($order->qris_fee, 0, ',', '.')."\n"
            .'Total: Rp'.number_format($order->total, 0, ',', '.')."\n"
            .'Pengambilan: '.($pickup ?: '-')."\n"
            .'Request Bakery: '.($order->bakery_request ?: '-')."\n\n"
            .'Terima kasih.';

        return $message;
    }

    /**
     * Link WhatsApp Mahligai Bakery dengan pesan pemesanan otomatis.
     */
    public static function waOrderLink(Order $order): string
    {
        return self::waLink(config('business.whatsapp_number'), self::customerOrderMessage($order));
    }

    /**
     * Link WhatsApp ke Mahligai Bakery dengan referensi nomor pesanan tertentu.
     */
    public static function customerChatWhatsAppLink(Order $order): string
    {
        $message = 'Halo Mahligai Bakery, saya ingin bertanya mengenai pesanan '.$order->order_number;

        return self::waLink(config('business.whatsapp_number'), $message);
    }

    /**
     * Nomor urut global berikutnya untuk order baru.
     */
    public static function nextQueueNumber(): int
    {
        return (int) Order::max('queue_number') + 1;
    }
}
