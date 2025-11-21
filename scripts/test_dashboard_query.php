<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== TESTING DASHBOARD QUERY ===\n\n";

// Test query yang sekarang ada di controller
$totalWarga = User::where('role', 'warga')->count();
echo "Total Warga (no filter): $totalWarga\n";

// Test dengan branch filter
echo "\n=== TESTING BRANCH FILTER ===\n";
$branches = DB::table('users')
    ->select('branch_id', DB::raw('count(*) as count'))
    ->where('role', 'warga')
    ->groupBy('branch_id')
    ->get();

foreach ($branches as $branch) {
    $branchName = $branch->branch_id ? "Branch ID {$branch->branch_id}" : "No Branch";
    echo "$branchName: {$branch->count} warga\n";
}

// Test admin info
echo "\n=== ADMIN INFO ===\n";
$admins = User::where('role', 'admin')->get(['id', 'name', 'email', 'branch_id']);
foreach ($admins as $admin) {
    echo "Admin: {$admin->name} (ID: {$admin->id}) - Branch ID: " . ($admin->branch_id ?? 'NULL') . "\n";
}

?>
