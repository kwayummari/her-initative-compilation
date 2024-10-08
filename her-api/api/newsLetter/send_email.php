<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json"); // Set content type to JSON
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get POST data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Validate the input data
    // Sample email addresses for testing
    $sampleEmails = [
        'developerkwayu@gmail.com',
        'msiluandrew2020@gmail.com'
    ];
    
    // You can select the first sample email for testing
    $to = $sampleEmails[0]; // Change this to any email from the sample array for testing
    $subject = "New Message"; // Subject of the email
    $message = "Hello, this is a test message."; // Email message

    // Set the headers for the email
    $headers = "From: newsletter@herinitiative.or.tz\r\n" . // Sender's email
               "Reply-To: newsletter@herinitiative.or.tz\r\n" . // Reply-to email
               "X-Mailer: PHP/" . phpversion(); // PHP version

    // Attempt to send the email
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
    }

