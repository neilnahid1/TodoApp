<?php
require('../php/helper.php');
session_start();
if (isset($_SESSION['user']) && isset($_POST['UserID'])) {
    //delete tasks first
    $query = "delete from Tasks where UserID={$_POST['UserID']}";
    if (mysqli_query($link, $query)) {
        $query = "delete from Users where UserID={$_POST['UserID']}";
        if (mysqli_query($link, $query)) {
            echo "Successfully deleted";
        } else {
            echo mysqli_error($link);
        }
    } else {
        echo mysqli_error($link);
    }
} else
    echo "failed";