# PENYEMPURNAAN BESAR UI/UX MAHLIGAI BAKERY

Saya ingin melakukan penyempurnaan pada project Laravel Mahligai Bakery yang sudah ada.

Saya sudah melakukan testing terhadap hasil implementasi sebelumnya dan menemukan beberapa masalah UI/UX serta alur authentication.

Saya ingin semua masalah berikut diperbaiki sampai benar-benar berfungsi.

PENTING:

* Jangan membuat sistem baru jika fitur yang sama sudah tersedia.
* Audit kode existing terlebih dahulu.
* Jangan membuat duplicate controller/model/service/migration/authentication.
* Pertahankan sistem order, cart, QRIS, WhatsApp, struk, queue number, notification, chat, dan database yang sudah ada.
* Jangan menghapus fitur yang sudah berjalan.
* Jangan mengubah harga produk.
* Jangan mengubah data katalog.
* Jangan mengganti status order existing yang sudah digunakan dan dites.
* Jangan merusak test yang sudah ada.
* Semua perubahan harus benar-benar dites secara manual dan automated test jika memungkinkan.
* Fokus pada stabilitas dan UX profesional.

==================================================

1. LANDING PAGE HARUS KEMBALI MENJADI LANDING PAGE BAKERY
   ==================================================

HASIL IMPLEMENTASI SEBELUMNYA:

Saat membuka `/`, sekarang muncul halaman:

"Selamat Datang di Mahligai Bakery"

dengan dua pilihan:

* Masuk sebagai Pelanggan
* Masuk sebagai Admin

Saya TIDAK menginginkan tampilan seperti itu lagi.

Landing page harus kembali menjadi landing page bakery profesional seperti desain sebelum perubahan login.

Jangan tampilkan card:

"Masuk sebagai Pelanggan"

dan

"Masuk sebagai Admin"

di halaman landing.

Landing page harus menampilkan:

* Logo Mahligai Bakery
* Navbar
* Beranda
* Tentang Kami
* Produk
* Galeri
* Lokasi
* Kontak
* tombol Login
* tombol Hubungi Kami / WhatsApp
* Hero bakery
* Produk
* About
* Gallery
* Location
* Contact
* section lain yang sudah ada.

Pertahankan landing page existing sebanyak mungkin.

Jangan membuat landing page baru yang menghilangkan section existing.

==================================================
2. TOMBOL LOGIN DI NAVBAR
=========================

Di landing page, tampilkan tombol:

"Login"

Tombol Login menjadi pintu masuk untuk pengguna.

Ketika diklik:

arahkan ke halaman login.

Jangan langsung meminta user memilih:

Pelanggan / Admin

di landing page.

Pilihan role tidak boleh berupa dua card besar seperti screenshot sebelumnya.

==================================================
3. HALAMAN LOGIN
================

Buat halaman login yang profesional dan sederhana.

Tampilkan:

Logo Mahligai Bakery

"Selamat Datang Kembali"

"Masuk untuk melanjutkan ke Mahligai Bakery."

Field:

Username

Password

Button:

"Login"

Tambahkan:

"Belum punya akun?"

jika sistem customer registration memang tersedia.

==================================================
4. LOGIN CUSTOMER DAN ADMIN
===========================

Saya ingin authentication lebih jelas.

Admin:

Username:
admin

Password:
bakery mahligai

Password WAJIB menggunakan hashing Laravel.

Jangan menyimpan password plaintext.

Jangan hardcode credential pada JavaScript/frontend.

Customer juga harus mempunyai authentication/session yang jelas.

PENTING:

Audit sistem customer yang sekarang.

Jika customer sebelumnya hanya menggunakan nama tanpa password, jangan membuat implementasi setengah-setengah.

Sesuaikan dengan sistem authentication yang sudah ada dan buat login customer stabil.

Jika sistem existing memang sudah memiliki username/password customer, gunakan sistem tersebut.

Jika belum ada credential customer, buat mekanisme customer account yang konsisten dengan database dan auth existing.

Jangan membuat dua sistem login yang saling bertabrakan.

==================================================
5. REDIRECT SETELAH LOGIN
=========================

