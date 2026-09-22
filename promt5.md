Saya ingin memperbaiki dan menyempurnakan fitur Data Diri & Pembayaran pada website Mahligai Bakery berdasarkan tampilan yang sedang digunakan saat ini.

Perhatikan seluruh alur pemesanan dan pembayaran yang sudah ada. Jangan membuat sistem baru yang terpisah dari sistem existing. Perbaiki dan integrasikan fitur yang sudah ada.

1. PERBAIKI PERHITUNGAN TOTAL PEMBAYARAN

Pada modal "Data Diri & Pembayaran", saat ini:
- Subtotal masih menampilkan Rp0.
- Biaya QRIS masih menampilkan Rp0.
- Total Pembayaran masih menampilkan Rp0.

Perbaiki agar seluruh nominal otomatis mengambil data dari produk/menu yang benar-benar dipilih pelanggan.

Alurnya harus seperti berikut:

Produk/Menu dipilih
→ harga produk terbaca
→ jumlah produk terbaca
→ subtotal dihitung
→ jika metode pembayaran QRIS dipilih, biaya QRIS dihitung sesuai aturan yang sudah ditentukan
→ total pembayaran = subtotal + biaya QRIS
→ semua nominal ditampilkan secara real-time pada modal pembayaran.

Jangan pernah menampilkan Rp0 jika pelanggan sudah memiliki produk yang dipilih.

Gunakan format Rupiah yang konsisten, contoh:
Rp14.000
Rp30.000
Rp52.500

Pastikan perhitungan menggunakan angka/decimal yang benar dan bukan perhitungan berdasarkan string harga yang dapat menyebabkan hasil salah.

2. BIAYA QRIS

Biaya QRIS harus dihitung berdasarkan menu/pesanan sesuai konfigurasi yang sudah dibuat sebelumnya.

Jangan membuat satu biaya QRIS global jika sistem memang sudah mendukung biaya berbeda berdasarkan menu.

Pastikan:
- Pembayaran WhatsApp tidak dikenakan biaya QRIS.
- Pembayaran QRIS mendapatkan biaya QRIS sesuai aturan menu/pesanan.
- Biaya QRIS ditampilkan secara terpisah pada bagian "Biaya QRIS".
- Total pembayaran otomatis berubah ketika pelanggan mengganti metode pembayaran.

Jika biaya QRIS belum mempunyai struktur yang jelas di database/config, periksa implementasi existing terlebih dahulu dan gunakan struktur yang paling sesuai dengan project tanpa membuat data duplikat.

3. PERBAIKI DESAIN MODAL PEMBAYARAN

Rapikan desain modal "Data Diri & Pembayaran" agar terlihat lebih profesional, modern, bersih, dan nyaman digunakan.

Pertahankan konsep warna Mahligai Bakery:
- hijau muda
- hijau tua
- putih/cream
- gunakan warna secara konsisten.

Perbaiki:
- spacing antar field
- ukuran typography
- alignment
- ukuran tombol
- radio button metode pembayaran
- bagian ringkasan pembayaran
- subtotal
- biaya QRIS
- total pembayaran.

Bagian "Total Pembayaran" harus dibuat paling menonjol karena merupakan informasi utama bagi pelanggan.

Jangan membuat modal terlalu besar atau terlalu kecil.

Modal harus tetap:
- responsive desktop
- responsive laptop
- responsive tablet
- responsive mobile.

Pastikan isi modal tidak terpotong dan dapat di-scroll jika kontennya lebih panjang.

4. LOGO QRIS

Pada pilihan metode pembayaran QRIS, jangan hanya menggunakan icon kotak/generic icon.

Gunakan tampilan/logo yang secara visual jelas menunjukkan bahwa pilihan tersebut adalah QRIS.

Jika project sudah memiliki asset/logo QRIS, gunakan asset tersebut.

Jika belum ada asset QRIS, buat struktur asset yang jelas sehingga saya dapat mengganti file logo QRIS sendiri nanti.

Contoh lokasi:
public/images/payment/qris.png

Jangan menggunakan logo palsu atau membuat tulisan QRIS yang menyerupai logo resmi jika asset resmi belum tersedia.

Tampilan pilihan pembayaran harus jelas:

[ Logo QRIS ] QRIS

dan

[ Logo WhatsApp ] WhatsApp

5. WHATSAPP HARUS DISTABILKAN

