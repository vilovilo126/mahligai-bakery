# Mahligai Bakery — Dokumentasi Implementasi

Lengkap untuk sistem **pemesanan via WhatsApp + QRIS**, **biaya QRIS per item**, **nomor WhatsApp terpusat**, dan **halaman admin pesanan**. Berbasis `pomt4.md` (FASE 1–11) dan `promt3.md`.

---

## Ringkasan Status

- Semua FASE 1–11 **selesai** dan **terverifikasi** (tests 27/27 lulus, build Vite sukses, smoke test end-to-end berhasil).
- Aplikasi: Laravel 13.29 · PHP 8.3 · MySQL (backend), SQLite in-memory (test) · Tailwind 4 + Vite.
- Backend **tidak pernah mempercayai harga dari frontend** — seluruhnya direkompit dari `config/menu.php`.

---

## 1. Rute (routes/web.php)

| Metode | URI | Nama | Controller@method | Tujuan |
|---|---|---|---|---|
| GET | `/` | `home` | `PageController@index` | Landing page (lama, dipertahankan) |
| POST | `/orders` | `orders.store` | `OrderController@store` | Simpan pesanan pelanggan (tanpa login) |
| GET | `/admin/orders` | `admin.orders.index` | `OrderController@index` | Daftar pesanan admin |
| GET | `/admin/orders/{order}` | `admin.orders.show` | `OrderController@show` | Detail pesanan admin |
| PATCH | `/admin/orders/{order}/status` | `admin.orders.update-status` | `OrderController@updateStatus` | Ubah status pesanan/pembayaran |
| POST | `/ai/chat` | `ai.chat` | `AiChatController@chat` | Chat AI (backend dipertahankan) |

`/orders` dan `/admin/*` adalah rute web standar → **CSRF wajib** untuk POST/PATCH. Frontend `product-modal.js` mengirim header `X-CSRF-TOKEN` dari meta tag.

---

## 2. Database & Migrasi

**Migration:** `database/migrations/2026_09_01_055219_create_orders_table.php` → tabel `orders`.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | auto increment |
| `customer_name` | string | nama pemesan |
| `customer_phone` | string | nomor WhatsApp pemesan |
| `payment_method` | string, default `qris` | `qris` atau `wa` |
| `order_status` | string, default `menunggu_pembayaran` | lihat konstanta model |
| `payment_status` | string, default `belum_bayar` | lihat konstanta model |
| `subtotal` | unsignedInteger | harga varian/paket × qty |
| `add_ons_total` | unsignedInteger | total biaya additional |
| `qris_fee` | unsignedInteger | total biaya QRIS (per item × qty) |
| `total` | unsignedInteger | subtotal + add_ons_total + qris_fee |
| `order_data` | json | snapshot item yang tervalidasi |
| `timestamps` | — | `created_at` / `updated_at` |

Index: `payment_method`, `order_status`, `payment_status`.

Semua kolom harga disimpan sebagai **integer Rupiah** (bukan float) — aman untuk operasi uang.

---

## 3. Model & Relasi

**`app/Models/Order.php`**

- `ORDER_STATUSES` (map key→label): `menunggu_pembayaran`, `pembayaran_diproses`, `pembayaran_berhasil`, `pesanan_diproses`, `pesanan_siap`, `pesanan_selesai`, `pesanan_dibatalkan`.
- `PAYMENT_STATUSES`: `belum_bayar`, `diproses`, `sukses`, `gagal`.
- Casts: `order_data` → `array`, `subtotal`/`add_ons_total`/`qris_fee`/`total` → `integer`.
- Accessors: `payment_method_label`, `order_status_label`, `payment_status_label`.
- Scope: `latest()` = urut `id` menurun.

> **Catatan relasi:** `Order` saat ini **mandiri** (tidak berelasi langsung ke tabel `products`/`categories` karena menu homepage tetap config-driven; DB produk lama tidak dipakai untuk pemesanan). `order_data` adalah snapshot JSON sehingga pesanan tetap akurat walau menu berubah di kemudian hari.

