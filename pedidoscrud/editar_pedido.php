<?php
include 'conexion.php';

$idPedido = intval($_GET['id'] ?? 0);
if ($idPedido <= 0) {
    header("Location: pedidos.php");
    exit;
}

// Obtener datos del pedido actual
$sqlPedido = "SELECT * FROM pedidos WHERE idPedido = $idPedido";
$resultPedido = $conexion->query($sqlPedido);
if ($resultPedido->num_rows === 0) {
    header("Location: pedidos.php");
    exit;
}
$pedido = $resultPedido->fetch_assoc();

// Listas de selección
$usuarios = $conexion->query("SELECT idUsuario, Nombre FROM usuario ORDER BY Nombre");
$autos = $conexion->query("SELECT idAuto, Nombre FROM autos ORDER BY Nombre");
$planes = $conexion->query("SELECT idPlan, Nombre FROM planespago ORDER BY Nombre");

// Guardar cambios
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = intval($_POST['idUsuario']);
    $idAuto = intval($_POST['idAuto']);
    $idPlan = intval($_POST['idPlan']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $opinion = $conexion->real_escape_string($_POST['opinion']);
    $fecha = $_POST['fecha'];

    $sql = "UPDATE pedidos SET 
                idUsuario = $idUsuario,
                idAuto = $idAuto,
                idPlan = $idPlan,
                Telefono = '$telefono',
                Correo = '$correo',
                Opinion = '$opinion',
                fecha = '$fecha'
            WHERE idPedido = $idPedido";

    if ($conexion->query($sql)) {
        header("Location: pedidos.php?msg=Pedido+actualizado+correctamente");
        exit;
    } else {
        $error = "Error al actualizar el pedido: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2>Editar Pedido</h2>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label for="idUsuario" class="form-label">Usuario</label>
      <select name="idUsuario" class="form-select" required>
        <option value="">Seleccione</option>
        <?php while ($usuario = $usuarios->fetch_assoc()): ?>
          <option value="<?= $usuario['idUsuario'] ?>" <?= $usuario['idUsuario'] == $pedido['idUsuario'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($usuario['Nombre']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="idAuto" class="form-label">Auto</label>
      <select name="idAuto" class="form-select" required>
        <option value="">Seleccione</option>
        <?php while ($auto = $autos->fetch_assoc()): ?>
          <option value="<?= $auto['idAuto'] ?>" <?= $auto['idAuto'] == $pedido['idAuto'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($auto['Nombre']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="idPlan" class="form-label">Plan</label>
      <select name="idPlan" class="form-select" required>
        <option value="">Seleccione</option>
        <?php while ($plan = $planes->fetch_assoc()): ?>
          <option value="<?= $plan['idPlan'] ?>" <?= $plan['idPlan'] == $pedido['idPlan'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($plan['Nombre']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono</label>
      <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($pedido['Telefono']) ?>" required />
    </div>

    <div class="mb-3">
      <label for="correo" class="form-label">Correo</label>
      <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($pedido['Correo']) ?>" required />
    </div>

    <div class="mb-3">
      <label for="opinion" class="form-label">Opinión</label>
      <textarea name="opinion" class="form-control" rows="3" required><?= htmlspecialchars($pedido['Opinion']) ?></textarea>
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" name="fecha" class="form-control" value="<?= $pedido['fecha'] ?>" required />
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="pedidos.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
