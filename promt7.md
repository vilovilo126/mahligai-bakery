# PERUBAHAN ALUR LANDING PAGE, LOGIN CUSTOMER & ADMIN MAHLIGAI BAKERY

Saya ingin melanjutkan pengembangan project Laravel Mahligai Bakery yang sudah ada.

Saya ingin mengubah alur awal website agar pengguna pertama kali tidak langsung masuk ke halaman menu bakery, tetapi terlebih dahulu melihat halaman landing/login yang memungkinkan pengguna memilih apakah mereka masuk sebagai:

1. Pelanggan
2. Admin Mahligai Bakery

PENTING:

* Audit project terlebih dahulu sebelum mengubah kode.
* Jangan menghapus fitur existing.
* Jangan membuat sistem order baru jika sistem order sudah tersedia.
* Jangan membuat model/controller/migration duplicate.
* Gunakan authentication/session yang sudah ada jika sudah tersedia.
* Pertahankan katalog produk, cart, checkout, QRIS, WhatsApp, struk, dan sistem order yang sudah dibuat.
* Pertahankan desain hijau/cream khas Mahligai Bakery.
* Semua halaman harus responsive.

==================================================

1. LANDING PAGE PERTAMA
   ==================================================

Saya ingin halaman pertama website menjadi halaman penyambutan/login Mahligai Bakery.

Desain harus tetap mengambil inspirasi dari landing page yang sekarang:

* warna hijau Mahligai Bakery
* cream
* premium bakery
* clean
* modern
* elegant
* responsive
* animasi smooth
* tidak terlalu ramai.

Buat halaman:

"Selamat Datang di Mahligai Bakery"

Dengan teks pendukung seperti:

"Nikmati berbagai pilihan roti dan produk bakery Mahligai Bakery."

Kemudian tampilkan dua pilihan utama:

---

## PELANGGAN

"Masuk sebagai Pelanggan"

Keterangan:
"Pesan produk, lakukan pembayaran, dan pantau pesanan Anda."

Button:
"Masuk sebagai Pelanggan"

---

## ADMIN

"Masuk sebagai Admin"

Keterangan:
"Kelola pesanan dan data pelanggan Mahligai Bakery."

Button:
"Masuk sebagai Admin"

---

Gunakan card/button yang terlihat profesional.

Tambahkan animasi masuk yang halus.

Gunakan Framer Motion/motion atau sistem animasi existing jika tersedia.

Jangan membuat animasi terlalu berlebihan.

==================================================
2. LOGIN PELANGGAN
==================

Ketika user memilih:

"Masuk sebagai Pelanggan"

arahkah ke halaman login pelanggan.

Customer cukup memasukkan:

* Nama pelanggan

Tidak perlu password untuk customer pada tahap ini.

Tampilkan:

"Selamat Datang"

"Masukkan nama Anda untuk mulai memesan di Mahligai Bakery."

Field:

Nama Lengkap

Button:

"Masuk ke Menu"

Setelah berhasil:

customer diarahkan ke website/menu bakery yang sekarang sudah ada.

Customer harus dapat melihat:

* Beranda
* Tentang Kami
* Produk
* Galeri
* Lokasi
* Kontak
* Menu bakery
* Keranjang
* Pembayaran
* Pesanan Saya
* Chat Admin
* WhatsApp.

Nama customer yang login harus tersimpan pada session customer.

Nama tersebut digunakan ketika membuat order.

Contoh:

Nama:
Viola

Maka ketika checkout:

Nama Lengkap:
Viola

Tidak perlu meminta nama lagi jika sudah tersedia dari session, tetapi tetap izinkan customer mengubahnya jika desain existing membutuhkan.

==================================================
3. ALUR CUSTOMER
================

Setelah customer login:

LOGIN PELANGGAN
↓
LANDING / WEBSITE BAKERY
↓
MENU PRODUK
↓
PILIH PRODUK
↓
TAMBAH KE KERANJANG
↓
CHECKOUT
↓
DATA DIRI
↓
TANGGAL PENGAMBILAN
↓
JAM PENGAMBILAN
↓
REQUEST BAKERY
↓
PILIH QRIS / WHATSAPP
↓
KONFIRMASI PESANAN
↓
ANIMASI PESANAN BERHASIL
↓
STRUK
↓
PESANAN SAYA

