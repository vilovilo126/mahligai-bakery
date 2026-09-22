Saya ingin melanjutkan pengembangan project Laravel Mahligai Bakery yang sudah ada.

PENTING:
- Jangan membuat ulang fitur yang sudah ada.
- Jangan menghapus fitur yang sudah berjalan.
- Sebelum mengubah kode, lakukan audit terhadap struktur project, database, routes, controllers, models, services, Blade, CSS, JavaScript, dan komponen order yang sudah ada.
- Pertahankan arsitektur dan naming convention yang sudah digunakan.
- Jangan membuat duplicate controller, model, migration, service, helper, JavaScript module, atau komponen jika sebenarnya sudah tersedia.
- Gunakan kembali sistem order/cart/payment yang sudah ada.
- Multi-product checkout tetap menggunakan cart JavaScript yang sudah dirancang.
- QRIS fee tetap berasal dari config/menu.php per item dan hanya berlaku ketika metode pembayaran QRIS dipilih.
- Jika WhatsApp dipilih, qris_fee harus 0.
- Status pembayaran jangan dibuat otomatis menjadi lunas tanpa bukti/verifikasi nyata.
- Status awal pembayaran tetap "Menunggu Pembayaran".
- Jangan membuat fake payment verification.
- Jangan menghapus data katalog/menu bakery yang sudah ada.
- Jangan mengubah harga produk yang sudah ada.
- Jangan menghapus fitur WhatsApp yang sudah dibuat.
- Gunakan Framer Motion/motion yang sudah tersedia bila memang sudah digunakan project.
- Project menggunakan Laravel + Blade + JavaScript/Tailwind sesuai struktur yang sudah ada.
- Tetap pisahkan CSS dan JavaScript sesuai struktur project.
- Semua perubahan harus responsive desktop, tablet, dan mobile.

==================================================
A. PERBAIKI HALAMAN DATA DIRI & PEMBAYARAN
==================================================

Pada modal "Data Diri & Pembayaran" seperti screenshot yang saya berikan, sekarang tombol konfirmasi terlalu menutupi area bawah dan modal terasa penuh.

Saya ingin desain checkout seperti website pembayaran profesional.

Buat:

1. Bagian isi checkout dapat di-scroll secara vertikal.

2. Header modal tetap nyaman:
   - tombol kembali
   - judul "Data Diri & Pembayaran"
   - tombol X
   - tombol X WAJIB bisa diklik dan berfungsi.
   - jangan ada overlay atau elemen lain yang menangkap klik tombol X.

3. Body checkout:
   - scrollable
   - scrollbar tidak mengganggu tampilan
   - pada desktop tetap rapi
   - pada mobile tidak melebihi tinggi layar
   - gunakan max-height yang aman seperti viewport/dynamic viewport.
   - jangan membuat halaman utama ikut tertutup secara aneh.

4. Bagian tombol konfirmasi:
   - jangan menutupi isi.
   - jangan menempel secara buruk ke konten.
   - berikan spacing yang cukup.
   - tombol berada pada area footer checkout yang nyaman.
   - jika menggunakan sticky footer, pastikan body dapat scroll di belakangnya dengan benar dan footer tidak menutupi field.
   - tombol tetap mudah ditemukan saat user scroll.
   - gunakan desain modern seperti checkout website profesional.

5. Tombol:
   - "Konfirmasi Pesanan"
   - saat sedang diproses tampilkan loading state yang halus.
   - jangan membuat user mengklik berkali-kali.
   - setelah request selesai, kembalikan state tombol dengan benar.

6. Pastikan:
   - subtotal benar
   - biaya QRIS benar
   - total benar
   - metode WhatsApp tidak mendapatkan biaya QRIS
   - multi-item tetap dihitung dengan benar
   - quantity tetap dihitung benar
   - add-on tetap masuk ke order
   - tidak ada lagi bug Rp0.

7. Gunakan selector yang scoped berdasarkan step/modal supaya bug duplicate data-order-subtotal, data-order-qris, data-order-total tidak muncul kembali.

==================================================
B. STRUK PESANAN SETELAH BERHASIL
==================================================

Setelah pelanggan berhasil melakukan pemesanan, jangan langsung hanya menutup modal.

Tampilkan pengalaman order success yang profesional.

