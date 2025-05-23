<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /login');
    exit();
}

// Helper for active menu
function isActive($route) {
    return strpos($_SERVER['REQUEST_URI'], $route) === 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5ede3;
            font-family: 'Montserrat', Arial, sans-serif;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background: #f8f1e6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 8px rgba(0,0,0,0.04);
        }
        .sidebar-top {
            padding: 2rem 1.5rem 1.5rem 1.5rem;
        }
        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 2.5rem;
        }
        .logo-icon {
            width: 36px;
            height: 36px;
            margin-right: 0.7rem;
        }
        .logo-text {
            font-family: 'Montserrat', Arial, sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            color: #7b5434;
            letter-spacing: 0.04em;
        }
        .menu {
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }
        .menu-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.7rem 1rem;
            border-radius: 1rem;
            color: #7b5434;
            font-size: 1.05rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.18s, color 0.18s;
            background: none;
        }
        .menu-item svg {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }
        .menu-item.active {
            background: #7b5434;
            color: #fff;
        }
        .menu-item.active svg path,
        .menu-item.active svg rect,
        .menu-item.active svg circle {
            stroke: #fff !important;
            fill: none !important;
        }
        .menu-item:hover:not(.active) {
            background: #e6d3c0;
        }
        .sidebar-bottom {
            padding: 1.5rem;
        }
        .logout {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            color: #7b5434;
            font-size: 1.05rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            background: none;
            cursor: pointer;
            padding: 0.5rem 0.7rem;
            border-radius: 0.8rem;
            transition: background 0.18s;
        }
        .logout svg {
            width: 22px;
            height: 22px;
        }
        .logout:hover {
            background: #e6d3c0;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div>
            <div class="sidebar-top">
                <div class="logo">
                    <span class="logo-icon">
                        <!-- Coffee cup SVG -->
                        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="16" cy="27" rx="12" ry="3" fill="#f5ede3" stroke="#7b5434" stroke-width="2"/>
                            <ellipse cx="16" cy="15" rx="8" ry="5" fill="#f5ede3" stroke="#7b5434" stroke-width="2"/>
                            <ellipse cx="16" cy="15" rx="6" ry="3" fill="#f5ede3" stroke="#7b5434" stroke-width="1.2"/>
                            <path d="M22 15c3 3 3 7-3 9" stroke="#7b5434" stroke-width="2" fill="none"/>
                            <path d="M12 10c-1-3 4-4 2-8" stroke="#7b5434" stroke-width="2" fill="none"/>
                        </svg>
                    </span>
                    <span class="logo-text">KapeGabay</span>
                </div>
                <nav class="menu">
                    <a href="/admin/dashboard" class="menu-item<?php echo isActive('/admin/dashboard') ? ' active' : ''; ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#7b5434" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="12" width="6" height="8" rx="2"/><rect x="9" y="8" width="6" height="12" rx="2"/><rect x="15" y="4" width="6" height="16" rx="2"/></svg>
                        Dashboard
                    </a>
                    <a href="/admin/registry" class="menu-item<?php echo isActive('/admin/farmers') ? ' active' : ''; ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#7b5434" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M16 3v4M8 3v4"/><path d="M12 12v2"/></svg>
                        Farmer Registry
                    </a>
                    <a href="/admin/knowledge" class="menu-item<?php echo isActive('/admin/knowledge') ? ' active' : ''; ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#7b5434" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10M7 12h10M7 16h6"/></svg>
                        Knowledge Hub
                    </a>
                    <a href="/admin/notification" class="menu-item<?php echo isActive('/admin/notifications') ? ' active' : ''; ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#7b5434" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M18 16v-5a6 6 0 1 0-12 0v5l-2 2v1h16v-1l-2-2z"/><circle cx="12" cy="21" r="1.5"/></svg>
                        Notifications
                    </a>
                    <a href="/admin/reports" class="menu-item<?php echo isActive('/admin/reports') ? ' active' : ''; ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#7b5434" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 12h10M7 16h6"/></svg>
                        Reports
                    </a>
                    <a href="/admin/message" class="menu-item<?php echo isActive('/admin/messages') ? ' active' : ''; ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#7b5434" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
                        Message
                    </a>
                    <a href="/admin/profile" class="menu-item<?php echo isActive('/admin/profile') ? ' active' : ''; ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#7b5434" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg>
                        Profile
                    </a>
                </nav>
            </div>
        </div>
        <div class="sidebar-bottom">
            <a href="/logout" class="logout">
                <svg viewBox="0 0 24 24" fill="none" stroke="#7b5434" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l2 2"/></svg>
                Logout
            </a>
        </div>
    </aside>
    <!-- Main content should be placed after this sidebar in your layout -->
</body>
</html> 