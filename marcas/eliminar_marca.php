<?php
// /marcas/eliminar_marca.php
require 'conexion.php';
$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM marcas WHERE idMarca = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
}
header('Location: marcas.php');
exit;
