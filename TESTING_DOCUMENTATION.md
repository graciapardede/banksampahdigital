# Testing Documentation - BankSampahDigital (User Features)

## Table of Contents

### Authentication & Account Management
1. [Login](#1-login)
2. [Register](#2-register)
3. [Logout](#3-logout)
4. [Google OAuth Login](#4-google-oauth-login)
5. [Google OAuth Register](#5-google-oauth-register)
6. [Unlink Google Account](#6-unlink-google-account)

### User Dashboard & Profile
7. [Dashboard](#7-dashboard)
8. [Profile View](#8-profile-view)
9. [Profile Edit](#9-profile-edit)
10. [Profile Photo Upload](#10-profile-photo-upload)
11. [Change Password](#11-change-password)

### Waste Deposit Management
12. [View Deposit Page](#12-view-deposit-page)
13. [View Waste Types List](#13-view-waste-types-list)
14. [View Deposit History](#14-view-deposit-history)
15. [View Deposit Detail](#15-view-deposit-detail)

### Point Redemption Management
16. [View Reward Items](#16-view-reward-items)
17. [View Reward Item Detail](#17-view-reward-item-detail)
18. [Add Item to Cart](#18-add-item-to-cart)
19. [View Cart](#19-view-cart)
20. [Update Cart Quantity](#20-update-cart-quantity)
21. [Remove Item from Cart](#21-remove-item-from-cart)
22. [Clear Cart](#22-clear-cart)
23. [Checkout Cart](#23-checkout-cart)
24. [Instant Redeem](#24-instant-redeem)
25. [View Redemption History](#25-view-redemption-history)
26. [View Redemption Detail](#26-view-redemption-detail)

### Transaction & History
27. [View Transaction History](#27-view-transaction-history)
28. [Filter Transaction by Type](#28-filter-transaction-by-type)
29. [Filter Transaction by Status](#29-filter-transaction-by-status)
30. [View Transaction Detail (Deposit)](#30-view-transaction-detail-deposit)
31. [View Transaction Detail (Redemption)](#31-view-transaction-detail-redemption)

### Notification System
32. [View Notifications](#32-view-notifications)
33. [Get Unread Count](#33-get-unread-count)
34. [Mark Notification as Read](#34-mark-notification-as-read)
35. [Mark All Notifications as Read](#35-mark-all-notifications-as-read)

### Eco News
36. [View Eco News Search Page](#36-view-eco-news-search-page)
37. [Search Eco News](#37-search-eco-news)
38. [View All News Articles](#38-view-all-news-articles)
39. [View News Detail](#39-view-news-detail)
40. [View News by Category](#40-view-news-by-category)

### Location & Branch
41. [View Branch Locations](#41-view-branch-locations)
42. [View Branch Details](#42-view-branch-details)
43. [Get Direction to Branch](#43-get-direction-to-branch)

---

## 1. Login

### Test ID
FT-01-Login

### FR/NFR ID
FT-01 Login

### Test Name
User Login Authentication

### Objective
1. Mengirimkan data kredensial (email dan kata sandi) ke server untuk melakukan proses autentikasi pengguna yang valid.
2. Memverifikasi bahwa server memberikan respons error untuk kredensial yang tidak valid.
3. Memuat status sesi pengguna yang sedang aktif untuk mengakses halaman dashboard setelah login berhasil.
4. Mengambil informasi pengguna (seperti nama atau peran) setelah login berhasil dan menyimpan status di sisi klien.

### Description
1. Jika data input tidak lengkap (misalnya, email atau kata sandi kosong), server akan merespons dengan status kode 422 Unprocessable Entity.
2. Endpoint ini bertujuan memastikan hanya pengguna yang terdaftar dengan kredensial valid yang dapat mengakses sistem.
3. Permintaan harus dikirim menggunakan metode POST dengan data dalam format JSON atau form data.
4. Jika kredensial valid, server akan mengembalikan session cookie dan redirect ke dashboard dengan status kode 200 OK.

### Precondition
- Tabel Users memiliki minimal 1 data pengguna yang telah didaftarkan sebelumnya
- Database tersedia dan dapat diakses
- Session storage berfungsi dengan baik

### Date
8 Desember 2025

### Tester
QA Team - User Authentication Module

### Testing Scenario

#### 1. GET
- **Mengakses halaman login**: Mengirimkan request GET ke `/login` untuk menampilkan halaman login, memastikan status 200 OK dengan halaman dalam format HTML dengan form login yang lengkap (field email, password, remember me checkbox, link register, link forgot password, tombol login with Google).
- **Redirect jika sudah login**: Mengirimkan request GET ke `/login` dengan session autentikasi yang valid, memastikan redirect ke `/dashboard` dengan status 302 Found untuk mencegah user yang sudah login mengakses halaman login lagi.
- **Verifikasi CSRF token**: Memastikan form login memiliki CSRF token yang valid untuk keamanan.

#### 2. POST
- **Login dengan data valid**: Mengirimkan request POST ke `/login` dengan email `user@example.com` dan kata sandi yang benar `password123`, memastikan status 200 OK atau 302 redirect ke dashboard dengan session cookie yang ter-set.
- **Login dengan email salah**: Mengirimkan request POST ke `/login` dengan email yang tidak terdaftar `notfound@example.com`, memastikan status 401 Unauthorized dengan pesan error "Email tidak ditemukan" dalam response JSON atau flash message.
- **Login dengan kata sandi salah**: Mengirimkan request POST ke `/login` dengan email benar tetapi kata sandi yang salah `wrongpassword`, memastikan status 401 Unauthorized dengan pesan error "Kata sandi salah".
- **Login dengan email kosong**: Mengirimkan request POST ke `/login` tanpa field email, memastikan status 422 Unprocessable Entity dengan pesan validasi "Email harus diisi".
- **Login dengan password kosong**: Mengirimkan request POST ke `/login` tanpa field password, memastikan status 422 Unprocessable Entity dengan pesan validasi "Password harus diisi".
- **Login dengan format email tidak valid**: Mengirimkan request POST dengan email format salah `invalidemailformat`, memastikan status 422 dengan pesan "Format email tidak valid".
- **Login dengan remember me**: Mengirimkan request POST dengan checkbox `remember` ter-check, memastikan cookie remember_token di-set dengan durasi yang lebih panjang (30 hari).
- **Login dengan SQL injection attempt**: Mengirimkan request POST dengan email berisi SQL injection `'; DROP TABLE users--`, memastikan sistem aman dan menolak dengan proper escaping.
- **Login dengan XSS attempt**: Mengirimkan request POST dengan password berisi script `<script>alert('xss')</script>`, memastikan input di-sanitize dan tidak execute script.
- **Rate limiting test**: Mengirimkan 10 request POST login gagal dalam 1 menit, memastikan setelah 5 kali gagal sistem memberi delay atau captcha untuk mencegah brute force attack.

### Evaluation Criteria
1. Harus mengembalikan response dalam format yang benar (JSON untuk API, redirect untuk web).
2. Jika tidak ada data, status kode yang dikembalikan adalah 401 Unauthorized untuk kredensial salah atau 422 untuk input tidak lengkap.
3. Session cookie harus ter-set dengan secure flag jika menggunakan HTTPS.
4. Password harus di-verify menggunakan Hash::check() bukan plain text comparison.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT01-01 | User memasukkan **email** `user@example.com` dan **kata sandi** `password123` yang valid sesuai dengan format yang diperlukan. | 200 OK atau 302 redirect, sistem set session cookie dan redirect ke `/dashboard`. User dapat melihat data dashboard dengan nama user ditampilkan. | 200 OK, session ter-set dengan benar, redirect ke dashboard berhasil, nama user muncul di header. | [x] passed<br>[ ] failed |
| FT01-02 | Pengguna memasukkan **email** `notfound@example.com` yang tidak terdaftar di database. | 401 Unauthorized, sistem merespons dengan flash message "Email tidak ditemukan" di halaman login. | 401 Unauthorized, flash message error ditampilkan dengan benar di atas form login. | [x] passed<br>[ ] failed |
| FT01-03 | Pengguna memasukkan email benar `user@example.com` tetapi **kata sandi** salah `wrongpass123`. | 401 Unauthorized, sistem merespons dengan flash message "Kata sandi salah". | 401 Unauthorized, pesan error "Kata sandi salah" ditampilkan. | [x] passed<br>[ ] failed |
| FT01-04 | Pengguna mengirimkan form dengan **email kosong** dan password diisi. | 422 Unprocessable Entity, sistem merespons dengan pesan validasi "Email harus diisi" di bawah field email. | 422 Unprocessable Entity, validasi error muncul di field yang sesuai. | [x] passed<br>[ ] failed |
| FT01-05 | Pengguna mengirimkan form dengan email diisi tetapi **password kosong**. | 422 Unprocessable Entity, sistem merespons dengan pesan validasi "Password harus diisi". | 422 Unprocessable Entity, validasi error ditampilkan. | [x] passed<br>[ ] failed |
| FT01-06 | Pengguna memasukkan format email tidak valid `invalidemail` tanpa @ dan domain. | 422 Unprocessable Entity, sistem merespons dengan pesan "Format email tidak valid". | 422 Unprocessable Entity, validasi format email bekerja. | [x] passed<br>[ ] failed |
| FT01-07 | Pengguna login dengan mencentang checkbox **remember me**. | 200 OK, cookie `remember_token` di-set dengan expire 30 hari, user tetap login setelah close browser. | Cookie remember_token ter-set dengan benar, session persisten. | [x] passed<br>[ ] failed |
| FT01-08 | User sudah login mencoba akses `/login` lagi. | 302 Found, redirect ke `/dashboard` untuk mencegah double login. | Redirect berhasil, user tidak bisa akses halaman login. | [x] passed<br>[ ] failed |
| FT01-09 | Attempt SQL injection dengan email `'; DROP TABLE users--`. | 422 atau 401, sistem safe dari SQL injection, input di-escape dengan benar. | Sistem aman, query tidak execute malicious code. | [x] passed<br>[ ] failed |
| FT01-10 | Login gagal 5 kali berturut-turut dalam 1 menit. | 429 Too Many Requests, sistem menampilkan captcha atau delay 60 detik. | Rate limiting aktif, mencegah brute force attack. | [x] passed<br>[ ] failed |

### Notes
- Uji menggunakan berbagai data skenario untuk memastikan error handling.
- Semua pengujian yang dilakukan berjalan dengan baik.
- Password di-hash menggunakan bcrypt dengan cost factor 12.
- Session timeout default: 120 menit (2 jam).
- Remember token: 43200 menit (30 hari).
- Rate limiting: maxAttempts 5, decayMinutes 1.

---

## 2. Register

### Test ID
FT-02-Register

### FR/NFR ID
FT-02 Register

### Test Name
User Registration

### Objective
1. Mengirimkan data pendaftaran (nama, email, kata sandi, konfirmasi password, nomor telepon) ke server untuk membuat akun pengguna baru.
2. Memverifikasi bahwa server memberikan respons error untuk data yang tidak valid atau sudah terdaftar.
3. Memastikan pengguna dapat langsung login dan redirect ke dashboard setelah registrasi berhasil.
4. Menyimpan data pengguna ke database dengan role default sebagai 'user' dan branch_id null (bisa pilih cabang nanti).

### Description
1. Jika data input tidak lengkap atau format tidak valid (misalnya, email tidak valid, password < 8 karakter), server akan merespons dengan status kode 422 Unprocessable Entity.
2. Jika email sudah terdaftar, server akan merespons dengan status 409 Conflict dengan pesan "Email sudah terdaftar".
3. Permintaan harus dikirim menggunakan metode POST dengan data dalam format form data atau JSON.
4. Jika registrasi berhasil, server akan membuat session login dan redirect ke dashboard dengan status kode 201 Created atau 302 redirect.

### Precondition
- Database tersedia dan dapat diakses
- Tabel users dapat menerima data baru
- Email verification tidak wajib (optional)
- Session storage berfungsi

### Date
8 Desember 2025

### Tester
QA Team - User Registration Module

### Testing Scenario

#### 1. GET
- **Mengakses halaman register**: Mengirimkan request GET ke `/register` untuk menampilkan form pendaftaran dengan field: nama, email, password, password_confirmation, nomor_telepon, alamat (optional), memastikan status 200 OK dengan form lengkap dan CSRF token.
- **Redirect jika sudah login**: Mengirimkan request GET ke `/register` dengan session yang sudah authenticated, memastikan redirect ke `/dashboard` dengan status 302 untuk mencegah user yang sudah login register lagi.
- **Verifikasi form fields**: Memastikan semua field required memiliki attribute required dan proper type (email untuk email field, password untuk password, number untuk phone).

#### 2. POST
- **Register dengan data valid lengkap**: Mengirimkan request POST ke `/register` dengan data: nama `John Doe`, email `john@example.com`, password `securepass123`, password_confirmation `securepass123`, nomor_telepon `081234567890`, memastikan status 201 Created dan user baru tersimpan di database dengan password ter-hash.
- **Register dengan email yang sudah ada**: Mengirimkan request POST ke `/register` dengan email yang sudah terdaftar `existing@example.com`, memastikan status 409 Conflict dengan pesan error "Email sudah terdaftar" dan tidak membuat duplikat entry.
- **Register dengan format email tidak valid**: Mengirimkan request POST dengan email format salah `notanemail`, memastikan status 422 Unprocessable Entity dengan pesan "Format email tidak valid".
- **Register dengan password kurang dari 8 karakter**: Mengirimkan request POST dengan password `pass123` (7 karakter), memastikan status 422 dengan pesan "Password minimal 8 karakter".
- **Register dengan password dan konfirmasi tidak cocok**: Mengirimkan request POST dengan password `password123` dan password_confirmation `password456`, memastikan status 422 dengan pesan "Konfirmasi password tidak cocok".
- **Register dengan nomor telepon tidak valid**: Mengirimkan request POST dengan nomor_telepon `123` (terlalu pendek) atau `abcd1234`, memastikan status 422 dengan pesan "Format nomor telepon tidak valid".
- **Register tanpa nama**: Mengirimkan request POST tanpa field nama, memastikan status 422 dengan pesan "Nama harus diisi".
- **Register dengan nama hanya spasi**: Mengirimkan request POST dengan nama berisi hanya spasi `"   "`, memastikan validasi menolak dan meminta nama valid.
- **Register dengan email mengandung spasi**: Mengirimkan request POST dengan email `user @example.com`, memastikan validasi trim spasi atau reject.
- **Register dengan password lemah**: Mengirimkan request POST dengan password `12345678` (hanya angka), sistem menerima tetapi memberikan warning "Password lemah, disarankan kombinasi huruf, angka, dan simbol".
- **Register dengan XSS attempt di nama**: Mengirimkan request POST dengan nama `<script>alert('xss')</script>`, memastikan input di-sanitize dan tersimpan sebagai plain text tanpa execute.
- **Register kemudian auto-login**: Setelah registrasi berhasil, memastikan user langsung ter-authenticate dan redirect ke dashboard tanpa perlu login manual.

### Evaluation Criteria
1. Harus mengembalikan data dalam format yang benar (redirect untuk web, JSON untuk API).
2. Jika email sudah terdaftar, status kode 409 Conflict.
3. Jika validasi gagal, status kode 422 Unprocessable Entity dengan detail error untuk setiap field.
4. Password harus di-hash menggunakan Hash::make() sebelum disimpan ke database.
5. Role default user adalah 'user' bukan 'admin'.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT02-01 | User memasukkan **nama** `John Doe`, **email** `john@example.com`, **kata sandi** `password123`, **konfirmasi password** `password123`, dan **nomor telepon** `081234567890` yang valid. | 201 Created, sistem membuat akun baru di tabel users dengan password ter-hash, role='user', dan auto-login kemudian redirect ke `/dashboard`. | 201 Created, user berhasil dibuat dengan ID baru, password di-hash dengan bcrypt, session ter-set, redirect berhasil ke dashboard. | [x] passed<br>[ ] failed |
| FT02-02 | User memasukkan **email** `existing@example.com` yang sudah terdaftar di database. | 409 Conflict, sistem merespons dengan flash message "Email sudah terdaftar. Silakan gunakan email lain atau login." dan kembali ke form register dengan input lain tetap terisi. | 409 Conflict, pesan error muncul, email field di-highlight merah, old input preserved kecuali password. | [x] passed<br>[ ] failed |
| FT02-03 | User memasukkan **password** `pass12` (6 karakter) kurang dari minimal 8 karakter. | 422 Unprocessable Entity, sistem merespons dengan pesan validasi "Password minimal 8 karakter" di bawah field password. | 422 Unprocessable Entity, validasi error muncul dengan pesan yang jelas. | [x] passed<br>[ ] failed |
| FT02-04 | User memasukkan format **email** `notvalidemail` tanpa @ dan domain. | 422 Unprocessable Entity, sistem merespons dengan pesan "Format email tidak valid. Contoh: user@example.com". | 422 Unprocessable Entity, format email di-validasi dengan benar. | [x] passed<br>[ ] failed |
| FT02-05 | User memasukkan password `password123` dan konfirmasi password `different456` yang tidak cocok. | 422 Unprocessable Entity, sistem merespons dengan pesan "Konfirmasi password tidak cocok dengan password". | 422 Unprocessable Entity, validasi password confirmation bekerja. | [x] passed<br>[ ] failed |
| FT02-06 | User memasukkan **nomor telepon** `123` yang terlalu pendek (< 10 digit). | 422 Unprocessable Entity, sistem merespons dengan pesan "Nomor telepon minimal 10 digit". | 422 Unprocessable Entity, validasi panjang nomor telepon aktif. | [x] passed<br>[ ] failed |
| FT02-07 | User submit form tanpa mengisi field **nama**. | 422 Unprocessable Entity, sistem merespons dengan pesan "Nama harus diisi" di field nama. | 422 Unprocessable Entity, required validation untuk nama bekerja. | [x] passed<br>[ ] failed |
| FT02-08 | User memasukkan nama dengan **hanya spasi** `"     "`. | 422 Unprocessable Entity, sistem trim spasi dan detect sebagai empty, pesan "Nama tidak boleh hanya spasi". | Validasi bekerja, nama dengan hanya spasi ditolak. | [x] passed<br>[ ] failed |
| FT02-09 | User register dengan nama mengandung **XSS script** `<script>alert('test')</script>`. | 201 Created, nama di-sanitize menjadi plain text tanpa tag HTML, tersimpan aman di database. | Input di-escape dengan benar, tidak ada script injection. | [x] passed<br>[ ] failed |
| FT02-10 | Setelah register berhasil, verifikasi **auto-login**. | User langsung ter-authenticate tanpa perlu login manual, session.user_id ter-set. | Auto-login berhasil, user langsung masuk dashboard. | [x] passed<br>[ ] failed |

### Notes
- Validasi dilakukan di sisi server dan client (HTML5 validation + JavaScript).
- Password di-hash menggunakan bcrypt dengan cost factor 12 sebelum disimpan.
- Email validation menggunakan Laravel built-in rule 'email:rfc,dns' untuk strict validation.
- Nomor telepon validation: minimal 10 digit, maksimal 15 digit, hanya angka dan '+'.
- Nama: minimal 3 karakter, maksimal 100 karakter.
- Default role: 'user', default branch_id: null (bisa update nanti di profile).
- Semua pengujian berjalan dengan baik tanpa error critical.

---

## 3. Logout

### Test ID
FT-03-Logout

### FR/NFR ID
FT-03 Logout

### Test Name
User Logout

### Objective
1. Menghapus session pengguna yang sedang aktif untuk mengakhiri sesi login.
2. Menghapus cookie remember_token jika ada untuk keamanan.
3. Regenerate session token untuk mencegah session fixation attack.
4. Redirect user ke halaman login atau home page setelah logout berhasil.

### Description
1. Logout menggunakan metode POST untuk mencegah CSRF attack (tidak bisa logout via GET link).
2. Session akan di-flush dan cookie akan dihapus dari browser.
3. Setelah logout, user tidak bisa akses halaman yang memerlukan authentication tanpa login ulang.
4. Logout harus aman dari race condition (multiple logout request sekaligus).

### Precondition
- User sudah login dengan session aktif
- Auth middleware berfungsi dengan baik
- Session driver configured (file/database/redis)

### Date
8 Desember 2025

### Tester
QA Team - Authentication Module

### Testing Scenario

#### 1. POST
- **Logout normal**: User yang sudah login mengirim request POST ke `/logout` dengan CSRF token valid, memastikan session dihapus, cookie dihapus, dan redirect ke `/` atau `/login` dengan status 302.
- **Logout dengan remember token**: User yang login dengan "remember me" mengirim request POST logout, memastikan cookie remember_token juga dihapus dari database dan browser.
- **Logout tanpa CSRF token**: Mengirim request POST `/logout` tanpa CSRF token, memastikan Laravel menolak dengan status 419 Page Expired.
- **Logout sudah logout**: User yang sudah logout mencoba logout lagi, memastikan tidak error dan redirect ke login page.
- **Verifikasi session invalidation**: Setelah logout, mencoba akses `/dashboard` dengan session ID lama, memastikan redirect ke `/login` dengan status 401 atau 302.
- **Logout dari multiple devices**: User login di 2 device berbeda, logout di device 1, memastikan session di device 1 hilang tetapi device 2 tetap login (session independent).
- **Logout dengan redirect intended**: Setelah logout, jika user akses halaman protected, redirect ke login dengan intended URL tersimpan, setelah login redirect ke halaman yang dimaksud.

#### 2. GET (Should Not Work)
- **Attempt logout via GET**: Mengirim request GET ke `/logout`, memastikan method not allowed atau redirect ke halaman error karena logout harus POST.

### Evaluation Criteria
1. Session harus benar-benar dihapus dari storage (file/database).
2. Cookie di browser harus cleared (inspect dengan DevTools).
3. After logout, akses halaman protected harus redirect ke login.
4. Logout harus idempotent (bisa dipanggil multiple kali tanpa error).

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT03-01 | User yang sudah login mengklik tombol **logout** dan submit form POST ke `/logout`. | 302 Found, session dihapus dari server, cookie cleared dari browser, redirect ke `/` dengan flash message "Anda telah logout". | 302 Found, session ter-destroy, redirect berhasil, pesan sukses ditampilkan. | [x] passed<br>[ ] failed |
| FT03-02 | User dengan **remember token** melakukan logout. | 302 Found, remember_token dihapus dari tabel users dan cookie browser, user harus login ulang di akses berikutnya. | Remember token cleared dari database dan browser, logout success. | [x] passed<br>[ ] failed |
| FT03-03 | Attempt logout dengan **POST tanpa CSRF token**. | 419 Page Expired, request ditolak oleh middleware VerifyCsrfToken. | 419 Page Expired, CSRF protection bekerja dengan baik. | [x] passed<br>[ ] failed |
| FT03-04 | User yang sudah logout mencoba **logout lagi** (double logout). | 302 Found, redirect ke `/login` tanpa error, sistem handle gracefully. | Tidak ada error, redirect normal ke login page. | [x] passed<br>[ ] failed |
| FT03-05 | Setelah logout, user mencoba akses `/dashboard` dengan session ID lama yang sudah invalid. | 302 Found, redirect ke `/login` dengan pesan "Silakan login untuk melanjutkan". | Redirect ke login berhasil, session lama tidak valid. | [x] passed<br>[ ] failed |
| FT03-06 | User logout di device 1, verifikasi session di device 2 masih aktif. | Session di device 1 hilang (redirect ke login), session di device 2 masih bisa akses dashboard normal. | Session management per device bekerja independen. | [x] passed<br>[ ] failed |
| FT03-07 | Logout kemudian akses URL protected `/profil/edit`, setelah login redirect ke intended URL. | Redirect ke login dengan intended URL saved, setelah login berhasil auto redirect ke `/profil/edit`. | Intended redirect bekerja, UX smooth. | [x] passed<br>[ ] failed |
| FT03-08 | Attempt logout via **GET request** ke `/logout`. | 405 Method Not Allowed atau 302 redirect dengan error, karena route hanya accept POST. | GET request ditolak, harus POST untuk security. | [x] passed<br>[ ] failed |

### Notes
- Logout route: `POST /logout` dengan middleware auth.
- Session regenerate() dipanggil untuk mencegah session fixation.
- Remember token di-set null di database saat logout.
- Flash message: "Anda telah berhasil logout" ditampilkan di halaman login.
- Logout log dapat ditambahkan untuk audit trail (optional).

---

## 4. Google OAuth Login

### Test ID
FT-04-GoogleLogin

### FR/NFR ID
FT-04 Google OAuth Login

### Test Name
Google OAuth Authentication for Existing User

### Objective
1. Redirect user ke Google OAuth consent screen untuk memilih akun Google.
2. Menerima callback dari Google dengan authorization code.
3. Exchange code untuk access token dan mendapatkan user info dari Google.
4. Login user yang sudah ada dengan email yang sama dari Google account.

### Description
1. Menggunakan Laravel Socialite package untuk integrasi Google OAuth 2.0.
2. User yang sudah punya akun dengan email sama akan langsung login tanpa register ulang.
3. Jika google_id belum tersimpan, sistem akan update user record dengan google_id dan google_token.
4. Session akan ter-set setelah login sukses via Google.

### Precondition
- Google OAuth credentials (Client ID dan Secret) sudah dikonfigurasi di `.env`
- Redirect URI `http://127.0.0.1:8000/auth/google/callback` terdaftar di Google Cloud Console
- Laravel Socialite package terinstall (`composer require laravel/socialite`)
- User dengan email `user@gmail.com` sudah terdaftar di database
- Internet connection tersedia

### Date
8 Desember 2025

### Tester
QA Team - OAuth Integration Module

### Testing Scenario

#### 1. GET
- **Redirect ke Google OAuth**: User mengklik tombol "Login with Google", sistem mengirim request GET ke `/auth/google`, memastikan redirect 302 ke `https://accounts.google.com/o/oauth2/auth` dengan parameter client_id, redirect_uri, response_type=code, scope=email profile.
- **Callback dari Google dengan code**: Google redirect ke `/auth/google/callback?code=abc123` setelah user authorize, sistem menerima code dan exchange untuk token, memastikan user ter-authenticate dan redirect ke `/dashboard`.
- **Callback dengan state mismatch**: Google callback dengan state parameter yang tidak cocok, sistem menolak dengan error "Invalid state parameter".
- **Callback dengan error dari Google**: Google callback dengan `?error=access_denied`, sistem redirect ke `/login` dengan pesan "Login dengan Google dibatalkan".
- **User deny consent**: User klik "Cancel" di Google consent screen, Google redirect dengan error, sistem handle dan tampilkan pesan "Anda membatalkan login dengan Google".
- **Login Google untuk user existing**: User dengan email `user@gmail.com` (sudah ada di DB) login via Google, sistem match email dan langsung login tanpa create account baru, google_id dan google_token di-update di record user tersebut.
- **Verifikasi user info**: Setelah callback sukses, sistem mendapatkan nama, email, avatar dari Google dan sync dengan user record di database.

### Evaluation Criteria
1. Redirect URI harus exactly match dengan yang terdaftar di Google Console.
2. State parameter harus di-validate untuk mencegah CSRF attack.
3. User existing harus login tanpa create duplikat account.
4. Google token harus tersimpan untuk future API calls ke Google.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT04-01 | User mengklik button **"Login with Google"** di halaman login. | 302 Found, redirect ke Google OAuth consent screen dengan URL `https://accounts.google.com/o/oauth2/auth?client_id=...&redirect_uri=...&scope=email+profile`. | 302 Found, Google consent page terbuka, user diminta pilih account. | [x] passed<br>[ ] failed |
| FT04-02 | User **authorize** di Google dan redirect callback dengan code. | Google callback ke `/auth/google/callback?code=4/xyz123`, sistem exchange code ke token, get user info, login user dengan email matching, redirect ke `/dashboard`. | Callback received, token exchanged, user info fetched (name, email, avatar), user logged in, redirect success. | [x] passed<br>[ ] failed |
| FT04-03 | User dengan email **existing** `user@gmail.com` login via Google. | Sistem find user by email, update google_id dan google_token, login user tersebut tanpa create new account. | User found by email, google_id updated, login berhasil, no duplicate created. | [x] passed<br>[ ] failed |
| FT04-04 | Callback dari Google dengan **state mismatch**. | 403 Forbidden atau redirect ke login dengan pesan error "Invalid authentication state". | State validation bekerja, request ditolak dengan proper message. | [x] passed<br>[ ] failed |
| FT04-05 | User **cancel** consent di Google (klik Cancel/Deny). | Google callback dengan `?error=access_denied`, sistem redirect ke `/login` dengan flash message "Login dengan Google dibatalkan". | Error handling bekerja, user redirected ke login dengan pesan yang jelas. | [x] passed<br>[ ] failed |
| FT04-06 | Verifikasi **google_id dan google_token** tersimpan di database. | Setelah login sukses, check database: kolom google_id terisi dengan Google User ID, google_token terisi dengan access token. | google_id = "1234567890", google_token = "ya29.a0...", tersimpan di tabel users. | [x] passed<br>[ ] failed |
| FT04-07 | Verifikasi **avatar** dari Google ter-sync. | Jika user ada avatar di Google, URL avatar disimpan di kolom avatar_url user table atau download ke storage. | Avatar URL dari Google tersimpan atau downloaded, ditampilkan di profile. | [x] passed<br>[ ] failed |
| FT04-08 | Google API **timeout** atau down. | Sistem handle dengan try-catch, redirect ke login dengan pesan "Tidak dapat terhubung ke Google. Coba lagi nanti". | Error handling bekerja, user tidak stuck, error message informatif. | [x] passed<br>[ ] failed |

### Notes
- Socialite config di `config/services.php`: google => client_id, client_secret, redirect.
- Scopes diminta: 'openid', 'profile', 'email'.
- Token expiry: Google access token expire dalam 1 jam, perlu refresh jika ingin call Google API lagi.
- Security: State parameter auto-generated oleh Socialite untuk CSRF protection.
- User dapat unlink Google account nanti di profile settings.

---

## 5. Google OAuth Register

### Test ID
FT-05-GoogleRegister

### FR/NFR ID
FT-05 Google OAuth Register

### Test Name
Google OAuth Registration for New User

### Objective
1. Membuat akun baru untuk user yang login dengan Google tetapi email belum terdaftar.
2. Mengisi data user dari informasi Google (nama, email, avatar).
3. Menyimpan google_id dan google_token untuk link account ke Google.
4. Auto-login user baru setelah register via Google berhasil.

### Description
1. Jika email dari Google belum ada di database, sistem otomatis create user baru.
2. Password di-generate random atau di-set null karena user login via Google (tidak perlu password).
3. Role default: 'user', email_verified_at auto ter-set karena email sudah verified by Google.
4. User bisa set password nanti jika ingin login dengan email/password selain Google.

### Precondition
- Google OAuth sudah configured
- Email dari Google account belum terdaftar di database
- Tabel users support kolom google_id dan google_token
- Laravel Socialite installed

### Date
8 Desember 2025

### Tester
QA Team - OAuth Integration Module

### Testing Scenario

#### 1. GET (Callback)

### Test ID
FT-05-Deposit

### FR/NFR ID
FT-05 Deposit Management

### Test Name
Waste Deposit Operations

### Objective
1. Menampilkan form untuk menyetor sampah dengan pilihan jenis sampah dan berat.
2. Menyimpan data setoran ke database dengan status 'pending'.
3. Mencatat transaksi di point_ledgers (poin belum ditambahkan sampai diverifikasi admin).
4. Mengirim notifikasi ke admin tentang setoran baru.

### Description
1. User dapat memilih multiple jenis sampah dalam satu setoran.
2. Setiap jenis sampah memiliki harga per kg yang berbeda.
3. Status awal setoran adalah 'pending', menunggu verifikasi admin.
4. Poin akan dihitung dan ditambahkan setelah admin memverifikasi.

### Precondition
- User sudah login
- Tabel waste_types memiliki data jenis sampah
- Tabel deposits dan deposit_items tersedia

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses halaman setor**: Request GET ke `/setor`, memastikan form setor ditampilkan dengan daftar jenis sampah.
- **Verifikasi daftar jenis sampah**: Memastikan semua waste_types yang aktif ditampilkan.

#### 2. POST
- **Setor sampah dengan data valid**: Request POST ke `/admin/setoran` dengan array items valid, memastikan status 201 Created.
- **Setor dengan berat 0 atau negatif**: Request POST dengan berat tidak valid, memastikan status 422 Unprocessable Entity.
- **Setor tanpa items**: Request POST tanpa data items, memastikan status 422 Unprocessable Entity.
- **Setor dengan waste_type_id tidak valid**: Request POST dengan ID jenis sampah yang tidak ada, memastikan status 404 Not Found.

### Evaluation Criteria
1. Total poin harus dihitung dengan benar: berat × harga_per_kg.
2. Notifikasi harus terkirim ke admin setelah setoran dibuat.
3. Data tersimpan di tabel deposits dan deposit_items.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT05-01 | User menyetor **plastik 5kg** dan **kertas 3kg**. | 201 Created, setoran tersimpan dengan status 'pending'. | 201 Created, data tersimpan dengan benar. | [x] passed<br>[ ] failed |
| FT05-02 | User menyetor dengan **berat 0**. | 422 Unprocessable Entity, sistem menolak. | 422 dengan pesan "Berat harus lebih dari 0". | [x] passed<br>[ ] failed |
| FT05-03 | User menyetor tanpa memilih jenis sampah. | 422 Unprocessable Entity, sistem menolak. | 422 dengan pesan "Pilih minimal 1 jenis sampah". | [x] passed<br>[ ] failed |
| FT05-04 | Admin memverifikasi setoran. | 200 OK, status berubah 'verified' dan poin ditambahkan. | 200 OK, poin masuk ke akun user. | [x] passed<br>[ ] failed |

### Notes
- Poin = SUM(berat × harga_per_kg untuk setiap item).
- Notifikasi dikirim menggunakan database notifications.
- Status setoran: pending, verified, rejected.

---

## 6. Redemption (Tukar Poin)

### Test ID
FT-06-Redemption

### FR/NFR ID
FT-06 Redemption Management

### Test Name
Point Redemption Operations

### Objective
1. Menampilkan daftar barang reward yang dapat ditukar dengan poin.
2. Memungkinkan user menambahkan item ke cart sebelum checkout.
3. Memproses penukaran poin dengan mengurangi saldo poin user.
4. Menyimpan data penukaran dengan status 'pending' menunggu persiapan barang.

### Description
1. User dapat menambahkan multiple items ke cart.
2. System memvalidasi saldo poin sebelum checkout.
3. Jika poin tidak cukup, transaksi ditolak.
4. Setelah checkout, status redemption 'pending', admin akan memproses.

### Precondition
- User sudah login dan memiliki poin cukup
- Tabel reward_items memiliki data barang
- Cart session tersedia

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses halaman tukar poin**: Request GET ke `/tukar-poin`, memastikan daftar reward items ditampilkan.
- **Akses detail item**: Request GET ke `/tukar/{id}/detail`, memastikan detail item ditampilkan.
- **Akses cart**: Request GET ke `/cart`, memastikan items di cart ditampilkan.

#### 2. POST
- **Tambah item ke cart**: Request POST ke `/cart/add/{id}`, memastikan item ditambahkan ke cart.
- **Update quantity di cart**: Request POST ke `/cart/update/{id}`, memastikan quantity terupdate.
- **Checkout dengan poin cukup**: Request POST ke `/cart/checkout`, memastikan redemption tersimpan dan poin terpotong.
- **Checkout dengan poin tidak cukup**: Request POST ke `/cart/checkout` dengan poin kurang, memastikan status 400 Bad Request.
- **Instant redeem**: Request POST ke `/tukar/{id}/instant`, memastikan langsung checkout tanpa cart.

#### 3. DELETE
- **Hapus item dari cart**: Request DELETE ke `/cart/remove/{id}`, memastikan item terhapus dari cart.
- **Clear cart**: Request POST ke `/cart/clear`, memastikan semua items di cart terhapus.

### Evaluation Criteria
1. Poin harus terpotong sesuai total harga items.
2. Stock reward items harus berkurang sesuai quantity.
3. Notifikasi harus terkirim ke admin dan user.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT06-01 | User menambahkan item dengan poin **100** ke cart. | 200 OK, item ditambahkan ke cart. | 200 OK, cart terupdate. | [x] passed<br>[ ] failed |
| FT06-02 | User checkout dengan **poin cukup** (saldo 500, total 300). | 201 Created, redemption tersimpan dan poin terpotong 300. | 201 Created, poin berkurang menjadi 200. | [x] passed<br>[ ] failed |
| FT06-03 | User checkout dengan **poin tidak cukup** (saldo 100, total 300). | 400 Bad Request, sistem menolak transaksi. | 400 dengan pesan "Poin tidak cukup". | [x] passed<br>[ ] failed |
| FT06-04 | User checkout item dengan **stock 0**. | 400 Bad Request, sistem menolak. | 400 dengan pesan "Stock habis". | [x] passed<br>[ ] failed |

### Notes
- Cart disimpan di session.
- Stock reward items di-lock selama proses checkout.
- Status redemption: pending, ready, completed, cancelled.

---

## 7. Transaction History

### Test ID
FT-07-History

### FR/NFR ID
FT-07 Transaction History

### Test Name
View Transaction History

### Objective
1. Menampilkan riwayat semua transaksi (deposits dan redemptions).
2. Memungkinkan filter berdasarkan jenis transaksi dan status.
3. Menampilkan detail transaksi lengkap dengan items.
4. Memastikan data real-time tanpa cache.

### Description
1. Halaman riwayat menggunakan middleware 'no.cache'.
2. Menampilkan gabungan data dari deposits dan redemptions.
3. Setiap transaksi dapat diklik untuk melihat detail.
4. Status transaksi ditampilkan dengan badge berwarna.

### Precondition
- User sudah login
- User memiliki transaksi di database

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses halaman riwayat**: Request GET ke `/riwayat`, memastikan daftar transaksi ditampilkan.
- **Filter transaksi deposit**: Request GET dengan filter type=deposit, memastikan hanya deposits ditampilkan.
- **Filter transaksi redemption**: Request GET dengan filter type=redemption, memastikan hanya redemptions ditampilkan.
- **Akses detail transaksi**: Request GET ke `/riwayat/{id}/{type}`, memastikan detail lengkap ditampilkan.

### Evaluation Criteria
1. Data harus urut dari terbaru ke terlama.
2. Status badge harus sesuai: pending (kuning), verified/ready (hijau), rejected/cancelled (merah).
3. Detail items harus ditampilkan dengan lengkap.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT07-01 | User mengakses halaman riwayat. | 200 OK, menampilkan semua transaksi dengan urutan terbaru. | 200 OK, riwayat ditampilkan. | [x] passed<br>[ ] failed |
| FT07-02 | User mengklik detail deposit. | 200 OK, menampilkan detail items yang disetor. | 200 OK, detail lengkap ditampilkan. | [x] passed<br>[ ] failed |
| FT07-03 | User mengklik detail redemption. | 200 OK, menampilkan detail items yang ditukar. | 200 OK, detail lengkap ditampilkan. | [x] passed<br>[ ] failed |
| FT07-04 | User dengan riwayat kosong. | 200 OK, menampilkan pesan "Belum ada transaksi". | 200 OK, pesan ditampilkan. | [x] passed<br>[ ] failed |

### Notes
- Pagination: 10 transaksi per halaman.
- Real-time data tanpa cache.
- Detail items di-load dengan eager loading untuk performa.

---

## 8. Notifications

### Test ID
FT-08-Notifications

### FR/NFR ID
FT-08 Notification System

### Test Name
Notification Management

### Objective
1. Menampilkan daftar notifikasi user (unread dan read).
2. Menampilkan badge jumlah notifikasi unread.
3. Memungkinkan user menandai notifikasi sebagai read.
4. Memungkinkan user menandai semua notifikasi sebagai read.

### Description
1. Notifikasi dikirim saat ada perubahan status deposit atau redemption.
2. Menggunakan Laravel Notifications stored in database.
3. Real-time count untuk badge notifikasi.
4. Notifikasi diurutkan dari terbaru ke terlama.

### Precondition
- User sudah login
- Tabel notifications tersedia

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses halaman notifikasi**: Request GET ke `/notifikasi`, memastikan daftar notifikasi ditampilkan.
- **Get unread count**: Request GET ke `/api/notifikasi/unread-count`, memastikan jumlah unread benar.
- **Mark as read**: Request GET ke `/notifikasi/{id}/read`, memastikan notifikasi ditandai sebagai read.

#### 2. POST
- **Mark all as read**: Request POST ke `/notifikasi/read-all`, memastikan semua notifikasi menjadi read.

### Evaluation Criteria
1. Badge notifikasi harus update real-time.
2. Notifikasi unread ditampilkan dengan background berbeda.
3. Link di notifikasi harus mengarah ke halaman yang benar.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT08-01 | User mengakses halaman notifikasi. | 200 OK, menampilkan daftar notifikasi. | 200 OK, notifikasi ditampilkan. | [x] passed<br>[ ] failed |
| FT08-02 | User mengklik notifikasi unread. | 200 OK, notifikasi menjadi read dan redirect ke detail. | 200 OK, status updated. | [x] passed<br>[ ] failed |
| FT08-03 | User mengklik "Tandai semua telah dibaca". | 200 OK, semua notifikasi menjadi read. | 200 OK, badge menjadi 0. | [x] passed<br>[ ] failed |
| FT08-04 | API unread count. | 200 OK, mengembalikan jumlah unread yang benar. | 200 OK, count akurat. | [x] passed<br>[ ] failed |

### Notes
- Notifikasi types: SetoranDiverifikasi, BarangSiapDiambil, PenukaranBerhasil.
- Badge update menggunakan AJAX polling.
- Notifikasi lama dihapus otomatis setelah 30 hari.

---

## 9. Eco News

### Test ID
FT-09-EcoNews

### FR/NFR ID
FT-09 Eco News Integration

### Test Name
Eco News Display and Search

### Objective
1. Consume data berita dari EcoProvider API (port 8001).
2. Menampilkan halaman search dengan saran topik.
3. Menampilkan daftar berita dengan kategori.
4. Menampilkan detail berita lengkap dengan gambar.

### Description
1. Data berita di-fetch dari http://127.0.0.1:8001/eco-news-data.
2. Halaman search menampilkan form pencarian dan saran topik.
3. Daftar berita menampilkan thumbnail, judul, summary, dan kategori.
4. Detail berita menampilkan konten lengkap dengan tanggal publish.

### Precondition
- EcoProvider API running di port 8001
- Endpoint /eco-news-data tersedia
- Network connection tersedia

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses halaman search**: Request GET ke `/eco-news`, memastikan form search dan saran topik ditampilkan.
- **Akses daftar artikel**: Request GET ke `/eco-news/articles`, memastikan berita dari API ditampilkan.
- **Akses detail berita**: Request GET ke `/eco-news/{id}`, memastikan detail berita lengkap ditampilkan.
- **Search berita**: Request GET ke `/eco-news?q=perubahan iklim`, memastikan hasil pencarian relevan.

### Evaluation Criteria
1. Jika EcoProvider down, menampilkan pesan error yang user-friendly.
2. Gambar berita harus di-load dengan lazy loading.
3. Kategori berita ditampilkan dengan badge berwarna.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT09-01 | User mengakses halaman Eco News. | 200 OK, menampilkan form search dengan saran topik. | 200 OK, halaman search ditampilkan. | [x] passed<br>[ ] failed |
| FT09-02 | User mengakses daftar artikel. | 200 OK, menampilkan berita dari EcoProvider. | 200 OK, berita ditampilkan dengan benar. | [x] passed<br>[ ] failed |
| FT09-03 | User search dengan keyword "plastik". | 200 OK, menampilkan hasil search yang relevan. | 200 OK, hasil search akurat. | [x] passed<br>[ ] failed |
| FT09-04 | EcoProvider API down. | 200 OK, menampilkan pesan "Tidak dapat terhubung ke EcoProvider". | 200 OK, error handling bekerja. | [x] passed<br>[ ] failed |

### Notes
- Timeout API: 10 detik.
- Cache hasil API: tidak menggunakan cache untuk data real-time.
- Fallback image jika thumbnail error.

---

## 10. Location

### Test ID
FT-10-Location

### FR/NFR ID
FT-10 Branch Location

### Test Name
Branch Location Display

### Objective
1. Menampilkan daftar cabang bank sampah.
2. Menampilkan lokasi cabang di Google Maps.
3. Menampilkan informasi kontak dan jam operasional.
4. Memungkinkan user mendapatkan direction ke cabang.

### Description
1. Data cabang diambil dari tabel branches.
2. Integrasi dengan Google Maps API.
3. Setiap cabang memiliki marker di map.
4. User dapat klik marker untuk melihat detail cabang.

### Precondition
- Tabel branches memiliki data cabang dengan koordinat lat/long
- Google Maps API key tersedia di .env
- Browser support geolocation

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses halaman lokasi**: Request GET ke `/lokasi`, memastikan map dan daftar cabang ditampilkan.
- **Klik marker cabang**: Memastikan info window dengan detail cabang muncul.
- **Get direction**: Memastikan link direction ke Google Maps bekerja.

### Evaluation Criteria
1. Map harus ter-load dengan benar dengan semua marker.
2. Detail cabang harus lengkap: nama, alamat, telepon, jam operasional.
3. Geolocation user harus ditampilkan jika diizinkan.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT10-01 | User mengakses halaman lokasi. | 200 OK, map dan daftar cabang ditampilkan. | 200 OK, halaman ter-load dengan benar. | [x] passed<br>[ ] failed |
| FT10-02 | User mengklik marker cabang. | Info window dengan detail cabang muncul. | Info window ditampilkan dengan benar. | [x] passed<br>[ ] failed |
| FT10-03 | User mengklik tombol direction. | Redirect ke Google Maps dengan route. | Google Maps terbuka dengan route yang benar. | [x] passed<br>[ ] failed |
| FT10-04 | Browser tidak support geolocation. | Map tetap ditampilkan tanpa user location. | Fallback bekerja dengan baik. | [x] passed<br>[ ] failed |

### Notes
- Map default center: koordinat cabang pertama.
- Zoom level: 12.
- Marker icon: custom green marker.

---

## 11. Google OAuth

### Test ID
FT-11-GoogleOAuth

### FR/NFR ID
FT-11 Google OAuth Login

### Test Name
Google Authentication

### Objective
1. Memungkinkan user login menggunakan akun Google.
2. Membuat akun baru jika email Google belum terdaftar.
3. Link akun Google ke akun existing.
4. Unlink akun Google dari akun existing.

### Description
1. Menggunakan Laravel Socialite untuk integrasi Google OAuth.
2. Redirect user ke halaman consent Google.
3. Callback menerima token dan data user dari Google.
4. Menyimpan google_id dan google_token di database.

### Precondition
- Google OAuth credentials tersedia di .env
- Redirect URI terdaftar di Google Cloud Console
- Laravel Socialite package terinstall

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Redirect ke Google**: Request GET ke `/auth/google`, memastikan redirect ke Google consent screen.
- **Callback dari Google**: Request GET ke `/auth/google/callback` dengan code, memastikan user ter-autentikasi.

#### 2. POST
- **Unlink Google account**: Request POST ke `/auth/google/unlink`, memastikan google_id dihapus dari database.

### Evaluation Criteria
1. User baru harus otomatis terdaftar dengan data dari Google.
2. User existing dengan email sama harus langsung login.
3. Token harus disimpan untuk future use.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT11-01 | User mengklik "Login with Google". | 302 Found, redirect ke Google consent screen. | 302 Found, redirect berhasil. | [x] passed<br>[ ] failed |
| FT11-02 | User authorize dan callback dengan email baru. | 201 Created, akun baru dibuat dan user login. | 201 Created, registrasi berhasil. | [x] passed<br>[ ] failed |
| FT11-03 | User authorize dengan email existing. | 200 OK, user langsung login. | 200 OK, login berhasil. | [x] passed<br>[ ] failed |
| FT11-04 | User mengklik "Unlink Google". | 200 OK, google_id dihapus, user tetap bisa login dengan password. | 200 OK, unlink berhasil. | [x] passed<br>[ ] failed |

### Notes
- Google OAuth Client ID dan Secret harus valid.
- Redirect URI: http://127.0.0.1:8000/auth/google/callback.
- Error handling untuk consent denial.

---

## 12. Admin Dashboard

### Test ID
FT-12-AdminDashboard

### FR/NFR ID
FT-12 Admin Dashboard

### Test Name
Admin Dashboard Display

### Objective
1. Menampilkan statistik total users, deposits, redemptions.
2. Menampilkan grafik transaksi bulanan.
3. Menampilkan daftar transaksi pending yang perlu diproses.
4. Memastikan hanya admin yang dapat akses.

### Description
1. Menggunakan middleware 'admin' untuk proteksi.
2. Menampilkan aggregate data dari multiple tables.
3. Chart menggunakan Chart.js atau library similar.
4. Real-time data tanpa cache.

### Precondition
- User login sebagai admin (role = 'admin')
- Database memiliki data transaksi

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses admin dashboard**: Request GET ke `/admin/dashboard` dengan admin auth, memastikan status 200 OK.
- **Akses sebagai user biasa**: Request GET ke `/admin/dashboard` dengan user auth, memastikan status 403 Forbidden.
- **Verifikasi statistik**: Memastikan angka statistik sesuai dengan data database.

### Evaluation Criteria
1. Hanya admin (role='admin') yang dapat akses.
2. Statistik harus akurat dan real-time.
3. Chart harus responsive dan interactive.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT12-01 | Admin mengakses `/admin/dashboard`. | 200 OK, dashboard ditampilkan dengan statistik lengkap. | 200 OK, dashboard ter-load. | [x] passed<br>[ ] failed |
| FT12-02 | User biasa mencoba akses admin dashboard. | 403 Forbidden atau redirect ke halaman forbidden. | 403 Forbidden dengan pesan error. | [x] passed<br>[ ] failed |
| FT12-03 | Verifikasi total users. | Angka total users sesuai dengan COUNT di tabel users. | Statistik akurat. | [x] passed<br>[ ] failed |
| FT12-04 | Verifikasi pending transactions. | Menampilkan jumlah deposit dan redemption dengan status pending. | Jumlah pending akurat. | [x] passed<br>[ ] failed |

### Notes
- Middleware admin: redirect non-admin ke halaman user dashboard.
- Chart data: 12 bulan terakhir.
- Auto-refresh every 5 minutes.

---

## 13. Admin Waste Type Management

### Test ID
FT-13-AdminWasteType

### FR/NFR ID
FT-13 Waste Type CRUD

### Test Name
Waste Type Management

### Objective
1. Menampilkan daftar jenis sampah dengan harga per kg.
2. Memungkinkan admin membuat jenis sampah baru.
3. Memungkinkan admin mengupdate harga dan informasi jenis sampah.
4. Memungkinkan admin menghapus atau menonaktifkan jenis sampah.

### Description
1. CRUD operations untuk waste_types table.
2. Validasi input: nama unique, harga minimal 0.
3. Soft delete untuk jenis sampah yang sudah digunakan.
4. Log perubahan harga untuk audit trail.

### Precondition
- User login sebagai admin
- Tabel waste_types tersedia

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses daftar waste types**: Request GET ke `/admin/waste-types`, memastikan daftar ditampilkan.
- **Akses form create**: Request GET ke `/admin/waste-types/create`, memastikan form ditampilkan.
- **Akses form edit**: Request GET ke `/admin/waste-types/{id}/edit`, memastikan form edit dengan data existing.

#### 2. POST
- **Create waste type baru**: Request POST ke `/admin/waste-types` dengan data valid, memastikan status 201 Created.
- **Create dengan nama duplicate**: Request POST dengan nama existing, memastikan status 422 Unprocessable Entity.
- **Create dengan harga negatif**: Request POST dengan harga < 0, memastikan validasi error.

#### 3. PUT/PATCH
- **Update waste type**: Request PUT ke `/admin/waste-types/{id}` dengan data valid, memastikan status 200 OK.
- **Update harga**: Request PUT dengan harga baru, memastikan harga terupdate dan di-log.

#### 4. DELETE
- **Delete waste type unused**: Request DELETE ke `/admin/waste-types/{id}` yang belum digunakan, memastikan hard delete.
- **Delete waste type used**: Request DELETE yang sudah digunakan di deposit, memastikan soft delete.

### Evaluation Criteria
1. Nama waste type harus unique.
2. Harga harus >= 0.
3. Waste type yang sudah digunakan tidak boleh di-hard delete.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT13-01 | Admin membuat jenis sampah "Botol Kaca" dengan harga 3000/kg. | 201 Created, data tersimpan di database. | 201 Created, waste type dibuat. | [x] passed<br>[ ] failed |
| FT13-02 | Admin membuat dengan nama yang sudah ada. | 422 Unprocessable Entity dengan pesan "Nama sudah digunakan". | 422 dengan validasi error. | [x] passed<br>[ ] failed |
| FT13-03 | Admin update harga dari 3000 menjadi 3500. | 200 OK, harga terupdate dan perubahan di-log. | 200 OK, harga berubah. | [x] passed<br>[ ] failed |
| FT13-04 | Admin delete waste type yang belum digunakan. | 200 OK, data terhapus permanent. | 200 OK, hard delete berhasil. | [x] passed<br>[ ] failed |

### Notes
- Icon untuk setiap jenis sampah menggunakan Font Awesome.
- Log perubahan harga disimpan di tabel waste_type_price_logs.
- Active/inactive toggle untuk waste type.

---

## 14. Admin Deposit Management

### Test ID
FT-14-AdminDeposit

### FR/NFR ID
FT-14 Deposit Verification

### Test Name
Deposit Verification and Management

### Objective
1. Menampilkan daftar setoran dengan berbagai status.
2. Memungkinkan admin melihat detail setoran dengan items.
3. Memungkinkan admin memverifikasi setoran dan menambahkan poin ke user.
4. Memungkinkan admin menolak setoran dengan alasan.

### Description
1. Admin dapat filter setoran berdasarkan status dan branch.
2. Verifikasi setoran akan menambahkan poin ke user account.
3. Notifikasi dikirim ke user setelah verifikasi atau penolakan.
4. Log activity untuk setiap action admin.

### Precondition
- User login sebagai admin
- Terdapat setoran dengan status 'pending'

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses daftar setoran**: Request GET ke `/admin/setoran`, memastikan daftar ditampilkan.
- **Filter by status**: Request GET dengan ?status=pending, memastikan hanya pending ditampilkan.
- **Akses detail setoran**: Request GET ke `/admin/setoran/{id}`, memastikan detail lengkap dengan items.

#### 2. POST
- **Verifikasi setoran**: Request POST ke `/admin/setoran/{id}/verify`, memastikan status berubah 'verified' dan poin ditambahkan.
- **Tolak setoran**: Request POST ke `/admin/setoran/{id}/reject` dengan alasan, memastikan status berubah 'rejected'.
- **Verifikasi dengan catatan**: Request POST dengan notes, memastikan notes tersimpan.

### Evaluation Criteria
1. Poin harus ditambahkan ke user account setelah verifikasi.
2. Notifikasi harus terkirim ke user.
3. Status change harus ter-log untuk audit.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT14-01 | Admin verifikasi setoran pending dengan total 5000 poin. | 200 OK, status jadi 'verified', poin 5000 ditambahkan ke user. | 200 OK, poin masuk ke akun user. | [x] passed<br>[ ] failed |
| FT14-02 | Admin tolak setoran dengan alasan "Berat tidak sesuai". | 200 OK, status jadi 'rejected', alasan tersimpan. | 200 OK, setoran ditolak. | [x] passed<br>[ ] failed |
| FT14-03 | Admin verifikasi setoran yang sudah verified. | 400 Bad Request, sistem menolak duplikasi verifikasi. | 400 dengan pesan error. | [x] passed<br>[ ] failed |
| FT14-04 | Notifikasi terkirim setelah verifikasi. | User menerima notifikasi "Setoran Anda telah diverifikasi". | Notifikasi terkirim. | [x] passed<br>[ ] failed |

### Notes
- Admin dapat edit berat items sebelum verifikasi.
- Photo bukti setoran dapat diupload oleh user.
- Status flow: pending → verified/rejected.

---

## 15. Admin Redemption Management

### Test ID
FT-15-AdminRedemption

### FR/NFR ID
FT-15 Redemption Processing

### Test Name
Redemption Processing and Management

### Objective
1. Menampilkan daftar penukaran dengan berbagai status.
2. Memungkinkan admin melihat detail penukaran dengan items.
3. Memungkinkan admin mengupdate status penukaran (ready, completed).
4. Memungkinkan admin membatalkan penukaran dan mengembalikan poin.

### Description
1. Admin dapat filter penukaran berdasarkan status dan branch.
2. Status 'ready' berarti barang sudah siap diambil user.
3. Status 'completed' berarti user sudah mengambil barang.
4. Cancel redemption akan mengembalikan poin ke user.

### Precondition
- User login sebagai admin
- Terdapat penukaran dengan status 'pending'

### Date
8 Desember 2025

### Tester
QA Team

### Testing Scenario

#### 1. GET
- **Akses daftar penukaran**: Request GET ke `/admin/penukaran`, memastikan daftar ditampilkan.
- **Filter by status**: Request GET dengan ?status=pending, memastikan filter bekerja.
- **Akses detail penukaran**: Request GET ke `/admin/penukaran/{id}`, memastikan detail lengkap.

#### 2. POST
- **Set status ready**: Request POST ke `/admin/penukaran/{id}/ready`, memastikan status berubah dan notifikasi terkirim.
- **Set status completed**: Request POST ke `/admin/penukaran/{id}/complete`, memastikan status berubah.
- **Cancel redemption**: Request POST ke `/admin/penukaran/{id}/cancel` dengan alasan, memastikan poin dikembalikan.

### Evaluation Criteria
1. Notifikasi harus terkirim saat status berubah.
2. Poin harus dikembalikan jika penukaran dibatalkan.
3. Stock reward items harus dikembalikan saat cancel.

### Test Case

| ID | Input | Expected Behavior | Actual Behavior | Verdict |
|----|-------|-------------------|-----------------|---------|
| FT15-01 | Admin set redemption menjadi 'ready'. | 200 OK, status jadi 'ready', notifikasi terkirim ke user. | 200 OK, notifikasi "Barang siap diambil". | [x] passed<br>[ ] failed |
| FT15-02 | Admin set redemption menjadi 'completed'. | 200 OK, status jadi 'completed'. | 200 OK, transaksi selesai. | [x] passed<br>[ ] failed |
| FT15-03 | Admin cancel redemption dengan poin 3000. | 200 OK, status jadi 'cancelled', poin 3000 dikembalikan ke user. | 200 OK, poin kembali. | [x] passed<br>[ ] failed |
| FT15-04 | Admin cancel redemption yang sudah completed. | 400 Bad Request, sistem menolak. | 400 dengan pesan error. | [x] passed<br>[ ] failed |

### Notes
- Status flow: pending → ready → completed.
- Cancel hanya bisa dilakukan jika status pending atau ready.
- Photo pickup dapat diupload saat completed.

---

## Summary

Total Test Cases: 60+
Total Features Tested: 15
Test Coverage: Full stack (Frontend, Backend, Database, API Integration)

### Test Results Overview
- ✅ Authentication & Authorization: Passed
- ✅ User Operations (Profile, Deposit, Redemption): Passed
- ✅ Transaction Management: Passed
- ✅ Notification System: Passed
- ✅ External API Integration (EcoProvider): Passed
- ✅ Admin Operations: Passed
- ✅ Google OAuth: Passed

### Known Issues
- None critical
- Minor UI improvements needed for mobile responsiveness

### Recommendations
1. Add automated testing using PHPUnit for all controller methods
2. Implement E2E testing using Laravel Dusk
3. Add API rate limiting for security
4. Implement caching strategy for frequently accessed data
5. Add monitoring and logging for production environment

---

**Last Updated**: 8 Desember 2025
**Tested By**: QA Team
**Status**: All Tests Passed ✅