Gunakan SweetAlert2 jika sudah tersedia di project.

Setelah order berhasil:

1. Tampilkan SweetAlert2 success dengan animasi.

Contoh:
- icon success
- "Pesanan Berhasil!"
- "Pesanan Anda sudah berhasil dibuat."
- nomor pesanan/order number.

2. Setelah SweetAlert selesai, tampilkan halaman/section/detail "Struk Pesanan".

Struk harus berisi:

- Nomor urut pelanggan
- Nomor pesanan/order number
- Nama pelanggan
- Nomor WhatsApp
- Daftar produk
- Harga masing-masing
- Quantity
- Add-on/request bakery
- Subtotal
- Biaya QRIS jika ada
- Total pembayaran
- Metode pembayaran
- Status pembayaran
- Tanggal pemesanan
- Jam pemesanan
- Waktu/tanggal pengambilan jika sudah ditentukan
- Catatan/request pelanggan jika ada.

3. Buat desain struk seperti receipt digital modern.

4. Sediakan tombol:
   - "Lihat Pesanan Saya"
   - "Kembali ke Menu"
   - jika relevan "Chat Admin"
   - "Hubungi via WhatsApp"

5. Struk harus mengambil data order sebenarnya dari database/response.
Jangan hardcode data.

==================================================
C. KERANJANG / PESANAN SAYA
==================================================

Saya ingin pelanggan mempunyai tombol/menu "Keranjang Pesanan" atau "Pesanan Saya".

Jangan hanya menjadi cart sementara.

Setelah checkout, pelanggan dapat melihat order yang pernah dibuat.

Buat halaman/section:

"Pesanan Saya"

Setiap pesanan menampilkan:

- Nomor urut pelanggan
- Nomor pesanan
- Produk
- Total
- Metode pembayaran
- Status pembayaran
- Status pesanan
- Tanggal beli
- Jam beli
- Tanggal/jam pengambilan
- Request bakery
- tombol "Lihat Detail"
- tombol "Lihat Struk"
- tombol "Chat Admin"

Status pesanan minimal:

- Pesanan Dibuat
- Menunggu Pembayaran
- Pembayaran Dikonfirmasi
- Sedang Diproses
- Siap Diambil
- Selesai
- Dibatalkan

Admin dapat mengubah status sesuai kondisi nyata.

Jangan membuat status pembayaran "berhasil" secara otomatis hanya karena order dibuat.

==================================================
D. NOMOR URUT PELANGGAN OTOMATIS
==================================================

Saya ingin setiap pelanggan/order mempunyai nomor urut otomatis seperti:

1
2
3
4
5
dst.

Nomor urut harus otomatis berdasarkan order/pelanggan yang dibuat.

Jangan menggunakan nomor acak untuk nomor urut pelanggan.

Jika database sudah mempunyai ID/order ID yang dapat dipakai, audit terlebih dahulu apakah bisa digunakan atau perlu field khusus.

Jika membutuhkan migration baru untuk fitur ini, buat migration yang aman dan tidak merusak data existing.

Nomor urut harus terlihat di:

- struk pelanggan
- halaman Pesanan Saya
- admin dashboard
- detail order admin
- notifikasi yang relevan.

==================================================
E. LOGIN PELANGGAN
==================================================

Saya ingin sebelum pelanggan menggunakan website/order, pelanggan melakukan login sederhana.

Untuk pelanggan cukup:

- Nama pelanggan

Tidak perlu password untuk customer pada tahap ini.

Buat halaman/modal:

"Selamat Datang di Mahligai Bakery"

Field:
- Nama Lengkap

Button:
- "Masuk"

Setelah login:
- simpan identitas customer menggunakan session Laravel yang sesuai.
- nama customer dapat digunakan di menu bakery.
- nama customer dapat digunakan pada order.
- nama customer dapat ditampilkan pada navbar/menu customer.
- customer dapat melihat pesanan miliknya berdasarkan session/identitas yang benar.

Jangan meminta customer login ulang setiap membuka halaman jika session masih aktif.

Buat:
- login customer
- logout customer
- middleware/guard/session yang sesuai jika diperlukan.

PENTING:
Karena login customer hanya menggunakan nama, jangan menganggap nama sebagai keamanan tinggi.
Gunakan session Laravel dan mekanisme yang konsisten untuk sesi customer.

