# PERBAIKAN MODAL CHECKOUT — SCROLL, METODE PEMBAYARAN, DAN FOOTER

Perbaiki modal checkout pada project Mahligai Bakery berdasarkan kondisi berikut:

## MASALAH SAAT INI

Pada modal checkout tahap **“Data Diri & Pembayaran”**:

1. Bagian “Ringkasan Pesanan” terlihat.
2. Field Nama Lengkap terlihat.
3. Field Nomor WhatsApp terlihat.
4. Jadwal Pengambilan terlihat.
5. Request untuk Bakery terlihat.
6. Bagian **Metode Pembayaran terpotong di bagian bawah modal**.
7. Modal **tidak bisa discroll ke bawah** menggunakan mouse wheel, touchpad, maupun scrollbar.
8. Akibatnya user tidak dapat melihat pilihan pembayaran secara lengkap.
9. User juga tidak dapat mencapai tombol konfirmasi/pesan yang berada di bagian bawah.
10. Jangan menyelesaikan masalah dengan mengecilkan font, mengecilkan seluruh modal, atau menghapus field.

## TUJUAN UTAMA

Buat modal checkout menjadi seperti modal e-commerce profesional:

* Modal tetap berada di tengah layar.
* Modal memiliki tinggi maksimum mengikuti viewport.
* Isi modal dapat discroll secara vertikal.
* Semua field tetap dengan ukuran yang nyaman dibaca.
* Bagian Metode Pembayaran dapat terlihat dengan jelas setelah scroll.
* Bagian QRIS/WhatsApp dapat terlihat setelah memilih metode pembayaran.
* Tombol aksi terakhir tetap dapat diakses.
* Tombol X tetap bisa diklik kapan saja.
* Tombol kembali tetap berfungsi.
* Tidak boleh ada isi yang tertutup oleh footer.
* Tidak boleh ada double scrollbar yang membingungkan.

---

# 1. AUDIT STRUKTUR MODAL

Cari file yang mengatur modal checkout, terutama:

* `product-modal.js`
* CSS yang berkaitan dengan product modal / checkout modal
* Blade partial/modal checkout
* JavaScript yang mengatur perpindahan step checkout

Jangan langsung membuat ulang modal.

Pertahankan struktur, data, dan fitur checkout yang sudah ada.

Cari penyebab mengapa scroll tidak bekerja.

Periksa terutama:

* `overflow: hidden`
* `overflow-y: hidden`
* `height`
* `max-height`
* `position: fixed`
* nested modal container
* `event.preventDefault()`
* wheel event
* touch event
* `pointer-events`
* parent container yang mengunci scroll
* `body` yang dibuat `overflow: hidden`
* footer yang menutupi content
* elemen dengan `position: absolute` atau `fixed` yang menimpa body modal.

---

# 2. STRUKTUR MODAL YANG DIINGINKAN

Gunakan konsep struktur berikut:

```text
Modal
├── Header
│   ├── Back
│   ├── Title
│   └── Close X
│
├── Scrollable Body
│   ├── Ringkasan Pesanan
│   ├── Nama Lengkap
│   ├── Nomor WhatsApp
│   ├── Jadwal Pengambilan
│   ├── Request Bakery
│   ├── Metode Pembayaran
│   ├── QRIS / WhatsApp Payment
│   └── Informasi pembayaran lainnya
│
└── Footer / Action
    └── Tombol konfirmasi
```

Yang paling penting:

**HANYA BODY KONTEN YANG MENJADI AREA SCROLL UTAMA.**

Jangan membuat seluruh halaman/browser menjadi scroll untuk mengatasi masalah ini.

---

# 3. CSS MODAL

Atur modal agar memiliki batas tinggi terhadap viewport.

Gunakan pendekatan seperti:

```css
.checkout-modal {
    max-height: 90vh;
    height: min(90vh, 900px);
    display: flex;
    flex-direction: column;
}

.checkout-modal-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden;
    overscroll-behavior: contain;
    -webkit-overflow-scrolling: touch;
}
```

Sesuaikan class dengan class yang benar-benar digunakan project.

JANGAN copy class tersebut secara membabi buta jika project menggunakan nama class berbeda.

Yang penting adalah prinsip:

```text
modal = flex column
body = flex: 1 + min-height: 0 + overflow-y: auto
```

---

# 4. JANGAN BIARKAN FOOTER MENUTUP BODY

Jika footer checkout menggunakan:

