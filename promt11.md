# PERBAIKAN BESAR — DETAIL PESANAN ADMIN + STRUK + PRINT PREVIEW

Saya ingin memperbaiki halaman:

```text
/admin/orders/{id}
```

Saat ini halaman Detail Pesanan sudah berfungsi, tetapi layout masih terasa **panjang ke bawah di sisi kiri**, sehingga komposisinya tidak seimbang.

Selain itu, fitur **Cetak Struk** membuka Chrome Print Preview, tetapi hasil preview sebelumnya hampir kosong. Saya ingin kedua masalah ini diperbaiki sekaligus.

Gunakan desain yang profesional, modern, bersih, responsive, dan tetap mengikuti identitas Mahligai Bakery.

---

# BAGIAN A — PERBAIKI LAYOUT DETAIL PESANAN

## 1. MASALAH LAYOUT SAAT INI

Saat ini layout kira-kira seperti:

```text
┌──────────────────┬─────────────────────────────┐
│ Data Pelanggan   │ Rincian Pesanan             │
│                  │                             │
│                  │ Ringkasan Pembayaran        │
│                  │                             │
│ Perbarui Status  │                             │
│                  │                             │
│ Struk Pesanan    │                             │
│                  │                             │
│                  │                             │
│                  │                             │
└──────────────────┴─────────────────────────────┘
```

Masalahnya:

* kolom kiri terlalu panjang
* kolom kiri memiliki terlalu banyak section bertumpuk
* kolom kanan memiliki banyak ruang kosong
* halaman terasa berat sebelah
* struk berada terlalu jauh ke bawah
* informasi penting tidak terlihat dalam satu komposisi yang seimbang.

---

# 2. TARGET LAYOUT BARU

Buat layout lebih seimbang seperti konsep:

```text
┌──────────────────────────────────────────────────────────┐
│ ← Kembali ke Daftar       MB-0001 #1                    │
│                           Dibuat 22 Sep 2026, 02:11      │
│                                                          │
│ [Data Pelanggan]          [Rincian Pesanan]              │
│                           [Ringkasan Pembayaran]         │
│                                                          │
│ [Perbarui Status]         [Struk Pesanan / Cetak]        │
│                                                          │
└──────────────────────────────────────────────────────────┘

              [Preview Cetak Struk]
```

Gunakan CSS Grid responsive.

Contoh konsep:

```css
grid-template-columns: minmax(280px, 0.8fr) minmax(0, 1.7fr);
```

Tetapi sesuaikan dengan struktur existing agar hasilnya natural.

Jangan memaksakan angka tersebut jika tidak cocok.

---

# 3. DATA PELANGGAN

Card:

```text
DATA PELANGGAN
```

Tetap berisi:

* Nama
* Nomor WhatsApp
* Metode Pembayaran
* Akun Pelanggan
* Tanggal Pesan
* Jam Pesan
* Tgl Pengambilan
* Jam Pengambilan
* Request Bakery.

Tetapi buat lebih compact.

Gunakan layout dua kolom untuk data yang cocok:

```text
Tanggal Pesan      Jam Pesan
22 Sep 2026        02:11

Tgl Pengambilan    Jam Pengambilan
22 Sep 2026        14:30
```

Jangan membuat card terlalu tinggi.

---

# 4. REQUEST BAKERY

Tetap tampil di dalam Data Pelanggan.

Gunakan box yang compact:

```text
REQUEST BAKERY

Tolong saat pengambilan barang.
sudah siap bawaannya
```

Jangan membuat tinggi box berlebihan.

Jika teks panjang, gunakan wrapping normal.

---

# 5. PERBARUI STATUS

Card:

```text
PERBARUI STATUS
```

Tetap berisi:

```text
Status Pemesanan
[ Pesanan Dibuat ▼ ]

Status Pembayaran
[ Menunggu Pembayaran ▼ ]

[ Simpan Status ]
```

Buat lebih compact dan sejajar.

---

# 6. RINCIAN PESANAN

Card ini menjadi card utama di kolom kanan.

Tetap tampilkan:

