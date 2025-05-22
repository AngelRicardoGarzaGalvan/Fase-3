<?php
$host = "localhost"; 
$user = "root";
$pass = "";
$dbname = "agencia_autos";

$conexion = new mysqli($host, $user, $pass, $dbname);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