Jika ADMIN berhasil login:

LOGIN
↓
ADMIN DASHBOARD

Jika CUSTOMER berhasil login:

LOGIN
↓
MENU / WEBSITE BAKERY

Customer masuk ke website bakery yang sudah ada.

Jangan masuk ke landing pilihan role.

==================================================
6. LOGOUT WAJIB KEMBALI KE LANDING PAGE
=======================================

Ini sangat penting.

Saat ADMIN klik:

"Logout"

maka:

Admin Logout
↓
Session admin dihapus
↓
Redirect ke `/`
↓
Landing page Mahligai Bakery

Saat CUSTOMER klik:

"Logout"

maka:

Customer Logout
↓
Session customer dihapus
↓
Redirect ke `/`
↓
Landing page Mahligai Bakery

Jangan redirect ke:

/login

Jangan redirect ke:

/admin/login

Jangan redirect ke:

/menu

Kecuali memang ada kondisi khusus yang diperlukan security.

Target utama setelah logout:

`/`

Pastikan tidak muncul error.

Pastikan browser tidak dapat kembali ke dashboard dengan tombol Back tanpa login lagi.

Gunakan session invalidation/regeneration sesuai praktik Laravel.

==================================================
7. BUG TOMBOL X PADA MODAL CHECKOUT
===================================

Saat ini tombol X pada modal:

"Data Diri & Pembayaran"

TIDAK BISA DIKLIK.

Ini harus diperbaiki.

Audit:

* z-index
* overlay
* pointer-events
* event propagation
* fixed/sticky element
* invisible element
* form overlay
* modal container
* button nesting
* JavaScript event listener.

Pastikan tombol X benar-benar menerima click.

Ketika diklik:

Modal tertutup.

Tidak submit form.

Tidak menjalankan checkout.

Tidak membuka halaman lain.

Tidak menyebabkan error JavaScript.

Tambahkan event listener yang scoped ke modal yang benar.

Jika modal dibuat/dibuka lebih dari sekali, pastikan event listener tidak terpasang berkali-kali.

==================================================
8. MODAL CHECKOUT HARUS BISA SCROLL SAMPAI BAWAH
================================================

Screenshot pertama menunjukkan masalah:

Bagian:

"Metode Pembayaran"

berada terlalu bawah sehingga user tidak dapat melihat keseluruhan checkout dengan nyaman.

Saya ingin modal checkout seperti website pembayaran profesional.

Struktur:

┌───────────────────────────────┐
│ Header + Back + X             │
├───────────────────────────────┤
│                               │
│       SCROLLABLE BODY         │
│                               │
│ Ringkasan Pesanan             │
│ Nama                          │
│ WhatsApp                      │
│ Jadwal Pengambilan            │
│ Request Bakery                │
│ Metode Pembayaran             │
│ Subtotal                      │
│ QRIS Fee                      │
│ Total                         │
│                               │
├───────────────────────────────┤
│ Tombol Konfirmasi             │
└───────────────────────────────┘

BODY HARUS BISA DI-SCROLL.

Header tidak ikut hilang.

Footer/button tidak menutupi konten.

Pada mobile juga harus bisa scroll.

Gunakan:

* max-height viewport
* overflow-y-auto
* min-height / flex layout yang benar
* dynamic viewport jika diperlukan
* safe area pada mobile.

Jangan menggunakan fixed height yang menyebabkan konten terpotong.

==================================================
9. TOMBOL KONFIRMASI TIDAK BOLEH MENUTUPI KONTEN
================================================

Tombol:

"Konfirmasi Pesanan"

harus berada setelah ringkasan pembayaran.

Jangan membuat tombol terlalu besar sampai menutupi:

* total
* metode pembayaran
* field
* request bakery.

Jika menggunakan sticky footer:

pastikan terdapat padding-bottom pada scrollable content sehingga elemen terakhir tetap dapat terlihat sepenuhnya.

User harus bisa scroll sampai:

"Total Pembayaran"

kemudian tombol:

"Konfirmasi Pesanan"

dapat ditekan dengan nyaman.

