<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Branch;

echo "=== CEK DATA WARGA ===\n\n";

// 1. Cek total users
$totalUsers = User::count();
echo "Total users di database: {$totalUsers}\n";

// 2. Cek user dengan role 'warga' atau 'user'
$wargaUsers = User::whereIn('role', ['user', 'warga'])->count();
echo "Total warga (user/warga role): {$wargaUsers}\n";

// 3. Cek admin
$adminUsers = User::whereIn('role', ['admin'])->count();
echo "Total admin: {$adminUsers}\n\n";

// 4. Detail setiap user
echo "=== DETAIL SEMUA USER ===\n";
$users = User::all();
foreach ($users as $user) {
    echo "\n---\n";
    echo "ID: {$user->id}\n";
    echo "Nama: {$user->name}\n";
    echo "Role: {$user->role}\n";
    echo "Branch ID: " . ($user->branch_id ? $user->branch_id : 'NULL') . "\n";
    if ($user->branch_id) {
        $branch = Branch::find($user->branch_id);
        echo "Branch Name: " . ($branch ? $branch->name : 'NOT FOUND') . "\n";
    }
}

echo "\n\n=== DETAIL SEMUA BRANCH ===\n";
$branches = Branch::all();
foreach ($branches as $branch) {
    echo "\n---\n";
    echo "ID: {$branch->id}\n";
    echo "Nama: {$branch->name}\n";
    echo "Lokasi: {$branch->location}\n";
    // Hitung user di branch ini
    $userCount = User::where('branch_id', $branch->id)->count();
    echo "Jumlah user di branch: {$userCount}\n";
}

echo "\n\n=== RINGKASAN ===\n";
echo "Warga dengan branch_id: " . User::whereIn('role', ['user', 'warga'])->whereNotNull('branch_id')->count() . "\n";
echo "Warga tanpa branch_id: " . User::whereIn('role', ['user', 'warga'])->whereNull('branch_id')->count() . "\n";
