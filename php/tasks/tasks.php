<?php
require "../config.php";
require "../utilities/helper.php";
function addTask($data)
{
    global $link;
    $name = $data['Name'];
    $description = $data['Description'];
    $userID = $data['UserID'];
    $query = "insert into Tasks(name,description,userid) value('$name','$description',$userID)";
    if (mysqli_query($link, $query)) {
        return mysqli_insert_id($link);
    } else {
        var_dump($query);
        echo printError($link);
        echo "source: tasks.php - addTask";
    }
}
function updateTask($data)
{
    global $link;
    $name = $data['Name'];
    $description = $data['Description'];
    $taskCodeID = $data['TaskCodeID'];
    $isComplete = isset($data['IsComplete']) ? 1 : 0;
    $query = "update Tasks set name='$name',description='$description',iscomplete=$isComplete, dateupdated=now() where taskcodeID=$taskCodeID";
    if (mysqli_query($link, $query)) {
        return;
    } else {
        echo mysqli_error($link);
        echo "source: tasks.php.updateTask()";
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
function getUserTasks($userID)
{
    global $link;
    $query = "select * from Tasks where userid=$userID";
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link)) {
        echo mysqli_error($link);
    } else {
        echo convertResultToJSON($result);
    }
}
