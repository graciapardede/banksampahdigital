# ==============================================================================
# BANKSAMPAHDIGITAL - ENVIRONMENT CONFIGURATION GUIDE
# ==============================================================================
# Panduan lengkap untuk setup BankSampahDigital di LOCAL dan PRODUCTION

# ==============================================================================
# ENVIRONMENT SETUP
# ==============================================================================

# LOCAL DEVELOPMENT
# Copy ini ke .env untuk development lokal:
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
ECO_PROVIDER_BASE_URL=http://127.0.0.1:8001/api
ECO_NEWS_API=http://127.0.0.1:8001/api/news
ECO_EVENTS_API=http://127.0.0.1:8001/api/events
ECO_TIPS_API=http://127.0.0.1:8001/api/tips
ECO_STATUS_API=http://127.0.0.1:8001/api/status

# PRODUCTION (HOSTED)
# Copy ini ke .env.production untuk hosting:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bsdgs.fun
ECO_PROVIDER_BASE_URL=https://services.bsdgs.fun/api
ECO_NEWS_API=https://services.bsdgs.fun/api/news
ECO_EVENTS_API=https://services.bsdgs.fun/api/events
ECO_TIPS_API=https://services.bsdgs.fun/api/tips
ECO_STATUS_API=https://services.bsdgs.fun/api/status

# ==============================================================================
# SETUP INSTRUCTIONS
# ==============================================================================

## LOCAL DEVELOPMENT SETUP

### 1. Clone Repository
```bash
git clone https://github.com/graciapardede/banksampahdigital.git
cd banksampahdigital
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
```

Edit `.env` dengan nilai:
```
APP_NAME=BankSampahDigital
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Database (Adjust untuk mysql local Anda)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=banksampahdigital
DB_USERNAME=root
DB_PASSWORD=your_password

# EcoProvider Service (Local)
ECO_PROVIDER_BASE_URL=http://127.0.0.1:8001/api
ECO_NEWS_API=http://127.0.0.1:8001/api/news
ECO_EVENTS_API=http://127.0.0.1:8001/api/events
ECO_TIPS_API=http://127.0.0.1:8001/api/tips
ECO_STATUS_API=http://127.0.0.1:8001/api/status

ECO_API_TIMEOUT=10
ECO_API_CACHE=30
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
npm run dev
```

### 7. Start Development Server
```bash
# Terminal 1: Laravel Server (Port 8000)
php artisan serve

# Terminal 2: EcoProvider Service (Port 8001) - if local
# Jalankan service EcoProvider Anda di port 8001
```

### 8. Access Application
- BankSampahDigital: http://127.0.0.1:8000
- EcoProvider Service: http://127.0.0.1:8001/api/status

---

## PRODUCTION DEPLOYMENT

### Prerequisites
- Domain: bsdgs.fun (BankSampahDigital)
- Domain: services.bsdgs.fun (EcoProvider)
- SSL Certificate (HTTPS)
- Proper Database Setup
- Environment variables configured

### 1. Server Configuration (via hosting control panel)

#### BankSampahDigital (bsdgs.fun)
```
Domain: bsdgs.fun
Root: /public (Laravel public folder)
PHP Version: 8.1+
Environment Variables:
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://bsdgs.fun
  ECO_PROVIDER_BASE_URL=https://services.bsdgs.fun/api
```

#### EcoProvider Service (services.bsdgs.fun)
```
Domain: services.bsdgs.fun
Root: /public (service public folder)
PHP Version: 8.1+
Environment Variables:
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://services.bsdgs.fun
```

### 2. Deploy BankSampahDigital
```bash
# SSH ke server hosting
ssh user@bsdgs.fun

# Navigate to root directory
cd /home/user/public_html/bsdgs.fun

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Update environment
cp .env.production .env

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
```

### 3. Deploy EcoProvider Service
```bash
# SSH ke server hosting
ssh user@services.bsdgs.fun

# Navigate to service directory
cd /home/user/public_html/services.bsdgs.fun

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Update environment
cp .env.production .env

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force
```

---

## API INTEGRATION CHECKLIST

### Health Checks

#### Local
```bash
# Check BankSampahDigital
curl http://127.0.0.1:8000/api/health

# Check EcoProvider
curl http://127.0.0.1:8001/api/status
```

#### Production
```bash
# Check BankSampahDigital
curl https://bsdgs.fun/api/health

# Check EcoProvider
curl https://services.bsdgs.fun/api/status
```

### API Endpoints

#### News Endpoints
- Local: http://127.0.0.1:8001/api/news
- Production: https://services.bsdgs.fun/api/news

#### Events Endpoints
- Local: http://127.0.0.1:8001/api/events
- Production: https://services.bsdgs.fun/api/events

#### Tips Endpoints
- Local: http://127.0.0.1:8001/api/tips
- Production: https://services.bsdgs.fun/api/tips

---

## TROUBLESHOOTING

### Issue: API Connection Timeout
**Solution:**
1. Check if EcoProvider service is running
2. Verify firewall allows traffic on port 8001 (local) or 443 (production)
3. Check ECO_* variables di .env
4. Review logs: `tail -f storage/logs/laravel.log`

### Issue: CORS Errors
**Solution:**
Pastikan EcoProvider API memiliki CORS headers yang proper:
```php
// In EcoProvider's middleware
header('Access-Control-Allow-Origin: https://bsdgs.fun');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key');
```

### Issue: SSL Certificate Errors
**Solution:**
```bash
# Verify SSL
curl -I https://services.bsdgs.fun

# Jika error, update CA bundle:
php artisan vendor:publish --tag=configuration
```

### Issue: Database Connection Errors
**Solution:**
1. Verify database credentials di .env
2. Ensure database exists: `mysql -u root -p` then `SHOW DATABASES;`
3. Run migrations: `php artisan migrate`

---

## MAINTENANCE

### Regular Tasks
```bash
# Clear application cache
php artisan cache:clear

# Clear view cache
php artisan view:clear

# Clear routes cache (after route changes)
php artisan route:clear

# Run scheduled tasks (add to cron)
php artisan schedule:run

# Backup database
mysqldump -u user -p database_name > backup.sql
```

### Monitor Logs
```bash
# Real-time logs
tail -f storage/logs/laravel.log

# Filter for EcoProvider errors
tail -f storage/logs/laravel.log | grep EcoProvider
```

---

## SUPPORT

For more information:
- Repository: https://github.com/graciapardede/banksampahdigital
- Issues: https://github.com/graciapardede/banksampahdigital/issues
- Email: graciapardede30@gmail.com
