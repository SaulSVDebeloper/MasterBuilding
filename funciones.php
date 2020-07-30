<?php


$conexion = new mysqli('localhost', 'root', '', 'masterDB'); //funcion de conexion a la base de datos 
if ($conexion->connect_error) {
    echo("Conexión fallida: ");
}

/* ------------------------------------------------------------------------------------------------ */

function validar($pass,$email) { //valida a los usuarios de la base de datos
    global $conexion; //variable global de la conexion con la base de datos;
    $nameUser ="";
    $user = "SELECT `nombre` FROM `usuarios` WHERE `email` = '$email';";
    if($valido= $conexion->query($user)){ //recogemos el nombre del user 
        if($valido->num_rows > 0 ){
            while($registro = $valido->fetch_assoc()){
                $nameUser = $registro["nombre"];
                //echo "*".$nameUser."*";
            }
        }
    }
    $consultasql="SELECT * FROM `usuarios` WHERE `email` = '$email' AND `contrasena` = '$pass';";
    if($valido= $conexion->query($consultasql)){ //hacemos la validacion del user del login
        if($valido->num_rows > 0 ){
            return "true|".$nameUser;
        }else{
            return "false|".$nameUser;
        }
    }
}

/* ------------------------------------------------------------------------------------------------ */

function validarEmail($email){  //valida para que el email esté bien escrito
    $matches = null;
    return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email, $matches));
}

/* ------------------------------------------------------------------------------------------------ */

function validaNombreNum($palabra){ //valida que el nombre sea correcto y no contenga números
    $texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
    $aux = "";
    $cont = 0;
    for ($i=0; $i < strlen($palabra); $i++) { 
        if (preg_match($texto,$palabra[$i])) {
            
        }else{
            $cont++;
        }
    }
    return $cont;
}

/* ------------------------------------------------------------------------------------------------ */

function crearCookie($nombreUser){//funcion encargada de crear la cookie del user
    setcookie("nombre", $nombreUser, time()+3600);
}

/* ------------------------------------------------------------------------------------------------ */

function cerrarSession($nombreUser){  // cierra la sesion y manda al user al login
    session_start();
    unset($_SESSION);
    setcookie(session_name(),'',time()-3600);
    setcookie("nombre", $nombreUser,time()-3600);
    session_destroy();
    header("location: login.php");
}

/* ------------------------------------------------------------------------------------------------ */

function recordatorioUser($logueado){ //creamos un recordatorio de los user conectados
    $ruta  = "recordatorio.txt";
    if (isset($ruta)) {
        $fichero = fopen("recordatorio.txt", "a+");
        fwrite($fichero, $logueado . PHP_EOL);
        fclose($fichero);
    }else{
        $fichero = fopen("recordatorio.txt", "w+");
        fwrite($fichero, $logueado . PHP_EOL);
        fclose($fichero);
    }
}
/* ------------------------------------------------------------------------------------------------ */
function modificarDatos(){
    $desple="";
    $desple=desplegableNombreP();
    $resul="";
    $resul.= "<div style='font-family:fantasy; margin-left:10px;'>";
    $resul.= "<form action='' method='post'>";
    $resul.= "<table class='table' style='text-align:center; font-size:18px;'>";
    $resul.= "<tr><th colspan='2' style='text-align:center; font-size:25px;'><u>Modificar Precio Propiedad</u></th></tr>";
    $resul.= "<tr><td>Producto ".$desple."</td></tr>";
    $resul.= "<tr><td>Nuevo Precio Alquiler<input type='text' name='nuevoPrecio' style='border-radius:10px; margin-left:20px;' placeholder='New Price'></td></tr>";
    $resul.= "<tr><td colspan='2' align='center'><input type='submit' class='btn btn-primary' value='Modificar' name='modificarPrecioPro' style='margin-top:5px;'></td></tr>";
    $resul.= "</table>";
    $resul.= "</div>";
    $resul.= "<br>";
    $resul.= "</form>";
    return $resul;

}
/* ------------------------------------------------------------------------------------------------ */

function modificarDatosUser(){
    $resul="";
    $resul.= "<div style='font-family:fantasy; margin-left:10px;'>";
    $resul.= "<form action='' method='post'>";
    $resul.= "<table class='table' style='text-align:center; font-size:18px;'>";
    $resul.= "<tr><th colspan='2' style='text-align:center; font-size:25px;'><u>Modificar Nombre</u></th></tr>";
    $resul.= "<tr><td>Nuevo Nombre<input type='text' name='modiNombre' style='border-radius:10px; margin-left:20px;' placeholder='New Name'></td></tr>";
    $resul.= "<tr><td colspan='2' align='center'><input type='submit' class='btn btn-primary' value='Modificar' name='newName' style='margin-top:5px;'></td></tr>";
    $resul.= "</table>";
    $resul.= "</div>";
    $resul.= "<br>";
    $resul.= "</form>";
    return $resul;

}

