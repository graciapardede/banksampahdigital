# 📡 Dokumentasi Integrasi API Eksternal - Green Saving

**Dibuat:** 8 Desember 2025  
**Developer:** Gracia Pardede  
**Project:** Bank Sampah Digital (Green Saving)

---

## 🎯 Overview

Project Green Saving telah terintegrasi dengan **3 API Eksternal** untuk meningkatkan fungsionalitas aplikasi:

1. **Google OAuth API** - Autentikasi login dengan akun Google
2. **EcoProvider API** - Konsumsi berita lingkungan dari service eksternal
3. **Google Maps JavaScript API** - Menampilkan lokasi cabang Bank Sampah

---

## 1️⃣ Google OAuth API

### 📌 **Fungsi**
Memungkinkan user untuk login menggunakan akun Google mereka, tanpa perlu membuat akun baru dengan email/password.

### 🔧 **Teknologi**
- **Library:** Laravel Socialite 5.23.2
- **Provider:** Google OAuth 2.0
- **Endpoint:** `https://accounts.google.com/o/oauth2/auth`

### 📂 **Files Terkait**
```
app/Http/Controllers/Auth/GoogleAuthController.php    # Controller OAuth
routes/web.php                                          # Route /auth/google/*
database/migrations/*_add_google_fields_to_users.php   # Migration
resources/views/auth/login.blade.php                   # Tombol login Google
```

### ⚙️ **Konfigurasi** (.env)
```env
GOOGLE_CLIENT_ID=1016009453768-lc9sfg0glql992jmp6decvfnlvumj91a.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 🔄 **Flow Proses**
1. User klik tombol "Masuk dengan Google"
2. Redirect ke Google → User pilih akun & izinkan akses
3. Google callback ke `/auth/google/callback` dengan auth code
4. Server exchange code → dapat user data (name, email, avatar)
5. Cek database:
   - Jika user sudah ada (email match) → Login
   - Jika user baru → Register otomatis
6. Session dibuat → User masuk ke dashboard

### 📊 **Database Impact**
Kolom ditambahkan ke tabel `users`:
- `google_id` (string) - ID unik dari Google
- `google_token` (text) - Access token
- `google_refresh_token` (text) - Refresh token
- `avatar` (string) - URL foto profil dari Google

### 🚀 **Cara Testing**
1. Buka http://localhost:8000/login
2. Klik "Masuk dengan Google"
3. Pilih akun Google
4. Setelah redirect, user langsung masuk dashboard

---

## 2️⃣ EcoProvider API

### 📌 **Fungsi**
Mengonsumsi berita lingkungan dari API eksternal EcoProvider untuk ditampilkan di menu "Eco News" aplikasi.

### 🔧 **Teknologi**
- **HTTP Client:** Laravel Http Facade
- **Base URL:** `http://localhost:8001/api` (development)
- **Method:** GET requests

### 📂 **Files Terkait**
```
app/Services/EcoNewsService.php                # Service layer untuk API calls
app/Http/Controllers/EcoNewsController.php     # Controller
routes/web.php                                  # Route /eco-news/*
resources/views/eco-news/index.blade.php       # List berita
resources/views/eco-news/show.blade.php        # Detail berita
resources/views/eco-news/search.blade.php      # Pencarian berita
```

### ⚙️ **Konfigurasi** (Optional - hardcoded in service)
```php
// Base URL bisa dipindah ke .env jika diperlukan
protected $baseUrl = 'http://localhost:8001/api';
```

### 🔄 **API Endpoints yang Dikonsumsi**

#### **GET /eco-news**
Mengambil semua berita lingkungan
```json
Response:
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Pemanasan Global dan Dampaknya",
      "summary": "Ringkasan berita...",
      "content": "Konten lengkap...",
      "author": "Tim EcoNews",
      "category": "Iklim",
      "thumbnail_url": "http://localhost:8001/storage/...",
      "published_at": "2024-12-01 10:00:00",
      "tags": ["iklim", "pemanasan global"]
    }
  ]
}
```

#### **GET /eco-news/{id}**
Mengambil detail satu berita
```json
Response:
{
  "success": true,
  "data": {
    "id": 1,
    "title": "...",
    "content": "..."
  }
}
```

#### **GET /eco-news/search?q={keyword}**
Mencari berita berdasarkan keyword
```json
Response:
{
  "success": true,
  "data": [...]
}
```

