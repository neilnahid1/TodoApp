<?php
$link = mysqli_connect('127.0.0.1', 'root', '!mrniceknight1', 'todo');
function isFieldsSet($fields)
{
    foreach ($fields as $field) {
        if (!empty($_POST[$field])) {
            continue;
        } else
            return false;
    }
    return true;
}
function getRoleID($roleName, $link)
{
    $res = mysqli_query($link, "select RoleID from Roles where name='$roleName'");
    $data = mysqli_fetch_assoc($res);
    return $data["RoleID"];
}
function alert($message)
{
    echo "<script>alert('$message');</script>";
}
function convertResultToJSON($result)
{
    $array = array();
    while ($row = $result->fetch_assoc()) {
        $array[] = $row;
    }
    return json_encode($array);
}
function redirectIfNoSession()
{
    if (!isset($_SESSION['user'])) {
        header("Location: ../php/login.php");
    }
}
