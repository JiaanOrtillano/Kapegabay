<?php require_once __DIR__ . '/layouts/header.php'; ?>

<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<?php
// require_once __DIR__ . '/layouts/header.php';

// Connect to the database
$db = new PDO('sqlite:' . __DIR__ . '/../../database.sqlite');

// Fetch current settings
$stmt = $db->query('SELECT * FROM system LIMIT 1');
$settings = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle AJAX form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    $response = ['success' => false, 'message' => ''];
    
    try {
        $platform_name = $_POST['platform_name'] ?? '';
        $language = $_POST['language'] ?? '';
        $logo_path = $settings['logo'];

        // Handle logo upload
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = __DIR__ . '/../../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $filename = 'logo_' . time() . '.' . $ext;
            $target_path = $upload_dir . $filename;

            // Delete old logo if it exists and is not blank
            if (!empty($settings['logo'])) {
                $old_logo_path = __DIR__ . '/../../' . $settings['logo'];
                if (file_exists($old_logo_path)) {
                    unlink($old_logo_path);
                }
            }

            if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_path)) {
                $logo_path = 'uploads/' . $filename;
            }
        }

        // Update the system table
        $stmt = $db->prepare('UPDATE system SET logo = ?, platform_name = ?, language = ? WHERE id = 1');
        $stmt->execute([$logo_path, $platform_name, $language]);

        $response['success'] = true;
        $response['message'] = 'Settings updated successfully';
        $response['logo'] = $logo_path;
        $response['platform_name'] = $platform_name;
        $response['language'] = $language;
    } catch (Exception $e) {
        $response['message'] = 'Error updating settings: ' . $e->getMessage();
    }
    
    echo json_encode($response);
    exit;
}
?>

<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-10 w-full max-w-xl">
        <h2 class="text-2xl font-bold text-brown-700 mb-8">Settings</h2>
        <form id="settingsForm" method="POST" enctype="multipart/form-data" class="space-y-8">
            <input type="hidden" name="ajax" value="1">
            <div>
                <label class="block text-lg font-semibold text-gray-700 mb-2">Branding</label>
                <div id="logoPreview">
                    <?php if (!empty($settings['logo'])): ?>
                        <img src="/<?php echo htmlspecialchars($settings['logo']); ?>" alt="Logo" class="max-h-16 mb-4 rounded shadow border">
                    <?php endif; ?>
                </div>
                <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200 mb-4">
                <input type="text" name="platform_name" value="<?php echo htmlspecialchars($settings['platform_name']); ?>" placeholder="Platform Name" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-300">
            </div>
            <div>
                <label class="block text-lg font-semibold text-gray-700 mb-2">Language</label>
                <select name="language" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-300">
                    <option value="English" <?php if ($settings['language'] === 'English') echo 'selected'; ?>>English</option>
                    <option value="Tagalog" <?php if ($settings['language'] === 'Tagalog') echo 'selected'; ?>>Tagalog</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-8 rounded shadow transition">Save</button>
            </div>
        </form>
        <div id="message" class="mt-4 text-center hidden"></div>
    </div>
</div>

<script>
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageDiv = document.getElementById('message');
    const submitButton = this.querySelector('button[type="submit"]');
    
    // Disable submit button and show loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Saving...';
    
    fetch(window.location.href, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update logo preview if new logo was uploaded
            if (data.logo) {
                const logoPreview = document.getElementById('logoPreview');
                logoPreview.innerHTML = `<img src="/${data.logo}" alt="Logo" class="max-h-16 mb-4 rounded shadow border">`;
            }
            
            // Show success message
            messageDiv.textContent = data.message;
            messageDiv.className = 'mt-4 text-center text-green-600';
            messageDiv.classList.remove('hidden');
            
            // Hide message after 3 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        messageDiv.textContent = error.message;
        messageDiv.className = 'mt-4 text-center text-red-600';
        messageDiv.classList.remove('hidden');
    })
    .finally(() => {
        // Re-enable submit button
        submitButton.disabled = false;
        submitButton.textContent = 'Save';
    });
});
</script>
