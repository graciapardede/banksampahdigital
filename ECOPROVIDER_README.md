# ✅ ECOPROVIDER DEPLOYMENT - COMPLETE GUIDE

**Domain:** services.bsdgs.fun  
**Project:** EcoProvider  
**Status:** ✅ Complete Documentation Ready  

---

## 📚 DOKUMENTASI YANG SUDAH SAYA BUAT

Saya telah membuat **4 file dokumentasi lengkap** untuk deployment EcoProvider:

### 1. **ECOPROVIDER_QUICKSTART.md** ⭐ START HERE!
- **Durasi:** 5 menit untuk dibaca
- **Untuk:** Instruksi cepat yang perlu langsung dijalankan
- **Konten:** 4 STEPS utama dengan copy-paste ready commands
- **Cocok untuk:** User yang terburu-buru

### 2. **ECOPROVIDER_DEPLOYMENT_GUIDE.md**
- **Durasi:** 30 menit untuk dibaca
- **Untuk:** Panduan lengkap step-by-step
- **Konten:** 12 langkah detail dengan penjelasan setiap step
- **Cocok untuk:** User yang ingin memahami setiap detail

### 3. **ECOPROVIDER_VERIFICATION_CHECKLIST.md**
- **Durasi:** 20 menit untuk dibaca
- **Untuk:** Verifikasi struktur folder & file
- **Konten:** Checklist lengkap, permissions, testing
- **Cocok untuk:** User yang ingin pastikan semuanya benar

### 4. **ECOPROVIDER_SUBDOMAIN_SETUP.md**
- **Durasi:** 15 menit untuk dibaca
- **Untuk:** Konfigurasi subdomain detail
- **Konten:** 3 metode (cPanel, SSH, Plesk) + troubleshooting
- **Cocok untuk:** Setup subdomain services.bsdgs.fun

---

## 🚀 QUICK SUMMARY - APA YANG HARUS ANDA LAKUKAN

### Jika Belum Ada Project di Hosting:
1. Upload/clone EcoProvider project ke: `public_html/EcoProvider`
2. Pastikan struktur folder lengkap (app/, bootstrap/, public/, etc)
3. Verify vendor/ folder atau jalankan: `composer install`

### Jika Sudah Ada Project di Hosting:
**Ikuti 4 STEPS di `ECOPROVIDER_QUICKSTART.md`:**

1. **Verify Struktur** - 5 menit
2. **Configure & Install** - 10 menit
3. **Setup Subdomain** - 5-10 menit
4. **Testing** - 5 menit

**Total:** ~35 menit untuk complete setup

---

## 🎯 COMMANDS RINGKAS

### Untuk SSH (Copy-Paste):

```bash
# Setup
cd public_html/EcoProvider
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan optimize:clear

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Permissions
chmod -R 775 storage bootstrap/cache
chmod 644 .env

# Test
curl https://services.bsdgs.fun/api/status
# Expected: {"status":"ok"}
```

---

## 📋 STRUKTUR YANG HARUS ADA

```
public_html/EcoProvider/
├── app/                 ✅ Application code
├── bootstrap/           ✅ Bootstrap (cache writable)
├── config/              ✅ Configuration
├── database/            ✅ Migrations & seeders
├── public/              ✅ Document Root (IMPORTANT!)
│   ├── index.php       ✅ Entry point
│   └── .htaccess       ✅ Routing rules
├── routes/              ✅ Routes definition
│   └── api.php         ✅ API routes
├── storage/             ✅ Logs & cache (writable)
├── vendor/              ✅ Composer packages
├── .env                 ✅ Configuration (production)
├── artisan              ✅ Console application
└── composer.json        ✅ Dependencies
```

---

## ⚙️ FILE .ENV YANG DIPERLUKAN

```env
APP_NAME=EcoProvider
APP_ENV=production          ← IMPORTANT
APP_KEY=base64:...         ← Auto-generated
APP_DEBUG=false            ← IMPORTANT
APP_URL=https://services.bsdgs.fun  ← IMPORTANT

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ecoprovider_db
DB_USERNAME=user
DB_PASSWORD=password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

---

## 🔧 ROUTES YANG WAJIB ADA

**File:** `routes/api.php`

```php
// Health check - WAJIB untuk testing
Route::get('/status', fn() => response()->json(['status' => 'ok'], 200));

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'app_name' => config('app.name'),
        'environment' => config('app.env'),
        'timestamp' => now()->toIso8601String(),
        'url' => config('app.url'),
    ], 200);
});

