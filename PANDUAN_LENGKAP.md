# 📚 PANDUAN LENGKAP - PT KOMARI WEB KURSUS

## 🚀 Cara Menjalankan Aplikasi

### 1. Jalankan Server Laravel
```bash
php artisan serve
```
Buka browser ke: **http://localhost:8000**

### 2. (Opsional) Jika Pakai Laragon
Pastikan Laragon sudah running, lalu buka: **http://websiteptkomari.test**

---

## 👥 AKUN DEFAULT

### Admin
- **Username:** `admin`
- **Password:** `admin123`
- **Akses:** Dashboard admin, kelola kursus, kelola pesanan

### Siswa (Test)
- **Username:** `andi123`
- **Password:** `andi1234`
- **Akses:** Dashboard siswa, beli paket kursus

---

## 🎯 FITUR APLIKASI

### 🔐 UNTUK SISWA/PELANGGAN

#### 1. Register Akun Baru
- Buka `/register`
- Isi form:
  - Nama Lengkap
  - Username (unik)
  - Email (unik)
  - Password (min 6 karakter)
  - Konfirmasi Password (harus sama)
- Klik **Daftar**
- Otomatis login dan masuk ke dashboard siswa

#### 2. Login
- Buka `/login`
- Masukkan username & password
- Klik **Login**
- Redirect ke dashboard siswa

#### 3. Dashboard Siswa (`/dashboard`)
**Fitur:**
- Sidebar kiri dengan menu navigasi
- Hero card dengan sapaan nama
- 3 stat card: Paket Aktif, Di Keranjang, Menunggu Bayar
- Grid **Paket Belajar Saya** (paket yang sudah dibeli & lunas)
- Grid **Paket Tersedia** (paket yang belum dibeli)
- List **Pesanan Pending** (menunggu konfirmasi admin)

#### 4. Lihat Semua Kursus (`/courses`)
- Daftar semua kursus aktif
- Klik **Lihat Detail** untuk info lengkap
- Tombol **Tambah ke Keranjang**

#### 5. Detail Kursus (`/courses/{id}`)
- Deskripsi lengkap kursus
- Harga
- Tombol **Tambah ke Keranjang**
- Form rating (bisa kasih rating 1-5 + review)

#### 6. Keranjang (`/cart`)
- Lihat semua item di keranjang
- Hapus item dari keranjang
- Total harga
- Tombol **Checkout**

#### 7. Checkout (`/orders/create`)
- Konfirmasi pesanan
- Review item yang akan dibeli
- Total harga
- Tombol **Buat Pesanan**
- Setelah buat pesanan → status **pending** (menunggu konfirmasi admin)

#### 8. Riwayat Pesanan (`/orders`)
- Semua pesanan (pending & paid)
- Status pesanan
- Detail per pesanan

#### 9. Detail Pesanan (`/orders/{id}`)
- Info lengkap pesanan
- Item yang dibeli
- Total harga
- Status pembayaran

---

### 🛡️ UNTUK ADMIN

#### 1. Login Admin
- Buka `/login`
- Username: `admin`
- Password: `admin123`
- Otomatis redirect ke `/admin`

#### 2. Dashboard Admin (`/admin`)
**Fitur:**
- Welcome bar dengan nama admin
- 4 stat card:
  - Total Pesanan
  - Total Pendapatan (dari pesanan lunas)
  - Pending Orders (menunggu konfirmasi)
  - Total Kursus
- Quick actions: Kelola Kursus & Kelola Pesanan
- Tabel 5 pesanan terbaru

#### 3. Kelola Kursus (`/admin/courses`)
**Fitur:**
- Form tambah kursus baru (nama, harga, deskripsi, status)
- Tabel semua kursus
- Tombol **Edit** (modal popup)
- Tombol **Hapus**
- Status aktif/nonaktif per kursus

#### 4. Kelola Pesanan (`/admin/orders`)
**Fitur:**
- Tabel semua pesanan
- Info pelanggan (nama, email)
- Kursus yang dibeli
- Total harga
- Status (pending/paid)
- Tombol **Konfirmasi Bayar** (ubah status pending → paid)
- Tombol **Reset** (ubah paid → pending)

---

## 🔄 ALUR PEMBELIAN PAKET KURSUS

### Dari Sisi Siswa:
1. **Register/Login** → masuk ke dashboard
2. **Lihat kursus** → pilih paket yang diinginkan
3. **Tambah ke keranjang** → bisa tambah beberapa paket
4. **Checkout** → buat pesanan (status: **pending**)
5. **Menunggu konfirmasi** → admin akan konfirmasi pembayaran
6. **Setelah dikonfirmasi** → status jadi **paid**, paket masuk ke "Paket Belajar Saya"

### Dari Sisi Admin:
1. **Login admin** → masuk ke dashboard admin
2. **Lihat pesanan pending** → di dashboard atau `/admin/orders`
3. **Konfirmasi pembayaran** → klik tombol "Konfirmasi Bayar"
4. **Status berubah** → pesanan jadi **paid**, siswa bisa akses paket

---

## 📁 STRUKTUR FILE PENTING

### Controllers
- `app/Http/Controllers/AuthController.php` - Login, register, logout
- `app/Http/Controllers/DashboardController.php` - Dashboard siswa
- `app/Http/Controllers/CourseController.php` - Lihat kursus
- `app/Http/Controllers/CartController.php` - Keranjang
- `app/Http/Controllers/OrderController.php` - Pesanan
- `app/Http/Controllers/AdminController.php` - Dashboard & kelola admin
- `app/Http/Controllers/RatingController.php` - Rating kursus

