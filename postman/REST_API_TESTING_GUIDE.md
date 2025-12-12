# 🚀 REST API Testing Guide - Bank Sampah Digital

## ⚠️ PENTING - Perbedaan Web vs REST API

### ❌ SALAH - Web Routes (untuk Browser)
```
POST /register          → Butuh CSRF token
POST /login             → Butuh CSRF token
GET  /dashboard         → Session-based auth
```

### ✅ BENAR - REST API Routes (untuk Postman/Mobile)
```
POST /api/register      → Tidak butuh CSRF
POST /api/login         → Return Bearer token
GET  /api/me            → Bearer token auth
```

---

## 📥 Setup Postman

### 1. Import Files

Import 2 file ini ke Postman:

1. **Environment:** `BankSampahDigital.postman_environment.json`
2. **Collection:** `BankSampahDigital_REST_API.postman_collection.json`

### 2. Pilih Environment

Di kanan atas Postman, pilih dropdown dan select: **"Bank Sampah Digital - Local"**

### 3. Pastikan Server Running

```bash
cd d:\laragon\www\banksampahdigital
php artisan serve
```

Server harus running di: `http://127.0.0.1:8000`

---

## 🎯 Testing Flow - Step by Step

### Step 1: Test Public Endpoint (Tidak Perlu Token)

**Request:** `GET /api/branches`

**Expected Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Cabang Pusat",
            "address": "Jl. Sudirman No. 123",
            ...
        }
    ]
}
```

**✅ Jika berhasil:** Server sudah jalan dengan baik!

---

### Step 2: Register User Baru

**Request:** `POST /api/register`

**Body (JSON):**
```json
{
    "full_name": "Budi Santoso",
    "email": "budi@test.com",
    "phone": "08123456789",
    "address": "Jl. Merdeka No. 123",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Expected Response (201):**
```json
{
    "success": true,
    "message": "Registration successful",
    "data": {
        "user": {
            "id": 2,
            "name": "Budi Santoso",
            "email": "budi@test.com",
            "role": "warga",
            "balance_points": 0
        },
        "token": "1|abc123xyz...",
        "token_type": "Bearer"
    }
}
```

**✅ Token otomatis tersimpan** di environment variable `api_token`!

---

### Step 3: Login (Jika Sudah Punya Akun)

**Request:** `POST /api/login`

**Body (JSON):**
```json
{
    "email": "budi@test.com",
    "password": "password123"
}
```

**Expected Response (200):**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {...},
        "token": "2|def456uvw...",
        "token_type": "Bearer"
    }
}
```

**✅ Token otomatis tersimpan!**

---

### Step 4: Get Profile (Pakai Token)

**Request:** `GET /api/me`

**Authorization:** Bearer Token (otomatis dari environment)

**Expected Response (200):**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 2,
            "name": "Budi Santoso",
            "full_name": "Budi Santoso",
            "email": "budi@test.com",
            "phone": "08123456789",
            "address": "Jl. Merdeka No. 123",
            "role": "warga",
            "balance_points": 0,
            "created_at": "2024-12-12T10:30:00.000000Z"
        }
    }
}
```

---

### Step 5: Get Waste Types (Jenis Sampah)

**Request:** `GET /api/waste-types`

**Authorization:** Bearer Token

**Expected Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Plastik",
            "price_per_kg": 2000,
            "description": "Plastik botol, kemasan"
        },
        {
            "id": 2,
            "name": "Kertas",
            "price_per_kg": 1500,
            "description": "Kertas, kardus"
        }
    ]
}
```

---

### Step 6: Get Reward Items (Barang Penukaran)

**Request:** `GET /api/reward-items`

**Authorization:** Bearer Token

**Expected Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Pulsa Rp 10.000",
            "points_required": 5000,
            "stock": 100,
            "is_active": true
        },
        {
            "id": 2,
            "name": "Beras 5kg",
            "points_required": 25000,
            "stock": 50,
            "is_active": true
        }
    ]
}
```

---

### Step 7: Tukar Poin (Create Redemption)

**Request:** `POST /api/redemptions`

**Authorization:** Bearer Token

**Body (JSON):**
```json
{
    "items": [
        {
            "reward_item_id": 1,
            "quantity": 2
        }
    ],
    "delivery_option": "pickup",
    "notes": "Mohon disiapkan sebelum Jumat"
}
```

**Expected Response (201):**
```json
{
    "success": true,
    "message": "Redemption created successfully",
    "data": {
        "redemption": {
            "id": 1,
            "user_id": 2,
            "total_points": 10000,
            "status": "pending",
            "delivery_option": "pickup",
            "notes": "Mohon disiapkan sebelum Jumat",
            "items": [...]
        }
    }
}
```

---

### Step 8: Get Riwayat Setoran Sampah

**Request:** `GET /api/deposits`

**Authorization:** Bearer Token

**Expected Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "user_id": 2,
            "total_weight": 10.5,
            "total_points": 15750,
            "status": "approved",
            "created_at": "2024-12-12T09:00:00.000000Z",
            "items": [...]
        }
    ]
}
```

---

### Step 9: Get Riwayat Tukar Poin

**Request:** `GET /api/redemptions`

**Authorization:** Bearer Token

**Expected Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "user_id": 2,
            "total_points": 10000,
            "status": "pending",
            "delivery_option": "pickup",
            "created_at": "2024-12-12T10:00:00.000000Z",
            "items": [...]
        }
    ]
}
```

---

### Step 10: Logout

**Request:** `POST /api/logout`

**Authorization:** Bearer Token

