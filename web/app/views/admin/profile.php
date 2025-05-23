<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../../config/database.php';
use root_dev\Config\Database;

// Fetch current admin data from DB
$db = Database::connect();
$stmt = $db->prepare('SELECT * FROM admins WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5ede3] font-['Montserrat',Arial,sans-serif] flex">
    <div class="main-content ml-[250px] w-full min-h-screen flex items-center justify-center">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-10">
            <div class="flex items-center gap-6 mb-10">
                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-4xl text-[#7b5434] overflow-hidden">
                    <?php if (!empty($admin['photo'])): ?>
                        <img src="<?= htmlspecialchars($admin['photo']) ?>" alt="Profile Photo" class="w-full h-full object-cover" />
                    <?php else: ?>
                        <span>👤</span>
                    <?php endif; ?>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-[#7b5434] mb-1">My Profile</h1>
                </div>
            </div>
            <form action="/admin/profile/update" method="POST" enctype="multipart/form-data" class="flex flex-col gap-6">
                <div>
                    <label class="font-semibold text-[#7b5434] block mb-2">Profile Photo</label>
                    <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#a6b98a] file:text-white hover:file:bg-[#7b5434]" />
                </div>
                <div class="flex gap-6">
                    <div class="flex-1">
                        <label class="font-semibold text-[#7b5434] block mb-2">Full Name</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($admin['username'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] focus:outline-none focus:border-[#7b5434]" />
                    </div>
                    <div class="flex-1">
                        <label class="font-semibold text-[#7b5434] block mb-2">Role</label>
                        <input type="text" name="role" value="<?= htmlspecialchars($admin['role'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] bg-gray-100 text-gray-500" readonly />
                    </div>
                </div>
                <div>
                    <label class="font-semibold text-[#7b5434] block mb-2">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($admin['email'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] focus:outline-none focus:border-[#7b5434]" />
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#a6b98a] text-white font-semibold text-lg px-8 py-2 rounded-lg shadow hover:bg-[#7b5434] transition">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