==================================================
F. LOGIN ADMIN MAHLIGAI BAKERY
==================================================

Buat halaman login khusus admin.

Username:
admin

Password:
bakery mahligai

PENTING:
- password harus disimpan menggunakan hashing Laravel.
- jangan menyimpan password plaintext di database.
- jangan menampilkan password di halaman admin.
- jangan hardcode credential pada frontend JavaScript.
- gunakan seeder/config/environment sesuai arsitektur Laravel yang paling aman untuk project ini.
- jika sudah ada sistem User/role, gunakan kembali sistem tersebut.
- jangan membuat sistem autentikasi duplicate jika Laravel auth yang diperlukan sudah tersedia.

Admin login harus berbeda dari customer login.

Admin yang berhasil login diarahkan ke:

/admin

atau route admin yang sesuai dengan struktur project.

Semua halaman admin wajib terlindungi sehingga customer biasa tidak dapat mengaksesnya.

==================================================
G. ADMIN DASHBOARD
==================================================

Buat halaman Admin Bakery yang profesional.

Dashboard menampilkan:

1. Ringkasan:
   - total pesanan
   - pesanan baru
   - menunggu pembayaran
   - sedang diproses
   - siap diambil
   - selesai
   - dibatalkan

2. Daftar pesanan terbaru.

Setiap order menampilkan:

- nomor urut pelanggan
- nomor order
- nama pelanggan
- nomor WhatsApp
- produk
- quantity
- total
- tanggal order
- jam order
- tanggal pengambilan
- jam pengambilan
- request bakery
- metode pembayaran
- status pembayaran
- status pesanan.

Admin dapat membuka detail order.

==================================================
H. ADMIN MENGELOLA PESANAN
==================================================

Admin harus dapat:

- melihat semua pesanan
- melihat detail pesanan
- melihat struk
- melihat kapan pelanggan membeli
- melihat jam pembelian
- melihat kapan pesanan akan diambil
- melihat request bakery
- melihat nama pelanggan
- melihat nomor urut pelanggan
- melihat nomor WhatsApp
- mengubah status pesanan
- mengubah status pembayaran
- menambahkan/catatan internal jika sistem existing mendukung
- melihat produk dan add-on yang dibeli.

Status harus sinkron dengan halaman pelanggan.

Jika admin mengubah:

"Sedang Diproses"

maka pelanggan juga melihat:

"Sedang Diproses"

Jika admin mengubah:

"Siap Diambil"

maka pelanggan juga melihat:

"Siap Diambil"

Jangan membuat status admin dan customer berjalan pada data yang berbeda.

==================================================
I. WAKTU PEMBELIAN DAN WAKTU PENGAMBILAN
==================================================

Order harus mencatat:

- created_at = waktu pelanggan melakukan pembelian.
- pickup date
- pickup time

Jika fitur pickup belum ada pada database/UI:

buat field dan UI yang sesuai.

Pada checkout, pelanggan dapat memilih:

"Tanggal Pengambilan"

dan

"Jam Pengambilan"

serta:

"Request Bakery"

contoh:
- tulisan pada box
- kartu ucapan
- request khusus
- request lainnya.

Request bakery harus tersimpan di order dan dapat dilihat admin.

Validasi:
- tanggal/jam harus masuk akal.
- jangan menerima data kosong jika field wajib.
- tampilkan error dengan jelas.

==================================================
J. CHAT PELANGGAN DENGAN ADMIN
==================================================

Saya ingin pelanggan mempunyai dua pilihan ketika ingin bertanya:

1. "Chat Admin"
2. "Chat via WhatsApp"

Chat Admin:
- menggunakan sistem chat di dalam website.
- customer dapat mengirim pesan kepada admin.
- admin dapat membaca pesan.
- admin dapat membalas.
- percakapan tersimpan.
- tampilkan waktu pesan.
- tampilkan status pesan jika sistem mendukung.
- gunakan UI chat modern.

Chat via WhatsApp:
- langsung membuka WhatsApp.
- gunakan nomor bisnis yang sudah digunakan project:
  08113996988
- gunakan format WhatsApp internasional:
  628113996988
- jangan arahkan ke halaman login.
- jangan menggunakan nomor hardcode di banyak file jika config business.php sudah menjadi single source.
- gunakan config bisnis yang sudah ada.

