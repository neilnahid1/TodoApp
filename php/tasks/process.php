<?php
require "../tasks/tasks.php";
require "../tasks/taskItems.php";
session_start();
switch ($_POST['Type']) {
    case "getCurrentUserTasks":
        getUserTasks($_SESSION['user']['UserID']);
        break;
    case "addTask":
        $latest_taskCodeID = addTask($_POST); // add task first

        //add the task items to the newly created task
        foreach ($_POST['TaskItems'] as $taskItem) {
            addTaskItem($taskItem, $latest_taskCodeID);
        }
        //error checking
        if (mysqli_errno($link)) {
            printError($link);
            echo "source: tasks.process.php";
        } else {
            echo "Successfully added task";
        }
        break;
    case "updateTask":
        updateTask($_POST);
        break;
    case "deleteTask":
        deleteTask($_POST['TaskCodeID']);
        break;
    default:
       echo "default case task.process.php";
}
