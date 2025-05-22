<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = $_POST["nombre"];
  $correo = $_POST["correo"];
  $telefono = $_POST["telefono"];
  $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT);
  $idRol = $_POST["idRol"];
  $fecha = date("Y-m-d");

  $stmt = $conexion->prepare("INSERT INTO usuario (Nombre, Correo, Telefono, Contraseña, idRol, fecha) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssis", $nombre, $correo, $telefono, $contrasena, $idRol, $fecha);
  $stmt->execute();

  header("Location: usuarios.php");
  exit();
}

$roles = $conexion->query("SELECT * FROM rol");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Crear Usuario</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Correo</label>
      <input type="email" name="correo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Teléfono</label>
      <input type="text" name="telefono" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Contraseña</label>
      <input type="password" name="contrasena" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Rol</label>
      <select name="idRol" class="form-select" required>
        <option value="">Seleccione un rol</option>
        <?php while($rol = $roles->fetch_assoc()): ?>
          <option value="<?= $rol['idRol'] ?>"><?= $rol['Nombre'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>
</body>
</html>
