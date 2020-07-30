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
$cargar = "SELECT * FROM `gastoscomunes` LIMIT $pagina, 4;";

$resul = "";
$cont = 0;
$tipoProducto ="";
if($valido= $conexion->query($cargar)){ //recogemos el nombre del user 
    if($valido->num_rows > 0 ){
        if ($mostrar == "Todo" || $mostrar == "Elija" || $mostrar == "") {
            //$tipoProducto = desplegableTipoPropiedadesAjaxDBAdmin(); //creamos el desplegable para el admin
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='3' style='font-family:fantasy; color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch;'><h3>Gastos Comunes</h3></th></tr>";
            $resul .= "<tr><td style='text-align:center; vertical-align:middle;'><b><u>COSTES</u></b></td><td style='text-align:center; vertical-align:middle;'><b><u>PRECIO PAGAR</u></b></td><td style='text-align:center; vertical-align:middle;'><b><u>Mes Arreglo</u></b></td></tr>";
            while($registro = $valido->fetch_assoc()){
                $costes = $registro['costes'];
                $definicion = $registro['definir'];
                $mes = $registro['mesArreglo'];
                $resul.="<tr><td style='text-align:center; vertical-align:middle;'>".$costes." €</td><td style='text-align:center; vertical-align:middle;'>".$definicion."</td><td style='text-align:center; vertical-align:middle;'>".$mes."</td></tr>";
                $cont++;
            }
            $resul.="<tr><td></td></tr>";
            $resul.= "<tr><td colspan='3' style='text-align:left; vertical-align:middle;'><p style='margin-left:75px;'><input type='submit' value=' Anterior ' class='btn btn-primary' onclick=\"anterior2('$pagina');\">";
            $resul.= " --- ";
            $resul.= "<input type='submit' value=' Siguiente ' class='btn btn-primary' onclick=\"siguiente2('$pagina');\"></p></td></tr>";
            $resul .= "</table>";
            $resul.= "<br><br>";
            echo $resul;

        }else{
            $cargar = "SELECT * FROM `propiedades`";
            $valido= $conexion->query($cargar);
            //$tipoProducto = desplegableTipoPropiedadesAjaxDBAdmin();//creamos el desplegable para el admin
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='2' style='font-family:fantasy; color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch;'><h3>Gastos Comunes</h3></th></tr>";
            $resul .= "<tr><td style='text-align:center; vertical-align:middle;'><b><u>COSTES</u></b></td><td style='text-align:center; vertical-align:middle;'><b><u>PRECIO PAGAR</u></b></td></tr>";
            while($registro = $valido->fetch_assoc()){
                $costes = $registro['costes'];
                $definicion = $registro['definir'];
                $resul.="<tr><td style='text-align:center; vertical-align:middle;'>".$costes." €</td><td style='text-align:center; vertical-align:middle;'>".$definicion."</td></tr>";
                $cont++;
            }
            $resul .= "</table>";
            $resul.= "<br><br>";
            echo $resul; 
        }
    }
}