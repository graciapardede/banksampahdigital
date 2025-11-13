<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Set admin branch_id
$admin = App\Models\User::where('role', 'admin')->first();

if ($admin) {
    $admin->branch_id = 1; // Set to Cabang Medan Utara
    $admin->save();
    
    // Refresh to load the branch relation
    $admin->refresh();
    $admin->load('branch');
    
    echo "✅ Admin '{$admin->name}' berhasil di-set ke branch_id: {$admin->branch_id}\n";
    
    // Use getRelation to specifically access the branch relationship, not the old string field
    $branchRelation = $admin->getRelation('branch');
    if ($branchRelation) {
        echo "   Branch: {$branchRelation->name}\n";
        echo "   Alamat: {$branchRelation->address}\n";
    } else {
        echo "   Branch: (Relasi belum ter-load)\n";
    }
} else {
    echo "❌ Admin tidak ditemukan\n";
}
