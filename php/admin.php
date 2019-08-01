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
    <h1 class="text-center">Users Table</h1>
    <table class="table table-striped">
        <thead class="thead-dark">
            <th style="width:15%">UserID</th>
            <th style="width:50%">Username</th>
            <th style="width:15%">Role</th>
            <th style="width:20%">Functionalities</th>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                $dom = "<tr>";
                $dom .= "<td>{$row['UserID']}</td>";
                $dom .= "<td>{$row['Username']}</td>";
                $dom .= "<td>" . ($row['RoleID'] == 1 ? "Admin" : "User") . "</td>";
                $dom .= "<td>";
                $dom .= "<button onclick='getAllUserTasks(this.value)' value='{$row['UserID']}' data-toggle='modal' id='viewUser' data-target='#viewTaskModal' class='btn btn-dark'>View Tasks</button>";
                $dom .= "<button value='{$row['UserID']}' data-toggle='modal' id='updateUser' data-target='#updateTaskModal' class='btn btn-dark'>Edit</button>";
                $dom .= "<button value='{$row['UserID']}' data-toggle='modal' id='deleteUser' data-target='#deleteTaskModal' class='btn btn-dark'>Delete</button>";
                $dom .= "</td>";
                $dom .= "</tr>";
                echo $dom;
            }
            ?>
        </tbody>
    </table>
    <!-- Modal for Viewing User Tasks -->
    <div class="modal" id="viewTaskModal" tabindex="-1" role="dialog" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">Viewing User Tasks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="userTasksModalBody">
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
    <script src="../js/adminFunctionalities.js"></script>
</body>

</html>