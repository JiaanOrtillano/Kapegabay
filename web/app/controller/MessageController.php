<?php

namespace root_dev\Controller;

require_once __DIR__ . '/../models/Message.php';
require_once __DIR__ . '/../models/User.php';
use root_dev\Models\Message;
use root_dev\Models\User;

class MessageController {
    private $messageModel;
    private $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->messageModel = new Message();
        $this->userModel = new User();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $conversations = $this->messageModel->getConversations($userId);
        require_once __DIR__ . '/../views/admin/message.php';
    }

    public function sendMessage() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $senderId = $_SESSION['user_id'];
        $receiverId = $_POST['receiver_id'] ?? null;
        $message = $_POST['message'] ?? null;

        if (!$receiverId || !$message) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        if ($this->messageModel->sendMessage($senderId, $receiverId, $message)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to send message']);
        }
    }

    public function getMessages() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $userId1 = $_SESSION['user_id'];
        $userId2 = $_GET['user_id'] ?? null;

        if (!$userId2) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing user ID']);
            return;
        }

        $messages = $this->messageModel->getMessages($userId1, $userId2);
        echo json_encode(['messages' => $messages]);
    }

    public function markAsRead() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            return;
        }

        $messageId = $_POST['message_id'] ?? null;

        if (!$messageId) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing message ID']);
            return;
        }

        if ($this->messageModel->markAsRead($messageId)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to mark message as read']);
        }
    }

    public function getUnreadCount() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $count = $this->messageModel->getUnreadCount($userId);
        echo json_encode(['count' => $count]);
    }
} 