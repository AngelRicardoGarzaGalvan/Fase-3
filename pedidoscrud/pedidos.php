<?php
include 'conexion.php';

$sql = "SELECT pedidos.*, 
               usuario.Nombre AS nombreUsuario, 
               autos.Nombre AS nombreAuto, 
               planespago.Nombre AS nombrePlan
        FROM pedidos
        LEFT JOIN usuario ON pedidos.idUsuario = usuario.idUsuario
        LEFT JOIN autos ON pedidos.idAuto = autos.idAuto
        LEFT JOIN planespago ON pedidos.idPlan = planespago.idPlan
        ORDER BY pedidos.fecha DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Gestión de Pedidos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Gestión de Pedidos</h2>
  <a href="crear_pedido.php" class="btn btn-success mb-3">Agregar Pedido</a>

  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>Usuario</th>
        <th>Auto</th>
        <th>Plan</th>
        <th>Teléfono</th>
        <th>Correo</th>
        <th>Opinión</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($pedido = $resultado->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($pedido['nombreUsuario']) ?></td>
          <td><?= htmlspecialchars($pedido['nombreAuto']) ?></td>
          <td><?= htmlspecialchars($pedido['nombrePlan']) ?></td>
          <td><?= htmlspecialchars($pedido['Telefono']) ?></td>
          <td><?= htmlspecialchars($pedido['Correo']) ?></td>
          <td><?= htmlspecialchars($pedido['Opinion']) ?></td>
          <td><?= htmlspecialchars($pedido['fecha']) ?></td>
          <td>
            <a href="editar_pedido.php?id=<?= $pedido['idPedido'] ?>" class="btn btn-warning btn-sm">Editar</a>
            <a href="eliminar_pedido.php?id=<?= $pedido['idPedido'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este pedido?')">Eliminar</a>
          </td>
        </tr>
      <?php endwhile; ?>
      <?php if ($resultado->num_rows === 0): ?>
        <tr>
          <td colspan="8" class="text-center">No hay pedidos registrados.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
