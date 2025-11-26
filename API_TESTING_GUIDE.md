# API Testing Guide - Bank Sampah Digital

## 📋 **Base URL**
```
Local: http://127.0.0.1:8000
```

## 🔐 **Authentication**

Aplikasi ini menggunakan **Laravel Session-based Auth** (bukan Token API).

### Login (untuk mendapatkan session)
```
POST /login
Content-Type: application/x-www-form-urlencoded

Body:
email: martua.sitorus@gmail.com
password: password123
```

**Response Success:**
```json
{
    "redirect": "/dashboard"
}
```

Setelah login, browser akan menyimpan session cookie yang digunakan untuk request selanjutnya.

---

## 📡 **Available API Endpoints**

### **1. User/Warga APIs**

#### Get Dashboard Data
```
GET /api/dashboard
Headers:
  Cookie: laravel_session=...
  X-CSRF-TOKEN: ...
```

**Response:**
```json
{
    "balance_points": 5000,
    "user_name": "Martua Sitorus",
    "member_since": "Nov 2024",
    "deposits_count": 15,
    "redemptions_count": 5
}
```

---

#### Get User Deposits (Riwayat Setoran)
```
GET /api/deposits
```

**Response:**
```json
[
    {
        "id": 1,
        "user_id": 3,
        "branch_id": 1,
        "total_points": 500,
        "status": "verified",
        "created_at": "2024-11-20T10:30:00.000000Z",
        "items": [
            {
                "id": 1,
                "waste_type_id": 1,
                "weight": 5.5,
                "points": 275,
                "waste_type": {
                    "id": 1,
                    "name": "Botol Plastik",
                    "category": "Plastik",
                    "points_per_unit": 50,
                    "unit": "kg"
                }
            }
        ],
        "branch": {
            "id": 1,
            "name": "Cabang Sitoluama"
        }
    }
]
```

---

#### Get Deposit Detail
```
GET /api/deposits/{id}
Example: GET /api/deposits/1
```

**Response:** Single deposit object (sama seperti di atas)

---

#### Get Redemptions (Riwayat Penukaran)
```
GET /api/redemptions
```

**Response:**
```json
[
    {
        "id": 1,
        "user_id": 3,
        "branch_id": 1,
        "total_points": 1000,
        "status": "pending",
        "created_at": "2024-11-22T14:20:00.000000Z",
        "items": [
            {
                "id": 1,
                "reward_item_id": 5,
                "quantity": 2,
                "points": 500,
                "reward_item": {
                    "id": 5,
                    "name": "Beras 5kg",
                    "points_cost": 500,
                    "description": "Beras premium kualitas terbaik",
                    "image": "beras.jpg"
                }
            }
        ]
    }
]
```

---

#### Create Redemption (Submit Penukaran)
```
POST /api/redemptions
Content-Type: application/json

Body:
{
    "branch_id": 1,
    "items": [
        {
            "reward_item_id": 5,
            "quantity": 2
        }
    ]
}
```

**Response Success:**
```json
{
    "success": true,
    "message": "Penukaran berhasil diajukan",
    "redemption": {
        "id": 10,
        "total_points": 1000,
        "status": "pending"
    }
}
```

---

#### Cancel Redemption
```
POST /api/redemptions/{id}/cancel
Example: POST /api/redemptions/10/cancel
```

**Response:**
```json
{
    "success": true,
    "message": "Penukaran berhasil dibatalkan"
}
```

---

#### Get Reward Items (Barang Tukar)
```
GET /api/reward-items
Query Params:
  - branch_id (optional): Filter by branch
  - search (optional): Search by name
```

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Beras 5kg",
            "points_cost": 500,
            "description": "Beras premium",
            "stock": 50,
            "image": "beras.jpg",
            "branch_id": 1
        }
    ],
    "current_page": 1,
    "last_page": 3,
    "total": 25
}
```

---

#### Get Reward Item Detail
```
GET /api/reward-items/{id}
Example: GET /api/reward-items/1
```

---

#### Get Branches
```
GET /api/branches
```

**Response:**
```json
[
    {
        "id": 1,
        "name": "Cabang Sitoluama",
        "address": "Jl. Sitoluama No. 123",
        "phone": "081234567890"
    }
]
```

---

#### Get Profile
```
GET /api/profile
```

**Response:**
```json
{
    "id": 3,
    "name": "Martua Sitorus",
    "email": "martua.sitorus@gmail.com",
    "phone": "081234567890",
    "balance_points": 5000,
    "profile_photo": "1234567890_3.jpg",
    "branch_id": 1,
    "created_at": "2024-11-01T00:00:00.000000Z"
}
```

---

#### Update Profile
```
PUT /api/profile
Content-Type: multipart/form-data

