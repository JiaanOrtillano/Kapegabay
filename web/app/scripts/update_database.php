<?php
try {
    // Connect directly to the SQLite database file
    $db = new PDO('sqlite:' . __DIR__ . '/../../database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop existing knowledge table if it exists
    $db->exec("DROP TABLE IF EXISTS knowledge");
    
    // Create knowledge table with new structure
    $sql = "CREATE TABLE knowledge (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        coffee_type TEXT NOT NULL,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        image TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $db->exec($sql);
    echo "Database updated successfully! Knowledge table has been recreated.";
    
} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage();
} 