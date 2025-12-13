# BankSampahDigital ↔ EcoProvider Integration Checklist

**Status**: Dokumentasi lengkap setup integrasi untuk production & local

**Last Updated**: 2025-12-14

---

## 🎯 QUICK SUMMARY

### Current Setup
- **BankSampahDigital Main App**:
  - Local: `http://127.0.0.1:8000`
  - Production: `https://bsdgs.fun`
  
- **EcoProvider Service**:
  - Local: `http://127.0.0.1:8001`
  - Production: `https://services.bsdgs.fun`

### What's Been Done ✅
1. ✅ EcoProviderService dengan retry & caching mechanism
2. ✅ Multiple API endpoints support (news, events, tips, status)
3. ✅ Environment-aware configuration (.env & .env.production)
4. ✅ CORS configuration untuk cross-domain requests
5. ✅ Detailed error logging & monitoring
6. ✅ Health check endpoints
7. ✅ Integration test script

---

## 📋 PRE-DEPLOYMENT CHECKLIST

### LOCAL DEVELOPMENT

#### 1. Environment Setup
- [ ] Clone repository: `git clone https://github.com/graciapardede/banksampahdigital.git`
- [ ] Install PHP dependencies: `composer install`
- [ ] Install JS dependencies: `npm install`
- [ ] Copy .env file: `cp .env.example .env`
- [ ] Generate app key: `php artisan key:generate`

#### 2. Database Setup
- [ ] Create MySQL database: `banksampahdigital`
- [ ] Update .env with DB credentials
- [ ] Run migrations: `php artisan migrate`
- [ ] Run seeders: `php artisan db:seed`

#### 3. Build & Compile Assets
- [ ] Build CSS/JS: `npm run dev`
- [ ] Clear caches: `php artisan cache:clear && php artisan view:clear`

#### 4. Local Service Startup
```bash
# Terminal 1 - BankSampahDigital (Port 8000)
php artisan serve

# Terminal 2 - EcoProvider Service (Port 8001)
# Start your EcoProvider service here
```

#### 5. Verify Configuration
```bash
# .env harus memiliki:
APP_ENV=local
APP_URL=http://127.0.0.1:8000
ECO_PROVIDER_BASE_URL=http://127.0.0.1:8001/api
```

#### 6. Run Integration Test
```bash
php test_integration.php
```

**Expected Output**: ✓ Semua endpoint terkoneksi ✓

---

### PRODUCTION DEPLOYMENT

