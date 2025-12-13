# 🚀 SETUP GUIDE - EcoProvider Laravel di Hosting

**Domain:** `services.bsdgs.fun`  
**Project Folder:** `EcoProvider`  
**Status:** Setup & Deployment Guide

---

## 📋 STEP-BY-STEP DEPLOYMENT

### **STEP 1: Verifikasi Struktur Folder (SSH)**

```bash
# SSH ke hosting
ssh user@your-hosting.com

# Navigate ke folder project
cd public_html/EcoProvider
# atau
cd /home/username/public_html/EcoProvider

# List struktur folder
ls -la

# Output harus seperti ini:
# drwxr-xr-x  app/
# drwxr-xr-x  bootstrap/
# drwxr-xr-x  config/
# drwxr-xr-x  database/
# drwxr-xr-x  public/
# drwxr-xr-x  resources/
# drwxr-xr-x  routes/
# drwxr-xr-x  storage/
# drwxr-xr-x  tests/
# drwxr-xr-x  vendor/
# -rw-r--r--  .env
# -rw-r--r--  .env.example
# -rw-r--r--  .gitignore
# -rw-r--r--  artisan
# -rw-r--r--  composer.json
# -rw-r--r--  composer.lock
# -rw-r--r--  package.json
# -rw-r--r--  README.md
```

✅ **Jika struktur sudah lengkap, lanjut ke STEP 2**

---

### **STEP 2: Verifikasi File .htaccess**

```bash
# SSH: Check if .htaccess exists in public folder
cat public/.htaccess

# Output harus seperti ini:
```

**File: `public/.htaccess`** (Standard Laravel)
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

✅ **Jika sudah sesuai, lanjut ke STEP 3**  
❌ **Jika tidak ada/berbeda**, copy-paste konten di atas ke `public/.htaccess`

---

### **STEP 3: Periksa/Update .env**

```bash
# SSH: Check .env file
cat .env | grep -E "APP_ENV|APP_KEY|APP_URL|APP_DEBUG"

# Output saat ini:
# APP_ENV=local
# APP_KEY=base64:...
# APP_URL=http://localhost
# APP_DEBUG=true
```

**Update .env untuk Production:**
```bash
# SSH: Edit .env
nano .env

# Ubah ke:
APP_NAME="EcoProvider"
APP_ENV=production
APP_KEY=base64:your_existing_key_here
APP_DEBUG=false
APP_URL=https://services.bsdgs.fun

LOG_CHANNEL=stack
LOG_LEVEL=info

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=ecoprovider_db
DB_USERNAME=ecoprovider_user
DB_PASSWORD=your_password

# Jika ada:
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
```

**Save:** Ctrl+X → Y → Enter

---

### **STEP 4: Setup Routes - API Status Endpoint**

Verifikasi file `routes/api.php` sudah ada endpoint `/status`:

```bash
# SSH: Check routes/api.php
head -30 routes/api.php

# Should see:
# Route::get('/status', fn() => ['status' => 'ok']);
```

**Jika belum ada, tambahkan ke `routes/api.php`:**

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check endpoint - WAJIB ada untuk testing
Route::get('/status', fn() => response()->json(['status' => 'ok'], 200));

// Test endpoint dengan detail
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'app_name' => config('app.name'),
        'environment' => config('app.env'),
        'timestamp' => now()->toIso8601String(),
        'url' => config('app.url'),
    ], 200);
});

// News endpoint (example)
Route::get('/news', function () {
    return response()->json([
        'success' => true,
        'data' => [
            [
                'id' => 1,
                'title' => 'Sample News',
                'content' => 'This is a sample news item',
                'created_at' => now(),
            ]
        ]
    ], 200);
});

// Other routes...
```

---

### **STEP 5: Install Dependencies & Optimize**

```bash
# SSH: Navigate to project folder
cd public_html/EcoProvider
# or
cd /home/username/public_html/EcoProvider

# 1. Install composer dependencies
composer install --no-dev --optimize-autoloader

# Output: Should complete without errors

# 2. Generate APP_KEY if not exists
php artisan key:generate

# Output: 
# Application key set successfully.

# 3. Clear all cache
php artisan optimize:clear

