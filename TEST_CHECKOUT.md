# 🧪 TEST CHECKOUT - Langkah demi Langkah

## Persiapan

```bash
# 1. Clear cache
php artisan view:clear
php artisan config:clear
php artisan cache:clear

# 2. Pastikan ada data kursus
php artisan db:seed --class=CourseSeeder

# 3. Jalankan server
php artisan serve
```

## Test Flow Checkout

### 1. Buka Browser
Buka: **http://localhost:8000**

### 2. Register Akun Siswa Baru
- Klik **Daftar** atau buka `/register`
- Isi form:
  - Nama Lengkap: `Test Siswa`
  - Username: `testsiswa`
  - Email: `test@siswa.com`
  - Password: `test1234`
  - Konfirmasi Password: `test1234`
- Klik **Daftar**
- Harus otomatis login dan masuk ke dashboard siswa

### 3. Tambah Paket ke Keranjang
**Dari Dashboard:**
- Scroll ke bawah ke bagian "Paket Tersedia"
- Klik tombol **"🛒 Tambah ke Keranjang"** di salah satu paket
- Harus muncul notifikasi hijau: "✅ Paket ditambahkan ke keranjang"

**Atau dari Halaman Kursus:**
- Klik menu **"Semua Kursus"** di sidebar
- Klik **"Lihat Detail"** di salah satu kursus
- Klik **"Tambah ke Keranjang"**

### 4. Lihat Keranjang
- Klik **"Keranjang"** di sidebar atau topbar
- Harus muncul paket yang sudah ditambahkan
- Ada tombol **"Hapus"** dan total harga
- Ada tombol **"Checkout"** di bawah

### 5. Checkout
- Klik tombol **"Checkout"**
- Harus redirect ke `/orders/create`
- Muncul halaman **"Konfirmasi Pesanan"**
- Ada list item yang akan dibeli
- Ada total harga
- Ada tombol **"Buat Pesanan"**

### 6. Buat Pesanan
- Klik tombol **"Buat Pesanan"**
- Harus redirect ke `/orders/{id}` (detail pesanan)
- Muncul notifikasi: "✅ Pesanan berhasil dibuat. Menunggu pembayaran."
- Status pesanan: **⏳ Pending**
- Keranjang otomatis kosong

### 7. Cek Dashboard
- Kembali ke dashboard
- Di bagian **"Pesanan Menunggu Konfirmasi"** harus muncul pesanan baru
- Stat card **"Menunggu Bayar"** harus bertambah

### 8. Konfirmasi Pembayaran (Admin)
- Logout dari akun siswa
- Login sebagai admin:
  - Username: `admin`
  - Password: `admin123`
- Masuk ke **"Kelola Pesanan"**
- Cari pesanan dari siswa tadi
- Klik tombol **"✅ Konfirmasi Bayar"**
- Status berubah jadi **✅ Lunas**

### 9. Cek Paket Aktif (Siswa)
- Logout dari admin
- Login kembali sebagai siswa (`testsiswa` / `test1234`)
- Masuk ke dashboard
- Di bagian **"Paket Belajar Saya"** harus muncul paket yang sudah dibeli
- Badge: **"✅ Sudah Dimiliki"**

---

## ❌ Jika Ada Error

### Error: "Keranjang kosong" padahal sudah tambah
**Penyebab:** Session tidak tersimpan atau CSRF token issue

**Solusi:**
```bash
# Clear semua cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Restart server
# Ctrl+C untuk stop
php artisan serve
```

### Error: "419 Page Expired" saat submit form
**Penyebab:** CSRF token expired

**Solusi:**
- Refresh halaman (F5)
- Submit form lagi

### Error: "Whoops, something went wrong"
**Penyebab:** Ada error PHP

**Solusi:**
1. Cek log: `storage/logs/laravel.log`
2. Atau aktifkan debug mode di `.env`:
   ```
   APP_DEBUG=true
   ```
3. Refresh halaman untuk lihat error detail

### Error: Redirect loop atau halaman blank
**Penyebab:** Middleware atau session issue

**Solusi:**
```bash
# Clear session
php artisan session:flush

# Clear config
php artisan config:clear

# Restart server
```

---

## 🔍 Debug Mode

Jika masih error, aktifkan debug mode:

### 1. Edit `.env`
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### 2. Restart Server
```bash
# Stop server (Ctrl+C)
php artisan serve
```

### 3. Ulangi Test
- Error detail akan muncul di halaman
- Copy paste error message untuk troubleshooting

---

## ✅ Checklist Test

- [ ] Register siswa baru berhasil
- [ ] Login siswa berhasil
- [ ] Dashboard siswa muncul dengan benar
- [ ] Tambah ke keranjang berhasil
- [ ] Keranjang menampilkan item
- [ ] Checkout page muncul
- [ ] Buat pesanan berhasil
- [ ] Pesanan muncul di riwayat (status: pending)
- [ ] Admin bisa konfirmasi pembayaran
- [ ] Status pesanan berubah jadi paid
- [ ] Paket muncul di "Paket Belajar Saya"

---

## 📸 Screenshot yang Dibutuhkan (Jika Error)

1. **Error message** (full screen)
2. **Browser console** (F12 → Console tab)
3. **Network tab** (F12 → Network tab, filter: XHR/Fetch)
4. **Laravel log** (`storage/logs/laravel.log` - 50 baris terakhir)

---

**Jika semua checklist ✅, berarti checkout sudah jalan sempurna!**
