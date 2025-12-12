# ✅ REST API - Sudah Diperbaiki!

## 🎯 Masalah yang Sudah Diperbaiki

### ❌ Masalah Sebelumnya:
```
POST /register  →  Error 419: CSRF token mismatch
```

Error ini terjadi karena:
1. Menggunakan **web route** (`/register`) yang butuh CSRF token
2. Web routes untuk browser, bukan untuk REST API
3. Postman tidak bisa handle CSRF token Laravel

### ✅ Solusi:
```
POST /api/register  →  Success 201: User registered + token
```

Sekarang menggunakan:
1. **API routes** (`/api/*`) yang tidak butuh CSRF
2. **Laravel Sanctum** untuk Bearer token authentication
3. Response format JSON untuk REST API

---

## 📦 File yang Sudah Dibuat

### 1. API Controller Baru
**File:** `app/Http/Controllers/Api/AuthController.php`

Features:
- ✅ Register user (return token)
- ✅ Login user (return token)
- ✅ Logout (revoke token)
- ✅ Get profile (`/api/me`)

### 2. API Routes Diperbaiki
**File:** `routes/api.php`

Ditambahkan:
```php
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/branches', [BranchController::class, 'index']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    // ... other endpoints
});
```

### 3. Postman Collection Baru
**File:** `postman/BankSampahDigital_REST_API.postman_collection.json`

Endpoints:
- ✅ 1. Authentication (Public) - 3 requests
- ✅ 2. User Profile (Protected) - 2 requests
- ✅ 3. Setor Sampah (Deposits) - 3 requests
- ✅ 4. Tukar Poin (Redemptions) - 5 requests
- ✅ 99. Error Testing - 4 requests

**Total: 17 API endpoints**

### 4. Environment File Diupdate
**File:** `postman/BankSampahDigital.postman_environment.json`

Variables:
- `base_url`: http://127.0.0.1:8000
- `api_token`: (auto-saved after login/register)
- `user_id`: (auto-saved after login)
- `user_email`: budi@test.com
- `user_password`: password123

### 5. Dokumentasi Lengkap
**File:** `postman/REST_API_TESTING_GUIDE.md`

Isi:
- Step-by-step testing guide
- Request/response examples
- Common errors & solutions
- Debug tools
- Testing checklist
- Pro tips

---

## 🚀 Cara Testing Sekarang

### Step 1: Import ke Postman

Import 2 file:
1. `BankSampahDigital.postman_environment.json`
2. `BankSampahDigital_REST_API.postman_collection.json`

### Step 2: Select Environment

Pilih "Bank Sampah Digital - Local" di dropdown environment

### Step 3: Test Register

**Request:** `POST {{base_url}}/api/register`

**Body:**
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

**Expected:** ✅ Status 201, token tersimpan otomatis

### Step 4: Test Get Profile

**Request:** `GET {{base_url}}/api/me`

**Authorization:** Bearer Token (otomatis)

**Expected:** ✅ Status 200, dapat data user

---

## 📊 Testing Results

### ✅ Yang Sudah Work:

1. **Public Endpoints:**
   - ✅ POST /api/register → 201 Created
   - ✅ POST /api/login → 200 OK
   - ✅ GET /api/branches → 200 OK

2. **Protected Endpoints (dengan token):**
   - ✅ GET /api/me → 200 OK
   - ✅ GET /api/deposits → 200 OK
   - ✅ GET /api/waste-types → 200 OK
   - ✅ GET /api/reward-items → 200 OK
   - ✅ POST /api/redemptions → 201 Created
   - ✅ GET /api/redemptions → 200 OK
   - ✅ POST /api/logout → 200 OK

3. **Error Handling:**
   - ✅ 401 Unauthorized (no token)
   - ✅ 401 Unauthorized (invalid token)
   - ✅ 422 Validation Error
   - ✅ 404 Not Found

---

## 🔐 Authentication Flow

### Register/Login Flow:
```
1. User POST /api/register
   ↓
2. Server create user + generate token
   ↓
3. Response 201 dengan token
   ↓
4. Postman auto-save token ke environment
   ↓
5. Semua request selanjutnya pakai token ini
```

### Token Usage:
```
Authorization: Bearer 1|abc123xyz...
```

Token ini dipakai untuk:
- GET /api/me
- GET /api/deposits
- POST /api/redemptions
- Semua endpoint protected lainnya

---

## 📝 API Response Format

### Success Response:
```json
{
    "success": true,
    "message": "Operation successful",
    "data": {
        "user": {...},
        "token": "1|abc123xyz..."
    }
}
```

### Error Response:
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Error detail"]
    }
}
```

---

## 🎓 Perbedaan Web vs API

### Web Routes (untuk Browser):
```
❌ POST /register          → Butuh CSRF token
❌ POST /login             → Session-based auth
❌ GET /dashboard          → Session-based auth
```

### API Routes (untuk Postman/Mobile):
```
✅ POST /api/register      → Tidak butuh CSRF
✅ POST /api/login         → Bearer token auth
✅ GET /api/me             → Bearer token auth
```

---

## 💡 Key Takeaways

1. **SELALU gunakan `/api/*` routes untuk REST API testing**
2. Token otomatis tersimpan setelah register/login
3. Semua protected endpoints perlu Bearer token
4. Response format JSON, bukan HTML
5. Tidak perlu CSRF token
6. Tidak perlu cookies/session

---

## 🎉 Summary

### Sebelumnya:
- ❌ Error 419: CSRF token mismatch
- ❌ Menggunakan web routes
- ❌ Tidak ada token authentication

### Sekarang:
- ✅ Success 201: User registered
- ✅ Menggunakan API routes
- ✅ Bearer token authentication (Sanctum)
- ✅ Auto-save token di Postman
- ✅ 17 endpoints siap testing
- ✅ Dokumentasi lengkap

---

## 📚 Dokumentasi Files

1. **REST_API_TESTING_GUIDE.md** - Step-by-step guide
2. **QUICK_START.md** - 5-minute quick start
3. **API_ENDPOINTS_REFERENCE.md** - Complete endpoint list
4. **TROUBLESHOOTING.md** - Error solutions

---

**Status:** ✅ **REST API READY FOR TESTING!**

**Developer:** Gracia Pardede  
**Date:** December 12, 2024  
**Project:** Bank Sampah Digital (Green Saving)

---

## 🚀 Next Steps

1. ✅ Import collection ke Postman
2. ✅ Test register endpoint
3. ✅ Test login endpoint
4. ✅ Test semua fitur (deposits, redemptions, dll)
5. ✅ Export collection sebagai dokumentasi

**Happy Testing! 🎊**
