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


$sql = "INSERT INTO weyes (id,nombre,apellidos,posicionbarco1,posicionbarco2,posicionbarco3,posicionbarco4) VALUES (' ','$nombre','$apellidos','$posicionbarco1','$posicionbarco2',$posicionbarco3','$posicionbarco4')";

if(mysqli_query($conn,$sql)){
    echo "new recod created succefuly";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


?>