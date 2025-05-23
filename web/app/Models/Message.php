<?php

namespace root_dev\Models;

require_once __DIR__ . '/../../config/database.php';
use root_dev\Config\Database;

class Message {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function sendMessage($senderId, $receiverId, $message) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO messages (sender_id, receiver_id, message) 
                VALUES (?, ?, ?)
            ");
            return $stmt->execute([$senderId, $receiverId, $message]);
        } catch (\PDOException $e) {
            error_log("Error sending message: " . $e->getMessage());
            return false;
        }
    }

    public function getMessages($userId1, $userId2) {
        try {
            $stmt = $this->db->prepare("
                SELECT m.*, 
                       u1.username as sender_name,
                       u2.username as receiver_name
                FROM messages m
                JOIN users u1 ON m.sender_id = u1.id
                JOIN users u2 ON m.receiver_id = u2.id
                WHERE (m.sender_id = ? AND m.receiver_id = ?)
                   OR (m.sender_id = ? AND m.receiver_id = ?)
                ORDER BY m.created_at ASC
            ");
            $stmt->execute([$userId1, $userId2, $userId2, $userId1]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error getting messages: " . $e->getMessage());
            return [];
        }
    }

    public function markAsRead($messageId) {
        try {
            $stmt = $this->db->prepare("
                UPDATE messages 
                SET is_read = 1 
                WHERE id = ?
            ");
            return $stmt->execute([$messageId]);
        } catch (\PDOException $e) {
            error_log("Error marking message as read: " . $e->getMessage());
            return false;
        }
    }

    public function getUnreadCount($userId) {
        try {
            $stmt = $this->db->prepare("
                SELECT COUNT(*) 
                FROM messages 
                WHERE receiver_id = ? AND is_read = 0
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Error getting unread count: " . $e->getMessage());
            return 0;
        }
    }

    public function getConversations($userId) {
        try {
            // First, get all users
            $stmt = $this->db->prepare("
                SELECT 
                    u.id as other_user_id,
                    u.username as other_username,
                    (
                        SELECT message 
                        FROM messages 
                        WHERE (sender_id = ? AND receiver_id = u.id)
                           OR (sender_id = u.id AND receiver_id = ?)
                        ORDER BY created_at DESC 
                        LIMIT 1
                    ) as last_message,
                    (
                        SELECT created_at 
                        FROM messages 
                        WHERE (sender_id = ? AND receiver_id = u.id)
                           OR (sender_id = u.id AND receiver_id = ?)
                        ORDER BY created_at DESC 
                        LIMIT 1
                    ) as last_message_time,
                    (
                        SELECT COUNT(*) 
                        FROM messages 
                        WHERE receiver_id = ? 
                        AND sender_id = u.id 
                        AND is_read = 0
                    ) as unread_count
                FROM users u
                WHERE u.id != ?
                ORDER BY last_message_time DESC NULLS LAST
            ");
            $stmt->execute([$userId, $userId, $userId, $userId, $userId, $userId]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error getting conversations: " . $e->getMessage());
            return [];
        }
    }
} 