---

## 4. Konfigurasi

### `config/business.php` — Identitas Bisnis Terpusat
Sumber tunggal nomor WhatsApp & info kontak. Ganti nomor hanya di sini (atau `.env`):
- `whatsapp_number` = `628113996988` (format internasional, tanpa `+`/`0`)
- `whatsapp_display` = `0811-3996-988` (format tampilan)
- `address`, `hours`, `price_range`, `rating`
- `wa_order_message` = pesan otomatis prefilled

### `config/menu.php` — Sumber Kebenaran Menu & Harga
- Semua varian/paket/additional kini punya kunci **`qris_fee`** (default `0`).
- Group punya `id`, `title`, `variants` atau `variant_groups[].items`, `packages`, `add_ons`.
- Frontend mengirim `group_id` + nama varian/paket/additional + qty; backend **merekompit** harga & `qris_fee` dari file ini.

---

## 5. Backend — Kalkulasi Order

### `app/Services/Order/OrderCalculatorService.php`
`calculate(array $payload)`:
1. Untuk tiap item, `resolveItem()` menemukan group → varian/paket → additional dari `config/menu.php`.
2. Validasi: satu item harus punya varian **ATAU** paket (bukan keduanya); `variants`, `packages`, group yang tidak ditemukan → `RuntimeException` (dikembalikan sebagai 422 oleh controller).
3. Harga dasar + `qris_fee` diambil dari config (bukan dari request), dikali `quantity`.
4. Additional divalidasi terhadap daftar `add_ons` grup; nama tidak dikenal diabaikan.
5. Mereturn `items` tersnapshot, `subtotal`, `add_ons_total`, `qris_fee`, `total`.

Manipulasi harga dari browser **tidak mungkin** — verifikasi: `test_it_ignores_forced_low_price_from_frontend`.

### `app/Support/OrderHelper.php`
- `normalizePhone()`: `0811-3996-988` → `628113996988` (awalan `0` → `62`; tidak mengubah yang sudah `62`; tambah `62` jika belum).
- `waLink($phone, $message)`: `https://wa.me/62...?text=<prefilled>`.
- `adminOrderMessage(Order)`: ringkasan pesanan untuk dikirim admin via WA.

### `app/Http/Requests/StoreOrderRequest.php`
Validasi `customer_name`, `customer_phone`, `payment_method` (`in:qris,wa`), `items` (array min 1, qty 1–999, `group_id` wajib). **Tidak** ada validasi harga — back-end yang menentukan.

### `app/Http/Controllers/OrderController.php`
- `store()`: kalkulasi via service → `Order::create` (status awal default) → JSON `{ success, order: { id, total, qris_fee, qris_image, payment_method } }`. Handle `RuntimeException` → 422, error lain → 500.
- `index()` / `show()`: halaman admin.
- `updateStatus()`: validasi key status dari konstanta model, lalu update.

---

## 6. Frontend — Alur Pemesanan

### Modal Produk (FASE 1 — di tengah layar)
`resources/views/components/product-detail-modal.blade.php` + `resources/js/modules/product-modal.js`
- Root `#product-modal` memakai `fixed inset-0 z-[80] flex items-center justify-center` → **centered**.
- Dua langkah: `customize` (pilih paket/additional/qty) → `checkout` (nama/telepon/metode bayar).
- Harga live dihitung dari `price_raw`/`qris_fee_raw` (diambil dari menu config lalu disertakan di `data-detail`).
- Submit → `fetch('/orders')` POST + `X-CSRF-TOKEN`. Jika `qris` → terbit event `qris:open`; jika `wa` → buka `wa.me` dengan nomor dari `data-wa-number` (config).

### Modal QRIS (FASE 5 — tanpa login)
`resources/views/components/qris-modal.blade.php` + `resources/js/modules/qris.js`
- Menampilkan gambar `/images/payment/qris.svg` (placeholder — **ganti dengan QRIS asli nanti**), total, biaya QRIS, nominal yang harus dibayar.
- Didengarkan via event `qris:open`.
- Tombol konfirmasi hanya memberi pesan terima kasih (status asli diubah admin di halaman admin).

