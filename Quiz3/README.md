# Quiz 3: Matrícula de estudiantes con Laravel (MVC)

- **CRUD de cursos**: nombre, código, cantidad de créditos y carrera (las carreras vienen de un seed).
- **Formulario de matrícula** (página principal): lista de cursos cargada con un seed; el estudiante elige uno, presiona **Matricular**, se guarda y se muestran los datos del registro.

## ¿Dónde está el MVC?

| Capa | Archivo | Qué hace |
|---|---|---|
| **Modelo** | `app/Models/Carrera.php`, `Curso.php`, `Matricula.php` | Tablas y relaciones (Eloquent) |
| **Vista** | `resources/views/cursos/*`, `resources/views/matriculas/*` | Pantallas Blade |
| **Controlador** | `app/Http/Controllers/CursoController.php`, `MatriculaController.php` | Reciben la petición, usan el modelo y devuelven la vista |
| Rutas | `routes/web.php` | URL → método del controlador |
| Migraciones | `database/migrations/2026_11_24_*` | Crean las tablas `carreras`, `cursos`, `matriculas` |
| Seeders | `database/seeders/CarreraSeeder.php`, `CursoSeeder.php` | Datos fijos de carreras y cursos |

Relaciones: **Carrera 1 → N Curso 1 → N Matrícula**

Flujo de la matrícula: `GET /` (formulario) → `POST /matriculas` (guarda) → `GET /matriculas/{id}` (muestra el registro)

## Cómo correrlo (XAMPP + MySQL)

1. Encender Apache y MySQL en XAMPP.
2. En phpMyAdmin crear la base de datos `quiz3_matricula`.
3. En la carpeta `Quiz3`:
   ```bash
   composer install
   copy .env.example .env      # solo si no existe el .env
   php artisan key:generate    # solo si se copió el .env.example
   php artisan migrate --seed
   ```
   En el `.env`: `DB_CONNECTION=mysql`, `DB_DATABASE=quiz3_matricula`, `DB_USERNAME=root`, `DB_PASSWORD=`.
4. Abrir **http://workshop3.local** (vhost que apunta a `Quiz3/public`), o correr `php artisan serve` y abrir http://127.0.0.1:8000.

Para empezar de cero: `php artisan migrate:fresh --seed`

## Rutas

| Método | URL | Acción |
|---|---|---|
| GET | / | Formulario de matrícula |
| POST | /matriculas | Guardar matrícula |
| GET | /matriculas | Lista de matrículas |
| GET | /matriculas/{id} | Datos del registro |
| GET/POST/PUT/DELETE | /cursos... | CRUD de cursos (`Route::resource`) |

Para verlas todas: `php artisan route:list`
