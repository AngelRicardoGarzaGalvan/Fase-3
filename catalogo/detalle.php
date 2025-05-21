<?php
include("conexion.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de auto no especificado.");
}

$idAuto = intval($_GET['id']);

$sql = "SELECT autos.*, marcas.Nombre AS nombreMarca FROM autos JOIN marcas ON autos.idMarca = marcas.idMarca WHERE autos.idAuto = $idAuto";
$result = $conexion->query($sql);

if ($result->num_rows == 0) {
    die("Auto no encontrado.");
}

$auto = $result->fetch_assoc();

function mostrarVideo($url) {
    if (!$url) return "<p>No hay video disponible.</p>";

    if (preg_match('/youtu\.be\/([^\?&]+)/', $url, $matches)) {
        $id = $matches[1];
        return "<iframe width='100%' height='400' src='https://www.youtube.com/embed/$id' frameborder='0' allowfullscreen></iframe>";
    }
    if (preg_match('/youtube\.com.*v=([^&]+)/', $url, $matches)) {
        $id = $matches[1];
        return "<iframe width='100%' height='400' src='https://www.youtube.com/embed/$id' frameborder='0' allowfullscreen></iframe>";
    }

    if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
        $id = $matches[1];
        return "<iframe src='https://player.vimeo.com/video/$id' width='100%' height='400' frameborder='0' allowfullscreen></iframe>";
    }

    $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
    if (in_array($ext, ['mp4', 'webm', 'ogg'])) {
        return "<video width='100%' height='400' controls><source src='$url' type='video/$ext'>Tu navegador no soporta video HTML5.</video>";
    }

    return "<p>Formato de video no reconocido o no soportado para mostrar.</p>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Detalle del Auto - <?php echo htmlspecialchars($auto['Nombre']); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-light shadow-sm px-4">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="http://localhost/Fase-3/catalogo/catalogo.php">Inicio</a>
    </div>
  </nav>

  <div class="container mt-5">
    <h1 class="mb-4"><?php echo htmlspecialchars($auto['Nombre']); ?></h1>
    <div class="row">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" alt="Imagen del auto" class="card-img-top" style="height: 350px; object-fit: cover;">
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm p-4">
          <h4>Marca: <span class="text-primary"><?php echo htmlspecialchars($auto['nombreMarca']); ?></span></h4>
          <h4>Precio: <span class="text-success">$<?php echo number_format($auto['precio'], 2); ?></span></h4>
          <h5>Fecha:</h5>
          <p><?php echo htmlspecialchars($auto['fecha']); ?></p>
          <h5>Descripción:</h5>
          <p><?php echo nl2br(htmlspecialchars($auto['Descripcion'])); ?></p>
        </div>
      </div>
    </div>

    <div class="card mt-5 shadow-sm p-3">
      <h3 class="mb-3">Video del Auto</h3>
      <?php echo mostrarVideo($auto['video']); ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
