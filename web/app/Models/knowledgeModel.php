<?php
use root_dev\Config\Database;

require_once __DIR__ . '/../../config/database.php';

function fetchKnowledgeFromDB() {
    $db = Database::connect();
    $stmt = $db->query("SELECT * FROM knowledge ORDER BY id DESC");
    return $stmt->fetchAll();
}

function addKnowledgeToDB($data) {
    try {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO knowledge (coffee_type, title, description, image) VALUES (:coffee_type, :title, :description, :image)");
        
        return $stmt->execute([
            ':coffee_type' => $data['coffee_type'],
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':image' => $data['image']
        ]);
    } catch (PDOException $e) {
        error_log("Error adding knowledge: " . $e->getMessage());
        return false;
    }
}
