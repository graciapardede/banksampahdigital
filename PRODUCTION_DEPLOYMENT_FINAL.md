# 🚀 BANKSAMPAHDIGITAL ↔ ECOPROVIDER - FINAL DEPLOYMENT GUIDE

**Status**: ✅ READY FOR PRODUCTION DEPLOYMENT  
**Updated**: 2025-12-14  
**Target**: Production deployment to bsdgs.fun & services.bsdgs.fun

---

## 📊 SYSTEM ARCHITECTURE

```
┌─────────────────────────────────────────────────────────────────┐
│                    USER BROWSERS / CLIENTS                       │
└────────────────────┬────────────────────────────────────────────┘
                     │
          ┌──────────┴──────────┐
          │                     │
    ┌─────▼──────────┐    ┌────▼──────────────┐
    │  BankSampah    │    │  EcoProvider      │
    │  Digital       │    │  Service          │
    │  bsdgs.fun     │    │  services.bsdgs   │
    │  :8000 (local) │    │  .fun :8001 (local)
    │                │    │                   │
    │ ✓ Main App     │◄──►│ ✓ API Service    │
    │ ✓ User Auth    │    │ ✓ News/Events    │
    │ ✓ Points Mgmt  │    │ ✓ Tips/Categories│
    │ ✓ Redemptions  │    │ ✓ Cache/Optimize │
    └────────────────┘    └───────────────────┘
            │                      │
            └──────────┬───────────┘
                       │
                   ┌───▼────┐
                   │ MySQL  │
                   │Database│
                   └────────┘
```

---

## ✅ CONFIGURATION SUMMARY

### BankSampahDigital Configuration

**File**: `.env.production`

```env
APP_NAME=BankSampahDigital
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bsdgs.fun

# Database
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_DATABASE=banksampahdigital_prod
DB_USERNAME=prod_user
DB_PASSWORD=secure_password

# EcoProvider Integration (PRODUCTION)
ECO_PROVIDER_BASE_URL=https://services.bsdgs.fun/api
ECO_NEWS_API=https://services.bsdgs.fun/api/news
ECO_EVENTS_API=https://services.bsdgs.fun/api/events
ECO_TIPS_API=https://services.bsdgs.fun/api/tips
ECO_STATUS_API=https://services.bsdgs.fun/api/status

# Cache & Performance
CACHE_STORE=redis
ECO_API_CACHE=60  # Cache API responses for 60 minutes

# Session
SESSION_DOMAIN=bsdgs.fun
SESSION_DRIVER=database
```

### EcoProvider Service Configuration

**File**: `.env.production`

```env
APP_NAME=EcoProvider
APP_ENV=production
APP_DEBUG=false
APP_URL=https://services.bsdgs.fun

# Database
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_DATABASE=ecoprovider_prod
DB_USERNAME=prod_user
DB_PASSWORD=secure_password
```

---

## 🎯 STEP-BY-STEP DEPLOYMENT

### Phase 1: Pre-Deployment (LOCAL TESTING)

#### 1.1 Verify Local Setup
```bash
cd /path/to/banksampahdigital

# Check .env configuration
cat .env | grep -E "APP_ENV|ECO_"

# Expected:
# APP_ENV=local
# ECO_PROVIDER_BASE_URL=http://127.0.0.1:8001/api

# Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

#### 1.2 Start Local Servers
```bash
# Terminal 1: BankSampahDigital
php artisan serve --host=127.0.0.1 --port=8000

# Terminal 2: EcoProvider Service (if applicable)
# Start your EcoProvider service on port 8001

# Terminal 3: Test Integration
php test_integration.php
```

#### 1.3 Verify All Tests Pass
```bash
# Expected output:
# ✓ Configuration Check - PASS
# ✓ Service Integration - PASS (if port 8001 available)
# ✓ CORS Configuration - PASS
```

---

### Phase 2: Server Preparation

#### 2.1 SSH Into Server
```bash
# Connect to hosting server
ssh user@yourhostingprovider.com

# Navigate to public_html
cd /home/username/public_html
```

#### 2.2 Verify Server Requirements
```bash
# Check PHP version (must be 8.1+)
php -v

# Check MySQL
mysql --version

# Check Composer
composer --version

