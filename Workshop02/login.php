<?php
session_start();
require "conexion.php";

// Datos que envió el formulario del index.php
$username = $_POST["username"];
$password = $_POST["password"];

// Buscar el usuario
$consulta = $conexion->prepare("SELECT id, password FROM users WHERE username = ?");
$consulta->bind_param("s", $username);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows == 1) {
  $fila = $resultado->fetch_assoc();

  if (password_verify($password, $fila["password"])) {
    // Login correcto, se cmbia el id de la sesión por seguridad
    session_regenerate_id(true);

    // Guardamos en la sesión quién es el usuario
    $_SESSION["usuario_id"] = $fila["id"];
    $_SESSION["username"] = $username;

    header("Location: perfil.php");
    exit;
  }
}

// Usuario no existe o contraseña incorrecta
$_SESSION["error"] = "Credenciales inválidas";
header("Location: index.php");
exit;