```css
position: fixed;
```

atau

```css
position: absolute;
```

dan menyebabkan konten tertutup, perbaiki.

Lebih baik gunakan:

```css
.checkout-modal-footer {
    flex-shrink: 0;
}
```

Jika footer memang harus sticky, gunakan struktur yang aman dan pastikan body memiliki padding bawah yang cukup.

Contoh:

```css
.checkout-modal-body {
    padding-bottom: 24px;
}
```

Jangan sampai field terakhir atau metode pembayaran berada di balik footer.

---

# 5. METODE PEMBAYARAN HARUS TERLIHAT

Pada screenshot saat ini:

```text
Request untuk Bakery
↓
Metode Pembayaran
↓
[ bagian pilihan pembayaran terpotong ]
```

Setelah diperbaiki, user harus bisa:

1. Membuka checkout.
2. Scroll ke bawah.
3. Melihat heading **Metode Pembayaran**.
4. Melihat pilihan:

   * QRIS
   * WhatsApp / metode pembayaran lain yang memang sudah tersedia di project.
5. Memilih metode.
6. Melihat informasi tambahan metode tersebut.
7. Scroll sampai bagian bawah.
8. Melihat tombol konfirmasi/pesan.

Jangan menghapus metode pembayaran yang sudah ada.

---

# 6. SCROLL HARUS BENAR-BENAR BERFUNGSI

Pastikan mouse wheel bekerja ketika pointer berada di dalam modal.

Pastikan touchpad bekerja.

Pastikan mobile touch scroll bekerja.

Pastikan scrollbar body modal muncul ketika content lebih tinggi dari modal.

Jangan memasang event listener yang mencegah scroll tanpa alasan.

Cari kode seperti:

```js
event.preventDefault()
```

atau handler wheel/touch yang mungkin memblokir scroll.

Jika ada, periksa apakah handler tersebut diperlukan.

Jangan menghapus logic checkout yang valid hanya untuk memperbaiki scroll.

---

# 7. BODY PAGE SAAT MODAL TERBUKA

Ketika modal dibuka, background halaman boleh dikunci agar halaman belakang tidak ikut scroll.

Namun:

**penguncian body halaman TIDAK BOLEH mengunci scroll body modal.**

Contoh konsep:

```text
BODY HALAMAN
overflow: hidden

        ↓

CHECKOUT MODAL
overflow: visible

        ↓

CHECKOUT MODAL BODY
overflow-y: auto
```

Pastikan lock pada `body` tidak diwariskan menjadi masalah pada area scroll modal.

---

# 8. HEADER MODAL

Header harus tetap terlihat dengan baik.

Pastikan:

* tombol X bisa diklik
* tombol Back bisa diklik
* header tidak menutupi content
* z-index benar
* tidak ada overlay yang menutup tombol
* klik X benar-benar menutup checkout/modal
* klik Back kembali ke step sebelumnya.

Jika header sticky, gunakan:

```css
position: sticky;
top: 0;
z-index: 10;
```

Tetapi hanya jika memang dibutuhkan.

---

# 9. FOOTER DAN TOMBOL KONFIRMASI

Tombol konfirmasi/pesan harus bisa dicapai setelah user scroll ke bawah.

Pastikan tidak:

* tertutup content
* berada di luar viewport
* tertutup footer lain
* tertutup scrollbar
* tidak bisa diklik
* terpotong di mobile.

Jika footer dibuat sticky, pastikan body memiliki ruang yang cukup.

---

# 10. RESPONSIVE

Perbaikan harus bekerja pada:

### Desktop

Modal sekitar:

```text
80–90vh
```

dengan body scroll.

### Laptop

Modal tidak boleh melebihi viewport.

### Tablet

Body tetap dapat di-scroll.

### Mobile

Modal dapat menggunakan hampir seluruh layar:

```css
max-height: 100dvh;
```

atau pendekatan responsive yang sesuai.

Jangan sampai mobile mengalami:

* modal lebih tinggi dari layar
* tombol konfirmasi hilang
* metode pembayaran terpotong
* scroll tidak bekerja.

Gunakan `dvh` bila sesuai untuk mobile browser modern.

---

# 11. JANGAN MERUSAK FITUR YANG SUDAH ADA

Pertahankan seluruh fungsi yang sudah berjalan:

