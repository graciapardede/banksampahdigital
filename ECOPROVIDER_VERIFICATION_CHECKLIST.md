# ✅ ECOPROVIDER DEPLOYMENT - VERIFICATION CHECKLIST

**Domain:** services.bsdgs.fun  
**Project:** EcoProvider  
**Status:** Deployment Verification Guide

---

## 📋 STRUKTUR FOLDER YANG HARUS ADA

### Verifikasi Folder Utama

```
EcoProvider/
├── app/                      ← Application files
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   ├── Models/
│   └── ...
├── bootstrap/                ← Bootstrap files
│   ├── app.php
│   ├── providers.php
│   └── cache/               ← PENTING: harus writable
├── config/                   ← Configuration files
│   ├── app.php
│   ├── database.php
│   └── ...
├── database/                 ← Database files
│   ├── migrations/
│   ├── seeders/
│   └── ...
├── public/                   ← DOCUMENT ROOT ⭐
│   ├── index.php            ← Entry point
│   ├── .htaccess            ← Routing rules
│   ├── css/
│   ├── js/
│   └── ...
├── resources/                ← Views & assets
│   ├── css/
│   ├── js/
│   ├── views/
│   └── ...
├── routes/                   ← Routes definition
│   ├── api.php              ← API ROUTES ⭐
│   ├── web.php
│   └── console.php
├── storage/                  ← Logs & cache (WRITABLE)
│   ├── app/
│   ├── framework/
│   ├── logs/
│   └── ...
├── tests/                    ← Test files
├── vendor/                   ← Composer packages (REQUIRED)
│   └── autoload.php
├── .env                      ← Configuration (LOCAL) ⭐
├── .env.example
├── .gitignore
├── artisan                   ← Console application
├── composer.json             ← Dependencies list
├── composer.lock             ← Lock file
├── package.json              ← NPM packages (optional)
└── README.md
```

### Perlu Dibuat/Diverifikasi

```bash
# SSH command untuk verify struktur:
cd public_html/EcoProvider

# List semua folder
ls -la

# Check specific folders exist
test -d app && echo "✅ app/" || echo "❌ app/ missing"
test -d bootstrap && echo "✅ bootstrap/" || echo "❌ bootstrap/ missing"
test -d config && echo "✅ config/" || echo "❌ config/ missing"
test -d database && echo "✅ database/" || echo "❌ database/ missing"
test -d public && echo "✅ public/" || echo "❌ public/ missing"
test -d resources && echo "✅ resources/" || echo "❌ resources/ missing"
test -d routes && echo "✅ routes/" || echo "❌ routes/ missing"
test -d storage && echo "✅ storage/" || echo "❌ storage/ missing"
test -d vendor && echo "✅ vendor/" || echo "❌ vendor/ missing"
test -f artisan && echo "✅ artisan" || echo "❌ artisan missing"
test -f composer.json && echo "✅ composer.json" || echo "❌ composer.json missing"
test -f .env && echo "✅ .env" || echo "❌ .env missing"

# Result: Semua harus ✅
```

---

## 🔧 FILE-FILE PENTING YANG PERLU DIVERIFIKASI

### 1. File: `public/.htaccess`

**Status:** ✅ WAJIB ADA (untuk routing Laravel)

**Lokasi:** `EcoProvider/public/.htaccess`

**Konten (Standard Laravel 11):**

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**Verifikasi di SSH:**
```bash
cat public/.htaccess
# Should output the rewrite rules above

# Or check if exists:
ls -la public/.htaccess
```

---

### 2. File: `public/index.php`

**Status:** ✅ WAJIB ADA (entry point)

**Lokasi:** `EcoProvider/public/index.php`

**Verifikasi:**
```bash
head -20 public/index.php

# Should show:
# <?php
# use Illuminate\Contracts\Http\Kernel;
# 
# define('LARAVEL_START', microtime(true));
# ...
```

---

### 3. File: `.env`

**Status:** ✅ CRITICAL untuk production

**Lokasi:** `EcoProvider/.env`

