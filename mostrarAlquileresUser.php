<?php
session_start();
include "funciones.php";
$mostrar = "";
$num=4;
$precio="";
$img ="";
$user="";
$user= $_REQUEST['valor'];
//echo $mostrar."*";
if (isset($_REQUEST['pag']) && ($_REQUEST['pag'] != 0)) {
    $pagina= $_REQUEST['pag'];
}else{
    $pagina = 0;
}

/* echo $mostrar."|";
echo $pagina; */

global $conexion;
$cargar = "SELECT * FROM `propiedades` WHERE `usuario` = '$user';";

$resul = "";
$cont = 0;
$tipoProducto ="";
if($valido= $conexion->query($cargar)){ //recogemos el nombre del user 
    if($valido->num_rows > 0 ){
            //$tipoProducto = desplegableTipoPropiedadesAjaxDBAdmin(); //creamos el desplegable para el admin
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='3' style='font-family:fantasy; color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch;'><h3>MI VIVIENDA</h3></th></tr>";
            $resul .= "<tr><td style='text-align:center; vertical-align:middle;'><b>NOMBRE VIVIENDA</b></td><td style='text-align:center; vertical-align:middle;'><b>TIPO VIVIENDA</b></td><td style='text-align:center; vertical-align:middle;'><b>PRECIO MENSUAL</b></td></tr>";
            while($registro = $valido->fetch_assoc()){
                $nombre = $registro['nombreCalle'];
                $precio = $registro['precioAlquiler'];
                $catego = $registro['categoria'];
                $resul.="<tr><td style='text-align:center; vertical-align:middle;'>".$nombre."</td><td style='text-align:center; vertical-align:middle;'>".$catego."</td><td style='text-align:center; vertical-align:middle;'>".$precio." €</td></tr>";
                
            }
            $resul .= "</table>";
            $resul.= "<br>";
            echo $resul;
    }
}