<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['idUsuario'])) {
    die("Acceso denegado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idPedido'])) {
    $idPedido = intval($_POST['idPedido']);
    $idUsuario = $_SESSION['idUsuario'];

    // Verifica que el pedido le pertenece al usuario antes de eliminar
    $sql = "DELETE FROM pedidos WHERE idPedido = ? AND idUsuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $idPedido, $idUsuario);

    if ($stmt->execute()) {
        header("Location: historialpedidos.php");
        exit();
    } else {
        echo "Error al cancelar el pedido.";
    }

    $stmt->close();
}
?>
