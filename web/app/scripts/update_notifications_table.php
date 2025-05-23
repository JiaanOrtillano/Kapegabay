<?php
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../../database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS notifications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        message TEXT NOT NULL,
        image TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $db->exec($sql);
    echo "Notifications table created successfully!";
} catch (PDOException $e) {
    echo "Error creating notifications table: " . $e->getMessage();
} 