Jika customer berasal dari order tertentu, pesan WhatsApp dapat menyertakan nomor order secara otomatis.

Contoh pesan:
"Halo Mahligai Bakery, saya ingin bertanya mengenai pesanan #...."

==================================================
K. CHAT ADMIN
==================================================

Pada admin dashboard buat menu:

"Pesan"

Admin dapat melihat:

- daftar percakapan
- nama customer
- pesan terakhir
- waktu pesan terakhir
- unread badge
- buka percakapan
- membalas pesan.

Chat harus memiliki:

- unread count
- timestamp
- customer name
- pesan
- reply admin.

Jika memungkinkan berdasarkan arsitektur project, gunakan polling ringan/AJAX atau mekanisme realtime yang sudah tersedia.

Jangan menggunakan mekanisme yang menyebabkan request terus menerus secara berlebihan.

==================================================
L. NOTIFIKASI CUSTOMER
==================================================

Buat sistem notifikasi customer yang sinkron.

Customer dapat menerima notifikasi ketika:

- order berhasil dibuat
- pembayaran diperbarui
- order mulai diproses
- order siap diambil
- order selesai
- admin membalas chat
- ada informasi penting dari admin.

Tambahkan icon notifikasi pada menu/navbar customer.

Jika ada notifikasi baru:
- tampilkan badge angka
- badge berubah sesuai jumlah unread.
- klik notifikasi membuka detail yang sesuai.
- notifikasi dapat ditandai sudah dibaca.

Jangan menggunakan dummy notification.

Notifikasi harus berdasarkan data sebenarnya.

==================================================
M. NOTIFIKASI ADMIN
==================================================

Admin juga mempunyai notifikasi.

Contoh:

- ada pesanan baru
- ada pembayaran/customer update
- ada chat baru
- ada customer mengirim request
- ada order yang perlu diperiksa.

Admin navbar/dashboard memiliki notification icon.

Tampilkan:
- badge jumlah unread
- daftar notifikasi
- waktu
- link ke order/chat terkait
- mark as read.

Customer dan admin harus mempunyai data notifikasi masing-masing dan tidak saling tercampur.

==================================================
N. ADMIN EDIT PROFIL
==================================================

Admin dapat membuka:

"Profil Saya"

Admin dapat melihat dan mengubah:

- nama
- username jika arsitektur memungkinkan
- nomor WhatsApp
- email jika ada
- foto profil jika sistem mendukung
- password.

Jika mengubah password:
- gunakan current password verification
- hash password baru.

Buat validasi yang benar.

==================================================
O. MENU PRODUK CUSTOMER
==================================================

Menu bakery yang sudah ada harus tetap digunakan.

Pastikan customer dapat:

- melihat produk
- melihat harga
- melihat detail
- memilih quantity
- memilih additional
- memasukkan ke cart
- membeli beberapa produk sekaligus
- checkout.

Additional harus ikut masuk ke order.

Jangan menghilangkan katalog:

- Roti Unyil Aneka Rasa
- Roti Sisir
- Aneka Roti / Regular Bread
- Roti Tawar dan produk lain yang sudah ada di config/menu.php.

Harga tetap menggunakan sumber data existing.

==================================================
P. ANIMASI DAN SMOOTH SCROLL
==================================================

Saya ingin website terasa smooth dan profesional.

Gunakan Framer Motion/motion yang sudah tersedia untuk React-style components jika memang bagian tersebut menggunakan React.

Untuk landing page/Blade yang sudah menggunakan Lenis atau smooth scrolling existing:
- pertahankan sistem yang sudah ada.
- jangan membuat dua smooth-scroll engine yang bentrok.
- audit getLenis/initLenis yang sudah ada.

Saat user melakukan scroll:
- section masuk dengan animasi halus
- fade/slide ringan
- tidak terlalu cepat
- tidak berlebihan
- jangan membuat website berat.
- jangan membuat animasi mengganggu klik atau form.
- gunakan prefers-reduced-motion untuk accessibility jika memungkinkan.

Animasi yang diinginkan:
- hero
- about
- menu
- product cards
- gallery
- testimonials
- contact
- order section
- notification
- modal transition
- success order.

Gunakan animasi yang elegan dan tidak berlebihan.

