<?php
include 'conexion.php';

$error = '';
// Obtener marcas para el select
$marcas = $conexion->query("SELECT idMarca, Nombre FROM marcas ORDER BY Nombre");

// Validar que haya id por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: autos.php?msg=ID+no+válido");
    exit;
}

$idAuto = intval($_GET['id']);

// Si es POST, actualizar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $idMarca = intval($_POST['idMarca']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    $precio = floatval($_POST['precio']);
    $imagen = $conexion->real_escape_string($_POST['imagen']);
    $video = $conexion->real_escape_string($_POST['video']);

    $sqlUpdate = "UPDATE autos SET
        Nombre = '$nombre',
        idMarca = $idMarca,
        Descripcion = '$descripcion',
        fecha = '$fecha',
        imagen = '$imagen',
        precio = $precio,
        video = '$video'
        WHERE idAuto = $idAuto";

    if ($conexion->query($sqlUpdate)) {
        header("Location: autos.php?msg=Auto+actualizado+correctamente");
        exit;
    } else {
        $error = "Error al actualizar: " . $conexion->error;
    }
}

// Obtener datos actuales del auto para llenar el formulario
$sql = "SELECT * FROM autos WHERE idAuto = $idAuto";
$result = $conexion->query($sql);
if ($result->num_rows === 0) {
    header("Location: autos.php?msg=Auto+no+encontrado");
    exit;
}
$auto = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Auto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2>Editar Auto</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required value="<?= htmlspecialchars($auto['Nombre']) ?>" />
    </div>

    <div class="mb-3">
      <label for="idMarca" class="form-label">Marca</label>
      <select name="idMarca" id="idMarca" class="form-select" required>
        <option value="">Seleccione una marca</option>
        <?php while ($marca = $marcas->fetch_assoc()): ?>
          <option value="<?= $marca['idMarca'] ?>" <?= ($marca['idMarca'] == $auto['idMarca']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($marca['Nombre']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required><?= htmlspecialchars($auto['Descripcion']) ?></textarea>
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" name="fecha" id="fecha" class="form-control" required value="<?= htmlspecialchars($auto['fecha']) ?>" />
    </div>

    <div class="mb-3">
      <label for="precio" class="form-label">Precio</label>
      <input type="number" name="precio" id="precio" step="0.01" class="form-control" required value="<?= htmlspecialchars($auto['precio']) ?>" />
    </div>

    <div class="mb-3">
      <label for="imagen" class="form-label">URL de la Imagen</label>
      <input type="url" name="imagen" id="imagen" class="form-control" placeholder="https://..." value="<?= htmlspecialchars($auto['imagen']) ?>" required />
    </div>

    <div class="mb-3">
      <label for="video" class="form-label">URL del Video</label>
      <input type="url" name="video" id="video" class="form-control" placeholder="https://..." value="<?= htmlspecialchars($auto['video']) ?>" />
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="autos.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
