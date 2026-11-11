# Workshop: CRUD de Productos con Laravel (MVC)

CRUD sencillo (Crear, Leer, Actualizar, Eliminar) de productos usando **Laravel** con **XAMPP (MySQL)**.

## ¿Dónde está el MVC?

| Capa | Archivo | Qué hace |
|---|---|---|
| **Modelo** | `app/Models/Producto.php` | Representa la tabla `productos` (Eloquent ORM) |
| **Vista** | `resources/views/productos/*.blade.php` | Pantallas HTML con plantillas Blade |
| **Controlador** | `app/Http/Controllers/ProductoController.php` | Recibe la petición, usa el modelo y devuelve la vista |
| Rutas | `routes/web.php` | Conecta cada URL con un método del controlador |
| Migración | `database/migrations/..._create_productos_table.php` | Crea la tabla en MySQL desde código |

Flujo: **Navegador → Ruta → Controlador → Modelo (BD) → Controlador → Vista → Navegador**

## Requisitos

- XAMPP (Apache + MySQL encendidos)
- PHP 8.3 o superior para Laravel 13 (con PHP 8.2, Composer instala Laravel 12 y el código funciona igual)
- Composer: https://getcomposer.org/download/

Para revisar las versiones:
```bash
php -v
composer -V
```

## Paso a paso

### 1. Crear el proyecto
```bash
cd C:\xampp\htdocs
composer create-project laravel/laravel crud-productos
cd crud-productos
```

### 2. Crear la base de datos
En phpMyAdmin (http://localhost/phpmyadmin) cree una base llamada `crud_productos`.

### 3. Configurar el `.env`
Abra el archivo `.env` y cambie la conexión (por defecto viene SQLite):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_productos
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Copiar los archivos de este workshop
Copie cada archivo en la misma ruta dentro del proyecto. `routes/web.php` reemplaza al que ya existe.

> Opcional: los archivos se pueden generar con Artisan y luego pegar el contenido:
> ```bash
> php artisan make:model Producto -m
> php artisan make:controller ProductoController --resource --model=Producto
> ```

### 5. Ejecutar las migraciones
```bash
php artisan migrate
```

### 6. Levantar el servidor
```bash
php artisan serve
```
Abra http://127.0.0.1:8000. Lo redirige a `/productos`.

## Rutas que genera `Route::resource`

Para verlas: `php artisan route:list`

| Método | URL | Acción | Operación |
|---|---|---|---|
| GET | /productos | index | Listar (Read) |
| GET | /productos/create | create | Formulario nuevo |
| POST | /productos | store | Guardar (Create) |
| GET | /productos/{id} | show | Ver detalle (Read) |
| GET | /productos/{id}/edit | edit | Formulario editar |
| PUT | /productos/{id} | update | Actualizar (Update) |
| DELETE | /productos/{id} | destroy | Eliminar (Delete) |

## Errores comunes

- **"could not find driver" / "Connection refused"**: MySQL no está encendido en XAMPP o el `.env` no está configurado.
- **Table 'productos' doesn't exist**: falta ejecutar `php artisan migrate`.
- **Error 419 Page Expired**: falta `@csrf` dentro del formulario.
- **No se ven los cambios del `.env`**: ejecute `php artisan config:clear`.