Pertahankan sistem checkout yang sudah ada.

Jangan membuat checkout baru yang duplicate.

==================================================
4. LOGIN ADMIN
==============

Jika user memilih:

"Masuk sebagai Admin"

arahkah ke halaman login admin.

Gunakan credential admin yang sudah ditentukan sebelumnya:

Username:
admin

Password:
bakery mahligai

PENTING:

* password harus disimpan menggunakan hashing Laravel.
* jangan menyimpan password plaintext di database.
* jangan hardcode credential di JavaScript/frontend.
* gunakan sistem User/role/auth existing jika tersedia.
* jangan membuat authentication duplicate jika sudah ada.

Setelah admin berhasil login:

arahkah ke:

/admin

atau route admin existing yang paling sesuai.

==================================================
5. ADMIN DASHBOARD
==================

Admin dashboard menjadi pusat pengelolaan Mahligai Bakery.

Tampilkan dashboard profesional.

Bagian atas menampilkan statistik:

---

TOTAL PESANAN
jumlah seluruh order

---

TOTAL PELANGGAN
jumlah customer yang sudah melakukan order

---

PESANAN HARI INI
jumlah order hari ini

---

MENUNGGU PEMBAYARAN
jumlah order yang belum dikonfirmasi pembayarannya

---

SEDANG DIPROSES
jumlah order yang sedang dibuat bakery

---

SIAP DIAMBIL
jumlah order yang sudah siap diambil

---

Semua angka harus mengambil data database sebenarnya.

Jangan menggunakan angka dummy.

==================================================
6. DAFTAR SEMUA PESANAN
=======================

Admin dapat melihat seluruh order pelanggan.

Buat tabel/list profesional.

Kolom:

* No.
* Nomor Pesanan
* Nomor Urut Pelanggan
* Nama Pelanggan
* Nomor WhatsApp
* Produk
* Total
* Tanggal Pesan
* Jam Pesan
* Tanggal Pengambilan
* Jam Pengambilan
* Metode Pembayaran
* Status Pembayaran
* Status Pesanan
* Aksi

Aksi:

"Lihat Detail"

"Lihat Struk"

Jika diperlukan:

"Ubah Status"

==================================================
7. DETAIL PESANAN ADMIN
=======================

Ketika admin membuka detail order, tampilkan:

Nomor Urut:
1

Nomor Pesanan:
MB-00001

Nama:
Viola

Nomor WhatsApp:
08xxxxxxxxxx

Tanggal Pesan:
21 September 2026

Jam Pesan:
09:45

Tanggal Pengambilan:
22 September 2026

Jam Pengambilan:
15:00

Produk:

* Roti Kismis x1
* Roti Sisir x2

Additional:

* Box M
* Kartu ucapan

Request Bakery:
"Tambahkan tulisan Selamat Ulang Tahun"

Subtotal:
Rp...

Biaya QRIS:
Rp...

Total:
Rp...

Metode Pembayaran:
QRIS

Status Pembayaran:
Menunggu Pembayaran

Status Pesanan:
Pesanan Dibuat

Semua informasi harus mengambil data order sebenarnya.

==================================================
8. STRUK ADMIN
==============

Admin harus dapat melihat struk digital pelanggan.

Struk menampilkan:

* Logo Mahligai Bakery
* Nomor order
* Nomor urut pelanggan
* Nama customer
* Nomor WhatsApp
* Produk
* Quantity
* Harga
* Additional
* Subtotal
* QRIS fee
* Total
* Metode pembayaran
* Status pembayaran
* Tanggal order
* Jam order
* Tanggal pengambilan
* Jam pengambilan
* Request bakery.

Sediakan tombol:

"Lihat Struk"

"Cetak Struk"

Jika sistem existing mendukung print, gunakan sistem tersebut.

==================================================
9. TOTAL JUMLAH PELANGGAN
=========================

Admin harus dapat mengetahui berapa banyak pelanggan yang sudah memesan.

Contoh:

"Total Pelanggan"

125

Angka harus berasal dari database.

PENTING:

Bedakan:

* jumlah order
* jumlah customer unik.

Jika satu customer melakukan 3 order, jangan menghitungnya sebagai 3 customer jika statistik yang ditampilkan adalah "Total Pelanggan".

Namun:

