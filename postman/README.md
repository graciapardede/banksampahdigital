# 📚 Postman API Testing - Bank Sampah Digital

## 🎯 Start Here!

Selamat datang! Dokumentasi ini berisi panduan lengkap untuk testing REST API Bank Sampah Digital menggunakan Postman.

---

## ⚠️ PENTING - Baca Ini Dulu!

### Problem yang Sudah Diperbaiki:
```
❌ Error: 419 CSRF token mismatch di endpoint /register
✅ Fixed: Gunakan /api/register dengan Bearer token authentication
```

**👉 Read: [FINAL_SUMMARY.md](FINAL_SUMMARY.md) untuk overview lengkap!**

---

## 📖 Dokumentasi Map

Pilih dokumentasi sesuai kebutuhan Anda:

### 🚀 Untuk Pemula (Start Here!)

1. **[FINAL_SUMMARY.md](FINAL_SUMMARY.md)** ⭐ **START HERE!**
   - Overview lengkap masalah & solusi
   - Before/After comparison
   - Quick start 3 steps
   - Test results summary
   - **👈 Recommended untuk dibaca pertama kali!**

2. **[QUICK_REFERENCE.md](QUICK_REFERENCE.md)** ⚡ Cheat Sheet
   - Quick command reference
   - All endpoints list (copy-paste ready)
   - Common fixes one-liners
   - Testing checklist

---

### 📚 Untuk Detail & Step-by-Step

3. **[REST_API_TESTING_GUIDE.md](REST_API_TESTING_GUIDE.md)** 📖 Complete Guide
   - Step-by-step testing guide (10 steps)
   - Request/response examples dengan expected output
   - Detailed explanations untuk setiap endpoint
   - Best practices & tips

4. **[QUICK_START.md](QUICK_START.md)** ⏱️ 5-Minute Setup
   - Rapid setup guide untuk yang buru-buru
   - User flow scenario (login → cart → checkout)
   - Admin flow scenario (deposits → redemptions)
   - Pro tips Postman

---

### 🔧 Untuk Troubleshooting

5. **[TROUBLESHOOTING.md](TROUBLESHOOTING.md)** 🛠️ Error Solutions
   - 10 common errors dengan solusi lengkap
   - Step-by-step debugging
   - Debug tools (Console, Tinker, Logs)
   - Emergency reset procedures

---

### 📊 Untuk Reference

6. **[API_ENDPOINTS_REFERENCE.md](API_ENDPOINTS_REFERENCE.md)** 📋 API Documentation
   - Complete endpoint table (sortable)
   - Request body JSON examples
   - Response status codes
   - Authentication requirements
   - **Good for quick lookup!**

7. **[FIX_SUMMARY.md](FIX_SUMMARY.md)** 📝 Technical Details
   - Technical fix summary untuk developer
   - Files created/modified dengan paths
   - Code changes yang dilakukan
   - Architecture decisions

---

## 🚀 Quick Start (3 Steps)

### Step 1: Import Files ke Postman

1. Buka **Postman**
2. Click **Import** button (kiri atas)
3. Drag & drop 2 files ini:
   - `BankSampahDigital.postman_environment.json`
   - `BankSampahDigital_REST_API.postman_collection.json`

### Step 2: Select Environment

Di kanan atas Postman, pilih dropdown **"No Environment"** → Select:
```
Bank Sampah Digital - Local
```

### Step 3: Start Testing!

1. **Start Laravel server:**
   ```bash
   php artisan serve
   ```

2. **Test Register:**
   - Open: "1. Authentication (Public)" → "Register User"
   - Click: **Send**
   - ✅ Expected: Status 201, token auto-saved!

3. **Test Get Profile:**
   - Open: "2. User Profile (Protected)" → "Get My Profile"
   - Click: **Send**
   - ✅ Expected: Status 200, user data received!

**🎉 Done! API working!**

---

## 📦 Files Overview

### Postman Files:
```
postman/
├── BankSampahDigital.postman_environment.json    # Environment config
├── BankSampahDigital_REST_API.postman_collection.json  # 17 API endpoints
```

### Documentation Files:
```
postman/
├── README.md                          # This file (index)
├── FINAL_SUMMARY.md                   # ⭐ Start here!
├── QUICK_REFERENCE.md                 # Quick commands
├── REST_API_TESTING_GUIDE.md          # Detailed guide
├── QUICK_START.md                     # 5-minute setup
├── TROUBLESHOOTING.md                 # Error solutions
├── API_ENDPOINTS_REFERENCE.md         # Endpoint docs
└── FIX_SUMMARY.md                     # Technical details
```

---

## 🎯 Collection Structure

Collection berisi **17 endpoints** dalam 5 folders:

### 1. Authentication (Public) - 3 endpoints
- POST /api/register
- POST /api/login
- GET /api/branches

### 2. User Profile (Protected) - 2 endpoints
- GET /api/me
- POST /api/logout

### 3. Setor Sampah (Deposits) - 3 endpoints
- GET /api/waste-types
- GET /api/deposits
- GET /api/deposits/:id

### 4. Tukar Poin (Redemptions) - 5 endpoints
- GET /api/reward-items
- GET /api/reward-items/:id
- GET /api/redemptions
- POST /api/redemptions
- GET /api/redemptions/:id