#### 1. Pre-Deployment Checks
- [ ] Domain bsdgs.fun sudah terdaftar dan menunjuk ke server
- [ ] Domain services.bsdgs.fun sudah terdaftar dan menunjuk ke server
- [ ] SSL Certificate sudah di-install untuk kedua domain (Let's Encrypt recommended)
- [ ] PHP 8.1+ terinstall
- [ ] MySQL 8.0+ terinstall
- [ ] Composer terinstall
- [ ] SSH access ke server tersedia

#### 2. Server Configuration

**Untuk BankSampahDigital (bsdgs.fun)**:
```
Domain: bsdgs.fun
Root Directory: /public
Document Root: /home/user/public_html/bsdgs.fun/public
SSL: Required (HTTPS)
PHP Version: 8.1+
```

**Untuk EcoProvider Service (services.bsdgs.fun)**:
```
Domain: services.bsdgs.fun
Root Directory: /public
Document Root: /home/user/public_html/services.bsdgs.fun/public
SSL: Required (HTTPS)
PHP Version: 8.1+
```

#### 3. Deploy BankSampahDigital

```bash
# SSH ke server
ssh user@bsdgs.fun

# Navigate ke app directory
cd /home/user/public_html/bsdgs.fun

# Clone atau pull repository
git clone https://github.com/graciapardede/banksampahdigital.git .
# atau
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Copy production environment
cp .env.production .env

# Update APP_KEY (jika belum ada)
php artisan key:generate

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Setup Database
php artisan migrate --force
php artisan db:seed --force

# Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap

# Clear all caches
php artisan cache:clear
```

#### 4. Deploy EcoProvider Service

Lakukan hal yang sama untuk EcoProvider:

```bash
# SSH ke server
ssh user@services.bsdgs.fun

# Navigate ke service directory
cd /home/user/public_html/services.bsdgs.fun

# Clone atau pull repository
git clone https://github.com/ecoprovider/service.git .
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Copy production environment
cp .env.production .env

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Setup Database
php artisan migrate --force

# Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap
```

#### 5. Verify Production Setup

```bash
# Check BankSampahDigital
curl https://bsdgs.fun/api/health

# Check EcoProvider Service
curl https://services.bsdgs.fun/api/status

# Check integration
curl https://bsdgs.fun/api/eco-provider/status
```

---

## 🔗 API ENDPOINTS REFERENCE

### BankSampahDigital Endpoints

| Endpoint | Method | Auth | Purpose |
|----------|--------|------|---------|
| `/api/health` | GET | No | Health check |
| `/api/eco-provider/status` | GET | No | EcoProvider status |
| `/api/register` | POST | No | User registration |
| `/api/login` | POST | No | User login |
| `/api/logout` | POST | Yes | User logout |
| `/api/me` | GET | Yes | Get current user |
| `/eco-news/articles` | GET | No | List news |
| `/eco-news/{id}` | GET | No | Get single news |

### EcoProvider Service Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/status` | GET | Service status |
| `/api/news` | GET | Get all news |
| `/api/events` | GET | Get all events |
| `/api/tips` | GET | Get all tips |
| `/api/categories` | GET | Get all categories |

---

## 🚨 TROUBLESHOOTING

### Issue: API Connection Timeout (Connection refused)

**Symptoms**: 
```
cURL error 7: Failed to connect to services.bsdgs.fun:443
```

**Solutions**:
1. Verify EcoProvider Service is running
2. Check firewall rules allow traffic to port 443
3. Verify domain DNS resolution: `nslookup services.bsdgs.fun`
4. Check server logs: `tail -f /var/log/apache2/error.log`

---

### Issue: CORS Errors

**Symptoms**:
```
Access to XMLHttpRequest at 'https://services.bsdgs.fun' from origin 'https://bsdgs.fun' 
has been blocked by CORS policy
```

**Solutions**:
1. Verify CORS configuration in [config/cors.php](config/cors.php)
2. Add allowed origins:
```php
'allowed_origins' => [
    'https://bsdgs.fun',
    'https://services.bsdgs.fun',
],
```
3. Restart web server: `sudo systemctl restart apache2`

---

### Issue: SSL Certificate Errors

**Symptoms**:
```
cURL error 60: SSL certificate problem: self signed certificate
```

**Solutions**:
1. Verify SSL certificate is valid: `ssl-verify domains.com`
2. Install Let's Encrypt certificate: `certbot certonly --apache -d bsdgs.fun`
3. Force HTTPS redirect in .htaccess:
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

### Issue: Database Connection Error

**Symptoms**:
```
SQLSTATE[HY000] [2002] Can't connect to MySQL server
```

**Solutions**:
1. Verify MySQL is running: `sudo systemctl status mysql`
2. Check database credentials in .env
3. Verify database exists: `mysql -u user -p -e "SHOW DATABASES;"`
4. Run migrations: `php artisan migrate --force`

---

### Issue: 500 Internal Server Error

**Symptoms**:
```
HTTP 500 Internal Server Error
```

**Solutions**:
1. Check application logs:
```bash
tail -f storage/logs/laravel.log
```

2. Verify APP_DEBUG=false in production (for security)

3. Clear caches:
```bash
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

4. Check file permissions:
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 755 public
```

---

## 📊 MONITORING & LOGGING

### Check API Health Status

```bash
# Local
curl http://127.0.0.1:8000/api/eco-provider/status | json_pp

# Production
curl https://bsdgs.fun/api/eco-provider/status | json_pp
```

**Expected Response**:
```json
{
  "status": "ok",
  "eco_provider_status": {
    "status": "ok",
    "code": 200,
    "timestamp": "2025-12-14T10:30:00+00:00"
  },
  "endpoints": {
    "news": {
      "status": "ok",
      "code": 200
    },
    "events": {
      "status": "ok",
      "code": 200
    },
    "tips": {
      "status": "ok",
      "code": 200
    },
    "status": {
      "status": "ok",
      "code": 200
    }
  },
  "timestamp": "2025-12-14T10:30:00+00:00"
}
```

### Monitor Real-time Logs

```bash
# Watch Laravel logs
tail -f storage/logs/laravel.log

# Filter for EcoProvider errors
tail -f storage/logs/laravel.log | grep EcoProvider

# Filter for API errors
tail -f storage/logs/laravel.log | grep -i "error\|exception"
```

---

## 🔐 SECURITY CHECKLIST

- [ ] APP_DEBUG=false di production
- [ ] APP_KEY di-generate dengan `php artisan key:generate`
- [ ] Database credentials di-secure di .env
- [ ] API credentials (ECO_API_KEY, ECO_API_SECRET) di-configure jika ada
- [ ] HTTPS enforced di production
- [ ] CORS hanya allow trusted origins
- [ ] Rate limiting di-enable untuk API endpoints
- [ ] SQL injection prevention via Eloquent ORM
- [ ] CSRF token validation enabled
- [ ] Sensitive data tidak di-log

---

## 📈 PERFORMANCE TIPS

### Enable API Caching

```env
# .env
ECO_API_CACHE=60  # Cache untuk 60 menit
```

### Use Redis untuk Caching (Production)

```env
# .env.production
CACHE_STORE=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

### Optimize Database Queries

```bash
# Check slow queries
mysql -u root -p -e "SHOW PROCESSLIST;"

# Enable query caching
# Edit /etc/mysql/mysql.conf.d/mysqld.cnf
query_cache_size=64M
query_cache_type=1
```

---

## 📞 SUPPORT & RESOURCES

- **Repository**: https://github.com/graciapardede/banksampahdigital
- **Issues**: https://github.com/graciapardede/banksampahdigital/issues
- **Email**: graciapardede30@gmail.com
- **Laravel Docs**: https://laravel.com/docs
- **CORS Documentation**: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS

---

## 🗓️ DEPLOYMENT TIMELINE

### Week 1: Preparation
- [ ] Finalize domain setup
- [ ] Setup SSL certificates
- [ ] Configure server environment
- [ ] Run local testing

### Week 2: Deployment
- [ ] Deploy BankSampahDigital
- [ ] Deploy EcoProvider Service
- [ ] Run integration tests
- [ ] Monitor logs for errors

### Week 3: Monitoring
- [ ] Check uptime
- [ ] Monitor performance
- [ ] Fix any issues
- [ ] Backup database

### Ongoing
- [ ] Weekly backups
- [ ] Monthly security updates
- [ ] Monitor error logs
- [ ] Update dependencies

---

**Document Version**: 1.0  
**Last Updated**: 2025-12-14  
**Status**: Ready for Production
