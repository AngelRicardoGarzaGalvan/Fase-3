<?php
session_start();
include("conexion.php");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de auto no especificado.");
}

$idAuto = intval($_GET['id']);

// Cargar auto y marca
$sql = "SELECT autos.*, marcas.Nombre AS nombreMarca FROM autos 
        JOIN marcas ON autos.idMarca = marcas.idMarca 
        WHERE autos.idAuto = $idAuto";
$result = $conexion->query($sql);
if ($result->num_rows == 0) die("Auto no encontrado.");
$auto = $result->fetch_assoc();

// Cargar planes
$planes = $conexion->query("SELECT * FROM planespago");

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedir_auto'])) {
    if (!isset($_SESSION['idUsuario'])) die("Debe iniciar sesión.");

    $idUsuario = $_SESSION['idUsuario'];
    $idPlan = intval($_POST['plan_pago']);
    $telefono = $conexion->real_escape_string($_POST['telefono']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $opinion = $conexion->real_escape_string($_POST['opinion']);
    $fecha = date('Y-m-d H:i:s');

    $insert = "INSERT INTO pedidos (idUsuario, idAuto, idPlan, Telefono, Correo, Opinion, fecha)
               VALUES ($idUsuario, $idAuto, $idPlan, '$telefono', '$correo', '$opinion', '$fecha')";

    if ($conexion->query($insert)) {
        header("Location: ../pedidos/historialpedidos.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error al guardar pedido: " . $conexion->error . "</div>";
    }
}

function mostrarVideo($url) {
    if (!$url) return "<p>No hay video disponible.</p>";
    if (preg_match('/youtu\.be\/([^\?&]+)/', $url, $m) || preg_match('/youtube\.com.*v=([^&]+)/', $url, $m)) {
        return "<iframe width='100%' height='400' src='https://www.youtube.com/embed/{$m[1]}' frameborder='0' allowfullscreen></iframe>";
    }
    if (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
        return "<iframe src='https://player.vimeo.com/video/{$m[1]}' width='100%' height='400' frameborder='0' allowfullscreen></iframe>";
    }
    $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
    if (in_array($ext, ['mp4', 'webm', 'ogg'])) {
        return "<video width='100%' height='400' controls><source src='$url' type='video/$ext'></video>";
    }
    return "<p>Formato de video no reconocido.</p>";
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
        <a class="navbar-brand fw-bold" href="catalogo.php">Inicio</a>
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

                <!-- Botón para mostrar el formulario -->
                <button class="btn btn-primary mt-3" data-bs-toggle="collapse" data-bs-target="#formularioPedir">Pedir este auto</button>
            </div>
        </div>
    </div>

    <div class="card mt-5 shadow-sm p-3">
        <h3 class="mb-3">Video del Auto</h3>
        <?php echo mostrarVideo($auto['video']); ?>
    </div>

    <!-- Formulario de pedido -->
    <div class="collapse mt-4" id="formularioPedir">
        <div class="card card-body shadow-sm">
            <h4>Formulario de Pedido</h4>
            <form method="POST">
                <input type="hidden" name="pedir_auto" value="1">
                <div class="mb-3">
                    <label>Nombre del Vehículo</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($auto['Nombre']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Marca</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($auto['nombreMarca']); ?>" readonly>
                </div>
                <div class="mb-3">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Correo</label>
                    <input type="email" name="correo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Plan de Pago</label>
                    <select name="plan_pago" class="form-select" required>
                        <option value="">Seleccione un plan</option>
                        <?php while ($plan = $planes->fetch_assoc()): ?>
                            <option value="<?php echo $plan['idPlan']; ?>"><?php echo htmlspecialchars($plan['Nombre']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Opinión</label>
                    <textarea name="opinion" class="form-control" rows="3" placeholder="¿Qué te gustó del auto?"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Pedir</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
