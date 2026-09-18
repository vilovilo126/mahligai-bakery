Saya ingin melakukan perbaikan dan pengembangan pada sistem Menu dan pemesanan website Mahligai Bakery berdasarkan tampilan website yang sudah ada.

JANGAN menghapus fitur yang sudah berjalan. Periksa terlebih dahulu struktur project dan kode yang sudah ada, kemudian lakukan perubahan hanya pada bagian yang diperlukan.

==================================================
1. PERBAIKI POSISI DETAIL MENU / MODAL
==================================================

Saat pelanggan mengklik menu, produk, varian, harga, atau bagian yang dapat membuka detail produk, saya ingin tampilan detail tersebut muncul di TENGAH-TENGAH LAYAR.

Saat ini modal/detail produk terlihat terlalu berada di sebelah kiri seperti pada tampilan sebelumnya. Perbaiki posisi tersebut.

Ketentuannya:

- Modal harus berada tepat di tengah viewport secara horizontal dan vertikal.
- Gunakan layout yang responsive.
- Pada desktop, modal berada di tengah layar.
- Pada laptop, tablet, dan mobile, modal tetap berada di tengah dan tidak keluar dari layar.
- Jika isi modal panjang, bagian isi modal dapat di-scroll tanpa membuat posisi modal menjadi aneh.
- Background halaman di belakang modal tetap menggunakan overlay.
- Gunakan animasi masuk yang halus seperti fade + scale.
- Gunakan animasi keluar yang halus.
- Klik tombol X harus menutup modal.
- Klik area overlay dapat menutup modal jika sesuai dengan struktur aplikasi.
- Pastikan modal tidak tertutup di belakang navbar atau elemen lain.
- Pastikan z-index modal benar.
- Jangan membuat modal menempel di sisi kiri seperti tampilan sebelumnya.

Hal ini berlaku untuk semua detail produk, bukan hanya Roti Sisir.

==================================================
2. SISTEM PEMESANAN PRODUK
==================================================

Saya ingin website tidak hanya menampilkan katalog, tetapi juga dapat digunakan pelanggan untuk melakukan pemesanan.

Ketika pelanggan memilih sebuah produk, pelanggan dapat melihat:

- Nama produk
- Varian
- Harga
- Jumlah
- Paket jika tersedia
- Additional jika tersedia
- Total harga
- Pilihan metode pembayaran

Buat alur pemesanan yang sederhana dan mudah dipahami.

Contoh alur:

Pelanggan
↓
Pilih Menu
↓
Pilih Varian
↓
Pilih Paket jika tersedia
↓
Pilih Additional jika diperlukan
↓
Tentukan jumlah
↓
Lihat ringkasan pesanan
↓
Total harga
↓
Pilih metode pembayaran
↓
Konfirmasi pesanan

Jangan membuat sistem checkout yang terlalu rumit.

==================================================
3. ADDITIONAL OTOMATIS MASUK KE PESANAN
==================================================

Jika pelanggan memilih Additional, Additional tersebut harus otomatis masuk ke daftar pesanan pelanggan.

Contohnya:

Produk:
Roti Unyil Aneka Rasa

Paket:
Paket Isi 25 PCS
Rp72.500

Additional:
Kartu Ucapan
+Rp5.000

Hampers
+Rp7.000

Maka sistem harus menyimpan/menghasilkan detail pesanan:

Roti Unyil Aneka Rasa
Paket Isi 25 PCS

Additional:
- Kartu Ucapan
- Hampers

Total:
Rp84.500

Jangan hanya menampilkan Additional di halaman. Additional yang dipilih harus menjadi bagian dari data/order pelanggan.

==================================================
4. DAFTAR PELANGGAN / DAFTAR PESANAN
==================================================

Ketika pelanggan melakukan pemesanan, data pesanan harus masuk ke daftar pelanggan/order yang dapat digunakan oleh admin.

Admin harus dapat mengetahui:

- Nama pelanggan
- Nomor WhatsApp pelanggan
- Produk yang dipesan
- Varian
- Paket
- Additional
- Jumlah
- Harga produk
- Biaya Additional
- Biaya QRIS jika ada
- Total pembayaran
- Metode pembayaran
- Status pesanan
- Status pembayaran
- Waktu pemesanan

Jika struktur database belum memiliki tabel order/pesanan, buat struktur Laravel yang sesuai menggunakan:

