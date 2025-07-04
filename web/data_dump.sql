PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE admins (

                id INTEGER PRIMARY KEY AUTOINCREMENT,

                username TEXT NOT NULL,

                email TEXT NOT NULL,

                password TEXT NOT NULL,

                role TEXT NOT NULL DEFAULT 'admin',

                olr TEXT,

                created_at DATETIME DEFAULT CURRENT_TIMESTAMP

            );
INSERT INTO admins VALUES(1,'admin','admin@example.com','$2y$10$Cc/yUoFEPW/iJXOh6lJGsuimAyhNivhgUK006WyaVkiB0SwyiJaiW','admin',NULL,'2025-05-23 01:29:07');
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

            );
INSERT INTO users VALUES(1,'john_doe','john@example.com','$2y$10$bKgf/9xkegLFuVv49kfoTuxgz/2PhQQF43A.DMmm9tu6EFvB/pCvS',NULL,NULL,1,'user',NULL,'2025-05-23 04:27:00','2025-05-23 04:27:00');
INSERT INTO users VALUES(2,'jane_smith','jane@example.com','$2y$10$UAHYKDdMvt.xisHw3eySWuLfUmA4ZET6jU8lINZyCW7WDFvVf6KZm',NULL,NULL,1,'user',NULL,'2025-05-23 04:27:00','2025-05-23 04:27:00');
INSERT INTO users VALUES(3,'bob_wilson','bob@example.com','$2y$10$rof6Ig4EPUFxYb0/24CSvO5OX6JpvMZJxKabBh.ud7HBD60gqV1z.',NULL,NULL,1,'user',NULL,'2025-05-23 04:27:00','2025-05-23 04:27:00');
INSERT INTO users VALUES(4,'alice_brown','alice@example.com','$2y$10$NAITzm4B9WsGcZHic7DIl.Q6st6usp0O3ge4b.sNiibcSKTAtEGOK',NULL,NULL,1,'user',NULL,'2025-05-23 04:27:00','2025-05-23 04:27:00');
INSERT INTO users VALUES(5,'charlie_davis','charlie@example.com','$2y$10$KzKYcMk58fBmgmqJrSxLuOxFY/zzQxQSZGjA7r9lYl/ZmKjMjft9K',NULL,NULL,1,'user',NULL,'2025-05-23 04:27:01','2025-05-23 04:27:01');
INSERT INTO users VALUES(6,'admin1','admin1@example.com','$2y$10$WBONG1dhfm6lfHVX/k1RLebbT65SzX5zEFeL1fdn498EAIWOGqllS',NULL,NULL,1,'admin',NULL,'2025-05-23 05:10:04','2025-05-23 05:10:04');
INSERT INTO users VALUES(8,'user2','user2@example.com','$2y$10$A0A.xKLv.hYv1BSECzBvXOgwx3xH4CkPYXIfGq8IkGEqdWvNL9ZhS',NULL,NULL,1,'user',NULL,'2025-05-23 05:10:04','2025-05-23 05:10:04');
CREATE TABLE knowledge (

        id INTEGER PRIMARY KEY AUTOINCREMENT,

        coffee_type TEXT NOT NULL,

        title TEXT NOT NULL,

        description TEXT NOT NULL,

        image TEXT NOT NULL,

        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    );
INSERT INTO knowledge VALUES(1,'Robusta','sadda','DADAd','/app/assets/images/knowledge/682fedd8eb4ca.png','2025-05-23 03:39:04');
INSERT INTO knowledge VALUES(2,'Liberica','testbebeboy','bwahhaha','/app/assets/images/knowledge/682fedfdb212f.jpg','2025-05-23 03:39:41');
CREATE TABLE notifications (

        id INTEGER PRIMARY KEY AUTOINCREMENT,

        title TEXT NOT NULL,

        message TEXT NOT NULL,

        image TEXT,

        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    );
INSERT INTO notifications VALUES(1,'gdsgds','gdsgdsg','/app/assets/images/notifications/682ff310408f1.jpg','2025-05-23 04:01:20');
CREATE TABLE messages (

            id INTEGER PRIMARY KEY AUTOINCREMENT,

            sender_id INTEGER NOT NULL,

            receiver_id INTEGER NOT NULL,

            message TEXT NOT NULL,

            is_read INTEGER DEFAULT 0,

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,

            FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE

        );