==================================================
Q. UX CHECKOUT
==================================================

Checkout harus terasa seperti website bakery/e-commerce profesional.

Alur:

Customer login
↓
Melihat menu
↓
Pilih produk
↓
Tambah ke keranjang
↓
Tambah additional jika diperlukan
↓
Buka keranjang
↓
Lanjut pembayaran
↓
Isi nama
↓
Isi nomor WhatsApp
↓
Pilih tanggal pengambilan
↓
Pilih jam pengambilan
↓
Isi request bakery
↓
Pilih QRIS / WhatsApp
↓
Melihat subtotal
↓
Melihat biaya QRIS jika QRIS
↓
Melihat total
↓
Konfirmasi Pesanan
↓
Success animation
↓
Struk
↓
Pesanan masuk ke "Pesanan Saya"
↓
Admin menerima notifikasi order baru.

==================================================
R. QRIS
==================================================

Pertahankan sistem QRIS yang sudah ada.

Ketika QRIS dipilih:
- tampilkan biaya QRIS sesuai config/menu.php per item.
- tampilkan total yang benar.
- QRIS nominal harus sama dengan total order.
- status awal "Menunggu Pembayaran".
- jangan mengklaim pembayaran berhasil jika belum diverifikasi.

Ketika WhatsApp dipilih:
- qris_fee = 0
- total = subtotal + add-ons
- buka WhatsApp menggunakan wa_link dari backend.
- pesan WhatsApp harus berisi order sebenarnya.

QRIS logo yang sudah ada tetap digunakan sesuai implementasi existing dan jangan membuat logo resmi palsu.

==================================================
S. WHATSAPP ORDER
==================================================

Jika customer memilih WhatsApp:

Backend menghasilkan wa_link yang benar.

Pesan harus dinamis dan berisi:

- nomor order
- nomor urut pelanggan
- nama pelanggan
- nomor WhatsApp
- daftar produk
- quantity
- add-ons
- subtotal
- biaya QRIS jika ada
- total
- metode pembayaran
- tanggal pengambilan
- jam pengambilan
- request bakery.

Jangan membuat pesan WhatsApp statis.

Gunakan OrderHelper/logic existing jika sudah tersedia.

==================================================
T. RESPONSIVE
==================================================

Semua halaman harus responsive.

Desktop:
- dashboard luas
- sidebar admin
- tabel/list order rapi.

Tablet:
- layout menyesuaikan.

Mobile:
- sidebar menjadi menu mobile
- checkout tidak terpotong
- modal bisa scroll
- tombol konfirmasi tidak menutupi isi
- notification dropdown tidak keluar layar
- chat nyaman digunakan
- struk dapat dibaca dengan jelas.

==================================================
U. DATABASE DAN MIGRATION
==================================================

Sebelum membuat migration baru, audit database yang sudah ada.

Gunakan tabel/model existing jika sudah mendukung.

Fitur baru yang mungkin membutuhkan data persistence:
- customer session/profile jika diperlukan
- pickup date/time
- bakery request
- order number/queue number jika belum ada
- chat
- chat messages
- notifications
- admin role/auth jika belum ada.

Tetapi:
- jangan membuat tabel duplicate.
- jangan membuat model duplicate.
- jangan membuat migration duplicate.
- gunakan tabel existing bila memungkinkan.
- jika benar-benar perlu migration baru, buat migration Laravel yang aman dan jelas.
- jalankan migration setelah implementasi.

==================================================
V. SECURITY
==================================================

Pastikan:

- admin route terlindungi.
- customer tidak bisa masuk admin.
- admin tidak bercampur dengan customer.
- password admin hashed.
- validasi request menggunakan Laravel Request validation jika sudah ada pola tersebut.
- CSRF tetap aktif.
- authorization diterapkan pada order/chat/notification.
- customer hanya dapat melihat order miliknya.
- jangan expose credential admin pada JavaScript/frontend.
- jangan expose API key Gemini.
- gunakan .env untuk secret.
- jangan log password atau secret.

==================================================
W. TESTING
==================================================

Setelah selesai implementasi, jalankan:

php artisan test --compact

vendor/bin/pint --format agent

npm run build

Jika ada error, perbaiki sampai build dan test berhasil.

Tambahkan/update test untuk:

