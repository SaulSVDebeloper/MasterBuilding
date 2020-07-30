<?php
include "funciones.php";
global $conexion;
$calle = "";
$calle = $_REQUEST['valorBorrar'];

$cargar = "DELETE FROM `propiedades` WHERE `nombreCalle` = '$calle';";
//echo $cargar;
$conexion->query($cargar);

echo "Propiedad borrada correctamente";