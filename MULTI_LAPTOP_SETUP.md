# Multi-Laptop Development Guide

## 🔍 **Problem**

Login di laptop A tidak bisa diakses di laptop B karena:
- ✗ Database lokal (masing-masing laptop punya database sendiri)
- ✗ Session lokal (disimpan di file system masing-masing)
- ✗ User terdaftar di laptop A → tidak ada di database laptop B

---

## 🎯 **Solusi**

### **Opsi 1: Shared Database via Network (Recommended)**

Gunakan 1 database MySQL yang bisa diakses dari kedua laptop via network lokal.

#### **Setup Database Server (Laptop A):**

**1. Check IP Address Laptop A:**
```powershell
ipconfig
# Cari IPv4 Address, contoh: 192.168.1.100
```

**2. Configure MySQL untuk Allow Remote Connection:**

Edit file `my.ini` di Laragon:
```
C:\laragon\bin\mysql\mysql-8.x.x\my.ini
```

Cari dan ubah:
```ini
# Dari:
bind-address = 127.0.0.1

# Jadi:
bind-address = 0.0.0.0
```

**3. Create Remote User:**
```sql
-- Login ke MySQL di Laragon
mysql -u root -p

-- Create user yang bisa akses dari network
CREATE USER 'root'@'%' IDENTIFIED BY 'Gracia044.';
GRANT ALL PRIVILEGES ON banksampahdigital.* TO 'root'@'%';
FLUSH PRIVILEGES;
```

**4. Restart MySQL:**
Di Laragon → Stop MySQL → Start MySQL

**5. Test koneksi dari Laptop B:**
```powershell
# Di Laptop B
mysql -h 192.168.1.100 -u root -p banksampahdigital
# Masukkan password: Gracia044.
```

#### **Configure Laptop B (.env):**

```env
# .env di Laptop B
DB_CONNECTION=mysql
DB_HOST=192.168.1.100  # IP Laptop A
DB_PORT=3306
DB_DATABASE=banksampahdigital
DB_USERNAME=root
DB_PASSWORD=Gracia044.
```

**Test connection:**
```bash
php artisan migrate:status
# Jika berhasil, artinya koneksi ke DB Laptop A sudah OK
```

---

### **Opsi 2: Sync Database Manual**

Export/Import database antar laptop menggunakan script yang sudah saya buatkan.

#### **Di Laptop A (Export):**
```bash
# Export semua users
php scripts/export_users.php

# Output: users_export_2024-11-24_120000.json
```

#### **Transfer File:**
Copy file JSON ke Laptop B via:
- USB flashdisk
- Google Drive / Dropbox
- WhatsApp / Email
- Network share

#### **Di Laptop B (Import):**
```bash
# Import users
php scripts/import_users.php users_export_2024-11-24_120000.json
```

---

### **Opsi 3: Cloud Database (Production-like)**

Gunakan database di cloud yang bisa diakses dari mana saja.

#### **PlanetScale (Free Tier - Recommended):**

1. Sign up: https://planetscale.com
2. Create database: `banksampahdigital`
3. Get connection string
4. Update `.env` di kedua laptop:

```env
DB_CONNECTION=mysql
DB_HOST=aws.connect.psdb.cloud
DB_PORT=3306
DB_DATABASE=banksampahdigital
DB_USERNAME=xxxxxxxxx
DB_PASSWORD=pscale_pw_xxxxxxxxx
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
```

#### **AWS RDS / Google Cloud SQL:**
- Setup MySQL instance
- Allow IP dari kedua laptop
- Update `.env` dengan connection string

---

## 🚀 **Quick Start (Opsi 1 - Shared Database)**

### **Laptop A (Database Server):**

```powershell
# 1. Check IP
ipconfig
# Contoh: 192.168.1.100

# 2. Edit my.ini
notepad C:\laragon\bin\mysql\mysql-8.x.x\my.ini
# Ubah bind-address = 0.0.0.0

# 3. Restart MySQL di Laragon

# 4. Create remote user
mysql -u root -p
```

```sql
CREATE USER 'root'@'%' IDENTIFIED BY 'Gracia044.';
GRANT ALL PRIVILEGES ON banksampahdigital.* TO 'root'@'%';
FLUSH PRIVILEGES;
EXIT;
```

