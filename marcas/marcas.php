<?php
// /marcas/marcas.php
require 'conexion.php';
$sql    = "SELECT * FROM marcas";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Marcas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light shadow-sm px-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../admin.html">Inicio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
      </ul>
      <div class="d-flex align-items-center">
        <i class="bi bi-person-circle fs-4 me-2"></i>
        <span>Administrador</span>
      </div>
    </div>
  </div>
</nav>
  <div class="container mt-4">
    <h1 class="mb-4">Marcas</h1>
    <a href="crear_marca.php" class="btn btn-success mb-3">+ Nueva Marca</a>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php if($result->num_rows): ?>
        <?php while($m = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $m['idMarca'] ?></td>
          <td><?= htmlspecialchars($m['Nombre'], ENT_QUOTES) ?></td>
          <td>
            <a href="editar_marca.php?id=<?= $m['idMarca'] ?>" class="btn btn-primary btn-sm">Editar</a>
            <a href="eliminar_marca.php?id=<?= $m['idMarca'] ?>"
               onclick="return confirm('¿Seguro que quieres borrar esta marca?');"
               class="btn btn-danger btn-sm">Borrar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="3" class="text-center">No hay marcas aún.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