==================================================
10. MODAL RESPONSIVE
====================

Desktop:

modal berada di tengah.

Mobile:

modal menggunakan hampir seluruh layar tetapi tetap memiliki margin yang nyaman.

Contoh struktur:

max-height:
90dvh / 100dvh sesuai kebutuhan.

Body:

overflow-y-auto.

Jangan membuat body website ikut scroll ketika modal terbuka.

Saat modal ditutup:

scroll halaman utama kembali normal.

==================================================
11. CHECKOUT FLOW
=================

Pertahankan flow existing:

Cart
↓
Checkout
↓
Data Diri
↓
Nomor WhatsApp
↓
Tanggal Pengambilan
↓
Jam Pengambilan
↓
Request Bakery
↓
Metode Pembayaran
↓
Subtotal
↓
QRIS Fee
↓
Total
↓
Konfirmasi.

Jangan menghilangkan field existing.

==================================================
12. ANIMASI PESANAN BERHASIL
============================

Setelah order berhasil:

tampilkan custom success animation yang sudah direncanakan.

Jangan install dependency baru jika tidak diperlukan.

Gunakan CSS/JavaScript existing.

Tampilkan:

✓

"Pesanan Berhasil!"

Nomor Pesanan:
MB-00001

Nomor Urut:
1

Button:

"Lihat Struk"

"Pesanan Saya"

Animasi harus smooth dan tidak mengganggu.

==================================================
13. STRUK
=========

Setelah berhasil:

customer dapat melihat struk.

Struk menampilkan data order sebenarnya:

* logo
* nomor order
* nomor urut
* nama customer
* WhatsApp
* produk
* quantity
* harga
* additional
* subtotal
* QRIS fee
* total
* metode pembayaran
* status pembayaran
* tanggal order
* jam order
* tanggal pickup
* jam pickup
* request bakery.

Jangan menggunakan data dummy.

==================================================
14. DASHBOARD ADMIN DISEMPURNAKAN
=================================

Dashboard admin yang sekarang masih perlu dipoles.

Buat tampilan admin lebih profesional.

Gunakan:

* sidebar modern
* topbar
* notification
* profile admin
* statistics card
* order table
* status badge
* search
* responsive layout
* empty state
* loading state jika diperlukan.

Dashboard harus terlihat seperti dashboard bakery/e-commerce profesional.

==================================================
15. STATISTIK ADMIN
===================

Tampilkan:

Total Pesanan
Total Pelanggan
Pesanan Hari Ini
Menunggu Pembayaran
Sedang Diproses
Siap Diambil

Gunakan data database sebenarnya.

Jangan hardcode angka.

"Total Pelanggan" = jumlah customer unik yang sudah mempunyai order.

"Total Pesanan" = jumlah seluruh order.

==================================================
16. HALAMAN PESANAN ADMIN
=========================

Admin dapat melihat semua order.

Tampilkan:

* Nomor
* Nomor Order
* Queue Number
* Nama Customer
* WhatsApp
* Produk
* Total
* Tanggal
* Jam
* Pickup
* Payment
* Status Payment
* Status Order
* Aksi.

Buat tabel responsive.

Pada mobile:
ubah tabel menjadi card/list jika diperlukan agar tidak overflow horizontal secara buruk.

==================================================
17. HALAMAN PELANGGAN ADMIN
===========================

Pertahankan halaman:

Pelanggan

Tampilkan:

* nama customer
* nomor WhatsApp
* jumlah order
* order terakhir
* tanggal order terakhir.

Data berasal dari database.

Tambahkan:

"Lihat Pesanan"

agar admin dapat melihat order customer tersebut.

==================================================
18. DETAIL ORDER ADMIN
======================

Saat admin membuka detail:

Tampilkan card informasi yang jelas:

INFORMASI PELANGGAN

* nama
* WhatsApp

INFORMASI ORDER

* nomor order
* queue number
* tanggal
* jam

PESANAN

* produk
* quantity
* add-ons

PENGAMBILAN

* tanggal
* jam

REQUEST

* request bakery

PEMBAYARAN

* subtotal
* QRIS fee
* total
* metode
* status.

