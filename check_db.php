<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== WASTE TYPES DATABASE CHECK ===\n\n";
foreach(DB::table('waste_types')->get() as $w) {
    echo "ID: {$w->id}\n";
    echo "Name: {$w->name}\n";
    echo "Image: " . ($w->image ?? 'NULL') . "\n";
    echo "Points: {$w->points_per_unit}\n";
    echo str_repeat('-', 50) . "\n";
}
