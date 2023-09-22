<?php
$servername="localhost";
$username="root";
$pass="";



try {
    $conn=new PDO("mysql:host=$servername;dbname=db_resultado",$username,$pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (\Throwable $th) {
    //throw $th;
}

?>