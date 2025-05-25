<?php
// Conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agencia_autos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
