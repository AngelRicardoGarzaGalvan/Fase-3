<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Catálogo de Autos - Agencia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .price {
      font-weight: 700;
      font-size: 1.25rem;
      color: #198754; /* verde bootstrap */
    }
    .marca {
      font-style: italic;
      color: #6c757d;
    }
  </style>
</head>
<body>
  <!-- Navbar idéntico -->
  <nav class="navbar navbar-expand-lg bg-light shadow-sm px-4">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="../index.html">Inicio</a>
      <!-- Aquí puedes poner los links del navbar que tenías antes -->
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
