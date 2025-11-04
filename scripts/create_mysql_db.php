<?php
// Simple script to create MySQL database if it doesn't exist.
 $host = '127.0.0.1';
 $port = 3306;
 $user = 'root';
 $pass = 
 $db = 'banksampahdigital';
try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "DB_CREATED_OK\n";
} catch (PDOException $e) {
    echo "DB_ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