- Migration
- Model
- Controller
- Route
- Validation

Jangan membuat tabel database secara manual melalui phpMyAdmin.

Gunakan database Laravel secara benar.

Jika sudah ada struktur customer/order/pesanan, gunakan dan kembangkan struktur yang sudah ada daripada membuat tabel duplikat.

==================================================
5. STATUS PESANAN
==================================================

Buat status pesanan yang jelas sehingga admin dapat mengetahui kondisi pesanan.

Contoh status:

- Menunggu Pembayaran
- Pembayaran Diproses
- Pembayaran Berhasil
- Pesanan Diproses
- Pesanan Siap
- Pesanan Selesai
- Pesanan Dibatalkan

Gunakan struktur yang mudah dikembangkan.

Jangan menghapus status yang sudah ada jika project sudah memiliki status sendiri. Sesuaikan dengan struktur yang ditemukan saat pemeriksaan project.

==================================================
6. PEMBAYARAN QRIS
==================================================

Tambahkan metode pembayaran:

QRIS

Jika pelanggan memilih pembayaran QRIS, pelanggan TIDAK BOLEH dipaksa login terlebih dahulu hanya untuk melihat atau melakukan pembayaran QRIS.

Halaman QRIS harus dapat diakses oleh pelanggan tanpa login jika memang halaman tersebut sebelumnya meminta login.

Perbaiki alur agar:

Pelanggan
↓
Memilih QRIS
↓
Melihat halaman/modal QRIS
↓
Melihat QRIS yang tersedia
↓
Melakukan pembayaran
↓
Melanjutkan konfirmasi pembayaran

QRIS harus dapat ditampilkan secara langsung kepada pelanggan.

Jika saat ini QRIS berada di halaman yang membutuhkan autentikasi/login, pisahkan akses QRIS pelanggan dari halaman admin sehingga pelanggan tidak perlu login untuk melihat QRIS.

==================================================
7. BIAYA QRIS BERDASARKAN MASING-MASING MENU
==================================================

Biaya QRIS TIDAK sama untuk semua menu.

Setiap produk/menu dapat memiliki biaya QRIS masing-masing.

Contohnya:

Roti Unyil
Harga: Rp30.000
Biaya QRIS: sesuai pengaturan produk

Roti Sisir
Harga: Rp58.000
Biaya QRIS: sesuai pengaturan produk

Regular Bread
Harga: Rp15.000
Biaya QRIS: sesuai pengaturan produk

Sistem harus mengambil biaya QRIS berdasarkan produk/menu yang dipilih pelanggan.

Jangan menggunakan satu biaya QRIS global untuk seluruh produk.

Jika pelanggan memilih beberapa produk sekaligus dan masing-masing produk memiliki biaya QRIS berbeda, sistem harus menghitung biaya QRIS sesuai aturan yang telah ditentukan pada masing-masing produk.

Biaya QRIS harus menjadi bagian dari perhitungan total pembayaran.

Contoh:

Produk:
Roti Sisir Premium
Rp68.000

Additional:
Kartu Ucapan
+Rp5.000

Subtotal:
Rp73.000

Biaya QRIS:
RpX

Total:
Rp73.000 + RpX

Nilai RpX harus otomatis diambil dari data produk/paket/varian yang dipilih.

JANGAN menentukan nominal biaya QRIS sendiri.

==================================================
8. BIAYA QRIS PADA PRODUK, VARIAN, ATAU PAKET
==================================================

Perhatikan bahwa menu Mahligai Bakery memiliki:

- Produk
- Varian
- Paket
- Additional

Beberapa menu mempunyai paket dengan harga yang berbeda.

Contoh Roti Unyil:

Paket Isi 3 PCS
Rp9.000

Paket Isi 10 PCS
Rp30.000

Paket Isi 15 PCS
Rp44.500

Paket Isi 18 PCS
Rp52.500

Paket Isi 25 PCS
Rp72.500

Paket Isi 30 PCS
Rp87.000

Paket Isi 50 PCS
Rp143.000

Jika biaya QRIS dapat berbeda berdasarkan paket, sistem harus mendukung biaya QRIS berdasarkan paket yang dipilih.

Begitu juga dengan Roti Sisir.

Jika biaya QRIS berbeda berdasarkan:

- Produk
- Varian
- Paket