1. Customer login.
2. Admin login.
3. Customer tidak dapat mengakses admin.
4. Admin dapat mengakses dashboard.
5. Multi-item checkout.
6. Quantity.
7. Add-ons.
8. QRIS fee.
9. WhatsApp qris_fee = 0.
10. Order number.
11. Queue/customer number.
12. Pickup date/time.
13. Bakery request.
14. Order status.
15. Customer dapat melihat order sendiri.
16. Admin dapat melihat semua order.
17. Notification customer.
18. Notification admin.
19. Chat customer-admin.
20. Admin reply.
21. WhatsApp link.
22. Order total.
23. Receipt data.
24. Invalid phone number.
25. X button/modal close tidak rusak secara frontend.

==================================================
X. DOKUMENTASI
==================================================

Setelah implementasi, update:

docs/IMPLEMENTATION.md

Dokumentasikan:

- file yang diubah
- file yang dibuat
- migration
- model
- controller
- service
- helper
- routes
- Blade
- JavaScript
- CSS
- auth customer
- auth admin
- order flow
- payment flow
- QRIS
- WhatsApp
- chat
- notification
- receipt
- admin dashboard
- testing.

==================================================
Y. JANGAN MERUSAK IMPLEMENTASI SEBELUMNYA
==================================================

Ini sangat penting.

Implementasi sebelumnya sudah mempunyai:

- multi-item cart
- OrderCalculatorService
- OrderController
- OrderHelper
- product-detail-modal.blade.php
- product-modal.js
- qris modal
- qris.js
- WhatsApp order
- config/menu.php
- config/business.php
- floating WhatsApp
- per-item QRIS fee
- order database
- existing menu/catalog.

Gunakan semua yang sudah ada.

Jangan membuat versi kedua dari fitur-fitur tersebut.

Audit terlebih dahulu lalu extend/refactor jika diperlukan.

==================================================
Z. HASIL AKHIR YANG SAYA INGINKAN
==================================================

Saya ingin Mahligai Bakery mempunyai alur seperti ini:

CUSTOMER

Login dengan nama
↓
Landing page / menu bakery
↓
Pilih produk
↓
Cart
↓
Checkout
↓
Data diri
↓
Tanggal & jam pengambilan
↓
Request bakery
↓
QRIS / WhatsApp
↓
Konfirmasi
↓
Animasi berhasil SweetAlert2
↓
Struk digital
↓
Pesanan Saya
↓
Melihat status pesanan
↓
Melihat kapan membeli
↓
Melihat kapan diambil
↓
Melihat total
↓
Melihat status pembayaran
↓
Chat Admin / WhatsApp


ADMIN

Login:
username admin
password sesuai credential admin yang saya tentukan
↓
Admin Dashboard
↓
Notifikasi pesanan baru
↓
Melihat semua pesanan
↓
Melihat nomor urut pelanggan
↓
Melihat nama pelanggan
↓
Melihat produk
↓
Melihat total
↓
Melihat jam/tanggal pembelian
↓
Melihat tanggal/jam pengambilan
↓
Melihat request bakery
↓
Melihat status pembayaran
↓
Mengubah status pesanan
↓
Chat dengan pelanggan
↓
Notifikasi sinkron
↓
Edit Profil Admin


DESAIN

- modern
- profesional
- bakery premium
- hijau Mahligai Bakery
- clean
- smooth
- tidak terlalu banyak animasi
- responsive
- checkout dapat di-scroll
- tombol konfirmasi tidak menutupi konten
- tombol X modal berfungsi
- SweetAlert2 success
- receipt digital
- notification badge
- chat UI modern
- admin dashboard profesional.

==================================================
LANGKAH KERJA
==================================================

Jangan langsung mengubah kode.

Tahap 1:
Audit project dan buat PLAN lengkap.

Tunjukkan:
1. struktur existing yang akan dipakai
2. file yang akan diubah
3. file baru yang benar-benar diperlukan
4. migration yang diperlukan
5. model yang diperlukan
6. controller
7. routes
8. middleware/auth
9. service/helper
10. Blade
11. JavaScript
12. CSS
13. testing
14. urutan implementasi
15. risiko konflik dengan kode existing.

Jangan menghapus implementasi existing tanpa alasan.

Setelah plan selesai, BERHENTI dan tunggu persetujuan saya sebelum melakukan Build.