### Data-detail menu (FASE 2 — harga integer)
`menu-variant-card.blade.php`, `menu-variant-row.blade.php`, `menu-packages.blade.php`, `menu-addons.blade.php`
- `mountMenuDetail()` kini menerima `int $rawPrice` → menambahkan `price_raw`, `qris_fee_raw`, `group_id`, `variant_name`, `is_addon_only` ke JSON `data-detail`.
- Harga dikirim sebagai **integer**, bukan string format sehingga kalkulasi JS akurat.

### Tombol Melayang WhatsApp (FASE 7 — ganti Gemini button)
`resources/views/components/chatbot.blade.php` + `resources/js/modules/chatbot.js`
- Launcher Gemini dihapus dari UI; **backend AI dipertahankan**.
- `#wa-floating` = tombol melayang hijau emerald, pulsating, tooltip "Chat WhatsApp", menautkan `https://wa.me/<nomor config>?text=<pesan order>`.
- `chatbot.js` diamankan dengan guard `#chat-launcher`/`#chat-panel` (no-op jika elemen tak ada).

### DTLLayout & CSS
- `resources/views/layouts/landing.blade.php` menyertakan `<x-qris-modal />`; `app.js` mengimpor module `qris`.
- `resources/css/custom.css` menambahkan blok `.wa-float` (z-index).
- `navbar`, `footer`, `contact`, `about`, `gallery` memakai `config('business.*')` (nomor terpusat, format `62`).

---

## 7. Admin — Manajemen Pesanan

`resources/views/layouts/admin.blade.php`, `resources/views/admin/orders/index.blade.php`, `resources/views/admin/orders/show.blade.php`

- `index`: tabel paginated (20/halaman) dengan status + tombol "Hubungi WA" (link `wa.me` prefilled, format `62`).
- `show`: detail lengkap + ringkasan item + tombol "Hubungi via WhatsApp" (`OrderHelper::waLink(customer_phone, adminOrderMessage)`).
- Form ubah status pesanan & pembayaran → `PATCH .../status`.
- **Admin tidak memerlukan login** (sesuai keputusan yang disetujui).

---

## 8. Frontend × Backend × AI

- **Frontend ↔ Order**: modal produk → `POST /orders` → controller recompute → simpan → jawab JSON → buka QRIS/WA.
- **Frontend ↔ Admin**: halaman admin baca dari DB (CRUD read + update status).
- **AI (Gemini)**: backend utuh tetap ada (`AiChatController@chat`, `GeminiService`), tetapi **tidak ada lagi tombol melayang AI** di UI; tombol diganti WhatsApp. `GeminiService.buildPrompt()` kini memakai `config('business.whatsapp_display')` (diperbaiki dari literal heredoc yang salah).
- **Keamanan**: API key Gemini **tidak** pernah diekspos ke frontend (dicek: tidak ada `AIza` di `public/`). Nomor kontak hanya disimpan di config.

---

## 9. Testing

| File | Jenis | Cakupan |
|---|---|---|
| `tests/Unit/OrderCalculatorServiceTest.php` | Unit | harga varian+additional, paket, qty, varian tak ditemukan (throws), manipulasi harga diabaikan, multi-item |
| `tests/Feature/OrderTest.php` | Feature | buat order tanpa login, additional tersimpan, validasi wajib, recompute harga dipalsukan, varian invalid → 422, QRIS image |
| `tests/Feature/AdminOrdersTest.php` | Feature | daftar, detail, update status |

**Dijalankan:** `php artisan test` → **27 passed / 84 assertions** (termasuk `HomePageTest`, `AiChatTest` — tidak ada regresi).

**Lint/format:** `vendor/bin/pint --format agent` lulus; build `npm run build` sukses.

---

