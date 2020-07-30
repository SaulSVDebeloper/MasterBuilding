<?php

include "funciones.php";
$mostrar = "";
$num=4;
$precio="";
$img ="";
$mostrar= $_REQUEST['valor'];
//echo $mostrar."*";
if (isset($_REQUEST['pag']) && ($_REQUEST['pag'] != 0)) {
    $pagina= $_REQUEST['pag'];
}else{
    $pagina = 0;
}
/* echo $mostrar."|";
echo $pagina; */

global $conexion;
$cargar = "SELECT * FROM `propiedades` LIMIT $pagina, 3;";

$resul = "";
$cont = 0;
$tipoProducto ="";
if($valido= $conexion->query($cargar)){ //recogemos el nombre del user 
    if($valido->num_rows > 0 ){
        if ($mostrar == "Todo" || $mostrar == "Elija" || $mostrar == "") {
            //$tipoProducto = desplegableTipoPropiedadesAjaxDBAdmin(); //creamos el desplegable para el admin
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='4' style='font-family:fantasy; color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch;'><h3>Viviendas en Alquiler</h3></th></tr>";
            $resul .= "<tr><td style='text-align:center; vertical-align:middle;'><b>NOMBRE</b></td><td style='text-align:center; vertical-align:middle;'><b>PRECIO</b></td><td style='text-align:center; vertical-align:middle;'><b>INQUILINO</b></td><td style='text-align:center;'><b>ELIMINAR PROPRIEDAD</b></td></tr>";
            while($registro = $valido->fetch_assoc()){
                $nombre = $registro['nombreCalle'];
                $precio = $registro['precioAlquiler'];
                $usuario = $registro['usuario'];
                $categoría=$registro['categoria'];
                $resul.="<tr><td style='text-align:center; vertical-align:middle;'>".$nombre."</td><td style='text-align:center; vertical-align:middle;'>".$precio." €</td><td style='text-align:center; vertical-align:middle;'>".$usuario." </td><td style='text-align:center; vertical-align:middle;'><input type='submit' value='Borrar Propiedad' class='btn btn-primary' onclick=\"borrarPropiedad('$nombre');\" style='font-family:fantasy;'></td></tr>";
                $cont++;
            }
            $resul.="<tr><td></td></tr>";
            $resul.= "<tr><td colspan='3' style='text-align:left; vertical-align:middle;'><p style='margin-left:75px;'><input type='submit' value=' Anterior ' class='btn btn-primary' onclick=\"anterior('$pagina');\">";
            $resul.= " --- ";
            $resul.= "<input type='submit' value=' Siguiente ' class='btn btn-primary' onclick=\"siguiente('$pagina');\"></p></td></tr>";
            $resul .= "</table>";
            $resul.= "<br><br>";
            echo $resul;

        }else{
             $cargar = "SELECT * FROM `propiedades`";
            $valido= $conexion->query($cargar);
            //$tipoProducto = desplegableTipoPropiedadesAjaxDBAdmin();//creamos el desplegable para el admin
   
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='3' style='font-family:fantasy; color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch;'><h3>Viviendas en Alquiler</h3></th></tr>";
            $resul .= "<tr><td style='text-align:center; vertical-align:middle;'>NOMBRE</td><td style='text-align:center; vertical-align:middle;'><b>INQUILINO</b></td><td style='text-align:center; vertical-align:middle;'>PRECIO</td><td style='text-align:center'>ELIMINAR PROPRIEDAD</td></tr>";
            while($registro = $valido->fetch_assoc()){
                $nombre = $registro['nombreCalle'];
                $precio = $registro['precioAlquiler'];
                $usuario = $registro['usuario'];
                $categoría=$registro['categoria'];
                $resul.="<tr><td style='text-align:center; vertical-align:middle;'>".$nombre."</td><td style='text-align:center; vertical-align:middle;'>".$precio." €</td><td style='text-align:center; vertical-align:middle;'>".$usuario." </td><td style='text-align:center; vertical-align:middle;'><input type='submit' value='Borrar Propiedad' class='btn btn-primary' onclick=\"borrarPropiedad('$nombre');\" style='font-family:fantasy;'></td></tr>";
                $cont++;
            }
            $resul .= "</table>";
            $resul.= "<br><br>";
            echo $resul; 
        }
    }
}