Tambahkan tombol:

"Lihat Struk"

"Cetak Struk"

"Ubah Status"

==================================================
19. HALAMAN CUSTOMER DISEMPURNAKAN
==================================

Customer setelah login harus mendapatkan pengalaman yang profesional.

Navbar:

Logo
Beranda
Tentang
Produk
Galeri
Lokasi
Kontak

Bagian kanan:

Keranjang
Notifikasi
Nama Customer
Logout.

Customer dapat:

* melihat produk
* memasukkan produk ke cart
* checkout
* membayar
* melihat struk
* melihat Pesanan Saya
* melihat status order
* chat admin
* WhatsApp admin.

Jangan sampai menu yang sudah ada hilang.

==================================================
20. PESANAN SAYA CUSTOMER
=========================

Buat tampilan lebih profesional.

Tampilkan card order:

MB-00001

#1

Viola

Rp105.000

21 September 2026
10:00

Status:

Sedang Diproses

Timeline:

Pesanan Dibuat
↓
Pembayaran
↓
Diproses
↓
Siap Diambil
↓
Selesai

Tambahkan:

"Lihat Struk"

"Detail Pesanan"

"Chat Admin"

==================================================
21. STATUS HARUS SINKRON
========================

Gunakan status existing.

JANGAN mengganti constants/status database yang sudah ada.

Jika dashboard membutuhkan:

"Sedang Diproses"

map dari status existing:

`pesanan_diproses`

Jika dashboard membutuhkan:

"Siap Diambil"

map dari:

`pesanan_siap`

Jangan membuat status kedua.

==================================================
22. NOTIFIKASI
==============

Pastikan notification customer dan admin tetap berjalan.

Customer:

* order baru
* pembayaran
* status order
* chat admin.

Admin:

* order baru
* pembayaran
* chat customer.

Notification badge harus sinkron dengan database.

==================================================
23. CHAT
========

Pastikan:

Customer:
Chat Admin
atau
WhatsApp.

Admin:
melihat chat customer
dan membalas.

Jangan merusak chat existing.

==================================================
24. SMOOTH SCROLL DAN ANIMASI
=============================

Landing page dan halaman customer harus terasa smooth.

Pertahankan Lenis/getLenis/initLenis jika sudah ada.

Jangan membuat dua library smooth scrolling yang bertabrakan.

Gunakan animasi:

* fade
* slide
* hover
* card reveal
* modal transition.

Gunakan prefers-reduced-motion jika memungkinkan.

Jangan membuat animasi mengganggu input, button, modal, atau scrolling.

==================================================
25. FIX SEMUA MASALAH POINTER / CLICK
=====================================

Audit seluruh overlay/modal.

Terutama:

* X
* Back
* Confirm
* Delete
* Login
* Logout
* Checkout
* Payment method
* Cart
* Notification
* Chat.

Pastikan tidak ada element transparan yang menutup tombol.

Periksa:

pointer-events
z-index
position
overflow
stacking context
event propagation.

Semua tombol harus benar-benar dapat diklik.

==================================================
26. LOGOUT
==========

Pastikan:

ADMIN LOGOUT
↓
session invalidate
↓
redirect `/`

CUSTOMER LOGOUT
↓
session invalidate
↓
redirect `/`

Setelah logout:

* dashboard tidak bisa dibuka kembali tanpa login
* halaman customer tidak bisa dibuka kembali tanpa login
* browser back tidak menampilkan halaman private secara fungsional
* session benar-benar dihapus.

==================================================
27. ERROR HANDLING
==================

Jangan tampilkan error Laravel mentah kepada user untuk error biasa.

Gunakan:

* validation message
* toast/inline error
* loading state
* empty state
* success state.

Jika request AJAX gagal:

tampilkan pesan yang jelas.

Jangan membuat halaman blank.

==================================================
28. SECURITY
============

Pertahankan:

* CSRF
* auth middleware
* admin middleware
* customer middleware/guard
* authorization
* password hashing
* session invalidation.

Jangan expose:

* password
* API key
* secret
* credential.

