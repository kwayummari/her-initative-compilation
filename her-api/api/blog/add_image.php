<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Directory where you want to store uploaded images
    $uploadDirectory = 'images/';

    $filename = uniqid() . '_' . basename($_FILES['file']['name']); // Sanitize filename
    $targetPath = $uploadDirectory . $filename;

    // Check file extension if needed
    $fileExtension = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
        http_response_code(400);
        echo json_encode(["error" => "Only JPG, JPEG, PNG, and GIF files are allowed."]);
        exit;
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        $fileUrl = "https://herinitiative.or.tz/her-api/api/blog/images/$filename";
        echo json_encode([
            "success" => 1,
            "file" => [
                "url" => $fileUrl
            ]
        ]);
    } else {
        // Failed to move the uploaded file
        http_response_code(500);
        echo json_encode(["error" => "Failed to move uploaded file."]);
    }
} else {
    // No file uploaded or an error occurred during upload
    http_response_code(400);
    echo json_encode(["error" => "No file uploaded or an error occurred."]);
}
?>
