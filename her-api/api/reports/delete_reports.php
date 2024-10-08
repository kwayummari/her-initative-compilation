<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include('../../config/db.php');

class API {
    private $db;

    public function __construct() {
        $this->db = new Connect;
    }

    public function Delete($id) {
        $query = $this->db->prepare("DELETE FROM reports WHERE id = :id"); // Fixed the SQL syntax
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        if($query->execute()) {
            return json_encode(array("message" => "Report deleted successfully."));
        } else {
            return json_encode(array("message" => "Error deleting report."));
        }
    }
}

$API = new API();

if(isset($_POST['id'])) {
    $id = intval($_POST['id']); // Ensure the ID is an integer

    echo $API->Delete($id);
}
?>
