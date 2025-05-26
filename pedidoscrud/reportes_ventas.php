<?php
include 'conexion.php';

// Meses en español
$meses_es = [
  1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
  5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
  9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

$añoSeleccionado = isset($_GET['año']) && is_numeric($_GET['año']) ? intval($_GET['año']) : date('Y');
$mesSeleccionado = isset($_GET['mes']) && is_numeric($_GET['mes']) ? intval($_GET['mes']) : 0;

$whereFecha = "";
if ($mesSeleccionado > 0) {
    $whereFecha = "WHERE YEAR(ped.fecha) = $añoSeleccionado AND MONTH(ped.fecha) = $mesSeleccionado";
} else {
    $whereFecha = "WHERE YEAR(ped.fecha) = $añoSeleccionado";
}

// Ventas por día
$sqlVentasPorDia = "
    SELECT DAY(ped.fecha) AS dia, COUNT(*) AS ventas
    FROM pedidos ped
    $whereFecha
    GROUP BY dia
    ORDER BY dia
";
$resultVentasDia = $conexion->query($sqlVentasPorDia);

// Ventas por plan
$sqlVentasPorPlan = "
    SELECT p.Nombre AS nombrePlan, COUNT(*) AS totalVentas
    FROM pedidos ped
    INNER JOIN planespago p ON ped.idPlan = p.idPlan
    $whereFecha
    GROUP BY ped.idPlan
";
$resultVentasPlan = $conexion->query($sqlVentasPorPlan);

// Ventas por auto
$sqlVentasPorAuto = "
    SELECT a.Nombre AS nombreAuto, COUNT(*) AS totalVentas
    FROM pedidos ped
    INNER JOIN autos a ON ped.idAuto = a.idAuto
    $whereFecha
    GROUP BY ped.idAuto
    ORDER BY totalVentas DESC
";
$resultVentasAuto = $conexion->query($sqlVentasPorAuto);

// Preparar datos para JS
$datosVentasDia = [];
$labelsDia = [];
while ($fila = $resultVentasDia->fetch_assoc()) {
    $labelsDia[] = $fila['dia'];
    $datosVentasDia[] = intval($fila['ventas']);
}

$datosVentasPlan = [];
$labelsPlan = [];
while ($fila = $resultVentasPlan->fetch_assoc()) {
    $labelsPlan[] = $fila['nombrePlan'];
    $datosVentasPlan[] = intval($fila['totalVentas']);
}

$datosVentasAuto = [];
$labelsAuto = [];
while ($fila = $resultVentasAuto->fetch_assoc()) {
    $labelsAuto[] = $fila['nombreAuto'];
    $datosVentasAuto[] = intval($fila['totalVentas']);
}

$anioActual = date('Y');
$anioInicio = 2020;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Reportes de Ventas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="reportes.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light shadow-sm px-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../admin.html">Volver al Inicio</a>
        </div>
    </nav>
<div class="container mt-5">
  <h2 class="mb-4">Reportes de Ventas</h2>

  <form method="get" class="row g-3 align-items-center mb-4">
    <div class="col-auto">
      <label for="año" class="col-form-label">Año:</label>
    </div>
    <div class="col-auto">
      <select name="año" id="año" class="form-select">
        <?php for ($y = $anioInicio; $y <= $anioActual; $y++): ?>
          <option value="<?= $y ?>" <?= ($añoSeleccionado == $y) ? 'selected' : '' ?>><?= $y ?></option>
        <?php endfor; ?>
      </select>
    </div>

    <div class="col-auto">
      <label for="mes" class="col-form-label">Mes:</label>
    </div>
    <div class="col-auto">
      <select name="mes" id="mes" class="form-select">
        <option value="0" <?= ($mesSeleccionado == 0) ? 'selected' : '' ?>>Todos</option>
        <?php foreach ($meses_es as $numMes => $nombreMes): ?>
          <option value="<?= $numMes ?>" <?= ($mesSeleccionado == $numMes) ? 'selected' : '' ?>>
            <?= $nombreMes ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Filtrar</button>
    </div>
  </form>

  <div class="row gy-4">
    <div class="col-md-6">
      <h5>Ventas por Día (<?= $mesSeleccionado > 0 ? $meses_es[$mesSeleccionado] : 'Todos los meses' ?> <?= $añoSeleccionado ?>)</h5>
      <canvas id="ventasDiaChart"></canvas>
    </div>

    <div class="col-md-6">
      <h5>Ventas por Plan (<?= $mesSeleccionado > 0 ? $meses_es[$mesSeleccionado] : 'Todos los meses' ?> <?= $añoSeleccionado ?>)</h5>
      <canvas id="ventasPlanChart"></canvas>
    </div>

    <div class="col-md-12">
      <h5>Ventas por Auto (<?= $mesSeleccionado > 0 ? $meses_es[$mesSeleccionado] : 'Todos los meses' ?> <?= $añoSeleccionado ?>)</h5>
      <canvas id="ventasAutoChart"></canvas>
    </div>
  </div>
</div>

<script>
  // Variables globales
  const ventasDiaLabels = <?= json_encode($labelsDia) ?>;
  const ventasDiaData = <?= json_encode($datosVentasDia) ?>;

  const ventasPlanLabels = <?= json_encode($labelsPlan) ?>;
  const ventasPlanData = <?= json_encode($datosVentasPlan) ?>;

  const ventasAutoLabels = <?= json_encode($labelsAuto) ?>;
  const ventasAutoData = <?= json_encode($datosVentasAuto) ?>;

  const mesTexto = <?= json_encode($mesSeleccionado > 0 ? $meses_es[$mesSeleccionado] : 'Todos los meses') ?>;
  const añoTexto = <?= json_encode($añoSeleccionado) ?>;
</script>

<script src="reportes.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
