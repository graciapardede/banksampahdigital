# 🛠️ Troubleshooting Guide - Postman API Testing

Solusi untuk masalah umum saat testing API Bank Sampah Digital.

---

## 🚨 Common Issues & Solutions

### 1. ❌ Error: "Could not get any response"

**Penyebab:**
- Laravel server tidak running
- URL salah
- Firewall blocking

**Solusi:**

```bash
# Cek apakah server running
php artisan serve

# Jika error, coba port lain
php artisan serve --port=8001

# Update base_url di environment
# http://127.0.0.1:8001
```

**Test:**
```bash
# Di browser atau curl
http://127.0.0.1:8000
```

---

### 2. ❌ Error: "401 Unauthenticated"

**Penyebab:**
- Token tidak ada
- Token expired
- Token invalid
- Header Authorization salah

**Solusi A - Generate Token Baru:**

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'warga@test.com')->first();

# Hapus token lama
$user->tokens()->delete();

# Generate token baru
$token = $user->createToken('postman-test')->plainTextToken;
echo $token;
exit
```

**Solusi B - Check Authorization:**

Di Postman, pastikan:
1. Tab **Authorization** → Type: **Bearer Token**
2. Token field: `{{api_token}}`
3. Environment variable `api_token` sudah diisi

**Solusi C - Check Header:**

Tambahkan manual di Headers:
```
Authorization: Bearer <paste_token_here>
Accept: application/json
```

---

### 3. ❌ Error: "404 Not Found"

**Penyebab:**
- Route tidak ada
- ID resource tidak ditemukan
- URL typo

**Solusi:**

**Check routes:**
```bash
php artisan route:list | grep api
```

**Check URL:**
```
# Salah
http://127.0.0.1:8000/apis/deposits

# Benar
http://127.0.0.1:8000/api/deposits
```

**Check ID exists:**
```php
# Di tinker
App\Models\Deposit::find(1);  # Null = tidak ada
```

---

### 4. ❌ Error: "422 Unprocessable Entity" (Validation Error)

**Penyebab:**
- Required field kosong
- Format data salah
- Constraint violation

**Solusi:**

**Check response body untuk detail error:**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password must be at least 8 characters."
        ]
    }
}
```

**Fix berdasarkan error message:**
```json
{
    "email": "user@test.com",      // ✅ Tambahkan field yang missing
    "password": "password123"       // ✅ Min 8 karakter
}
```

---

### 5. ❌ Error: "SQLSTATE[HY000] [2002] Connection refused"

**Penyebab:**
- Database tidak running
- Config database salah

**Solusi:**

**Check database service:**
```bash
# MySQL di Laragon
# Buka Laragon → Start All
```

**Check .env file:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=banksampahdigital
DB_USERNAME=root
DB_PASSWORD=
```

**Test connection:**
```bash
php artisan migrate:status
```

---

### 6. ❌ Error: "Insufficient points"

**Penyebab:**
- User tidak punya cukup poin untuk redemption

**Solusi:**

**Check balance:**
```php
$user = App\Models\User::find(2);
echo $user->balance_points;
```

**Add points (Admin):**
```php
# Buat deposit untuk user
$deposit = App\Models\Deposit::create([
    'user_id' => 2,
    'total_weight' => 10,
    'total_points' => 50000,
    'status' => 'approved'
]);