### **Laptop B (Client):**

```powershell
# 1. Test koneksi
mysql -h 192.168.1.100 -u root -p banksampahdigital

# 2. Update .env
```

Edit `.env`:
```env
DB_HOST=192.168.1.100  # IP Laptop A
```

```powershell
# 3. Clear config cache
php artisan config:clear

# 4. Test
php artisan migrate:status
```

---

## 🔐 **Security Notes**

### **Development (Local Network):**
- ✅ OK untuk development di rumah/lab
- ✅ Pastikan firewall Windows allow MySQL port 3306
- ⚠️ Jangan expose ke internet publik

### **Production:**
- Use SSL/TLS for database connection
- Use strong passwords
- Whitelist IP addresses only
- Consider using cloud database with built-in security

---

## 🐛 **Troubleshooting**

### **"Connection Refused" dari Laptop B:**

**Check 1: Firewall Windows**
```powershell
# Allow MySQL port 3306
netsh advfirewall firewall add rule name="MySQL" dir=in action=allow protocol=TCP localport=3306
```

**Check 2: MySQL listening on correct interface**
```sql
SHOW VARIABLES LIKE 'bind_address';
-- Should be: 0.0.0.0 or :: (not 127.0.0.1)
```

**Check 3: User privileges**
```sql
SELECT user, host FROM mysql.user WHERE user='root';
-- Should have root@% (% = any host)
```

### **"Access Denied" error:**

```sql
-- Grant privileges again
GRANT ALL PRIVILEGES ON banksampahdigital.* TO 'root'@'%';
FLUSH PRIVILEGES;
```

### **"Can't connect to MySQL server":**

**Check MySQL is running:**
```powershell
# Check if MySQL service is running
netstat -an | findstr "3306"
```

**Ping test:**
```powershell
# From Laptop B
ping 192.168.1.100
```

---

## 📝 **Testing Script**

Save as `scripts/test_connection.php`:

```php
<?php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $pdo = DB::connection()->getPdo();
    echo "✅ Database connection successful!\n";
    echo "📊 Database: " . config('database.connections.mysql.database') . "\n";
    echo "🖥️  Host: " . config('database.connections.mysql.host') . "\n";
    
    $users = DB::table('users')->count();
    echo "👥 Total users: $users\n";
    
} catch (\Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
}
```

Run:
```bash
php scripts/test_connection.php
```

---

## 📊 **Architecture Options**

### **Option 1: Shared Database**
```
Laptop A (DB Server)          Laptop B (Client)
├── MySQL Server              ├── Laravel App
├── Laravel App               └── Connect to Laptop A DB
└── Database: banksampahdigital
```

### **Option 2: Cloud Database**
```
Laptop A                      Cloud (PlanetScale/AWS)      Laptop B
├── Laravel App               ├── MySQL Database           ├── Laravel App
└── Connect to Cloud -------> │   banksampahdigital  <----- └── Connect to Cloud
```

### **Option 3: Separate Databases (Current)**
```
Laptop A                      Laptop B
├── MySQL (Local)             ├── MySQL (Local)
├── DB: banksampahdigital     ├── DB: banksampahdigital
└── Users: A, B, C            └── Users: X, Y, Z
    ❌ Not synchronized
```

---

## ✅ **Recommended Workflow**

**For Development Team (2-3 people):**
1. Use **Opsi 1 (Shared Database via Network)**
2. 1 laptop sebagai "Development Server"
3. Laptop lain connect ke server ini

**For Production Deployment:**
1. Use **Opsi 3 (Cloud Database)**
2. Deploy Laravel app to hosting (Heroku/Vercel/VPS)
3. All users access via internet

---

## 🎓 **Kesimpulan**

**Problem:**
- Database lokal = data tidak sync antar laptop

**Solution:**
1. **Quick Fix:** Export/Import users manual
2. **Best for Team:** Shared database via network
3. **Best for Production:** Cloud database

**Recommended Next Steps:**
1. Setup shared database (Opsi 1) untuk development
2. Nanti saat deploy production → migrate ke cloud database

---

**Created:** November 24, 2025
