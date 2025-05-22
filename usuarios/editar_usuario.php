<?php
include 'conexion.php';

$id = $_GET['id'];
$usuario = $conexion->query("SELECT * FROM usuario WHERE idUsuario = $id")->fetch_assoc();
$roles = $conexion->query("SELECT * FROM rol");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = $_POST["nombre"];
  $correo = $_POST["correo"];
  $telefono = $_POST["telefono"];
  $idRol = $_POST["idRol"];

  $conexion->query("UPDATE usuario SET Nombre='$nombre', Correo='$correo', Telefono='$telefono', idRol=$idRol WHERE idUsuario=$id");
  header("Location: usuarios.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Editar Usuario</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Nombre</label>
      <input type="text" name="nombre" value="<?= $usuario['Nombre'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Correo</label>
      <input type="email" name="correo" value="<?= $usuario['Correo'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Teléfono</label>
      <input type="text" name="telefono" value="<?= $usuario['Telefono'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Rol</label>
      <select name="idRol" class="form-select" required>
        <?php while($rol = $roles->fetch_assoc()): ?>
          <option value="<?= $rol['idRol'] ?>" <?= $usuario['idRol'] == $rol['idRol'] ? 'selected' : '' ?>>
            <?= $rol['Nombre'] ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
