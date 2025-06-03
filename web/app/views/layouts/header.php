<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_uri = $_SERVER['REQUEST_URI'];

// Connect to the database and fetch system settings
$settings = [
    'logo' => '',
    'platform_name' => 'Kapegabay',
    'language' => 'English'
];
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../../../database.sqlite');
    $stmt = $db->query('SELECT * FROM system LIMIT 1');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $settings = $row;
    }
} catch (Exception $e) {
    // Fallback to defaults if DB fails
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($settings['platform_name']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<aside class="w-64 h-screen bg-[#f7ede2] fixed top-0 left-0 flex flex-col justify-between shadow-md z-50">
    <div>
        <div class="flex items-center gap-3 p-6 text-[#7b5434] font-bold text-xl">
            <?php if (!empty($settings['logo'])): ?>
                <img src="/<?php echo htmlspecialchars($settings['logo']); ?>" alt="Logo" class="h-10 w-auto rounded shadow border bg-white">
            <?php else: ?>
                <span class="text-2xl">&#9749;</span>
            <?php endif; ?>
            <?php echo htmlspecialchars($settings['platform_name']); ?>
        </div>
        <nav class="flex-1">
            <ul class="px-4 space-y-2">
                <li>
                    <a href="/dashboard" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-medium transition 
                        <?= $current_uri == '/dashboard' ? 'bg-[#7b5434] text-white shadow' : 'text-[#7b5434] hover:bg-[#7b5434] hover:text-white' ?>">
                        <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="16" height="16" rx="4"/>
                        </svg>
                        Dashboard
                    </a>
                </li>
            
                <li>
                    <a href="/users" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-medium transition 
                        <?= strpos($current_uri, 'users') !== false ? 'bg-[#7b5434] text-white shadow' : 'text-[#7b5434] hover:bg-[#7b5434] hover:text-white' ?>">
                        <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="14" rx="3"/>
                            <circle cx="8" cy="17" r="2"/>
                            <circle cx="16" cy="17" r="2"/>
                        </svg>
                        Manage Users
                    </a>
                </li>
                <li>
                    <a href="analytics" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-medium transition 
                        <?= strpos($current_uri, '/admin/analytics') !== false ? 'bg-[#7b5434] text-white shadow' : 'text-[#7b5434] hover:bg-[#7b5434] hover:text-white' ?>">
                        <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="4" y="10" width="3" height="7" rx="1.5"/>
                            <rect x="10.5" y="6" width="3" height="11" rx="1.5"/>
                            <rect x="17" y="13" width="3" height="4" rx="1.5"/>
                        </svg>
                        Analytics
                    </a>
                </li>
                <li>
                    <a href="/settings" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-medium transition 
                        <?= strpos($current_uri, '/settings') !== false ? 'bg-[#7b5434] text-white shadow' : 'text-[#7b5434] hover:bg-[#7b5434] hover:text-white' ?>">
                        <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3.5"/>
                            <path d="..."/>
                        </svg>
                        Platform Settings
                    </a>
                </li>
                <li>
                    <a href="/notification" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-medium transition 
                        <?= strpos($current_uri, '/notifications') !== false ? 'bg-[#7b5434] text-white shadow' : 'text-[#7b5434] hover:bg-[#7b5434] hover:text-white' ?>">
                        <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="..."/>
                        </svg>
                        Notifications
                    </a>
                </li>
                <li>
                    <a href="/logs" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-medium transition 
                        <?= strpos($current_uri, 'logs') !== false ? 'bg-[#7b5434] text-white shadow' : 'text-[#7b5434] hover:bg-[#7b5434] hover:text-white' ?>">
                        <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        System Logs
                    </a>
                </li>
    
                <li>
                    <a href="/user_message" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-medium transition 
                        <?= strpos($current_uri, '/messages') !== false ? 'bg-[#7b5434] text-white shadow' : 'text-[#7b5434] hover:bg-[#7b5434] hover:text-white' ?>">
                        <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="2" y="4" width="20" height="16" rx="4"/>
                            <path d="M6 8h12M6 12h8"/>
                        </svg>
                        Messages
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="px-6 py-4 border-t border-[#e0cfc2]">
        <form action="/logout" method="POST">
            <button type="submit" class="flex items-center gap-3 text-[#a47149] hover:text-[#7b5434] transition">
                <svg class="w-6 h-6 stroke-current" fill="none" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
