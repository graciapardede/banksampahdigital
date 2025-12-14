<?php

// Boot the Laravel app and print basic user info (safe read-only script)
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$count = User::count();
echo "Users count: $count\n";
$users = User::limit(5)->get(['id','full_name','email']);
foreach ($users as $u) {
    echo "#{$u->id}: {$u->full_name} <{$u->email}>\n";
}
 
?>