Perbaiki seluruh integrasi WhatsApp agar konsisten dan tidak menghasilkan link yang salah.

Nomor WhatsApp Mahligai Bakery:
08113996988

Gunakan format nomor internasional yang benar untuk WhatsApp ketika membuat URL.

Saat pelanggan memilih WhatsApp sebagai metode pembayaran/pemesanan:
- sistem tidak mengarah ke nomor yang salah
- sistem tidak menghasilkan URL rusak
- sistem langsung membuka WhatsApp
- pesan WhatsApp sudah otomatis terisi.

Pesan otomatis harus berisi informasi pesanan, minimal:
- nama pelanggan
- nomor WhatsApp pelanggan
- daftar menu yang dipesan
- jumlah masing-masing menu
- subtotal
- metode pembayaran
- biaya QRIS jika ada
- total pembayaran.

Contoh format pesan:

Halo Mahligai Bakery,

Saya ingin melakukan pemesanan.

Nama:
[namapelanggan]

Nomor WhatsApp:
[nomor pelanggan]

Pesanan:
- [Nama Produk] x [Jumlah] = Rp[Harga]
- [Nama Produk] x [Jumlah] = Rp[Harga]

Subtotal: Rp[Subtotal]
Metode Pembayaran: WhatsApp
Biaya QRIS: Rp0
Total: Rp[Total]

Terima kasih.

Jangan hardcode pesan hanya untuk satu produk. Pesan harus dibuat secara dinamis berdasarkan isi keranjang/pesanan pelanggan.

6. HASIL PEMBAYARAN HARUS TERHUBUNG DENGAN PESANAN

Setelah pelanggan menekan "Konfirmasi Pesanan", data pesanan harus benar-benar tersimpan dan terhubung dengan data pelanggan.

Pastikan hubungan berikut berjalan:

Pelanggan
→ memilih menu
→ memilih jumlah
→ melihat total
→ mengisi data diri
→ memilih metode pembayaran
→ konfirmasi pesanan
→ order tersimpan
→ status pembayaran tersimpan
→ pelanggan diarahkan ke proses pembayaran yang sesuai.

Jangan hanya menampilkan notifikasi sukses tanpa menyimpan data order.

Pastikan data yang tersimpan minimal memiliki:
- nama pelanggan
- nomor WhatsApp
- daftar pesanan
- subtotal
- biaya QRIS
- total pembayaran
- metode pembayaran
- status order
- status pembayaran
- waktu pemesanan.

Gunakan database/model/controller/service/request yang sudah ada jika tersedia.

Jangan membuat tabel atau model duplikat jika fitur order sudah pernah dibuat.

7. ALUR QRIS

Jika pelanggan memilih QRIS:

Pilih produk
→ Data Diri & Pembayaran
→ pilih QRIS
→ sistem menghitung subtotal
→ sistem menghitung biaya QRIS
→ sistem menghitung total
→ klik "Konfirmasi Pesanan"
→ order disimpan
→ tampilkan halaman/modal pembayaran QRIS
→ tampilkan nominal pembayaran yang BENAR
→ tampilkan QRIS yang tersedia
→ pelanggan melakukan pembayaran
→ sistem memiliki status pembayaran yang terhubung dengan order.

Nominal pada QRIS harus sama dengan:
TOTAL PEMBAYARAN

Jangan sampai:
- modal menampilkan Rp52.500
- tetapi halaman QRIS menampilkan Rp0
- atau nominal QRIS berbeda dari total order.

8. STATUS PEMBAYARAN

Buat alur status yang jelas, misalnya:

Menunggu Pembayaran
→ Pembayaran Diproses
→ Pembayaran Berhasil

Jika project belum memiliki payment gateway/verifikasi otomatis, jangan berpura-pura bahwa pembayaran sudah terverifikasi secara otomatis.

Gunakan status "Menunggu Pembayaran" sampai ada mekanisme verifikasi yang benar.

9. SETELAH PEMBAYARAN / KONFIRMASI

Setelah order berhasil dibuat, pelanggan harus mendapatkan informasi yang jelas mengenai:
- nomor/order ID
- daftar pesanan
- total pembayaran
- metode pembayaran
- status pembayaran.

Jika pembayaran menggunakan WhatsApp, arahkan pelanggan ke WhatsApp Mahligai Bakery dengan pesan order otomatis.

