<?php
require('../php/helper.php');
session_start();
redirectIfNoSession();
if (isset($_POST['UserID'])) {
    $query = "delete from Tasks where UserID={$_POST['UserID']}";
    if (mysqli_query($link, $query)) {
        echo "Successfully deleted all tasks.";
     }
     else {
         echo mysqli_error($link);
     }
}
