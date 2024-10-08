<?php
header("Access-Control-Allow-Origin: *");
include('../../config/db.php');

class API {
    private $db;

    public function __construct() {
        $this->db = new Connect;
    }

    public function Delete($email) {
        $query = $this->db->prepare("DELETE FROM newsLetter WHERE email = :email"); // Fixed the SQL syntax
        $query->bindParam(':email', $email, PDO::PARAM_INT);

        if($query->execute()) {
            echo 'You have successfully unsubscribed from our newsletter. We’re sorry to see you go, but you’ll no longer receive updates from us. If this was a mistake, feel free to subscribe again anytime!';
        } else {
            return json_encode(array("message" => "Error deleting blog content."));
        }
    }
}

$API = new API();

if(isset($_GET['email'])) {
    $email = intval($_GET['email']); // Ensure the ID is an integer

    echo $API->Delete($email);
}
?>