## 10. Daftar File (Dibuat / Dimodifikasi)

**Dibuat baru:**
- `config/business.php` — identitas bisnis + nomor WhatsApp terpusat
- `config/menu.php` — ditulis ulang: menambah `qris_fee` pada semua item
- `app/Models/Order.php`
- `app/Http/Controllers/OrderController.php`
- `app/Http/Requests/StoreOrderRequest.php`
- `app/Services/Order/OrderCalculatorService.php`
- `app/Support/OrderHelper.php`
- `database/migrations/2026_09_01_055219_create_orders_table.php`
- `resources/views/layouts/admin.blade.php`
- `resources/views/admin/orders/index.blade.php`
- `resources/views/admin/orders/show.blade.php`
- `resources/views/components/qris-modal.blade.php`
- `resources/views/components/product-detail-modal.blade.php` (ditulis ulang)
- `resources/views/components/chatbot.blade.php` (ditulis ulang → WA float)
- `resources/js/modules/product-modal.js` (ditulis ulang)
- `resources/js/modules/qris.js`
- `resources/js/modules/chatbot.js` (ditulis ulang, guard)
- `public/images/payment/qris.svg` (placeholder QRIS)
- `tests/Unit/OrderCalculatorServiceTest.php`
- `tests/Feature/OrderTest.php`
- `tests/Feature/AdminOrdersTest.php`

**Dimodifikasi:**
- `routes/web.php` — tambah 4 rute order/admin
- `app/Services/Ai/GeminiService.php` — pakai `config('business.whatsapp_display')`
- `resources/views/home/partials/menu-variant-card.blade.php`, `menu-variant-row.blade.php`, `menu-packages.blade.php`, `menu-addons.blade.php` — data-detail harga integer & `is_addon_only`
- `resources/views/layouts/landing.blade.php` — include `<x-qris-modal />`
- `resources/js/app.js` — import modul `qris`
- `resources/css/custom.css` — blok `.wa-float`
- `resources/views/components/navbar.blade.php`, `footer.blade.php`, `contact.blade.php`, `about.blade.php`, `gallery.blade.php` — hardcode nomor → `config('business.*')`

---

## 11. Pohon Struktur (relevan)

```
mahligai-bakery/
├─ config/
│  ├─ business.php
│  └─ menu.php
├─ app/
│  ├─ Http/
│  │  ├─ Controllers/OrderController.php
│  │  └─ Requests/StoreOrderRequest.php
│  ├─ Models/Order.php
│  ├─ Services/
│  │  ├─ Ai/GeminiService.php
│  │  └─ Order/OrderCalculatorService.php
│  └─ Support/OrderHelper.php
├─ database/migrations/2026_09_01_055219_create_orders_table.php
├─ resources/
│  ├─ views/
│  │  ├─ layouts/{landing,admin}.blade.php
│  │  ├─ components/{qris-modal,product-detail-modal,chatbot}.blade.php
│  │  ├─ admin/orders/{index,show}.blade.php
│  │  └─ home/partials/menu-{variant-card,variant-row,packages,addons}.blade.php
│  ├─ js/  modules/{product-modal,qris,chatbot}.js, app.js
│  └─ css/custom.css
├─ public/images/payment/qris.svg   ← GANTI DENGAN QRIS ASLI
├─ tests/
│  ├─ Unit/OrderCalculatorServiceTest.php
│  └─ Feature/{OrderTest,AdminOrdersTest}.php
└─ docs/IMPLEMENTATION.md
```

---

## 12. Catatan & Tindak Lanjut

- **QRIS:** `public/images/payment/qris.svg` masih placeholder teks "GANTI DENGAN QRIS ASLI" — ganti dengan gambar QRIS milik toko.
- **Biaya QRIS:** diset `0` di `config/menu.php`; ubah nilai `qris_fee` per item jika toko mulai memungut biaya.
- **Verifikasi:** lakukan `php artisan migrate`, `npm run build`, lalu `php artisan test` setelah mengubah config/menu.
