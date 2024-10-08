<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include('../../config/db.php');

class API {
    function AddSubscriber($email) {
        // Database connection
        $db = new Connect;

        // Validate the email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(array("message" => "Invalid email format."));
        }

        // Check if the email already exists in the database
        $checkQuery = $db->prepare("SELECT * FROM newsLetter WHERE email = :email");
        $checkQuery->bindParam(':email', $email);
        $checkQuery->execute();
        
        if ($checkQuery->rowCount() > 0) {
            return json_encode(array("message" => "Email is already subscribed."));
        }

        // Insert the email into the database
        $query = $db->prepare("INSERT INTO newsLetter (email) VALUES (:email)");
        $query->bindParam(':email', $email);
        
        if ($query->execute()) {
            return json_encode(array("message" => "Subscription successful."));
        } else {
            return json_encode(array("message" => "Error while subscribing."));
        }
    }
}

$API = new API;

// Check if the email field is set in the POST request
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    echo $API->AddSubscriber($email);
} else {
    // If email is not set, return an error message
    echo json_encode(array("message" => "Email not provided."));
}
?>