maka gunakan struktur data yang paling sesuai agar biaya QRIS dapat ditentukan secara spesifik.

Jangan mengasumsikan bahwa semua varian atau paket memiliki biaya QRIS yang sama.

Saya akan menentukan nominal biaya QRIS masing-masing menu/paket/varian nantinya.

==================================================
9. PENGELOLAAN BIAYA QRIS
==================================================

Jika struktur database Product sudah tersedia, tambahkan field atau struktur yang diperlukan untuk menyimpan biaya QRIS masing-masing produk.

Contoh konsep:

qris_fee

atau gunakan struktur database yang lebih sesuai dengan project yang sudah ada.

Tentukan tipe data yang aman untuk nilai uang.

Jika biaya QRIS menggunakan nominal tetap, simpan sebagai nominal.

Jika produk tidak memiliki biaya QRIS, nilai dapat dibuat 0/null sesuai kebutuhan sistem.

Jangan membuat biaya QRIS secara hardcoded di JavaScript.

Backend Laravel harus menghitung ulang biaya QRIS berdasarkan data produk dari database.

Frontend hanya menampilkan hasil perhitungan.

Jika biaya QRIS perlu berbeda untuk setiap paket/varian, buat struktur database yang memungkinkan pengaturan tersebut.

==================================================
10. ADMIN - PENGATURAN BIAYA QRIS
==================================================

Jika terdapat halaman admin untuk mengelola produk, tambahkan pengaturan:

Biaya QRIS

sehingga admin nantinya dapat menentukan biaya QRIS untuk masing-masing menu/paket/varian.

Contoh:

Nama:
Roti Sisir Premium

Harga:
Rp68.000

Biaya QRIS:
RpX

Simpan.

Ketika pelanggan memilih produk tersebut, sistem otomatis menggunakan biaya QRIS yang sudah disimpan.

Saya harus dapat mengubah biaya QRIS tanpa harus mengubah banyak file kode.

==================================================
11. HALAMAN / MODAL QRIS
==================================================

Buat tampilan QRIS yang profesional.

Tampilkan:

- Judul Pembayaran QRIS
- Gambar QRIS
- Total yang harus dibayar
- Biaya QRIS jika ada
- Total akhir
- Instruksi pembayaran
- Tombol kembali
- Tombol konfirmasi pembayaran

Untuk gambar QRIS, jangan membuat QRIS palsu dan jangan menggunakan QRIS random dari internet.

Siapkan placeholder atau struktur gambar yang nantinya dapat saya ganti sendiri.

Gunakan folder gambar yang sudah tersedia atau buat struktur seperti:

public/images/payment/

Saya akan memasukkan gambar QRIS asli sendiri nanti.

==================================================
12. RINGKASAN PEMBAYARAN
==================================================

Pada saat pelanggan memilih QRIS, tampilkan:

RINGKASAN PESANAN

Nama Pelanggan
Nomor WhatsApp

Produk
Varian/Paket
Jumlah

Additional:
- ...

Subtotal
Biaya Additional
Biaya QRIS
Total Pembayaran

Metode Pembayaran:
QRIS

Contoh:

ROTI SISIR PREMIUM
Paket: 5 PCS

Harga:
Rp68.000

Additional:
Kartu Ucapan +Rp5.000

Subtotal:
Rp73.000

Biaya QRIS:
RpX

TOTAL:
Rp73.000 + RpX

Nilai RpX harus otomatis diambil dari konfigurasi/data produk atau paket yang dipilih.

Jangan meminta pelanggan memasukkan biaya QRIS sendiri.

==================================================
13. NOMOR WHATSAPP MAHLIGAI BAKERY
==================================================

Gunakan nomor WhatsApp Mahligai Bakery berikut:

08113996988

Untuk link WhatsApp gunakan format internasional:

628113996988

Jangan menggunakan nomor dengan format yang salah pada URL WhatsApp.

Jangan menaruh nomor WhatsApp hardcoded di banyak file.

Simpan nomor WhatsApp dalam konfigurasi atau satu tempat yang mudah diubah.

Jika nomor berubah nantinya, cukup ubah satu tempat.

==================================================
14. TOMBOL "VIEW W.A"
==================================================

Jika terdapat tombol:

"View W.A"

maka tombol tersebut harus langsung mengarah ke WhatsApp Mahligai Bakery menggunakan nomor:

