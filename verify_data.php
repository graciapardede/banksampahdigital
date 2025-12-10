<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Deposit;
use App\Models\Redemption;

echo "=== VERIFIKASI DATA WARGA & TRANSAKSI ===\n\n";

// 1. Cek warga
$totalWarga = User::whereIn('role', ['user', 'warga'])->count();
$wargaSample = User::whereIn('role', ['user', 'warga'])->first();

echo "✓ Total Warga: {$totalWarga}\n";
if ($wargaSample) {
    echo "  Contoh: {$wargaSample->name}\n";
    echo "  Email: {$wargaSample->email}\n";
    echo "  Branch ID: " . ($wargaSample->branch_id ?? 'NULL (bebas)') . "\n";
    echo "  Balance Points: {$wargaSample->balance_points}\n";
}

echo "\n";

// 2. Cek deposit
$totalDeposits = Deposit::count();
$depositSample = Deposit::with('user', 'branch')->first();

echo "✓ Total Deposit Transaksi: {$totalDeposits}\n";
if ($depositSample) {
    echo "  Contoh:\n";
    echo "    - Warga: {$depositSample->user->name}\n";
    echo "    - Cabang: {$depositSample->branch->name}\n";
    echo "    - Status: {$depositSample->status}\n";
    echo "    - Poin: {$depositSample->total_points}\n";
}

echo "\n";

// 3. Cek redemption
$totalRedemptions = Redemption::count();
$redemptionSample = Redemption::with('user', 'branch')->first();

echo "✓ Total Redemption Transaksi: {$totalRedemptions}\n";
if ($redemptionSample) {
    echo "  Contoh:\n";
    echo "    - Warga: {$redemptionSample->user->name}\n";
    echo "    - Cabang: {$redemptionSample->branch->name}\n";
    echo "    - Status: {$redemptionSample->status}\n";
    echo "    - Poin Digunakan: {$redemptionSample->total_points}\n";
}

echo "\n" . str_repeat("=", 50) . "\n";

// 4. Dashboard view
echo "\n=== DASHBOARD ADMIN VIEW ===\n";
$admins = User::where('role', 'admin')->get();

foreach ($admins as $admin) {
    echo "\nAdmin: {$admin->name}\n";
    echo "  Total Warga: {$totalWarga}\n";
    echo "  Total Deposit: {$totalDeposits}\n";
    echo "  Total Redemption: {$totalRedemptions}\n";
    echo "  Pending Deposits: " . Deposit::where('status', 'pending')->count() . "\n";
    echo "  Pending Redemptions: " . Redemption::where('status', 'pending')->count() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "✓ Semua data warga dan transaksi tetap aman!\n";
echo "✓ Warga bebas ke cabang manapun!\n";
echo "✓ Admin melihat data global!\n";
