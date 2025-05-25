<?php
// /marcas/conexion.php
$host     = '127.0.0.1';
$user     = 'root';
$password = '';
$database = 'agencia_autos';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
