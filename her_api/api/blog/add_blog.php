<?php
header("Access-Control-Allow-Origin: *");
include('../../config/db.php');

class API{
    function Upload($title, $image, $description, $full_description, $category){
        $db = new Connect;

        // Upload Image file
        $upload_dir = "images/"; // Directory where you want to save uploaded images
        $image_name = basename($image["name"]);
        $target_file = $upload_dir . $image_name;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            return json_encode(array("message" => "Image file already exists."));
        }

        // Check file size
        if ($image["size"] > 5000000) { // Adjust the size limit according to your needs
            return json_encode(array("message" => "Image file is too large."));
        }

        // Allow certain file formats
        if (!in_array($imageFileType, array("jpg", "jpeg", "png", "gif"))) {
            return json_encode(array("message" => "Only JPG, JPEG, PNG, and GIF images are allowed."));
        }

        // Upload image file
        if (!move_uploaded_file($image["tmp_name"], $target_file)) {
            return json_encode(array("message" => "Error uploading image file."));
        }

        // Insert blog content into the database
        if (!empty($description)) {
            $query = $db->prepare("INSERT INTO blogs (title, image, description, full_description, category) VALUES (:title, :image, :description, :full_description, :category)");
            $query->bindParam(':description', $description);
        } else {
            $query = $db->prepare("INSERT INTO blogs (title, image, full_description, category) VALUES (:title, :image, :full_description, :category)");
        }
        $query->bindParam(':title', $title);
        $query->bindParam(':image', $image_name);
        $query->bindParam(':full_description', $full_description);
        $query->bindParam(':category', $category);
        
        if($query->execute()) {
            return json_encode(array("message" => "Blog content uploaded successfully."));
        } else {
            return json_encode(array("message" => "Error uploading blog content."));
        }
    }
}

$API = new API;

// Check if it's an upload request
if(isset($_FILES['image']) && isset($_POST['title']) && isset($_POST['full_description'])) {
    $title = $_POST['title'];
    $description = isset($_POST['description']) ? $_POST['description'] : ''; // Check if description is set
    $image = $_FILES['image'];
    $full_description = $_POST['full_description'];
    $category = $_POST['category'];

    header('Content-Type: application/json');
    echo $API->Upload($title, $image, $description, $full_description, $category);
} else {
    // Otherwise, it's a request to fetch data
    header('Content-Type: application/json');
    echo $API->Select();
}
?>
