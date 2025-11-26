<?php
/**
 * Export ALL Database Data
 * Export semua data dari semua tabel penting
 * 
 * Run: php scripts/export_all_data.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "📦 Exporting all database data...\n";
    echo "========================================\n\n";
    
    $exportData = [
        'exported_at' => now()->toDateTimeString(),
        'database' => config('database.connections.mysql.database'),
        'host' => config('database.connections.mysql.host'),
    ];
    
    // 1. Export Users
    echo "👥 Exporting users... ";
    $exportData['users'] = DB::table('users')->get()->toArray();
    echo count($exportData['users']) . " records\n";
    
    // 2. Export Branches
    echo "🏢 Exporting branches... ";
    $exportData['branches'] = DB::table('branches')->get()->toArray();
    echo count($exportData['branches']) . " records\n";
    
    // 3. Export Waste Types
    echo "♻️  Exporting waste_types... ";
    $exportData['waste_types'] = DB::table('waste_types')->get()->toArray();
    echo count($exportData['waste_types']) . " records\n";
    
    // 4. Export Reward Items
    echo "🎁 Exporting reward_items... ";
    $exportData['reward_items'] = DB::table('reward_items')->get()->toArray();
    echo count($exportData['reward_items']) . " records\n";
    
    // 5. Export Deposits
    echo "📥 Exporting deposits... ";
    $exportData['deposits'] = DB::table('deposits')->get()->toArray();
    echo count($exportData['deposits']) . " records\n";
    
    // 6. Export Deposit Items
    echo "📋 Exporting deposit_items... ";
    $exportData['deposit_items'] = DB::table('deposit_items')->get()->toArray();
    echo count($exportData['deposit_items']) . " records\n";
    
    // 7. Export Redemptions
    echo "🎯 Exporting redemptions... ";
    $exportData['redemptions'] = DB::table('redemptions')->get()->toArray();
    echo count($exportData['redemptions']) . " records\n";
    
    // 8. Export Redemption Items
    echo "📝 Exporting redemption_items... ";
    $exportData['redemption_items'] = DB::table('redemption_items')->get()->toArray();
    echo count($exportData['redemption_items']) . " records\n";
    
    // 9. Export Point Ledgers
    echo "💰 Exporting point_ledgers... ";
    $exportData['point_ledgers'] = DB::table('point_ledgers')->get()->toArray();
    echo count($exportData['point_ledgers']) . " records\n";
    
    // 10. Export Points Ledger (alternative table)
    echo "💵 Exporting points_ledger... ";
    $exportData['points_ledger'] = DB::table('points_ledger')->get()->toArray();
    echo count($exportData['points_ledger']) . " records\n";
    
    // 11. Export Notifications
    echo "🔔 Exporting notifications... ";
    $exportData['notifications'] = DB::table('notifications')->get()->toArray();
    echo count($exportData['notifications']) . " records\n";
    
    // Save to JSON file
    $filename = 'full_database_export_' . date('Y-m-d_His') . '.json';
    $filepath = __DIR__ . '/' . $filename;
    
    file_put_contents($filepath, json_encode($exportData, JSON_PRETTY_PRINT));
    
    echo "\n========================================\n";
    echo "✅ Success! Full database exported\n";
    echo "📁 File: $filepath\n";
    echo "📊 File size: " . round(filesize($filepath) / 1024, 2) . " KB\n\n";
    
    echo "📋 Summary:\n";
    echo "   Users: " . count($exportData['users']) . "\n";
    echo "   Branches: " . count($exportData['branches']) . "\n";
    echo "   Waste Types: " . count($exportData['waste_types']) . "\n";
    echo "   Reward Items: " . count($exportData['reward_items']) . "\n";
    echo "   Deposits: " . count($exportData['deposits']) . "\n";
    echo "   Deposit Items: " . count($exportData['deposit_items']) . "\n";
    echo "   Redemptions: " . count($exportData['redemptions']) . "\n";
    echo "   Redemption Items: " . count($exportData['redemption_items']) . "\n";
    echo "   Point Ledgers: " . count($exportData['point_ledgers']) . "\n";
    echo "   Points Ledger: " . count($exportData['points_ledger']) . "\n";
    echo "   Notifications: " . count($exportData['notifications']) . "\n\n";
    
    echo "🚀 Next step:\n";
    echo "   Copy file '$filename' ke laptop lain\n";
    echo "   Lalu jalankan: php scripts/import_all_data.php $filename\n";
    
} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
