# ⚡ QUICK REFERENCE - API External Integration

## 🎯 TL;DR (5 Minutes)

### What Changed?
1. **Added ECO_* environment variables** to `.env` (use production URLs)
2. **Created EcoProviderService** with retry & caching logic
3. **Updated EcoNewsController** to use EcoProviderService
4. **Added API logging middleware** for monitoring
5. **Configured CORS & HTTPS** for production
6. **Added health check endpoints** for debugging

### Commands to Run (Production)
```bash
php artisan config:clear
php artisan optimize:clear
php artisan config:cache
php artisan optimize
```

### Test It
```bash
# Health check
curl https://bsdgs.fun/api/health

# Status check
curl https://bsdgs.fun/api/eco-provider/status

# Eco News page
https://bsdgs.fun/eco-news
```

---

## 🔧 Configuration

### .env (For Production)
```dotenv
APP_ENV=production
APP_DEBUG=false

ECO_NEWS_API="https://services.bsdgs.fun/api/news"
ECO_EVENTS_API="https://services.bsdgs.fun/api/events"
ECO_TIPS_API="https://services.bsdgs.fun/api/tips"
ECO_STATUS_API="https://services.bsdgs.fun/api/status"

ECO_API_TIMEOUT=10      # seconds
ECO_API_CACHE=30        # minutes (0 = disable)
```

### For Development (localhost)
```dotenv
APP_ENV=local
APP_DEBUG=true

ECO_NEWS_API="http://localhost:8001/api/news"
ECO_EVENTS_API="http://localhost:8001/api/events"
ECO_TIPS_API="http://localhost:8001/api/tips"
ECO_STATUS_API="http://localhost:8001/api/status"

ECO_API_TIMEOUT=10
ECO_API_CACHE=30
```

---

## 📁 Files to Know

| File | Purpose |
|------|---------|
| `app/Services/EcoProviderService.php` | Retry + Caching logic |
| `app/Http/Middleware/ApiAccessLogger.php` | API request logging |
| `config/cors.php` | CORS whitelist |
| `config/logging.php` | Log channels (api_access) |
| `app/Providers/AppServiceProvider.php` | HTTPS forcing |
| `routes/api.php` | Health check endpoints |
| `storage/logs/api-access.log` | API request logs |
| `storage/logs/laravel.log` | Application logs |

---

## 🚀 Deployment Steps

```bash
# 1. SSH to production
ssh user@bsdgs.fun
cd /path/to/application

# 2. Update .env for production URLs
nano .env
# Change:
# APP_ENV=production
# ECO_NEWS_API="https://services.bsdgs.fun/api/news"
# etc...

# 3. Clear & rebuild cache
php artisan config:clear
php artisan optimize:clear
php artisan config:cache
php artisan optimize

# 4. Test
curl https://bsdgs.fun/api/health
# Should return: {"status":"ok"}

# 5. Check logs
tail -20 storage/logs/api-access.log
tail -20 storage/logs/laravel.log

# Done! ✅
```

---

## 🧪 Quick Tests

### Test 1: API Health
```bash
curl https://bsdgs.fun/api/health
# Expected: {"status":"ok"}
```

### Test 2: EcoProvider Status
```bash
curl https://bsdgs.fun/api/eco-provider/status
# Expected: {"status":"ok","code":200,...}
```

### Test 3: Check Logs
```bash
tail -50 storage/logs/api-access.log | head -5
tail -50 storage/logs/laravel.log | grep -i "eco"
```

### Test 4: Browser Test
Open: `https://bsdgs.fun/eco-news`
- Should see news OR yellow warning (not error)
- F12 Console should have NO CORS errors
- F12 Network should show requests to API (200 status)

---

## 🐛 Troubleshooting

### Problem: Blank page or error
```bash
# Check logs
tail -100 storage/logs/laravel.log | grep -i error

# Clear cache
php artisan config:clear
php artisan view:clear
```

### Problem: CORS error in console
```bash
# Verify domain in config/cors.php
grep "bsdgs.fun" config/cors.php

# Should see your domain listed
```

### Problem: Timeout error
```bash
# Increase timeout in .env
ECO_API_TIMEOUT=20  # 20 seconds

# Clear cache
php artisan config:clear
```

### Problem: Empty data
```bash
# Test EcoProvider API directly
curl https://services.bsdgs.fun/api/news

# Check network connectivity
ping services.bsdgs.fun
telnet services.bsdgs.fun 443

# Check application logs
tail -50 storage/logs/laravel.log | grep "EcoProvider"
```

---

## ✅ Checklist

- [ ] .env has ECO_* variables with production URLs
- [ ] `php artisan config:clear` ran successfully
- [ ] `/api/health` returns `{"status":"ok"}`
- [ ] `/api/eco-provider/status` returns valid JSON
- [ ] `/eco-news` page displays without error
- [ ] Browser console (F12) shows NO CORS/HTTPS errors
- [ ] `storage/logs/api-access.log` has entries
- [ ] No errors in `storage/logs/laravel.log`

---

## 📞 Support

**If something is broken:**

1. Check logs: `tail -100 storage/logs/laravel.log | grep -i error`
2. Check API: `curl https://services.bsdgs.fun/api/news`
3. Clear cache: `php artisan config:clear && php artisan optimize`
4. Test: `curl https://bsdgs.fun/api/health`

**Still stuck?** Enable debug mode temporarily:
```bash
# Edit .env
APP_DEBUG=true

# Clear cache
php artisan config:clear

# Test, then disable debug again
APP_DEBUG=false
php artisan config:clear
```

---

**Last Updated:** December 13, 2025 ✅
**Status:** Ready for Production
