<?php
// Migration script to create 'system' table and insert default values

$db = new PDO('sqlite:database.sqlite');

// Create the system table if it doesn't exist
$db->exec('CREATE TABLE IF NOT EXISTS system (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    logo TEXT,
    platform_name TEXT,
    language TEXT
)');

// Check if a row already exists
$result = $db->query('SELECT COUNT(*) as count FROM system');
$count = $result->fetch(PDO::FETCH_ASSOC)['count'];

if ($count == 0) {
    // Insert default row
    $stmt = $db->prepare('INSERT INTO system (logo, platform_name, language) VALUES (?, ?, ?)');
    $stmt->execute(['', 'KapeGababy', 'English']);
    echo "Default system settings inserted.\n";
} else {
    echo "System table already has data.\n";
}

echo "Migration complete.\n"; 