**Konten yang Diperlukan:**

```env
# App Configuration
APP_NAME=EcoProvider
APP_ENV=production
APP_KEY=base64:your_key_here_from_key_generate
APP_DEBUG=false
APP_URL=https://services.bsdgs.fun

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=info

# Database (jika digunakan)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ecoprovider_db
DB_USERNAME=ecoprovider_user
DB_PASSWORD=secure_password

# Cache & Session
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local

# Mail (optional)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@services.bsdgs.fun

# Misc
BROADCAST_CONNECTION=log
```

**Verifikasi:**
```bash
cat .env | grep -E "APP_ENV|APP_URL|APP_KEY|APP_DEBUG"

# Output harus:
# APP_ENV=production
# APP_URL=https://services.bsdgs.fun
# APP_KEY=base64:...
# APP_DEBUG=false
```

---

### 4. File: `routes/api.php`

**Status:** ✅ CRITICAL untuk testing

**Lokasi:** `EcoProvider/routes/api.php`

**Konten Minimal (untuk testing):**

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Status endpoint - WAJIB untuk verify deployment
Route::get('/status', fn() => response()->json(['status' => 'ok'], 200));

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'app_name' => config('app.name'),
        'environment' => config('app.env'),
        'timestamp' => now()->toIso8601String(),
        'url' => config('app.url'),
    ], 200);
});

// Your API routes here:
// Route::get('/news', [...]);
// Route::post('/news', [...]);
// etc.
```

**Verifikasi:**
```bash
grep -n "api/status\|get('/status" routes/api.php

# Output should show:
# Line with: Route::get('/status', ...)
```

---

### 5. File: `composer.json`

**Status:** ✅ Harus Ada

**Lokasi:** `EcoProvider/composer.json`

**Verifikasi:**
```bash
cat composer.json | head -10

# Should show:
# {
#     "name": "laravel/laravel",
#     "type": "project",
#     ...
```

---

### 6. File: `artisan`

**Status:** ✅ Harus Ada

**Lokasi:** `EcoProvider/artisan`

**Verifikasi:**
```bash
ls -la artisan

# Should output:
# -rwxr-xr-x  ... artisan

file artisan

# Should output:
# artisan: PHP script text executable
```

---

## 🔐 FILE PERMISSIONS

**Verifikasi & Set Permissions:**

```bash
# SSH: Navigate to project
cd public_html/EcoProvider

# Check current permissions
ls -la storage bootstrap/cache .env

# Set correct permissions
chmod 755 bootstrap/cache storage
chmod 644 .env
chmod 755 artisan

# Recursive for storage
chmod -R 775 storage bootstrap/cache

# Verify again
ls -ld storage bootstrap/cache
ls -l .env

# Output should be:
# drwxrwxr-x ... storage
# drwxrwxr-x ... bootstrap/cache
# -rw-r--r-- ... .env
```

---

## 🚀 DEPLOYMENT COMMANDS (SSH)

**Copy-paste sesuai urutan:**

```bash
# Step 1: Navigate to project
cd public_html/EcoProvider

# Step 2: Install dependencies (if vendor not exist)
composer install --no-dev --optimize-autoloader

# Step 3: Generate APP_KEY (if empty)
php artisan key:generate

# Step 4: Clear old cache
php artisan optimize:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

# Step 5: Rebuild cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Step 6: Verify
php artisan --version
php artisan route:list | grep "api/status\|api/health"

# Expected output:
# Laravel Framework X.Y.Z
# GET|HEAD  api/status
# GET|HEAD  api/health
```

---

## 🧪 TESTING - FROM SSH

**Jalankan langsung dari SSH server:**

```bash
# Test 1: Basic status endpoint
curl https://services.bsdgs.fun/api/status

# Expected output:
# {"status":"ok"}

# Test 2: Health with details
curl https://services.bsdgs.fun/api/health

# Expected output:
# {
#   "status":"ok",
#   "app_name":"EcoProvider",
#   "environment":"production",
#   "timestamp":"2025-12-13T...",
#   "url":"https://services.bsdgs.fun"
# }