Jika pembayaran menggunakan QRIS, arahkan pelanggan ke tampilan QRIS dengan nominal total yang benar.

10. TOMBOL VIEW W.A

Perbaiki tombol "View W.A" yang sudah ada.

Ketika diklik:
→ langsung membuka WhatsApp Mahligai Bakery
→ menggunakan nomor 08113996988
→ menggunakan format nomor internasional WhatsApp
→ jika berasal dari produk/order tertentu, sertakan informasi produk/order pada pesan otomatis.

Jangan mengarahkan pelanggan ke halaman login terlebih dahulu hanya untuk membuka WhatsApp.

11. ICON DI POJOK KANAN BAWAH

Icon chatbot Gemini yang sebelumnya berada di kanan bawah website ingin diganti menjadi icon WhatsApp.

Icon tersebut harus:
- menggunakan icon WhatsApp yang jelas
- tetap berada di kanan bawah
- responsive
- tidak menutupi tombol penting
- memiliki hover effect yang halus
- ketika diklik langsung membuka WhatsApp Mahligai Bakery.

Nomor:
08113996988

Gunakan pesan default seperti:

"Halo Mahligai Bakery, saya ingin bertanya mengenai produk dan pemesanan."

Jika fitur Gemini masih digunakan di backend, jangan hapus backend Gemini tanpa alasan. Yang diubah hanya tombol/floating action pada tampilan website jika memang itu yang diminta.

12. VALIDASI

Tambahkan validasi untuk:
- Nama wajib diisi.
- Nomor WhatsApp wajib diisi.
- Nomor WhatsApp harus memiliki format yang valid.
- Minimal harus ada produk yang dipesan.
- Jumlah produk harus valid.
- Metode pembayaran wajib dipilih.

Tampilkan pesan error yang jelas dan profesional.

13. CEK SELURUH DATA PESANAN

Sebelum selesai, periksa seluruh alur dari:
- menu
- product detail
- paket
- tambahan/additional
- cart/order
- Data Diri & Pembayaran
- QRIS
- WhatsApp
- database
- controller
- service
- request
- JavaScript
- route
- view Blade
- CSS.

Pastikan semuanya menggunakan sumber data yang sama dan tidak ada perhitungan yang berdiri sendiri.

14. JANGAN MERUSAK FITUR EXISTING

PENTING:

Jangan menghapus fitur existing yang tidak berkaitan dengan perubahan ini.

Jangan membuat:
- model duplikat
- controller duplikat
- migration duplikat
- route duplikat
- JavaScript duplikat
- sistem order kedua.

Sebelum membuat file baru, periksa terlebih dahulu apakah file/fungsi tersebut sudah tersedia.

15. TESTING

Setelah implementasi:
- jalankan migration jika memang diperlukan
- jalankan test
- periksa route
- periksa console JavaScript
- periksa Laravel log
- test pemesanan beberapa produk
- test satu produk
- test beberapa jumlah produk
- test QRIS
- test WhatsApp
- test perubahan metode pembayaran
- test perhitungan total
- test responsive mobile.

Contoh yang wajib diuji:

Produk Rp14.000 x 1
→ subtotal harus Rp14.000

Produk Rp14.000 x 2
→ subtotal harus Rp28.000

Produk Rp14.000 x 2 + produk Rp30.000 x 1
→ subtotal harus Rp58.000

Kemudian jika QRIS dipilih:
→ biaya QRIS ditambahkan sesuai konfigurasi
→ total harus berubah secara otomatis.

Jangan menggunakan angka contoh tersebut sebagai data permanen. Gunakan data produk sebenarnya dari project.

16. HASIL AKHIR

Setelah selesai, jangan hanya mengatakan "selesai".

Berikan dokumentasi:
- file yang dibuat
- file yang diubah
- folder masing-masing file
- fungsi setiap file
- perubahan database
- perubahan migration
- perubahan route
- perubahan JavaScript
- perubahan CSS
- perubahan Blade
- alur order
- alur QRIS
- alur WhatsApp
- cara testing.

Jika ada bagian yang belum dapat dibuat karena membutuhkan API/payment gateway/credential eksternal, jelaskan bagian tersebut secara spesifik dan jangan membuat sistem palsu.

Mulai dengan memeriksa struktur project dan implementasi order/payment yang saat ini sudah ada. Setelah itu lakukan perubahan secara terintegrasi.