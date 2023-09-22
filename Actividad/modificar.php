<?php
require '../Actividad/db/db.php';

session_start();
function nombreAleatorio($longitud) {
    return substr(bin2hex(random_bytes($longitud)), 0, $longitud);
}
if($_FILES['foto']['size'] == 0){
    
    $code=$_POST["code"];
    $nombreMe=$_POST["nombre"];
    $existencia=$_POST["existencia"];
    $precio=$_POST["precio"];

    $query = "UPDATE  medicamentos set nombre=:nombre,existencia=:existencia,precio=:precio where code=:code";
    $ejecutar = $conn->prepare($query);
    $ejecutar->bindParam(":nombre",$nombreMe);
    $ejecutar->bindParam(":existencia",$existencia);

    $ejecutar->bindParam(":precio",$precio);
    $ejecutar->bindParam(":code",$code);
    $ejecutar->execute();
    if($ejecutar){
    
    header("Location: index.php");
    $_SESSION["editar"]=true;
    }

}else{


    $code=$_POST["code"];
    $nombreMe=$_POST["nombre"];
    $existencia=$_POST["existencia"];
    $precio=$_POST["precio"];
    $nombre=$_POST["imagen"];

    $dir="img/";
    $ruta=$dir.$nombre;
    if(file_exists($ruta)){
        if(unlink($ruta)){
            $arreglo=explode(".",$_FILES["foto"]["name"]);
            $extension=strtolower(end($arreglo));
            $nombreAleatorio= nombreAleatorio(64);
            $nombreImagen=$nombreAleatorio.".".$extension;
            $ruta=$dir.$nombreImagen;
            move_uploaded_file($_FILES["foto"]["tmp_name"],$ruta);

            $query = "UPDATE  medicamentos set nombre=:nombre,existencia=:existencia,precio=:precio,imagenes=:imagenes where code=:code";
            $ejecutar = $conn->prepare($query);
            $ejecutar->bindParam(":nombre",$nombreMe);
            $ejecutar->bindParam(":existencia",$existencia);
            $ejecutar->bindParam(":imagenes",$nombreImagen);
            $ejecutar->bindParam(":precio",$precio);
            $ejecutar->bindParam(":code",$code);
            $ejecutar->execute();
            if($ejecutar){
            
                header("Location: index.php");
            $_SESSION["editar"]=true;
            }
            
        }else{
            header("Location: error.php");
        }
    }
}