08113996988

Ketika pelanggan mengklik tombol tersebut:

- WhatsApp terbuka
- Nomor Mahligai Bakery menjadi tujuan
- Siapkan pesan otomatis/prefilled message
- Pesan dapat berisi konteks bahwa pelanggan ingin memesan

Contoh:

"Halo Mahligai Bakery, saya ingin memesan produk bakery. Mohon informasi lebih lanjut mengenai ketersediaan dan pemesanannya."

Jika sistem sudah memiliki informasi produk yang sedang dilihat, masukkan nama produk ke pesan otomatis.

Contoh:

"Halo Mahligai Bakery, saya ingin memesan Roti Sisir varian Tiramisu Crunchy. Mohon informasi mengenai ketersediaannya."

==================================================
15. GANTI FLOATING GEMINI MENJADI WHATSAPP
==================================================

Saat ini di bagian kanan bawah website terdapat tombol/logo Gemini.

Saya ingin tombol tersebut DIGANTI menjadi tombol/logo WhatsApp.

Jangan lagi menggunakan logo Gemini sebagai floating button di bagian kanan bawah.

Floating button baru:

- Menggunakan icon WhatsApp
- Berwarna sesuai identitas WhatsApp
- Tetap terlihat profesional dengan tema Mahligai Bakery
- Posisi kanan bawah
- Responsive
- Memiliki hover effect
- Memiliki tooltip seperti "Chat WhatsApp"
- Ketika diklik langsung membuka WhatsApp Mahligai Bakery
- Menggunakan nomor 08113996988 / 628113996988

Jika AI Chatbot Gemini masih digunakan di sistem, JANGAN menghapus backend Gemini atau fitur AI lainnya.

Yang diganti hanya floating button Gemini yang berada di kanan bawah.

==================================================
16. ADMIN DAPAT MENGHUBUNGI PELANGGAN
==================================================

Pada daftar pesanan pelanggan, jika terdapat nomor WhatsApp pelanggan, sediakan tombol:

"Hubungi via WhatsApp"

Ketika admin mengklik tombol tersebut, buka WhatsApp dengan nomor pelanggan yang tersimpan.

Jika memungkinkan, sertakan pesan otomatis berdasarkan pesanan.

Contoh:

"Halo Kak, kami dari Mahligai Bakery. Kami ingin mengonfirmasi pesanan Kakak: Roti Sisir Premium, 5 pcs. Terima kasih."

Pastikan nomor pelanggan divalidasi dan diformat dengan benar sebelum digunakan sebagai WhatsApp URL.

==================================================
17. VALIDASI PESANAN
==================================================

Pastikan sistem melakukan validasi sebelum pesanan disimpan.

Minimal validasi:

- Nama pelanggan wajib diisi
- Nomor WhatsApp wajib diisi
- Produk wajib dipilih
- Jumlah harus valid
- Varian harus valid jika produk memiliki varian
- Paket harus valid jika produk memiliki paket
- Additional harus berasal dari Additional yang tersedia
- Harga dihitung dari data sistem
- Biaya QRIS dihitung dari data sistem
- Total dihitung oleh backend

Jangan mempercayai total harga yang dikirim langsung dari frontend.

Backend Laravel harus menghitung ulang:

- Harga produk
- Harga paket
- Harga additional
- Biaya QRIS
- Total pembayaran

Hal ini untuk mencegah manipulasi harga dari browser.

==================================================
18. DATA MENU MAHLIGAI BAKERY
==================================================

Gunakan data menu Mahligai Bakery yang sudah dibuat sebelumnya:

1. Roti Unyil Aneka Rasa
2. Roti Sisir
3. Aneka Roti / Regular Bread
4. Roti Tawar dan produk terkait

Jangan menghapus data menu tersebut.

Jika menu saat ini menggunakan config/menu.php sesuai implementasi sebelumnya, pertahankan struktur tersebut jika masih sesuai.

Jika sistem pemesanan membutuhkan data database, buat integrasi yang rapi tanpa membuat data menu menjadi duplikat.

Periksa terlebih dahulu apakah:

- Product Model
- Category Model
- products table
- categories table
- config/menu.php

sudah digunakan.

Gunakan struktur yang paling aman berdasarkan kondisi project sebenarnya.

==================================================
19. GAMBAR PRODUK DAN QRIS
==================================================

