<?php
require("../php/config.php");
require("../php/helper.php");

function addUser($data)
{
    //$data may be $_GET, $_POST, depending on the request type
    global $link;
    $username = $data['username'];
    $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
    $firstName = $data['FirstName'];
    $lastName = $data['LastName'];
    $address = $data['Address'];
    $email = $data['EmailAddress'];
    $query = "insert into Users(username,password,fname,lname,address,emailaddress,roleID) values('$username','$hashedPassword',2);";
    if (mysqli_query($link, $query)) {
        echo "Successfully Registered.";
    } else {
        echo mysqli_error($link);
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
    $roleID = $data['roleID'];
    $userID = data['UserID'];
    $query = "update Users set username='$username',password='$hashedPassword',firstname='$firstName',lastname='$lastName', address='$address',emailaddress='$email',roleID=$roleID where userid=$userID";
    if (mysqli_query($link, $query)) {
        echo "Successfully updated";
    } else {
        echo mysqli_error($link);
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
function getUser($UserID)
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