### 📊 **Service Layer Pattern**
```php
// app/Services/EcoNewsService.php
class EcoNewsService {
    public function getAllNews() {
        $response = Http::get($this->baseUrl . '/eco-news');
        return $response->json()['data']; // Parse response.data
    }
}
```

### 🎨 **UI Features**
- Grid 3 kolom untuk list berita
- Thumbnail image dengan fallback
- Search functionality
- Detail page dengan full content
- Error handling jika API tidak tersedia

### 🚀 **Cara Testing**
1. Pastikan EcoProvider API running di port 8001
2. Buka http://localhost:8000/eco-news
3. Test search dengan keyword
4. Klik berita untuk lihat detail

### ⚠️ **Error Handling**
Jika EcoProvider API down:
```php
try {
    $news = $this->ecoNewsService->getAllNews();
} catch (\Exception $e) {
    return view('eco-news.index', [
        'news' => [],
        'isAvailable' => false,
        'error' => 'Tidak dapat terhubung ke EcoProvider. Silakan coba lagi nanti.'
    ]);
}
```

---

## 3️⃣ Google Maps JavaScript API

### 📌 **Fungsi**
Menampilkan peta interaktif dengan marker lokasi cabang Bank Sampah di Toba Samosir (IT Del & Hotel Labersa).

### 🔧 **Teknologi**
- **API:** Google Maps JavaScript API
- **Library:** Google Maps Core
- **Features:** Custom markers, Info windows, Directions link

### 📂 **Files Terkait**
```
app/Http/Controllers/LocationController.php    # Controller dengan data dummy
routes/web.php                                  # Route /lokasi
resources/views/lokasi/index.blade.php         # Map view
```

### ⚙️ **Konfigurasi** (.env)
```env
GOOGLE_MAPS_API_KEY=YOUR_GOOGLE_MAPS_API_KEY_HERE
```

⚠️ **PENTING:** Tim harus mendapatkan API Key sendiri dari Google Cloud Console:
1. Buka https://console.cloud.google.com
2. Create/Select project "Green Saving"
3. Enable "Maps JavaScript API"
4. Create credentials → API Key
5. Restrict key:
   - HTTP referrers: `http://localhost:8000/*`
   - API restrictions: Maps JavaScript API only
6. Copy key ke `.env`

### 📊 **Data Lokasi** (Dummy)
Controller berisi 2 lokasi cabang:
```php
$branches = [
    [
        'name' => 'Bank Sampah Sitoluama',
        'lat' => 2.383504625577555,
        'lng' => 99.14856842160157,
        'address' => 'Institut Teknologi Del, Sitoluama, Laguboti, Toba',
        'phone' => '0632-331234',
    ],
    [
        'name' => 'Bank Sampah Balige',
        'lat' => 2.3389718144967317,
        'lng' => 99.08154846392925,
        'address' => 'Hotel Labersa, Jl. Sisingamangaraja, Balige, Toba',
        'phone' => '0632-21234',
    ],
];
```

### 🗺️ **Map Features**

#### **1. Click-to-Show**
Map tersembunyi secara default, muncul setelah user klik card lokasi:
```javascript
function showMap(branchIndex) {
    // Show map container
    document.getElementById('mapContainer').classList.remove('hidden');
    // Pan to selected branch
    map.panTo({ lat: branch.lat, lng: branch.lng });
}
```

#### **2. Custom Green Markers**
```javascript
icon: {
    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#10b981">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
        </svg>
    `),
    scaledSize: new google.maps.Size(40, 40)
}
```

#### **3. User Geolocation**
Tombol "Lokasi Saya" untuk deteksi posisi user:
```javascript
function findMyLocation() {
    navigator.geolocation.getCurrentPosition(function(position) {
        userLocation = { lat: position.coords.latitude, lng: position.coords.longitude };
        // Add blue marker for user
        // Calculate distance to nearest branch
        // Show directions
    });
}
```

#### **4. Info Windows**
Saat klik marker, muncul info window dengan:
- Nama cabang
- Alamat lengkap
- Nomor telepon
- Jarak dari lokasi user (jika geolocation aktif)
- Tombol "Petunjuk Arah" → Link ke Google Maps

#### **5. Directions Integration**
```javascript
// Link ke Google Maps dengan origin & destination
const directionUrl = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${branchLat},${branchLng}`;
```

### 🎨 **UI Design**
- Map container: 500px height, rounded-2xl, shadow-lg
- Header dengan tombol "Lokasi Saya" (biru) & close button (merah)
- Info box jarak ke cabang terdekat (muncul setelah geolocation)
- Branch cards: Click untuk zoom ke lokasi

