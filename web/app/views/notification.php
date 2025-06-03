<?php
// You can add PHP logic notificationModel.phphere later for handling form submissions
require_once __DIR__ . '/../models/notificationModel.php';

// Initialize error log
error_log("Notification system started - " . date('Y-m-d H:i:s'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $message = $_POST['message'] ?? '';
    $imagePath = '';

    error_log("Attempting to create notification - Title: " . $title);

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . '/../assets/images/notifications/';
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
            error_log("Created notification images directory");
        }
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($file_extension, $allowed) && move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $imagePath = '/app/assets/images/notifications/' . $new_filename;
            error_log("Image uploaded successfully: " . $new_filename);
        } else {
            error_log("Image upload failed - Invalid file type or upload error");
        }
    }

    $data = [
        'title' => $title,
        'message' => $message,
        'image' => $imagePath
    ];

    if (addNotificationToDB($data)) {
        error_log("Notification created successfully - ID: " . (isset($data['id']) ? $data['id'] : 'unknown'));
        header('Location: /app/views/notification.php?success=1');
        exit();
    } else {
        error_log("Failed to create notification in database");
        header('Location: /app/views/notification.php?error=1');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Notification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#f5ede3] font-[Montserrat,Arial,sans-serif] flex">
<?php require_once __DIR__ . '/layouts/header.php'; ?>
    <main class="flex-1 p-10">
        <?php if (isset($_GET['success'])): ?>
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Notification has been sent successfully.',
                icon: 'success',
                confirmButtonColor: '#a6b98a'
            });
        </script>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: 'Failed to send notification. Please try again.',
                icon: 'error',
                confirmButtonColor: '#a6b98a'
            });
        </script>
        <?php endif; ?>
        <div class="bg-white rounded-xl shadow p-10 max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-[#7b5434]">Create Notification</h1>
                <a href="view_notification" class="bg-[#a6b98a] text-white px-6 py-2 rounded-lg font-semibold text-base shadow hover:bg-[#7b5434] transition">View Sent Notifications</a>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="block text-[#7b5434] font-medium mb-2">Title</label>
                    <input type="text" name="title" placeholder="Enter Notifications Title" class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] focus:outline-none focus:border-[#7b5434]" required>
                </div>
                <div>
                    <label class="block text-[#7b5434] font-medium mb-2">Message</label>
                    <textarea name="message" placeholder="Enter message details.." rows="4" class="w-full px-4 py-2 rounded-lg border border-[#e6d3c0] focus:outline-none focus:border-[#7b5434]" required></textarea>
                </div>
                <div>
                    <label class="block text-[#7b5434] font-medium mb-2">Upload Image</label>
                    <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#a6b98a] file:text-white hover:file:bg-[#7b5434]" />
                </div>
                <button type="submit" class="w-full bg-[#a6b98a] text-white py-3 rounded-lg font-semibold text-lg shadow hover:bg-[#7b5434] transition">Send Notifications</button>
            </form>
        </div>
    </main>
</body>
</html>
