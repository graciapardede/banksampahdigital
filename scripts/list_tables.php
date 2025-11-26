<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$tables = DB::select('SHOW TABLES');
$dbName = config('database.connections.mysql.database');
$key = "Tables_in_$dbName";

echo "📋 Tables in database:\n";
foreach ($tables as $table) {
    echo "   - " . $table->$key . "\n";
}
