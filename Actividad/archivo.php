<?php
require '../Actividad/db/db.php';

session_start();
function nombreAleatorio($longitud) {
    return substr(bin2hex(random_bytes($longitud)), 0, $longitud);
}

$nombreMe=$_POST["nombre"];
$existencia=$_POST["existencia"];
$precio=$_POST["precio"];
$fecha=date("Y-m-d");



$arreglo=explode(".",$_FILES["foto"]["name"]);
$extension=strtolower(end($arreglo));
$nombreAleatorio= nombreAleatorio(64);
$nombre=$nombreAleatorio.".".$extension;




$dir="img/";
$ruta=$dir.$nombre;
if(!file_exists($dir)){
    mkdir($dir,0777);
}

move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta);

$query = "INSERT INTO medicamentos(nombre,existencia,fecharegistro,precio,imagenes) values(:nombre,:existencia,:fecharegistro,:precio,:imagenes)";
$ejecutar = $conn->prepare($query);
$ejecutar->bindParam(":nombre",$nombreMe);
$ejecutar->bindParam(":existencia",$existencia);
$ejecutar->bindParam(":fecharegistro",$fecha);
$ejecutar->bindParam(":precio",$precio);
$ejecutar->bindParam(":imagenes",$nombre);
$ejecutar->execute();

header("Location: index.php");
$_SESSION['producto_agregado'] = true; 

?>
