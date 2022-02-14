<?php
$servername = "sql10.freesqldatabase.com";
$dbUsername = "sql10472377";
$dbPassword = "AcWGigWUh4";
$dbName = "sql10472377";

$conn = mysqli_connect($servername,$dbUsername,$dbPassword,$dbName);

if(!$conn){
    die("Connection failded: ".mysqli_connect_error());
}

