<?php
require '../Actividad/db/db.php';

session_start();
$code=$_GET["code"];

$query = "SELECT * FROM medicamentos where code=$code";
$ejecutar = $conn->prepare($query);
$ejecutar->execute();
$data = $ejecutar->fetchAll(PDO::FETCH_OBJ);

foreach ($data as $medi) {
    $nombre=$medi->imagenes;
}
$dir="img/";
$ruta=$dir.$nombre;
if(file_exists($ruta)){
    if(unlink($ruta)){
        $query = "DELETE FROM  medicamentos where code=:code";
        $ejecutar = $conn->prepare($query);
        $ejecutar->bindParam(":code",$code);
        $ejecutar->execute();
        if($ejecutar){
            header("Location: index.php");
        $_SESSION["eliminar"]=true;
        }
    }

}

?>