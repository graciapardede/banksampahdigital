# 🚀 Quick Reference - View Composer

## ✅ Setup Selesai!

View Composer sudah aktif. Variabel berikut **otomatis tersedia** di semua file `.blade.php`:

## 📦 Variabel Global

```php
$authUser   // Object User lengkap
$saldoPoin  // Integer balance_points
$namaUser   // String full_name/name
$emailUser  // String email
$roleUser   // String 'admin' atau 'user'
```

## 💡 Contoh Cepat

```blade
{{-- Nama user --}}
<h1>Hai, {{ $namaUser }}!</h1>

{{-- Saldo dengan format --}}
<p>Saldo: {{ number_format($saldoPoin, 0, ',', '.') }} poin</p>

{{-- Kondisi role --}}
@if($roleUser === 'admin')
    <p>Anda admin</p>
@endif

{{-- Object user lengkap --}}
<p>ID: {{ $authUser->id }}</p>
<p>Branch: {{ $authUser->branch->name }}</p>
```

## 📍 Lokasi File

- **View Composer:** `app/Providers/AppServiceProvider.php`
- **Contoh Implementasi:** `resources/views/layouts/navigation.blade.php`
- **Panduan Lengkap:** `VIEW_COMPOSER_GUIDE.md`
- **Contoh Kode:** `resources/views/examples/view-composer-usage.blade.php`

## 🎯 Keuntungan

✅ Tidak perlu `compact()` di setiap controller  
✅ Data selalu konsisten di semua halaman  
✅ Code lebih bersih dan DRY  
✅ Otomatis tersedia tanpa setup tambahan  

## 🔄 Clear Cache (jika perlu)

```bash
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

---

**Sekarang tinggal pakai!** 🎉
