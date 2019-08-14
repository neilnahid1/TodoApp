<?php
require('../config.php');
require('../utilities/helper.php');
function addUser($data)
{
    //$data may be $_GET, $_POST, depending on the request type
    global $link;
    $username = $data['Username'];
    $hashedPassword = password_hash($data['Password'], PASSWORD_BCRYPT);
    $firstName = $data['FirstName'];
    $lastName = $data['LastName'];
    $address = $data['Address'];
    $email = $data['EmailAddress'];
    $activationCode = uniqid($username);
    $query = "insert into Users(username,password,firstname,lastname,address,emailaddress,roleID,activationCode) values('$username','$hashedPassword','$firstName','$lastName','$address','$email',2,'$activationCode');";
    if (mysqli_query($link, $query)) {
        sendEmailVerification(mysqli_insert_id($link), $email, $activationCode);
    } else {
        printError($link);
    }
}
function updateUser($data)
{
    //$data may be $_GET, $_POST, depending on the request type
    global $link;
    $username = $data['Username'];
    $hashedPassword = password_hash($data['Password'], PASSWORD_BCRYPT);
    $firstName = $data['FirstName'];
    $lastName = $data['LastName'];
    $address = $data['Address'];
    $email = $data['EmailAddress'];
    $roleID = $data['RoleID'];
    $userID = $data['UserID'];
    $query = "update Users set username='$username',password='$hashedPassword',firstname='$firstName',lastname='$lastName', address='$address',emailaddress='$email',roleID=$roleID where userid=$userID";
    if (mysqli_query($link, $query)) {
        $query = "select * from Users where userid=$userID";
        $result = mysqli_query($link, $query)->fetch_assoc();
        session_start();
        if ($_SESSION['user']['UserID'] == $userID && !empty($_SESSION['Password'])) {
            echo "SUCCESS: REDIRECT";
            session_destroy();
        } else if ($_SESSION['user']['UserID'] == $userID && empty($_SESSION['Password'])) {
            $_SESSION['user'] = $result;
            echo "Successfully updated";
        } else {
            echo "Successfully updated";
        }
    } else {
        printError($link);
    }
}
function deleteUser($UserID)
{
    global $link;
    $query = "delete from Users where UserID=$UserID";
    if (mysqli_query($link, $query)) {
        echo "Successfully deleted!";
    } else {
        echo mysqli_error($link);
    }
}
function getUseById(int $UserID)
{
    global $link;
    $query = "select * from Users where userid=$UserID";
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        echo mysqli_error($link);
    } else {
        echo convertResultToJSON($result);
    }
}
function getUsers()
{
    global $link;
    $query = "select userid,firstname,lastname,address,username,emailaddress,roleid from Users where roleid=2";
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        echo mysqli_error($link);
    } else {
        echo convertResultToJSON($result);
    }
}
function sendEmailVerification($userid, $emailAddress, $activationCode)
{
    global $link;
    $subject = "Complete Registration: Todo App";
    $message = "Thank you for using the Todo app! Click on the link below to complete your registration\n
    http://localhost:3000/activate.php?activationCode=$activationCode";
    $headers =  'MIME-Version: 1.0' . "\r\n";
    $headers .= 'From: Your name <info@address.com>' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail($emailAddress, $subject, $message, $headers);
    echo "A verification link was sent to your email address.";
}
