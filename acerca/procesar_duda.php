<?php
// Conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agencia_autos";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos POST
$nombre = trim($_POST['nombre'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$mensaje = trim($_POST['descripcion'] ?? '');

// Validar campos
if (empty($nombre) || empty($telefono) || empty($correo) || empty($mensaje)) {
    die("Por favor llena todos los campos.");
}

// Buscar idUsuario
$idUsuario = NULL;
$sql = "SELECT idUsuario FROM usuario WHERE Correo = ?";
$stmtSelect = $conn->prepare($sql);
$stmtSelect->bind_param("s", $correo);
$stmtSelect->execute();
$stmtSelect->bind_result($idEncontrado);

if ($stmtSelect->fetch()) {
    $idUsuario = $idEncontrado;
}
$stmtSelect->close();

// Insertar
$stmt = $conn->prepare("INSERT INTO dudas (idUsuario, Nombre, Telefono, Correo, Descripcion) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $idUsuario, $nombre, $telefono, $correo, $mensaje);

// Ejecutar y verificar
if ($stmt->execute()) {
    echo "Gracias por enviar tu duda. Nos contactaremos contigo pronto.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
