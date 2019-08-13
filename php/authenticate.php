<?php
require('../php/config.php');
require_once('../php/utilities/helper.php');
if (isFieldsSet($_POST)) {
    global $link;
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $query = "select * from users where username='$username' and IsEmailVerified=1";
    $res = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        printError($link);
        die;
    } else {
        if (mysqli_num_rows($res) > 0) {
            $res = $res->fetch_assoc();
            if (password_verify($password, $res['Password'])) {
                session_start();
                $_SESSION['user'] = $res;
                echo "Successfully Logged In";
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User not exist/verified!";
        }
    }
} else {
    echo "Fields must not be empty.";
}
