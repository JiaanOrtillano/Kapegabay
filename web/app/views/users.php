<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../config/database.php';
use root_dev\Config\Database;

$db = Database::connect();
// Fetch all users (farmers)
$sql = "SELECT id, username, email, created_at as date_registered, role as status FROM users WHERE role != 'admin' ORDER BY created_at DESC";
$stmt = $db->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Registry</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #efefef;
            font-family: 'Montserrat', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .main-content {
            margin-left: 250px;
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .registry-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }
        .registry-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #7b5434;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .search-box {
            background: #fff;
            border-radius: 0.5rem;
            border: none;
            padding: 0.7rem 1.2rem;
            font-size: 1rem;
            color: #7b5434;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            outline: none;
            min-width: 220px;
        }
        .table-container {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 1.2rem 1.2rem 0.5rem 1.2rem;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 1rem;
        }
        thead tr {
            background: #f5ede3;
        }
        th, td {
            padding: 0.85rem 1rem;
            text-align: left;
        }
        th {
            color: #7b5434;
            font-weight: 700;
            font-size: 0.98rem;
        }
        tbody tr {
            border-bottom: 1px solid #f0e6d6;
        }
        tbody tr:last-child {
            border-bottom: none;
        }
        .status {
            font-weight: 600;
            border-radius: 0.7rem;
            padding: 0.3rem 1rem;
            font-size: 0.98rem;
            display: inline-block;
        }
        .status.verified {
            color: #3a7d3a;
            background: #e6f7e6;
        }
        .status.pending {
            color: #b97a2a;
            background: #fff5e6;
        }
        @media (max-width: 1100px) {
            .main-content {
                margin-left: 0;
                padding: 1.2rem 0.5rem;
            }
            .table-container {
                padding: 0.5rem 0.2rem 0.2rem 0.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="registry-header">
            <div class="registry-title">
                <svg width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="16" height="16" rx="4" stroke="#7b5434" stroke-width="1.5"/></svg>
                User Management
            </div>
            <input type="text" class="search-box" placeholder="Search Farmers..." onkeyup="searchTable(this.value)">
        </div>
        <div class="table-container">
            <table id="farmers-table">
                <thead>
                    <tr>
                        <th>FARMER ID</th>
                        <th>USERNAME</th>
                        <th>EMAIL</th>
                        <th>DATE REGISTERED</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['date_registered']); ?></td>
                        <td>
                            <button onclick="deleteUser(<?php echo $user['id']; ?>)" class="delete-btn" style="background: #ff4444; color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; cursor: pointer; font-size: 0.9rem;">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function searchTable(value) {
            value = value.toLowerCase();
            const rows = document.querySelectorAll('#farmers-table tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                fetch('app/views/delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'user_id=' + userId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User deleted successfully');
                        location.reload();
                    } else {
                        alert('Error deleting user: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the user');
                });
            }
        }
    </script>
</body>
</html>
<?php Database::close(); ?>