"Total Pesanan" tetap menghitung 3 order.

==================================================
10. NOMOR URUT PESANAN
======================

Pertahankan sistem nomor urut global:

1
2
3
4
5
dst.

Setiap order baru mendapatkan nomor urut berikutnya.

Contoh:

Nomor Urut:
15

Nomor Order:
MB-00015

Nomor tersebut harus tersimpan permanen dan tidak berubah.

Gunakan implementasi existing jika sudah dibuat.

Jangan membuat sistem nomor urut kedua.

==================================================
11. STATUS PESANAN
==================

Admin dapat mengubah status order.

Status:

* Pesanan Dibuat
* Menunggu Pembayaran
* Pembayaran Dikonfirmasi
* Sedang Diproses
* Siap Diambil
* Selesai
* Dibatalkan

Ketika admin mengubah status:

status harus otomatis terlihat pada halaman customer.

Contoh:

Admin:
"Sedang Diproses"

Customer:
"Sedang Diproses"

Jangan membuat status customer dan admin menggunakan data berbeda.

==================================================
12. TANGGAL DAN JAM PESANAN
===========================

Admin harus dapat melihat kapan customer melakukan order.

Gunakan:

orders.created_at

untuk waktu order sebenarnya.

Tampilkan:

Tanggal:
21 September 2026

Jam:
09:48

Jangan menggunakan waktu dummy.

Jika timezone aplikasi sudah diatur, gunakan timezone project yang benar.

==================================================
13. CUSTOMER "PESANAN SAYA"
===========================

Customer memiliki menu:

"Pesanan Saya"

Customer hanya dapat melihat order miliknya sendiri.

Tampilkan:

* Nomor urut
* Nomor order
* Produk
* Total
* Tanggal order
* Jam order
* Tanggal pengambilan
* Jam pengambilan
* Status pembayaran
* Status pesanan
* Lihat Struk.

Customer tidak boleh dapat melihat order customer lain.

==================================================
14. NAVBAR CUSTOMER
===================

Setelah customer login, navbar dapat menampilkan:

Nama customer

contoh:

"Halo, Viola"

Menu:

Beranda
Tentang Kami
Produk
Galeri
Lokasi
Kontak
Keranjang
Pesanan Saya
Notifikasi

Tetap pertahankan desain navbar existing jika sudah ada.

==================================================
15. ADMIN NAVBAR / SIDEBAR
==========================

Admin dashboard memiliki menu:

Dashboard
Pesanan
Pelanggan
Chat
Notifikasi
Profil Saya
Logout

Jika fitur produk admin sudah ada atau dibutuhkan:

Produk

Gunakan sidebar yang modern dan responsive.

==================================================
16. NOTIFIKASI
==============

Pertahankan sistem notifikasi yang sudah dirancang.

Admin mendapat notifikasi:

* pesanan baru
* pembayaran
* chat baru
* request bakery.

Customer mendapat notifikasi:

* pesanan berhasil
* status pembayaran berubah
* pesanan sedang diproses
* pesanan siap diambil
* pesanan selesai
* balasan admin.

Notifikasi harus menggunakan data sebenarnya.

Jangan menggunakan dummy notification.

==================================================
17. CHAT
========

Customer tetap memiliki dua pilihan:

1. Chat Admin
2. Chat WhatsApp

Chat Admin:

* menggunakan sistem chat website existing.
* admin dapat membalas.
* pesan tersimpan.
* tampilkan waktu pesan.
* unread badge.

WhatsApp:
gunakan nomor existing:

08113996988

format link:

628113996988

Jangan mengarahkan customer ke halaman login ketika menekan WhatsApp.

==================================================
18. PEMBAYARAN
==============

Semua fitur pembayaran existing harus tetap bekerja.

Customer dapat memilih:

QRIS
atau
WhatsApp

QRIS:

* subtotal benar
* QRIS fee sesuai config/menu.php
* total benar
* status awal Menunggu Pembayaran.

WhatsApp:

* QRIS fee = 0
* total = subtotal + additional
* WhatsApp link menggunakan order sebenarnya.

Jangan membuat payment gateway palsu.

==================================================
19. DESAIN LANDING LOGIN
========================

Halaman login pertama harus terlihat lebih premium daripada halaman login biasa.

Gunakan:

