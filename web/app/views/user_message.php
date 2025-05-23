<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/layouts/header.php';
use root_dev\Config\Database;

$db = Database::connect();
$sql = "SELECT id, username FROM users WHERE role != 'admin' ORDER BY username ASC";
$stmt = $db->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-2xl mx-auto mt-10">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-green-100">
            <h2 class="text-2xl font-bold text-green-700 mb-6 flex items-center gap-2">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 12l2 2 4-4"/></svg>
                User Directory
            </h2>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li class="flex items-center justify-between py-4 px-3 border-b last:border-b-0 hover:bg-green-50 transition group rounded-lg">
                        <div class="flex items-center gap-4">
                            <img src="<?php echo htmlspecialchars($user['profile_image'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($user['username'])); ?>"
                                 alt="Profile"
                                 class="w-12 h-12 rounded-full object-cover border-2 border-green-200 shadow-sm bg-white">
                            <div>
                                <div class="font-semibold text-gray-900 text-lg group-hover:text-green-700 transition">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </div>
                                <div class="text-sm text-gray-500 mt-1">
                                    <?php echo htmlspecialchars($user['region'] ?? ''); ?>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="/view_messages?id=<?php echo urlencode($user['id']); ?>" class="group">
                                <svg class="w-7 h-7 text-green-500 group-hover:text-green-700 transition" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="11" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 8l4 4-4 4"/>
                                </svg>
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
<?php Database::close(); ?>