```text
RINCIAN PESANAN

PAKET ISI 3 PCS ×1
ROTI UNYIL ANEKA RASA

Rp9.000

Additional:
REQUEST ROTI UNYIL DI PLASTIK (SATU PER SATU)

+ Rp15.000

Subtotal Additional: Rp15.000
```

Jika ada banyak produk:

* jangan membuat card terlalu tinggi
* gunakan spacing yang konsisten
* setiap produk tetap jelas
* quantity tetap terlihat
* harga tetap rata kanan.

---

# 7. RINGKASAN PEMBAYARAN

Card hijau tetap dipertahankan.

Tampilkan:

```text
RINGKASAN PEMBAYARAN

Subtotal                 Rp9.000
Biaya Additional         Rp15.000
Biaya QRIS               Rp0
───────────────────────────────
Total Pembayaran         Rp24.000
```

Total harus menjadi elemen paling menonjol.

Gunakan desain yang sama dengan identitas Mahligai Bakery.

---

# 8. STRUK PESANAN

Jangan lagi membuat section struk menjadi card panjang di kolom kiri.

Letakkan fitur struk di area yang lebih seimbang.

Contoh:

```text
┌───────────────────────────────────────────┐
│ STRUK PESANAN                             │
│                                           │
│ Klik "Cetak Struk" untuk mencetak        │
│ sebagai bukti pengambilan.                │
│                                           │
│              [ 🖨 Cetak Struk ]           │
│                                           │
│       ┌───────────────────────┐           │
│       │    Mahligai Bakery    │           │
│       │       MB-0001         │           │
│       │       #1              │           │
│       │       ...             │           │
│       └───────────────────────┘           │
└───────────────────────────────────────────┘
```

Jika ruang memungkinkan, letakkan mini preview struk di sebelah tombol.

Jangan membuat struk memanjang ke bawah tanpa alasan.

---

# 9. PREVIEW CETAK STRUK

Tambahkan section khusus setelah area detail utama:

```text
PREVIEW CETAK STRUK
Tampilan struk yang akan dicetak
```

Preview harus berada di tengah dan memiliki ukuran seperti struk.

Contoh:

```text
                  Preview Cetak Struk

             ┌─────────────────────┐
             │   Mahligai Bakery   │
             │ Renon, Denpasar...  │
             │                     │
             │ No. Pesanan MB-0001 │
             │ Nomor Urut      #1  │
             │ Nama       Ayu ...  │
             │ WhatsApp    087...  │
             │                     │
             │ RINCIAN PESANAN     │
             │                     │
             │ Total       Rp24.000│
             │                     │
             │ Request Bakery       │
             │                     │
             │ Terima kasih...     │
             └─────────────────────┘
```

Preview ini harus menggunakan **data order aktual**.

Jangan hardcode.

---

# 10. RESPONSIVE

Desktop:

```text
2 kolom utama
```

Tablet:

```text
2 kolom jika masih cukup
```

Mobile:

```text
1 kolom
```

Pastikan tidak ada horizontal overflow.

Jangan membuat sidebar atau card keluar layar.

---

# BAGIAN B — PERBAIKI CETAK STRUK

## 11. MASALAH PRINT PREVIEW

Saat ini ketika klik:

```text
Cetak Struk
```

Chrome Print Preview terbuka, tetapi hasil preview kosong/hampir kosong.

Padahal halaman normal sudah memiliki struk lengkap.

Perbaiki penyebab sebenarnya.

---

# 12. AUDIT IMPLEMENTASI PRINT

Cari tombol:

```text
Cetak Struk
```

Cari implementasinya.

Periksa apakah menggunakan:

```js
window.print()
```

atau route/view print khusus.

Cari juga:

```text
@media print
@page
print:hidden
print:block
display:none
visibility:hidden
```

Cari semua CSS dan JS yang berkaitan dengan print.

Jangan membuat solusi baru sebelum memahami implementasi existing.

---

# 13. GUNAKAN DATA ORDER AKTUAL

Jika admin membuka:

```text
/admin/orders/1
```

dan order tersebut:

```text
MB-0001
```

maka print harus:

```text
MB-0001
```

Jika membuka order lain:

```text
MB-0002
```

print harus:

