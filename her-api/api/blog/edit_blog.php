<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include('../../config/db.php');

class API {
    private $db;

    public function __construct() {
        $this->db = new Connect;
    }

    public function Upload($title, $full_description, $id) {
        $query = $this->db->prepare("UPDATE blogs SET title = :title, full_description = :full_description WHERE id = :id");
        $query->bindParam(':title', $title);
        $query->bindParam(':full_description', $full_description);
        $query->bindParam(':id', $id);

        if($query->execute()) {
            return json_encode(array("message" => "Blog content updated successfully."));
        } else {
            return json_encode(array("message" => "Error uploading blog content."));
        }
    }
}

$API = new API();

// Check if it's an upload request
if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['full_description'])) {
    $title = $_POST['title'];
    $full_description = $_POST['full_description'];
    $id = $_POST['id'];

    echo $API->Upload($title, $full_description, $id);
}
?>
