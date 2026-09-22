# Mahligai Bakery — Dokumentasi Implementasi

Dokumentasi lengkap sistem **pemesanan via WhatsApp + QRIS**, **biaya QRIS per item**, **nomor WhatsApp terpusat**, **login pelanggan (cukup nama)**, **"Pesanan Saya" + struk digital**, **chat in-app pelanggan↔admin**, **notifikasi database**, dan **panel admin login (dashboard, pesanan, chat, notifikasi, profil)**.

Berbasis `pomt4.md` (FASE 1–11), `promt4.md`, dan `promt6.md` (login pelanggan, queue/order number, pickup & request, struk, chat, notifikasi, admin panel, tes, dokumentasi).

---

## Ringkasan Status

- Seluruh fitur promt6 **selesai** dan **terverifikasi**: schema migrasi MySQL green, **72 tests / 238 assertions lulus**, Pint bersih, `npm run build` sukses (bundle `app` + `admin`).
- Aplikasi: Laravel 13.29 · PHP 8.3 · MySQL (backend), SQLite in-memory (test) · Tailwind 4 + Vite.
- Backend **tidak pernah mempercayai harga dari frontend** — seluruhnya direkompit dari `config/menu.php`.
- Akun admin default (seed): username `admin`, password `bakery mahligai` (dari `ADMIN_USERNAME`/`ADMIN_PASSWORD`).

---

## 1. Rute (routes/web.php)

| Metode | URI | Nama | Controller@method | Tujuan |
|---|---|---|---|---|
| GET | `/` | `home` | `PageController@index` | Landing page (dipertahankan) |
| POST | `/ai/chat` | `ai.chat` | `AiChatController@chat` | Chat AI (backend dipertahankan) |
| POST | `/customer/login` | `customer.login` | `CustomerAuthController@login` | Login pelanggan (nama saja, throttle) |
| POST | `/customer/logout` | `customer.logout` | `CustomerAuthController@logout` | Logout customer (`auth:customer`) |
| GET | `/customer/me` | `customer.me` | `CustomerAuthController@me` | Info sesi customer |
| GET | `/customer/orders` | `customer.orders` | `CustomerOrderController@index` | Daftar "Pesanan Saya" |
| GET | `/customer/orders/{order}` | `customer.orders.show` | `CustomerOrderController@show` | Detail pesanan pelanggan |
| GET | `/customer/orders/{order}/json` | `customer.orders.json` | `CustomerOrderController@json` | Data struk dalam JSON |
| GET | `/customer/notifications` | `customer.notifications` | `CustomerNotificationController@index` | Halaman notifikasi |
| GET | `/customer/notifications/list` | `customer.notifications.list` | `…@list` | List JSON utk bell navbar |
| POST | `/customer/notifications/read[/{id}]` | `customer.notifications.read[One]` | `…@markAsRead` | Tandai dbs. dibaca |
| GET | `/customer/chat` | `customer.chat` | `CustomerChatController@index` | Ambil pesan chat JSON |
| POST | `/customer/chat/send` | `customer.chat.send` | `…@send` | Kirim pesan pelanggan |
| GET | `/customer/chat/poll` | `customer.chat.poll` | `…@poll` | Polling pesan baru (`?after=id`) |
| POST | `/orders` | `orders.store` | `OrderController@store` | Simpan order (**wajib `auth:customer`**, throttle) |
| GET | `/admin/login` | `admin.login` | `AdminAuthController@showLogin` | Halaman login admin (`guest`) |
| POST | `/admin/login` | `admin.login.submit` | `…@login` | Proses login admin |
| POST | `/admin/logout` | `admin.logout` | `…@logout` | Logout admin (`auth`+`admin`) |
| GET | `/admin/dashboard` | `admin.dashboard` | `AdminDashboardController@index` | Dasbor statistik |
| GET | `/admin/orders` | `admin.orders.index` | `OrderController@index` | Daftar pesanan admin |
| GET | `/admin/orders/{order}` | `admin.orders.show` | `OrderController@show` | Detail pesanan admin |
| PATCH | `/admin/orders/{order}/status` | `admin.orders.update-status` | `…@updateStatus` | Ubah status pesanan/pembayaran |
| GET | `/admin/chat` | `admin.chat` | `AdminChatController@index` | Halaman chat admin |
| GET | `/admin/chat/overview` | `admin.chat.overview` | `…@overview` | List percakapan + unread (badge) |
| GET | `/admin/chat/{chat}/messages` | `admin.chat.messages` | `…@messages` | Muat pesan (menandai dibaca) |
| POST | `/admin/chat/{chat}/send` | `admin.chat.send` | `…@send` | Balas pesan dari admin |
| GET | `/admin/notifications` | `admin.notifications` | `AdminNotificationController@index` | Halaman notifikasi admin |
| GET | `/admin/notifications/list` | `admin.notifications.list` | `…@list` | List JSON utk bell admin |
| POST | `/admin/notifications/read[/{id}]` | `admin.notifications.read[One]` | `…@markAsRead` | Tandai dibaca |
| GET | `/admin/profile` | `admin.profile` | `AdminProfileController@edit` | Halaman profil admin |
| PUT | `/admin/profile` | `admin.profile.update` | `…@update` | Update identitas + avatar |
| PUT | `/admin/profile/password` | `admin.profile.password` | `…@updatePassword` | Ubah kata sandi admin |

