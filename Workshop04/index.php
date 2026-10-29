<?php
// Recibe todas las peticiones y decide qué controlador ejecutar

require_once __DIR__ . '/config/database.php';   // crea la conexión $conn
require_once __DIR__ . '/core/helpers.php';
require_once __DIR__ . '/core/auth.php';
require_once __DIR__ . '/core/messages.php';
require_once __DIR__ . '/core/Controller.php';

startSession();

// Tabla de rutas 'ruta' => [Controlador, método, método HTTP permitido]
$routes = [
    'auth/login'        => ['AuthController', 'loginForm', 'GET'],
    'auth/authenticate' => ['AuthController', 'login', 'POST'],
    'auth/register'     => ['AuthController', 'registerForm', 'GET'],
    'auth/store'        => ['AuthController', 'register', 'POST'],
    'auth/logout'       => ['AuthController', 'logout', 'POST'],

    'dashboard'         => ['DashboardController', 'index', 'GET'],

    'profile'           => ['ProfileController', 'show', 'GET'],
    'profile/update'    => ['ProfileController', 'update', 'POST'],

    'users'             => ['UserController', 'index', 'GET'],

    'courses'           => ['CourseController', 'index', 'GET'],
    'courses/create'    => ['CourseController', 'create', 'GET'],
    'courses/store'     => ['CourseController', 'store', 'POST'],
    'courses/edit'      => ['CourseController', 'edit', 'GET'],
    'courses/update'    => ['CourseController', 'update', 'POST'],
    'courses/delete'    => ['CourseController', 'delete', 'POST'],
];

// Si no viene ?route=..., se muestra el login
$route = $_GET['route'] ?? 'auth/login';

if (!is_string($route) || !isset($routes[$route])) {
    http_response_code(404);
    exit('Página no encontrada');
}

$controllerName = $routes[$route][0];
$method = $routes[$route][1];
$httpMethod = $routes[$route][2];

// Cada ruta solo acepta su método HTTP 
if ($_SERVER['REQUEST_METHOD'] !== $httpMethod) {
    http_response_code(405);
    exit('Método no permitido');
}

$file = __DIR__ . '/controllers/' . $controllerName . '.php';

if (!is_file($file)) {
    http_response_code(404);
    exit('Controlador no encontrado');
}

require_once $file;

$controller = new $controllerName($conn);
$controller->$method();