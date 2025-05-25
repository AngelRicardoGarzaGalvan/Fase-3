<?php
include 'conexion.php';

$idDuda = intval($_GET['id'] ?? 0);

if ($idDuda) {
    $stmt = $conn->prepare("DELETE FROM dudas WHERE idDuda = ?");
    $stmt->bind_param("i", $idDuda);
    $stmt->execute();
    $stmt->close();
}

header("Location: dudas.php?msg=eliminado");
exit;