# Output:
# Clearing compiled classes
# Clearing application cache
# Clearing route cache
# Clearing config cache
# Clearing bootstrap cache
# Clearing view cache

# 4. Rebuild cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Output:
# Caching the application configuration... Done
# Caching routes... Done
# Caching views... Done
# Optimizing...
```

---

### **STEP 6: Configure Subdomain in cPanel/Hosting Panel**

**In cPanel:**

1. Go to: **Addon Domains** (or **Subdomains**)
2. Create subdomain:
   - **Subdomain name:** `services`
   - **Domain:** `bsdgs.fun`
   - **Document Root:** `/home/username/public_html/EcoProvider/public`
   
3. Wait 1-5 minutes for DNS propagation

**OR via SSH (if supported):**
```bash
# Edit vhost configuration (example for cPanel)
nano /etc/apache2/conf.d/userdata/std/2_4/yourdomain.com/services.bsdgs.fun.conf

# Add:
<VirtualHost *:443>
    ServerName services.bsdgs.fun
    ServerAlias services.bsdgs.fun
    DocumentRoot /home/username/public_html/EcoProvider/public
    
    <Directory /home/username/public_html/EcoProvider/public>
        AllowOverride All
        Order allow,deny
        Allow from all
        
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteBase /
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php?/$1 [L]
        </IfModule>
    </Directory>
</VirtualHost>
```

**Then restart Apache:**
```bash
service apache2 restart
# or
systemctl restart apache2
```

---

### **STEP 7: Set File Permissions**

```bash
# SSH: Set proper permissions
cd public_html/EcoProvider

# Set directory permissions
chmod 755 bootstrap/cache storage

# Set file permissions
chmod 644 .env

# Laravel storage folder (for logs)
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Verify
ls -ld storage bootstrap/cache .env
# Output should be:
# drwxrwxr-x ... storage
# drwxrwxr-x ... bootstrap/cache
# -rw-r--r-- ... .env
```

---

### **STEP 8: Verify Database Connection (Optional)**

Jika menggunakan database:

```bash
# SSH: Test database connection
php artisan tinker

# In tinker:
> DB::connection()->getPdo()
> exit()

# Should output without error

# Or run migrations:
php artisan migrate
```

---

### **STEP 9: TEST ENDPOINTS - Via SSH**

```bash
# SSH: Test API endpoints locally (from server)

# Test 1: Status endpoint
curl https://services.bsdgs.fun/api/status

# Output:
# {"status":"ok"}

# Test 2: Health endpoint
curl https://services.bsdgs.fun/api/health

# Output:
# {"status":"ok","app_name":"EcoProvider","environment":"production","timestamp":"2025-12-13T...","url":"https://services.bsdgs.fun"}

# Test 3: News endpoint
curl https://services.bsdgs.fun/api/news

# Output: JSON array of news items

# Test with verbose (see headers):
curl -v https://services.bsdgs.fun/api/status

# Should see:
# HTTP/1.1 200 OK
# Content-Type: application/json
```

---

### **STEP 10: TEST ENDPOINTS - From Your Computer**

After SSH tests pass, test from your local machine:

```bash
# PowerShell or Command Prompt:

# Test 1: Simple GET
curl https://services.bsdgs.fun/api/status

# Test 2: With verbose output
curl -v https://services.bsdgs.fun/api/status

# Test 3: Check headers
curl -i https://services.bsdgs.fun/api/status

# Test 4: POST request (if applicable)
curl -X POST https://services.bsdgs.fun/api/news `
     -H "Content-Type: application/json" `
     -d '{"title":"Test"}'
```

---

### **STEP 11: Enable HTTPS/SSL (if not already)**

```bash
# SSH: Check if SSL is enabled
ls -la /home/username/ssl/
# Should see certificate files

# In cPanel: Auto-install Let's Encrypt
# 1. Go to: AutoSSL
# 2. Check subdomain: services.bsdgs.fun
# 3. Click: "Run AutoSSL"
# 4. Wait 5-10 minutes

# Or manual:
./autossl_check

# Then force HTTPS in .env:
# APP_URL=https://services.bsdgs.fun (with https://)
```

---

### **STEP 12: Monitor & Debug**