### 🚀 **Cara Testing**
1. Pastikan API key sudah diisi di `.env`
2. Run `php artisan config:clear`
3. Buka http://localhost:8000/lokasi
4. Klik salah satu card branch → Map muncul
5. Klik tombol "Lokasi Saya" → Browser minta izin
6. Allow location → Map show posisi user + nearest branch
7. Klik marker → Info window muncul
8. Klik "Petunjuk Arah" → Buka Google Maps directions

### 🔄 **Distance Calculation**
Menggunakan Haversine formula untuk hitung jarak:
```javascript
function calculateDistance(lat1, lng1, lat2, lng2) {
    const R = 6371; // Earth radius in km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
             Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
             Math.sin(dLng/2) * Math.sin(dLng/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c; // Distance in km
}
```

---

## 📋 Checklist Setup untuk Tim

### ✅ **Setelah Git Pull**

#### **1. Install Dependencies**
```bash
composer install
npm install
```

#### **2. Setup Environment**
Copy `.env.example` ke `.env` (jika belum ada), lalu isi:
```env
# Google OAuth
GOOGLE_CLIENT_ID=1016009453768-lc9sfg0glql992jmp6decvfnlvumj91a.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Google Maps (dapatkan sendiri dari Google Cloud Console)
GOOGLE_MAPS_API_KEY=YOUR_KEY_HERE
```

#### **3. Database Migration**
```bash
php artisan migrate
```
Migration baru akan menambahkan kolom OAuth di tabel `users`.

#### **4. Clear Cache**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

#### **5. Test EcoProvider API**
Pastikan service EcoProvider running di port 8001:
```bash
# Di terminal terpisah, jalankan EcoProvider
cd path/to/ecoprovider
php artisan serve --port=8001
```

#### **6. Test Google Maps**
1. Dapatkan API key dari Google Cloud Console
2. Isi ke `.env` → `GOOGLE_MAPS_API_KEY`
3. Run `php artisan config:clear`
4. Test di http://localhost:8000/lokasi

---

## 🎨 UI/UX Improvements

### **Navigation Consistency**
Semua modul sekarang memiliki 8 menu navigation yang konsisten:
1. Dashboard
2. Profil
3. Setor
4. Tukar Poin
5. Eco News (NEW)
6. Lokasi (NEW)
7. Riwayat
8. Notifikasi

### **Responsive Navigation**
Navigation tabs sudah dioptimasi agar tidak terpotong di mobile:
- **Desktop**: Text lengkap (Dashboard, Tukar Poin, Eco News, Notifikasi)
- **Mobile**: Text disingkat (Dashb, Tukar, Eco, Notif)
- Icon responsive: `text-sm lg:text-base`
- Padding dinamis: `px-2 lg:px-4`

### **Header Consistency**
Header di Eco News dan Lokasi sudah diseragamkan dengan modul lain:
- Logo lebih besar (16x16)
- Poin terintegrasi dengan PointsLedger
- Button size 14x14 dengan hover effect

---

## 🐛 Troubleshooting

### **Google OAuth Error: "invalid_client"**
- Cek GOOGLE_CLIENT_ID di `.env` (jangan ada typo)
- Pastikan redirect URI match di Google Cloud Console

### **EcoProvider API: "Connection refused"**
- Pastikan EcoProvider service running di port 8001
- Cek firewall/antivirus tidak block port 8001

### **Google Maps: Map tidak muncul**
- Cek API key sudah benar di `.env`
- Cek browser console untuk error
- Pastikan "Maps JavaScript API" enabled di Google Cloud Console
- Cek quota API belum habis

### **Poin tidak sinkron**
- Pastikan controller pass variable `$saldoPoin`
- Cek query: `PointsLedger::where('user_id', Auth::id())->sum('points')`

---

## 📞 Kontak

Jika ada pertanyaan atau butuh bantuan setup:
- **Developer:** Gracia Pardede
- **Repository:** https://github.com/graciapardede/banksampahdigital
- **Branch:** main

---

## 📝 Changelog

**8 Desember 2025:**
- ✅ Integrasi Google OAuth untuk login
- ✅ Integrasi EcoProvider API untuk berita lingkungan
- ✅ Integrasi Google Maps JavaScript API untuk lokasi branch
- ✅ Perbaikan UI/UX navigation tabs di semua modul
- ✅ Konsistensi header dan poin di eco-news & lokasi
- ✅ Responsive design untuk mobile devices

---

**🎉 Happy Coding! 🚀**
