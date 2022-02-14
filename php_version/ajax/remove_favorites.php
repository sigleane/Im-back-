<?php
require_once("../includes/db_connect.php");
require_once("../includes/instruction.php");

$dataFromAjax = file_get_contents('php://input');
$decoder = json_decode($dataFromAjax,true);

$db_instruction->DELETE_DATA($conn, "DELETE FROM favorites WHERE id = ?", "i", [$decoder]);

$db_instruction->UPDATE_DATA($conn, "UPDATE keylog SET status = NULL WHERE id = ?", "i", [$decoder]);

echo "deleted";