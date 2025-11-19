# CARA MENGGUNAKAN KOMPONEN ADMIN HEADER

## File Komponen: `resources/views/components/admin-header.blade.php`

Komponen header admin telah dibuat dengan fitur:
- ✅ Logo dan info admin
- ✅ Badge Administrator
- ✅ **Notifikasi Lonceng** dengan dropdown (AlpineJS)
- ✅ Badge merah untuk unread notifications
- ✅ Dropdown menampilkan 5 notifikasi terbaru
- ✅ Auto-hide dropdown saat klik di luar
- ✅ Link ke detail transaksi dari notifikasi
- ✅ Navigation tabs dengan active state
- ✅ Tombol Logout

---

## CARA MENGGANTI HEADER LAMA

### **SEBELUM (Header Hardcoded):**

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header Lama (HAPUS INI) -->
    <header class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    ...
                </div>
                <!-- Admin Actions -->
                <div class="flex items-center space-x-4">
                    ...
                </div>
            </div>
        </div>
        <!-- Navigation Tabs -->
        <div class="bg-green-100 px-4 py-4">
            ...
        </div>
    </header>

    <!-- Main Content -->
    <main>
        ...
    </main>
</body>
</html>
```

### **SESUDAH (Menggunakan Komponen):**

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin - Green Saving</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 to-green-100 font-poppins">

    <!-- Header Baru (Komponen) -->
    <x-admin-header activePage="penukaran" />

    <!-- Main Content -->
    <main>
        ...
    </main>
</body>
</html>
```

---

## PARAMETER KOMPONEN

### `activePage` (Optional)
Menentukan tab mana yang aktif (dengan background hijau).

**Nilai yang valid:**
- `dashboard` - Tab Dashboard aktif
- `setoran` - Tab Setoran aktif
- `penukaran` - Tab Penukaran aktif
- `reward-items` - Tab Tukar Barang aktif
- `waste-types` - Tab Jenis Sampah aktif
- `laporan` - Tab Laporan aktif

**Contoh Penggunaan:**

```blade
{{-- Halaman Dashboard --}}
<x-admin-header activePage="dashboard" />

{{-- Halaman Setoran --}}
<x-admin-header activePage="setoran" />

{{-- Halaman Penukaran --}}
<x-admin-header activePage="penukaran" />

{{-- Halaman Tukar Barang --}}
<x-admin-header activePage="reward-items" />

{{-- Halaman Jenis Sampah --}}
<x-admin-header activePage="waste-types" />

{{-- Halaman Laporan --}}
<x-admin-header activePage="laporan" />

{{-- Tanpa parameter (tidak ada tab aktif) --}}
<x-admin-header />
```

---

## CONTOH UPDATE FILE ADMIN

### 1. **Update `resources/views/admin/penukaran/index.blade.php`**

**Ganti baris 25-113 dengan:**
```blade
<!-- Header -->
<x-admin-header activePage="penukaran" />
```

### 2. **Update `resources/views/admin/setoran/index.blade.php`**

**Ganti header lama dengan:**
```blade
<!-- Header -->
<x-admin-header activePage="setoran" />
```

### 3. **Update `resources/views/admin/dashboard.blade.php`**

**Ganti header lama dengan:**
```blade
<!-- Header -->
<x-admin-header activePage="dashboard" />
```

### 4. **Update `resources/views/admin/reward-items/index.blade.php`**

**Ganti header lama dengan:**
```blade
<!-- Header -->
<x-admin-header activePage="reward-items" />
```

### 5. **Update `resources/views/admin/waste-types/index.blade.php`**

**Ganti header lama dengan:**
```blade
<!-- Header -->
<x-admin-header activePage="waste-types" />
```

### 6. **Update `resources/views/admin/laporan/index.blade.php`**

**Ganti header lama dengan:**
```blade
<!-- Header -->
<x-admin-header activePage="laporan" />
```

---

## STRUKTUR DATA NOTIFIKASI

Komponen ini mengharapkan notifikasi memiliki struktur data:

```php
[
    'title' => 'Judul Notifikasi',
    'message' => 'Pesan singkat (optional)',
    'link' => '/admin/penukaran/123',  // Link ke detail
    'type' => 'deposit' atau 'redemption' (optional, untuk icon)
]
```

**Contoh di Controller/Notification Class:**

```php
// Notifikasi Deposit
$admin->notify(new SetoranDiverifikasi($deposit, [
    'title' => 'Setoran Baru Terverifikasi',
    'message' => 'Setoran dari ' . $deposit->user->name,
    'link' => route('admin.setoran.show', $deposit->id),
    'type' => 'deposit'
]));

// Notifikasi Redemption
$admin->notify(new NewRedemptionRequest($redemption, [
    'title' => 'Permintaan Penukaran Baru',
    'message' => 'Penukaran dari ' . $redemption->user->name,
    'link' => route('admin.penukaran.show', $redemption->id),
    'type' => 'redemption'
]));
```

---

## FITUR NOTIFIKASI

1. **Badge Merah:** Muncul hanya jika ada unread notifications
2. **Animasi Pulse:** Badge akan berkedip untuk menarik perhatian
3. **Dropdown AlpineJS:** Smooth animation saat buka/tutup
4. **Auto Close:** Dropdown otomatis tutup saat klik di luar
5. **Unread Indicator:** Dot biru di setiap notifikasi yang belum dibaca
6. **Background Highlight:** Notifikasi unread memiliki background biru muda
7. **Time Display:** Menampilkan waktu relatif (5 menit yang lalu, 2 jam yang lalu, dll)
8. **Link to Detail:** Setiap notifikasi adalah link yang bisa diklik
9. **Empty State:** Pesan "Tidak ada notifikasi baru" jika kosong
10. **View All Link:** Link ke halaman notifikasi lengkap di footer dropdown

---

## CATATAN PENTING

⚠️ **Pastikan AlpineJS sudah ter-load:**
```html
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

⚠️ **Pastikan Bootstrap Icons sudah ter-load:**
```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
```

⚠️ **Pastikan route 'notifikasi' sudah ada di web.php:**
```php
Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');
```

---

## KEUNTUNGAN MENGGUNAKAN KOMPONEN

✅ **DRY (Don't Repeat Yourself):** Header cukup ditulis sekali
✅ **Konsistensi:** Semua halaman admin memiliki header yang sama
✅ **Mudah Update:** Update 1 file, berlaku di semua halaman
✅ **Active State:** Otomatis highlight tab yang sedang dibuka
✅ **Fitur Notifikasi:** Sudah built-in di semua halaman admin
✅ **Clean Code:** Kode lebih rapi dan mudah dibaca

---

## TROUBLESHOOTING

**Q: Badge notifikasi tidak muncul?**
A: Pastikan user memiliki relasi `notifications()` di model User.

**Q: Dropdown tidak berfungsi?**
A: Pastikan AlpineJS sudah ter-load sebelum komponen di-render.

**Q: Link notifikasi error 404?**
A: Pastikan semua route yang dipanggil di `$notification->data['link']` sudah terdaftar.

**Q: Styling tidak sesuai?**
A: Pastikan Tailwind CSS dan Bootstrap Icons sudah ter-load dengan benar.
