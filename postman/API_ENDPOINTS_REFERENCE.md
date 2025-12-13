# 📚 API Endpoints Reference

Quick reference untuk semua API endpoints Bank Sampah Digital.

---

## 🔓 Public Endpoints (No Auth)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/register` | Register user baru |
| POST | `/login` | Login user |
| GET | `/api/branches` | Get daftar cabang |

---

## 🔐 User Endpoints (Require Auth)

### Authentication

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/logout` | Logout user |

### Profile

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/me` | Get profil user (Sanctum) |
| GET | `/profile` | Get profil (Session) |
| PUT | `/api/profile` | Update profile |
| PUT | `/api/profile/password` | Update password |

### Dashboard

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/dashboard` | Get dashboard data |

### Branches

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/branches` | Get daftar cabang (auth) |

### Waste Types

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/waste-types` | Get jenis sampah & harga |

### Deposits (Setor Sampah)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/deposits` | Get riwayat setoran |
| GET | `/api/deposits/{id}` | Get detail setoran |

### Reward Items

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/reward-items` | Get daftar reward |
| GET | `/api/reward-items/{id}` | Get detail reward |

### Redemptions (Tukar Poin)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/redemptions` | Get riwayat penukaran |
| GET | `/api/redemptions/{id}` | Get detail penukaran |
| POST | `/api/redemptions` | Create penukaran baru |
| POST | `/api/redemptions/{id}/cancel` | Cancel penukaran |

### Cart System

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/cart` | Get isi keranjang |
| POST | `/cart/add/{rewardItemId}` | Tambah ke cart |
| POST | `/cart/update/{rewardItemId}` | Update quantity |
| DELETE | `/cart/remove/{rewardItemId}` | Hapus dari cart |
| POST | `/cart/clear` | Kosongkan cart |
| POST | `/cart/checkout` | Checkout cart |
| POST | `/tukar/{rewardItemId}/instant` | Tukar langsung (skip cart) |

### Notifications

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/notifikasi` | Get semua notifikasi |
| GET | `/api/notifikasi/unread-count` | Get jumlah unread |
| GET | `/notifikasi/{id}/read` | Mark as read |
| POST | `/notifikasi/read-all` | Mark all as read |

---

## 👨‍💼 Admin Endpoints (Require Admin Role)

### Admin - Deposits Management

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/setoran` | Get semua setoran |
| POST | `/admin/setoran` | Create setoran baru |
| GET | `/admin/setoran/{id}` | Get detail setoran |
| DELETE | `/admin/setoran/{id}` | Delete setoran |

### Admin - Redemptions Management

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/penukaran` | Get semua penukaran |
| GET | `/admin/penukaran/{id}` | Get detail penukaran |
| POST | `/admin/penukaran/{id}/approve` | Approve penukaran |
| POST | `/admin/penukaran/{id}/reject` | Reject penukaran |
| POST | `/admin/penukaran/{id}/complete` | Complete penukaran |
| POST | `/admin/penukaran/{id}/cancel` | Cancel penukaran |

