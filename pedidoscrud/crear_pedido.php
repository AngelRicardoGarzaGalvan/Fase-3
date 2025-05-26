<?php
include 'conexion.php';

$usuarios = $conexion->query("SELECT idUsuario, Nombre FROM usuario ORDER BY Nombre");
$autos = $conexion->query("SELECT idAuto, Nombre FROM autos ORDER BY Nombre");
$planes = $conexion->query("SELECT idPlan, Nombre FROM planespago ORDER BY Nombre");

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = intval($_POST['idUsuario']);
    $idAuto = intval($_POST['idAuto']);
    $idPlan = intval($_POST['idPlan']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $opinion = $conexion->real_escape_string($_POST['opinion']);
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO pedidos (idUsuario, idAuto, idPlan, Telefono, Correo, Opinion, fecha)
            VALUES ($idUsuario, $idAuto, $idPlan, '$telefono', '$correo', '$opinion', '$fecha')";

    if ($conexion->query($sql)) {
        header("Location: pedidos.php?msg=Pedido+creado+correctamente");
        exit;
    } else {
        $error = "Error al crear el pedido: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Crear Pedido</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2>Crear Pedido</h2>
  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label for="idUsuario" class="form-label">Usuario</label>
      <select name="idUsuario" class="form-select" required>
        <option value="">Seleccione</option>
        <?php while ($usuario = $usuarios->fetch_assoc()): ?>
          <option value="<?= $usuario['idUsuario'] ?>"><?= htmlspecialchars($usuario['Nombre']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="idAuto" class="form-label">Auto</label>
      <select name="idAuto" class="form-select" required>
        <option value="">Seleccione</option>
        <?php while ($auto = $autos->fetch_assoc()): ?>
          <option value="<?= $auto['idAuto'] ?>"><?= htmlspecialchars($auto['Nombre']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="idPlan" class="form-label">Plan</label>
      <select name="idPlan" class="form-select" required>
        <option value="">Seleccione</option>
        <?php while ($plan = $planes->fetch_assoc()): ?>
          <option value="<?= $plan['idPlan'] ?>"><?= htmlspecialchars($plan['Nombre']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono</label>
      <input type="text" name="telefono" class="form-control" required />
    </div>

    <div class="mb-3">
      <label for="correo" class="form-label">Correo</label>
      <input type="email" name="correo" class="form-control" required />
    </div>

    <div class="mb-3">
      <label for="opinion" class="form-label">Opinión</label>
      <textarea name="opinion" class="form-control" rows="3" required></textarea>
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" name="fecha" class="form-control" required />
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="pedidos.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
