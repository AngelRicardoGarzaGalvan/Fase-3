<?php
include 'conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: autos.php");
    exit;
}

$id = intval($id);

$sql = "SELECT Nombre FROM autos WHERE idAuto = $id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows === 0) {
    header("Location: autos.php");
    exit;
}

$auto = $resultado->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eliminar pedidos relacionados primero
    $deletePedidos = "DELETE FROM pedidos WHERE idAuto = $id";
    if ($conexion->query($deletePedidos) === false) {
        $error = "Error eliminando pedidos relacionados: " . $conexion->error;
    } else {
        // Luego eliminar el auto
        $deleteAuto = "DELETE FROM autos WHERE idAuto = $id";
        if ($conexion->query($deleteAuto)) {
            header("Location: autos.php?msg=Auto eliminado correctamente");
            exit;
        } else {
            $error = "Error eliminando el auto: " . $conexion->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Eliminar Auto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2>Eliminar Auto</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php else: ?>
    <div class="alert alert-warning">
      ¿Seguro que quieres eliminar el auto <strong><?= htmlspecialchars($auto['Nombre']) ?></strong>?
    </div>

    <form method="post" class="d-inline">
      <button type="submit" class="btn btn-danger">Sí, eliminar</button>
      <a href="autos.php" class="btn btn-secondary">Cancelar</a>
    </form>
  <?php endif; ?>
</div>
</body>
</html>
