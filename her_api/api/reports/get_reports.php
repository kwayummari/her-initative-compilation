<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include('../../config/db.php');

class API{
    function Select(){
        $db = new Connect;
        $users = array();
        
        $data = $db->prepare("SELECT * FROM reports ORDER BY id DESC");
        $data->execute();
        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
            $user = array(
                'id'  => $OutputData['id'],
                'pdf'  => $OutputData['pdf'],
                'title'  => $OutputData['title'],
                'description'  => $OutputData['description'],
            );
            array_push($users,$user);
        }
        return json_encode($users);
    }
}
$API = new API; 
header('Content-Type: application/json');
echo $API -> Select()

?>