### 99. Error Testing - 4 endpoints
- 401 No Token
- 401 Invalid Token
- 422 Validation Error
- 404 Not Found

---

## 🔑 Authentication Flow

### Token-Based Authentication (Laravel Sanctum):

```
1. POST /api/register
   → Response: { token: "1|abc123..." }
   → Token auto-saved to environment

2. Use token for all protected endpoints:
   Authorization: Bearer {{api_token}}

3. POST /api/logout
   → Token revoked
```

**No CSRF token needed!** ✅

---

## 💡 Key Features

- ✅ **No CSRF Token Required** - API routes tidak butuh CSRF
- ✅ **Auto Token Management** - Token otomatis tersimpan & dipakai
- ✅ **Bearer Authentication** - Laravel Sanctum token-based auth
- ✅ **JSON Responses** - Semua response dalam format JSON
- ✅ **Error Handling** - Clear error messages
- ✅ **RESTful Standard** - Mengikuti best practices

---

## 📊 Testing Checklist

Use this checklist untuk memastikan semua working:

### Server Setup
- [ ] Laravel server running (`php artisan serve`)
- [ ] Database connected
- [ ] Server accessible di http://127.0.0.1:8000

### Postman Setup
- [ ] Environment file imported
- [ ] Collection imported
- [ ] Environment selected di dropdown
- [ ] Variables configured (base_url, etc.)

### API Testing
- [ ] POST /api/register → Success 201
- [ ] Token auto-saved di environment
- [ ] POST /api/login → Success 200
- [ ] GET /api/me → Success 200
- [ ] GET /api/branches → Success 200
- [ ] GET /api/waste-types → Success 200
- [ ] GET /api/reward-items → Success 200
- [ ] GET /api/deposits → Success 200
- [ ] POST /api/redemptions → Success 201
- [ ] GET /api/redemptions → Success 200
- [ ] POST /api/logout → Success 200

### Error Testing
- [ ] GET /api/me (no token) → Error 401
- [ ] GET /api/me (invalid token) → Error 401
- [ ] POST /api/register (invalid data) → Error 422

---

## 🆚 Web Routes vs API Routes

### ❌ Don't Use (Web Routes):
```
POST /register           → Need CSRF token
POST /login              → Session-based auth
GET  /dashboard          → HTML response
```

### ✅ Use This (API Routes):
```
POST /api/register       → No CSRF needed
POST /api/login          → Token-based auth
GET  /api/me             → JSON response
```

**Always use `/api/*` routes for REST API testing!**

---

## 🛠️ Troubleshooting Quick Links

Having issues? Check these:

- **Error 419 CSRF?** → [TROUBLESHOOTING.md #1](TROUBLESHOOTING.md)
- **Error 401 Unauthenticated?** → [TROUBLESHOOTING.md #2](TROUBLESHOOTING.md)
- **Error 404 Not Found?** → [TROUBLESHOOTING.md #3](TROUBLESHOOTING.md)
- **Error 422 Validation?** → [TROUBLESHOOTING.md #4](TROUBLESHOOTING.md)
- **Token not saved?** → [TROUBLESHOOTING.md #8](TROUBLESHOOTING.md)

---

## 📞 Need Help?

### Documentation:
1. Read [FINAL_SUMMARY.md](FINAL_SUMMARY.md) untuk overview
2. Read [REST_API_TESTING_GUIDE.md](REST_API_TESTING_GUIDE.md) untuk details
3. Check [TROUBLESHOOTING.md](TROUBLESHOOTING.md) untuk errors

### Debug Tools:
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Check routes
php artisan route:list --path=api

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Postman Console:
```
Ctrl + Alt + C  (Windows)
Cmd + Alt + C   (Mac)
```

---

## 🎉 Summary

### What You Get:
- ✅ Complete REST API collection (17 endpoints)
- ✅ Auto token management
- ✅ Comprehensive documentation (7 files)
- ✅ Error handling examples
- ✅ Testing checklist
- ✅ Troubleshooting guide

### What You Can Do:
- ✅ Test all API features in Postman
- ✅ Register/Login users via API
- ✅ Test setor sampah (deposits)
- ✅ Test tukar poin (redemptions)
- ✅ Get user profile & data
- ✅ Handle errors properly

### Ready For:
- ✅ Mobile app development
- ✅ Frontend integration (React/Vue/Angular)
- ✅ Third-party API integration
- ✅ Production deployment

---

## 🙏 Credits

**Developer:** Gracia Pardede  
**Project:** Bank Sampah Digital (Green Saving)  
**Framework:** Laravel 10+ with Sanctum  
**Authentication:** Bearer Token (JWT)  
**Date:** December 12, 2024

---

**Status: ✅ READY FOR TESTING!**

## 📚 Next Steps

1. ✅ **Read:** [FINAL_SUMMARY.md](FINAL_SUMMARY.md)
2. ✅ **Import:** Collection & Environment to Postman
3. ✅ **Test:** Start with "Register User" endpoint
4. ✅ **Explore:** Test all features
5. ✅ **Reference:** Use docs when needed

---

🚀 **Happy API Testing!** 🎉
