<?php
require_once __DIR__ . '/../config/database.php';
use root_dev\Config\Database;

try {
    $db = Database::connect();
    
    // Create messages table
    $db->exec("
        CREATE TABLE IF NOT EXISTS messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            sender_id INTEGER NOT NULL,
            receiver_id INTEGER NOT NULL,
            message TEXT NOT NULL,
            is_read INTEGER DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
        )
    ");
    echo "✅ Messages table created successfully\n";

    // Add dummy users if they don't exist
    $dummyUsers = [
        ['username' => 'john_doe', 'email' => 'john@example.com', 'password' => 'password123'],
        ['username' => 'jane_smith', 'email' => 'jane@example.com', 'password' => 'password123'],
        ['username' => 'bob_wilson', 'email' => 'bob@example.com', 'password' => 'password123'],
        ['username' => 'alice_brown', 'email' => 'alice@example.com', 'password' => 'password123'],
        ['username' => 'charlie_davis', 'email' => 'charlie@example.com', 'password' => 'password123']
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
                VALUES (?, ?, ?, 'user', datetime('now'))
            ");
            $stmt->execute([$user['username'], $user['email'], $hashedPassword]);
            echo "✅ Created user: {$user['username']}\n";
        }
    }

    // Add some sample messages
    $stmt = $db->query("SELECT id FROM users LIMIT 5");
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (count($userIds) >= 2) {
        $sampleMessages = [
            "Hello! How can I help you today?",
            "I have a question about my account.",
            "Sure, what would you like to know?",
            "Can you explain how to use the new features?",
            "Of course! Let me walk you through it.",
            "Thanks for your help!",
            "You're welcome! Let me know if you need anything else."
        ];

        // Add messages between users
        for ($i = 0; $i < 5; $i++) {
            $senderId = $userIds[$i];
            $receiverId = $userIds[($i + 1) % count($userIds)];
            
            foreach ($sampleMessages as $message) {
                $stmt = $db->prepare("
                    INSERT INTO messages (sender_id, receiver_id, message, created_at)
                    VALUES (?, ?, ?, datetime('now', '-' || ? || ' minutes'))
                ");
                $stmt->execute([$senderId, $receiverId, $message, $i * 5]);
            }
        }
        echo "✅ Added sample messages\n";
    }

    echo "\nSetup completed successfully!\n";
    echo "You can now log in with any of these accounts:\n";
    foreach ($dummyUsers as $user) {
        echo "Email: {$user['email']}, Password: {$user['password']}\n";
    }

} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
} 