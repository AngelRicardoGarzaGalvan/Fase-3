<?php
$conexion = new mysqli("localhost", "root", "", "agencia_autos");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
