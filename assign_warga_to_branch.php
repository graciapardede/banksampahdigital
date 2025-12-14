<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Branch;

echo "=== ASSIGN WARGA KE CABANG ===\n\n";

// Get all branches
$branches = Branch::all();
if ($branches->isEmpty()) {
    echo "Tidak ada cabang di database. Silakan buat cabang terlebih dahulu.\n";
    exit;
}

echo "Cabang yang tersedia:\n";
foreach ($branches as $branch) {
    echo "- ID {$branch->id}: {$branch->name}\n";
}
echo "\n";

// Get all warga without branch_id
$warga = User::whereIn('role', ['user', 'warga'])->whereNull('branch_id')->get();
$totalWarga = $warga->count();

if ($totalWarga === 0) {
    echo "✓ Semua warga sudah terdaftar di cabang.\n";
    exit;
}

echo "Warga yang belum terdaftar di cabang: {$totalWarga}\n";
echo "Akan di-assign secara merata ke " . $branches->count() . " cabang.\n\n";

// Split warga evenly across branches
$wargaPerBranch = ceil($totalWarga / $branches->count());
$counter = 0;

foreach ($branches as $branchIndex => $branch) {
    $startIdx = $branchIndex * $wargaPerBranch;
    $endIdx = min($startIdx + $wargaPerBranch, $totalWarga);
    
    for ($i = $startIdx; $i < $endIdx; $i++) {
        if (isset($warga[$i])) {
            $user = $warga[$i];
            $user->update(['branch_id' => $branch->id]);
            $counter++;
            echo "✓ {$user->name} → {$branch->name}\n";
        }
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "Total warga yang di-assign: {$counter}\n";
echo "✓ Selesai!\n";
echo str_repeat("=", 50) . "\n";

// Verify
echo "\n=== VERIFIKASI ===\n";
foreach ($branches as $branch) {
    $count = User::where('branch_id', $branch->id)->count();
    echo "{$branch->name}: {$count} warga\n";
}
