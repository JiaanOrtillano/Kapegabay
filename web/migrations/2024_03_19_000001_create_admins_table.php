<?php

class CreateAdminsTable {
    public function up($pdo) {
        // Drop existing table if exists
        $pdo->exec("DROP TABLE IF EXISTS admins");

        // Create admins table
        $tableCreationQuery = "
            CREATE TABLE IF NOT EXISTS admins (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL,
                email TEXT NOT NULL,
                password TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT 'admin',
                olr TEXT,
                photo TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ";
        $pdo->exec($tableCreationQuery);

        // Create default admin account
        $username = 'admin';
        $email = 'admin@example.com';
        $password = 'admin123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertAdminQuery = "
            INSERT INTO admins (username, email, password, role, olr) 
            VALUES (?, ?, ?, 'admin', NULL);
        ";
        
        $stmt = $pdo->prepare($insertAdminQuery);
        $stmt->execute([$username, $email, $hashedPassword]);

        echo "✔️  Admins table created successfully with default admin account.\n";
        echo "Default admin credentials:\n";
        echo "Email: admin@example.com\n";
        echo "Password: admin123\n";
    }

    public function down($pdo) {
        $query = "DROP TABLE IF EXISTS admins;";
        $pdo->exec($query);
    }
} 