<?php
require('../php/helper.php');
session_start();
$fields = array('TaskCodeID', 'Description', 'Name');
if (isFieldsSet($fields) && isset($_SESSION['user'])) {
    $taskCodeID = $_POST['TaskCodeID'];
    $description = $_POST['Description'];
    $name = $_POST['Name'];
    $isComplete = isset($_POST['IsComplete']) ? 1 : 0;
    //update task
    $query = "update Tasks set name='$name', description='$description',isComplete=$isComplete where taskcodeID=$taskCodeID";

    //return updated task
    if (mysqli_query($link, $query)) {
        $res = mysqli_query($link, "select * from Tasks where TaskCodeID=$taskCodeID");
        $dataArray = array();
        while ($row = $res->fetch_assoc()) {
            $dataArray[] = $row;
        }
        echo json_encode($dataArray);
    } else {
        echo "Failed to update";
    }
} else {
    echo "you went bottom";
}
