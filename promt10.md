# FIX FINAL — CHECKOUT MODAL MASIH TIDAK BISA SCROLL

Perbaikan sebelumnya sudah menambahkan:

* `height: 100dvh`
* `height: min(90dvh, calc(100dvh - 2rem))`
* `flex-1`
* `min-h-0`
* `overflow-y-auto`
* `shrink-0`
* `overscroll-behavior: contain`

Namun setelah perubahan tersebut, **checkout modal di browser MASIH TIDAK BISA SCROLL**.

Screenshot terbaru menunjukkan:

* Header modal terlihat.
* Ringkasan pesanan terlihat.
* Nama lengkap terlihat.
* Nomor WhatsApp terlihat.
* Jadwal pengambilan terlihat.
* Request Bakery terlihat.
* Heading "Metode Pembayaran" terlihat.
* Pilihan QRIS dan WhatsApp hanya terlihat sebagian.
* Area modal berhenti di sana.
* Mouse wheel/touchpad tidak menggeser isi modal ke bawah.
* User tidak dapat mencapai bagian pembayaran selanjutnya maupun tombol konfirmasi.

JANGAN menganggap masalah sudah selesai hanya karena CSS build berhasil.

Sekarang lakukan **diagnosis langsung terhadap DOM dan browser**, kemudian perbaiki penyebab sebenarnya.

---

# 1. JANGAN ULANGI FIX CSS YANG SAMA TANPA DIAGNOSIS

Jangan hanya menambahkan:

```css
overflow-y: auto;
```

lagi.

Jangan hanya menambahkan:

```css
height: 100dvh;
```

lagi.

Periksa terlebih dahulu elemen mana yang sebenarnya menampung isi checkout.

Gunakan browser/devtools automation yang tersedia di environment untuk memeriksa DOM checkout ketika modal sedang terbuka.

Cari:

```html
#product-modal
```

kemudian:

```html
[data-modal-step="checkout"]
```

dan seluruh descendant yang memiliki:

```css
overflow
height
max-height
flex
position
```

---

# 2. CARI SCROLL CONTAINER YANG SEBENARNYA

Saat checkout modal terbuka, periksa setiap parent/container menggunakan JavaScript di browser.

Gunakan pemeriksaan seperti:

```js
const modal = document.querySelector('#product-modal');

console.log({
    modal,
    scrollHeight: modal?.scrollHeight,
    clientHeight: modal?.clientHeight,
    overflowY: modal ? getComputedStyle(modal).overflowY : null,
});
```

Kemudian periksa:

```js
const checkout = document.querySelector(
    '#product-modal [data-modal-step="checkout"]'
);

console.log({
    checkout,
    scrollHeight: checkout?.scrollHeight,
    clientHeight: checkout?.clientHeight,
    overflowY: checkout ? getComputedStyle(checkout).overflowY : null,
    display: checkout ? getComputedStyle(checkout).display : null,
    height: checkout ? getComputedStyle(checkout).height : null,
});
```

Kemudian cari semua descendant yang memiliki perbedaan:

```text
scrollHeight > clientHeight
```

Contoh:

```js
document.querySelectorAll('#product-modal *').forEach((el) => {
    const style = getComputedStyle(el);

    if (el.scrollHeight > el.clientHeight) {
        console.log('SCROLLABLE:', el, {
            scrollHeight: el.scrollHeight,
            clientHeight: el.clientHeight,
            overflowY: style.overflowY,
        });
    }
});
```

TUJUANNYA adalah menemukan:

**elemen mana yang seharusnya scroll tetapi ternyata tidak memiliki overflow yang benar.**

---

# 3. PERIKSA STRUKTUR STEP CHECKOUT

Periksa struktur aktual `data-modal-step="checkout"`.

Target akhirnya harus benar-benar seperti:

```text
#product-modal
│
└── modal-card
    │
    ├── checkout header
    │   ├── Back
    │   ├── Title
    │   └── X
    │
    ├── checkout body ← HARUS SCROLL
    │   ├── Ringkasan
    │   ├── Nama
    │   ├── WhatsApp
    │   ├── Jadwal
    │   ├── Request
    │   ├── Metode Pembayaran
    │   ├── QRIS
    │   ├── WhatsApp
    │   └── informasi pembayaran
    │
    └── footer/action
        └── tombol konfirmasi
```

