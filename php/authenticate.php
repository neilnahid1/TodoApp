<?php
require('../php/config.php');
require_once('../php/utilities/helper.php');
if (isFieldsSet($_POST)) {
    global $link;
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $query = "select * from users where username='$username'";
    $res = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        printError($link);
        die;
    } else {
        if (mysqli_num_rows($res) > 0) {
            $res = convertResultToAssoc($res);
            if (password_verify($password, $res[0]['Password'])) {
                session_start();
                $_SESSION['user'] = $res;
                echo "Successfully Logged In";
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User does not exist!";
        }
    }
} else {
    echo "Fields must not be empty.";
}
