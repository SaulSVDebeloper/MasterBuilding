<?php 
    session_start();
    include "funciones.php";
    $email="";
    $email = $_SESSION['email'] ;
    $name  = "";
    $resul  = "";
    $error = "";
    $modiNombre= "";
    $modiPass= "";
    $tablaModificarNombre ="";
    $tablaModificarNombre =modificarDatosUser();
    $tablaModificarPass ="";
    $tablaModificarPass =modificarPassUser();
    if (isset($_COOKIE['nombre'])) {
        $name1 = $_COOKIE['nombre'];
        $name = "Welcome ".$name1;
        $mostrar=mostrarUserCasa($name1);//descubrimos al user para mostrar su propiedad alquilada y mostrarla
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
        
        if (isset($_POST['volver'])) {
            header("location: indexUser.php");
        }
        if (isset($_POST['newName'])) {
            if (isset($_POST['modiNombre'])) {
                $newNombre = $_POST['modiNombre'];
                if (validaNombreNum($newNombre)!=0) {
                    $error .= "El nombre escrito es erroneo";
                }else{
                    cambiarNombre($newNombre,$email);
                }
            }else{
                $error .= "Debe escribir un Nombre.";
            }
        }

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MasterBuilding</title>

</head>
<body   onload="mostrarDBUser2('<?php echo $mostrar; ?>')" background="imgMaster/fondoBody2.jpg"><!--  onload="mostrarDBUser2($name)" -->
    <div class="page-header" class='page-header' style='width:auto; height:250px;  background-image:url("imgMaster/fondo5.jpg"); text-align:left; font-family:fantasy; font-size: 60px; margin-bottom:10px;'>
            <div class='row' style="width:100%;">
                <div style='margin-top:80px; margin-bottom:10px; margin-left:80px; width:auto; opacity:1; border-radius:30px;'><p style="float:left; color:#039AE1;">MasterBuilding</p></div>
            </div>
    </div>
    <?php
    
    if ($resul != "") {
        echo "<h4 style='font-family:fantasy; margin-left:20px; margin-top:10px; '>".$resul."</h4>";
    }
    if ($name != "") {
        echo "<h4 style='font-family:fantasy; margin-left:20px; margin-top:10px; margin-left:65px;'>".$name."</h4>";
    }
    
    echo "<form action='' method='post'>";
    echo "<input type='submit' value='Volver' name='volver' class='btn btn-primary' style='margin-left:90px; margin-top:10px; margin-bottom:10px; font-family:fantasy;'>";
    echo "</form>";
    echo "<p style='height:30px; background-color:black;'></p>";// Linea dividir
    
    if ($error != "") {
        echo "<div class='error'><h5 style='font-family:fantasy; margin-left:20px;'>".$error."</h5></div>";
    }
    
    if ($tablaModificarNombre != "") {
        echo $tablaModificarNombre;
    }
    echo "<p style='height:30px; background-color:black;'></p>";// Linea dividir
    if ($tablaModificarPass != "") {
        echo $tablaModificarPass;
    }
    

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