INSERT INTO messages VALUES(1,4,3,'Hello! How can I help you today?',0,'2025-05-23 04:27:01');
INSERT INTO messages VALUES(2,4,3,'I have a question about my account.',0,'2025-05-23 04:27:01');
INSERT INTO messages VALUES(3,4,3,'Sure, what would you like to know?',0,'2025-05-23 04:27:01');
INSERT INTO messages VALUES(4,4,3,'Can you explain how to use the new features?',0,'2025-05-23 04:27:01');
INSERT INTO messages VALUES(5,4,3,'Of course! Let me walk you through it.',0,'2025-05-23 04:27:01');
INSERT INTO messages VALUES(6,4,3,'Thanks for your help!',0,'2025-05-23 04:27:01');
INSERT INTO messages VALUES(7,4,3,'You''re welcome! Let me know if you need anything else.',0,'2025-05-23 04:27:01');
INSERT INTO messages VALUES(8,3,5,'Hello! How can I help you today?',0,'2025-05-23 04:22:01');
INSERT INTO messages VALUES(9,3,5,'I have a question about my account.',0,'2025-05-23 04:22:01');
INSERT INTO messages VALUES(10,3,5,'Sure, what would you like to know?',0,'2025-05-23 04:22:01');
INSERT INTO messages VALUES(11,3,5,'Can you explain how to use the new features?',0,'2025-05-23 04:22:01');
INSERT INTO messages VALUES(12,3,5,'Of course! Let me walk you through it.',0,'2025-05-23 04:22:01');
INSERT INTO messages VALUES(13,3,5,'Thanks for your help!',0,'2025-05-23 04:22:01');
INSERT INTO messages VALUES(14,3,5,'You''re welcome! Let me know if you need anything else.',0,'2025-05-23 04:22:01');
INSERT INTO messages VALUES(15,5,2,'Hello! How can I help you today?',0,'2025-05-23 04:17:01');
INSERT INTO messages VALUES(16,5,2,'I have a question about my account.',0,'2025-05-23 04:17:01');
INSERT INTO messages VALUES(17,5,2,'Sure, what would you like to know?',0,'2025-05-23 04:17:01');
INSERT INTO messages VALUES(18,5,2,'Can you explain how to use the new features?',0,'2025-05-23 04:17:01');
INSERT INTO messages VALUES(19,5,2,'Of course! Let me walk you through it.',0,'2025-05-23 04:17:01');
INSERT INTO messages VALUES(20,5,2,'Thanks for your help!',0,'2025-05-23 04:17:01');
INSERT INTO messages VALUES(21,5,2,'You''re welcome! Let me know if you need anything else.',0,'2025-05-23 04:17:01');
INSERT INTO messages VALUES(22,2,1,'Hello! How can I help you today?',0,'2025-05-23 04:12:01');
INSERT INTO messages VALUES(23,2,1,'I have a question about my account.',0,'2025-05-23 04:12:01');
INSERT INTO messages VALUES(24,2,1,'Sure, what would you like to know?',0,'2025-05-23 04:12:01');
INSERT INTO messages VALUES(25,2,1,'Can you explain how to use the new features?',0,'2025-05-23 04:12:01');
INSERT INTO messages VALUES(26,2,1,'Of course! Let me walk you through it.',0,'2025-05-23 04:12:01');
INSERT INTO messages VALUES(27,2,1,'Thanks for your help!',0,'2025-05-23 04:12:01');
INSERT INTO messages VALUES(28,2,1,'You''re welcome! Let me know if you need anything else.',0,'2025-05-23 04:12:01');
INSERT INTO messages VALUES(29,1,4,'Hello! How can I help you today?',0,'2025-05-23 04:07:01');
INSERT INTO messages VALUES(30,1,4,'I have a question about my account.',0,'2025-05-23 04:07:01');
INSERT INTO messages VALUES(31,1,4,'Sure, what would you like to know?',0,'2025-05-23 04:07:01');
INSERT INTO messages VALUES(32,1,4,'Can you explain how to use the new features?',0,'2025-05-23 04:07:01');
INSERT INTO messages VALUES(33,1,4,'Of course! Let me walk you through it.',0,'2025-05-23 04:07:01');
INSERT INTO messages VALUES(34,1,4,'Thanks for your help!',0,'2025-05-23 04:07:01');
INSERT INTO messages VALUES(35,1,4,'You''re welcome! Let me know if you need anything else.',0,'2025-05-23 04:07:01');
INSERT INTO messages VALUES(36,1,4,'gago',0,'2025-05-23 04:29:23');
INSERT INTO messages VALUES(37,1,2,'tangina mo po',0,'2025-05-23 04:29:34');
CREATE TABLE system (

    id INTEGER PRIMARY KEY AUTOINCREMENT,

    logo TEXT,

    platform_name TEXT,

    language TEXT

);
INSERT INTO system VALUES(1,'uploads/logo_1747983108.jpg','KapeNaBaby','Tagalog');
INSERT INTO sqlite_sequence VALUES('admins',1);
INSERT INTO sqlite_sequence VALUES('knowledge',2);
INSERT INTO sqlite_sequence VALUES('notifications',1);
INSERT INTO sqlite_sequence VALUES('users',8);
INSERT INTO sqlite_sequence VALUES('messages',37);
INSERT INTO sqlite_sequence VALUES('system',1);
COMMIT;
