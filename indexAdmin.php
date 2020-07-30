<?php 
    include "funciones.php";
    $name  = "";
    $resul  = "";
    $error = "";
    $modificarPropiedad="";
    $modificarPropiedad = modificarDatos();
    $nuevoInquilino="";
    $nuevoInquilino = agregarNuevoInquilino();
    $nuevaPropiedad="";
    $nuevaPropiedad = agregarNuevaPropiedad();
    if (isset($_COOKIE['nombre'])) {
        $name = $_COOKIE['nombre'];
        $name = "Welcome ".$name;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
        if (isset($_POST['close'])) {
            cerrarSession($name);
        }
        if (isset($_POST['costes'])) {
            header("location: costesComunes.php");
        }
        if (isset($_POST['modificarPrecioPro'])) {
            if (isset($_POST['nombreModificar']) && $_POST['nombreModificar']!="elije") {
                $nombreP = $_POST['nombreModificar'];
               if (isset($_POST['nuevoPrecio'])) {
                    $nuevoPrecio = $_POST['nuevoPrecio'];
                    //echo $nombreP."!".$nuevoPrecio;
                    modificarPrecio($nuevoPrecio,$nombreP);
               }else{
                   $error = "Debe introducir un precio.";
               }
            }else{
                $error = "Debe elegir un producto.";
            }
        }
        if (isset($_POST['nuevoInquilino'])) {
            if (isset($_POST['newPass'])) {
                if (isset($_POST['modiPass'])) {
                    $newPass = $_POST['modiPass'];
                    if (isset($_POST['repeModiPass'])) {
                        $newPassRepe = $_POST['repeModiPass'];
                        if ($newPass == $newPassRepe) {
                            cambiarPass($newPass,$email);
                        }else{
                            $error .= "Las contraseñas no coinciden.";
                        }
                    }else{
                        $error .= "Debe repetir la contraseña.";
                    }
                }else{
                    $error .= "Debe escribir una contraseña.";
                }
            }
        }

        if (isset($_POST['nuevoInquilino'])) {
            if (isset($_POST['nameRenting'])) {
                $nameRenting = $_POST['nameRenting'];
            }else{
                $error.= "<u><b><font color ='red'>Debe asignar un nombre</font></b></u><br>";
            }
            if (isset($_POST['emailRenting'])) {
                $email=$_POST['emailRenting'];
                //echo $email;
                if (validarEmail($email) == 0) { //viliadar email bien formado
                    $error.= "<u><b><font color ='red'>El email está mal formado</font></b></u><br>";
                } 
            }else{
                $error.= "<u><b><font color ='red'>Debe escribir su email</font></b></u><br><br>";
            }
            if (isset($_POST['passRenting'])) {
                $newPass = $_POST['passRenting'];
                if (isset($_POST['passRentingRepe'])) {
                    $newPassRepe = $_POST['passRentingRepe'];
                    if ($newPass != $newPassRepe) {
                        $error .= "Las contraseñas no coinciden.";
                    }
                }else{
                    $error .= "Debe repetir la contraseña.";
                }
            }else{
                $error .= "Debe escribir una contraseña.";
            }
            if ($error == "") {
                $resul .= agragarNuevoInquilinoDB($nameRenting,$email,$newPass);
            }else{
                $error .= "Existe un problema.";
            }
        }

        if (isset($_POST['nuevaPropiedadAgregar'])) {
            if (isset($_POST['calle'])) {
                $calle = $_POST['calle'];
            }else{
                $error.= "<u><b><font color ='red'>Debe asignar una calle</font></b></u><br>";
            }
            if (isset($_POST['precio'])) {
                $precio=$_POST['precio'];
            }else{
                $error.= "<u><b><font color ='red'>Debe escribir un precio</font></b></u><br><br>";
            }
            if (isset($_POST['categoria'])) {
                $categoria = $_POST['categoria'];
            }else{
                $error .= "Debe escribir una categoría.";
            }
            if (isset($_POST['usuarioAlquiler'])) {
                $usuarioAlquiler = $_POST['usuarioAlquiler'];
            }else{
                $error .= "Debe elegir un usuario.";
            }
            if ($error == "") {
                $resul .= nuevaPropiedad($calle,$precio,$categoria,$usuarioAlquiler);
            }else{
                $error .= "Existe un problema.";
            }
        }




    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ElectronicStation</title>
<script>

function mostrarDBAdmin2(valor,pag){  // funcion de ajax que muestra los productos al admin
        //document.write(valor);
        if (valor.length == 0) {
            document.getElemenById("resultado").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultado").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "mostrarAlquileresAdmin.php?valor="+valor+"&pag="+pag, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }
    function siguiente(valor){  //funcion de ajax que muestra los productos a los usuarios
        //document.write(valor);
        var todo = "Todo";
        if (valor.length == 0) {
            document.getElemenById("resultado").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resultadoAjax = document.getElementById("resultado").innerHTML = this.responseText;
                setTimeout(mostrarDBAdmin2(todo,resultadoAjax),15);
                }
            };
            xmlhttp.open("GET", "siguiente.php?valor="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }
    
    function anterior(valor){  //funcion de ajax que muestra los productos a los usuarios
        //document.write(valor);
        var todo = "Todo";
        if (valor.length == 0) {
            document.getElemenById("resultado").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resultadoAjax = document.getElementById("resultado").innerHTML = this.responseText;
                setTimeout(mostrarDBAdmin2(todo,resultadoAjax),15);
                }
            };
            xmlhttp.open("GET", "anterior.php?valor="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }

    function borrarPropiedad(valor){  // funcion de ajax que muestra los productos al admin
        //document.write(valor);
        if (valor.length == 0) {
            document.getElemenById("resultadoBorrado").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultadoBorrado").innerHTML = this.responseText;
                setTimeout(mostrarDBAdmin2("Todo"),20);
                }
            };
            xmlhttp.open("GET", "ajaxBorrarPropiedad.php?valorBorrar="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }

</script>
</head>
<body onload="mostrarDBAdmin2('Todo',0)" background="imgMaster/fondoBody2.jpg"><!--  onload="mostrarDBAdmin2('Todo',0)" -->
    <div class="page-header" class='page-header' style='width:auto; height:250px;  background-image:url("imgMaster/fondo5.jpg"); text-align:left; font-family:fantasy; font-size: 60px; margin-bottom:10px;'>
            <div class='row' style="width:100%;">
                <div style='margin-top:80px; margin-bottom:10px; margin-left:80px; width:auto; opacity:1; border-radius:30px;'><p style="float:left; color:#039AE1;">MasterBuilding</p></div>
            </div>
    </div> 
    <?php
    if ($name != "") {
        echo "<h4 style='font-family:fantasy; margin-left:20px; margin-top:10px; margin-left:65px;'>".$name."</h4>";
    }
    
    echo "<form action='' method='post'>";
    echo "<input type='submit' value='Cerrar Sesión' name='close' class='btn btn-primary' style='margin-left:90px; margin-top:10px; margin-bottom:10px; font-family:fantasy;'>";
    echo "<input type='submit' value='Costes Comunes' name='costes' class='btn btn-primary' style='margin-left:90px; margin-top:10px; margin-bottom:10px; font-family:fantasy;'>";
    echo "</form>";
    echo "<br><br>";   
    if ($resul != "") {
        echo "<h4 style='font-family:fantasy; margin-left:20px; margin-top:10px; '>".$resul."</h4>";
    }
    if ($error != "") {
        echo "<div class='error'><h5 style='font-family:fantasy; margin-left:20px;'>".$error."</h5></div>";
    }
    ?>
    <span id="resultadoBorrado"></span>
    <span id="resultadoModificar"></span>
    <span id="resultado"></span>
    <?php
    echo "<p style='height:30px; background-color:black;'></p>";
    echo "<br><br>";
    if ($modificarPropiedad!="") {
        echo $modificarPropiedad;
    }
    echo "<br><br>";
    echo "<p style='height:30px; background-color:black;'></p>";
    if ($nuevoInquilino!="") {
        echo $nuevoInquilino;
    }

    echo "<br><br>";
    echo "<p style='height:30px; background-color:black;'></p>";
    if ($nuevaPropiedad!="") {
        echo $nuevaPropiedad;
    }
    echo "<br><br>";
    ?>
    <div style="height:80px;"></div> <!-- estructura -->
    <footer style="background-color:black; height:100px; width: 100%; color:#039AE1; position:fixed; bottom:0;">
        <div class='row' style="width:100%;">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"  style="text-aling:center;  width:auto;"><p style="margin-top:40px; margin-left:20px; font-size:14px;">Copyright© 2020 MasterBuilding</p></div>
            <div class="d-none d-sm-block col-md-4 col-lg-4"  style=" text-aling:center; width:auto;"><h3 style="margin-top:35px; margin-bottom:20px; vertical-align:middle; margin-left:43px; float:right;">MasterBuilding</h3></div>
            <div class="d-none d-sm-block col-md-4 col-lg-4"  style=" vertical-align:middle;  width:auto; margin-top:20px;">
                <div class="float-right" style="margin-top:20px; margin-right:5px; font-size:14px;"><a href=""><img src='imgMaster/facebook.png'  style='width:30px; height:30px; border-radius:20px;'></a></div>
                <div class="float-right" style="margin-top:20px; margin-right:5px; font-size:14px;"><a href=""><img src='imgMaster/twitter.png'  style='width:30px; height:30px; border-radius:20px;'></a></div>
                <div class="float-right" style="margin-top:20px; margin-right:5px; font-size:14px;"><a href=""><img src='imgMaster/instagram.png'  style='width:30px; height:30px; border-radius:20px;'></a></div>
            </div>
        </div>
    </footer>
    
</body>
</html>