```text
MB-0002
```

Tidak boleh menggunakan data dummy.

---

# 14. ISI STRUK YANG HARUS DICETAK

Print Preview harus menampilkan:

### Header

```text
Mahligai Bakery
Renon, Denpasar Selatan, Bali
Tanggal dan jam order
```

### Identitas order

```text
No. Pesanan
MB-0001

Nomor Urut
#1

Nama
Ayu Anjani

WhatsApp
087763211198

Pengambilan
22 Sep 2026 14:30
```

### Rincian

```text
RINCIAN PESANAN

PAKET ISI 3 PCS ×1
ROTI UNYIL ANEKA RASA
Rp9.000

+ REQUEST ROTI UNYIL DI PLASTIK
(SATU PER SATU)
+ Rp15.000
```

### Total

```text
Subtotal       Rp9.000
Additional     Rp15.000
Biaya QRIS     Rp0

TOTAL          Rp24.000
```

### Status

```text
Menunggu Pembayaran
Pesanan Dibuat
QRIS
```

### Request

```text
REQUEST BAKERY

Tolong saat pengambilan barang.
sudah siap bawaannya
```

### Footer

```text
Terima kasih telah memesan di Mahligai Bakery
```

Semua nilai harus berasal dari order aktual.

---

# 15. PRINT HANYA STRUK

Ketika print:

JANGAN tampilkan:

* sidebar admin
* navbar
* tombol
* chat
* WhatsApp button
* status editor
* menu admin
* background halaman
* card dashboard lainnya.

Yang tampil hanya struk.

Gunakan print CSS dengan pendekatan yang stabil.

Contoh konsep:

```css
@media print {
    .no-print {
        display: none !important;
    }

    .print-only,
    .print-receipt {
        display: block !important;
    }
}
```

Sesuaikan dengan struktur existing.

Jangan copy-paste CSS contoh secara mentah jika tidak sesuai project.

---

# 16. UKURAN STRUK

Buat struk terlihat seperti receipt, bukan satu halaman dashboard.

Gunakan:

* width yang proporsional
* typography jelas
* spacing compact
* border/dashed divider yang halus
* total lebih menonjol
* tidak terlalu banyak whitespace.

Struk harus tetap bagus ketika dicetak ke PDF/printer.

---

# 17. PRINT PREVIEW HARUS SAMA DENGAN PREVIEW DI HALAMAN

Prinsip utama:

```text
Data Order
     ↓
Receipt Component
     ├── Preview di halaman
     └── Print
```

Jangan membuat dua sumber data berbeda.

Jika memungkinkan, gunakan satu partial/component Blade untuk receipt.

Contoh konsep:

```text
resources/views/components/
    order-receipt.blade.php
```

kemudian gunakan component tersebut untuk:

```text
Preview
+
Print
```

Tetapi sebelum membuat file baru, periksa apakah project sudah memiliki component/partial receipt.

Jika sudah ada, gunakan yang existing.

---

# 18. TAMPILAN DETAIL PESANAN

Saya ingin hasil akhirnya terasa seperti dashboard admin profesional.

Gunakan:

* cream background
* white cards
* green Mahligai Bakery
* rounded corners
* spacing konsisten
* typography jelas
* shadow ringan
* tidak terlalu banyak dekorasi.

Jangan menggunakan gradient berlebihan.

Jangan membuat halaman terlalu panjang jika informasi bisa dibuat lebih compact.

---

# 19. JANGAN MERUSAK FITUR EXISTING

Pertahankan:

* order detail
* customer information
* status order
* status payment
* save status
* chat pelanggan
* WhatsApp
* receipt
* print
* navigation kembali
* order number
* queue number
* payment data
* additional
* request bakery.

Jangan mengubah database jika tidak diperlukan.

Jangan membuat migration hanya untuk perubahan UI/print.

---

# 20. DATA DAN FORMAT

Gunakan format existing project.

Jangan mengubah:

```text
MB-0001
#1
Rp9.000
Rp15.000
Rp24.000
```

menjadi format lain jika formatter existing sudah benar.

Gunakan helper/formatter existing jika tersedia.

---

