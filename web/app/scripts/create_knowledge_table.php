<?php
require_once __DIR__ . '/../../config/database.php';
use root_dev\Config\Database;

try {
    $db = Database::connect();
    
    // Create knowledge table
    $sql = "CREATE TABLE IF NOT EXISTS knowledge (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        coffee_type TEXT NOT NULL,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        image TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->exec($sql);
    echo "Knowledge table created successfully!";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
} 