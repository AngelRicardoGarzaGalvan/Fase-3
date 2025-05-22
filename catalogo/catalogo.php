<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Catálogo de Autos - Agencia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="catalogo.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-light shadow-sm px-4">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="..//index.html">Inicio</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="nav-link btn btn-primary text-white px-3 me-2 active" aria-current="page" href="../acerca/acerca.html">Acerca de Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-primary px-3 me-2" href="catalogo.php">Catálogo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-primary px-3" href="../acerca/contactanos.html">Contáctanos</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
          <i class="bi bi-person-circle fs-4 me-2"></i>
          <span>Usuario</span>
        </div>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <h1 class="mb-4 text-center">Catálogo de Autos</h1>
    <div class="row g-4">
      <?php
      $consulta = "SELECT autos.*, marcas.Nombre AS nombreMarca FROM autos JOIN marcas ON autos.idMarca = marcas.idMarca";
      $resultado = $conexion->query($consulta);

      while($auto = $resultado->fetch_assoc()):
      ?>
      <div class="col-md-4">
        <div class="card h-100">
          <img src="<?php echo htmlspecialchars($auto['imagen']); ?>" class="card-img-top" alt="Imagen del auto <?php echo htmlspecialchars($auto['Nombre']); ?>" style="height: 220px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($auto['Nombre']); ?></h5>
            <p class="marca mb-2">Marca: <?php echo htmlspecialchars($auto['nombreMarca']); ?></p>
            <p class="price mb-4">$<?php echo number_format($auto['precio'], 2, '.', ','); ?></p>
            <a href="detalle.php?id=<?php echo $auto['idAuto']; ?>" class="btn btn-success mt-auto">Ver más</a>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
