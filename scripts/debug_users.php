<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== USER STATISTICS ===\n\n";

$totalUsers = User::count();
echo "Total All Users: $totalUsers\n";

$adminCount = User::where('role', 'admin')->count();
echo "Admin Count: $adminCount\n";

$nonAdminCount = User::where('role', '!=', 'admin')->count();
echo "Non-Admin Count (Warga): $nonAdminCount\n";

$userRoleCount = User::where('role', 'user')->count();
echo "Role 'user' Count: $userRoleCount\n";

echo "\n=== ROLES DISTRIBUTION ===\n";
$roles = DB::table('users')
    ->select('role', DB::raw('count(*) as count'))
    ->groupBy('role')
    ->get();

foreach ($roles as $role) {
    echo "Role '{$role->role}': {$role->count} users\n";
}

echo "\n=== SAMPLE USERS ===\n";
$users = User::limit(5)->get(['id', 'name', 'email', 'role']);
foreach ($users as $u) {
    echo "ID {$u->id}: {$u->name} ({$u->email}) - Role: '{$u->role}'\n";
}

?>
