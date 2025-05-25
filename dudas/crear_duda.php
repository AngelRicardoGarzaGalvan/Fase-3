<?php
include 'conexion.php';

// Obtener lista de usuarios para el select (asumiendo que quieres seleccionar el usuario)
$sqlUsuario = "SELECT idUsuario, Nombre FROM usuario ORDER BY Nombre";
$resultUsuario = $conn->query($sqlUsuario);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = intval($_POST['idUsuario']);
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $descripcion = trim($_POST['descripcion']);

    // Validar
    if (!$idUsuario || empty($nombre) || empty($telefono) || empty($correo) || empty($descripcion)) {
        $error = "Por favor llena todos los campos correctamente.";
    } else {
        // Insertar
        $stmt = $conn->prepare("INSERT INTO dudas (idUsuario, Nombre, Telefono, Correo, Descripcion, fecha) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("issss", $idUsuario, $nombre, $telefono, $correo, $descripcion);

        if ($stmt->execute()) {
            header("Location: dudas.php?msg=creado");
            exit;
        } else {
            $error = "Error al guardar la duda: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Crear Duda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-5">
  <h2>Agregar Nueva Duda</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post" action="">
    <div class="mb-3">
      <label for="idUsuario" class="form-label">Usuario</label>
      <select id="idUsuario" name="idUsuario" class="form-select" required>
        <option value="">Selecciona un usuario</option>
        <?php while($user = $resultUsuario->fetch_assoc()): ?>
          <option value="<?= $user['idUsuario'] ?>" <?= (isset($idUsuario) && $idUsuario == $user['idUsuario']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($user['Nombre']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="telefono" class="form-label">Teléfono</label>
      <input type="text" id="telefono" name="telefono" class="form-control" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="correo" class="form-label">Correo</label>
      <input type="email" id="correo" name="correo" class="form-control" value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="dudas.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
