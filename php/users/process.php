<?php 
require('./users.php');
var_dump($_POST);
switch($_POST['Type']){
    case "addUser":
    if(isFieldsSet($_POST)){
        if($_POST['Password']==$_POST['RepeatPassword'])
        addUser($_POST);
        else{
            echo "passwords doesn't match";
        }
    }
}