<?php
require("../php/helper.php");
session_start();
if (isset($_SESSION['user'])) {
    $query = "select userid,username,roleid from Users";
    $result = mysqli_query($link, $query);
    echo convertResultToJSON($result);
} else {
    header("Location: ../php/login.php");
}
