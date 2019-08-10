<?php 
require('./users.php');
switch($_POST['Type']){
    case "addUser":
    if(isFieldsSet($_POST)){
        if($_POST['Password']==$_POST['RepeatPassword'])
        addUser($_POST);
        else{
            echo "passwords doesn't match";
        }
    }
    else{
        echo "You must provide all fields.";
    }
}