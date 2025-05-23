<?php

class CreateUsersTable {
    public function up($pdo) {
        $query = "
            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                remember_token TEXT,
                email_verified_at DATETIME,
                is_active INTEGER DEFAULT 1,
                role TEXT DEFAULT 'user',
                olr TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $pdo->exec($query);
    }
}
