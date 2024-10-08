<?php
header("Access-Control-Allow-Origin: *");

// Get POST data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['message']) && isset($data['to'])) {
    $to = $data['to']; // Recipient's email address
    $subject = "New Message"; // Subject of the email
    $message = $data['message']; // Email message
    $headers = "From: info@herinitiative.or.tz" . "\r\n" . // Sender's email
               "Reply-To: info@herinitiative.or.tz" . "\r\n" . // Reply-to email
               "X-Mailer: PHP/" . phpversion(); // PHP version

    // Sending the email
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $to]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
}
?>
