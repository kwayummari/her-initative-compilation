<?php
header("Access-Control-Allow-Origin: *");
include('../../config/db.php');

class API{
    function Select(){
        $db = new Connect;
        $users = array();
        
        $data = $db->prepare("SELECT * FROM blogs WHERE category = '1' ORDER BY id DESC");
        $data->execute();
        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)){
            $user = array(
                'id'  => $OutputData['id'],
                'image'  => $OutputData['image'],
                'title'  => $OutputData['title'],
                'description'  => $OutputData['description'],
                'full_description'  => $OutputData['full_description'],
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

