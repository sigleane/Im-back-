<?php
require_once("./includes/db_connect.php");
require_once("./includes/instruction.php");

$status = $db_instruction->CREATE_DATA($conn,"INSERT INTO keylog (news) VALUES (?)", "s", [$content_in_file]);

