<?php
session_start();
require "conexion.php";

// sin sesión no se entra
if (!isset($_SESSION["usuario_id"])) {
  $_SESSION["error"] = "Debes iniciar sesión para entrar al perfil";
  header("Location: index.php");
  exit;
}

$id = $_SESSION["usuario_id"];
$mensaje = "";
$tipo = "danger";

// Actualizar datos  si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST["username"]);
  $provincia_id = (int) $_POST["provincia"];
  $password = $_POST["password"];  

  if ($username == "" || $provincia_id == 0) {
    $mensaje = "El username y la provincia son obligatorios";
  } elseif ($password != "" && strlen($password) < 6) {
    $mensaje = "La nueva contraseña debe tener al menos 6 caracteres";
  } else {

    // ¿Otro usuario ya tiene ese username? (id != ? excluye al usuario actual)
    $consulta = $conexion->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    $consulta->bind_param("si", $username, $id);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
      $mensaje = "Ese nombre de usuario ya está en uso";
    } else {

      if ($password != "") {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $actualizar = $conexion->prepare("UPDATE users SET username = ?, provincia_id = ?, password = ? WHERE id = ?");
        $actualizar->bind_param("sisi", $username, $provincia_id, $hash, $id);
      } else {
        // Dejó la contraseña vacía se mantiene la actual
        $actualizar = $conexion->prepare("UPDATE users SET username = ?, provincia_id = ? WHERE id = ?");
        $actualizar->bind_param("sii", $username, $provincia_id, $id);
      }
      $actualizar->execute();

      // Actualizamos también el nombre guardado en la sesión
      $_SESSION["username"] = $username;

      $mensaje = "Datos actualizados correctamente";
      $tipo = "success";
    }
  }
}

// Cargar datos de Usuario
$consulta = $conexion->prepare(
  "SELECT u.username, u.provincia_id, p.nombre AS provincia
   FROM users u
   LEFT JOIN provincias p ON u.provincia_id = p.id
   WHERE u.id = ?"
);
$consulta->bind_param("i", $id);
$consulta->execute();
$resultado = $consulta->get_result();

// Si el usuario ya no existe en la base de datos, cerramos la sesión
if ($resultado->num_rows == 0) {
  session_destroy();
  header("Location: index.php");
  exit;
}

$usuario = $resultado->fetch_assoc();

// Provincias para el dropdown
$provincias = $conexion->query("SELECT id, nombre FROM provincias ORDER BY nombre");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
  <div class="container mt-5">
    <h2 class="text-center">Bienvenido, <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
    <div class="row justify-content-center mt-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Mi perfil</h4>
          </div>
          <div class="card-body">
            <?php if ($mensaje != "") { ?>
              <div class="alert alert-<?php echo $tipo; ?>"><?php echo $mensaje; ?></div>
            <?php } ?>
            <form action="perfil.php" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                  value="<?php echo htmlspecialchars($usuario["username"]); ?>" required>
              </div>
              <div class="form-group">
                <label for="provincia">Provincia</label>
                <select class="form-control" id="provincia" name="provincia" required>
                  <?php while ($p = $provincias->fetch_assoc()) { ?>
                    <option value="<?php echo $p["id"]; ?>"
                      <?php if ($p["id"] == $usuario["provincia_id"]) { echo "selected"; } ?>>
                      <?php echo $p["nombre"]; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="password">Nueva contraseña</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Guardar</button>
            </form>
            <p class="text-center mt-3"><a href="logout.php">Cerrar sesión</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>