/* ------------------------------------------------------------------------------------------------ */

function modificarPassUser(){
    $resul="";
    $resul.= "<div style='font-family:fantasy; margin-left:10px;'>";
    $resul.= "<form action='' method='post'>";
    $resul.= "<table class='table' style='text-align:center; font-size:18px;'>";
    $resul.= "<tr><th colspan='2' style='text-align:center; font-size:25px;'><u>Modificar Contraseña</u></th></tr>";
    $resul.= "<tr><td>Nueva Contraseña<input type='text' name='modiPass' style='border-radius:10px; margin-left:20px;' placeholder='New Password'></td></tr>";
    $resul.= "<tr><td>Repetir Contraseña<input type='text' name='repeModiPass' style='border-radius:10px; margin-left:20px;' placeholder='New Password'></td></tr>";
    $resul.= "<tr><td colspan='2' align='center'><input type='submit' class='btn btn-primary' value='Modificar' name='newPass' style='margin-top:5px;'></td></tr>";
    $resul.= "</table>";
    $resul.= "</div>";
    $resul.= "<br>";
    $resul.= "</form>";
    return $resul;

}

/* ------------------------------------------------------------------------------------------------ */

function desplegableNombreP(){
    $resul = "";
    $aux =array();
    $nombres = "";
    $dummy ="";
    
    global $conexion;
    $selec = "SELECT * FROM `propiedades`;";
    if($valido= $conexion->query($selec)){ 
        while($registro = $valido->fetch_assoc()){  // nos debuelve un array asociativo del resultado del sql
            $nombres = $registro['nombreCalle'];
            if (!in_array($nombres, $aux)) {
                array_push($aux,$nombres);
            }
        }
    }
    $resul.="<select name='nombreModificar' style='font-family:fantasy; border-radius: 10px;'>";
    $resul.="<option value='elije'>Elija Propiedad</option>";
    for ($i=0; $i < count($aux); $i++) {
        $resul.="<option value='$aux[$i]'>$aux[$i]</option>";
    }
    $resul.= "</select>";
    return $resul;
}
/* ------------------------------------------------------------------------------------------------ */

function desplegableUsuario(){
    $resul = "";
    $aux =array();
    $nombres = "";
    $dummy ="";
    
    global $conexion;
    $selec = "SELECT * FROM `usuarios`;";
    if($valido= $conexion->query($selec)){ 
        while($registro = $valido->fetch_assoc()){  // nos debuelve un array asociativo del resultado del sql
            $nombres = $registro['email'];
            if (!in_array($nombres, $aux)) {
                array_push($aux,$nombres);
            }
        }
    }
    $resul.="<select name='usuarioAlquiler' style='font-family:fantasy; border-radius: 10px;'>";
    $resul.="<option value='elije'>Elija Usuario</option>";
    for ($i=0; $i < count($aux); $i++) {
        $resul.="<option value='$aux[$i]'>$aux[$i]</option>";
    }
    $resul.= "</select>";
    return $resul;
}
/* ------------------------------------------------------------------------------------------------ */

function modificarPrecio($precioModifi,$nombrePro){
    //echo $precioModifi."|".$nombrePro;
    $modificar ="";
    global $conexion;
    $modificar = "UPDATE `propiedades` SET `precioAlquiler`='$precioModifi' WHERE `nombreCalle` = '$nombrePro';";
    $conexion->query($modificar);            
}

/* ------------------------------------------------------------------------------------------------ */

function mostrarUserCasa($name){
    $email="";
    global $conexion;
    $cargar = "SELECT `email` FROM `usuarios` WHERE `nombre` = '$name';";
    if($valido= $conexion->query($cargar)){ 
        if($valido->num_rows > 0 ){
            while($registro = $valido->fetch_assoc()){
                $email = $registro['email'];
            }
        }
    }
    return $email;
}

/* ------------------------------------------------------------------------------------------------ */

function cambiarNombre($name,$email){
    global $conexion;
    $modificar ="";
    $modificar = "UPDATE `usuarios` SET `nombre`='$name' WHERE `email` = '$email';";
    $conexion->query($modificar); 
}

/* ------------------------------------------------------------------------------------------------ */

function cambiarPass($pass,$email){
    $modificar ="";
    global $conexion;
    $modificar = "UPDATE `usuarios` SET `contrasena`='$pass' WHERE `email` = '$email';";
    $conexion->query($modificar);  
}

/* ------------------------------------------------------------------------------------------------ */

