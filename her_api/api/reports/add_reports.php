<?php
header("Access-Control-Allow-Origin: *");
include('../../config/db.php');

class API{
    function Upload($title, $description, $pdf_file){
        $db = new Connect;

        // Upload PDF file
        $upload_dir = "pdf/"; // Directory where you want to save uploaded files
        $pdf_name = basename($pdf_file["name"]);
        $target_file = $upload_dir . $pdf_name;
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            return json_encode(array("message" => "File already exists."));
        }

        // Check file size
        if ($pdf_file["size"] > 11000000) { // Adjust the size limit according to your needs
            return json_encode(array("message" => "File is too large."));
        }

        // Allow certain file formats
        if($fileType != "pdf") {
            return json_encode(array("message" => "Only PDF files are allowed."));
        }

        // Upload file
        if (move_uploaded_file($pdf_file["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert details into the database
            $query = $db->prepare("INSERT INTO reports (title, description, pdf) VALUES (:title, :description, :pdf)");
            $query->bindParam(':title', $title);
            $query->bindParam(':description', $description);
            $query->bindParam(':pdf', $pdf_name);
            if($query->execute()) {
                return json_encode(array("message" => "File uploaded successfully."));
            } else {
                return json_encode(array("message" => "Error uploading file."));
            }
        } else {
            return json_encode(array("message" => "Error uploading file."));
        }
    }
}

$API = new API;

// Check if it's an upload request
if(isset($_FILES['pdf_file']) && isset($_POST['title']) && isset($_POST['description'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $pdf_file = $_FILES['pdf_file'];

    header('Content-Type: application/json');
    echo $API->Upload($title, $description, $pdf_file);
} else {
    // Otherwise, it's a request to fetch data
    header('Content-Type: application/json');
    echo $API->Select();
}
?>