Pastikan **header dan footer bukan bagian dari scroll body** jika memang desain sekarang menggunakan header/footer terpisah.

---

# 4. PERIKSA HAL PALING PENTING: CLASS `overflow-y-auto`

Cari element yang benar-benar membungkus konten checkout.

Pastikan element tersebut memiliki:

```css
flex: 1 1 0%;
min-height: 0;
overflow-y: auto;
overflow-x: hidden;
```

Jika menggunakan Tailwind, targetnya dapat berupa:

```html
class="min-h-0 flex-1 overflow-y-auto overflow-x-hidden"
```

TAPI:

**Jangan menambahkan class ini ke element secara asal.**

Pastikan element tersebut memang merupakan BODY checkout.

---

# 5. PERIKSA MASALAH `hidden`

Sangat penting:

Cari bagaimana step checkout ditampilkan.

Misalnya:

```html
<div data-modal-step="checkout" class="hidden ...">
```

Kemudian JavaScript mungkin mengganti:

```js
hidden
```

dengan:

```js
flex
```

atau:

```js
block
```

Periksa apakah JavaScript benar-benar menghapus class `hidden` ketika checkout dibuka.

Pastikan computed style ketika checkout aktif adalah:

```text
display: flex
```

bukan:

```text
display: none
```

---

# 6. PERIKSA CLASS `overflow-hidden` PADA PARENT

Cari seluruh parent dari scroll body.

Periksa apakah ada parent seperti:

```css
overflow: hidden;
```

yang menyebabkan child tidak dapat melakukan scroll.

Periksa juga:

```css
overflow: clip;
```

```css
contain
```

```css
position: fixed;
```

```css
height: 100%;
```

```css
max-height
```

Jika `overflow-hidden` diperlukan pada modal luar untuk mencegah background scrolling, pastikan **tidak menghalangi child scroll container**.

---

# 7. PERIKSA JAVASCRIPT YANG MEMBLOKIR WHEEL

Cari seluruh JavaScript terkait modal.

Cari:

```js
preventDefault
```

```js
wheel
```

```js
touchmove
```

```js
pointermove
```

```js
scroll
```

Periksa apakah ada event listener seperti:

```js
document.addEventListener('wheel', ...)
```

atau:

```js
modal.addEventListener('wheel', ...)
```

yang melakukan:

```js
event.preventDefault();
```

Jika ada dan menyebabkan modal tidak bisa scroll, perbaiki dengan benar.

JANGAN sekadar menghapus seluruh event listener jika event tersebut digunakan untuk mencegah background scroll.

---

# 8. PERIKSA BODY LOCK

Project mungkin menggunakan:

```js
document.body.style.overflow = 'hidden';
```

ketika modal terbuka.

Itu diperbolehkan.

Tetapi pastikan yang dikunci hanya:

```text
background page
```

bukan:

```text
checkout body
```

Target:

```text
PAGE
overflow: hidden

MODAL
overflow: visible

CHECKOUT BODY
overflow-y: auto
```

---

# 9. LAKUKAN TES PROGRAMMATIS

Setelah menemukan scroll body yang benar, jalankan tes di browser.

Misalnya:

```js
const body = /* checkout scroll container */;

console.log({
    before: body.scrollTop,
    scrollHeight: body.scrollHeight,
    clientHeight: body.clientHeight,
});
```

Kemudian:

```js
body.scrollTop = 500;

console.log({
    after: body.scrollTop,
});
```

HASIL YANG DIHARAPKAN:

```text
before: 0
after: 500
```

Jika:

```text
after: 0
```

maka element tersebut BUKAN scroll container yang benar atau masih dikunci CSS/JS.

Jangan berhenti sebelum menemukan element yang benar-benar berubah `scrollTop`.

---

# 10. TES MOUSE WHEEL

Setelah menemukan scroll container yang benar:

