<?php
/**
 * Test Database Connection
 * 
 * Run: php scripts/test_connection.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🔍 Testing Database Connection...\n";
echo "========================================\n\n";

try {
    // Test connection
    $pdo = DB::connection()->getPdo();
    
    echo "✅ Database connection successful!\n\n";
    
    // Show configuration
    echo "📋 Configuration:\n";
    echo "   Connection: " . config('database.default') . "\n";
    echo "   Host: " . config('database.connections.mysql.host') . "\n";
    echo "   Port: " . config('database.connections.mysql.port') . "\n";
    echo "   Database: " . config('database.connections.mysql.database') . "\n";
    echo "   Username: " . config('database.connections.mysql.username') . "\n\n";
    
    // Test queries
    echo "📊 Database Stats:\n";
    
    $users = DB::table('users')->count();
    echo "   👥 Total users: $users\n";
    
    $deposits = DB::table('deposits')->count();
    echo "   📦 Total deposits: $deposits\n";
    
    $redemptions = DB::table('redemptions')->count();
    echo "   🎁 Total redemptions: $redemptions\n";
    
    $rewardItems = DB::table('reward_items')->count();
    echo "   🏆 Total reward items: $rewardItems\n";
    
    $branches = DB::table('branches')->count();
    echo "   🏢 Total branches: $branches\n\n";
    
    // Show recent users
    echo "👤 Recent Users (last 5):\n";
    $recentUsers = DB::table('users')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get(['id', 'name', 'email', 'role']);
    
    foreach ($recentUsers as $user) {
        echo "   - [{$user->id}] {$user->name} ({$user->email}) - Role: {$user->role}\n";
    }
    
    echo "\n✅ All checks passed!\n";
    
} catch (\Exception $e) {
    echo "❌ Connection failed!\n\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    
    echo "💡 Troubleshooting:\n";
    echo "   1. Check if MySQL is running\n";
    echo "   2. Verify .env database credentials\n";
    echo "   3. Run: php artisan config:clear\n";
    echo "   4. Check firewall if connecting to remote DB\n\n";
    
    exit(1);
}
