# 📘 View Composer Guide - Data User & Saldo Poin

## ✅ Implementasi Selesai

View Composer telah dikonfigurasi di `app/Providers/AppServiceProvider.php` untuk menyediakan data user secara otomatis di **semua view Blade**.

---

## 🎯 Variabel yang Tersedia di Semua View

Setelah implementasi View Composer, variabel berikut **otomatis tersedia** di semua file `.blade.php` tanpa perlu pass dari controller:

| Variabel | Deskripsi | Contoh Nilai |
|----------|-----------|--------------|
| `$authUser` | Object user yang sedang login | `User {id: 1, name: "Budi", ...}` |
| `$saldoPoin` | Saldo poin user (balance_points) | `1500` |
| `$namaUser` | Nama lengkap user (full_name atau name) | `"Budi Santoso"` |
| `$emailUser` | Email user | `"budi.santoso@example.com"` |
| `$roleUser` | Role user (admin/user) | `"user"` atau `"admin"` |

---

## 📝 Cara Menggunakan di View Blade

### 1️⃣ **Tampilkan Nama User**
```blade
<h1>Selamat datang, {{ $namaUser }}!</h1>
```

### 2️⃣ **Tampilkan Saldo Poin**
```blade
<div>
    Saldo Anda: <strong>{{ number_format($saldoPoin, 0, ',', '.') }}</strong> poin
</div>
```

### 3️⃣ **Kondisional Berdasarkan Role**
```blade
@if($roleUser === 'admin')
    <p>Anda adalah admin</p>
@else
    <p>Anda adalah warga</p>
@endif
```

### 4️⃣ **Akses Data User Lengkap**
```blade
<div>
    <p>ID: {{ $authUser->id }}</p>
    <p>Email: {{ $authUser->email }}</p>
    <p>Member sejak: {{ $authUser->created_at->format('d M Y') }}</p>
</div>
```

### 5️⃣ **Format Angka dengan Pemisah Ribuan**
```blade
{{-- Tanpa desimal --}}
{{ number_format($saldoPoin, 0, ',', '.') }}
{{-- Output: 1.500 --}}

{{-- Dengan desimal --}}
{{ number_format($saldoPoin, 2, ',', '.') }}
{{-- Output: 1.500,00 --}}
```

---

## 🔧 Kode Implementasi di AppServiceProvider

File: `app/Providers/AppServiceProvider.php`

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // View Composer untuk menyediakan data user dan saldo poin secara global
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                // Variabel yang tersedia di semua view
                $view->with([
                    'authUser' => $user,
                    'saldoPoin' => $user->balance_points ?? 0,
                    'namaUser' => $user->full_name ?? $user->name ?? 'User',
                    'emailUser' => $user->email ?? '',
                    'roleUser' => $user->role ?? 'user',
                ]);
            }
        });
    }
}
```

**Penjelasan:**
- `View::composer('*', ...)` → Berlaku untuk **semua view** (`*` = wildcard)
- `Auth::check()` → Cek apakah user sudah login
- `$view->with([...])` → Inject variabel ke semua view

---

## 📍 Contoh Implementasi di Navigation (Header)

File: `resources/views/layouts/navigation.blade.php`

### Desktop Navigation (Tampilkan Saldo Poin)
```blade
{{-- Tampilkan Saldo Poin untuk User/Warga --}}
@if($roleUser === 'user')
    <div class="me-4 px-3 py-2 bg-green-50 border border-green-200 rounded-md">
        <span class="text-xs text-gray-600">Saldo Poin:</span>
        <span class="ms-1 text-sm font-bold text-green-600">
            {{ number_format($saldoPoin, 0, ',', '.') }}
        </span>
    </div>
@endif
```

### Dropdown User Info
```blade
<div class="px-4 py-2 border-b border-gray-200">
    <div class="text-sm font-medium text-gray-800">{{ $namaUser }}</div>
    <div class="text-xs text-gray-500">{{ $emailUser }}</div>
    @if($roleUser === 'user')
        <div class="mt-1 text-xs text-green-600 font-semibold">
            💰 {{ number_format($saldoPoin, 0, ',', '.') }} poin
        </div>
    @endif
</div>
```

---

## 🎨 Styling Saldo Poin (Best Practices)

### Badge Style
```blade
<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
    <i class="bi bi-coin me-1"></i>
    {{ number_format($saldoPoin, 0, ',', '.') }} poin
</span>
```

### Card Style
```blade
<div class="bg-gradient-to-r from-green-100 to-green-50 px-6 py-3 rounded-lg border border-green-200">
    <p class="text-xs text-gray-600 mb-1">Total Poin</p>
    <p class="text-2xl font-bold text-green-700">
        {{ number_format($saldoPoin, 0, ',', '.') }}
    </p>
</div>
```

---

## 🚀 Keuntungan Menggunakan View Composer

✅ **DRY Principle** → Tidak perlu menulis `compact('user', 'saldoPoin')` di setiap controller  
✅ **Konsistensi Data** → Data user dan saldo poin selalu sinkron di semua halaman  
✅ **Mudah Maintenance** → Update di satu tempat (AppServiceProvider), berlaku di semua view  
✅ **Performa Baik** → Data di-load sekali saat view di-render  
✅ **Clean Code** → Controller jadi lebih bersih dan fokus pada logic bisnis  

---

## 🔄 Update Data Real-time

Jika ingin data saldo poin selalu terkini (misalnya setelah transaksi), lakukan **refresh user** di controller:

```php
// Setelah transaksi sukses
auth()->user()->refresh();

// Atau redirect dengan pesan
return redirect()->route('dashboard')
    ->with('success', 'Transaksi berhasil!');
```

Data akan otomatis ter-update karena View Composer mengambil dari `Auth::user()` yang fresh.

---

## 🛠️ Troubleshooting

### ❌ Problem: Variabel tidak tersedia
**Penyebab:** User belum login  
**Solusi:** Pastikan route dilindungi dengan `auth` middleware

### ❌ Problem: Saldo tidak update setelah transaksi
**Penyebab:** Cache user object  
**Solusi:** Panggil `auth()->user()->refresh()` setelah update database

### ❌ Problem: Error "Undefined variable"
**Penyebab:** AppServiceProvider tidak ter-load  
**Solusi:** Clear cache dengan `php artisan config:clear` dan `php artisan view:clear`

---

## 📚 Referensi

- [Laravel View Composers](https://laravel.com/docs/11.x/views#view-composers)
- [Service Providers](https://laravel.com/docs/11.x/providers)
- [Authentication](https://laravel.com/docs/11.x/authentication)

---

## ✨ Contoh Penggunaan di Dashboard

```blade
<div class="container">
    <h1>Dashboard {{ $namaUser }}</h1>
    
    <div class="stats">
        <div class="card">
            <h3>Saldo Poin Anda</h3>
            <p class="text-3xl font-bold">
                {{ number_format($saldoPoin, 0, ',', '.') }}
            </p>
        </div>
        
        @if($roleUser === 'user')
            <div class="card">
                <p>Anda adalah member sejak:</p>
                <p>{{ $authUser->created_at->format('d F Y') }}</p>
            </div>
        @endif
    </div>
</div>
```

---

**🎉 Selamat! View Composer sudah siap digunakan!**

Sekarang Anda bisa menggunakan `$namaUser`, `$saldoPoin`, `$roleUser`, dll. di semua file Blade tanpa perlu pass dari controller.
