<?php
session_start();
require('../php/helper.php');
redirectIfNoSession(); // redirects user if session doesn't exists;
$query = "select TaskCodeID,Name,Description,IsComplete from Tasks where UserID={$_SESSION['user']['UserID']}";
if ($res = mysqli_query($link, $query)) {
    if ($res->num_rows) {
        echo convertResultToJSON($res);
    }
} else {
    echo "fetching tasks failed.";
}