# 21. TEST PRINT MULTIPLE ORDER

Test minimal:

```text
Order 1 → MB-0001
Order 2 → order berikutnya
```

Pastikan data print mengikuti order yang sedang dibuka.

---

# 22. TEST RESPONSIVE

Test:

### Desktop

* layout seimbang
* tidak panjang sebelah kiri
* struk mudah ditemukan

### Tablet

* tidak overflow

### Mobile

* berubah menjadi satu kolom
* semua card masih nyaman dibaca
* tombol Cetak Struk tetap mudah ditekan
* preview struk tidak keluar layar.

---

# 23. TEST

Setelah implementasi:

```bash
php artisan test --compact
```

```bash
vendor/bin/pint --format agent
```

```bash
npm run build
```

Semua harus berhasil.

---

# 24. MANUAL TEST WAJIB

Setelah Build:

1. Buka detail order.
2. Pastikan layout sudah tidak panjang sebelah kiri.
3. Pastikan Data Pelanggan compact.
4. Pastikan Perbarui Status tetap bekerja.
5. Pastikan Rincian Pesanan benar.
6. Pastikan Ringkasan Pembayaran benar.
7. Pastikan Preview Cetak Struk muncul dengan data yang benar.
8. Klik Cetak Struk.
9. Pastikan Chrome Print Preview terbuka.
10. Pastikan preview print **sudah terisi dengan struk**.
11. Pastikan bukan halaman putih kosong.
12. Cancel print.
13. Buka order lain.
14. Klik Cetak Struk.
15. Pastikan data berubah sesuai order tersebut.

---

# HASIL AKHIR YANG DIINGINKAN

Halaman Detail Pesanan harus terlihat seperti dashboard yang seimbang:

```text
┌─────────────────────────────────────────────────────────┐
│ ← Kembali     MB-0001 #1                                │
│               Dibuat 22 Sep 2026, 02:11                 │
│                                                         │
│ ┌────────────────┐  ┌────────────────────────────────┐ │
│ │ DATA PELANGGAN │  │ RINCIAN PESANAN                 │ │
│ │                │  │                                │ │
│ │ Nama           │  │ Produk                         │ │
│ │ WhatsApp       │  │ Additional                     │ │
│ │ Pembayaran     │  │ Subtotal                       │ │
│ │ Pengambilan    │  │                                │ │
│ │ Request        │  ├────────────────────────────────┤ │
│ └────────────────┘  │ RINGKASAN PEMBAYARAN           │ │
│                     │ TOTAL Rp24.000                 │ │
│ ┌────────────────┐  └────────────────────────────────┘ │
│ │ PERBARUI       │                                     │
│ │ STATUS         │  ┌────────────────────────────────┐ │
│ │                │  │ STRUK PESANAN                  │ │
│ │ [Status]       │  │ [Cetak Struk]   [Mini Preview]│ │
│ │ [Status]       │  └────────────────────────────────┘ │
│ │ [Simpan]       │                                     │
│ └────────────────┘                                     │
└─────────────────────────────────────────────────────────┘

              PREVIEW CETAK STRUK

                  ┌──────────────┐
                  │ Mahligai     │
                  │ Bakery       │
                  │              │
                  │ MB-0001      │
                  │ #1           │
                  │ Ayu Anjani   │
                  │ ...          │
                  │              │
                  │ TOTAL        │
                  │ Rp24.000     │
                  └──────────────┘
```

Dan ketika:

```text
Cetak Struk
```

diklik:

```text
Chrome Print Preview
        ↓
STRUK SUDAH TERISI
        ↓
DATA ORDER AKTUAL
```

Bukan halaman putih kosong.

# ATURAN PENTING

Sebelum melakukan perubahan, **audit file dan implementasi existing terlebih dahulu**.

Jangan menghapus fitur yang sudah bekerja.

Jangan mengubah database jika tidak diperlukan.

Jangan membuat data dummy.

Jangan membuat sistem print kedua jika sistem existing bisa diperbaiki.

Prioritaskan reuse component/partial receipt existing.

Setelah audit, berikan ringkasan file yang akan diubah dan alasan perubahannya sebelum Build.
