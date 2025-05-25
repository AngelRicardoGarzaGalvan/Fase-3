<?php
include 'conexion.php';

// Obtener marcas para el select
$marcas = $conexion->query("SELECT idMarca, Nombre FROM marcas ORDER BY Nombre");

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $idMarca = intval($_POST['idMarca']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $fecha = $_POST['fecha'];
    $precio = floatval($_POST['precio']);
    $imagen = $conexion->real_escape_string($_POST['imagen']); // URL de la imagen
    $video = $conexion->real_escape_string($_POST['video']);   // URL del video

    $sql = "INSERT INTO autos (Nombre, idMarca, Descripcion, fecha, imagen, precio, video) 
            VALUES ('$nombre', $idMarca, '$descripcion', '$fecha', '$imagen', $precio, '$video')";

    if ($conexion->query($sql)) {
        header("Location: autos.php?msg=Auto+creado+correctamente");
        exit;
    } else {
        $error = "Error al crear auto: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Auto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2>Agregar Auto</h2>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required />
    </div>

    <div class="mb-3">
      <label for="idMarca" class="form-label">Marca</label>
      <select name="idMarca" id="idMarca" class="form-select" required>
        <option value="">Seleccione una marca</option>
        <?php while ($marca = $marcas->fetch_assoc()): ?>
          <option value="<?= $marca['idMarca'] ?>"><?= htmlspecialchars($marca['Nombre']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
    </div>

    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" name="fecha" id="fecha" class="form-control" required />
    </div>

    <div class="mb-3">
      <label for="precio" class="form-label">Precio</label>
      <input type="number" name="precio" id="precio" step="0.01" class="form-control" required />
    </div>

    <div class="mb-3">
      <label for="imagen" class="form-label">URL de la Imagen</label>
      <input type="url" name="imagen" id="imagen" class="form-control" placeholder="https://..." required />
    </div>

    <div class="mb-3">
      <label for="video" class="form-label">URL del Video</label>
      <input type="url" name="video" id="video" class="form-control" placeholder="https://..." />
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="autos.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
