<?php
require_once __DIR__ . '/../models/knowledgeModel.php';

function getAllKnowledge() {
    return fetchKnowledgeFromDB();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_knowledge'])) {
    // Handle file upload
    $target_dir = __DIR__ . "/../assets/images/knowledge/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Check if image file is a actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        die("File is not an image.");
    }
    
    // Check file size (5MB max)
    if ($_FILES["image"]["size"] > 5000000) {
        die("Sorry, your file is too large.");
    }
    
    // Allow certain file formats
    if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg") {
        die("Sorry, only JPG, JPEG & PNG files are allowed.");
    }
    
    // Upload file
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Prepare data for database
        $data = [
            'coffee_type' => $_POST['coffee_type'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'image' => '/app/assets/images/knowledge/' . $new_filename
        ];
        
        // Save to database
        if (addKnowledgeToDB($data)) {
            // Redirect back to knowledge page
            header("Location: /app/views/admin/knowledge.php");
            exit();
        } else {
            die("Error saving knowledge to database.");
        }
    } else {
        die("Error uploading file. Please make sure the directory has proper write permissions.");
    }
}