==================================================
29. JANGAN DUPLICATE
====================

Sebelum membuat file baru, cari apakah sudah ada:

* CustomerAuthController
* AdminAuthController
* OrderController
* OrderHelper
* OrderCalculatorService
* customer auth
* admin auth
* modal JS
* cart JS
* notification JS
* chat JS
* receipt component
* admin layout
* customer layout.

Gunakan file existing.

==================================================
30. TESTING
===========

Setelah implementasi jalankan:

php artisan test --compact

vendor/bin/pint --format agent

npm run build

Jika ada error:

perbaiki.

Jalankan kembali sampai berhasil.

Tambahkan/ubah test jika diperlukan untuk:

1. Landing page.
2. Login customer.
3. Login admin.
4. Logout customer.
5. Logout admin.
6. Redirect logout ke `/`.
7. Authorization admin.
8. Authorization customer.
9. Checkout.
10. Modal close.
11. Checkout scroll.
12. Order creation.
13. Receipt.
14. Queue number.
15. Admin dashboard.
16. Admin customer list.
17. Customer order list.
18. Notification.
19. Chat.
20. QRIS.
21. WhatsApp.

==================================================
31. HASIL AKHIR YANG SAYA INGINKAN
==================================

ALUR WEBSITE:

LANDING PAGE BAKERY NORMAL
↓
Navbar
↓
[ LOGIN ]
↓
LOGIN
Username
Password
↓
┌───────────────┬───────────────┐
│               │               │
ADMIN         CUSTOMER
│               │
↓               ↓
Dashboard       Website Bakery
│               │
Pesanan         Produk
│               │
Pelanggan       Cart
│               │
Chat            Checkout
│               │
Notifikasi      QRIS/WhatsApp
│               │
Profil          Struk
│               │
Logout          Pesanan Saya
↓               │
LANDING ←───────┘

````

Landing page TIDAK boleh lagi menampilkan dua card:

"Masuk sebagai Pelanggan"

"Masuk sebagai Admin"

Login cukup melalui tombol "Login" di navbar.

==================================================
32. PRIORITAS PERBAIKAN
==================================================

Prioritas paling tinggi:

1. Tombol X checkout HARUS berfungsi.
2. Checkout HARUS bisa scroll sampai paling bawah.
3. Tombol Konfirmasi tidak boleh menutupi konten.
4. Landing page kembali menjadi landing bakery normal.
5. Login harus jelas dan stabil.
6. Logout admin → `/`.
7. Logout customer → `/`.
8. Admin dashboard dipoles.
9. Customer dashboard/menu dipoles.
10. Semua existing feature tetap bekerja.

Jangan menganggap task selesai hanya karena file berhasil dibuat.

Lakukan audit setelah implementasi dan pastikan seluruh alur dapat digunakan dari awal sampai akhir.

==================================================
33. MODE KERJA
==================================================

JANGAN langsung Build.

Tahap pertama:

Audit project existing.

Kemudian buat PLAN yang menjelaskan:

- file yang akan diubah
- file baru jika benar-benar diperlukan
- route yang berubah
- authentication yang digunakan
- controller
- Blade
- JavaScript
- CSS
- modal
- checkout
- logout
- admin dashboard
- customer page
- testing.

Setelah PLAN selesai:

BERHENTI.

Tunggu persetujuan saya sebelum Build.

### Setelah itu

Di OpenCode:

**`promt4.md` → drag ke OpenCode → pilih Plan.**

Jangan Build dulu.

Dan khusus **tombol X**, saya ingin OpenCode benar-benar mengaudit `z-index`, `pointer-events`, overlay, dan event listener. Karena dari screenshot pertama, masalahnya bukan sekadar posisi tombol—kalau tombol **X sama sekali tidak merespons klik**, ada kemungkinan elemen overlay/container lain yang menangkap klik.

Untuk checkout, target akhirnya harus seperti ini:

