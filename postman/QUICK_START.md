# 🚀 Quick Start Guide - Postman Testing

Panduan cepat untuk memulai testing API dalam 5 menit!

---

## ⚡ Setup Cepat (5 Menit)

### 1. Import Files (1 menit)

**Import Environment:**
- Buka Postman
- Klik **Environments** → **Import**
- Pilih `BankSampahDigital.postman_environment.json`

**Import Collection:**
- Klik **Collections** → **Import**  
- Pilih `BankSampahDigital.postman_collection.json`

### 2. Pilih Environment (10 detik)

Di dropdown kanan atas, pilih: **"Bank Sampah Digital - Local"**

### 3. Start Laravel Server (30 detik)

```bash
cd d:\laragon\www\banksampahdigital
php artisan serve
```

Pastikan running di: `http://127.0.0.1:8000`

### 4. Test Public Endpoint (30 detik)

Buka: **4. Branches (Cabang)** → **Get All Branches (Public)**

Klik **Send**

✅ Jika dapat response 200 dengan data, setup berhasil!

### 5. Generate Token (2 menit)

**Buka terminal baru:**

```bash
php artisan tinker
```

**Di Tinker:**

```php
$user = App\Models\User::where('email', 'warga@test.com')->first();
$token = $user->createToken('postman-test')->plainTextToken;
echo $token;
exit
```

**Copy token yang muncul**

### 6. Set Token di Environment (1 menit)

1. Klik icon ⚙️ (Environment) di kanan atas
2. Klik **Bank Sampah Digital - Local**
3. Edit variable `api_token`
4. Paste token di kolom **Current Value**
5. Klik **Save**

---

## 🎯 Testing Pertama (User Flow)

### Scenario: User Tukar Poin

**1. Login dulu (optional, jika pakai session):**

`1. Authentication` → `Login User`

**2. Cek profil:**

`2. User Profile` → `Get User Profile (API)`

**3. Lihat reward yang tersedia:**

`7. Reward Items` → `Get All Reward Items`

**4. Tambah ke cart:**

`9. Cart System` → `Add to Cart`

Body:
```json
{
    "quantity": 1
}
```

URL: `{{base_url}}/cart/add/1` (1 = reward_item_id)

**5. Lihat cart:**

`9. Cart System` → `Get Cart Items`

**6. Checkout:**

`9. Cart System` → `Checkout Cart`

Body:
```json
{
    "notes": "Kirim secepatnya!"
}
```

**7. Cek riwayat penukaran:**

`8. Redemptions` → `Get All Redemptions`

✅ **Selesai! User berhasil tukar poin!**

---

## 🔧 Testing Admin Flow

### Scenario: Admin Proses Setoran

**⚠️ Catatan:** Generate token untuk user admin dulu!

```php
$admin = App\Models\User::where('role', 'admin')->first();
$token = $admin->createToken('admin-test')->plainTextToken;
echo $token;
```

Update token di environment!

**1. Lihat semua user:**

Bisa via tinker atau database

**2. Create setoran untuk user:**

`11. Admin - Deposits` → `Create Deposit (Admin)`

Body:
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
    "notes": "Setoran warga Jl. Merdeka"
}
```

**3. Lihat semua setoran:**

`11. Admin - Deposits` → `Get All Deposits (Admin)`

**4. Proses redemption user:**

`12. Admin - Redemptions` → `Get All Redemptions (Admin)`

Pilih redemption yang pending:

`12. Admin - Redemptions` → `Approve Redemption`

URL: `{{base_url}}/admin/penukaran/{id}/approve`

**5. Selesaikan redemption:**

`12. Admin - Redemptions` → `Complete Redemption`

✅ **Done! Admin berhasil proses transaksi!**

---

## 🎨 Customize Environment

Edit environment untuk kebutuhan Anda:

```json
{
    "base_url": "http://127.0.0.1:8000",      // Ganti jika beda port
    "api_token": "your_token_here",           // Token user
    "admin_token": "admin_token_here",        // Token admin
    "user_email": "warga@test.com",
    "user_password": "password",
    "test_user_id": "2",
    "test_reward_id": "1",
    "test_waste_type_id": "1"
}
```

Gunakan di request: `{{test_user_id}}`

---

## 📊 Testing Checklist

### ✅ User Features
- [ ] Register
- [ ] Login
- [ ] Get Profile
- [ ] Update Profile
- [ ] Update Password
- [ ] Get Dashboard
- [ ] View Deposits History
- [ ] View Reward Items
- [ ] Add to Cart
- [ ] Checkout Cart
- [ ] View Redemptions
- [ ] Cancel Redemption
- [ ] View Notifications

### ✅ Admin Features
- [ ] Create Deposit
- [ ] View All Deposits
- [ ] Delete Deposit
- [ ] View All Redemptions
- [ ] Approve Redemption
- [ ] Reject Redemption
- [ ] Complete Redemption
- [ ] Create Reward Item
- [ ] Update Reward Item
- [ ] Update Stock
- [ ] Delete Reward Item

### ✅ Error Handling
- [ ] Test 401 Unauthorized
- [ ] Test 404 Not Found
- [ ] Test 422 Validation Error
- [ ] Test Insufficient Points

---

## 💡 Pro Tips

**Tip 1: Duplicate Requests**

Klik kanan request → Duplicate → Rename untuk testing variants

**Tip 2: Use Scripts**

Pre-request script untuk set variables:
```javascript
pm.environment.set("timestamp", Date.now());
```

**Tip 3: Run Collection**

Klik Collection → Run → Test semua endpoints sekaligus!

**Tip 4: Export untuk Backup**

Collection → ⋯ → Export → Save JSON file

**Tip 5: Share dengan Team**

Export collection & environment → Share file JSON

---

## 🆘 Need Help?

**Server tidak running:**
```bash
php artisan serve
```

**Token expired:**
```bash
php artisan tinker
$user->tokens()->delete();  # Hapus semua token lama
$token = $user->createToken('new')->plainTextToken;
```

**Reset database:**
```bash
php artisan migrate:fresh --seed
```

---

**Happy Testing! 🎉**

Developer: Gracia Pardede  
Project: Bank Sampah Digital (Green Saving)