// Your API routes here
// Route::get('/news', ...);
// Route::post('/news', ...);
```

---

## 🧪 TESTING

### Test 1: Verify dari SSH
```bash
curl https://services.bsdgs.fun/api/status
# Expected: {"status":"ok"}
```

### Test 2: Verify dari Browser
```
https://services.bsdgs.fun/api/status
# Should show JSON: {"status":"ok"}
```

### Test 3: Check in Green Saving
```javascript
// Di Green Saving (localhost:8000), buka F12 console:
fetch('https://services.bsdgs.fun/api/status')
  .then(r => r.json())
  .then(d => console.log('Success:', d))
  .catch(e => console.error('Error:', e))

// Should log: Success: {status: 'ok'}
```

---

## ⚠️ COMMON ISSUES

| Error | Cause | Fix |
|-------|-------|-----|
| 404 Not Found | .htaccess missing | Check `public/.htaccess` exists |
| 500 Internal Error | APP_KEY empty | Run `php artisan key:generate` |
| Connection Timeout | DNS not propagated | Wait 1-24 hours |
| Mixed Content | HTTP in .env | Change to `APP_URL=https://` |
| CORS Error | Domain not whitelisted | Add domain to CORS config |

---

## ✅ DEPLOYMENT CHECKLIST

- [ ] Project uploaded to `public_html/EcoProvider`
- [ ] Folder structure verified (12 folders)
- [ ] .env file configured (production, correct URL)
- [ ] Ran `composer install --no-dev`
- [ ] Ran `php artisan key:generate`
- [ ] Ran `php artisan optimize:clear`
- [ ] Ran `php artisan config:cache`
- [ ] Ran `php artisan route:cache`
- [ ] Ran `php artisan optimize`
- [ ] Permissions set (775 for storage)
- [ ] Subdomain created (services.bsdgs.fun)
- [ ] Subdomain points to `public/` folder
- [ ] `/api/status` endpoint working
- [ ] HTTPS/SSL enabled
- [ ] No errors in `storage/logs/laravel.log`

---

## 📚 NEXT STEPS

### Recommended Reading Order:

1. **First:** Read `ECOPROVIDER_QUICKSTART.md` (5 min)
2. **Then:** Follow the 4 STEPS in quickstart guide
3. **If Error:** Read `ECOPROVIDER_DEPLOYMENT_GUIDE.md` (detail)
4. **For Subdomain:** Read `ECOPROVIDER_SUBDOMAIN_SETUP.md`
5. **To Verify:** Use `ECOPROVIDER_VERIFICATION_CHECKLIST.md`

---

## 🎯 EXPECTED RESULT

✅ **Setelah selesai, Anda akan punya:**

1. ✅ EcoProvider running on `services.bsdgs.fun`
2. ✅ API endpoints accessible via HTTPS
3. ✅ `/api/status` returns `{"status":"ok"}`
4. ✅ Logs properly configured
5. ✅ Ready for Green Saving to consume API

---

## 📞 TROUBLESHOOTING QUICK LINKS

- **404 Error?** → Check ECOPROVIDER_DEPLOYMENT_GUIDE.md Step 2 (.htaccess)
- **500 Error?** → Check ECOPROVIDER_DEPLOYMENT_GUIDE.md Step 12 (Logs)
- **Subdomain Issue?** → Check ECOPROVIDER_SUBDOMAIN_SETUP.md
- **SSL/HTTPS Issue?** → Check ECOPROVIDER_SUBDOMAIN_SETUP.md (SSL section)
- **CORS Issue?** → Check routes/api.php (add CORS middleware)

---

## 📝 FINAL NOTES

✅ **Semua dokumentasi sudah disiapkan dengan:**
- Clear step-by-step instructions
- Copy-paste ready commands
- Troubleshooting guides
- Verification checklists
- Multiple configuration methods

✅ **Anda tinggal:**
1. SSH ke hosting
2. Navigate ke project folder
3. Copy-paste commands dari ECOPROVIDER_QUICKSTART.md
4. Test dengan: `curl https://services.bsdgs.fun/api/status`

**That's it! ✅**

---

**Created:** December 13, 2025  
**For:** EcoProvider Deployment  
**Status:** ✅ Complete & Ready to Deploy
