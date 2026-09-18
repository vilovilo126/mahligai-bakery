<?php

/*
|--------------------------------------------------------------------------
| Identitas Bisnis Mahligai Bakery
|--------------------------------------------------------------------------
|
| Sumber data terpusat untuk informasi kontak dan identitas bisnis.
| Nomor WhatsApp hanya perlu diubah DI SINI jika berubah nanti.
|
*/

return [

    'name' => env('BUSINESS_NAME', 'Mahligai Bakery'),

    /*
    | Nomor WhatsApp dalam format internasional tanpa "+" atau "0".
    | Contoh: 08113996988 -> 628113996988
    */
    'whatsapp_number' => env('BUSINESS_WHATSAPP_NUMBER', '628113996988'),

    'whatsapp_display' => env('BUSINESS_WHATSAPP_DISPLAY', '0811-3996-988'),

    'address' => env('BUSINESS_ADDRESS', 'Renon, Denpasar Selatan, Bali'),

    'hours' => env('BUSINESS_HOURS', 'Setiap Hari · 07.00 – 22.00 WITA'),

    'price_range' => env('BUSINESS_PRICE_RANGE', 'Rp1.000 – Rp50.000 / orang'),

    'rating' => env('BUSINESS_RATING', 4.6),

    /*
    | Pesan otomatis (prefilled) saat pelanggan membuka WhatsApp.
    */
    'wa_order_message' => 'Halo Mahligai Bakery, saya ingin memesan produk bakery. Mohon informasi lebih lanjut mengenai ketersediaan dan pemesanannya.',
];
