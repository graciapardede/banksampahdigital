<?php
/**
 * Export All Users to JSON
 * 
 * Run: php scripts/export_users.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

try {
    // Get all users
    $users = User::all()->toArray();
    
    // Export to JSON
    $jsonFile = __DIR__ . '/users_export_' . date('Y-m-d_His') . '.json';
    file_put_contents($jsonFile, json_encode($users, JSON_PRETTY_PRINT));
    
    echo "✅ Success! Exported " . count($users) . " users\n";
    echo "📁 File: $jsonFile\n\n";
    echo "Copy file ini ke laptop lain, lalu jalankan import_users.php\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
