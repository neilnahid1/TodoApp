<?php
session_start();
require('helper.php'); // includes mysqli_connect and helper functions
if (isset($_SESSION['user'])) {
  //redirect according to user type 1 - admin, 2 - user
  if ($_SESSION['user']['RoleID'] == "1")
    header("Location: ../php/admin/admin.php");
  else if ($_SESSION['user']['RoleID'] == "2")
    header("Location: ../index.php");
}
$fields = array('username', 'password');
if (isFieldsSet($fields)) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $query = "select * from Users where Username='$username'";
  $res = mysqli_query($link, $query);
  if (mysqli_num_rows($res)) {
    $user = $res->fetch_assoc();
    if (password_verify($password, $user['Password'])) {
      $_SESSION['user'] = $user;
      if ($user['RoleID'] == 1)
        header("Location: ../php/admin.php");
      else
        header("Location: ../index.php");
    } else {
      alert("Invalid password");
    }
  } else {
    alert("Invalid Username/password");
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <title>Neil's Todo</title>
</head>

<body>

  <div class="row">
    <div class="col"></div>
    <div class="col-3">
      <div class="card text-left">
        <div class="card-header text-center">
          Welcome to my Todo App!
        </div>
        <div class="card-body">
          <h5 class="card-title text-center">Login</h5>
          <form action="login.php" method="POST">
            <div class="form-group">
              <label for="exampleInputEmail1">Username</label>
              <input name="username" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <button type="button" onclick="window.location = '../php/register.php'" class="btn btn-primary">Register</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col"></div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>