function agregarNuevoInquilino(){
    $desple="";
    $desple=desplegableNombreP();
    $resul="";
    $resul.= "<div style='font-family:fantasy; margin-left:10px;'>";
    $resul.= "<form action='' method='post'>";
    $resul.= "<table class='table' style='text-align:center; font-size:18px;'>";
    $resul.= "<tr><th colspan='2' style='text-align:center; font-size:25px;'><u>Nuevo Inquilino</u></th></tr>";
    $resul.= "<tr><td>Nombre<input type='text' name='nameRenting' style='border-radius:10px; margin-left:20px;' placeholder='Name'></td></tr>";
    $resul.= "<tr><td>Email<input type='text' name='emailRenting' style='border-radius:10px; margin-left:20px;' placeholder='New Email'></td></tr>";
    $resul.= "<tr><td>Contraseña<input type='text' name='passRenting' style='border-radius:10px; margin-left:20px;' placeholder='New Pass'></td></tr>";
    $resul.= "<tr><td>Repetir Contraseña<input type='text' name='passRentingRepe' style='border-radius:10px; margin-left:20px;' placeholder='New Pass'></td></tr>";
    $resul.= "<tr><td colspan='2' align='center'><input type='submit' class='btn btn-primary' value='Agregar' name='nuevoInquilino' style='margin-top:5px;'></td></tr>";
    $resul.= "</table>";
    $resul.= "</div>";
    $resul.= "<br>";
    $resul.= "</form>";
    return $resul;
    
}

/* ------------------------------------------------------------------------------------------------ */

function agregarNuevaPropiedad(){
    $desple="";
    $desple=desplegableUsuario();
    $resul="";
    $resul.= "<div style='font-family:fantasy; margin-left:10px;'>";
    $resul.= "<form action='' method='post'>";
    $resul.= "<table class='table' style='text-align:center; font-size:18px;'>";
    $resul.= "<tr><th colspan='2' style='text-align:center; font-size:25px;'><u>Nueva Propiedad</u></th></tr>";
    $resul.= "<tr><td>Calle Propiedad<input type='text' name='calle' style='border-radius:10px; margin-left:20px;' placeholder='Calle'></td></tr>";
    $resul.= "<tr><td>Precio Alquiler<input type='text' name='precio' style='border-radius:10px; margin-left:20px;' placeholder='Precio'></td></tr>";
    $resul.= "<tr><td>Categoría<input type='text' name='categoria' style='border-radius:10px; margin-left:20px;' placeholder='Categoría'></td></tr>";
    $resul.= "<tr><td>Usuario $desple</td></tr>";
    $resul.= "<tr><td colspan='2' align='center'><input type='submit' class='btn btn-primary' value='Agregar' name='nuevaPropiedadAgregar' style='margin-top:5px;'></td></tr>";
    $resul.= "</table>";
    $resul.= "</div>";
    $resul.= "<br>";
    $resul.= "</form>";
    return $resul;
    
}

/* ------------------------------------------------------------------------------------------------ */

function agragarNuevoInquilinoDB($nameRenting,$email,$newPass){
    global $conexion;
    $existe = "SELECT `email` FROM `usuarios` WHERE `email` = '$email';";
    if($valido= $conexion->query($existe)){ //comprobamos si el producto existe en el carro
        if($valido->num_rows > 0 ){
            return "<u><b><font color ='red'>Ese usuario ya existe y no lo podemos agregar</font></b></u>";
        }else{
            $conexionPro = new PDO('mysql:host=localhost; dbname=masterDB', 'root', '');
            $conexionPro->exec("INSERT INTO `usuarios` (`nombre`, `email`, `contrasena`) VALUES ('$nameRenting', '$email', '$newPass');");
            return "Usuario añadido correctamente";
        }
    }
    unset($conexionPro);
}

/* ------------------------------------------------------------------------------------------------ */

function nuevaPropiedad($nombreCalle,$precioAlquiler,$categoria,$inquilino){
    global $conexion;
    $existe = "SELECT `nombreCalle` FROM `propiedades` WHERE `nombreCalle` = '$nombreCalle';";
    if($valido= $conexion->query($existe)){ //comprobamos si el producto existe en el carro
        if($valido->num_rows > 0 ){
            return "<u><b><font color ='red'>Ese usuario ya existe y no lo podemos agregar</font></b></u>";
        }else{
            $conexionPro = new PDO('mysql:host=localhost; dbname=masterDB', 'root', '');
            $conexionPro->exec("INSERT INTO `propiedades` (`nombreCalle`, `precioAlquiler`, `categoria`, `usuario`) VALUES ('$nombreCalle', '$precioAlquiler', '$categoria', '$inquilino');");
            return "Propiedad añadida correctamente";
        }
    }
    unset($conexionPro);
}