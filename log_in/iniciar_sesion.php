<?php
session_start();
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $conexion->real_escape_string($_POST['Correo']);
    $contrasena = $_POST['Contrasena'];

    $sql = "SELECT idUsuario, Nombre, Contraseña, idRol FROM usuario WHERE Correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contrasena, $usuario['Contraseña'])) {
            // Guardar datos en sesión
            $_SESSION['idUsuario'] = $usuario['idUsuario'];
            $_SESSION['Nombre'] = $usuario['Nombre'];
            $_SESSION['idRol'] = $usuario['idRol'];

            // Redirigir según rol
            if ($usuario['idRol'] == 1) {
                header("Location: .//admin.html");
            } else {
                header("Location: ../index.html");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Correo no encontrado.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Iniciar Sesión - ABJA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="iniciar_sesion.css" />
</head>
<body>
  <div class="container d-flex flex-column flex-lg-row align-items-center justify-content-center min-vh-100">
    <!-- Bienvenida -->
    <div class="welcome-section text-center text-lg-start me-lg-5">
      <h1>¡Bienvenido a ABJA!</h1>
      <p>El lugar en donde encontrarás una gran variedad de vehículos que se ajusten a tu estilo de vida.</p>
      <img src="../img/logo_abja.jpg" alt="Logo de ABJA" class="img-fluid" />
    </div>

    <!-- Formulario de inicio de sesión -->
    <div class="card p-4 shadow-lg" style="min-width: 320px; max-width: 400px;">
      <h2 class="text-center mb-4">Iniciar Sesión</h2>

      <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <form action="" method="POST">
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
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>

      <div class="text-center mt-3">
        <a href="registrar.php" class="register-link">¿No tienes cuenta? Regístrate</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
