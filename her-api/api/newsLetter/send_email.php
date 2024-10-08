<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Make sure the path is correct

$data = json_decode(file_get_contents('php://input'), true);

// Check if message and recipient email are provided in the request
if (isset($data['message']) && isset($data['to'])) {
    $to = $data['to']; // Recipient's email address from the request
    $subject = "Exciting News Inside! Discover Our Latest Updates"; // Subject of the email
    $message = $data['message']; // Email message from the request

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
        $mail->addAddress($to); // Add the recipient's email from the request

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;

        // HTML email body
        $htmlContent = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Your Newsletter Title</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background: #ffffff;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                h1 {
                    color: #333;
                }
                h2 {
                    color: #555;
                }
                p {
                    line-height: 1.6;
                    color: #666;
                }
                .footer {
                    text-align: center;
                    padding: 10px;
                    background: #e4e4e4;
                    border-radius: 5px;
                    margin-top: 20px;
                }
                .footer a {
                    text-decoration: none;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Hello ' . htmlspecialchars($to) . ',</h1>
                <h2>Your Monthly Newsletter</h2>
                <p>Welcome to our latest newsletter! We’re excited to share some great updates with you:</p>
                <p>' . nl2br(htmlspecialchars($message)) . '</p>
                <p>Thank you for being a valued member of our community. If you have any questions or feedback, feel free to reach out to us!</p>
                <p>Best regards,<br>The Her Initiative Team</p>
                <div class="footer">
                    <p>© ' . date("Y") . ' Her Initiative. All rights reserved.</p>
                    <p><a href="https://herinitiative.or.tz/her-api/api/newsLetter/unsubscribe.php?email=' . urlencode($to) . '">Unsubscribe</a> | <a href="tel:+255734283347">Contact Us</a></p>
                </div>
            </div>
        </body>
        </html>';

        $mail->Body = $htmlContent; // Set the HTML content

        // Send the email
        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Email sent successfully!']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email. Mailer Error: ' . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Message and recipient email are required.']);
}
