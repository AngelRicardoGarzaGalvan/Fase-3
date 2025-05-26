<?php
$host = 'localhost';
$usuario = 'root';
$contrasena = '';
$baseDeDatos = 'agencia_autos';

// Crear conexión
$conexion = new mysqli($host, $usuario, $contrasena, $baseDeDatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");
?>
