<?php
include 'conexion.php';

// Consulta para obtener autos con el nombre de la marca
$sql = "SELECT autos.*, marcas.Nombre AS nombreMarca 
        FROM autos 
        LEFT JOIN marcas ON autos.idMarca = marcas.idMarca
        ORDER BY autos.fecha DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Gestión de Autos</title>
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
      <ul class="navbar-nav me-auto">
      </ul>
      <div class="d-flex align-items-center">
        <i class="bi bi-person-circle fs-4 me-2"></i>
        <span>Administrador</span>
      </div>
    </div>
  </div>
</nav>

<!-- CONTENIDO -->
<div class="container mt-5">
  <h2 class="mb-4">Gestión de Autos</h2>
  <a href="crear_auto.php" class="btn btn-success mb-3">Agregar Auto</a>

  <table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Descripción</th>
        <th>Fecha</th>
        <th>Precio</th>
        <th>Imagen</th>
        <th>Video</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($auto = $resultado->fetch_assoc()): ?>
      <tr>
        <td><?= $auto['idAuto'] ?></td>
        <td><?= htmlspecialchars($auto['Nombre']) ?></td>
        <td><?= htmlspecialchars($auto['nombreMarca'] ?? 'Sin marca') ?></td>
        <td><?= htmlspecialchars($auto['Descripcion']) ?></td>
        <td><?= htmlspecialchars($auto['fecha']) ?></td>
        <td>$<?= number_format($auto['precio'], 2) ?></td>
        <td>
          <?php if ($auto['imagen']): ?>
            <img src="<?= htmlspecialchars($auto['imagen']) ?>" alt="Imagen" style="width: 80px; height: auto; object-fit: cover;">
          <?php else: ?>
            N/A
          <?php endif; ?>
        </td>
        <td>
          <?php if ($auto['video']): ?>
            <a href="<?= htmlspecialchars($auto['video']) ?>" target="_blank">Ver video</a>
          <?php else: ?>
            N/A
          <?php endif; ?>
        </td>
        <td>
          <a href="editar_auto.php?id=<?= $auto['idAuto'] ?>" class="btn btn-warning btn-sm">Editar</a>
          <a href="eliminar_auto.php?id=<?= $auto['idAuto'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este auto?');">Eliminar</a>
        </td>
      </tr>
      <?php endwhile; ?>
      <?php if ($resultado->num_rows === 0): ?>
      <tr>
        <td colspan="8" class="text-center">No hay autos registrados.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
