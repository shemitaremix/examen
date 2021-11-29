<?php

$servername = "jtb9ia3h1pgevwb1.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$database = "x1y1lmwpjpjc579l";
$username = "z8yrbz1t34hom5cj";
$password = "uwn15ldu6rtliip1";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn) {
    die ("connection failed: " . mysqli_connect_error());
}

echo "conected succesfuly";



?>