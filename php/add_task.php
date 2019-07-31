<?php
session_start();
require('../php/helper.php');
if (!empty($_POST['iTaskName']) && isset($_SESSION['user'])) {
    $taskName = $_POST['iTaskName'];
    $description = $_POST['iDescription'];
    $user = $_SESSION['user'];
    $query = "insert into Tasks(Name,Description,UserID,IsComplete)values('$taskName','$description',{$user['UserID']},0)";
    if (mysqli_query($link, $query)) {
        $id =  mysqli_insert_id($link);
        $res = mysqli_query($link, "select * from Tasks where TaskCodeID=$id");

        $data = array(); // initialise data array to storing result from query
        //convert $res into array
        while ($row = $res->fetch_assoc()) {
            $data[] = $row;
        }
        //send the jsonized data as response
        echo json_encode($data);
    } else
        echo "Something went wrong, and I don't know why";
} else {
    echo "either task name or user was not set.";
}
