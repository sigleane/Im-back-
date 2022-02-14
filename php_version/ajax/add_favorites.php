<?php
require_once("../includes/db_connect.php");
require_once("../includes/instruction.php");

$dataFromAjax = file_get_contents('php://input');
$decoder = json_decode($dataFromAjax,true);


$original_data = $db_instruction->READ_DATA($conn, "SELECT * FROM keylog where id = ?", "i", [$decoder]);


$db_instruction->CREATE_DATA($conn, "INSERT INTO favorites (news, hora, id) VALUES (?,?,?)", "ssi", [$original_data[0][1], $original_data[0][3], $original_data[0][0]]);

$db_instruction->UPDATE_DATA($conn, "UPDATE keylog SET status = 'favorite' WHERE id = ?", "i", [$original_data[0][0]]);


 var_dump($original_data);