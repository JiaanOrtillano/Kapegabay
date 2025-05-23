<?php
require_once __DIR__ . '/../config/database.php';
use root_dev\Config\Database;

try {
    $db = Database::connect();
    
    // Create dummy users with different roles
    $dummyUsers = [
        [
            'username' => 'admin1',
            'email' => 'admin1@example.com',
            'password' => 'admin123',
            'role' => 'admin'
        ],
        [
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => 'user123',
            'role' => 'user'
        ],
        [
            'username' => 'user2',
            'email' => 'user2@example.com',
            'password' => 'user123',
            'role' => 'user'
        ]
    ];

    foreach ($dummyUsers as $user) {
        // Check if user exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$user['email']]);
        
        if (!$stmt->fetch()) {
            // Create user
            $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
            $stmt = $db->prepare("
                INSERT INTO users (username, email, password, role, created_at) 
                VALUES (?, ?, ?, ?, datetime('now'))
            ");
            $stmt->execute([$user['username'], $user['email'], $hashedPassword, $user['role']]);
            echo "✅ Created user: {$user['username']} (Role: {$user['role']})\n";
        } else {
            echo "⚠️ User {$user['username']} already exists\n";
        }
    }

    echo "\nDummy user credentials:\n";
    echo "Admin:\n";
    echo "Email: admin1@example.com\n";
    echo "Password: admin123\n\n";
    echo "Regular Users:\n";
    echo "Email: user1@example.com\n";
    echo "Password: user123\n";
    echo "Email: user2@example.com\n";
    echo "Password: user123\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 