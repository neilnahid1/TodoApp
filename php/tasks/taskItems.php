<?php
function addTaskItem($data, $taskCodeID)
{
    global $link;
    $name = $data['Name'];
    $isDone = isset($data['IsDone']) ? 1 : 0;
    $query = "insert into TaskItems(name,taskCodeID,isDone) values('$name','$taskCodeID',$isDone)";
    var_dump($query);
    if (!mysqli_query($link, $query)) {
        printError($link);
        echo "source: taskitems.php.addTaskItem()";
        die;
    }
    else
        echo "Successfully added task item";
}
function updateTaskItem($data)
{
    global $link;
    $taskCodeID = $data['TaskCodeID'];
    $name = $data['Name'];
    $isDone = isset($data['IsDone']) ? 1 : 0;
    $query = "update taskItems set name='$name',isdone=$isDone where taskcodeID=$taskCodeID";
    die;
    if (mysqli_query($link, $query)) {
        echo "Successfully updated task item.";
    } else {
        echo mysqli_error($link);
        echo "source: taskitems.php.updateTaskItem()";
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
