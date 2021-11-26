<?php

$servername = "localhost";
$database = "partida";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn) {
    die ("connection failed: " . mysqli_connect_error());
}

echo "conected succesfuly";



?>