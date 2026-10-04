-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS workshop1;
USE workshop1;

--  Tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

-- Usuario de prueba, contraseña está guardada "encriptada" con password_hash)
INSERT INTO users (username, password) VALUES
('deiner', '$2y$10$U6eWo9RJKXNmN2C7min2XOpolQ9ppOA//MbldJaeAor4CjFfUax86');