### Admin - Reward Items Management

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/reward-items` | Get semua reward |
| POST | `/admin/reward-items` | Create reward baru |
| GET | `/admin/reward-items/{id}` | Get detail reward |
| PUT | `/admin/reward-items/{id}` | Update reward |
| DELETE | `/admin/reward-items/{id}` | Delete reward |
| POST | `/admin/reward-items/{id}/update-stock` | Update stock |

---

## 📦 Request Body Examples

### Register User
```json
{
    "full_name": "Budi Santoso",
    "email": "budi@test.com",
    "phone": "081234567890",
    "address": "Jl. Merdeka No. 123, Jakarta",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Login User
```json
{
    "email": "warga@test.com",
    "password": "password",
    "remember": true
}
```

### Update Profile
```json
{
    "name": "Budi Santoso Updated",
    "phone": "081234567999",
    "address": "Jl. Sudirman No. 456, Jakarta Pusat"
}
```

### Update Password
```json
{
    "current_password": "password123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

### Create Redemption
```json
{
    "items": [
        {
            "reward_item_id": 1,
            "quantity": 2
        },
        {
            "reward_item_id": 3,
            "quantity": 1
        }
    ],
    "notes": "Mohon kirim secepatnya, terima kasih!"
}
```

### Add to Cart
```json
{
    "quantity": 1
}
```

### Checkout Cart
```json
{
    "notes": "Kirim ke alamat rumah"
}
```

### Instant Redeem
```json
{
    "quantity": 1,
    "notes": "Tukar langsung"
}
```

### Create Deposit (Admin)
```json
{
    "user_id": 2,
    "items": [
        {
            "waste_type_id": 1,
            "weight": 5.5
        },
        {
            "waste_type_id": 2,
            "weight": 3.2
        }
    ],
    "notes": "Setoran dari warga Jl. Merdeka"
}
```

### Reject Redemption (Admin)
```json
{
    "reason": "Stok barang habis"
}
```

### Cancel Redemption (Admin)
```json
{
    "reason": "Dibatalkan oleh admin"
}
```

### Create Reward Item (Admin)
```json
{
    "name": "Voucher Belanja 100K",
    "description": "Voucher belanja Indomaret senilai Rp 100.000",
    "points_required": 100000,
    "stock": 50,
    "is_active": true
}
```

### Update Reward Item (Admin)
```json
{
    "name": "Voucher Belanja 100K Updated",
    "description": "Voucher belanja Alfamart/Indomaret senilai Rp 100.000",
    "points_required": 95000,
    "stock": 75,
    "is_active": true
}
```

### Update Stock (Admin)
```json
{
    "adjustment": 10,
    "note": "Restock bulanan"
}
```

---

## 📊 Response Status Codes

### Success Responses

| Code | Description | When |
|------|-------------|------|
| 200 | OK | GET requests successful |
| 201 | Created | POST create successful |
| 204 | No Content | DELETE successful |

### Client Error Responses

| Code | Description | When |
|------|-------------|------|
| 400 | Bad Request | Invalid request |
| 401 | Unauthorized | Token invalid/missing |
| 403 | Forbidden | No permission |
| 404 | Not Found | Resource not found |
| 422 | Unprocessable Entity | Validation error |

### Server Error Responses

| Code | Description | When |
|------|-------------|------|
| 500 | Internal Server Error | Server error |
| 503 | Service Unavailable | Server down |

---

## 🔑 Authentication

### Bearer Token (API)

Tambahkan di header:
```
Authorization: Bearer {your_token_here}
```

Generate token via Tinker:
```php
$user = App\Models\User::where('email', 'warga@test.com')->first();
$token = $user->createToken('api-token')->plainTextToken;
echo $token;
```

### Session-based (Web)

Login via `/login` endpoint. Session cookie otomatis tersimpan.

---

## 🎯 Common Headers

**Semua requests:**
```
Accept: application/json
```

**POST/PUT requests:**
```
Content-Type: application/json
```

**Protected routes:**
```
Authorization: Bearer {token}
```

---

## 💾 Database Seeder

Reset & seed database untuk testing:

```bash
php artisan migrate:fresh --seed
```

Default users setelah seed:
- **Admin:** admin@test.com / password
- **Warga:** warga@test.com / password

---

## 🔍 Search & Filter

Beberapa endpoints support query parameters:

**Deposits:**
```
GET /api/deposits?status=approved
GET /api/deposits?from=2024-01-01&to=2024-12-31
```

**Redemptions:**
```
GET /api/redemptions?status=pending
GET /api/redemptions?sort=created_at&order=desc
```

**Reward Items:**
```
GET /api/reward-items?is_active=1
GET /api/reward-items?min_points=50000&max_points=100000
```

---

**Last Updated:** December 2025  
**Version:** 1.0  
**Developer:** Gracia Pardede
