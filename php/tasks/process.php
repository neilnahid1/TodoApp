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
        } else
            echo "Successfully added task";

        break;
    case "deleteTask":
        deleteTask($_POST['TaskCodeID']);
        break;
    case "getTaskItems":
        if (!empty($_POST['TaskCodeID']))
            getTaskItems($_POST['TaskCodeID']);
        else
            echo "TaskCode invalid";
        break;
    case "updateTask":
        if (isset($_POST['Name']) && isset($_POST['Description']))
            updateTask($_POST);
        if (isset($_POST['TaskItems'])) {
            foreach ($_POST['TaskItems'] as $item) {
                if (isset($item['TaskCodeID']))
                    updateTaskItem($item);
                else
                    addTaskItem($item, $_POST['TaskCodeID']);
            }
            echo "Successfully Updated";
        } else
            echo "There is no Task Items to update.";
        break;
    default:
        echo "default case task.process.php";
}
