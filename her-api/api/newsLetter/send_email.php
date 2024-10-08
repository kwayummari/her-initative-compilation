<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Make sure the path is correct

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['message'])) {
    $to = 'developerkwayu@gmail.com'; // Recipient's email address
    $subject = "New Message"; // Subject of the email
    $message = $data['message']; // Email message

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.titan.email'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'newsletter@herinitiative.or.tz'; // SMTP username
        $mail->Password = 'Gudboy24@'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('newsletter@herinitiative.or.tz', 'Her Initiative');
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = nl2br($message); // Convert new lines to HTML line breaks

        // Send the email
        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully!']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email. Mailer Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Message field is required.']);
}