# Test 3: With verbose (see headers)
curl -v https://services.bsdgs.fun/api/status

# Should see:
# < HTTP/1.1 200 OK
# < Content-Type: application/json
# < Content-Length: XX

# Test 4: Check headers
curl -i https://services.bsdgs.fun/api/status

# Should see:
# HTTP/1.1 200 OK
# Content-Type: application/json
# ...
```

---

## 🧪 TESTING - FROM YOUR COMPUTER

**Setelah SSH tests pass:**

```powershell
# PowerShell

# Test 1: Simple request
curl https://services.bsdgs.fun/api/status

# Test 2: Verbose (detailed output)
curl -v https://services.bsdgs.fun/api/status

# Test 3: Show headers only
curl -i https://services.bsdgs.fun/api/status

# Test 4: From Green Saving (test CORS)
# In browser console or JS:
fetch('https://services.bsdgs.fun/api/status')
  .then(r => r.json())
  .then(d => console.log('Success:', d))
  .catch(e => console.error('Error:', e))

# Should log: Success: {status: 'ok'}
```

---

## ⚠️ COMMON ERRORS & SOLUTIONS

### ❌ 404 Not Found

**Cause:** .htaccess or routing issue

**Fix:**
```bash
# 1. Verify .htaccess exists
ls -la public/.htaccess

# 2. Check Apache rewrite module enabled
apache2ctl -M | grep rewrite

# 3. If not: enable rewrite module
a2enmod rewrite
systemctl restart apache2

# 4. Verify routes
php artisan route:list | grep status

# 5. Check DocumentRoot correct
apache2ctl -S | grep services
```

### ❌ 500 Internal Server Error

**Cause:** Laravel misconfiguration

**Fix:**
```bash
# 1. Check error logs
tail -50 storage/logs/laravel.log

# 2. Verify APP_KEY is set
grep APP_KEY .env

# 3. Clear cache
php artisan optimize:clear
php artisan config:clear

# 4. Check permissions
chmod -R 775 storage bootstrap/cache

# 5. Verify routes exist
php artisan route:list
```

### ❌ Connection Refused / Timeout

**Cause:** Service not running or wrong port

**Fix:**
```bash
# 1. Check PHP-FPM/CGI running
systemctl status php-fpm
# or
ps aux | grep php

# 2. Check firewall
sudo ufw status

# 3. Test with localhost first
curl http://localhost/EcoProvider/public/api/status
```

### ❌ Mixed Content Error

**Cause:** API URL using HTTP instead of HTTPS

**Fix:**
```bash
# 1. Edit .env
nano .env

# 2. Change to:
APP_URL=https://services.bsdgs.fun

# 3. Clear cache
php artisan config:clear
```

---

## ✅ SUCCESS CHECKLIST

Ketika semua ini passing, deployment SUKSES:

- [ ] Folder structure lengkap (12 folder utama)
- [ ] `.htaccess` ada di `public/` folder
- [ ] `.env` configured untuk production
- [ ] `routes/api.php` has `/api/status` endpoint
- [ ] Ran `composer install --no-dev`
- [ ] Ran `php artisan key:generate`
- [ ] Ran `php artisan optimize:clear`
- [ ] Ran `php artisan config:cache`
- [ ] Ran `php artisan route:cache`
- [ ] Ran `php artisan optimize`
- [ ] Permissions set correctly (775 for storage)
- [ ] Subdomain points to `public/` folder
- [ ] `curl https://services.bsdgs.fun/api/status` returns `{"status":"ok"}`
- [ ] No 404, 403, 500 errors
- [ ] No error messages in logs

---

## 📝 QUICK COPY-PASTE

```bash
# All commands in one block (copy & paste to SSH)

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
curl https://services.bsdgs.fun/api/status

# Done! Should output: {"status":"ok"}
```

---

**Last Updated:** December 13, 2025  
**Status:** ✅ Ready to Deploy
