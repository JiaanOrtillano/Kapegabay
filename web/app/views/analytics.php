<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../config/database.php';

use root_dev\Config\Database;

$db = Database::connect();

// Daily Active Users (users created today)
$today = date('Y-m-d');
$stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = ?");
$stmt->execute([$today]);
$dailyActive = $stmt->fetch()['count'];

// Monthly Active Users (users created this month)
$thisMonth = date('Y-m');
$stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE strftime('%Y-%m', created_at) = ?");
$stmt->execute([$thisMonth]);
$monthlyActive = $stmt->fetch()['count'];

// User Activity Trend (last 7 days)
$userActivityLabels = [];
$userActivityData = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $userActivityLabels[] = date('D', strtotime($date));
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = ?");
    $stmt->execute([$date]);
    $userActivityData[] = (int)$stmt->fetch()['count'];
}

// Submission Trends (messages per week for last 4 weeks)
$submissionLabels = [];
$submissionData = [];
for ($w = 3; $w >= 0; $w--) {
    $start = date('Y-m-d', strtotime("-" . ($w * 7) . " days", strtotime('monday this week')));
    $end = date('Y-m-d', strtotime($start . ' +6 days'));
    $submissionLabels[] = 'Week ' . (4 - $w);
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM messages WHERE DATE(created_at) BETWEEN ? AND ?");
    $stmt->execute([$start, $end]);
    $submissionData[] = (int)$stmt->fetch()['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports & Analytics</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .main-content { margin-left: 250px; padding: 2.5rem 2rem; background: #f5ede3; min-height: 100vh; font-family: 'Montserrat', Arial, sans-serif; }
        .title { font-size: 2rem; font-weight: 600; color: #7b5434; margin-bottom: 2.2rem; }
        .stats-row { display: flex; gap: 2rem; margin-bottom: 2.5rem; }
        .stat-card { flex: 1; background: #fff; border-radius: 1rem; padding: 1.5rem 2rem; color: #7b5434; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 2px solid #e6d3c0; }
        .stat-label { font-size: 1.05rem; opacity: 0.95; margin-bottom: 0.5rem; }
        .stat-value { font-size: 2.1rem; font-weight: 700; letter-spacing: 0.02em; }
        .cards-row { display: flex; gap: 2rem; }
        .card { flex: 1; background: #fff; border-radius: 1.1rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06); padding: 1.5rem; }
        .card-title { font-size: 1.1rem; font-weight: 600; color: #7b5434; margin-bottom: 1.2rem; }
        @media (max-width: 1100px) { .stats-row, .cards-row { flex-direction: column; gap: 1.2rem; } .main-content { margin-left: 0; padding: 1.2rem 0.5rem; } }
    </style>
</head>
<body>
<div class="main-content">
    <div class="title">Reports & Analytics</div>
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Daily Active Users</div>
            <div class="stat-value"><?php echo $dailyActive; ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Monthly Active Users</div>
            <div class="stat-value"><?php echo $monthlyActive; ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Monthly Active Users</div>
            <div class="stat-value"><?php echo $monthlyActive; ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Monthly Active Users</div>
            <div class="stat-value"><?php echo $monthlyActive; ?></div>
        </div>
    </div>
    <div class="cards-row">
        <div class="card">
            <div class="card-title">User Activity Trend</div>
            <canvas id="userActivityChart" height="220"></canvas>
        </div>
        <div class="card">
            <div class="card-title">Submission Trends</div>
            <canvas id="submissionChart" height="220"></canvas>
        </div>
    </div>
</div>
<script>
    // User Activity Trend (Line Chart)
    new Chart(document.getElementById('userActivityChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($userActivityLabels); ?>,
            datasets: [{
                label: 'Active Users',
                data: <?php echo json_encode($userActivityData); ?>,
                borderColor: '#7b5434',
                backgroundColor: 'rgba(166,185,138,0.18)',
                pointBackgroundColor: '#7b5434',
                pointBorderColor: '#7b5434',
                pointRadius: 5,
                fill: true,
                tension: 0.3,
            }]
        },
        options: {
            plugins: { legend: { display: true } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#7b5434', font: { weight: 600 } } },
                y: { grid: { color: '#e6e6e6' }, ticks: { color: '#7b5434', font: { weight: 600 } }, beginAtZero: true }
            }
        }
    });
    // Submission Trends (Bar Chart)
    new Chart(document.getElementById('submissionChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($submissionLabels); ?>,
            datasets: [{
                label: 'Submissions',
                data: <?php echo json_encode($submissionData); ?>,
                backgroundColor: '#a6b98a',
                borderRadius: 8,
                barPercentage: 0.6,
                categoryPercentage: 0.7,
            }]
        },
        options: {
            plugins: { legend: { display: true } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#7b5434', font: { weight: 600 } } },
                y: { grid: { color: '#e6e6e6' }, ticks: { color: '#7b5434', font: { weight: 600 } }, beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>
