<?php
session_start();
require('../TodoApp/php/helper.php');
//redirects to login if session doesn't exist
if (!isset($_SESSION['user'])) {
    header("Location: ../php/login.php");
} else if ($_SESSION['user']['RoleID'] == 1) header("Location: ../php/admin.php");
$user = $_SESSION['user'];
// var_dump($user);
$query = "select * from Tasks where userID={$user['UserID']}";
// var_dump($query);
$userTasks = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>User</title>
</head>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Welcome, <?= $user['Username'] ?></h1>
            <p class="lead">Listed below are your to-do lists.</p>
            <form action="../php/logout.php">
                <input type="hidden" name="isLoggedOut" value=>
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
    <h1 class="text-center">Tasks Table</h1>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <th style="width:10%">TaskID</th>
            <th style="width:50%">Name</th>
            <th style="width:10%">Completed</th>
            <th></th>
        </thead>
        <tbody>
            <?php
            while ($row = $userTasks->fetch_assoc()) {
                echo "<tr id=row" . $row['TaskCodeID'] . ">";
                echo "<td id=td_TaskCodeID>{$row['TaskCodeID']}</td>";
                echo "<td id=td_name>{$row['Name']}</td>";
                echo "<td class='text-center'>";
                echo "<input id=td_IsComplete class='form-check-input' type='checkbox'" . ($row['IsComplete'] == 1 ? "checked" : "1") . " onclick='return false;'>";
                echo "</td>";
                //buttons
                echo "<td>";
                echo "<button onclick='' value='{$row['TaskCodeID']}' data-toggle='modal' id='viewTask' data-target='#viewTaskModal' class='btn btn-dark'>View</button>";
                echo "<button value='{$row['TaskCodeID']}' data-toggle='modal' id='updateTask' data-target='#updateTaskModal' class='btn btn-dark'>Edit</button>";
                echo "<button value='{$row['TaskCodeID']}' data-toggle='modal' id='deleteTask' data-target='#deleteTaskModal' class='btn btn-dark'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            <tr id="btn_NewRow">
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <button data-toggle="modal" data-target="#createNewModal" class="btn btn-dark">New Task</button>
                </td>
            </tr>
            <?php

            ?>
        </tbody>
    </table>


    <!-- Modal for Creating new task-->
    <div class="modal fade" id="createNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- CREATE NEW TASK FORM -->
                    <form id="addTask">
                        <div class="form-group">
                            <label for="iTaskName">Name</label>
                            <input name="iTaskName" type="text" class="form-control" id="iTaskName" placeholder="Enter task name">
                        </div>
                        <div class="form-group">
                            <label for="iDescription">Description</label>
                            <input name="iDescription" type="text" class="form-control" id="iDescription" placeholder="Enter Description">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="btnCreate" type="button" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Viewing Selected Task-->
    <div class="modal fade" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">Viewing Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- View Task FORM -->
                    <form id="addTask">
                        <div class="form-group">
                            <label for="iTaskName">Name</label>
                            <input name="iTaskName" readonly type="text" class="form-control" id="vTaskName" placeholder="Enter task name">
                        </div>
                        <div class="form-group">
                            <label for="iDescription">Description</label>
                            <input name="iDescription" readonly type="text" class="form-control" id="vTaskDescription" placeholder="Enter Description">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="vTaskIsComplete" onclick="return false;">
                            <label class="form-check-label" for="defaultCheck1">
                                Completed
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Updating Selected Task-->
    <div class="modal fade" id="updateTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">Updating Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- update Task FORM -->
                    <form id="update_task">
                        <input type="hidden" name="TaskCodeID" id="uTaskCodeID">
                        <div class="form-group">
                            <label for="iTaskName">Name</label>
                            <input name="Name" type="text" class="form-control" id="uTaskName" placeholder="Enter task name">
                        </div>
                        <div class="form-group">
                            <label for="iDescription">Description</label>
                            <input name="Description" type="text" class="form-control" id="uTaskDescription" placeholder="Enter Description">
                        </div>
                        <div class="form-check">
                            <input name="IsComplete" class="form-check-input" type="checkbox" id="uTaskIsComplete">
                            <label class="form-check-label" for="defaultCheck1">
                                Completed
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn_update" type="button" data-dismiss="modal" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div><!-- Modal for Deleting Selected Task-->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2>Are you sure you want to delete User?</h2>
                </div>
                <div class="modal-footer">
                    <button id="btn_cancel" type="button" data-dismiss="modal" class="btn btn-dark">Cancel</button>
                    <button id="btn_delete" type="button" data-dismiss="modal" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/createTaskHandler.js"></script>
    <script src="../js/viewTaskHandler.js"></script>
    <script src="../js/updateTaskHandler.js"></script>
    <script src="../js/deleteTaskHandler.js"></script>
    <script>
    </script>
</body>

</html>