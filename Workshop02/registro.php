<?php
require "conexion.php";

$mensaje = "";
$tipo = "danger"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // 1. Recibir los datos del formulario
  $username = trim($_POST["username"]);
  $password = $_POST["password"];
  $confirmar = $_POST["confirmar"];
  $provincia_id = (int) $_POST["provincia"];

  // 2. Validaciones básicas
  if ($username == "" || $password == "" || $provincia_id == 0) {
    $mensaje = "Todos los campos son obligatorios";
  } elseif ($password != $confirmar) {
    $mensaje = "Las contraseñas no coinciden";
  } elseif (strlen($password) < 6) {
    $mensaje = "La contraseña debe tener al menos 6 caracteres";
  } else {

    // 3. Revisar si el username ya existe
    $consulta = $conexion->prepare("SELECT id FROM users WHERE username = ?");
    $consulta->bind_param("s", $username);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
      $mensaje = "Ese nombre de usuario ya existe";
    } else {

      // 4. Encriptar la contraseña y guardar el usuario con su provincia
      $hash = password_hash($password, PASSWORD_DEFAULT);

      $insertar = $conexion->prepare("INSERT INTO users (username, password, provincia_id) VALUES (?, ?, ?)");
      $insertar->bind_param("ssi", $username, $hash, $provincia_id);
      $insertar->execute();

      $mensaje = "Usuario creado correctamente. Ya puedes iniciar sesión.";
      $tipo = "success";
    }
  }
}

// Traer las provincias para llenar el dropdown
$provincias = $conexion->query("SELECT id, nombre FROM provincias ORDER BY nombre");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Registro de usuarios</h4>
          </div>
          <div class="card-body">
            <?php if ($mensaje != "") { ?>
              <div class="alert alert-<?php echo $tipo; ?>"><?php echo $mensaje; ?></div>
            <?php } ?>
            <form action="registro.php" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="form-group">
                <label for="confirmar">Confirmar password</label>
                <input type="password" class="form-control" id="confirmar" name="confirmar" required>
              </div>
              <div class="form-group">
                <label for="provincia">Provincia</label>
                <select class="form-control" id="provincia" name="provincia" required>
                  <option value="">-- Seleccione una provincia --</option>
                  <?php while ($p = $provincias->fetch_assoc()) { ?>
                    <option value="<?php echo $p["id"]; ?>"><?php echo $p["nombre"]; ?></option>
                  <?php } ?>
                </select>
              </div>
              <button type="submit" class="btn btn-success btn-block">Registrarse</button>
            </form>
            <p class="text-center mt-3"><a href="index.php">Volver al login</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>