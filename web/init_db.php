<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';

use root_dev\Config\Database;

try {
    // Create database connection
    $pdo = Database::connect();
    
    // Drop existing tables
    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("DROP TABLE IF EXISTS admins");
    
    // Run migrations
    require_once __DIR__ . '/migrations/2024_03_19_000001_create_admins_table.php';
    require_once __DIR__ . '/migrations/2025_04_04_184533_faculty_table.php';
    
    $adminMigration = new CreateAdminsTable();
    $adminMigration->up($pdo);
    
    $userMigration = new CreateUsersTable();
    $userMigration->up($pdo);
    
    echo "✅ Database initialized successfully!\n";
    echo "Database file created at: " . DB_PATH . "\n";
    
} catch (Exception $e) {
    echo "❌ Error initializing database: " . $e->getMessage() . "\n";
} 