# 🚀 PRODUCTION DEPLOYMENT CHECKLIST - API External Integration

## ✅ Pre-Deployment Checklist

### 1. Code Changes Verification
- [x] `.env` - ECO_* variables ditambahkan
- [x] `EcoProviderService.php` - Service dengan retry mechanism
- [x] `EcoNewsController.php` - Updated untuk gunakan EcoProviderService
- [x] `ApiAccessLogger.php` - Middleware logging
- [x] `config/logging.php` - api_access channel
- [x] `app/Http/Kernel.php` - ApiAccessLogger registered
- [x] `AppServiceProvider.php` - HTTPS forcing
- [x] `config/cors.php` - CORS whitelist
- [x] `routes/api.php` - Health check endpoints
- [x] `EcoProviderStatusController.php` - Status endpoint

### 2. Environment Setup
```bash
# SSH ke hosting, lalu:

# 1. Update .env di production
nano .env

# Pastikan:
APP_ENV=production
APP_DEBUG=false
ECO_NEWS_API="https://services.bsdgs.fun/api/news"
ECO_EVENTS_API="https://services.bsdgs.fun/api/events"
ECO_TIPS_API="https://services.bsdgs.fun/api/tips"
ECO_STATUS_API="https://services.bsdgs.fun/api/status"
ECO_API_TIMEOUT=10
ECO_API_CACHE=30

# 2. Clear all cache
php artisan config:clear
php artisan optimize:clear
php artisan view:clear
php artisan route:clear
php artisan cache:clear

# 3. Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 3. Verify HTTPS & SSL
- [ ] SSL certificate valid (cek di browser)
- [ ] Redirect HTTP → HTTPS working
- [ ] Mixed content warning tidak ada di console

```bash
# Test SSL:
curl -v https://bsdgs.fun

# Should see: "Verify return code: 0 (ok)"
```

### 4. Test Health Endpoints
```bash
# Test /api/health
curl https://bsdgs.fun/api/health

# Expected response:
# {"status":"ok"}

# Test /api/eco-provider/status
curl https://bsdgs.fun/api/eco-provider/status

# Expected response:
# {
#   "status":"ok|error|unreachable",
#   "code":200,
#   "timestamp":"2025-12-13T...",
#   "app_env":"production"
# }
```

### 5. Test Eco News Page
- [ ] Visit https://bsdgs.fun/eco-news
- [ ] Verify berita tampil (tidak error)
- [ ] Open F12 → Console (tidak ada CORS error)
- [ ] Open F12 → Network (request ke EcoProvider berhasil)

### 6. Verify Logging
```bash
# Check API access logs:
tail -50 storage/logs/api-access.log

# Check error logs:
tail -50 storage/logs/laravel.log | grep -i error

# Should see entries like:
# [timestamp] api_access.INFO: API Request {"timestamp":"...","client_ip":"..."}
```

### 7. CORS Testing
```bash
# Test CORS headers:
curl -H "Origin: https://bsdgs.fun" \
     -H "Access-Control-Request-Method: GET" \
     -X OPTIONS https://services.bsdgs.fun/api/news -v

# Should see:
# Access-Control-Allow-Origin: https://bsdgs.fun
```

### 8. Monitor Performance
- [ ] Check response time: < 2 seconds
- [ ] Monitor CPU usage
- [ ] Monitor memory usage
- [ ] Check database connections

```bash
# Check processes:
ps aux | grep php

# Check memory:
free -h

# Check disk space:
df -h
```

---

## 🔍 Debugging Guide

### If Eco News Page Shows Error

**Step 1: Check Logs**
```bash
tail -100 storage/logs/laravel.log | grep -A5 "EcoProvider"
```

**Step 2: Test EcoProvider API Directly**
```bash
curl -v https://services.bsdgs.fun/api/news
curl -v https://services.bsdgs.fun/api/events
curl -v https://services.bsdgs.fun/api/tips
```

**Step 3: Check Network Connectivity**
```bash
ping services.bsdgs.fun
telnet services.bsdgs.fun 443
```

**Step 4: Test via Laravel Tinker**
```bash
php artisan tinker
> $service = app('App\Services\EcoProviderService')
> $news = $service->getNews()
> dd($news)  # Should return array
```

### If CORS Error Appears

**Check:**
1. Domain di `config/cors.php` sudah include?
2. SSL certificate valid?
3. Browser console error message lengkap?

**Fix:**
```php
// config/cors.php
'allowed_origins' => [
    'https://bsdgs.fun',           // Add your domain
    'https://www.bsdgs.fun',       // Add www variant
],
```

### If Timeout Error

**Option 1: Increase Timeout**
```bash
# Edit .env:
ECO_API_TIMEOUT=20  # 20 seconds instead of 10
```

**Option 2: Check Network**
```bash
# Test latency:
ping services.bsdgs.fun
# Should be < 100ms

# If > 1000ms: network issue with hosting
```

---

## 📊 Post-Deployment Monitoring

### Daily Checks
```bash
# Check logs for errors:
grep "ERROR" storage/logs/laravel.log

# Count API calls:
wc -l storage/logs/api-access.log

# Check disk usage:
du -sh storage/logs/
```

### Weekly Checks
```bash
# Rotate old logs:
php artisan log:rotate

# Clear old cache:
php artisan cache:prune-stale-tags
```

### Monthly Checks
- [ ] Review API access patterns
- [ ] Check performance metrics
- [ ] Verify SSL certificate expiry
- [ ] Update dependencies if needed

---

## 🎯 Success Indicators

✅ **Green Saving is working correctly when:**

1. ✅ Health endpoint returns: `{"status":"ok"}`
2. ✅ Eco News page displays without error
3. ✅ Browser console shows NO CORS/HTTPS warnings
4. ✅ API access logs show successful requests (200 status)
5. ✅ Response time < 2 seconds
6. ✅ No database query errors in logs
7. ✅ All cache cleared and rebuilt

---

## 📞 Rollback Plan (If Issues)

**If something breaks:**

```bash
# 1. Disable API temporarily
# Edit .env:
ECO_API_CACHE=0  # Disable caching
ECO_API_TIMEOUT=5  # Reduce timeout to fail faster

# 2. Clear cache
php artisan config:clear

# 3. Test
# Visit https://bsdgs.fun/eco-news
# Should now show "Layanan EcoProvider sedang tidak tersedia"

# 4. Check logs for root cause
tail -100 storage/logs/laravel.log

# 5. Fix the issue
# - Update .env
# - Clear cache again
# - Test

php artisan config:clear
```

---

## 📝 Final Checklist

- [ ] All code changes applied
- [ ] .env updated with production URLs
- [ ] Cache cleared and rebuilt
- [ ] Health endpoints tested
- [ ] Eco News page tested
- [ ] CORS verified
- [ ] HTTPS enforced
- [ ] Logs monitored
- [ ] Performance acceptable
- [ ] No errors in logs
- [ ] Team notified of deployment

---

**Deployment Status:** Ready for Production ✅
**Last Updated:** December 13, 2025
