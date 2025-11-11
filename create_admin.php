<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Check if admin exists
$adminEmail = 'admin@banksampah.com';
$admin = User::where('email', $adminEmail)->first();

if ($admin) {
    echo "Admin user already exists:\n";
    echo "Email: {$admin->email}\n";
    echo "Name: {$admin->name}\n";
    echo "Role: {$admin->role}\n";
    echo "\nUpdating password to 'admin123'...\n";
    $admin->password = Hash::make('admin123');
    $admin->save();
    echo "Password updated successfully!\n";
} else {
    echo "Creating new admin user...\n";
    $admin = User::create([
        'name' => 'Admin',
        'email' => $adminEmail,
        'password' => Hash::make('admin123'),
        'phone' => '081234567890',
        'address' => 'Alamat Admin',
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    echo "Admin user created successfully!\n";
}

echo "\n=== Login Credentials ===\n";
echo "Email: admin@banksampah.com\n";
echo "Password: admin123\n";
echo "========================\n";
