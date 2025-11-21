<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$totalUsers = User::count();
echo "Total Users: $totalUsers\n\n";

$roles = User::select('role', DB::raw('count(*) as count'))
    ->groupBy('role')
    ->get();

echo "Users by Role:\n";
foreach ($roles as $role) {
    echo "- {$role->role}: {$role->count}\n";
}

echo "\nSample users:\n";
$users = User::limit(10)->get(['id', 'name', 'role', 'branch_id']);
foreach ($users as $u) {
    echo "#{$u->id}: {$u->name} - Role: {$u->role} - Branch: {$u->branch_id}\n";
}

?>
