<?php
header("Access-Control-Allow-Origin: *");
include('../../config/db.php');

class API {
    private $db;

    public function __construct() {
        $this->db = new Connect;
    }

    public function Delete($email) {
        $query = $this->db->prepare("DELETE FROM newsLetter WHERE email = :email");
        $query->bindParam(':email', $email, PDO::PARAM_STR); // Fixing parameter type for email

        if ($query->execute()) {
            $this->sendUnsubscribeResponse($email);
        } else {
            echo json_encode(array("message" => "Error occurred while processing your request."));
        }
    }

    private function sendUnsubscribeResponse($email) {
        // HTML structure to return after successful unsubscription
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Unsubscribed Successfully</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    margin: 0;
                    padding: 20px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .container {
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                    max-width: 600px;
                    text-align: center;
                }
                .container h1 {
                    color: #f44336;
                    font-size: 24px;
                }
                .container p {
                    font-size: 16px;
                    line-height: 1.5;
                    margin: 20px 0;
                }
                .container a {
                    text-decoration: none;
                    color: #1a73e8;
                }
                .container .subscribe-again {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    background-color: #1a73e8;
                    color: #fff;
                    border-radius: 5px;
                    font-size: 16px;
                    transition: background-color 0.3s ease;
                }
                .container .subscribe-again:hover {
                    background-color: #1558b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>You\'ve Unsubscribed</h1>
                <p>We\'re sorry to see you go! You\'ve successfully unsubscribed from our newsletter using the email <strong>' . htmlspecialchars($email) . '</strong>. You will no longer receive updates and promotions from us.</p>
                <p>If this was a mistake, feel free to <a href="https://herinitiative.or.tz/subscribe">subscribe again</a> anytime. We\'re always happy to have you!</p>
                <a class="subscribe-again" href="https://herinitiative.or.tz/subscribe">Subscribe Again</a>
            </div>
        </body>
        </html>';
    }
}

$API = new API();

if (isset($_GET['email'])) {
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL); // Sanitize email input

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $API->Delete($email);
    } else {
        echo json_encode(['message' => 'Invalid email format.']);
    }
} else {
    echo json_encode(['message' => 'Email parameter is missing.']);
}
