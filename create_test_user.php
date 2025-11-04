<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Load Laravel application
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Create or update test user
$email = 'test@example.com';
$password = 'password123';

$user = User::where('email', $email)->first();

if ($user) {
    // Update existing user
    $user->update([
        'password' => Hash::make($password),
        'role' => 'warga'
    ]);
    echo "Updated existing user: $email\n";
} else {
    // Create new user
    $user = User::create([
        'name' => 'Test User',
        'full_name' => 'Test User',
        'email' => $email,
        'password' => Hash::make($password),
        'role' => 'warga',
        'balance_points' => 0,
    ]);
    echo "Created new user: $email\n";
}

echo "Email: $email\n";
echo "Password: $password\n";
echo "Role: " . $user->role . "\n";
echo "User ID: " . $user->id . "\n";