<?php
include 'conexion.php';

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $conexion->query("DELETE FROM pedidos WHERE idPedido = $id");
}

header("Location: pedidos.php");
exit;