# Update balance
$user->balance_points += 50000;
$user->save();
```

**Atau create deposit via API:**
```json
POST /admin/setoran
{
    "user_id": 2,
    "items": [
        {
            "waste_type_id": 1,
            "weight": 10
        }
    ]
}
```

---

### 7. ❌ Error: "Out of stock"

**Penyebab:**
- Reward item stock habis

**Solusi:**

**Check stock:**
```php
$reward = App\Models\RewardItem::find(1);
echo $reward->stock;
```

**Update stock (Admin):**
```json
POST /admin/reward-items/1/update-stock
{
    "adjustment": 50,
    "note": "Restock"
}
```

---

### 8. ❌ Token tidak tersimpan di Environment

**Penyebab:**
- Lupa save environment
- Copas ke wrong field

**Solusi:**

1. Klik icon ⚙️ (Environment)
2. Pilih environment yang aktif
3. Find variable `api_token`
4. Paste token di **Current Value** (bukan Initial Value)
5. **KLIK SAVE** ⚠️
6. Refresh Postman

---

### 9. ❌ Request body tidak terkirim (empty)

**Penyebab:**
- Body type salah
- Header Content-Type tidak diset

**Solusi:**

Di Postman:
1. Tab **Body**
2. Pilih **raw**
3. Dropdown kanan: Pilih **JSON**
4. Di Headers, pastikan ada:
   ```
   Content-Type: application/json
   ```

---

### 10. ❌ CORS Error (dari browser)

**Penyebab:**
- Testing dari browser, bukan Postman
- CORS config belum diset

**Solusi:**

**Jika testing dari Postman Desktop:**
- CORS tidak apply, tidak perlu fix

**Jika testing dari Postman Web:**
- Install Postman Desktop App
- Atau add header:
```
Access-Control-Allow-Origin: *
```

---

## 🔧 Debugging Tools

### 1. Postman Console

**Cara buka:**
- `Ctrl + Alt + C` (Windows)
- `Cmd + Alt + C` (Mac)

**Manfaat:**
- Lihat raw request/response
- Debug headers
- Check cookies
- Monitor network

### 2. Laravel Log

**Location:**
```
storage/logs/laravel.log
```

**Watch log:**
```bash
# Real-time monitoring
tail -f storage/logs/laravel.log
```

**Clear log:**
```bash
echo "" > storage/logs/laravel.log
```

### 3. Tinker (Laravel Console)

**Useful commands:**

```php
# Check user
$user = App\Models\User::find(1);
$user->toArray();

# Check balance
$user->balance_points;

# Check deposits
App\Models\Deposit::where('user_id', 1)->get();

# Check redemptions
App\Models\Redemption::where('user_id', 1)->get();

# Check reward items
App\Models\RewardItem::where('is_active', 1)->get();

# Check waste types
App\Models\WasteType::all();
```

### 4. Database Query

```sql
-- Check users
SELECT id, name, email, role, balance_points FROM users;

-- Check deposits
SELECT id, user_id, total_weight, total_points, status 
FROM deposits ORDER BY created_at DESC LIMIT 10;

-- Check redemptions
SELECT id, user_id, total_points, status 
FROM redemptions ORDER BY created_at DESC LIMIT 10;

-- Check reward items
SELECT id, name, points_required, stock, is_active 
FROM reward_items;
```

---

## 🎯 Testing Checklist

Jika masalah persists, check semua ini:

### Server
- [ ] Laravel server running (`php artisan serve`)
- [ ] Database running (MySQL/PostgreSQL)
- [ ] Port 8000 tidak digunakan app lain

### Environment
- [ ] Environment selected di Postman
- [ ] `base_url` benar (http://127.0.0.1:8000)
- [ ] `api_token` sudah diisi & saved

### Request
- [ ] Method benar (GET/POST/PUT/DELETE)
- [ ] URL benar (check typo)
- [ ] Headers lengkap (Accept, Content-Type, Authorization)
- [ ] Body format benar (JSON)
- [ ] Required fields semua ada

### Authorization
- [ ] Token valid (generate baru jika expired)
- [ ] User role sesuai (admin untuk admin endpoints)
- [ ] Token set di Authorization tab atau Headers

### Database
- [ ] Migrations sudah run
- [ ] Seeders sudah run (optional)
- [ ] Data test tersedia (users, waste_types, dll)

---

## 🚑 Emergency Reset

Jika semua tidak work, reset everything:

```bash
# 1. Stop server
Ctrl + C

# 2. Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# 3. Reset database
php artisan migrate:fresh --seed

# 4. Restart server
php artisan serve

# 5. Generate new token
php artisan tinker
$user = App\Models\User::where('email', 'warga@test.com')->first();
$token = $user->createToken('test')->plainTextToken;
echo $token;
exit

# 6. Update token di Postman environment

# 7. Test public endpoint first
GET /api/branches
```

---

## 📞 Get Help

Jika masih error:

1. **Check Laravel Log:**
   ```
   storage/logs/laravel.log
   ```

2. **Enable Debug Mode:**
   ```env
   APP_DEBUG=true
   ```

3. **Check Postman Console:**
   `Ctrl + Alt + C`

4. **Ask in Forum:**
   - Laravel Discord
   - Stack Overflow
   - Reddit r/laravel

---

## 💡 Pro Tips

**Tip 1:** Selalu test public endpoint dulu sebelum yang protected

**Tip 2:** Generate token baru setiap kali mulai testing session

**Tip 3:** Save request sebagai example setelah berhasil

**Tip 4:** Export collection & environment untuk backup

**Tip 5:** Use Postman Console untuk debugging

---

**Happy Debugging! 🎉**

Developer: Gracia Pardede  
Project: Bank Sampah Digital (Green Saving)
