<?php
include 'conexion.php';

$idDuda = intval($_GET['id'] ?? 0);
if (!$idDuda) {
    header("Location: dudas.php");
    exit;
}

// Obtener la duda actual
$stmt = $conn->prepare("SELECT * FROM dudas WHERE idDuda = ?");
$stmt->bind_param("i", $idDuda);
$stmt->execute();
$result = $stmt->get_result();
$duda = $result->fetch_assoc();
$stmt->close();

if (!$duda) {
    header("Location: dudas.php");
    exit;
}

// Obtener usuarios para select
$sqlUsuario = "SELECT idUsuario, Nombre FROM usuario ORDER BY Nombre";
$resultUsuario = $conn->query($sqlUsuario);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = intval($_POST['idUsuario']);
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $descripcion = trim($_POST['descripcion']);

    if (!$idUsuario || empty($nombre) || empty($telefono) || empty($correo) || empty($descripcion)) {
        $error = "Por favor llena todos los campos correctamente.";
    } else {
        $stmt = $conn->prepare("UPDATE dudas SET idUsuario=?, Nombre=?, Telefono=?, Correo=?, Descripcion=? WHERE idDuda=?");
        $stmt->bind_param("issssi", $idUsuario, $nombre, $telefono, $correo, $descripcion, $idDuda);

        if ($stmt->execute()) {
            header("Location: dudas.php?msg=editado");
            exit;
        } else {
            $error = "Error al actualizar la duda: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Duda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-5">
  <h2>Editar Duda</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post" action="">
    <div class="mb-3">
      <label for="idUsuario" class="form-label">Usuario</label>
      <select id="idUsuario" name="idUsuario" class="form-select" required>
        <option value="">Selecciona un usuario</option>
        <?php while($user = $resultUsuario->fetch_assoc()): ?>
          <option value="<?= $user['idUsuario'] ?>" 
            <?= ((isset($idUsuario) && $idUsuario == $user['idUsuario']) || (!isset($idUsuario) && $duda['idUsuario'] == $user['idUsuario'])) ? 'selected' : '' ?>>
            <?= htmlspecialchars($user['Nombre']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control" 
        value="<?= htmlspecialchars($_POST['nombre'] ?? $duda['Nombre']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono</label>
      <input type="text" id="telefono" name="telefono" class="form-control" 
        value="<?= htmlspecialchars($_POST['telefono'] ?? $duda['Telefono']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="correo" class="form-label">Correo</label>
      <input type="email" id="correo" name="correo" class="form-control" 
        value="<?= htmlspecialchars($_POST['correo'] ?? $duda['Correo']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($_POST['descripcion'] ?? $duda['Descripcion']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="dudas.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
