# Fix: Vite manifest not found - RESOLVED ✅

## Error yang Terjadi
```
Illuminate\Foundation\ViteManifestNotFoundException
Vite manifest not found at: C:\laragon\www\banksampahdigital\public\build/manifest.json
```

**Halaman:** `/admin/dashboard`  
**Status Code:** 500

## Penyebab
Frontend assets (CSS & JS) belum di-build dengan Vite. File `manifest.json` tidak ada di folder `public/build/`.

## Solusi yang Diterapkan

### 1. Install Node Dependencies ✅
```bash
npm install
```
Menginstall semua package yang dibutuhkan dari `package.json`.

### 2. Build Assets dengan Vite ✅
```bash
npm run build
```
Vite melakukan bundling dan optimasi:
- `resources/css/app.css` → `public/build/assets/app-[hash].css`
- `resources/js/app.js` → `public/build/assets/app-[hash].js`
- Generate `public/build/manifest.json`

### 3. Tambah CDN Fallback ✅
**File:** `resources/views/layouts/app.blade.php`

Ditambahkan:
```html
<!-- Tailwind CSS CDN (fallback while building assets) -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Alpine.js for modal interactions -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

Ini memastikan styling tetap bekerja bahkan jika Vite build gagal.

## Struktur File Setelah Build

```
public/
├── build/
│   ├── assets/
│   │   ├── app-[hash].css      # Compiled CSS
│   │   └── app-[hash].js       # Compiled JS
│   └── manifest.json            # Vite manifest ✅
```

## Cara Kerja Vite di Laravel

### Development Mode
```bash
npm run dev
```
- Hot reload (perubahan langsung terlihat)
- Tidak perlu build ulang
- Server Vite running di port 5173

### Production Mode (yang kita gunakan)
```bash
npm run build
```
- Minify & optimize assets
- Generate file hash untuk cache busting
- Create manifest.json
- Ready untuk production

## Commands untuk Development

### Saat Development (Recommended)
```bash
npm run dev
```
Jalankan bersamaan dengan `php artisan serve`.

### Saat Production
```bash
npm run build
```
Build sekali, deploy hasil build.

## Troubleshooting

### Jika Error "npm not found"
Install Node.js dari: https://nodejs.org/

### Jika npm install error
```bash
# Hapus cache npm
npm cache clean --force

# Hapus node_modules
Remove-Item -Recurse -Force node_modules

# Install ulang
npm install
```

### Jika Vite error saat build
```bash
# Clear Vite cache
Remove-Item -Recurse -Force node_modules/.vite

# Build ulang
npm run build
```

### Jika styling rusak
1. Clear browser cache (Ctrl + Shift + Del)
2. Hard refresh (Ctrl + Shift + R)
3. Check console browser untuk error

## File-file yang Terlibat

### package.json
Berisi dependencies dan scripts npm:
```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build"
  },
  "devDependencies": {
    "vite": "^5.0",
    "tailwindcss": "^3.4",
    "alpinejs": "^3.x"
  }
}
```

### vite.config.js
Konfigurasi Vite untuk Laravel:
```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

### resources/views/layouts/app.blade.php
Template yang menggunakan Vite:
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

## Status Build

✅ **Node Modules:** Installed  
✅ **Vite Build:** Completed  
✅ **Manifest:** Generated at `public/build/manifest.json`  
✅ **CSS Assets:** Built  
✅ **JS Assets:** Built  
✅ **CDN Fallback:** Added (Tailwind + Alpine.js)

## Testing

### 1. Refresh Browser
Hard refresh: `Ctrl + Shift + R`

### 2. Login Admin
```
URL: http://127.0.0.1:8000/login
Email: admin@banksampah.com
Password: admin123
```

### 3. Access Admin Dashboard
```
URL: http://127.0.0.1:8000/admin/dashboard
Expected: ✅ Dashboard tampil dengan styling lengkap
Error: ❌ No more "Vite manifest not found"
```

## Next Steps (Optional)

### Untuk Development yang Lebih Smooth

Jalankan 2 terminal:

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Vite Dev Server:**
```bash
npm run dev
```

Dengan cara ini, perubahan CSS/JS langsung reload tanpa perlu build ulang.

---
**Error:** Vite manifest not found  
**Fixed:** npm install + npm run build + CDN fallback  
**Date:** November 10, 2025  
**Status:** RESOLVED ✅