* pilihan produk
* quantity
* additional
* request plastik
* subtotal
* biaya QRIS
* total
* ringkasan pesanan
* nama
* WhatsApp
* jadwal pengambilan
* request bakery
* metode pembayaran
* QRIS
* WhatsApp
* tombol kembali
* tombol X
* tambah ke keranjang
* lanjut ke pembayaran
* submit order
* success animation
* receipt
* nomor antrean
* order number.

Jangan mengubah database atau migration jika masalah ini hanya masalah UI/scroll.

---

# 12. PERBAIKI DENGAN CLEAN CODE

Jangan menambahkan workaround berulang.

Jangan membuat banyak nested scrollbar.

Hindari struktur seperti:

```text
modal overflow-y-auto
    ↓
body overflow-y-auto
    ↓
payment overflow-y-auto
```

Jika tidak diperlukan.

Targetkan satu scroll utama:

```text
Modal
 ├── Header
 ├── Body ← SATU-SATUNYA SCROLL
 └── Footer
```

---

# 13. CEK JAVASCRIPT

Periksa logic perpindahan:

```text
Product Detail
        ↓
Checkout / Data Diri & Pembayaran
        ↓
Payment
        ↓
Success
        ↓
Receipt
```

Saat pindah ke step **Data Diri & Pembayaran**, otomatis reset scroll body ke atas:

```js
body.scrollTop = 0;
```

Tetapi setelah itu user harus tetap dapat melakukan scroll ke bawah secara normal.

Jangan menggunakan:

```js
document.body.scrollTop
```

jika yang seharusnya di-scroll adalah container modal.

Gunakan reference ke container scroll modal yang benar.

---

# 14. VALIDASI MANUAL

Setelah selesai, lakukan test berikut.

### Test 1

Buka produk.

Klik lanjut ke checkout.

Expected:

* modal muncul
* header terlihat
* X terlihat.

### Test 2

Scroll menggunakan mouse wheel.

Expected:

* modal body bergerak ke bawah.

### Test 3

Scroll sampai bawah.

Expected:

* Metode Pembayaran terlihat lengkap.
* pilihan pembayaran terlihat.
* informasi pembayaran terlihat.
* tombol konfirmasi terlihat.

### Test 4

Pilih QRIS.

Expected:

* informasi QRIS muncul.
* tidak ada content yang terpotong.

### Test 5

Pilih WhatsApp/metode lainnya.

Expected:

* UI berubah sesuai logic existing.
* tidak ada error.

### Test 6

Klik X.

Expected:

* modal tertutup.

### Test 7

Klik Back.

Expected:

* kembali ke step sebelumnya.

### Test 8

Test mobile/responsive.

Expected:

* body modal tetap bisa scroll.
* tombol tetap bisa digunakan.
* tidak ada horizontal overflow.

---

# 15. SETELAH SELESAI

Jalankan:

```bash
php artisan test --compact
```

kemudian:

```bash
vendor/bin/pint --format agent
```

dan:

```bash
npm run build
```

Jika ada test yang gagal karena perubahan ini, perbaiki sampai passing.

Jangan mengubah fitur yang tidak berkaitan dengan masalah checkout.

## HASIL AKHIR YANG WAJIB

Saya ingin modal checkout bekerja seperti ini:

```text
┌──────────────────────────────────────┐
│ ← Data Diri & Pembayaran          X │
├──────────────────────────────────────┤
│                                      │
│ Ringkasan Pesanan                    │
│                                      │
│ Nama Lengkap                         │
│ [____________________________]       │
│                                      │
│ Nomor WhatsApp                       │
│ [____________________________]       │
│                                      │
│ Jadwal Pengambilan                   │
│ [ Tanggal ]       [ Jam ]            │
│                                      │
│ Request untuk Bakery                 │
│ [____________________________]       │
│                                      │
│ Metode Pembayaran                    │
│                                      │
│ [ QRIS ]        [ WhatsApp ]         │
│                                      │
│ informasi pembayaran                 │
│                                      │
│                ↕ SCROLL              │
│                                      │
├──────────────────────────────────────┤
│        Tombol Konfirmasi             │
└──────────────────────────────────────┘
```

Intinya:

**JANGAN MENGECILKAN MODAL UNTUK MEMAKSA SEMUA KONTEN MASUK.**

**BUAT BODY CHECKOUT BENAR-BENAR SCROLLABLE SEHINGGA USER BISA MENCAPAI METODE PEMBAYARAN DAN TOMBOL DI BAGIAN BAWAH.**