1. Buka checkout.
2. Arahkan mouse ke area isi checkout.
3. Scroll wheel ke bawah.

Pastikan posisi konten berubah.

Jika tidak berubah, cek event listener yang menangkap wheel.

---

# 11. TES TOUCHPAD

Di laptop:

* buka checkout
* arahkan pointer ke bagian isi modal
* gunakan gesture scroll touchpad

Expected:

```text
Ringkasan
↓
Nama
↓
WhatsApp
↓
Jadwal
↓
Request
↓
Metode Pembayaran
↓
QRIS / WhatsApp
↓
Detail pembayaran
↓
Tombol konfirmasi
```

---

# 12. JIKA PERLU, BUAT SCROLL BODY SECARA EKPLISIT

Jika struktur saat ini terlalu kompleks, gunakan struktur yang sederhana.

Contoh:

```html
<div data-modal-step="checkout"
     class="hidden min-h-0 flex-1 flex-col">

    <div class="shrink-0">
        HEADER
    </div>

    <div data-checkout-scroll
         class="min-h-0 flex-1 overflow-y-auto overflow-x-hidden">

        SEMUA ISI CHECKOUT

    </div>

    <div class="shrink-0">
        FOOTER
    </div>

</div>
```

Kemudian JavaScript menggunakan:

```js
const checkoutScroll = checkoutStep.querySelector(
    '[data-checkout-scroll]'
);
```

Untuk reset:

```js
checkoutScroll.scrollTop = 0;
```

JANGAN gunakan:

```js
document.body.scrollTop = 0;
```

untuk reset checkout.

---

# 13. PENTING: JANGAN MEMBUAT DUA SCROLLBAR

Saya tidak ingin:

```text
Modal scrollbar
+
Body scrollbar
```

atau:

```text
Checkout scrollbar
+
Payment scrollbar
```

Target hanya:

```text
┌───────────────────────┐
│ HEADER                │
├───────────────────────┤
│                       │
│                       │
│ CHECKOUT BODY         │
│                       │
│        ↕              │
│      SCROLL            │
│                       │
├───────────────────────┤
│ FOOTER                │
└───────────────────────┘
```

Satu scroll utama.

---

# 14. JANGAN MENGUBAH DATA ATAU LOGIC ORDER

Masalah ini adalah masalah UI/scroll.

Jangan mengubah:

* database
* migration
* order controller
* payment calculation
* QRIS fee
* order status
* queue number
* order number
* receipt
* customer data
* payment logic

kecuali ditemukan bug yang benar-benar berkaitan langsung dengan scroll.

---

# 15. SETELAH FIX

Lakukan:

```bash
npm run build
```

```bash
vendor/bin/pint --format agent
```

```bash
php artisan test --compact
```

Kemudian lakukan **manual browser test**, bukan hanya build/test.

WAJIB verifikasi:

### A

Checkout bisa dibuka.

### B

Mouse wheel bisa scroll.

### C

Touchpad bisa scroll.

### D

Metode Pembayaran bisa terlihat penuh.

### E

QRIS dan WhatsApp bisa dipilih.

### F

Informasi pembayaran bisa terlihat.

### G

Bagian paling bawah bisa dicapai.

### H

Tombol konfirmasi bisa diklik.

### I

X tetap bisa diklik.

### J

Back tetap bisa diklik.

---

# 16. JANGAN MENYATAKAN SELESAI HANYA BERDASARKAN BUILD

Build berhasil ≠ scroll berhasil.

Test harus membuktikan:

```text
checkout scrollHeight > checkout clientHeight
```

dan:

```text
scrollTop dapat berubah dari 0 ke nilai > 0
```

Jika hasil tersebut belum berhasil, teruskan diagnosis sampai menemukan penyebabnya.

## HASIL AKHIR

Saya ingin saat modal checkout dibuka:

**User dapat scroll dari bagian Ringkasan Pesanan sampai bagian paling bawah Metode Pembayaran dan tombol Konfirmasi menggunakan mouse wheel/touchpad tanpa harus mengecilkan modal atau font.**
