<?php
function getDBConnection(){
    $servername = "sql.freedb.tech";
    $username = "root";
    $password = "";
    $database = "freedb_nervusers";
    $port = 3306;


$connection = new mysqli($servername, $username, $password, $database);
if($connection->connect_error){
    die("Error: Failed to connect to MySQL. ".$connection->connect_error);
}

return $connection;
}

?>
