<?php
require('./users.php');
switch ($_POST['Type']) {
    case "addUser":
        if (isFieldsSet($_POST)) {
            if ($_POST['Password'] == $_POST['RepeatPassword'])
                addUser($_POST);
            else
                echo "passwords doesn't match";
        } else
            echo "You must provide all fields.";
        break;
    case "updateUser":
        if (isFieldsSet($_POST) || empty($_POST['Password']) || empty($_POST['ConfirmPassword'])) {
            if ($_POST['Password'] == $_POST['ConfirmPassword'])
                updateUser($_POST);
            else
                echo "Passwords doesn't match";
        } else
            echo "Make sure to fill all required fields";
        break;
        default: echo "went to default case user.process.php";
}
