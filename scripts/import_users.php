<?php
/**
 * Import Users from JSON
 * 
 * Run: php scripts/import_users.php users_export_2024-11-24_120000.json
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

if ($argc < 2) {
    echo "❌ Usage: php scripts/import_users.php <json_file>\n";
    echo "Example: php scripts/import_users.php users_export_2024-11-24_120000.json\n";
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
    // Read JSON
    $users = json_decode(file_get_contents($jsonFile), true);
    
    if (!$users) {
        throw new Exception("Invalid JSON format");
    }
    
    $imported = 0;
    $skipped = 0;
    
    foreach ($users as $userData) {
        // Check if user already exists
        $existing = User::where('email', $userData['email'])->first();
        
        if ($existing) {
            echo "⏭️  Skipped: {$userData['email']} (already exists)\n";
            $skipped++;
            continue;
        }
        
        // Import user
        User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'], // Already hashed
            'phone' => $userData['phone'] ?? null,
            'role' => $userData['role'],
            'balance_points' => $userData['balance_points'] ?? 0,
            'branch_id' => $userData['branch_id'] ?? null,
            'profile_photo' => $userData['profile_photo'] ?? null,
            'email_verified_at' => $userData['email_verified_at'] ?? null,
            'created_at' => $userData['created_at'],
            'updated_at' => $userData['updated_at'],
        ]);
        
        echo "✅ Imported: {$userData['email']}\n";
        $imported++;
    }
    
    echo "\n";
    echo "📊 Summary:\n";
    echo "   Imported: $imported users\n";
    echo "   Skipped: $skipped users\n";
    echo "   Total: " . count($users) . " users\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
