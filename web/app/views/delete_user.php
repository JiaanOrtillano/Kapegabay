<?php
require_once __DIR__ . '/../../config/database.php';
use root_dev\Config\Database;

header('Content-Type: application/json');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Check if user_id is provided
if (!isset($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit;
}

$user_id = (int)$_POST['user_id'];

try {
    $db = Database::connect();
    
    // First check if the user exists and is not an admin
    $check_sql = "SELECT role FROM users WHERE id = ?";
    $check_stmt = $db->prepare($check_sql);
    $check_stmt->execute([$user_id]);
    $user = $check_stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        exit;
    }
    
    if ($user['role'] === 'admin') {
        echo json_encode(['success' => false, 'message' => 'Cannot delete admin users']);
        exit;
    }
    
    // Delete the user
    $delete_sql = "DELETE FROM users WHERE id = ? AND role != 'admin'";
    $delete_stmt = $db->prepare($delete_sql);
    $result = $delete_stmt->execute([$user_id]);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
    }
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
} finally {
    Database::close();
} 