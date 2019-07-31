<?php
session_start();
require('../php/helper.php');
if (!empty($_POST['TaskCodeID']) && isset($_SESSION['user'])) {
    $taskCodeID = $_POST['TaskCodeID'];
    $query = "select * from Tasks where TaskCodeID=$taskCodeID";
    $res = mysqli_query($link,$query);
    if($res){
        $data = array();
        while($row = $res->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
    }
}
else{
    echo "something went wrong";
}