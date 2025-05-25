<?php
// /marcas/editar_marca.php
require 'conexion.php';

$id    = intval($_GET['id'] ?? 0);
$error = '';

if ($id <= 0) {
    die('ID inválido.');
}

// traer dato actual
$stmt = $conn->prepare("SELECT Nombre FROM marcas WHERE idMarca = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($nombre);
if (!$stmt->fetch()) {
    die('Marca no encontrada.');
}
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo = trim($_POST['nombre'] ?? '');
    if ($nuevo === '') {
        $error = 'El nombre no puede quedar vacío.';
    } else {
        $upd = $conn->prepare("UPDATE marcas SET Nombre = ? WHERE idMarca = ?");
        $upd->bind_param('si', $nuevo, $id);
        if ($upd->execute()) {
            header('Location: marcas.php');
            exit;
        } else {
            $error = 'Error al actualizar: ' . $upd->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Marca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h1 class="mb-4">Editar Marca #<?= $id ?></h1>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre"
               class="form-control" value="<?= htmlspecialchars($nombre, ENT_QUOTES) ?>">
      </div>
      <button class="btn btn-primary">Actualizar</button>
      <a href="marcas.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</body>
</html>
