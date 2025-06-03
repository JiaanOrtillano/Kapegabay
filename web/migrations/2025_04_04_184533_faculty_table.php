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

    public function createLoginActivitiesTable($pdo) {
        $query = "
            CREATE TABLE login_activities (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                username TEXT NOT NULL,
                role TEXT NOT NULL,
                login_time DATETIME DEFAULT CURRENT_TIMESTAMP,
                ip_address TEXT,
                user_agent TEXT,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )
        ";
        $pdo->exec($query);
    }
}
