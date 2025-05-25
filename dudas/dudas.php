<?php
include 'conexion.php';

// Consulta para obtener dudas junto con el nombre del usuario (si existe)
$sql = "SELECT dudas.*, usuario.Nombre AS nombreUsuario 
        FROM dudas 
        LEFT JOIN usuario ON dudas.idUsuario = usuario.idUsuario";


$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Gestión de Dudas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-light shadow-sm px-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../admin.html">Inicio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto"></ul>
      <div class="d-flex align-items-center">
        <i class="bi bi-person-circle fs-4 me-2"></i>
        <span>Administrador</span>
      </div>
    </div>
  </div>
</nav>

<!-- CONTENIDO -->
<div class="container mt-5">
  <h2 class="mb-4">Gestión de Dudas</h2>
  <a href="crear_duda.php" class="btn btn-success mb-3">Agregar Duda</a>

  <table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Descripción</th>
        <th>Usuario (registrado)</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($resultado && $resultado->num_rows > 0): ?>
        <?php while ($duda = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($duda['Nombre']) ?></td>
          <td><?= htmlspecialchars($duda['Telefono']) ?></td>
          <td><?= htmlspecialchars($duda['Correo']) ?></td>
          <td><?= nl2br(htmlspecialchars($duda['Descripcion'])) ?></td>
          <td><?= htmlspecialchars($duda['nombreUsuario'] ?? 'Invitado') ?></td>
          <td>
            <a href="editar_duda.php?id=<?= $duda['idDuda'] ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="eliminar_duda.php?id=<?= $duda['idDuda'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta duda?');">Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">No hay dudas registradas.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
