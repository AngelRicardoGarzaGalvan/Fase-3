<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['idUsuario'])) {
    die("Debe iniciar sesión para ver su historial de pedidos.");
}

$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT p.*, a.Nombre AS nombreAuto, m.Nombre AS marcaAuto, pl.nombre AS nombrePlan
        FROM pedidos p
        JOIN autos a ON p.idAuto = a.idAuto
        JOIN marcas m ON a.idMarca = m.idMarca
        JOIN planespago pl ON p.idPlan = pl.idPlan
        WHERE p.idUsuario = $idUsuario
        ORDER BY p.fecha DESC";

$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light shadow-sm px-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../catalogo/catalogo.php">Volver al Catálogo</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Historial de Pedidos</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Auto</th>
                            <th>Marca</th>
                            <th>Plan de Pago</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Opinión</th>
                            <th>Fecha</th>
                            <th>Acciones</th> <!-- Nueva columna -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pedido = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pedido['nombreAuto']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['marcaAuto']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['nombrePlan']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['Telefono']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['Correo']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['Opinion']); ?></td>
                                <td><?php echo date("d/m/Y H:i", strtotime($pedido['fecha'])); ?></td>
                                <td class="text-center">
                                    <form action="cancelar_pedido.php" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar este pedido?');">
                                        <input type="hidden" name="idPedido" value="<?php echo $pedido['idPedido']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">No has realizado ningún pedido todavía.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
