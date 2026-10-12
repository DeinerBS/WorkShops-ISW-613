# Workshop 2

Registro de usuarios con provincias y su perfil im´plementando sesiones 

## Archivos

 "database.sql" : crea la base de datos `workshop2` con las tablas `provincias` y `users`.
 `conexion.php`: es conexión a la base de datos.
 `index.php`: login.
 `login.php`: valida las credenciales e inicia la sesión.
 `registro.php`: registro de usuarios con dropdown de provincias.
 `perfil.php`: perfil del usuario, requiere sesión activa donde puede actualizar sus datos.
`logout.php`: cierra la sesión.


## Funcionamiento
- Si no hay sesión activa, `perfil.php` redirige al login.
- Las contraseñas se guardan encriptadas con `password_hash`.