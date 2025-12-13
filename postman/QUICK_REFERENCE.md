# 🎯 REST API Quick Reference Card

## ⚠️ MOST IMPORTANT

### ❌ JANGAN PAKAI INI:
```
POST /register          → ERROR 419 (CSRF token mismatch)
POST /login             → ERROR 419
```

### ✅ PAKAI INI:
```
POST /api/register      → SUCCESS 201 ✅
POST /api/login         → SUCCESS 200 ✅
```

---

## 📋 Quick Command Reference

### 1. Start Server
```bash
cd d:\laragon\www\banksampahdigital
php artisan serve
```

### 2. Import ke Postman
- Import: `BankSampahDigital.postman_environment.json`
- Import: `BankSampahDigital_REST_API.postman_collection.json`
- Select Environment: "Bank Sampah Digital - Local"

### 3. Test Register
```
POST {{base_url}}/api/register

Body (JSON):
{
    "full_name": "Budi Santoso",
    "email": "budi@test.com",
    "phone": "08123456789",
    "address": "Jl. Merdeka No. 123",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### 4. Test Login
```
POST {{base_url}}/api/login

Body (JSON):
{
    "email": "budi@test.com",
    "password": "password123"
}
```

### 5. Test Get Profile
```
GET {{base_url}}/api/me

Authorization: Bearer Token
Token: {{api_token}}
```

---

## 🔑 All API Endpoints

### Public (No Token)
```
POST   /api/register       → Register user baru
POST   /api/login          → Login & get token
GET    /api/branches       → Get daftar cabang
```

### Protected (Need Token)
```
# User Profile
GET    /api/me             → Get user profile
POST   /api/logout         → Logout (revoke token)

# Setor Sampah
GET    /api/waste-types    → Get jenis sampah
GET    /api/deposits       → Get riwayat setoran
GET    /api/deposits/:id   → Get detail setoran

# Tukar Poin
GET    /api/reward-items      → Get daftar reward
GET    /api/reward-items/:id  → Get detail reward
GET    /api/redemptions       → Get riwayat tukar poin
POST   /api/redemptions       → Tukar poin
GET    /api/redemptions/:id   → Get detail penukaran
```

---

## 💡 Common Fixes

### Error: 419 CSRF Token Mismatch
**Fix:** Gunakan `/api/register` bukan `/register`

### Error: 401 Unauthenticated
**Fix:** 
1. Check token di environment variable
2. Login ulang untuk get token baru
3. Pastikan Authorization type: Bearer Token

### Error: 422 Validation Error
**Fix:**
- Email harus format valid
- Password min 8 karakter
- password_confirmation harus sama
- Semua required fields harus diisi

### Error: 404 Not Found
**Fix:**
- Check typo di URL
- Pastikan ID resource exists
- Pastikan pakai `/api/*` bukan `/*`

---

## 📊 Request Headers

### For All Requests:
```
Accept: application/json
Content-Type: application/json
```

### For Protected Endpoints:
```
Authorization: Bearer {{api_token}}
```

---

## ✅ Testing Checklist

- [ ] Server running di http://127.0.0.1:8000
- [ ] Environment selected di Postman
- [ ] POST /api/register → Success 201
- [ ] Token otomatis tersimpan di environment
- [ ] GET /api/me → Success 200
- [ ] GET /api/branches → Success 200
- [ ] GET /api/waste-types → Success 200
- [ ] GET /api/reward-items → Success 200
- [ ] GET /api/deposits → Success 200
- [ ] POST /api/redemptions → Success 201 atau 422
- [ ] GET /api/redemptions → Success 200
- [ ] POST /api/logout → Success 200

---

**Files Location:** `d:\laragon\www\banksampahdigital\postman\`

**Documentation:**
- REST_API_TESTING_GUIDE.md
- FIX_SUMMARY.md
- TROUBLESHOOTING.md

**Developer:** Gracia Pardede
