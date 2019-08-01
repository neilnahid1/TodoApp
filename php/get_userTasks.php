<?php
session_start();
require('../php/helper.php');
if (isset($_POST['UserID']) && isset($_SESSION['user'])) {
    $query = "select * from Tasks where UserID={$_POST['UserID']}";
    $result = mysqli_query($link, $query);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
}
else{
    echo "invalid request";
}
