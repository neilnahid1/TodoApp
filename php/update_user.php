<?php
session_start();
require('../php/helper.php');
$fields = array('UserID,Username,RoleID');
if (isset($_SESSION['user']) && !empty($_POST['UserID']) && !empty($_POST['Username']) && !empty($_POST['RoleID'])) {
    $username = $_POST['Username'];
    $roleID = $_POST['RoleID'];
    $userID = $_POST['UserID'];
    if (!empty($_POST['Password'])) {
        $password = password_hash($_POST['Password'], PASSWORD_BCRYPT);
        $query = "update Users set username='$username',password='$password',roleid=$roleID where userID =$userID";
    } else {
        $query = "update Users set username='$username',roleid=$roleID where userID = $userID";
    }
    if (mysqli_query($link, $query)) {
        echo "Successfully updated.";
    } else {
        echo mysqli_error($link);
    }
} else {
    echo "wassap";
}