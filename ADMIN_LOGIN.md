# Panduan Login Admin - Bank Sampah Digital

## 🔑 Kredensial Admin

**Email:** admin@banksampah.com  
**Password:** admin123

## 🚀 Cara Login sebagai Admin

### Langkah 1: Buka Halaman Login
Buka browser dan akses:
```
http://127.0.0.1:8000/login
```

### Langkah 2: Masukkan Kredensial
- Email: `admin@banksampah.com`
- Password: `admin123`
- (Opsional) Centang "Remember Me" jika ingin tetap login

### Langkah 3: Login
Klik tombol **Login**

### Setelah Login Berhasil
Anda akan otomatis diarahkan ke:
```
http://127.0.0.1:8000/admin/dashboard
```

## 📋 Menu Admin yang Tersedia

Setelah login, Anda dapat mengakses menu-menu berikut di navigasi atas:

1. **Dashboard** - `/admin/dashboard`
   - Halaman utama admin dengan link ke semua fitur

2. **Setoran** - `/admin/setoran`
   - Laporan aktivitas dan kinerja cabang
   - Statistik setoran, komposisi sampah, pengguna teraktif

3. **Penukaran** - `/admin/penukaran`
   - Daftar permintaan penukaran dari warga
   - Status: Menunggu, Dikonfirmasi
   - Aksi: Lihat, Konfirmasi

4. **Tukar Barang** - `/admin/tukar-barang`
   - Manajemen barang reward
   - Tambah barang baru (modal dengan upload gambar)
   - Tambah stok barang yang ada

5. **Jenis Sampah** - `/admin/waste-types`
   - Kelola jenis sampah dan konversi poin
   - CRUD (Create, Read, Update, Delete)

## 🔄 Logout
Klik nama Anda di pojok kanan atas → Pilih **Log Out**

## 🛠️ Troubleshooting

### Jika Login Gagal
1. Pastikan email dan password benar (case sensitive)
2. Coba reset password dengan menjalankan:
   ```bash
   php create_admin.php
   ```

### Jika Diarahkan ke User Dashboard
- Pastikan role user adalah 'admin'
- Logout dan login kembali

### Jika Menu Admin Tidak Muncul
1. Clear cache:
   ```bash
   php artisan view:clear
   php artisan config:clear
   ```
2. Refresh browser (Ctrl + F5)

## 📝 Catatan Keamanan

⚠️ **PENTING untuk Production:**
- Ganti password default `admin123` dengan password yang kuat
- Aktifkan HTTPS
- Enable CSRF protection
- Implementasi rate limiting untuk login

## 💾 Backup Data Admin

Script untuk create/update admin tersimpan di:
```
create_admin.php
```

Jalankan script ini kapan saja untuk reset password admin.

---

**Server Status:** ✅ Running on http://127.0.0.1:8000  
**Created:** November 10, 2025
