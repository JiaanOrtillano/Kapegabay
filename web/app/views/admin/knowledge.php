<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../controller/knowledgeController.php';

$knowledgeList = getAllKnowledge();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Knowledge Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5ede3] font-[Montserrat,Arial,sans-serif] flex">
    <!-- Add Knowledge Modal -->
    <div id="addKnowledgeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-8 w-full max-w-2xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-[#7b5434]">Add New Knowledge</h2>
                <button onclick="toggleModal(false)" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="/app/controller/knowledgeController.php" method="POST" enctype="multipart/form-data">
                <div class="space-y-4">
                    <div>
                        <label class="block text-[#7b5434] font-medium mb-2">Coffee Type</label>
                        <select name="coffee_type" required class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] focus:outline-none focus:border-[#7b5434]">
                            <option value="Arabica">Arabica</option>
                            <option value="Robusta">Robusta</option>
                            <option value="Liberica">Liberica</option>
                            <option value="Excelsa">Excelsa</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[#7b5434] font-medium mb-2">Title</label>
                        <input type="text" name="title" required class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] focus:outline-none focus:border-[#7b5434]">
                    </div>
                    <div>
                        <label class="block text-[#7b5434] font-medium mb-2">Description</label>
                        <textarea name="description" required rows="4" class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] focus:outline-none focus:border-[#7b5434]"></textarea>
                    </div>
                    <div>
                        <label class="block text-[#7b5434] font-medium mb-2">Image</label>
                        <input type="file" name="image" required accept="image/*" class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] focus:outline-none focus:border-[#7b5434]">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <button type="button" onclick="toggleModal(false)" class="px-6 py-2 rounded-lg border border-[#7b5434] text-[#7b5434] font-medium hover:bg-[#7b5434] hover:text-white transition">Cancel</button>
                    <button type="submit" name="add_knowledge" class="px-6 py-2 rounded-lg bg-[#a6b98a] text-white font-medium hover:bg-[#7b5434] transition">Add Knowledge</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal + Main Content (as-is) -->
    <div class="main-content ml-[250px] p-10 w-full min-h-screen">
        <div class="text-3xl font-bold text-[#7b5434] mb-2">Knowledge Hub</div>
        <div class="text-[#7b5434] text-base mb-7">Explore guides, tips, and tutorials about coffee farming.</div>

        <!-- Search + Add Button -->
        <div class="flex justify-between items-center mb-4">
            <input class="w-full max-w-lg px-5 py-3 rounded-xl border border-[#e6d3c0] text-base outline-none" type="text" placeholder="Search Topics" />
            <button onclick="toggleModal(true)" class="ml-4 bg-[#a6b98a] text-white px-6 py-2 rounded-lg font-semibold text-base hover:bg-[#7b5434] transition">+ Add Knowledge</button>
        </div>

        <!-- Filter Buttons -->
        <div class="flex gap-8 border-b border-gray-200 mb-6">
            <button class="text-[#7b5434] text-base font-medium py-2 px-5 rounded-t-xl hover:bg-[#e6d3c0] transition">All</button>
            <button class="text-[#7b5434] text-base font-medium py-2 px-5 rounded-t-xl hover:bg-[#e6d3c0] transition">Arabica</button>
            <button class="text-[#7b5434] text-base font-medium py-2 px-5 rounded-t-xl hover:bg-[#e6d3c0] transition">Robusta</button>
            <button class="text-[#4d2e13] text-base font-bold py-2 px-5 rounded-t-xl bg-[#e6d3c0]">Liberica</button>
            <button class="text-[#7b5434] text-base font-medium py-2 px-5 rounded-t-xl hover:bg-[#e6d3c0] transition">Excelsa</button>
        </div>

        <!-- Knowledge List -->
        <div class="bg-white rounded-xl shadow p-8">
            <?php foreach ($knowledgeList as $knowledge): ?>
                <div class="flex items-center text-[#7b5434] font-bold text-lg mb-6 gap-2">
                    <span>☕</span>
                    <span><?= htmlspecialchars($knowledge['coffee_type']) ?></span>
                </div>
                <div class="flex gap-4 mb-8 items-start">
                    <img class="w-24 h-24 rounded-lg object-cover shadow" src="<?= htmlspecialchars($knowledge['image']) ?>" alt="<?= htmlspecialchars($knowledge['title']) ?>" />
                    <div class="flex-1">
                        <div class="flex items-center gap-2 text-[#7b5434] font-semibold text-base mb-1">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a9.001 9.001 0 1 0 2.649 2.648M19 7V4a1 1 0 0 0-1-1h-3"></path></svg>
                            <?= htmlspecialchars($knowledge['title']) ?>
                        </div>
                        <div class="text-[#4d2e13] text-sm leading-relaxed">
                            <?= nl2br(htmlspecialchars($knowledge['description'])) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="flex justify-end">
                <button class="bg-[#a6b98a] text-white px-8 py-2 rounded-lg font-semibold text-base hover:bg-[#7b5434] transition">Next</button>
            </div>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
        function toggleModal(show) {
            document.getElementById('addKnowledgeModal').classList.toggle('hidden', !show);
        }
    </script>
</body>
</html>