Saya akan memasukkan foto produk sendiri.

Jangan:

- Membuat gambar produk random
- Mengambil gambar dari internet
- Menggunakan gambar AI
- Menghapus gambar yang sudah saya siapkan

Gunakan struktur gambar yang sudah tersedia seperti:

- gallery
- avatar
- products

atau folder gambar yang sesuai dengan project.

Untuk QRIS gunakan placeholder/struktur gambar saja karena saya akan memasukkan QRIS asli sendiri.

==================================================
20. DESAIN UI
==================================================

Pertahankan identitas Mahligai Bakery:

- Hijau muda
- Hijau tua
- Putih
- Cream
- Elegan
- Modern
- Bersih
- Profesional

Gunakan:

- Rounded card
- Soft shadow
- Border halus
- Hover effect
- Smooth transition
- Modal animation
- Responsive layout
- Typography yang nyaman dibaca

Jangan membuat tampilan terlalu ramai.

Prioritaskan pengalaman pengguna.

==================================================
21. RESPONSIVE
==================================================

Pastikan semua fitur bekerja dengan baik pada:

- Desktop
- Laptop
- Tablet
- Smartphone

Khusus modal produk dan QRIS:

- Tidak keluar dari viewport
- Tidak terpotong
- Bisa scroll jika kontennya panjang
- Tetap berada di tengah
- Tombol mudah ditekan pada mobile

==================================================
22. KEAMANAN API GEMINI
==================================================

Jika Gemini masih digunakan, jangan pernah menaruh API Key Gemini secara langsung di:

- JavaScript frontend
- HTML
- Blade
- public folder
- source code yang dapat diakses browser

Gunakan `.env`, misalnya:

GEMINI_API_KEY=

API Key hanya digunakan melalui backend Laravel.

Jangan menampilkan API Key asli dalam dokumentasi atau output.

==================================================
23. PERIKSA PROJECT SEBELUM IMPLEMENTASI
==================================================

Sebelum mengubah file:

1. Periksa struktur project.
2. Periksa routes/web.php.
3. Periksa Controller.
4. Periksa Model.
5. Periksa Migration.
6. Periksa config/menu.php.
7. Periksa resources/views.
8. Periksa JavaScript Menu.
9. Periksa product-modal.js.
10. Periksa CSS yang digunakan.
11. Periksa sistem Gemini.
12. Periksa apakah sudah ada sistem customer/order/pesanan/payment.
13. Gunakan kembali kode yang sudah ada jika memungkinkan.
14. Jangan membuat file duplikat.
15. Jangan menghapus fitur yang tidak berhubungan.

Jika perlu membuat file baru, gunakan struktur Laravel yang benar.

Jika perlu migration, buat migration melalui Artisan.

==================================================
24. DATABASE
==================================================

Jika diperlukan perubahan database:

- Buat migration Laravel.
- Jangan mengubah database secara manual melalui phpMyAdmin.
- Pastikan migration aman.
- Gunakan Model Laravel.
- Gunakan relationship jika diperlukan.
- Jangan membuat tabel duplikat.
- Periksa migration yang sudah ada sebelum membuat migration baru.

Jika sistem membutuhkan:

- orders
- order_items
- customers
- payments

atau tabel terkait lainnya, buat berdasarkan kebutuhan struktur project yang sudah ada.

Pastikan satu pesanan dapat memiliki beberapa produk jika sistem memang mendukung keranjang/lebih dari satu produk.

==================================================
25. TESTING
==================================================

Setelah implementasi selesai, lakukan pengecekan/test terhadap:

- Modal produk berada di tengah
- Produk dapat diklik
- Varian dapat dipilih
- Paket dapat dipilih
- Additional dapat dipilih
- Additional masuk ke order
- Biaya QRIS sesuai produk/paket/varian
- Total harga dihitung benar
- Pesanan masuk ke daftar pelanggan/order
- QRIS dapat dibuka tanpa login pelanggan
- QRIS menampilkan total pembayaran
- Biaya QRIS dihitung dengan benar
- WhatsApp View W.A berfungsi
- Floating button WhatsApp berfungsi
- Admin dapat menghubungi pelanggan melalui WhatsApp
- Responsive mobile
- Responsive desktop
- Tidak ada error JavaScript
- Tidak ada error Laravel
- Tidak ada broken route
- Tidak ada API Key yang terekspos

