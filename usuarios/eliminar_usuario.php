<?php
include 'conexion.php';

$id = $_GET['id'];
$conexion->query("DELETE FROM usuario WHERE idUsuario = $id");
header("Location: usuarios.php");
exit();
?>
