# Dokumentasi Fitur Lupa Password

## Ringkasan
Fitur "Lupa Password" yang telah diimplementasikan adalah sistem reset password modern yang **tidak bergantung pada email server**. User dapat dengan mudah mereset password mereka melalui proses verifikasi 2 tahap dengan kode 6 digit.

## Alur Kerja

### 1. **Halaman Lupa Password** (`/forgot-password`)
- User memasukkan email mereka
- Sistem cek apakah email terdaftar
- Jika ada, generate kode reset 6 digit (random)
- Kode disimpan di database dengan expiry 15 menit
- Kode ditampilkan di console/debug bar (dev mode) untuk testing
- **Di production, kode bisa dikirim via SMS atau email service**

### 2. **Halaman Verifikasi Kode** (`/verify-reset-code`)
- User memasukkan email (otomatis dari step 1)
- User memasukkan kode 6 digit yang diterima
- Sistem validasi:
  - Apakah kode valid?
  - Apakah kode belum expired?
- Jika valid, redirect ke form reset password

### 3. **Halaman Reset Password** (`/reset-password-form`)
- User membuat password baru (minimal 8 karakter)
- User konfirmasi password
- Sistem validasi kecocokan password
- Password dienkripsi dan disimpan
- Kode reset dihapus dari database
- Redirect ke login dengan pesan sukses

## Routes

```
GET  /forgot-password          → Tampil form lupa password
POST /forgot-password/send     → Proses pengiriman kode
GET  /verify-reset-code        → Tampil form verifikasi kode
POST /verify-reset-code        → Verifikasi kode
GET  /reset-password-form      → Tampil form reset password
POST /reset-password           → Proses reset password
```

## Database Schema

Kolom baru di table `users`:
```php
password_reset_code        (string, nullable)
password_reset_expires_at  (timestamp, nullable)
```

## Controller

File: `app/Http/Controllers/Auth/ForgotPasswordController.php`

**Methods:**
- `showForm()` - Tampilkan form lupa password
- `sendReset()` - Generate dan simpan kode reset
- `showVerifyCode()` - Tampilkan form verifikasi kode
- `verifyCode()` - Validasi kode reset
- `showResetForm()` - Tampilkan form reset password
- `resetPassword()` - Proses reset password

## Views

1. `resources/views/auth/forgot-password-custom.blade.php`
   - Form input email
   - Tombol "Kirim Kode Reset"

2. `resources/views/auth/verify-reset-code.blade.php`
   - Form input 6 digit kode
   - Auto-format input angka saja
   - Countdown timer (opsional)

3. `resources/views/auth/reset-password-custom.blade.php`
   - Form input password & konfirmasi
   - Toggle show/hide password
   - Email read-only untuk referensi

## Security Features

✅ **Password Hashing** - Password dienkripsi dengan bcrypt
✅ **Code Expiration** - Kode reset valid hanya 15 menit
✅ **Code Invalidation** - Kode dihapus setelah berhasil reset
✅ **Email Verification** - User harus punya email terdaftar
✅ **Password Strength** - Minimal 8 karakter required
✅ **Rate Limiting** - Bisa ditambahkan via middleware

## Cara Testing

### 1. Lupa Password (Dev Mode)
```
1. Klik "Lupa Password" di login page
2. Masukkan email user (contoh: martua.sitorus@gmail.com)
3. Klik "Kirim Kode Reset"
4. Buka DevTools Console atau LogStream
5. Cari pesan "Password reset code for [email]: 123456"
6. Copy kode tersebut
7. Masukkan kode di form verifikasi
8. Buat password baru
9. Login dengan password baru
```

### 2. Test dengan Script PHP
```php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$user = User::where('email', 'martua.sitorus@gmail.com')->first();
echo "Password Reset Code: " . $user->password_reset_code . "\n";
echo "Expires At: " . $user->password_reset_expires_at . "\n";
```

## Integrasi SMS (Optional)

Untuk mengirim kode via SMS, update method `sendReset()` di `ForgotPasswordController`:

```php
public function sendReset(Request $request)
{
    // ... existing code ...
    
    // Kirim via SMS (contoh dengan Twilio)
    // Twilio::message($user->phone, "Kode reset: $resetCode");
    
    // Atau kirim via Email
    // Mail::send(new PasswordResetMail($user, $resetCode));
}
```

## Troubleshooting

### Kode tidak terlihat
**Solusi:** Kode ditampilkan di Laravel Log. Buka file:
```
storage/logs/laravel.log
```
Cari string: `Password reset code for`

### Kode sudah expired
**Solusi:** Generate ulang dengan submit form lupa password lagi (valid 15 menit)

### Email tidak terdaftar
**Solusi:** User harus register dulu di `/register` atau hubungi admin untuk dibuat manual

## Fitur Tambahan (Opsional)

Bisa ditambahkan di masa depan:
- [ ] SMS Gateway integration (Twilio, Nexmo, dll)
- [ ] Email service integration
- [ ] Rate limiting per IP
- [ ] Resend code button (countdown 30 detik)
- [ ] Admin panel untuk reset user password
- [ ] Activity log untuk setiap reset attempt
- [ ] Two-Factor Authentication dengan OTP

---

**Status:** ✅ Live dan Ready to Use
**Last Updated:** 9 Dec 2025
