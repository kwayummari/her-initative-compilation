<?php
header("Access-Control-Allow-Origin: *");
// require_once __DIR__ . '/connection.php';
include('../../config/db.php');

class API{
    function Select(){
        $db = new Connect;
        $users = array();
        $id = $_POST['id'];
        
        $data = $db->prepare("SELECT * FROM route WHERE destination_id = '".$id."'");
        $data->execute();
        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
            $user = array(
                'id'  => $OutputData['id'],
                'name'  => $OutputData['name'],
            );
            array_push($users,$user);
        }
        return json_encode($users);
    }
    // sendResponse(200, $user, 'news');
}
$API = new API; 
header('Content-Type: application/json');
echo $API -> Select()

?>