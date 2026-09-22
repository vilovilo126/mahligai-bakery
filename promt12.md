Saya ingin mengubah konsep website Mahligai Bakery agar **Landing Page dan halaman pelanggan benar-benar berbeda**.

## 1. LANDING PAGE / WELCOME

Halaman `/` atau Welcome harus menjadi **halaman perkenalan Mahligai Bakery**, bukan halaman katalog makanan.

Ketika pengunjung pertama kali membuka website, mereka harus melihat halaman seperti website company/profile bakery profesional.

### Landing page TIDAK BOLEH menampilkan:

* daftar menu makanan
* kategori Roti Unyil
* kategori Roti Sisir
* Aneka Roti
* Roti Tawar
* card produk
* harga produk
* tombol "Lihat Detail" produk
* keranjang
* fitur checkout
* fitur pemesanan pelanggan

Jadi bagian katalog/menu makanan yang terlihat pada screenshot saat ini **jangan tampil di Welcome**.

### Landing page fokus pada:

**Hero**

* Mahligai Bakery
* tagline yang elegan
* deskripsi singkat tentang bakery
* tombol "Masuk sebagai Pelanggan" / "Login"
* tombol informasi seperti "Tentang Kami"

**Tentang Mahligai Bakery**
Ceritakan mengenai Mahligai Bakery:

* siapa Mahligai Bakery
* konsep bakery
* kualitas produk
* bahan dan proses pembuatan
* komitmen terhadap pelanggan
* suasana/identitas bakery

**Cerita / About**
Buat section storytelling yang membuat pengunjung mengenal Mahligai Bakery.

**Keunggulan**
Contoh:

* Fresh setiap hari
* Dibuat dengan bahan berkualitas
* Banyak pilihan roti
* Bisa request untuk kebutuhan tertentu
* Pelayanan pelanggan

**Galeri**
Tetap boleh menampilkan foto bakery/produk sebagai visual, tetapi **jangan berubah menjadi katalog produk yang bisa dipesan**.

**Lokasi**
Tetap tampilkan informasi lokasi Mahligai Bakery.

Alamat existing:
Jl. Tukad Barito Timur No.99, Renon, Denpasar Selatan, Kota Denpasar, Bali 80226.

**Jam Operasional**
07.00–22.00 setiap hari.

**Kontak**
Tetap tampilkan WhatsApp/contact.

**Footer**
Tetap profesional dan berisi informasi Mahligai Bakery.

---

# 2. NAVBAR LANDING PAGE

Navbar Welcome harus dibuat seperti website company/bakery.

Contoh:

```text
Mahligai Bakery

Beranda
Tentang Kami
Cerita Kami
Galeri
Lokasi
Kontak

                         Masuk
```

Jangan tampilkan:

```text
Roti Unyil
Roti Sisir
Aneka Roti
Roti Tawar
Keranjang
```

di navbar landing page.

---

# 3. LOGIN

Tombol:

```text
Masuk
```

mengarah ke:

```text
/login
```

Tetap gunakan sistem authentication existing:

```text
username
password
```

Satu form login untuk customer dan admin.

Jangan membuat login customer/admin terpisah.

---

# 4. SETELAH CUSTOMER LOGIN

Setelah:

```text
role = customer
```

customer diarahkan ke halaman pelanggan.

Gunakan route `/menu` yang sudah ada sebagai halaman pelanggan, atau struktur existing yang sudah digunakan project.

**Penting: `/menu` bukan lagi landing page.**

`/menu` sekarang menjadi **Customer Home / Customer Shopping Page**.

---

# 5. HALAMAN PELANGGAN

Setelah customer berhasil login, tampilkan website yang memang ditujukan untuk pelanggan.

Di halaman ini baru boleh tersedia:

### Menu makanan

```text
Roti Unyil
Roti Sisir
Aneka Roti
Roti Tawar
```

dan seluruh produk existing.

Termasuk:

* harga
* Lihat Detail
* additional
* quantity
* keranjang
* checkout
* pembayaran
* QRIS
* WhatsApp
* Pesanan Saya
* status pesanan
* chat admin
* notifikasi.

Jangan menghapus fitur existing tersebut.

---

# 6. NAVBAR CUSTOMER

Navbar customer boleh berbeda dengan landing page.

Contoh:

```text
Mahligai Bakery

Beranda
Menu
Pesanan Saya
Chat

🔔
🛒
Nama Pelanggan
▼
```

Jika customer sudah login, tampilkan fitur pelanggan.

Contoh menu:

```text
Menu
Pesanan Saya
Notifikasi
Chat Admin
Profil
Logout
```

---

# 7. BEDAKAN SECARA VISUAL

Ini penting.

Saya tidak hanya ingin memindahkan menu dari satu halaman ke halaman lain.

Saya ingin:

### Landing Page

Terasa seperti:

**Company Profile / Brand Website**

Visual:

* elegant
* storytelling
* banyak whitespace
* foto bakery
* typography premium
* section tentang brand
* informasi bakery
* CTA untuk login/pelanggan

### Customer Page

