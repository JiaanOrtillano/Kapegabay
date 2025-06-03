<?php
require_once __DIR__ . '/layouts/header.php';

// Connect to the SQLite database
$db = new PDO('sqlite:' . __DIR__ . '/../../../database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch all RSBA submissions
$stmt = $db->query('SELECT * FROM rsba_submissions ORDER BY date_submitted DESC');
$rsbaList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sent Notifications</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head> 
<div class="main-content ml-[250px] p-10 w-full min-h-screen bg-[#f5ede3] font-[Montserrat,Arial,sans-serif] mr-20">
    <div class="text-3xl font-bold text-[#7b5434] mb-2">RSBA Submissions</div>
    <div class="mb-7">
        <input class="w-full max-w-lg px-5 py-3 rounded-xl border border-[#e6d3c0] text-base outline-none focus:border-[#7b5434] focus:ring-2 focus:ring-[#a6b98a] transition" type="text" placeholder="Search Topics" />
    </div>
    <div class="bg-white rounded-xl shadow p-8">
        <table class="w-full text-left border-separate border-spacing-y-2">
            <thead>
                <tr class="border-b text-[#7b5434] text-base">
                    <th class="py-3 px-4 font-semibold">Name</th>
                    <th class="py-3 px-4 font-semibold">Barangay</th>
                    <th class="py-3 px-4 font-semibold">Date Submitted</th>
                    <th class="py-3 px-4 font-semibold">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rsbaList as $row): ?>
                <tr class="bg-[#f9f6f2] hover:bg-[#e6d3c0] transition rounded-xl shadow-sm">
                    <td class="py-3 px-4 rounded-l-xl"><?= htmlspecialchars($row['full_name']) ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($row['barangay']) ?></td>
                    <td class="py-3 px-4"><?= htmlspecialchars($row['date_submitted']) ?></td>
                    <td class="py-3 px-4 rounded-r-xl">
                        <button class="bg-[#a6b98a] text-white px-6 py-2 rounded-lg font-medium shadow hover:bg-[#7b5434] transition" onclick="showModal(<?= $row['id'] ?>)">View</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="rsbaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-8 w-full max-w-xl relative shadow-lg border border-[#e6d3c0]">
            <button onclick="toggleModal(false)" class="absolute top-4 right-4 text-gray-400 hover:text-[#7b5434] text-3xl font-bold transition">&times;</button>
            <div id="modalContent"></div>
        </div>
    </div>
</div>

<script>
    const rsbaData = <?php echo json_encode($rsbaList); ?>;
    function showModal(id) {
        const data = rsbaData.find(item => item.id == id);
        if (!data) return;
        let html = `<div class='font-bold text-2xl mb-6 text-[#7b5434]'>RSBA Form Information</div>`;
        html += `<div class='space-y-3 text-base text-[#4d2e13]'>`;
        html += `<div><span class='font-semibold'>Full Name:</span> ${data.full_name}</div>`;
        html += `<div><span class='font-semibold'>Birthday:</span> ${data.birthday}</div>`;
        html += `<div><span class='font-semibold'>Gender:</span> ${data.gender}</div>`;
        html += `<div><span class='font-semibold'>Contact Number:</span> ${data.contact_number}</div>`;
        html += `<div><span class='font-semibold'>Barangay:</span> ${data.barangay}</div>`;
        html += `<div><span class='font-semibold'>Municipality:</span> ${data.municipality}</div>`;
        html += `<div><span class='font-semibold'>Province:</span> ${data.province}</div>`;
        html += `<div><span class='font-semibold'>Farm Size (hectares):</span> ${data.farm_size}</div>`;
        html += `<div><span class='font-semibold'>Type of Crop:</span> ${data.type_of_crop}</div>`;
        html += `<div><span class='font-semibold'>Type of Land:</span> ${data.type_of_land}</div>`;
        html += `<div><span class='font-semibold'>Reason for RSBA Request:</span> ${data.reason}</div>`;
        html += `<div><span class='font-semibold'>Date Submitted:</span> ${data.date_submitted}</div>`;
        html += `</div>`;
        document.getElementById('modalContent').innerHTML = html;
        toggleModal(true);
    }
    function toggleModal(show) {
        const modal = document.getElementById('rsbaModal');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
</script>