```bash
# SSH: Check logs if error

# Laravel logs:
tail -50 storage/logs/laravel.log

# Apache/Nginx logs:
tail -50 /var/log/apache2/access.log
tail -50 /var/log/apache2/error.log
# or
tail -50 /var/log/nginx/access.log
tail -50 /var/log/nginx/error.log

# If 404 error:
# 1. Check .htaccess in public/ folder (STEP 2)
# 2. Check DocumentRoot points to public/ folder
# 3. Run: php artisan route:list
# 4. Check routes/api.php is correct
```

---

## 🧪 TESTING CHECKLIST

### Before Going Live

- [ ] SSH to hosting
- [ ] Verify folder structure (STEP 1)
- [ ] Check .htaccess (STEP 2)
- [ ] Update .env (STEP 3)
- [ ] Add routes (STEP 4)
- [ ] Install dependencies (STEP 5)
- [ ] Configure subdomain (STEP 6)
- [ ] Set permissions (STEP 7)
- [ ] Test endpoints via SSH (STEP 9)
- [ ] Test endpoints from computer (STEP 10)
- [ ] Enable HTTPS (STEP 11)
- [ ] Check logs (STEP 12)

### Success Indicators

✅ `curl https://services.bsdgs.fun/api/status` returns `{"status":"ok"}`  
✅ `curl https://services.bsdgs.fun/api/health` returns full JSON  
✅ No 404 errors  
✅ No 500 errors (check logs)  
✅ Response time < 1 second  
✅ HTTPS working (green lock in browser)  

---

## ⚠️ TROUBLESHOOTING

### Error: 404 Not Found

**Cause:** .htaccess or routing issue

**Solutions:**
```bash
# 1. Check .htaccess exists
ls -la public/.htaccess

# 2. Check DocumentRoot correct
apache2ctl -S | grep services.bsdgs.fun

# 3. Check mod_rewrite enabled
apache2ctl -M | grep rewrite
# Output should include: rewrite_module (shared)

# 4. If not enabled:
a2enmod rewrite
systemctl restart apache2

# 5. Check routes
php artisan route:list | grep status
# Should output: GET|HEAD  api/status
```

### Error: 500 Internal Server Error

**Solutions:**
```bash
# 1. Check Laravel logs
tail -100 storage/logs/laravel.log

# 2. Check APP_KEY is set
grep APP_KEY .env

# 3. Check database connection (if using DB)
php artisan tinker
> DB::connection()->getPdo()

# 4. Clear cache
php artisan config:clear
php artisan route:clear

# 5. Check folder permissions
chmod -R 775 storage bootstrap/cache
```

### Error: Mixed Content (HTTPS page loading HTTP API)

**Solution:**
```bash
# Edit .env:
APP_URL=https://services.bsdgs.fun  # Use https://
```

### Error: CORS Error

**If Green Saving (localhost:8000) calls EcoProvider:**

Add to `routes/api.php`:
```php
Route::middleware('cors')->group(function () {
    Route::get('/status', fn() => ['status' => 'ok']);
    Route::get('/health', fn() => ['status' => 'ok']);
    // ... other routes
});
```

Or in `config/cors.php`:
```php
'allowed_origins' => [
    'http://localhost:8000',
    'http://localhost:3000',
    'https://bsdgs.fun',
],
```

---

## 📊 COMMANDS SUMMARY

Quick reference for all SSH commands:

```bash
# Setup
cd public_html/EcoProvider
composer install --no-dev --optimize-autoloader
php artisan key:generate

# Clear cache
php artisan optimize:clear

# Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Test
curl https://services.bsdgs.fun/api/status

# Monitor
tail -50 storage/logs/laravel.log

# Debug
php artisan route:list
php artisan config:show | grep APP
php artisan tinker
```

---

## 📝 FINAL CHECKLIST

```bash
# Copy-paste these commands in order:

# 1. Navigate to project
cd public_html/EcoProvider

# 2. Install
composer install --no-dev --optimize-autoloader

# 3. Setup key
php artisan key:generate

# 4. Clear
php artisan optimize:clear

# 5. Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 6. Test
curl https://services.bsdgs.fun/api/status

# Expected output: {"status":"ok"}
# Done! ✅
```

---

**Created:** December 13, 2025  
**For:** EcoProvider Laravel Deployment  
**Status:** ✅ Ready to Follow
