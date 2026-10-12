<?php
$servidor = "localhost";
$usuario_db = "root";
$clave_db = "";
$base_datos = "workshop2";

$conexion = new mysqli($servidor, $usuario_db, $clave_db, $base_datos);

if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// Ver bien las tildes y la ñ
$conexion->set_charset("utf8mb4");