# Check Node (if needed)
npm --version
```

#### 2.3 Create Directory Structure
```bash
# For BankSampahDigital
mkdir -p bsdgs.fun
cd bsdgs.fun

# For EcoProvider
cd ..
mkdir -p services.bsdgs.fun
```

---

### Phase 3: Deploy BankSampahDigital

#### 3.1 Clone Repository
```bash
cd /home/username/public_html/bsdgs.fun

# Clone from GitHub
git clone https://github.com/graciapardede/banksampahdigital.git .

# or Pull if already exists
git pull origin main
```

#### 3.2 Install Dependencies
```bash
# PHP dependencies
composer install --no-dev --optimize-autoloader

# Node dependencies (if needed)
npm install
npm run build
```

#### 3.3 Configure Environment
```bash
# Copy production environment file
cp .env.production .env

# OR manually edit .env with production values:
# APP_ENV=production
# APP_DEBUG=false
# APP_URL=https://bsdgs.fun
# ECO_PROVIDER_BASE_URL=https://services.bsdgs.fun/api
# DB_* = your production database credentials
```

#### 3.4 Generate Application Key
```bash
php artisan key:generate
```

#### 3.5 Setup Database
```bash
# Run migrations
php artisan migrate --force

# Run seeders (optional)
php artisan db:seed --force
```

#### 3.6 Optimize Laravel
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Clear old caches
php artisan cache:clear
```

#### 3.7 Set Proper Permissions
```bash
# Set directory permissions
chmod -R 755 storage bootstrap/cache
chmod -R 755 public

# Set ownership (replace www-data with your web server user)
chown -R www-data:www-data storage bootstrap
chown -R www-data:www-data storage/logs
```

#### 3.8 Verify Installation
```bash
# Test Laravel is working
curl https://bsdgs.fun/api/health

# Expected response:
# {"status":"ok"}
```

---

### Phase 4: Deploy EcoProvider Service

#### 4.1 Clone Repository
```bash
cd /home/username/public_html/services.bsdgs.fun

git clone <ecoprovider-repo-url> .
# or
git pull origin main
```

#### 4.2 Follow Same Steps as Phase 3
```bash
# Install
composer install --no-dev --optimize-autoloader

# Configure
cp .env.production .env

# Generate key
php artisan key:generate

# Database
php artisan migrate --force

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap
```

#### 4.3 Verify Service
```bash
curl https://services.bsdgs.fun/api/status

# Expected response:
# {"status":"ok","timestamp":"..."}
```

---

### Phase 5: Web Server Configuration

#### 5.1 For Apache (.htaccess)

**File**: `/home/username/public_html/bsdgs.fun/public/.htaccess`

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes If Not A Folder
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]

    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

#### 5.2 For Nginx

**File**: `/etc/nginx/sites-available/bsdgs.fun`

```nginx
server {
    listen 443 ssl http2;
    server_name bsdgs.fun www.bsdgs.fun;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/bsdgs.fun/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/bsdgs.fun/privkey.pem;

    # Performance
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Root Directory
    root /home/username/public_html/bsdgs.fun/public;
    index index.php;

    # Logging
    access_log /var/log/nginx/bsdgs.fun.access.log;
    error_log /var/log/nginx/bsdgs.fun.error.log;

    # PHP Handler
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Static Files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js)$ {
        expires 365d;
        add_header Cache-Control "public, immutable";
    }

    # Security
    location ~ /\.ht {
        deny all;
    }

    # Force HTTPS
    if ($scheme != "https") {
        return 301 https://$server_name$request_uri;
    }
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name bsdgs.fun www.bsdgs.fun;
    return 301 https://$server_name$request_uri;
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/bsdgs.fun /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

### Phase 6: SSL Certificate Setup

#### 6.1 Using Let's Encrypt (Free)

```bash
# Install certbot
sudo apt-get install certbot python3-certbot-apache python3-certbot-nginx

# Generate certificate
sudo certbot certonly --standalone -d bsdgs.fun -d www.bsdgs.fun
sudo certbot certonly --standalone -d services.bsdgs.fun

# Auto-renew
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer

