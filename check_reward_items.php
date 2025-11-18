<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\RewardItem;

echo "=== Checking Reward Items in Database ===\n\n";

$items = RewardItem::orderBy('id', 'desc')->take(5)->get();

if ($items->isEmpty()) {
    echo "❌ No items found in database!\n";
} else {
    echo "✅ Found " . $items->count() . " items:\n\n";
    foreach ($items as $item) {
        echo "ID: {$item->id}\n";
        echo "Name: {$item->name}\n";
        echo "Points: {$item->points_cost}\n";
        echo "Stock: {$item->stock}\n";
        echo "Image: {$item->image}\n";
        echo "Created: {$item->created_at}\n";
        echo "-------------------\n";
    }
}
