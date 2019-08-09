<?php
require('../php/helper.php');
require('../php/config.php');

function addTask($data)
{
    global $link;
    $name = $data['Name'];
    $description = $data['Description'];
    $userID = $data['UserID'];
    $query = "insert into Tasks(name,descriptiom,userid) value('$name','$description',$userID)";
    if (mysqli_query($link, $query)) {
        echo "Successfully Created Task.";
    } else {
        echo mysqli_error($link);
    }
}
function updateTask($data)
{
    global $link;
    $name = $data['Name'];
    $description = $data['Description'];
    $userID = $data['UserID'];
    $isComplete = $data['IsComplete'];
    $query = "insert into Tasks(name,description,dateupdated,iscomplete) values('$name','$description',now(),$isComplete)";
    if (mysqli_query($link, $query)) {
        echo "Successfully updated!";
    } else {
        echo mysqli_error($link);
    }
}
function deleteTask($taskCodeID)
{
    global $link;
    $query = "delete from Tasks where TaskCodeID=$taskCodeID";
    if (mysqli_query($link, $query)) {
        echo "Successfully deleted Task.";
    } else {
        echo mysqli_error($link);
    }
}
function getTask($taskCodeID)
{
    global $link;
    $query = "select * from Tasks where TaskCodeID=$taskCodeID";
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        echo mysqli_error($link);
    } else {
        echo convertResultToJSON($result);
    }
}

function addTaskItem($data)
{
    global $link;
    $taskCodeID = $data['TaskCodeID'];
    $name = $data['Name'];
    $isDone = $data['IsDone'];
    $query = "insert into TaskItems(name,taskCodeID) values('$name','$isDone')";
    if (mysqli_query($link, $query)) {
        echo "Successfully added task item.";
    } else {
        echo mysqli_error($link);
    }
}
function updateTaskItem($data)
{
    global $link;
    $taskCodeID = $data['TaskCodeID'];
    $name = $data['Name'];
    $isDone = $data['IsDone'];
    $query = "update taskItems set name='$name',isdone=$isDone where taskcodeID=$taskCodeID";
    if (mysqli_query($link, $query)) {
        echo "Successfully updated task item.";
    } else {
        echo mysqli_error($link);
    }
}
function getTaskItems($taskCodeID)
{
    global $link;
    $query = "select * from TaskItems where TaskCodeID=$taskCodeID";
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        echo mysqli_error($link);
    } else {
        echo convertResultToJSON($result);
    }
}
function deleteTaskItem($taskCodeID, $taskItemID)
{
    global $link;
    $query = "delete * from TaskItems where TaskCodeID=$taskCodeID and taskitemID=$taskItemID";
    if (mysqli_query($link, $query)) {
        echo "Successfully deleted task Item.";
    } else {
        echo mysqli_error($link);
    }
}