# Check renewal
sudo certbot renew --dry-run
```

---

### Phase 7: Verification & Testing

#### 7.1 Health Checks

```bash
# BankSampahDigital
curl https://bsdgs.fun/api/health
# Expected: {"status":"ok"}

# EcoProvider
curl https://services.bsdgs.fun/api/status
# Expected: {"status":"ok"}

# Integration Check
curl https://bsdgs.fun/api/eco-provider/status
# Expected: Detailed status with endpoint information
```

#### 7.2 API Endpoint Tests

```bash
# News API
curl https://services.bsdgs.fun/api/news
# Expected: JSON array with news items

# Events API
curl https://services.bsdgs.fun/api/events
# Expected: JSON array with events

# Full Status with All Endpoints
curl https://bsdgs.fun/api/eco-provider/status | json_pp
```

#### 7.3 Frontend Testing

```bash
# Open in browser
https://bsdgs.fun/login
https://bsdgs.fun/eco-news/articles

# Verify:
- ✓ Page loads without errors
- ✓ News from EcoProvider displays
- ✓ No CORS errors in browser console
- ✓ API requests complete in <2 seconds
```

---

## 🔍 MONITORING & MAINTENANCE

### Daily Checks
```bash
# Check error logs
tail -f storage/logs/laravel.log

# Monitor disk space
df -h

# Check database status
mysqladmin ping
```

### Weekly Maintenance
```bash
# Backup database
mysqldump -u user -p database > backup_$(date +%Y%m%d).sql

# Clear old cache
php artisan cache:clear

# Update dependencies (with testing)
composer update
```

### Monthly Tasks
```bash
# SSL certificate renewal
sudo certbot renew

# Database optimization
mysql -u user -p database -e "OPTIMIZE TABLE \G"

# Log rotation check
ls -la storage/logs/
```

---

## 🚨 EMERGENCY PROCEDURES

### If EcoProvider is Down
```bash
# 1. Check service status
curl https://services.bsdgs.fun/api/status

# 2. Check logs
ssh user@services.bsdgs.fun
tail -f storage/logs/laravel.log

# 3. Restart service
php artisan cache:clear
php artisan migrate --force

# 4. Update BankSampahDigital to fallback
# Edit config/services.php or adjust EcoProviderService
```

### If Database is Corrupt
```bash
# 1. Backup current database
mysqldump -u user -p database > backup_corrupt.sql

# 2. Restore from backup
mysql -u user -p database < backup_latest.sql

# 3. Run migrations
php artisan migrate --force

# 4. Clear caches
php artisan cache:clear
```

### If SSL Certificate Expires
```bash
# 1. Renew immediately
sudo certbot renew --force-renewal

# 2. Restart web server
sudo systemctl restart nginx
# or
sudo systemctl restart apache2

# 3. Verify
curl https://bsdgs.fun
```

---

## 📞 CONTACT & SUPPORT

**Primary Contact**: graciapardede30@gmail.com

**Repository**: https://github.com/graciapardede/banksampahdigital

**For Issues**:
1. Check application logs: `storage/logs/laravel.log`
2. Check server logs: `/var/log/apache2/error.log` or `/var/log/nginx/error.log`
3. Verify configuration: `.env` file settings
4. Test endpoints: Use curl commands above
5. Contact support with logs

---

## ✨ DEPLOYMENT CHECKLIST - FINAL

- [ ] Local testing completed and all tests pass
- [ ] Domain DNS records configured
- [ ] SSL certificates installed for both domains
- [ ] Server PHP & MySQL versions verified (8.1+)
- [ ] BankSampahDigital deployed and health check passes
- [ ] EcoProvider Service deployed and status check passes
- [ ] CORS configuration verified
- [ ] Database migrations completed
- [ ] Permissions set correctly (755/644)
- [ ] Caches cleared and optimized
- [ ] Monitoring and logging configured
- [ ] Backup system in place
- [ ] Email notifications configured (optional)
- [ ] All endpoints tested and working
- [ ] Frontend tested in browser
- [ ] Documentation reviewed and team trained

---

**Deployment Status**: 🟢 READY FOR PRODUCTION

**Deployed By**: Your Team  
**Deployment Date**: YYYY-MM-DD  
**Verified By**: Name, Email  

---

*For questions or issues during deployment, please refer to the comprehensive guide above or contact support.*
