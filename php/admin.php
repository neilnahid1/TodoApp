<?php
session_start();
require('../php/helper.php');
//redirects to login if session doesn't exist
if (!isset($_SESSION['user'])) {
    header("Location: ../php/login.php");
}
$user = $_SESSION['user'];
$query = "select UserID,Username,RoleID from Users";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Admin</title>
</head>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Welcome, <?= $user['Username'] ?></h1>
            <p class="lead">Listed below are the users.</p>
            <form action="../php/logout.php">
                <input type="hidden" name="isLoggedOut" value=>
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class='col'></div>
        <div class='col'>
            <h1 id="table_name" class="text-center">Users Table</h1>
        </div>
        <div class='col text-right'>
            <button class='btn-primary' onclick="fetchUsersTable()">Users Table</button>
            <button class='btn-primary' onclick="fetchTasksTable()">Tasks Table</button></div>
    </div>
    <table id="mainTable" class="table table-striped" style="table-layout:fixed">
        <!-- TABLE DATA WILL BE DYNAMICALLY GENERATED  -->
    </table>
    <!-- Modal for Viewing User Tasks -->
    <div class="modal fade" id="viewUserTasksModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">Viewing User Tasks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="userTasksModalBody">
                    <div class="text-right">
                        <button id="btn" data-toggle="modal" data-target="#createNewUserModal" class="btn btn-dark">New Task</button>
                        <button data-toggle="modal" data-target="#deleteAllUserTaskModal" class="btn btn-danger">Delete All Task</button>
                    </div>
                    <table id="tbl_userTasks" class="table table-striped" style="table-layout:fixed">
                        <!-- TABLE DATA WILL BE DYNAMICALLY GENERATED  -->
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- modal for editing user -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">Editing User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="userTasksModalBody">
                    <form id="updateUserForm">
                        <div class="form-group">
                            <label for="UserID">UserID</label>
                            <input type="text" class="form-control" name="UserID" id="UserID" placeholder="UserID" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" name="Username" id="Username" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="password" class="form-control" name="Password" id="Password" placeholder="New Password">
                        </div>
                        <div class="form-group">
                            <label for="RoleID">Role</label>
                            <select name="RoleID" id="RoleID" class="custom-select">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button data-dismiss="modal" onclick="updateUser()" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL FOR DELETING USER -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h1>Are you sure you want to delete?</h1>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button data-dismiss="modal" id="btn_deleteUser" onclick="deleteUser(this.value)" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
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
                    <button onclick="addTask()" id="btnCreate" type="button" class="btn btn-primary">Create</button>
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
                    <form id="view">
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
                    <form id="updateTaskForm">
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
                    <button onclick="updateTask()" id="btn_updateTask" type="button" data-dismiss="modal" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Deleting Selected Task-->
    <div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2>Are you sure you want to delete Task?</h2>
                </div>
                <div class="modal-footer">
                    <button id="btn_cancel" type="button" data-dismiss="modal" class="btn btn-dark">Cancel</button>
                    <button onclick='deleteTask(this.value)' id="btn_deleteTask" type="button" data-dismiss="modal" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Creating new User task-->
    <div class="modal fade" id="createNewUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form id="addUserTask">
                        <div class="form-group">
                            <label for="iTaskName">Name</label>
                            <input name="iTaskName" type="text" class="form-control" id="iTaskName" placeholder="Enter task name">
                        </div>
                        <div class="form-group">
                            <label for="iDescription">Description</label>
                            <input name="iDescription" type="text" class="form-control" id="iDescription" placeholder="Enter Description">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button name="UserID" data-dismiss="modal" onclick="addUserTask(this.value)" id="btn_Create" type="button" class="btn btn-primary">Create</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal for Viewing Selected User Task-->
    <div class="modal fade" id="viewUserTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
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
                    <form id="Userview">
                        <div class="form-group">
                            <label for="iTaskName">Name</label>
                            <input name="iTaskName" readonly type="text" class="form-control" id="vUserTaskName" placeholder="Enter task name">
                        </div>
                        <div class="form-group">
                            <label for="iDescription">Description</label>
                            <input name="iDescription" readonly type="text" class="form-control" id="vUserTaskDescription" placeholder="Enter Description">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="vUserTaskIsComplete" onclick="return false;">
                            <label class="form-check-label" for="defaultCheck1">
                                Completed
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Updating Selected User Task-->
    <div class="modal fade" id="updateUserTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
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
                    <form id="updateUserTaskForm">
                        <input type="hidden" name="TaskCodeID" id="uUserTaskCodeID">
                        <div class="form-group">
                            <label for="iTaskName">Name</label>
                            <input name="Name" type="text" class="form-control" id="uUserTaskName" placeholder="Enter task name">
                        </div>
                        <div class="form-group">
                            <label for="iDescription">Description</label>
                            <input name="Description" type="text" class="form-control" id="uUserTaskDescription" placeholder="Enter Description">
                        </div>
                        <div class="form-check">
                            <input name="IsComplete" class="form-check-input" type="checkbox" id="uUserTaskIsComplete">
                            <label class="form-check-label" for="defaultCheck1">
                                Completed
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="updateUserTask()" id="btn_updateTask" type="button" data-dismiss="modal" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Deleting Selected User Task-->
    <div class="modal fade" id="deleteUserTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2>Are you sure you want to delete Task?</h2>
                </div>
                <div class="modal-footer">
                    <button id="btn_cancel" type="button" data-dismiss="modal" class="btn btn-dark">Cancel</button>
                    <button onclick='deleteUserTask(this.value)' id="btn_UserdeleteTask" type="button" data-dismiss="modal" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Deleting All User Tasks-->
    <div class="modal fade" id="deleteAllUserTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2>Are you sure you want to delete all task?</h2>
                </div>
                <div class="modal-footer">
                    <button id="btn_cancel" type="button" data-dismiss="modal" class="btn btn-dark">Cancel</button>
                    <button data-dismiss="modal" onclick='deleteAllUserTasksFromUser(this.value)' id="btn_deleteAllTasks" type="button" data-dismiss="modal" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/users.js"></script>
    <script src="../js/userTasks.js"></script>
    <script src="../js/tasks.js"></script>
    <script>
        fetchUsersTable();
    </script>
</body>

</html>