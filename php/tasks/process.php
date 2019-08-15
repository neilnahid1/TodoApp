<?php
require "../tasks/tasks.php";
require "../tasks/taskItems.php";
session_start();
switch ($_POST['Type']) {
    case "getCurrentUserTasks":
        getUserTasks($_POST['UserID']);
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
            $existingItems = array();
            foreach ($_POST['TaskItems'] as $item) {
                // var_dump($item);
                //updates existing items and add new ones
                if (isset($item['TaskItemID'])) {
                    updateTaskItem($item);
                    $existingItems[] = $item['TaskItemID'];
                } else {
                    //add to the existing items the newly added task item
                    $existingItems[] = addTaskItem($item, $_POST['TaskCodeID']);
                }
            }
            //delete wasn't included in the post method, it is assumed deleted=
            deleteTaskItems($_POST['TaskCodeID'], $existingItems);
            echo "Successfully updated Task.";
        } else {
            //if task items are empty, it means, user deleted all the task items;
            deleteAllTaskItemsOf($_POST['TaskCodeID']);
            echo "Successfully updated Task.";
        }
        break;
    default:
        echo "default case task.process.php";
}
