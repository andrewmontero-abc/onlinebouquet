<?php
function getDBConnection(){
    $servername = "sql301.infinityfree.com";
    $username = "root";
    $password = "";
    $database = "users";


$connection = new mysqli($servername, $username, $password, $database);
if($connection->connect_error){
    die("Error: Failed to connect to MySQL. ".$connection->connect_error);
}

return $connection;
}

?>
