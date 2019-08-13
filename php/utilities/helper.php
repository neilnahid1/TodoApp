<?php
function isFieldsSet($data)
{
    foreach ($data as $key => $value) {
        if (empty($data[$key])) {
           return false; die;
        }
    }
    return true;
    // foreach ($fields as $field) {
    //     if (!empty($_POST[$field]) && isset($_POST[$field])) {
    //         continue;
    //     } else
    //         return false;
    // }
    // return true;
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
    if (empty($_SESSION)) {
        header("Location: ../login.php");
    }
}
function printError(mysqli $link){
    echo $link->errno . " ". $link->error;
}
function convertResultToAssoc($result){
    $array = array();
    while ($row = $result->fetch_assoc()) {
        $array[] = $row;
    }
    return $array;
}