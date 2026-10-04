<?php
session_start();

// conexion a la base de datos
$servidor = "localhost";
$usuario_db = "root";
$clave_db = "";
$base_datos = "workshop1";

// Conectarnos a la base de datos
$conexion = new mysqli($servidor, $usuario_db, $clave_db, $base_datos);

if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// Recibir los datos que envió el formulario del index.php
$username = $_POST["username"];
$password = $_POST["password"];

// Buscar el usuario con ese username
$sql = "SELECT password FROM users WHERE username = ?";
$consulta = $conexion->prepare($sql);
$consulta->bind_param("s", $username);
$consulta->execute();
$resultado = $consulta->get_result();

// Ver el resultado
if ($resultado->num_rows == 1) {
  // El usuario existe, ahora revisamos la contraseña
  $fila = $resultado->fetch_assoc();

  if (password_verify($password, $fila["password"])) {
    // Contraseña correcta
    header("Location: usuario_existe.php");
    exit;
  }
}

// el usuario no existe o la contraseña está mal
$_SESSION["error"] = "Credenciales Inválidas";
header("Location: index.php");
exit;