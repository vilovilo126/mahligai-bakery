Setelah seluruh implementasi selesai, buatkan dokumentasi lengkap mengenai semua perubahan yang telah kamu lakukan pada project.

Saya ingin dokumentasi ditampilkan dengan struktur yang jelas dan mudah dipahami.

Untuk SETIAP file dan folder yang dibuat atau diubah, tampilkan:

1. Path/lokasi folder
2. Nama file
3. Status:
   - File baru
   - File yang diubah
   - File yang dihapus (jika ada)
4. Kegunaan file tersebut
5. Bagian kode atau fitur apa yang ditangani
6. Hubungan file tersebut dengan file lain
7. Jika file berhubungan dengan database, jelaskan tabel, migration, model, field, relasi, dan kegunaannya
8. Jika file berhubungan dengan frontend, jelaskan component, JavaScript, CSS, Tailwind CSS, modal, carousel, filter, dan interaksi yang digunakan
9. Jika file berhubungan dengan backend Laravel, jelaskan Controller, Model, Service, Route, Migration, Seeder, dan fungsi masing-masing
10. Jika file berhubungan dengan AI Gemini, jelaskan alur request dari frontend → backend → Gemini → response dan lokasi environment variable API Key tanpa menampilkan API Key asli

Tampilkan struktur folder project setelah implementasi dalam bentuk tree, contohnya:

project/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── Services/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
└── tests/

Setelah tree, jelaskan SATU PER SATU setiap folder dan file yang dibuat atau diubah.

Contoh format:

### 1. config/menu.php
Status: File baru

Kegunaan:
File ini digunakan untuk menyimpan seluruh data katalog Mahligai Bakery seperti kategori, nama produk, varian, harga, paket, Additional, dan informasi lainnya.

Digunakan oleh:
- home/index.blade.php
- menu.js
- Product detail modal

### 2. resources/js/menu.js
Status: File baru

Kegunaan:
Menangani interaksi Menu seperti filter kategori, membuka detail produk, modal, dan interaksi katalog.

### 3. resources/css/custom.css
Status: File diubah

Kegunaan:
Menangani styling tambahan yang tidak ditangani oleh Tailwind CSS seperti animasi, hover effect, modal transition, dan elemen visual lainnya.

Jangan hanya memberikan daftar file yang kamu ingat. Periksa kondisi project SEBENARNYA setelah implementasi selesai dan dokumentasikan file yang benar-benar dibuat, diubah, dipindahkan, atau dihapus.

Jangan menghilangkan file yang sudah ada dari dokumentasi hanya karena file tersebut tidak dibuat oleh implementasi ini. Jika file lama digunakan atau dimodifikasi untuk fitur baru, jelaskan juga.

Jika ada file yang tidak jadi digunakan atau dibuat tetapi sempat direncanakan, pisahkan ke bagian:

"File yang direncanakan tetapi tidak dibuat/digunakan"

Jika ada migration baru, tampilkan nama migration dan jelaskan perubahan database yang dilakukan.

Jika ada Model baru, tampilkan nama Model dan tabel yang digunakan.

Jika ada Controller baru, tampilkan route atau fitur yang menggunakan Controller tersebut.

Jika ada JavaScript, CSS, Blade, PHP, config, migration, seeder, test, atau file lainnya, semuanya harus dicantumkan.

Di bagian terakhir, buat:

## ALUR SISTEM

Jelaskan alur bagaimana pengguna membuka halaman Menu sampai melihat detail produk.

Contoh:

User
↓
Homepage
↓
Menu Section
↓
Filter kategori
↓
Product Card
↓
Product Detail Modal
↓
Data dari config/menu.php

Kemudian buat:

## RINGKASAN PERUBAHAN

- Jumlah file baru
- Jumlah file diubah
- Jumlah file dihapus
- Migration baru
- Model baru
- Controller baru
- JavaScript baru/diubah
- CSS baru/diubah
- Blade/View baru/diubah
- Config baru/diubah
- Test baru/diubah

PENTING:
- Jangan menampilkan API Key Gemini yang asli.
- Jangan mengarang file yang tidak ada.
- Jangan hanya menjelaskan berdasarkan plan.
- Dokumentasikan berdasarkan kondisi project SEBENARNYA setelah implementasi selesai.
- Jika ada ketidakpastian, periksa file project terlebih dahulu.
- Saya ingin dokumentasi ini lengkap karena akan saya gunakan untuk memahami struktur project dan sebagai dokumentasi pengerjaan.

Jangan berhenti hanya pada ringkasan. Saya ingin setiap file yang berkaitan dengan fitur Menu Mahligai Bakery dijelaskan sampai saya bisa memahami fungsi masing-masing file tanpa harus membuka kodenya terlebih dahulu.