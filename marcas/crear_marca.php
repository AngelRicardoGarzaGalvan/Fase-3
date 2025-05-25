<?php
// /marcas/crear_marca.php
require 'conexion.php';
$nombre = '';
$error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    if ($nombre === '') {
        $error = 'El nombre es obligatorio.';
    } else {
        $stmt = $conn->prepare("INSERT INTO marcas (Nombre) VALUES (?)");
        $stmt->bind_param('s', $nombre);
        if ($stmt->execute()) {
            header('Location: marcas.php');
            exit;
        } else {
            $error = 'Error al guardar: ' . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Marca</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h1 class="mb-4">+ Nueva Marca</h1>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" id="nombre"
               class="form-control" value="<?= htmlspecialchars($nombre, ENT_QUOTES) ?>">
      </div>
      <button class="btn btn-success">Guardar</button>
      <a href="marcas.php" class="btn btn-secondary">Cancelar</a>
    </form>
  </div>
</body>
</html>
