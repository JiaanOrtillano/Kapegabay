<?php

use root_dev\Config\Database;

require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../../config/database.php';

// Create database connection
$db = Database::connect();

// Get total users count from database
$sql = "SELECT COUNT(*) as total FROM users";
$stmt = $db->query($sql);
$totalUsers = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];

// Example data for demo
$fcaActivity = 320;
$platformViews = 15400;

// Example chart data (replace with real data as needed)
$farmerTrend = [60, 120, 180, 240, 300];
$fcaRegions = [90, 140, 100, 130, 95];
$regionLabels = ['Region I', 'Region II', 'Region III', 'Region IVA', 'Region V'];
$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #efefef;
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .main-content {
            margin-left: 250px; /* sidebar width */
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .dashboard-title {
            font-size: 2rem;
            font-weight: 600;
            color: #7b5434;
            margin-bottom: 2.2rem;
        }
        .stats-row {
            display: flex;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }
        .stat-card {
            flex: 1;
            background: linear-gradient(90deg, #a6b98a 0%, #7b5434 100%);
            border-radius: 1rem;
            padding: 1.5rem 2rem;
            color: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        .stat-label {
            font-size: 1.05rem;
            opacity: 0.95;
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-size: 2.1rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }
        .stat-sub {
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 0.2rem;
        }
        .cards-row {
            display: flex;
            gap: 2rem;
            margin-top: 1.5rem;
        }
        .card {
            flex: 1;
            background: #fff;
            border-radius: 1.1rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 1.5rem 1.5rem 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #7b5434;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .card-title svg {
            width: 18px;
            height: 18px;
        }
        @media (max-width: 1100px) {
            .stats-row, .cards-row {
                flex-direction: column;
                gap: 1.2rem;
            }
            .main-content {
                margin-left: 0;
                padding: 1.2rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="dashboard-title">Dashboard Overview</div>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total Registered Farmers</div>
                <div class="stat-value"><?php echo number_format($totalUsers); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">FCA Activity</div>
                <div class="stat-value"><?php echo number_format($fcaActivity); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Platform Analytics</div>
                <div class="stat-value"><?php echo number_format($platformViews/1000, 1); ?>K Views</div>
            </div>
        </div>
        <div class="cards-row">
            <div class="card">
                <div class="card-title">
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="16" height="16" rx="4" stroke="#7b5434" stroke-width="1.5"/><path d="M5 15l3.5-4 3 3 3.5-6" stroke="#a6b98a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Farmer Registration Trend
                </div>
                <canvas id="farmerTrendChart" height="220"></canvas>
            </div>
            <div class="card">
                <div class="card-title">
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="16" height="16" rx="4" stroke="#7b5434" stroke-width="1.5"/><rect x="6" y="8" width="2" height="6" rx="1" fill="#7b5434"/><rect x="9" y="5" width="2" height="9" rx="1" fill="#7b5434"/><rect x="12" y="10" width="2" height="4" rx="1" fill="#7b5434"/></svg>
                    FCA Activity Overview
                </div>
                <canvas id="fcaActivityChart" height="220"></canvas>
            </div>
        </div>
    </div>
    <script>
        // Farmer Registration Trend (Line Chart)
        new Chart(document.getElementById('farmerTrendChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: '',
                    data: <?php echo json_encode($farmerTrend); ?>,
                    borderColor: '#a6b98a',
                    backgroundColor: 'rgba(166,185,138,0.18)',
                    pointBackgroundColor: '#7b5434',
                    pointBorderColor: '#7b5434',
                    pointRadius: 5,
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#7b5434', font: { weight: 600 } } },
                    y: { grid: { color: '#e6e6e6' }, ticks: { color: '#7b5434', font: { weight: 600 } }, beginAtZero: true, max: 320 }
                }
            }
        });
        // FCA Activity Overview (Bar Chart)
        new Chart(document.getElementById('fcaActivityChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($regionLabels); ?>,
                datasets: [{
                    label: '',
                    data: <?php echo json_encode($fcaRegions); ?>,
                    backgroundColor: '#7b5434',
                    borderRadius: 8,
                    barPercentage: 0.6,
                    categoryPercentage: 0.7,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#7b5434', font: { weight: 600 } } },
                    y: { grid: { color: '#e6e6e6' }, ticks: { color: '#7b5434', font: { weight: 600 } }, beginAtZero: true, max: 160 }
                }
            }
        });
    </script>
</body>
</html>

<?php

Database::close();
?>

<script>
    const menuButton = document.querySelector('button[aria-controls="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