Body:
name: Martua Sitorus Updated
phone: 081999888777
profile_photo: [file]
```

---

### **2. Admin APIs**

#### Get Admin Dashboard Stats
```
GET /admin/api/dashboard
```

**Response:**
```json
{
    "stats": {
        "total_users": 22,
        "total_deposits": 150,
        "total_redemptions": 45,
        "pending_deposits": 5,
        "pending_redemptions": 3
    },
    "deposits_by_month": [...],
    "redemptions_by_month": [...]
}
```

---

## 🧪 **Testing dengan Postman**

### **Setup Postman Collection**

1. **Import Environment:**
```json
{
  "name": "Bank Sampah Digital - Local",
  "values": [
    {
      "key": "base_url",
      "value": "http://127.0.0.1:8000",
      "enabled": true
    },
    {
      "key": "csrf_token",
      "value": "",
      "enabled": true
    }
  ]
}
```

2. **Login Flow:**
   - Request 1: `GET {{base_url}}/login` - Dapatkan CSRF token dari cookie
   - Request 2: `POST {{base_url}}/login` - Login dengan credentials
   - Request 3+: Gunakan session cookie untuk API calls

3. **Headers yang Diperlukan:**
```
Cookie: laravel_session=...
X-CSRF-TOKEN: ...
Accept: application/json
Content-Type: application/json
```

---

## 🔍 **Manual Testing Steps**

### **Test 1: Login & Get Dashboard**
```bash
# 1. Login
curl -X POST http://127.0.0.1:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "email=martua.sitorus@gmail.com&password=password123" \
  -c cookies.txt

# 2. Get Dashboard
curl http://127.0.0.1:8000/api/dashboard \
  -H "Accept: application/json" \
  -b cookies.txt
```

### **Test 2: Get Deposits**
```bash
curl http://127.0.0.1:8000/api/deposits \
  -H "Accept: application/json" \
  -b cookies.txt
```

### **Test 3: Create Redemption**
```bash
curl -X POST http://127.0.0.1:8000/api/redemptions \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -b cookies.txt \
  -d '{
    "branch_id": 1,
    "items": [
      {"reward_item_id": 1, "quantity": 2}
    ]
  }'
```

---

## 📝 **Testing Checklist**

### **Warga/User Testing:**
- [ ] Login dengan user biasa
- [ ] Get dashboard data
- [ ] Get riwayat setoran
- [ ] Get riwayat penukaran
- [ ] Get list barang reward
- [ ] Submit penukaran baru
- [ ] Cancel penukaran
- [ ] Update profile
- [ ] Upload foto profil

### **Admin Testing:**
- [ ] Login sebagai admin
- [ ] Get dashboard stats
- [ ] Get list semua deposits
- [ ] Verify deposit
- [ ] Get list redemptions
- [ ] Approve/reject redemption
- [ ] CRUD reward items
- [ ] CRUD waste types
- [ ] Generate reports

---

## ⚙️ **Testing Tools**

### **1. Postman** (Recommended)
- Import collection dari dokumentasi ini
- Otomatis handle cookies & CSRF tokens
- Save responses untuk debugging

### **2. Thunder Client** (VS Code Extension)
- Testing API langsung dari VS Code
- Lebih ringan dari Postman

### **3. Browser DevTools**
- Network tab untuk melihat actual API calls
- Inspect responses & cookies

### **4. PHP Artisan Tinker**
```bash
php artisan tinker

# Test query
>>> App\Models\User::count()
>>> App\Models\Deposit::with('items')->first()
>>> App\Models\Redemption::pending()->count()
```

---

## 🐛 **Common Issues & Solutions**

### **419 CSRF Token Mismatch**
**Solution:** 
- Dapatkan CSRF token dari `GET /login` dulu
- Tambahkan header `X-CSRF-TOKEN`

### **401 Unauthenticated**
**Solution:**
- Login dulu untuk dapatkan session
- Include cookie dalam setiap request

### **404 Not Found**
**Solution:**
- Pastikan Laravel server running: `php artisan serve`
- Cek route list: `php artisan route:list`

### **500 Internal Server Error**
**Solution:**
- Cek log: `storage/logs/laravel.log`
- Run: `php artisan optimize:clear`

---

## 📦 **Export Postman Collection**

Saya bisa buatkan file Postman Collection lengkap jika diperlukan!

---

**Last Updated:** November 24, 2025