Rute admin berada dalam grup `middleware(['auth', 'admin'])`; area pelanggan dalam `auth:customer`. Semua POST/PATCH rute web → **CSRF wajib** (frontend mengirim `X-CSRF-TOKEN`).

---

## 2. Database, Migrasi & Auth

**Migrasi baru (2026_09_18_*):**
- `create_customers_table` → `customers` (`id`, `name` unique). `Customer extends Authenticatable` + `Notifiable`.
- `add_customer_and_pickup_fields_to_orders_table` → `orders`: `customer_id` (FK → customers), `queue_number` (unique, global running), `pickup_date`, `pickup_time`, `bakery_request` + index `customer_id`.
- `add_admin_fields_to_users_table` → `users`: `username` (unique), `role` (default `user`), `whatsapp_number`, `avatar_path`; index `role`.
- `create_chats_table` → `chats` (`customer_id` unique, `admin_id`, `last_message_at`).
- `create_chat_messages_table` → `chat_messages` (`chat_id` FK cascade, `sender` enum `customer|admin`, `message`, `read_by_customer`, `read_by_admin`); index `[chat_id, id]`.
- `create_notifications_table` → tabel `notifications` standar Laravel database notification (uuid PK, morphs `notifiable`, `data`, `read_at`).

**Auth:**
- `config/auth.php`: guard `customer` (driver `session`, provider `customers`) + provider `customers` (model `App\Models\Customer`).
- `app/Http/Middleware/EnsureAdmin.php` dialihkan sebagai alias `admin` di `bootstrap/app.php` → 403 untuk non-admin.
- `bootstrap/app.php`: `redirectGuestsTo` (admin/* → `admin.login`, lainnya → `home`) & `redirectUsersTo` (→ `admin.dashboard`).
- `database/seeders/AdminSeeder.php`: idempoten, cocokkan via `username` **atau** `email`, kredensial dari env (default `admin` / `bakery mahligai`). Dipanggil oleh `DatabaseSeeder`.
- `UserFactory` diperbarui (+`username`, `role`); `CustomerFactory` baru.

---

## 3. Model & Relasi

**`Order`** (`app/Models/Order.php`)
- `ORDER_STATUSES`: `pesanan_dibuat`, `menunggu_pembayaran`, `pembayaran_diproses`, `pembayaran_berhasil`, `pesanan_diproses`, `pesanan_siap`, `pesanan_selesai`, `pesanan_dibatalkan`. **Order baru default `pesanan_dibuat`** (promt6).
- `PAYMENT_STATUSES`: `belum_bayar`, `diproses`, `sukses`, `gagal`. Default `belum_bayar`.
- Fillable + `queue_number`; casts: `order_data` → array, integer uang, `queue_number`/`pickup_date` (date)/`pickup_time` (string).
- Accessors: `order_number` = `MB-` + id 4 digit (`MB-0001`); `payment_method_label`, `order_status_label`, `payment_status_label`, `pickup_label` (date + HH:MM), `wa_order_link`, `chat_whatsapp_link`.
- Relasi `customer()`; scope `latest()`, `forCustomer()`.

**`Customer`** — `Authenticatable` + `Notifiable`; relasi `orders()`, `chat()` (HasOne).

**`Chat` / `ChatMessage`** — relasi `customer()`, `admin()`, `messages()`; helper `unreadByAdmin()`, `unreadByCustomer()`; konstanta `ChatMessage::SENDER_CUSTOMER/ADMIN`.

**`User`** — + Fillable `username`, `role`, `whatsapp_number`, `avatar_path`; accessor `is_admin`.

**`AppNotification`** (`app/Notifications/AppNotification.php`) — notifikasi `database` dengan `title`/`body`/`url` (`toArray`).

> **Catatan:** `Order` tetap mandiri dari tabel produk (menu config-driven); `order_data` snapshot JSON menjaga akurasi historic.

---

## 4. Konfigurasi

### `config/business.php` — Identitas Bisnis Terpusat
- `whatsapp_number = 628113996988` (internasional, tanpa `+`/`0`), `whatsapp_display = 0811-3996-988`.
- Dipakai semua link WA (order, chat, template) via `config('business.*')`.

### `config/menu.php` — Sumber Kebenaran Menu & Harga
- Semua varian/paket/additional punya `qris_fee` (per item). Backend merekompit seluruh harga dari file ini.

---

## 5. Backend — Kalkulasi & Order

### `OrderCalculatorService::calculate()`
1. `resolveItem()` temukan group → varian/paket → additional dari `config/menu.php`.
2. Validasi: satu item harus varian ATAU paket; yang tak dikenal → `RuntimeException` → 422.
3. Harga dasar + `qris_fee` dari config × qty; additional tervalidasi; manipulasi harga dari browser tidak mungkin.

### `OrderHelper` (app/Support/OrderHelper.php)
- `normalizePhone()`: `0811-3996-988` → `628113996988`.
- `waLink($phone, $message)`, `adminOrderMessage()`.
- `customerOrderMessage(Order)`: pesan order baru yang memuat **Nomor Urut, Nomor Pesanan (MB-…), item, subtotal, metode bayar, biaya QRIS, total, Pengambilan (tanggal+jam), Request Bakery**.
- `waOrderLink(Order)`, `customerChatWhatsAppLink(Order)`.
- `nextQueueNumber()`: `(int) Order::max('queue_number') + 1` — dipanggil dalam `DB::transaction` di controller agar unik global.

### `StoreOrderRequest`
Validasi `customer_name`, `customer_phone`, `payment_method`, **`pickup_date` (required, `after_or_equal:today`)**, **`pickup_time` (required, `date_format:H:i`)**, `bakery_request` (nullable, max 1000), `items`. Harga tidak divalidasi — backend yang menentukan.

### `OrderController`
- `store()`: recompute → `DB::transaction` (tetapkan `customer_id`, `queue_number`, pickup; default `pesanan_dibuat`/`belum_bayar`) → notif semua admin ("Pesanan Baru …") → JSON `{ success, order: { order_number, queue_number, pickup, totals, qris_image, wa_link, … } }`.
- `updateStatus()`: validasi status dari konstanta, update, notifikasi pelanggan.

---

## 6. Frontend — Alur Pemesanan Pelanggan

- **Login nama saja:** `customer-login-modal` + `customer-auth.js` (fetch `/customer/login`), nama disimpan di `customers` (firstOrCreate), navbar menampilkan nama + menu dropdown; tombol login dibuka otomatis saat checkout guest.
- **`product-detail-modal` (3 langkah):** `customize` → `checkout` → `receipt` (struk). Field baru **Pickup Date** (`min` = hari ini), **Pickup Time**, **Request Bakery**. Submit → login if guest → `POST /orders` dengan spinner + tombol disable → sukses menampilkan animasi centang (CSS `success-check`, tanpa library) → **struk digital** berisi nomor urut/pesanan, item, pickup, total dari respons DB.
- **`qris-modal` + `qris.js`:** menampilkan `order_number`, total + biaya QRIS; tombol bayar berlabel; laman "Pesanan Saya" dukung `[data-customer-pay]` untuk buka QRIS langsung. Versi baru sudah menghapus ref `qrisConfirm` yang mati.
- **`order-receipt` component:** struk reusable (single source of truth `renderReceipt` di JS), parameter `data` + `viewer` (landing/account).
- **Chat pelanggan:** `customer-chat` component + `customer-chat.js` (poll `/customer/chat/poll?after=id` ~8 dtk, pause saat tab hidden, terima otomatis).
- **Notifikasi:** `customer-notifications.js` poll bell `/customer/notifications/list`, dropdown + tandai read, halaman `/customer/notifications`.
- Aplikasi: `resources/js/app.js` mengimpor module `product-modal`, `qris`, `customer-auth`, `customer-notifications`, `customer-chat`; `custom.css` (+animasi centang, chat scrollbar, pulse dot).

---

## 7. Admin — Panel (login wajib)

- **Login:** `admin/login.blade.php` + `AdminAuthController` (`Auth::attempt` + `role=admin`).
- **Layout:** `layouts/admin.blade.php` — sidebar responsif (mobile toggle + overlay), topbar bell notifikasi + ikon chat, badge unread (`data-admin-unread-chat/notif`, `data-admin-chat-topbadge`), profil bawah + logout.
- **Dashboard:** statistik (total, hari ini, menunggu bayar, total pendapatan), daftar pesanan terbaru.
- **Orders:** tabel dengan kolom Nomor (# queue + `MB-…`), pickup & request; detail dengan struk item, status form, link chat & WA; note kolom kosong → `colspan=9`.
- **Chat:** `admin/chat.blade.php` — daftar percakapan + pesan; `admin-chat.js` (pilih konversasi, muat/tandai-dibaca `/admin/chat/{id}/messages`, balas `/admin/chat/{id}/send`, polling 8 dtk, auto-buka `?chat=id`).
- **Notifications:** daftar + tandai baca; **Profile:** update nama/WA/avatar (storage public), ganti password (validasi current).
- **`resources/js/admin.js`** (entry Vite terpisah; `vite.config.js` input) → module `admin-layout.js` (sidebar, bell + badge polling 20 dtk, pause saat hidden) & `admin-chat.js`. CSS admin custom di `custom.css`.

---

## 8. Alur Data Utama

- **Order baru:** checkout → login customer (jika belum) → `POST /orders` → backend recompute + nomor urut dalam transaksi → notif admin → struk (dan Qris/WA konfirmasi). Pelanggan bisa melihat riwayat di "Pesanan Saya".
- **Chat:** pelanggan kirim → `chats`/`chat_messages` dibuat → notif admin (bell + badge). Admin buka → pesan ditandai dibaca; admin balas → notif pelanggan.
- **Notifikasi:** Laravel `notifications` (database) untuk `Customer` & `User`; ditrigger order dibuat, status berubah, chat dibalas, pesan chat masuk, welcome login.
- **Status pembayaran tetap** `belum_bayar` sampai admin memverifikasi di halaman admin — tidak ada auto-verify.

---

## 9. Testing

| File | Cakupan |
|---|---|
| `tests/Unit/OrderCalculatorServiceTest.php` | kalkulasi harga, additional, paket, qty, manipulasi diabaikan |
| `tests/Feature/OrderTest.php` | login wajib, order + queue/order number, pickup fields (valid/past), recompute, QRIS/WA, link WA |
| `tests/Feature/AdminOrdersTest.php` | guest → admin.login; list, detail, update status |
| `tests/Feature/CustomerAuthTest.php` | login nama, welcome notification, me, logout |
| `tests/Feature/AdminAuthTest.php` | login valid/invalid, non-admin diblokir (403), logout |
| `tests/Feature/CustomerOrderTest.php` | list sendiri, detail/403 lintas pelanggan, JSON struk |
| `tests/Feature/ChatTest.php` | kirim/membalas, notif kedua sisi, poll after, mark-read |
| `tests/Feature/NotificationTest.php` | halaman, list JSON, mark read (all/one) customer & admin |
| `tests/Feature/AdminProfileTest.php` | lihat, update profil/avatar, ganti password valid/invalid |

**Dijalankan:** `php artisan test` → **72 passed / 238 assertions**. Format: `vendor/bin/pint --format agent` bersih; `npm run build` sukses.

---

## 10. Daftar File Kunci (promt6)

**Migrations / Seeds / Factories:** `2026_09_18_055915`…`055921` (6 file), `AdminSeeder.php`, `DatabaseSeeder.php`, `CustomerFactory.php`, `UserFactory.php`.

**Backend:** `app/Models/{Customer,Chat,ChatMessage,Order,User}.php`, `app/Notifications/AppNotification.php`, `app/Http/Middleware/EnsureAdmin.php`, `config/auth.php`, `bootstrap/app.php`, `app/Support/OrderHelper.php`, `app/Http/Requests/StoreOrderRequest.php`, `app/Http/Controllers/{CustomerAuth,CustomerOrder,CustomerChat,CustomerNotification,AdminAuth,AdminDashboard,AdminChat,AdminNotification,AdminProfile,Order}Controller.php`, `routes/web.php`.

**Frontend pelanggan:** `customer-login-modal`,`customer-chat`,`order-receipt`,`product-detail-modal`,`qris-modal`,`navbar` (components); `customer/orders`,`order-show`,`notifications`; `js/modules/{product-modal,qris,customer-auth,customer-notifications,customer-chat}.js`; `app.js`; `custom.css`.

**Frontend admin:** `layouts/admin` + `admin/{login,dashboard,orders/index,orders/show,chat,notifications,profile}`; `js/admin.js` + `modules/{admin-layout,admin-chat}.js`; `vite.config.js` (entry admin).

**Tests:** lihat §9.

---

## 11. Catatan & Tindak Lanjut

- **QRIS:** `public/images/payment/qris.svg` masih placeholder — ganti dengan QRIS asli toko.
- **Biaya QRIS:** diset `0` di `config/menu.php`; ubah per item bila toko mulai memungut.
- **Admin seeding:** `php artisan db:seed --class=AdminSeeder` idempoten (username/email).
- **Verifikasi:** `php artisan migrate`, `npm run build`, `php artisan test`.