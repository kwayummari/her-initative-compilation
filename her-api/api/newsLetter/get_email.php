<?php
header("Access-Control-Allow-Origin: *");
include('../../config/db.php');

class API{
    function Select(){
        $db = new Connect;
        $users = array();
        
        $data = $db->prepare("SELECT * FROM newsLetter ORDER BY id DESC");
        $data->execute();
        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
            $user = array(
                'id'  => $OutputData['id'],
                'email'  => $OutputData['email'],
                'date'  => $OutputData['date'],
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

