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
    $query = "insert into Users(username,password,firstname,lastname,address,emailaddress,roleID) values('$username','$hashedPassword','$firstName','$lastName','$address','$email',2);";
    if (mysqli_query($link, $query)) {
        echo "Successfully Registered.";
    } else {
        echo "ERROR CODE: ".mysqli_errno($link);
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
    $userID = data['UserID'];
    $query = "update Users set username='$username',password='$hashedPassword',firstname='$firstName',lastname='$lastName', address='$address',emailaddress='$email',roleID=$roleID where userid=$userID";
    if (mysqli_query($link, $query)) {
        echo "Successfully updated";
    } else {
        echo mysqli_errno($link);
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
    $query = "select userid,firstname,lastname from Users where roleid=2";
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        echo mysqli_error($link);
    } else {
        echo convertResultToJSON($result);
    }
}
