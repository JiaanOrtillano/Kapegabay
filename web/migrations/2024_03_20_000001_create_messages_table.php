<?php

class CreateMessagesTable {
    public function up($pdo) {
        $query = "
            CREATE TABLE IF NOT EXISTS messages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                sender_id INTEGER NOT NULL,
                receiver_id INTEGER NOT NULL,
                message TEXT NOT NULL,
                is_read INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
            );
        ";
        $pdo->exec($query);
    }

    public function down($pdo) {
        $query = "DROP TABLE IF EXISTS messages;";
        $pdo->exec($query);
    }
} 