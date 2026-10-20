# Workshop 3: Módulo de Cursos

Aplicación web en PHP y MySQL construida sobre el proyecto base de la week4 del curso ISW-613. Agrega un menú de navegación y una sección de **Cursos** con las cuatro operaciones CRUD

## Qué hace

- **Menú de navegación** para ir al inicio, al perfil, a Cursos o cerrar sesión.
- **Listado de cursos** en una tabla con Nombre, Código de Curso, Id de la Carrera, Créditos y Descripción.
- **Crear Curso:** formulario para registrar un curso nuevo. Al guardarlo, vuelve al listado.
- **Editar:** cada curso tiene un botón que abre el formulario con sus datos para modificarlos.
- **Eliminar:** cada curso tiene un botón que lo borra mediante una petición **POST**, con confirmación previa.
- **Acceso protegido:** todas las pantallas y acciones de cursos exigen una sesión de usuario activa.
- **Validaciones:** campos obligatorios, créditos entre 1 y 20, carrera existente y código de curso único.

## Distribución de los archivos

### Archivos nuevos de este workshop

| Carpeta | Archivo | Función |
|---|---|---|
| raíz | `courses_schema.sql` | Crea las tablas `careers` y `courses`, con datos de ejemplo. |
| `pages/` | `courses.php` | Tabla con todos los cursos y los botones Crear, Editar y Eliminar. |
| `pages/` | `course_form.php` | Formulario único para crear o editar un curso. |
| `pages/common/` | `nav.php` | Menú de navegación compartido por las páginas con sesión. |
| `actions/` | `create_course.php` | Valida y guarda un curso nuevo. |
| `actions/` | `update_course.php` | Valida y guarda los cambios de un curso. |
| `actions/` | `delete_course.php` | Elimina un curso (solo acepta POST). |
| `utils/` | `courses.php` | Funciones para listar, buscar, crear, actualizar y eliminar cursos, y validar el formulario. |
| `utils/` | `careers.php` | Funciones para listar y buscar carreras. |

### Archivos del proyecto base que se modificaron

| Archivo | Cambio |
|---|---|
| `utils/messages.php` | Se agregaron los mensajes de éxito y error de cursos. |
| `pages/dashboard.php` | Se agregó el menú de navegación y un botón a Cursos. |
| `pages/profile.php` | Se agregó el menú de navegación. |
| `utils/database.php` | La contraseña de MySQL quedó vacía para que funcione con XAMPP. |

