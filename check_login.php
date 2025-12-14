<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== CHECK LOGIN ISSUE ===\n\n";

// 1. Cek total users
$totalUsers = User::count();
echo "Total users in database: {$totalUsers}\n\n";

if ($totalUsers === 0) {
    echo "NO USERS FOUND! Database kosong.\n";
    echo "Silakan jalankan seeder atau buat user manual.\n";
    exit;
}

// 2. List semua users
echo "=== LIST ALL USERS ===\n";
$users = User::all();
foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "Password Hash: " . substr($user->password, 0, 50) . "...\n";
    echo "-------------------\n";
}

// 3. Test password untuk email yang di screenshot
$testEmail = 'admin.sitoluama@greensaving.com';
$testPassword = 'password'; // ganti dengan password yang Anda coba

echo "\n=== TEST LOGIN FOR: {$testEmail} ===\n";

$user = User::where('email', $testEmail)->first();

if (!$user) {
    echo "User dengan email '{$testEmail}' TIDAK DITEMUKAN!\n";
    echo "Email yang tersedia:\n";
    User::all()->pluck('email')->each(function($email) {
        echo "  - {$email}\n";
    });
} else {
    echo "User ditemukan!\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n\n";
    
    // Test password
    echo "Testing password: '{$testPassword}'\n";
    
    if (Hash::check($testPassword, $user->password)) {
        echo "PASSWORD MATCH! Login seharusnya berhasil.\n";
    } else {
        echo "PASSWORD TIDAK MATCH!\n";
        echo "Password hash di database: {$user->password}\n";
        echo "\nCoba password lain:\n";
        
        $commonPasswords = ['password', '12345678', 'admin123', 'password123'];
        foreach ($commonPasswords as $pw) {
            if (Hash::check($pw, $user->password)) {
                echo "PASSWORD YANG BENAR: '{$pw}'\n";
                break;
            }
        }
    }
}

echo "\n=== HASH NEW PASSWORD (untuk reset) ===\n";
echo "Password 'password' hash: " . Hash::make('password') . "\n";
echo "Password 'admin123' hash: " . Hash::make('admin123') . "\n";
