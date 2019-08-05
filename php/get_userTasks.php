<?php
session_start();
require('../php/helper.php');
if (isset($_POST['UserID']) && isset($_SESSION['user'])) {
    $query = "select TaskCodeID,Name,Description,IsComplete from Tasks where UserID={$_POST['UserID']}";
if ($res = mysqli_query($link, $query)) {
    if ($res->num_rows) {
        echo convertResultToJSON($res);
    }
} else {

    echo $query;
}
}
else{
    echo "invalid request";
}
