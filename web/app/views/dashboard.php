<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php
require_once __DIR__ . '/../../config/database.php';
use root_dev\Config\Database;

$db = Database::connect();
$sql = "SELECT COUNT(*) as total FROM users WHERE role != 'admin1'";
$stmt = $db->query($sql);
$totalUsers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<div class="bg-gray-100 min-h-screen py-10 ml-60">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-3xl font-semibold text-gray-800 mb-1">Dashboard Overview</h2>
        <div class="text-gray-500 mb-8">System Overview and Key Metrics</div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-3xl mb-2">👨‍🌾</div>
                <div class="text-2xl font-bold"><?php echo number_format($totalUsers); ?></div>
                <div class="text-gray-600">Farmers</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-3xl mb-2">👩‍🌾</div>
                <div class="text-2xl font-bold"><?php echo number_format($totalUsers); ?></div>
                <div class="text-gray-600">Farmers</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-3xl mb-2">🤝</div>
                <div class="text-2xl font-bold"><?php echo number_format($totalUsers); ?></div>
                <div class="text-gray-600">Farmers</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                <div class="text-3xl mb-2">🗂️</div>
                <div class="text-2xl font-bold"><?php echo number_format($totalUsers); ?></div>
                <div class="text-gray-600">Farmers</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="font-semibold text-gray-800 mb-4">Recent Activity</div>
            <ul class="divide-y divide-gray-200">
                <li class="flex justify-between py-2 text-gray-700"><span>User John Doe logged in</span><span class="text-gray-400 text-sm">10 minutes ago</span></li>
                <li class="flex justify-between py-2 text-gray-700"><span>FCA Leader Jane approved submission</span><span class="text-gray-400 text-sm">15 minutes ago</span></li>
                <li class="flex justify-between py-2 text-gray-700"><span>DA Staff Alex created new report</span><span class="text-gray-400 text-sm">20 minutes ago</span></li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="font-semibold text-gray-800 mb-4">System Health</div>
            <div class="flex flex-col md:flex-row md:justify-between md:items-center text-gray-700">
                <div class="mb-2 md:mb-0">
                    Database: <span class="text-green-600 font-bold">Healthy</span><br>
                    Uptime: <span class="text-green-600 font-bold">99.9%</span>
                </div>
                <div class="text-right">
                    API Response: <span class="text-green-600 font-bold">Good</span><br>
                    Server Load: <span class="text-yellow-500 font-bold">Low</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <button class="bg-green-300 hover:bg-green-400 text-white rounded-lg shadow p-6 font-semibold text-lg flex flex-col items-center transition">
                Manage Users
                <span class="text-sm font-normal mt-2">Add, edit, or remove users.</span>
            </button>
            <button class="bg-green-300 hover:bg-green-400 text-white rounded-lg shadow p-6 font-semibold text-lg flex flex-col items-center transition">
                View Reports
                <span class="text-sm font-normal mt-2">Generate and view platform reports.</span>
            </button>
            <button class="bg-green-300 hover:bg-green-400 text-white rounded-lg shadow p-6 font-semibold text-lg flex flex-col items-center transition">
                System Settings
                <span class="text-sm font-normal mt-2">Update platform settings and preferences.</span>
            </button>
        </div>
    </div>
</div>


