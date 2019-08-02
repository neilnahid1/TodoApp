<?php
session_start();
require('../php/helper.php');
checkIfSessionExists();
if (!empty($_POST['TaskCodeID']) && isset($_SESSION['user'])) {
    $query = "delete from Tasks where TaskCodeID={$_POST['TaskCodeID']}";
    if (mysqli_query($link, $query)) {
        //successfully deleted
        echo "success";
    } else {
        //something went wrong
        echo "did not successfully deleted"; 
    }
} else {
    echo "something's not right";
}
