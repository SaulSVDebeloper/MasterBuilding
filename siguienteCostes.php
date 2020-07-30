<?php

include "funciones.php";

if (isset($_REQUEST['valor'])) {
    $pag= $_REQUEST['valor'];
    $inicio = $pag;
    $paginita = $inicio + 3;
    global $conexion;
    $cargar = "SELECT * FROM `gastoscomunes`;";
    $resul = "";
    $tipoProducto ="";
    $valido= $conexion->query($cargar); //recogemos el nombre de la casa 
    $cantidad = $valido->num_rows; //cantidad 14 total casas
    $cantidad= $cantidad /3;
    $cantidad = ceil($cantidad);
    $cantidad = $cantidad * 3;
    $cantidad = $cantidad - 3;
    if ($pag == $cantidad) {
        $pag = 0 ;
        echo $pag;
    }else{
        $pagina = $pag + 3;
        echo $pagina;
    } 
}