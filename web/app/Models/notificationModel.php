<?php
use root_dev\Config\Database;

require_once __DIR__ . '/../../config/database.php';

/**
 * Add a notification record to the database
 * @param array $data ['title' => string, 'message' => string, 'image' => string]
 * @return bool True on success, false on failure
 */
function addNotificationToDB(array $data): bool {
    try {
        $db = Database::connect();
        $sql = "INSERT INTO notifications (title, message, image, created_at) VALUES (:title, :message, :image, datetime('now'))";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':message', $data['message']);
        $stmt->bindParam(':image', $data['image']);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Failed to add notification: " . $e->getMessage());
        return false;
    }
}

/**
 * Fetch all notifications ordered by newest first
 * @return array
 */
function fetchAllNotifications(): array {
    $db = Database::connect();
    $stmt = $db->query("SELECT * FROM notifications ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
