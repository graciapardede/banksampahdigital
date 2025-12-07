# Quick Test Guide - Eco News Integration

## ✅ Pre-requisites Check

### 1. Check EcoProvider is Running
Open terminal and run:
```bash
curl http://localhost:8001/api/news
```
Or in PowerShell:
```powershell
Invoke-WebRequest -Uri http://localhost:8001/api/news
```

Expected: Status 200 with JSON response

---

## 🧪 Manual Testing Steps

### Test 1: Access News List
1. Open browser: `http://localhost:8000/eco-news`
2. ✅ Should see grid of news cards
3. ✅ Each card should have:
   - Thumbnail image
   - Title
   - Summary
   - Category badge
   - Author & date
   - "Baca Selengkapnya" button

### Test 2: View News Detail
1. Click "Baca Selengkapnya" on any news card
2. ✅ Should redirect to detail page
3. ✅ Detail page should show:
   - Large featured image
   - Full title
   - Author, date, source
   - Full content
   - Tags (if available)
   - Back button
   - Print button

### Test 3: Search Functionality
1. Click "Cari Berita" button in header
2. Type keyword: "iklim"
3. Click "Cari" button
4. ✅ Should show search results
5. ✅ Should display result count
6. Try empty search
7. ✅ Should show search suggestions

### Test 4: Navigation Menu
1. Check top navigation bar
2. ✅ Should see "🌿 Eco News" menu item
3. Click menu item
4. ✅ Should navigate to news list

### Test 5: Mobile Responsive
1. Open browser DevTools (F12)
2. Toggle device toolbar (Ctrl+Shift+M)
3. Select mobile device (e.g., iPhone 12)
4. ✅ News grid should be single column
5. ✅ Navigation should show hamburger menu
6. ✅ All content should be readable

### Test 6: Error Handling
1. Stop EcoProvider server (Ctrl+C in terminal)
2. Refresh news page
3. ✅ Should show yellow warning alert
4. ✅ Message: "Layanan EcoProvider sedang tidak tersedia"
5. ✅ No fatal errors

---

## 📊 Expected API Response Format

### GET /api/news
```json
[
    {
        "id": 1,
        "title": "Sample News Title",
        "summary": "Short summary of the news",
        "content": "Full content here...",
        "thumbnail_url": "https://example.com/image.jpg",
        "category": "Environment",
        "author": "John Doe",
        "source": "News Source",
        "source_url": "https://source.com/article",
        "published_at": "2025-12-07T10:00:00Z",
        "tags": ["climate", "environment"]
    }
]
```

---

## 🐛 Common Issues & Solutions

### Issue 1: "Connection refused"
**Cause:** EcoProvider not running
**Solution:**
```bash
cd path/to/ecoprovider
php artisan serve --port=8001
```

### Issue 2: Blank page
**Cause:** Cache not cleared
**Solution:**
```bash
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

### Issue 3: Images not loading
**Cause:** Invalid thumbnail URL
**Solution:** Check EcoProvider returns valid image URLs
- Fallback SVG placeholder will show automatically

### Issue 4: Menu not showing
**Cause:** Not logged in
**Solution:** Login first at `http://localhost:8000/login`

---

## ✅ Success Criteria

All tests passed if:
- [x] News list displays properly
- [x] Detail page shows full content
- [x] Search returns results
- [x] Menu visible in navigation
- [x] Responsive on mobile
- [x] Error handling works when provider down
- [x] No console errors
- [x] All images load (or show placeholder)

---

## 📝 Test Results Template

```
Test Date: ___________
Tester: ___________

Test 1 (News List): [ ] Pass [ ] Fail
Test 2 (Detail Page): [ ] Pass [ ] Fail
Test 3 (Search): [ ] Pass [ ] Fail
Test 4 (Navigation): [ ] Pass [ ] Fail
Test 5 (Responsive): [ ] Pass [ ] Fail
Test 6 (Error Handling): [ ] Pass [ ] Fail

Notes:
_________________________________
_________________________________
```

---

**Ready to Test!** 🚀
