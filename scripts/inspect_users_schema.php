<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Create kernel and boot
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$connection = DB::connection()->getName();
$columns = Schema::getColumnListing('users');

echo "Connection: $connection\n";
echo "Users columns (" . count($columns) . "):\n";
foreach ($columns as $col) {
    echo "- $col\n";
}

// Print foreign keys info for users (Postgres)
try {
    $sm = DB::getDoctrineSchemaManager();
    $foreignKeys = $sm->listTableForeignKeys('users');
    echo "\nForeign keys:\n";
    foreach ($foreignKeys as $fk) {
        echo "- ({" . implode(',', $fk->getLocalColumns()) . "}) -> " . $fk->getForeignTableName() . "(" . implode(',', $fk->getForeignColumns()) . ")\n";
    }
} catch (Exception $e) {
    // Doctrine may not be available for some drivers
}
