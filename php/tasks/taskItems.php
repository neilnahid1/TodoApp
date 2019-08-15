<?php
function addTaskItem($data, $taskCodeID)
{
    global $link;
    $name = $data['Name'];
    $isDone = isset($data['IsDone']) ? 1 : 0;
    $query = "insert into TaskItems(name,taskCodeID,isDone) values('$name','$taskCodeID',$isDone)";
    if (!mysqli_query($link, $query)) {
        printError($link);
        echo "source: taskitems.php.addTaskItem()";
        die;
    } else
        //return the id of the newly added item
        return mysqli_insert_id($link);
}
function updateTaskItem($data)
{
    global $link;
    $taskItemID = $data['TaskItemID'];
    $name = $data['Name'];
    $isDone = isset($data['IsDone']) ? 1 : 0;

    $query = "update taskItems set name='$name',isdone=$isDone where taskItemID=$taskItemID";
    if (mysqli_query($link, $query)) {
        return;
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
function deleteTaskItems($taskCodeID, $taskItemIDs)
{
    global $link;
    $query = "delete from TaskItems where taskcodeid=$taskCodeID and ";
    foreach ($taskItemIDs as $taskItemID) {
        $query .= "taskitemID!=$taskItemID and ";
    }
    $query = substr($query, 0, strlen($query) - 4);
    if (mysqli_query($link, $query)->num_rows) {
        echo "Successfully deleted task Items.";
    }
    if (mysqli_errno($link)) {
        printError($link);
    }
}
