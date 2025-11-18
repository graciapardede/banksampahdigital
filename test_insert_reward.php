<?php

/**
 * Script untuk test insert reward item langsung ke database
 * Jalankan: php test_insert_reward.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\RewardItem;

echo "=== Test Insert Reward Item ===\n\n";

try {
    // Test data
    $data = [
        'name' => 'Test Barang ' . date('H:i:s'),
        'description' => 'Barang test dari script',
        'points_cost' => 100,
        'stock' => 50,
        'branch_id' => 1,
        'image' => 'test_image.png'
    ];
    
    echo "Data yang akan diinsert:\n";
    print_r($data);
    echo "\n";
    
    $item = RewardItem::create($data);
    
    echo "✅ SUCCESS! Reward item berhasil ditambahkan!\n";
    echo "ID: " . $item->id . "\n";
    echo "Nama: " . $item->name . "\n";
    echo "Poin: " . $item->points_cost . "\n";
    echo "Stok: " . $item->stock . "\n\n";
    
    echo "Cek di browser: http://127.0.0.1:8000/admin/reward-items\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
