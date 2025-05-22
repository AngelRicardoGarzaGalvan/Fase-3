<?php
session_start();
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST['Nombre']);
    $telefono = $conexion->real_escape_string($_POST['Telefono']);
    $correo = $conexion->real_escape_string($_POST['Correo']);
    $contrasena = $_POST['Contrasena'];

    // Hashear contraseña para seguridad
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Asignar rol "Usuario" (idRol=2)
    $idRol = 2;

    $sql = "INSERT INTO usuario (Nombre, Correo, Telefono, Contraseña, idRol, fecha) VALUES (?, ?, ?, ?, ?, CURDATE())";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $correo, $telefono, $contrasena_hash, $idRol);

    if ($stmt->execute()) {
        // Registro exitoso → redirigir a login
        header("Location: iniciar_sesion.php");
        exit();
    } else {
        $error = "Error al registrar usuario: " . $conexion->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registro - ABJA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="registrar.css" />
</head>
<body>
  <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-center min-vh-100">
    <!-- Bienvenida -->
    <div class="welcome-section text-center text-lg-start me-lg-5">
      <h1>¡Bienvenido a ABJA!</h1>
      <p>El lugar en donde encontrarás una gran variedad de vehículos que se ajusten a tu estilo de vida.</p>
      <img src="../img/logo_abja.jpg" alt="Logo de ABJA" class="img-fluid" />
    </div>

    <!-- Formulario de registro -->
    <div class="card p-4 shadow-lg" style="min-width: 320px; max-width: 400px;">
      <h2 class="text-center mb-4">Regístrate</h2>

      <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <form action="" method="POST">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input
            type="text"
            class="form-control"
            id="nombre"
            name="Nombre"
            placeholder="Nombre completo"
            required
            value="<?php echo isset($_POST['Nombre']) ? htmlspecialchars($_POST['Nombre']) : ''; ?>"
          />
        </div>
        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input
            type="tel"
            class="form-control"
            id="telefono"
            name="Telefono"
            placeholder="Número de teléfono"
            required
            value="<?php echo isset($_POST['Telefono']) ? htmlspecialchars($_POST['Telefono']) : ''; ?>"
          />
        </div>
        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input
            type="email"
            class="form-control"
            id="correo"
            name="Correo"
            placeholder="Correo electrónico"
            required
            value="<?php echo isset($_POST['Correo']) ? htmlspecialchars($_POST['Correo']) : ''; ?>"
          />
        </div>
        <div class="mb-3">
          <label for="contrasena" class="form-label">Contraseña</label>
          <input
            type="password"
            class="form-control"
            id="contrasena"
            name="Contrasena"
            placeholder="Contraseña"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
      </form>
      <div class="text-center mt-3">
        <a href="iniciar_sesion.php" class="login-link">¿Ya tienes cuenta? Inicia sesión</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
