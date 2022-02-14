<?php

require_once("../includes/db_connect.php");
require_once("../includes/instruction.php");


$brute_data = $db_instruction->READ_DATA($conn, "SELECT * FROM favorites", NULL, NULL);

$set_day = ""; 

foreach ($brute_data as $key => $value) {
    $data_news = $value[1];
    $data_id = $value[0];
    $first_item_id = $brute_data[0][2];

    $header_and_logs = explode(") ||", $data_news);
    $date_and_pc = explode("||", $header_and_logs[0]);


    $adapt_logs_to_DOM = str_replace("
    ", "<br>", $header_and_logs[1]);

  

    $day_and_hour = explode("-", $date_and_pc[0]);
    $day = explode("/",$day_and_hour[0])[0];
   
    if($set_day !== $day && $data_id !== $first_item_id){
        echo "<br><hr><br>";
    }

    write_in_DOM($data_id, $date_and_pc, $adapt_logs_to_DOM);
    $set_day = $day;

}

function write_in_DOM($data_id, $date_and_pc, $adapt_logs_to_DOM){
    echo "<p id='$data_id'>
    <span class='data'>
        <span class='header_data'>|| <span class='date_header'>$date_and_pc[0]</span> || <span class='pc_identifier'>$date_and_pc[1])</span> ||</span><br><br>
        <span class='content_data'>$adapt_logs_to_DOM</span>
    </span>
    </p>";
}