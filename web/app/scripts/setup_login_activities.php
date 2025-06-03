<?php
require_once __DIR__ . '/../../config/database.php';
use root_dev\Config\Database;

try {
    $db = Database::connect();
    
    // Create login_activities table
    $sql = "CREATE TABLE IF NOT EXISTS login_activities (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        username TEXT NOT NULL,
        role TEXT NOT NULL,
        login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
        ip_address TEXT,
        user_agent TEXT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    
    $db->exec($sql);
    echo "✅ Login activities table created successfully!\n";
} catch (PDOException $e) {
    echo "❌ Error creating login activities table: " . $e->getMessage() . "\n";
} 