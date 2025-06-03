<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../config/database.php';
use root_dev\Config\Database;

$db = Database::connect();

$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch user info
$user_stmt = $db->prepare("SELECT username FROM users WHERE id = ?");
$user_stmt->execute([$user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

// Fetch messages for this user (assuming a messages table with user_id, content, created_at)
$msg_stmt = $db->prepare("SELECT message FROM messages WHERE sender_id = ? ORDER BY created_at ASC");
$msg_stmt->execute([$user_id]);
$messages = $msg_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat with <?php echo htmlspecialchars($user['username'] ?? 'User'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-xl mx-auto mt-10">
        <div class="bg-white rounded-2xl shadow-xl border p-0">
            <div class="bg-orange-100 rounded-t-2xl px-6 py-4 border-b flex items-center">
                <a href="user_message.php" class="mr-3 text-orange-400 hover:text-orange-600">
                    <!-- Back arrow -->
                    <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <span class="font-semibold text-lg text-orange-900">Chat with <?php echo htmlspecialchars($user['username'] ?? 'User'); ?></span>
            </div>
            <div class="p-6 space-y-3 min-h-[300px] bg-gray-50">
                <?php foreach ($messages as $msg): ?>
                    <div class="bg-gray-200 rounded-lg px-4 py-2 text-gray-800 w-fit">
                        <?php echo htmlspecialchars($msg['message']); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- <form class="flex items-center border-t p-4 bg-gray-100" method="post" action="">
                <input type="text" name="message" class="flex-1 rounded-lg border px-4 py-2 mr-2 focus:outline-none focus:ring-2 focus:ring-orange-200" placeholder="Type your message..." disabled />
                <button type="submit" class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-5 py-2 rounded-lg" disabled>Send</button>
            </form> -->
        </div>
    </div>
</body>
</html>
<?php Database::close(); ?> 