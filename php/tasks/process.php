<?php
require "../tasks/process.php";

switch($_POST['Type']){
    case "getUserTasks": getAllTasksOf($_POST['UserID']);
    case "addTask": addTask($_POST);
    case "updateTask": updateTask($_POST);
    case "deleteTask": deleteTask($_POST['TaskCodeID']);
}