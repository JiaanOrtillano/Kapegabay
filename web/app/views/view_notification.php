<?php
require_once __DIR__ . '/../models/notificationModel.php';
$notifications = fetchAllNotifications();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sent Notifications</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<div class="min-h-screen font-[Montserrat,Arial,sans-serif] ml-60">
    
    <div class="max-w-2xl mx-auto py-10">
        <!-- <a href="/app/views/admin/notification.php" class="mb-6 inline-block bg-[#7b5434] text-white px-4 py-2 rounded shadow">&lt; Back</a> -->
        <h1 class="text-2xl font-semibold text-[#7b5434] mb-6">Sent Notifications</h1>
        <?php if (empty($notifications)): ?>
            <div class="bg-white p-6 rounded shadow text-center text-gray-500">No notifications sent yet.</div>
        <?php else: ?>
            <div class="space-y-5">
                <?php foreach ($notifications as $notif): ?>
                    <div class="bg-white rounded shadow p-5">
                        <div class="text-lg font-semibold text-[#7b5434] mb-1"><?php echo htmlspecialchars($notif['title']); ?></div>
                        <div class="text-gray-700 mb-2"><?php echo nl2br(htmlspecialchars($notif['message'])); ?></div>
                        <div class="text-xs text-gray-500">
                            <?php echo date('F j, Y, g:i A', strtotime($notif['created_at'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div> 