**Expected Response (200):**
```json
{
    "success": true,
    "message": "Logout successful"
}
```

**Token akan di-revoke dan tidak bisa dipakai lagi.**

---

## 🔑 Cara Kerja Token

### Auto-Save Token

Setiap kali berhasil **Register** atau **Login**, token otomatis tersimpan di environment variable dengan script ini:

```javascript
if (pm.response.code === 200) {
    const response = pm.response.json();
    if (response.data && response.data.token) {
        pm.environment.set('api_token', response.data.token);
        console.log('Token saved:', response.data.token);
    }
}
```

### Authorization Header

Semua request yang perlu authentication menggunakan:
```
Authorization: Bearer {{api_token}}
```

Postman otomatis replace `{{api_token}}` dengan token yang tersimpan.

---

## ❌ Common Errors & Solutions

### Error 1: "CSRF token mismatch" (419)

**Penyebab:**
```
❌ POST /register          (Web route - butuh CSRF)
```

**Solusi:**
```
✅ POST /api/register      (API route - tidak butuh CSRF)
```

**Pastikan semua endpoint dimulai dengan `/api/`!**

---

### Error 2: "Unauthenticated" (401)

**Penyebab:**
- Token tidak ada
- Token expired
- Token invalid

**Solusi:**

1. **Check environment:**
   - Klik icon ⚙️ di kanan atas
   - Select environment
   - Check variable `api_token` terisi

2. **Login ulang:**
   ```
   POST /api/login
   ```

3. **Check Authorization tab:**
   - Type: Bearer Token
   - Token: `{{api_token}}`

---

### Error 3: "Validation error" (422)

**Penyebab:**
- Required field kosong
- Format data salah

**Contoh Response:**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

**Solusi:**
- Check semua required fields
- Pastikan format email benar
- Password min 8 karakter
- `password_confirmation` harus sama dengan `password`

---

### Error 4: "Route not found" (404)

**Penyebab:**
```
❌ /apis/register           (Typo: apis)
❌ /api/registrations       (Typo: registrations)
```

**Solusi:**
```
✅ /api/register            (Benar)
✅ /api/login               (Benar)
```

---

## 🛠️ Debug Tools

### 1. Postman Console

Buka console untuk lihat detail request/response:
```
Ctrl + Alt + C   (Windows)
Cmd + Alt + C    (Mac)
```

### 2. Laravel Log

Check error di Laravel:
```bash
tail -f storage/logs/laravel.log
```

### 3. Test di Browser

Untuk endpoint GET public:
```
http://127.0.0.1:8000/api/branches
```

---

## 📊 Testing Checklist

Gunakan checklist ini untuk memastikan semua fitur work:

### Public Endpoints
- [ ] GET /api/branches → Success (200)

### Authentication
- [ ] POST /api/register → Success (201), token tersimpan
- [ ] POST /api/login → Success (200), token tersimpan
- [ ] GET /api/me → Success (200), dapat data user
- [ ] POST /api/logout → Success (200)

### Deposits (Setor Sampah)
- [ ] GET /api/waste-types → Success (200)
- [ ] GET /api/deposits → Success (200)
- [ ] GET /api/deposits/1 → Success (200) atau 404

### Redemptions (Tukar Poin)
- [ ] GET /api/reward-items → Success (200)
- [ ] GET /api/reward-items/1 → Success (200) atau 404
- [ ] POST /api/redemptions → Success (201) atau 422
- [ ] GET /api/redemptions → Success (200)
- [ ] GET /api/redemptions/1 → Success (200) atau 404

### Error Testing
- [ ] GET /api/me (no token) → Error (401)
- [ ] GET /api/me (invalid token) → Error (401)
- [ ] POST /api/register (invalid data) → Error (422)
- [ ] GET /api/deposits/999999 → Error (404)

---

## 💡 Pro Tips

### Tip 1: Pakai Collection Runner
Run semua test sekaligus:
1. Klik kanan Collection
2. Run collection
3. Lihat hasilnya

### Tip 2: Export Collection
Backup collection setelah selesai test:
1. Klik ... pada collection
2. Export
3. Save as JSON

### Tip 3: Gunakan Variables
Simpan data yang sering dipakai di environment:
```
{{base_url}}/api/deposits
{{user_id}}
{{reward_item_id}}
```

### Tip 4: Save Examples
Setelah request berhasil:
1. Klik "Save as Example"
2. Beri nama deskriptif
3. Dokumentasi otomatis!

---

## 🎉 Summary

### Flow Testing Lengkap:

1. ✅ Import Collection & Environment
2. ✅ Test public endpoint (`/api/branches`)
3. ✅ Register user baru (`/api/register`)
4. ✅ Token otomatis tersimpan
5. ✅ Get profile (`/api/me`)
6. ✅ Get waste types (`/api/waste-types`)
7. ✅ Get reward items (`/api/reward-items`)
8. ✅ Create redemption (`/api/redemptions`)
9. ✅ Get riwayat deposits (`/api/deposits`)
10. ✅ Get riwayat redemptions (`/api/redemptions`)
11. ✅ Logout (`/api/logout`)

### Key Points:

- ⚠️ **SELALU gunakan `/api/*` routes, BUKAN `/register` atau `/login`**
- 🔑 Token otomatis tersimpan setelah register/login
- 🛡️ Semua endpoint (kecuali public) perlu Bearer token
- 📱 REST API ini siap untuk Mobile App/Frontend

---

**Developer:** Gracia Pardede  
**Project:** Bank Sampah Digital (Green Saving)  
**Date:** December 2024

🚀 **Happy Testing!**
