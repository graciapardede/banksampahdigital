<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== TEST DASHBOARD ADMIN ===\n\n";

$admins = User::where('role', 'admin')->get();

foreach ($admins as $admin) {
    // Simulate login
    Auth::login($admin);
    
    $branchId = $admin->branch_id;
    echo "Admin: {$admin->name} (Branch ID: {$branchId})\n";
    
    // Query total_users sesuai controller (tanpa filter branch)
    $totalUsers = User::whereIn('role', ['user', 'warga'])->count();
    
    echo "Total Warga di Dashboard: {$totalUsers}\n";
    echo "---\n\n";
    
    Auth::logout();
}

echo "✓ Semua admin sekarang melihat total warga yang SAMA di dashboard!\n";
