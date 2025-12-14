<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== CLEAR BRANCH_ID WARGA ===\n\n";

// Get all warga
$warga = User::whereIn('role', ['user', 'warga'])->get();
$totalWarga = $warga->count();

echo "Total warga sebelum clear: {$totalWarga}\n";
echo "Proses clearing branch_id...\n\n";

$updated = 0;
foreach ($warga as $user) {
    if ($user->branch_id !== null) {
        $oldBranch = $user->branch_id;
        $user->update(['branch_id' => null]);
        $updated++;
        echo "✓ {$user->name} (Branch ID: {$oldBranch} → NULL)\n";
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "Total warga yang di-clear: {$updated}\n";
echo "✓ Selesai!\n";
echo str_repeat("=", 50) . "\n";

// Verify
echo "\n=== VERIFIKASI ===\n";
$withBranch = User::whereIn('role', ['user', 'warga'])->whereNotNull('branch_id')->count();
$withoutBranch = User::whereIn('role', ['user', 'warga'])->whereNull('branch_id')->count();

echo "Warga dengan branch_id: {$withBranch}\n";
echo "Warga tanpa branch_id (bebas): {$withoutBranch}\n";

if ($withoutBranch === $totalWarga) {
    echo "\n✓ Semua warga sekarang bebas (tidak terikat cabang)!\n";
} else {
    echo "\nAda yang salah, cek lagi.\n";
}
