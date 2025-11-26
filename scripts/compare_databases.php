<?php
/**
 * Compare Database Contents
 * 
 * Compare record counts between exported JSON and current database
 * 
 * Run: php scripts/compare_databases.php full_database_export_2025-11-24_093801.json
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

if ($argc < 2) {
    echo "❌ Usage: php scripts/compare_databases.php <json_file>\n";
    echo "Example: php scripts/compare_databases.php full_database_export_2025-11-24_093801.json\n";
    exit(1);
}

$jsonFile = $argv[1];

// Check if file path is absolute or relative
if (!file_exists($jsonFile)) {
    $jsonFile = __DIR__ . '/' . basename($jsonFile);
}

if (!file_exists($jsonFile)) {
    echo "❌ File not found: $jsonFile\n";
    exit(1);
}

try {
    // Read exported data
    $exportedData = json_decode(file_get_contents($jsonFile), true);
    
    if (!$exportedData) {
        throw new Exception("Invalid JSON format");
    }
    
    echo "🔍 Comparing Database Contents\n";
    echo "========================================\n\n";
    
    echo "📊 Comparison Results:\n\n";
    
    $tables = [
        'users' => '👥 Users',
        'branches' => '🏢 Branches',
        'waste_types' => '♻️  Waste Types',
        'reward_items' => '🎁 Reward Items',
        'deposits' => '📥 Deposits',
        'deposit_items' => '📋 Deposit Items',
        'redemptions' => '🎯 Redemptions',
        'redemption_items' => '📝 Redemption Items',
        'point_ledgers' => '💰 Point Ledgers',
        'notifications' => '🔔 Notifications'
    ];
    
    $totalDiff = 0;
    
    foreach ($tables as $table => $label) {
        $exportedCount = count($exportedData[$table] ?? []);
        $currentCount = DB::table($table)->count();
        $diff = $exportedCount - $currentCount;
        
        $diffSymbol = $diff > 0 ? "⚠️  +" : ($diff < 0 ? "✓ " : "✅");
        $diffText = $diff != 0 ? " (diff: $diff)" : "";
        
        echo sprintf("%-20s: Exported: %3d | Current: %3d %s %s\n", 
            $label, $exportedCount, $currentCount, $diffSymbol, $diffText);
        
        $totalDiff += abs($diff);
    }
    
    echo "\n========================================\n";
    
    if ($totalDiff == 0) {
        echo "✅ Databases are in sync! No differences found.\n";
    } else {
        echo "⚠️  Total differences: $totalDiff records\n";
        echo "💡 Run import script to sync databases:\n";
        echo "   php scripts/import_all_data.php " . basename($jsonFile) . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
