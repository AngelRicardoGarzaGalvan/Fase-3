<?php
include 'conexion.php';

// Leer usuarios
$consulta = "SELECT usuario.*, rol.Nombre AS nombreRol 
             FROM usuario 
             JOIN rol ON usuario.idRol = rol.idRol";
$resultado = $conexion->query($consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>CRUD Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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

<div class="container mt-5">
  <h2 class="mb-4">Gestión de Usuarios</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Teléfono</th>
        <th>Rol</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while($fila = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= $fila['idUsuario']?></td>
          <td><?= $fila['Nombre'] ?></td>
          <td><?= $fila['Correo'] ?></td>
          <td><?= $fila['Telefono'] ?></td>
          <td><?= $fila['nombreRol'] ?></td>
          <td><?= $fila['fecha'] ?></td>
          <td>
            <a href="editar_usuario.php?id=<?= $fila['idUsuario'] ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="eliminar_usuario.php?id=<?= $fila['idUsuario'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