Jika terdapat test yang sudah tersedia, jalankan test tersebut dan perbaiki error yang muncul akibat perubahan.

==================================================
26. HASIL AKHIR
==================================================

Tujuan akhir saya:

Website Mahligai Bakery harus berubah dari sekadar katalog menjadi katalog + sistem pemesanan sederhana.

PELANGGAN:

Melihat menu
↓
Klik produk
↓
Detail muncul tepat di tengah
↓
Memilih varian
↓
Memilih paket
↓
Memilih Additional
↓
Melihat subtotal
↓
Melihat biaya QRIS sesuai menu/paket
↓
Melihat total
↓
Memilih QRIS
↓
Melihat QRIS tanpa harus login
↓
Melakukan pembayaran
↓
Mengonfirmasi pembayaran
↓
Dapat menghubungi Mahligai Bakery melalui WhatsApp

ADMIN:

Melihat daftar pelanggan/pesanan
↓
Melihat detail pesanan
↓
Melihat produk
↓
Melihat varian
↓
Melihat paket
↓
Melihat Additional
↓
Melihat biaya QRIS
↓
Melihat total
↓
Melihat status pembayaran
↓
Menghubungi pelanggan melalui WhatsApp

Jangan hanya membuat tampilan visual.

Pastikan alur:

Frontend
↓
JavaScript
↓
Laravel Route
↓
Controller
↓
Model
↓
Database

benar-benar terhubung.

==================================================
27. DOKUMENTASI SETELAH SELESAI
==================================================

Setelah seluruh implementasi selesai, berikan dokumentasi lengkap kepada saya.

Jelaskan:

1. File yang dibuat.
2. File yang diubah.
3. Folder yang digunakan.
4. Migration yang dibuat.
5. Model yang dibuat/diubah.
6. Controller yang dibuat/diubah.
7. Route yang dibuat/diubah.
8. JavaScript yang dibuat/diubah.
9. CSS yang dibuat/diubah.
10. View/Blade yang dibuat/diubah.
11. Database yang berubah.
12. Relationship database.
13. Alur pemesanan.
14. Alur Additional.
15. Alur perhitungan harga.
16. Alur biaya QRIS per menu.
17. Alur pembayaran QRIS.
18. Alur WhatsApp pelanggan.
19. Alur WhatsApp admin.
20. Cara mengganti gambar produk.
21. Cara mengganti gambar QRIS.
22. Cara mengganti nomor WhatsApp.
23. Cara mengubah biaya QRIS masing-masing menu/paket/varian.
24. Cara menjalankan migration.
25. Cara menjalankan project.
26. Test yang sudah dilakukan.
27. Error yang ditemukan dan cara memperbaikinya jika ada.

Jika membuat file baru, jelaskan juga:

NAMA FILE
↓
LOKASI FOLDER
↓
KEGUNAAN FILE
↓
ISI/FUNGSI UTAMA FILE
↓
FILE LAIN YANG TERHUBUNG

Saya ingin dokumentasi tersebut lengkap sehingga saya dapat memahami struktur project Mahligai Bakery tanpa harus menebak-nebak fungsi setiap file.

==================================================
28. ATURAN PENTING
==================================================

- Jangan menghapus fitur yang masih digunakan.
- Jangan membuat file duplikat.
- Jangan membuat data menu duplikat.
- Jangan mengarang nominal biaya QRIS.
- Jangan mengarang QRIS.
- Jangan mengarang gambar produk.
- Jangan mengekspos API Key.
- Jangan hardcode biaya QRIS di frontend.
- Jangan hardcode nomor WhatsApp di banyak file.
- Jangan meminta pelanggan login hanya untuk membuka QRIS.
- Jangan menghitung total hanya dari frontend.
- Backend harus melakukan validasi dan perhitungan ulang.
- Pertahankan desain Mahligai Bakery yang sudah ada.
- Gunakan struktur project yang sudah tersedia jika memungkinkan.
- Sebelum membuat perubahan, periksa kode yang sudah ada.
- Jika ada beberapa cara implementasi, pilih cara yang paling aman dan sesuai dengan struktur Laravel project ini.

Jangan menentukan nominal biaya QRIS sendiri.

Biaya QRIS akan saya tentukan untuk masing-masing menu, varian, atau paket nantinya.