Terasa seperti:

**Bakery Ordering / Shopping Website**

Visual:

* product cards
* kategori makanan
* harga
* tombol beli/detail
* cart
* checkout
* order status.

Kedua halaman harus terasa sebagai **dua pengalaman berbeda**, walaupun tetap menggunakan identitas Mahligai Bakery yang sama.

---

# 8. ROUTING

Pertahankan routing existing sebisa mungkin.

Konsep akhirnya:

```text
/ 
↓
WELCOME / LANDING PAGE
↓
Tentang Mahligai Bakery
↓
Masuk
↓
/login
↓
username + password
↓
role customer
↓
/menu
↓
CUSTOMER SHOPPING PAGE
```

Untuk admin:

```text
/
↓
Masuk
↓
/login
↓
username + password
↓
role admin
↓
/admin/dashboard
```

Jangan merusak redirect role yang sudah dibuat.

---

# 9. LOGOUT

Jika customer logout:

```text
Customer
↓
Logout
↓
/
```

Kembali ke Landing Page.

Jika admin logout:

```text
Admin
↓
Logout
↓
/
```

Kembali ke Landing Page.

Landing page harus tetap bisa dilihat tanpa login.

---

# 10. PERTAHANKAN DATA DAN FITUR

Jangan menghapus:

* menu config
* product
* cart
* checkout
* QRIS
* WhatsApp order
* order
* receipt
* customer account
* authentication
* admin dashboard
* notifications
* chat
* order status.

Yang diubah adalah **pemisahan tampilan dan pengalaman pengguna**, bukan menghapus sistem yang sudah ada.

---

# 11. PENTING — AUDIT EXISTING DAHULU

Sebelum Build:

Cari dan audit:

```text
routes/web.php
resources/views/welcome.blade.php
resources/views/
resources/css/
resources/js/
config/menu.php
app/Http/Controllers/
```

Cari bagaimana halaman Welcome saat ini mengambil:

* menu
* products
* categories
* gallery
* login
* navbar.

Cari juga bagaimana `/menu` saat ini bekerja.

Jangan membuat halaman customer baru jika `/menu` existing sudah bisa digunakan dan cukup dipindahkan/diperbaiki.

Gunakan kembali komponen yang sudah ada jika memungkinkan.

---

# 12. JANGAN UBAH DATABASE

Untuk perubahan ini:

**Jangan membuat migration** kecuali benar-benar ditemukan kebutuhan database yang wajib.

Fokus pada:

* Blade
* Controller jika diperlukan
* Route jika diperlukan
* CSS
* JS
* komponen existing.

---

# 13. HASIL AKHIR YANG SAYA INGINKAN

Ketika orang membuka:

```text
127.0.0.1:8000/
```

mereka melihat:

```text
┌───────────────────────────────────────────────┐
│ Mahligai Bakery                               │
│                                               │
│ Beranda  Tentang Kami  Cerita  Galeri        │
│ Lokasi   Kontak                    [Masuk]    │
│                                               │
│        SELAMAT DATANG DI                      │
│        MAHLIGAI BAKERY                        │
│                                               │
│   Cerita dan identitas bakery                 │
│                                               │
│        [Masuk sebagai Pelanggan]              │
│                                               │
├───────────────────────────────────────────────┤
│ Tentang Mahligai Bakery                       │
├───────────────────────────────────────────────┤
│ Cerita Kami                                   │
├───────────────────────────────────────────────┤
│ Keunggulan                                    │
├───────────────────────────────────────────────┤
│ Galeri                                        │
├───────────────────────────────────────────────┤
│ Lokasi & Jam Operasional                      │
├───────────────────────────────────────────────┤
│ Kontak                                        │
└───────────────────────────────────────────────┘
```

**Tidak ada katalog makanan di halaman ini.**

Sedangkan setelah customer login:

```text
/login
   ↓
Customer
   ↓
/menu
   ↓

┌───────────────────────────────────────────────┐
│ Mahligai Bakery     Menu  Pesanan  🛒  👤    │
├───────────────────────────────────────────────┤
│ Roti Unyil | Roti Sisir | Aneka Roti | Tawar │
├───────────────────────────────────────────────┤
│                                               │
│  [Produk] [Produk] [Produk] [Produk]         │
│                                               │
│  Rp...       Rp...       Rp...               │
│                                               │
│          Lihat Detail / Pesan                │
│                                               │
└───────────────────────────────────────────────┘
```

Jadi **Welcome = memperkenalkan Mahligai Bakery.**

**Customer `/menu` = tempat pelanggan melihat menu dan melakukan pemesanan.**

Jangan mencampurkan kedua pengalaman tersebut.

Sebelum Build, buat Plan terlebih dahulu dan tampilkan:

1. file yang akan diubah
2. route yang akan digunakan
3. bagaimana menu dipindahkan dari Welcome ke Customer Page
4. bagaimana navbar Guest dan Customer dibedakan
5. pastikan fitur existing tidak rusak.

Setelah Plan selesai, jangan Build dulu sampai plan tersebut selesai diaudit.
