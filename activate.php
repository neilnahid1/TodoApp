<?php
require('../TodoApp/php/utilities/helper.php');
require('../TodoApp/php/config.php');
if (isFieldsSet($_GET)) {
    $activationCode = $_GET['activationCode'];
    $query = "select * from users where activationCode='$activationCode'";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result)) {

        $message = "Successfully Activated Account";
        $query = "update users set isemailverified=1 where activationCode='$activationCode'";
        mysqli_query($link, $query);
        mysqli_errno($link) ? printError($link) : "Okay";
    } else {
        // printError($link);
        $message = "Invalid Code";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Todo App</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <div class="col text-center">
        <h1 id="message"><?= $message ?></h1>
        <div class="text-center">
            <a class="small" href="login.php">Proceed to login</a>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        function activate() {}
    </script>
</body>

</html>