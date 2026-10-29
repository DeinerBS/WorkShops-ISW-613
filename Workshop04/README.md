# Workshop 4: Patrón MVC

Refactorización del Workshop 3 para separar el código siguiendo el patrón **MVC (Modelo, Vista, Controlador)**. La aplicación sigue haciendo lo mismo: login, registro, perfil con foto, lista de usuarios y módulo de Cursos (crear, listar, editar y eliminar). Lo que cambia es cómo está organizado el código.

## El patrón MVC en este proyecto

| Rol | Responsabilidad | Carpeta |
|---|---|---|
| **Modelo** | Habla con la base de datos. Una clase por tabla. No tiene HTML. | `models/` |
| **Vista** | Solo muestra HTML con los datos recibidos. No consulta la base de datos. | `views/` |
| **Controlador** | Recibe la petición, valida, usa los modelos y elige la vista o la redirección. | `controllers/` |

El archivo `index.php` es el **punto de entrada**: recibe todas las peticiones, lee el parámetro `route` de la URL y ejecuta el método del controlador que corresponde según una tabla de rutas.

### Cómo viaja una petición

Ejemplo: `index.php?route=courses/edit&id=3`

1. `index.php` busca `courses/edit` en la tabla de rutas y encuentra `CourseController::edit()`.
2. Comprueba que la petición use el método HTTP permitido (GET para editar).
3. `CourseController` verifica la sesión, y le pide el curso al modelo `Course`.
4. El controlador pasa el curso y las carreras (del modelo `Career`) a la vista `views/courses/form.php`.
5. La vista dibuja el formulario dentro del layout (cabecera, menú y pie).

## Estructura de carpetas

```
Workshop04/
├── index.php                  Punto de entrada y tabla de rutas
├── config/
│   └── database.php           Conexión PDO a la base de datos
├── core/
│   ├── Controller.php         Clase base de los controladores (render)
│   ├── auth.php               Manejo de sesión (login, logout, requireLogin)
│   ├── helpers.php            Funciones auxiliares: e(), url(), redirect()
│   ├── messages.php           Mensajes de éxito y error
│   └── profile_pictures.php   Validación y almacenamiento de fotos de perfil
├── models/
│   ├── User.php               Tabla users
│   ├── Province.php           Tabla provinces
│   ├── Career.php             Tabla careers
│   └── Course.php             Tabla courses
├── controllers/
│   ├── AuthController.php     Login, registro y logout
│   ├── DashboardController.php
│   ├── ProfileController.php  Perfil y actualización de datos y foto
│   ├── UserController.php     Lista de usuarios
│   └── CourseController.php   CRUD de cursos
├── views/
│   ├── layouts/               header.php, nav.php, footer.php
│   ├── auth/                  login.php, register.php
│   ├── profile/               show.php
│   ├── users/                 index.php
│   ├── courses/               index.php, form.php
│   └── dashboard.php
├── uploads/profile_pictures/  Fotos de perfil subidas
├── auth_schema.sql
├── provinces_schema.sql
├── profile_picture_schema.sql
└── courses_schema.sql
```

## Rutas

| Ruta | Método | Controlador::método | Función |
|---|---|---|---|
| `auth/login` | GET | `AuthController::loginForm` | Muestra el login |
| `auth/authenticate` | POST | `AuthController::login` | Inicia sesión |
| `auth/register` | GET | `AuthController::registerForm` | Muestra el registro |
| `auth/store` | POST | `AuthController::register` | Crea el usuario |
| `auth/logout` | POST | `AuthController::logout` | Cierra la sesión |
| `dashboard` | GET | `DashboardController::index` | Pantalla de inicio |
| `profile` | GET | `ProfileController::show` | Muestra el perfil |
| `profile/update` | POST | `ProfileController::update` | Actualiza el perfil |
| `users` | GET | `UserController::index` | Lista de usuarios |
| `courses` | GET | `CourseController::index` | Lista de cursos |
| `courses/create` | GET | `CourseController::create` | Formulario de curso nuevo |
| `courses/store` | POST | `CourseController::store` | Guarda el curso nuevo |
| `courses/edit` | GET | `CourseController::edit` | Formulario de edición |
| `courses/update` | POST | `CourseController::update` | Guarda los cambios |
| `courses/delete` | POST | `CourseController::delete` | Elimina el curso |

Las rutas que modifican datos solo aceptan POST; el `index.php` rechaza cualquier otro método.

## De dónde viene cada pieza (Workshop 3 → Workshop 4)

| Workshop 3 | Workshop 4 |
|---|---|
| `utils/users.php`, `provinces.php`, `careers.php`, `courses.php` | `models/` (una clase por tabla) |
| `actions/*.php` | Métodos de los controladores |
| `pages/*.php`, `users.php` | `views/` |
| `pages/common/`, `inc/` | `views/layouts/` |
| `utils/auth.php`, `messages.php`, `profile_pictures.php` | `core/` |
| `utils/database.php` | `config/database.php` |

## Base de datos

Base: `iswapp` (sin cambios respecto al Workshop 3). Los scripts no crean la base: hay que crearla e importar, en este orden:

1. `auth_schema.sql`
2. `provinces_schema.sql`
3. `profile_picture_schema.sql`
4. `courses_schema.sql`

## Cómo ejecutarlo

1. Iniciar **Apache** y **MySQL** en XAMPP.
2. Crear la base `iswapp` en phpMyAdmin e importar los scripts en orden.
3. Revisar `config/database.php` (usuario `root`, contraseña vacía en XAMPP).
4. Servir la carpeta con un **virtual host** cuyo `DocumentRoot` sea `Workshop04`, porque el proyecto usa rutas absolutas.
5. Abrir el sitio, crear un usuario con **Sign up** e iniciar sesión.


