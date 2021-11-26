<?php
require("conexion.php");
$nombre= "";
$apellidos = "";
$posicionbarco1 = "";
$posicionbarco2 = "";
$posicionbarco3 = "";
$posicionbarco4 = "";

if(isset($_POST["nombre"])){
    $nombre = $_POST["nombre"];
}

if(isset($_POST["apellidos"])){
    $apellidos = $_POST["apellidos"];
}

if(isset($_POST["posicionbarco1"])){
    $posicionbarco1 = $_POST["posicionbarco1"];
}

if(isset($_POST["posicionbarco2"])){
    $posicionbarco2 = $_POST["posicionbarco2"];
}

if(isset($_POST["posicionbarco3"])){
    $posicionbarco3 = $_POST["posicionbarco3"];
}

if(isset($_POST["posicionbarco4"])){
    $posicionbarco4 = $_POST["posicionbarco4"];
}


$sql = "INSERT INTO partida (id,nombre,apellidos) VALUES (' ','$nombre','$apellidos')";

if(mysqli_query($conn,$sql)){
    return 1;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);   
}


?>