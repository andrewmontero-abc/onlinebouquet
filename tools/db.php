<?php
function getDBConnection(){

$host = 'switchyard.proxy.rlwy.net';
$port = 17607;
$user = 'root';
$password = 'TzYfrdBKhmUefTAVqmjeatqGWnNqGuwa';
$dbname = 'railway';

// Create connection
$connection = new mysqli($host, $user, $password, $dbname, $port);

if($connection->connect_error){
    die("Error: Failed to connect to MySQL. ".$connection->connect_error);
}

return $connection;
}

?>
