<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../config/database.php';

use root_dev\Config\Database;

$db = Database::connect();

// Get all admins only
$adminStmt = $db->query("SELECT id, username, email, 'admin' as role, created_at FROM admins");
$admins = $adminStmt->fetchAll(PDO::FETCH_ASSOC);

usort($admins, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});
?>

<div class="main-content">
    <h2>System Admins</h2>
    <p>List of all admins who can log in.</p>
    <div style="overflow-x:auto;">
        <table class="table-logs">
            <thead>
                <tr>
                    <th>Created At</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.table-logs {
    width: 100%;
    border-collapse: collapse;
    margin-top: 2rem;
    background: #fff;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.table-logs th, .table-logs td {
    padding: 0.8rem 1.2rem;
    border-bottom: 1px solid #eee;
    text-align: left;
}
.table-logs th {
    background: #f5ede3;
    color: #7b5434;
    font-weight: 700;
}
.table-logs tr:last-child td {
    border-bottom: none;
}
</style>
