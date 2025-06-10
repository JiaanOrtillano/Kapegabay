<?php

namespace App\Controller;
require_once __DIR__ . '/../../config/database.php';
use App\Database\Database;

class AdminController {
    public function getRecentLogins() {
        try {
            $db = Database::connect();
            $sql = "SELECT * FROM login_activities ORDER BY login_time DESC LIMIT 10";
            $stmt = $db->query($sql);
            $logins = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            header('Content-Type: application/json');
            echo json_encode($logins);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch login activities']);
        }
    }
} 