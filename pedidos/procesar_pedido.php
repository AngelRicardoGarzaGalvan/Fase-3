<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['idUsuario'])) {
    die("No autorizado.");
}

$idUsuario = $_SESSION['idUsuario'];
$idAuto = intval($_POST['idAuto']);
$idPlan = intval($_POST['idPlan']);
$telefono = $conexion->real_escape_string($_POST['telefono']);
$correo = $conexion->real_escape_string($_POST['correo']);
$opinion = $conexion->real_escape_string($_POST['opinion']);
$fecha = date("Y-m-d H:i:s");

$sql = "INSERT INTO pedidos (idUsuario, idAuto, idPlan, Telefono, Correo, Opinion, fecha)
        VALUES ($idUsuario, $idAuto, $idPlan, '$telefono', '$correo', '$opinion', '$fecha')";

if ($conexion->query($sql) === TRUE) {
    header("Location: historialpedidos.php");
    exit;
} else {
    echo "Error al registrar el pedido: " . $conexion->error;
}
?>
