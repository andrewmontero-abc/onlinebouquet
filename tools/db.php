<?php
function getDBConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "nervusers";


$connection = new mysqli($servername, $username, $password, $database);
if($connection->connect_error){
    die("Error: Failed to connect to MySQL. ".$connection->connect_error);
}

return $connection;
}

?>