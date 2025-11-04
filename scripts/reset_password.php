<?php

// Reset user password script (use only locally)
if ($argc < 3) {
    echo "Usage: php reset_password.php email new_password\n";
    exit(1);
}

$email = $argv[1];
$newPassword = $argv[2];

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', $email)->first();
if (! $user) {
    echo "User with email $email not found.\n";
    exit(1);
}

$user->password = Hash::make($newPassword);
$user->save();

echo "Password for {$user->email} updated successfully.\n";

?>