```text
┌─────────────────────────────┐
│ ← Data Diri & Pembayaran  X │ ← tetap terlihat
├─────────────────────────────┤
│                             │
│   RINGKASAN PESANAN         │
│                             │
│   Nama                      │
│   WhatsApp                  │
│   Jadwal Pengambilan        │
│   Request Bakery            │
│   Metode Pembayaran         │
│                             │
│   ↓ SCROLL ↓                │
│                             │
│   Subtotal                  │
│   Biaya QRIS                │
│   TOTAL                     │
│                             │
├─────────────────────────────┤
│   KONFIRMASI PESANAN        │
└─────────────────────────────┘
````

Jadi **bagian bawah tidak boleh terpotong seperti screenshot pertama** dan tombol konfirmasi tidak boleh menutupi isi.

Setelah OpenCode selesai membuat **Plan `promt4.md`**, kirim hasilnya ke sini. Saya cek dulu sebelum kamu tekan **Build**.

### 34. STABILITAS FONT DAN KETERBACAAN LANDING PAGE

Saya ingin typography pada landing page Mahligai Bakery terlihat stabil, jelas, dan profesional.

Masalah yang harus diperbaiki:

* Font jangan terlihat terlalu gelap.
* Font jangan tertutup oleh overlay/background.
* Font jangan menjadi blur.
* Font jangan berubah warna secara tidak konsisten ketika scrolling.
* Text harus tetap terbaca ketika berada di atas background hijau.
* Jangan sampai gradient, overlay, image, animation, atau pseudo-element menutupi tulisan.
* Jangan membuat opacity pada parent element yang menyebabkan seluruh text ikut menjadi transparan.
* Pastikan `z-index` text berada di layer yang benar.
* Pastikan contrast antara text dan background cukup jelas.
* Jangan menggunakan text-shadow berlebihan.
* Jangan membuat font terlihat terlalu tipis.
* Jangan membuat animasi text menyebabkan flicker atau perubahan brightness.

### TYPOGRAPHY

Gunakan typography yang sudah menjadi bagian dari desain Mahligai Bakery.

Headline harus:

* jelas
* tegas
* elegan
* mudah dibaca
* tidak terlalu tipis.

Paragraph harus:

* memiliki line-height yang nyaman
* warna cukup kontras
* tidak terlalu redup.

Navigation:

* tetap jelas ketika navbar berada di atas hero/background.
* saat navbar berubah ketika scrolling, warna text harus tetap terbaca.
* jangan sampai navbar menjadi transparan sehingga text sulit dibaca.

### BACKGROUND DAN OVERLAY

Audit seluruh:

* background
* gradient
* overlay
* pseudo-element `::before`
* pseudo-element `::after`
* blur
* backdrop-filter
* opacity
* z-index
* position

Pastikan tidak ada layer yang menutupi atau menggelapkan text.

Jika menggunakan overlay pada hero, overlay hanya digunakan untuk membantu keterbacaan, bukan membuat seluruh halaman menjadi gelap.

Gunakan struktur layer yang jelas, misalnya:

background
↓
decorative layer
↓
overlay
↓
content
↓
interactive elements

Content/text harus berada di atas decorative/background layer.

### SCROLLING

Saat user melakukan scroll:

* font tetap stabil
* warna text tidak berkedip
* ukuran font tidak berubah tiba-tiba
* opacity tidak berubah secara ekstrem
* tidak terjadi flicker
* tidak terjadi text disappearing
* tidak terjadi layout shift.

Jika menggunakan Framer Motion / animation library atau animation existing, gunakan animasi yang subtle.

Jangan menganimasikan opacity/transform secara berlebihan pada text.

### ACCESSIBILITY

Pastikan text memiliki contrast yang baik terhadap background.

Jangan mengorbankan keterbacaan hanya demi efek visual.

Gunakan `prefers-reduced-motion` untuk user yang mengurangi animasi.

### HASIL YANG DIINGINKAN

Landing page Mahligai Bakery harus terasa:

* clean
* premium
* modern
* elegant
* readable
* smooth.

Font harus selalu terlihat jelas dari saat halaman pertama dibuka sampai user selesai scrolling seluruh landing page.

Jangan mengubah font secara drastis jika typography existing sudah sesuai dengan desain. Fokus pada stabilitas, contrast, layering, dan keterbacaan.
