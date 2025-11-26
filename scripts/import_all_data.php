<?php
/**
 * Import ALL Database Data
 * Import semua data dari file JSON export
 * 
 * Run: php scripts/import_all_data.php full_database_export_2025-11-24_120000.json
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

if ($argc < 2) {
    echo "❌ Usage: php scripts/import_all_data.php <json_file>\n";
    echo "Example: php scripts/import_all_data.php full_database_export_2025-11-24_120000.json\n";
    exit(1);
}

$jsonFile = $argv[1];

// Check if file path is absolute or relative
if (!file_exists($jsonFile)) {
    $jsonFile = __DIR__ . '/' . $jsonFile;
}

if (!file_exists($jsonFile)) {
    echo "❌ File not found: $jsonFile\n";
    exit(1);
}

try {
    echo "📦 Importing all database data...\n";
    echo "========================================\n\n";
    
    // Read JSON
    $data = json_decode(file_get_contents($jsonFile), true);
    
    if (!$data) {
        throw new Exception("Invalid JSON format");
    }
    
    echo "📋 Source Database:\n";
    echo "   Database: {$data['database']}\n";
    echo "   Host: {$data['host']}\n";
    echo "   Exported at: {$data['exported_at']}\n\n";
    
    $stats = [
        'users' => ['imported' => 0, 'skipped' => 0],
        'branches' => ['imported' => 0, 'skipped' => 0],
        'waste_types' => ['imported' => 0, 'skipped' => 0],
        'reward_items' => ['imported' => 0, 'skipped' => 0],
        'deposits' => ['imported' => 0, 'skipped' => 0],
        'deposit_items' => ['imported' => 0, 'skipped' => 0],
        'redemptions' => ['imported' => 0, 'skipped' => 0],
        'redemption_items' => ['imported' => 0, 'skipped' => 0],
        'point_ledgers' => ['imported' => 0, 'skipped' => 0],
        'points_ledger' => ['imported' => 0, 'skipped' => 0],
        'notifications' => ['imported' => 0, 'skipped' => 0],
    ];
    
    // Start transaction
    DB::beginTransaction();
    
    try {
        // 1. Import Branches first (referenced by other tables)
        echo "🏢 Importing branches...\n";
        foreach ($data['branches'] as $branch) {
            $existing = DB::table('branches')->where('id', $branch->id)->first();
            if (!$existing) {
                DB::table('branches')->insert((array)$branch);
                $stats['branches']['imported']++;
            } else {
                $stats['branches']['skipped']++;
            }
        }
        
        // 2. Import Users
        echo "👥 Importing users...\n";
        foreach ($data['users'] as $user) {
            $existing = DB::table('users')->where('id', $user->id)->first();
            if (!$existing) {
                DB::table('users')->insert((array)$user);
                $stats['users']['imported']++;
            } else {
                $stats['users']['skipped']++;
            }
        }
        
        // 3. Import Waste Types
        echo "♻️  Importing waste_types...\n";
        foreach ($data['waste_types'] as $wasteType) {
            $existing = DB::table('waste_types')->where('id', $wasteType->id)->first();
            if (!$existing) {
                DB::table('waste_types')->insert((array)$wasteType);
                $stats['waste_types']['imported']++;
            } else {
                $stats['waste_types']['skipped']++;
            }
        }
        
        // 4. Import Reward Items
        echo "🎁 Importing reward_items...\n";
        foreach ($data['reward_items'] as $rewardItem) {
            $existing = DB::table('reward_items')->where('id', $rewardItem->id)->first();
            if (!$existing) {
                DB::table('reward_items')->insert((array)$rewardItem);
                $stats['reward_items']['imported']++;
            } else {
                $stats['reward_items']['skipped']++;
            }
        }
        
        // 5. Import Deposits
        echo "📥 Importing deposits...\n";
        foreach ($data['deposits'] as $deposit) {
            $existing = DB::table('deposits')->where('id', $deposit->id)->first();
            if (!$existing) {
                DB::table('deposits')->insert((array)$deposit);
                $stats['deposits']['imported']++;
            } else {
                $stats['deposits']['skipped']++;
            }
        }
        
        // 6. Import Deposit Items
        echo "📋 Importing deposit_items...\n";
        foreach ($data['deposit_items'] as $depositItem) {
            $existing = DB::table('deposit_items')->where('id', $depositItem->id)->first();
            if (!$existing) {
                DB::table('deposit_items')->insert((array)$depositItem);
                $stats['deposit_items']['imported']++;
            } else {
                $stats['deposit_items']['skipped']++;
            }
        }
        
        // 7. Import Redemptions
        echo "🎯 Importing redemptions...\n";
        foreach ($data['redemptions'] as $redemption) {
            $existing = DB::table('redemptions')->where('id', $redemption->id)->first();
            if (!$existing) {
                DB::table('redemptions')->insert((array)$redemption);
                $stats['redemptions']['imported']++;
            } else {
                $stats['redemptions']['skipped']++;
            }
        }
        
        // 8. Import Redemption Items
        echo "📝 Importing redemption_items...\n";
        foreach ($data['redemption_items'] as $redemptionItem) {
            $existing = DB::table('redemption_items')->where('id', $redemptionItem->id)->first();
            if (!$existing) {
                DB::table('redemption_items')->insert((array)$redemptionItem);
                $stats['redemption_items']['imported']++;
            } else {
                $stats['redemption_items']['skipped']++;
            }
        }
        
        // 9. Import Point Ledgers
        echo "💰 Importing point_ledgers...\n";
        if (isset($data['point_ledgers'])) {
            foreach ($data['point_ledgers'] as $ledger) {
                $existing = DB::table('point_ledgers')->where('id', $ledger->id)->first();
                if (!$existing) {
                    DB::table('point_ledgers')->insert((array)$ledger);
                    $stats['point_ledgers']['imported']++;
                } else {
                    $stats['point_ledgers']['skipped']++;
                }
            }
        }
        
        // 10. Import Points Ledger
        echo "💵 Importing points_ledger...\n";
        if (isset($data['points_ledger'])) {
            foreach ($data['points_ledger'] as $ledger) {
                $existing = DB::table('points_ledger')->where('id', $ledger->id)->first();
                if (!$existing) {
                    DB::table('points_ledger')->insert((array)$ledger);
                    $stats['points_ledger']['imported']++;
                } else {
                    $stats['points_ledger']['skipped']++;
                }
            }
        }
        
        // 11. Import Notifications
        echo "🔔 Importing notifications...\n";
        foreach ($data['notifications'] as $notification) {
            $existing = DB::table('notifications')->where('id', $notification->id)->first();
            if (!$existing) {
                DB::table('notifications')->insert((array)$notification);
                $stats['notifications']['imported']++;
            } else {
                $stats['notifications']['skipped']++;
            }
        }
        
        // Commit transaction
        DB::commit();
        
        echo "\n========================================\n";
        echo "✅ Import completed successfully!\n\n";
        
        echo "📊 Summary:\n";
        foreach ($stats as $table => $stat) {
            $total = $stat['imported'] + $stat['skipped'];
            echo sprintf("   %-20s: %3d imported, %3d skipped, %3d total\n", 
                ucfirst(str_replace('_', ' ', $table)), 
                $stat['imported'], 
                $stat['skipped'], 
                $total
            );
        }
        
        echo "\n🎉 Database sekarang sudah sync!\n";
        
    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }
    
} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n\n";
    echo "💡 Tip: Pastikan struktur tabel sudah sama (run migrations dulu)\n";
}
