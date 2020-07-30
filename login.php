<?php

include "funciones.php";
$resul = "";
$resulvalida = "";
$error = "";
$logueado = ""; 
$aux = array();
$paginacion = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    if (isset($_POST['email'])) {
        $email=$_POST['email'];
        //echo $email;
        if (validarEmail($email) == 0) { //viliadar email bien formado
            $error.= "<u><b><font color ='red'>El email está mal formado</font></b></u><br>";
        } 
    }else{
        $error.= "<u><b><font color ='red'>Debe escribir su email</font></b></u><br><br>";
    }
    if (isset($_POST['pass']) && $_POST['pass'] != "") {
        $pass=$_POST['pass']; 
        //echo $pass;
    }else{
        $error.= "<u><b><font color ='red'>Debe escribir una contraseña</font></b></u><br><br>";
    }

    if ($error == "") {
        $resulValida = validar($pass,$email); //validar a los user y pass
        $aux = explode("|",$resulValida);
        //print_r($aux);
        $nombreUser = $aux[1];
        if ($aux[0] == "true" && $aux[1] == "admin") {
            //echo $nombreUser;
            session_start();
            $_SESSION['nombre'] = $nombreUser;
            $_SESSION['email'] = $email;
            crearCookie($nombreUser);   // creamos la cookie
            $hora = date("F j, Y, g:i a");
            $logueado = $nombreUser.",".$email.",".$hora."|"; 
            recordatorioUser($logueado);
            header("location: indexAdmin.php");// 2º header a la página del admin
        }
        if ($aux[0] == "true" && $aux[1] != "admin") {
            //echo $nombreUser;
            session_start();
            $_SESSION['nombre'] = $nombreUser;
            $_SESSION['email'] = $email;
            echo $_SESSION['email'];
            crearCookie($nombreUser);   // creamos la cookie
            $hora = date("F j, Y, g:i a");
            $logueado = $nombreUser.",".$email.",".$hora."|"; 
            recordatorioUser($logueado);
            header("location: indexUser.php");// 2º header a la página de tienda
        }else{
            $error .= "<u><b><font color ='red'>No tiene cuenta en esta web o la contraseá o email son incorretas</font></b></u><br>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width,user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MasterBuilding</title>
</head>
<body background="imgMaster/fondoBody2.jpg">
    <div class="page-header" class='page-header' style='width:auto; height:250px;  background-image:url("imgMaster/fondo5.jpg"); text-align:left; font-family:fantasy; font-size: 60px; margin-bottom:10px;'>
            <div class='row' style="width:100%;">
                <div style='margin-top:80px; margin-bottom:10px; margin-left:80px; width:auto; opacity:1; border-radius:30px;'><p style="float:left; color:#039AE1;">MasterBuilding</p></div>
            </div>
    </div>
    <form action="" method="post" >
        <table class="table table-striped" style="text-align:center; margin-top:100px;">
            <tr><th><h3>Login</h3></th></tr>
            <tr><td><b>Email User:</b></td></tr>
            <tr><td><input type="text" name="email" style="border-radius:10px;" placeholder="User"></td></tr>
            <tr><td><b>Password:</b></td></tr>
            <tr><td><input type="password" name="pass" style="border-radius:10px;" placeholder="Password"></td></tr>
            <tr><td><input type="submit" value="Connect" class="btn btn-primary"></td></tr>
        </table>
    </form>
    <footer style="background-color:black; height:100px; width: 100%; color:#039AE1; position:absolute; bottom:0;">
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