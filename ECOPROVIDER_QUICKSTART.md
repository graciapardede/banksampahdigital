# ⚡ ECOPROVIDER - QUICK START GUIDE

**Domain:** services.bsdgs.fun  
**Status:** Setup & Testing Guide  

---

## 🚀 YANG PERLU ANDA LAKUKAN (4 STEPS)

### STEP 1: Verifikasi Struktur Folder (5 menit)

SSH ke hosting:
```bash
ssh user@yourdomain.com

# Navigate ke project
cd public_html/EcoProvider

# Verify struktur
ls -la

# Harus ada:
# drwxr-xr-x app/
# drwxr-xr-x bootstrap/
# drwxr-xr-x config/
# drwxr-xr-x public/
# drwxr-xr-x routes/
# drwxr-xr-x storage/
# drwxr-xr-x vendor/
# -rw-r--r-- .env
# -rw-r--r-- artisan
# -rw-r--r-- composer.json
```

❌ **Jika ada yang missing?**
- Folder: Upload/clone project
- Vendor: Run `composer install`
- .env: Copy dari `.env.example`

✅ **Jika semua lengkap, lanjut STEP 2**

---

### STEP 2: Configure & Install (10 menit)

```bash
# Navigate ke project (jika belum)
cd public_html/EcoProvider

# 1. Update .env
nano .env

# Ubah ini:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://services.bsdgs.fun
APP_KEY=base64:... (already set, jangan ubah)
```

**Save:** Ctrl+X → Y → Enter

```bash
# 2. Install dependencies
composer install --no-dev --optimize-autoloader

# 3. Generate APP_KEY (jika empty)
php artisan key:generate

# 4. Clear cache
php artisan optimize:clear

# 5. Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 6. Set permissions
chmod -R 775 storage bootstrap/cache
chmod 644 .env

# Output harus sukses semua (no errors)
```

✅ **Jika semua berhasil, lanjut STEP 3**

---

### STEP 3: Setup Subdomain (5-10 menit)

**Pilih salah satu:**

#### Option A: cPanel (EASIEST)
1. Login cPanel: https://yourdomain.com:2083
2. Click: **Addon Domains** atau **Subdomains**
3. Create: `services.bsdgs.fun`
4. Document Root: `public_html/EcoProvider/public`
5. Click: Add/Create
6. Wait: 1-5 minutes untuk DNS

#### Option B: Plesk
1. Login Plesk: https://yourdomain.com:8443
2. Click: Hosting & Subscriptions → bsdgs.fun
3. Tab: Subdomains → Add
4. Name: `services`
5. Document Root: `EcoProvider/public`
6. SSL: Auto (Let's Encrypt)
7. OK

#### Option C: SSH/Manual
Lihat file: `ECOPROVIDER_SUBDOMAIN_SETUP.md`

✅ **Jika subdomain sudah created, lanjut STEP 4**

---

### STEP 4: Testing (5 menit)

**Test 1: From SSH**
```bash
# SSH:
curl https://services.bsdgs.fun/api/status

# Expected output:
# {"status":"ok"}
```

**Test 2: From Your Computer**
```powershell
# PowerShell:
curl https://services.bsdgs.fun/api/status

# Expected output:
# {"status":"ok"}
```

**Test 3: Check in Browser**
```
Open: https://services.bsdgs.fun/api/status
Should see: {"status":"ok"}
Green lock icon (HTTPS working)
```

**Test 4: Check Error Logs**
```bash
# SSH:
tail -20 storage/logs/laravel.log

# Should NOT have errors
# Should show "configured successfully"
```

---

## ✅ SUCCESS CHECKLIST

- [ ] Folder structure verified
- [ ] .env updated (production, correct URL)
- [ ] `composer install` ran successfully
- [ ] `php artisan key:generate` ran
- [ ] `php artisan optimize:clear` ran
- [ ] `php artisan config:cache` ran
- [ ] Subdomain created in control panel
- [ ] DNS propagated (1-5 minutes)
- [ ] `curl https://services.bsdgs.fun/api/status` returns `{"status":"ok"}`
- [ ] No errors in `storage/logs/laravel.log`

---

## 🐛 IF SOMETHING GOES WRONG

### Error: 404 Not Found

```bash
# SSH:

# 1. Check .htaccess
ls -la public/.htaccess

# 2. Check rewrite module
apache2ctl -M | grep rewrite

# 3. If missing, enable:
a2enmod rewrite
systemctl restart apache2

# 4. Clear cache
php artisan config:clear
```

### Error: 500 Internal Server Error

```bash
# SSH:

# 1. Check logs
tail -50 storage/logs/laravel.log

# 2. Check APP_KEY
grep APP_KEY .env

# 3. Fix permissions
chmod -R 775 storage bootstrap/cache

# 4. Clear cache
php artisan optimize:clear
```

### Error: Cannot Connect (Timeout)

```bash
# 1. Check DNS:
nslookup services.bsdgs.fun

# 2. Check Apache running:
systemctl status apache2

# 3. Wait for DNS (24 hours max)
# 4. Try from different network
```

### Error: Mixed Content

```bash
# Edit .env:
APP_URL=https://services.bsdgs.fun  # Use HTTPS://

# Clear cache:
php artisan config:clear
```

---

## 📚 DETAILED GUIDES

Untuk instruksi lengkap, baca file-file ini:

| File | Untuk |
|------|-------|
| `ECOPROVIDER_DEPLOYMENT_GUIDE.md` | Setup lengkap step-by-step |
| `ECOPROVIDER_VERIFICATION_CHECKLIST.md` | Verifikasi struktur & file |
| `ECOPROVIDER_SUBDOMAIN_SETUP.md` | Setup subdomain detail |

---

## 🎯 TL;DR (COPY-PASTE)

```bash
# SSH: Semua commands dalam satu blok

cd public_html/EcoProvider && \
composer install --no-dev --optimize-autoloader && \
php artisan key:generate && \
php artisan optimize:clear && \
php artisan config:cache && \
php artisan route:cache && \
php artisan view:cache && \
php artisan optimize && \
chmod -R 775 storage bootstrap/cache && \
chmod 644 .env && \
php artisan route:list | grep status && \
curl https://services.bsdgs.fun/api/status

# Last command harus output: {"status":"ok"}
# Done! ✅
```

---

**Created:** December 13, 2025  
**Status:** ✅ Ready to Deploy  
**Next:** Follow STEP 1-4 di atas, selesai!