### Views
- `resources/views/auth/login.blade.php` - Halaman login
- `resources/views/auth/register.blade.php` - Halaman register
- `resources/views/dashboard.blade.php` - Dashboard siswa
- `resources/views/courses/` - Halaman kursus
- `resources/views/cart/` - Halaman keranjang
- `resources/views/orders/` - Halaman pesanan
- `resources/views/admin/` - Halaman admin

### Models
- `app/Models/User.php` - User (siswa & admin)
- `app/Models/Course.php` - Kursus
- `app/Models/Cart.php` - Keranjang
- `app/Models/Order.php` - Pesanan
- `app/Models/OrderItem.php` - Item pesanan
- `app/Models/Rating.php` - Rating kursus

### Routes
- `routes/web.php` - Semua route aplikasi

### Middleware
- `app/Http/Middleware/AdminMiddleware.php` - Proteksi route admin

---

## 🐛 TROUBLESHOOTING

### Problem: Login/Register refresh tanpa masuk
**Solusi:** Sudah difix! Pastikan:
- Field password confirmation di register: `name="password_confirmation"`
- Error ditampilkan dengan `@if($errors->any())`

### Problem: Dashboard siswa tidak muncul
**Solusi:** Sudah difix! Dashboard siswa sekarang full design dengan sidebar.

### Problem: Admin bisa diakses siapa saja
**Solusi:** Sudah difix! Route `/admin/*` dilindungi middleware `admin`.

### Problem: Tidak ada data kursus
**Solusi:** Jalankan seeder:
```bash
php artisan db:seed --class=CourseSeeder
```

### Problem: Tidak ada akun admin
**Solusi:** Jalankan seeder:
```bash
php artisan db:seed --class=AdminSeeder
```

---

## 🎨 DESAIN & TAMPILAN

### Dashboard Siswa
- **Sidebar kiri** (fixed): Logo, user info, menu navigasi, logout
- **Topbar**: Judul halaman, tanggal, tombol keranjang & tambah paket
- **Hero card hijau**: Sapaan + info paket aktif
- **3 stat card**: Paket aktif, di keranjang, menunggu bayar
- **Grid paket**: Icon per mata pelajaran, badge status
- **Dark theme**: Background #0B1120, card #0F172A

### Dashboard Admin
- **Welcome bar hijau**: Sapaan admin + badge administrator
- **4 stat card**: Total pesanan, pendapatan, pending, kursus
- **Quick actions**: 2 card besar untuk menu utama
- **Tabel pesanan terbaru**: 5 pesanan terakhir

### Halaman Admin Kursus
- **Form tambah**: Nama, harga, deskripsi, status
- **Tabel**: ID, nama, deskripsi, harga, status, aksi
- **Modal edit**: Popup untuk edit tanpa pindah halaman

### Halaman Admin Pesanan
- **Tabel lengkap**: Order ID, pelanggan, kursus, total, status, tanggal
- **Tombol aksi**: Konfirmasi bayar, reset status

---

## 📊 DATABASE

### Tables
- `users` - User (siswa & admin)
- `courses` - Kursus
- `carts` - Keranjang
- `orders` - Pesanan
- `order_items` - Item per pesanan
- `ratings` - Rating kursus

### Seeder
- `CourseSeeder` - 4 kursus default (Matematika, Bahasa Inggris, IPA, IPS)
- `AdminSeeder` - 1 admin default

---

## ✅ CHECKLIST FITUR

### Siswa
- [x] Register akun baru
- [x] Login
- [x] Dashboard dengan sidebar
- [x] Lihat semua kursus
- [x] Detail kursus
- [x] Tambah ke keranjang
- [x] Lihat keranjang
- [x] Hapus dari keranjang
- [x] Checkout (buat pesanan)
- [x] Riwayat pesanan
- [x] Detail pesanan
- [x] Kasih rating kursus
- [x] Lihat paket yang sudah dibeli

### Admin
- [x] Login admin
- [x] Dashboard admin dengan stats
- [x] Tambah kursus baru
- [x] Edit kursus
- [x] Hapus kursus
- [x] Lihat semua pesanan
- [x] Konfirmasi pembayaran (pending → paid)
- [x] Reset status pesanan
- [x] Middleware proteksi route admin
- [x] Redirect otomatis berdasarkan role

---

## 🔒 KEAMANAN

- [x] Password di-hash dengan bcrypt
- [x] CSRF protection di semua form
- [x] Middleware auth untuk halaman yang butuh login
- [x] Middleware admin untuk route `/admin/*`
- [x] Validation di semua input form
- [x] Session regeneration setelah login

---

## 🚀 NEXT STEPS (Opsional)

1. **Payment Gateway**: Integrasi Midtrans/Xendit untuk pembayaran otomatis
2. **Email Notification**: Kirim email konfirmasi setelah pesanan dibuat
3. **Upload Materi**: Admin bisa upload file PDF/video untuk setiap kursus
4. **Progress Tracking**: Siswa bisa track progress belajar
5. **Certificate**: Generate sertifikat setelah selesai kursus
6. **Live Chat**: Chat antara siswa dan admin
7. **Promo Code**: Sistem diskon dengan kode promo

---

## 📞 SUPPORT

Jika ada masalah atau pertanyaan, cek:
1. Log Laravel: `storage/logs/laravel.log`
2. Browser console untuk error JavaScript
3. Network tab di browser DevTools untuk error AJAX

---

**Dibuat dengan ❤️ untuk PT Komari**
