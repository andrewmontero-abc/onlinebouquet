<?php
function getDBConnection(){
    $servername = "nervdb.ddns.net";
    $username = "root";
    $password = "";
    $database = "nervusers";
    $port = 3306;


$connection = new mysqli($servername, $username, $password, $database);
if($connection->connect_error){
    die("Error: Failed to connect to MySQL. ".$connection->connect_error);
}

return $connection;
}

?>
