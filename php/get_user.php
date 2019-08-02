<?php
require('../php/helper.php');
session_start();
if(isset($_SESSION['user']) && isset($_POST['UserID'])){
    $query = "select UserID,Username,RoleID from Users where UserID={$_POST['UserID']}";
    if($result = mysqli_query($link,$query)){
        echo json_encode($result->fetch_assoc()); 
    }
    else{
        echo mysqli_error($link);
    }
}
