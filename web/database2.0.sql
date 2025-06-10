-- MySQL/MariaDB compatible database schema
-- Drop tables if they exist
DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `knowledge`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `admins`;
DROP TABLE IF EXISTS `system`;

-- Create tables
CREATE TABLE `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'admin',
    `olr` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100),
    `email_verified_at` TIMESTAMP NULL,
    `is_active` TINYINT(1) DEFAULT 1,
    `role` VARCHAR(50) DEFAULT 'user',
    `olr` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `knowledge` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `coffee_type` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `notifications` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `image` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `messages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `sender_id` INT NOT NULL,
    `receiver_id` INT NOT NULL,
    `message` TEXT NOT NULL,
    `is_read` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`receiver_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

CREATE TABLE `system` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `logo` VARCHAR(255),
    `platform_name` VARCHAR(255),
    `language` VARCHAR(50)
);

-- Insert actual data from SQLite database

-- Insert admins data
INSERT INTO `admins` (`username`, `email`, `password`, `role`, `olr`, `created_at`) VALUES
('admin', 'admin@example.com', '$2y$10$Cc/yUoFEPW/iJXOh6lJGsuimAyhNivhgUK006WyaVkiB0SwyiJaiW', 'admin', NULL, '2025-05-23 01:29:07');
-- ('ADMIN', 'admin2@example.com', '$2y$10$A0A.xKLv.hYv1BSECzBvXOgwx3xH4CkPYXIfGq8IkGEqdWvNL9ZhS', NULL, NULL, 1, 'user', NULL, '2025-05-23 05:10:04', '2025-05-23 05:10:04');

-- Insert users data
INSERT INTO `users` (`username`, `email`, `password`, `remember_token`, `email_verified_at`, `is_active`, `role`, `olr`, `created_at`, `updated_at`) VALUES
('john_doe', 'john@example.com', '$2y$10$bKgf/9xkegLFuVv49kfoTuxgz/2PhQQF43A.DMmm9tu6EFvB/pCvS', NULL, NULL, 1, 'user', NULL, '2025-05-23 04:27:00', '2025-05-23 04:27:00'),
('jane_smith', 'jane@example.com', '$2y$10$UAHYKDdMvt.xisHw3eySWuLfUmA4ZET6jU8lINZyCW7WDFvVf6KZm', NULL, NULL, 1, 'user', NULL, '2025-05-23 04:27:00', '2025-05-23 04:27:00'),
('bob_wilson', 'bob@example.com', '$2y$10$rof6Ig4EPUFxYb0/24CSvO5OX6JpvMZJxKabBh.ud7HBD60gqV1z.', NULL, NULL, 1, 'user', NULL, '2025-05-23 04:27:00', '2025-05-23 04:27:00'),
('alice_brown', 'alice@example.com', '$2y$10$NAITzm4B9WsGcZHic7DIl.Q6st6usp0O3ge4b.sNiibcSKTAtEGOK', NULL, NULL, 1, 'user', NULL, '2025-05-23 04:27:00', '2025-05-23 04:27:00'),
('charlie_davis', 'charlie@example.com', '$2y$10$KzKYcMk58fBmgmqJrSxLuOxFY/zzQxQSZGjA7r9lYl/ZmKjMjft9K', NULL, NULL, 1, 'user', NULL, '2025-05-23 04:27:01', '2025-05-23 04:27:01'),
-- ('admin1', 'admin1@example.com', '$2y$10$WBONG1dhfm6lfHVX/k1RLebbT65SzX5zEFeL1fdn498EAIWOGqllS', NULL, NULL, 1, 'admin', NULL, '2025-05-23 05:10:04', '2025-05-23 05:10:04'),
('user2', 'user2@example.com', '$2y$10$A0A.xKLv.hYv1BSECzBvXOgwx3xH4CkPYXIfGq8IkGEqdWvNL9ZhS', NULL, NULL, 1, 'admin', NULL, '2025-05-23 05:10:04', '2025-05-23 05:10:04');

-- Insert knowledge data
INSERT INTO `knowledge` (`coffee_type`, `title`, `description`, `image`, `created_at`) VALUES
('Robusta', 'sadda', 'DADAd', '/app/assets/images/knowledge/682fedd8eb4ca.png', '2025-05-23 03:39:04'),
('Liberica', 'testbebeboy', 'bwahhaha', '/app/assets/images/knowledge/682fedfdb212f.jpg', '2025-05-23 03:39:41');

-- Insert notifications data
INSERT INTO `notifications` (`title`, `message`, `image`, `created_at`) VALUES
('gdsgds', 'gdsgdsg', '/app/assets/images/notifications/682ff310408f1.jpg', '2025-05-23 04:01:20');

-- Insert messages data
INSERT INTO `messages` (`sender_id`, `receiver_id`, `message`, `is_read`, `created_at`) VALUES
(4, 3, 'Hello! How can I help you today?', 0, '2025-05-23 04:27:01'),
(4, 3, 'I have a question about my account.', 0, '2025-05-23 04:27:01'),
(4, 3, 'Sure, what would you like to know?', 0, '2025-05-23 04:27:01'),
(4, 3, 'Can you explain how to use the new features?', 0, '2025-05-23 04:27:01'),
(4, 3, 'Of course! Let me walk you through it.', 0, '2025-05-23 04:27:01'),
(4, 3, 'Thanks for your help!', 0, '2025-05-23 04:27:01'),
(4, 3, 'You\'re welcome! Let me know if you need anything else.', 0, '2025-05-23 04:27:01'),
(3, 5, 'Hello! How can I help you today?', 0, '2025-05-23 04:22:01'),
(3, 5, 'I have a question about my account.', 0, '2025-05-23 04:22:01'),
(3, 5, 'Sure, what would you like to know?', 0, '2025-05-23 04:22:01'),
(3, 5, 'Can you explain how to use the new features?', 0, '2025-05-23 04:22:01'),
(3, 5, 'Of course! Let me walk you through it.', 0, '2025-05-23 04:22:01'),
(3, 5, 'Thanks for your help!', 0, '2025-05-23 04:22:01'),
(3, 5, 'You\'re welcome! Let me know if you need anything else.', 0, '2025-05-23 04:22:01'),
(5, 2, 'Hello! How can I help you today?', 0, '2025-05-23 04:17:01'),
(5, 2, 'I have a question about my account.', 0, '2025-05-23 04:17:01'),
(5, 2, 'Sure, what would you like to know?', 0, '2025-05-23 04:17:01'),
(5, 2, 'Can you explain how to use the new features?', 0, '2025-05-23 04:17:01'),
(5, 2, 'Of course! Let me walk you through it.', 0, '2025-05-23 04:17:01'),
(5, 2, 'Thanks for your help!', 0, '2025-05-23 04:17:01'),
(5, 2, 'You\'re welcome! Let me know if you need anything else.', 0, '2025-05-23 04:17:01'),
(2, 1, 'Hello! How can I help you today?', 0, '2025-05-23 04:12:01'),
(2, 1, 'I have a question about my account.', 0, '2025-05-23 04:12:01'),
(2, 1, 'Sure, what would you like to know?', 0, '2025-05-23 04:12:01'),
(2, 1, 'Can you explain how to use the new features?', 0, '2025-05-23 04:12:01'),
(2, 1, 'Of course! Let me walk you through it.', 0, '2025-05-23 04:12:01'),
(2, 1, 'Thanks for your help!', 0, '2025-05-23 04:12:01'),
(2, 1, 'You\'re welcome! Let me know if you need anything else.', 0, '2025-05-23 04:12:01'),
(1, 4, 'Hello! How can I help you today?', 0, '2025-05-23 04:07:01'),
(1, 4, 'I have a question about my account.', 0, '2025-05-23 04:07:01'),
(1, 4, 'Sure, what would you like to know?', 0, '2025-05-23 04:07:01'),
(1, 4, 'Can you explain how to use the new features?', 0, '2025-05-23 04:07:01'),
(1, 4, 'Of course! Let me walk you through it.', 0, '2025-05-23 04:07:01'),
(1, 4, 'Thanks for your help!', 0, '2025-05-23 04:07:01'),
(1, 4, 'You\'re welcome! Let me know if you need anything else.', 0, '2025-05-23 04:07:01'),


-- Insert system data
INSERT INTO `system` (`logo`, `platform_name`, `language`) VALUES
('uploads/logo_1747983108.jpg', 'KapeNaBaby', 'Tagalog'); 