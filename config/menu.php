<?php

/*
|--------------------------------------------------------------------------
| Menu Katalog Mahligai Bakery
|--------------------------------------------------------------------------
|
| Sumber data tunggal untuk katalog menu. Struktur data dibuat agar mudah
| diubah: nama produk, varian, harga, paket, additional, dan gambar (path)
| cukup diedit di file ini tanpa mengubah struktur komponen.
|
| Setiap harga disimpan sebagai integer Rupiah tanpa pemisah. Gunakan flag
| `per_pcs` untuk menampilkan keterangan "PER PCS", dan `note` untuk
| keterangan tambahan pada varian/paket.
|
| Field `qris_fee` (integer, default 0) menyimpan biaya QRIS untuk masing-
| masing varian/paket/additional. Isi dengan nominal yang diinginkan;
| biarkan 0 jika tidak ada biaya QRIS atau belum ditentukan.
|
*/

return [

    'groups' => [

        /*
        | Roti Unyil — produk tanpa foto.
        | Dirancang berbasis typography, icon, badge, dan elemen dekoratif.
        */
        [
            'id' => 'roti-unyil',
            'title' => 'ROTI UNYIL ANEKA RASA',
            'nav' => 'Roti Unyil',
            'eyebrow' => 'Bite-Size Favorit',
            'description' => 'Roti unyil yang mungil dengan beragam pilihan topping dan isian. Cocok untuk acara keluarga dan disukai anak-anak.',
            'has_image' => false,
            'image' => null,
            'image_thumb' => null,

            'variants' => [
                ['name' => 'Smoked Beef Cheese', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Cheese Scroll', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Abon Ayam', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Banana Custard', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Blueberry', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Choco Crispy Ball', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Chocolate Custard', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Butter Meses Cokelat', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Tiramisu', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Red Bean', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Coffee Bun', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Mini Pizza (Chicken)', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Sosis Ayam', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Velvet Cokelat Filling', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Sosis Ayam Keju', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Pandan Srikaya', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Rainbow Butter Meses', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Pisang Keju', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Cinnamon Roll', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Strawberry', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Keju Parut', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Cokelat', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Cokelat Keju', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Oreo Custard', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Pisang Cokelat', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'Selai Nanas', 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
            ],

            'packages_heading' => 'PAKET ROTI UNYIL',
            'packages_description' => 'Seperti namanya, roti ini memiliki ukuran yang lebih kecil dengan variasi topping yang cocok untuk acara keluarga dan disukai oleh anak-anak karena bentuknya yang mungil. Dikemas dalam beberapa paket sesuai dengan jumlah Roti Unyil dalam satu box.',

            'packages' => [
                ['name' => 'PAKET ISI 3 PCS', 'price' => 9000, 'note' => 'Khusus paket ini menggunakan kemasan plastik', 'qris_fee' => 0],
                ['name' => 'PAKET ISI 10 PCS', 'price' => 30000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PAKET ISI 15 PCS', 'price' => 44500, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PAKET ISI 18 PCS', 'price' => 52500, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PAKET ISI 25 PCS', 'price' => 72500, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PAKET ISI 30 PCS', 'price' => 87000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PAKET ISI 50 PCS', 'price' => 143000, 'note' => 'Khusus paket ini menggunakan 2 box unyil 25pcs', 'qris_fee' => 0],
            ],

            'package_note' => 'KEMASAN MENGGUNAKAN BOX (KECUALI PAKET ISI 3 MENGGUNAKAN PLASTIK)',

            'add_ons' => [
                ['name' => 'KARTU UCAPAN', 'price' => 5000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'HAMPERS (PITA, KARTU UCAPAN, HANGTAG)', 'price' => 7000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PAPER BAG (UNYIL 10,15,18PCS)', 'price' => 6000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'TAS SPUNBOND (25,30,50PCS)', 'price' => 7000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'REQUEST ROTI UNYIL DI PLASTIK (SATU PER SATU)', 'price' => 15000, 'note' => '/ BOX', 'qris_fee' => 0],
            ],
        ],

        /*
        | Roti Sisir — MAHLIGAI'S BEST SELLER.
        */
        [
            'id' => 'roti-sisir',
            'title' => 'ROTI SISIR',
            'nav' => 'Roti Sisir',
            'eyebrow' => 'Best Seller',
            'badge' => "MAHLIGAI'S BEST SELLER",
            'description' => 'Roti Sisir bertekstur lembut dengan aroma butter premium, berisi aneka selai yang akan memanjakan lidah. Semua varian selai tentu saja tidak jauh dengan cita rasa yang ada di Indonesia.',
            'has_image' => false,
            'image' => null,
            'image_thumb' => null,

            'variant_groups' => [
                [
                    'label' => 'VARIAN KLASIK',
                    'items' => [
                        ['name' => 'BUTTER CREAM', 'price' => 12000, 'per_pcs' => false, 'qris_fee' => 0],
                        ['name' => 'KEJU SUSU', 'price' => 12000, 'per_pcs' => false, 'qris_fee' => 0],
                        ['name' => 'BUTTER MESES', 'price' => 12000, 'per_pcs' => false, 'qris_fee' => 0],
                        ['name' => 'MOCCA NOUGAT', 'price' => 12000, 'per_pcs' => false, 'qris_fee' => 0],
                        ['name' => 'MESES MOCCA', 'price' => 12000, 'per_pcs' => false, 'qris_fee' => 0],
                    ],
                ],
                [
                    'label' => 'VARIAN PREMIUM',
                    'items' => [
                        ['name' => 'TIRAMISU CRUNCHY', 'price' => 14000, 'per_pcs' => false, 'qris_fee' => 0],
                        ['name' => 'SELAI NANAS', 'price' => 14000, 'per_pcs' => false, 'qris_fee' => 0],
                        ['name' => 'PEANUT BUTTER', 'price' => 14000, 'per_pcs' => true, 'qris_fee' => 0],
                        ['name' => 'CHOCO CRUNCHY', 'price' => 14000, 'per_pcs' => true, 'qris_fee' => 0],
                        ['name' => 'NUTELLA', 'price' => 14000, 'per_pcs' => true, 'qris_fee' => 0],
                        ['name' => 'GREEN TEA CRUNCHY', 'price' => 14000, 'per_pcs' => true, 'qris_fee' => 0],
                        ['name' => 'COKELAT KEJU', 'price' => 14000, 'per_pcs' => true, 'qris_fee' => 0],
                        ['name' => 'COKELAT KACANG', 'price' => 14000, 'per_pcs' => true, 'qris_fee' => 0],
                    ],
                ],
                [
                    'label' => 'VARIAN SAVOURY',
                    'items' => [
                        ['name' => 'ABON AYAM', 'price' => 17000, 'per_pcs' => false, 'qris_fee' => 0],
                        ['name' => 'SMOKED BEEF CHEESE', 'price' => 17000, 'per_pcs' => true, 'qris_fee' => 0],
                    ],
                ],
            ],

            'packages_heading' => 'PAKET ROTI SISIR',
            'packages_description' => null,

            'packages' => [
                ['name' => 'ROTI SISIR KLASIK', 'price' => 58000, 'note' => 'Isi 5 pcs', 'qris_fee' => 0],
                ['name' => 'ROTI SISIR PREMIUM', 'price' => 68000, 'note' => 'Isi 5 pcs', 'qris_fee' => 0],
                ['name' => 'ROTI SISIR KLASIK + PREMIUM', 'price' => 62000, 'note' => 'Isi 3 pcs varian klasik dan 2 pcs varian premium', 'qris_fee' => 0],
                ['name' => 'ROTI SISIR PREMIUM + SAVOURY', 'price' => 74000, 'note' => 'Isi 3 pcs varian premium dan 2 pcs varian savoury', 'qris_fee' => 0],
            ],

            'package_note' => 'ROTI SISIR AKAN DIKEMAS KE DALAM PLASTIK SATU PER SATU DAN ADA PAKET SESUAI DENGAN JUMLAHNYA. KEMASAN MENGGUNAKAN POUCHBAG.',

            'add_ons' => [
                ['name' => 'BOX ISI 5 PCS + PAPER BAG (M)', 'price' => 10000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'BOX ISI 10 PCS (PILIH 2 PAKET ROTI SISIR) + PAPER BAG', 'price' => 12000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PITA, KARTU UCAPAN, & HANGTAG', 'price' => 7000, 'note' => null, 'qris_fee' => 0],
            ],
        ],

        /*
        | Aneka Roti (Regular Bread).
        */
        [
            'id' => 'aneka-roti',
            'title' => 'ANEKA ROTI (REGULAR BREAD)',
            'nav' => 'Aneka Roti',
            'eyebrow' => 'Regular Bread',
            'description' => 'Koleksi roti regular dengan berbagai isian dan topping khas Nusantara, dibuat segar setiap hari. Ganti path gambar berikut dengan foto produk asli Anda.',
            'has_image' => true,
            'image' => 'images/products/placeholder.svg',
            'image_thumb' => 'images/products/placeholder.svg',

            'variants' => [
                ['name' => 'ROTI JAGUNG SUSU', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'ROTI KISMIS', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'POLO BUN', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'COFFEE BUN', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'RED BEAN', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'ROTI PISANG COKELAT', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'ROTI CHEESE RING', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'ROTI PANDAN SRIKAYA', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'ROTI COKELAT KEJU', 'price' => 10000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PIZZA BREAD (CHICKEN)', 'price' => 13000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'ROTI SMOKED BEEF CHEESE', 'price' => 15000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'ROTI SMOKED CHICKEN CHEESE', 'price' => 15000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'CHICKEN MAYO SANDWICH', 'price' => 15000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
                ['name' => 'EGG MAYO SANDWICH', 'price' => 15000, 'per_pcs' => true, 'note' => null, 'qris_fee' => 0],
            ],

            'packages_heading' => null,
            'packages_description' => null,
            'packages' => [],
            'package_note' => null,

            'add_ons' => [
                ['name' => 'BOX UKURAN S', 'price' => 3000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'BOX UKURAN M', 'price' => 5000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'BOX UKURAN L', 'price' => 8000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'BOX UKURAN XL', 'price' => 10000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PAPER BAG UKURAN M', 'price' => 5000, 'note' => null, 'qris_fee' => 0],
                ['name' => 'PAPER BAG UKURAN L', 'price' => 6000, 'note' => null, 'qris_fee' => 0],
            ],
        ],

        /*
        | Aneka Roti — Roti Tawar & lainnya. Dipisahkan visual dari Regular Bread.
        */
        [
            'id' => 'roti-tawar',
            'title' => 'ANEKA ROTI',
            'nav' => 'Roti Tawar',
            'eyebrow' => 'Roti Tawar & Lainnya',
            'description' => 'Roti tawar dan roti sobek lezat, potong rapi dan siap disajikan. Ganti path gambar berikut dengan foto produk asli Anda.',
            'has_image' => true,
            'image' => 'images/products/placeholder.svg',
            'image_thumb' => 'images/products/placeholder.svg',

            'variants' => [
                ['name' => 'ROTI TAWAR', 'price' => 16000, 'per_pcs' => false, 'note' => 'For 10 slices', 'qris_fee' => 0],
                ['name' => 'ROTI SISIR PLAIN', 'price' => 25000, 'per_pcs' => false, 'note' => 'For 14 slices', 'qris_fee' => 0],
                ['name' => 'ROTI GANDUM', 'price' => 20000, 'per_pcs' => false, 'note' => 'For 10 slices', 'qris_fee' => 0],
                ['name' => 'ROTI MULTIGRAIN', 'price' => 25000, 'per_pcs' => false, 'note' => 'For 10 slices', 'qris_fee' => 0],
                ['name' => 'ROTI SOBEK COKELAT', 'price' => 25000, 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
                ['name' => 'ROTI SOBEK PANDAN', 'price' => 25000, 'per_pcs' => false, 'note' => null, 'qris_fee' => 0],
            ],

            'packages_heading' => null,
            'packages_description' => null,
            'packages' => [],
            'package_note' => null,
            'add_ons' => [],
        ],
    ],
];