* background hijau Mahligai Bakery
* cream card
* logo Mahligai Bakery
* ilustrasi bakery jika asset existing tersedia
* subtle glow
* soft shadow
* rounded corners
* typography premium.

Buat dua card:

PELАNGGAN

"Pesan roti favorit Anda dengan mudah."

[ Masuk sebagai Pelanggan ]

ADMIN

"Kelola pesanan dan pelanggan Mahligai Bakery."

[ Masuk sebagai Admin ]

Tambahkan animasi:

* fade in
* slight slide up
* hover
* button transition.

Jangan membuat animasi berlebihan.

==================================================
20. RESPONSIVE
==============

Mobile:

* dua card login tersusun vertikal.
* button mudah ditekan.
* tidak overflow.
* logo tetap terlihat.
* typography menyesuaikan.

Desktop:

* dua pilihan login dapat berdampingan.
* hero/ilustrasi dapat berada di samping.
* terlihat seperti landing page bakery profesional.

==================================================
21. KEAMANAN
============

Pastikan:

* admin route hanya dapat diakses admin.
* customer tidak dapat mengakses dashboard admin.
* admin tidak dapat melihat data melalui endpoint tanpa authorization yang benar.
* customer hanya dapat melihat order miliknya.
* password admin menggunakan hash.
* CSRF aktif.
* validasi request aktif.
* jangan expose credential admin di frontend.
* jangan expose API key Gemini.

==================================================
22. AUDIT SEBELUM IMPLEMENTASI
==============================

Sebelum mengubah kode, audit:

* routes/web.php
* routes/console.php
* User model
* Order model
* OrderController
* OrderCalculatorService
* OrderHelper
* customer authentication/session
* admin authentication
* existing middleware
* existing migrations
* existing checkout
* existing product modal
* existing QRIS
* existing WhatsApp
* existing notification
* existing chat
* existing Blade layout
* existing CSS
* existing JavaScript.

Jika fitur sudah tersedia:
GUNAKAN KEMBALI.

Jangan membuat versi duplicate.

==================================================
23. TESTING
===========

Setelah implementasi:

php artisan test --compact

vendor/bin/pint --format agent

npm run build

Pastikan tidak ada error.

Test:

1. Landing login muncul pertama kali.
2. Login customer berhasil.
3. Customer diarahkan ke menu bakery.
4. Nama customer tersimpan.
5. Customer dapat checkout.
6. Login admin berhasil.
7. Admin diarahkan ke dashboard.
8. Customer tidak dapat masuk admin.
9. Admin dapat melihat semua order.
10. Admin dapat melihat nama customer.
11. Admin dapat melihat tanggal order.
12. Admin dapat melihat jam order.
13. Admin dapat melihat total order.
14. Admin dapat melihat jumlah customer unik.
15. Admin dapat melihat struk.
16. Nomor urut otomatis.
17. Customer hanya melihat order sendiri.
18. Status admin dan customer sinkron.
19. QRIS tetap bekerja.
20. WhatsApp tetap bekerja.
21. Notification tetap bekerja.
22. Chat tetap bekerja.

==================================================
24. HASIL AKHIR
===============

Alur final yang saya inginkan:

```
                WEBSITE
                   ↓
          LANDING LOGIN PAGE
                   ↓
          ┌────────┴────────┐
          ↓                 ↓
      PELANGGAN           ADMIN
          ↓                 ↓
    Login Nama         Login Admin
          ↓                 ↓
   Website Bakery      Admin Dashboard
          ↓                 ↓
   Menu Produk        Statistik
          ↓                 ↓
      Keranjang       Semua Pesanan
          ↓                 ↓
      Checkout        Detail Order
          ↓                 ↓
  QRIS / WhatsApp      Lihat Struk
          ↓                 ↓
       Struk          Data Pelanggan
          ↓                 ↓
  Pesanan Saya        Tanggal/Jam
          ↓                 ↓
   Status Pesanan     Total Pesanan
                            ↓
                       Chat & Notifikasi
```

Jangan merusak landing page bakery, menu, katalog, checkout, QRIS, WhatsApp, cart, order, chat, dan fitur existing lainnya.

Buat PLAN terlebih dahulu.

Jangan langsung BUILD.

Setelah PLAN selesai, berhenti dan tunggu persetujuan saya.
