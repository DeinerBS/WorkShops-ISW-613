CREATE DATABASE IF NOT EXISTS workshop2 CHARACTER SET utf8mb4;
USE workshop2;

CREATE TABLE IF NOT EXISTS provincias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  provincia_id INT NOT NULL,
  FOREIGN KEY (provincia_id) REFERENCES provincias(id)
);

INSERT INTO provincias (nombre) VALUES
('San José'),
('Alajuela'),
('Cartago'),
('Heredia'),
('Guanacaste'),
('Puntarenas'),
('Limón');


INSERT INTO users (username, password, provincia_id) VALUES
('deiner', '$2y$10$U6eWo9RJKXNmN2C7min2XOpolQ9ppOA//MbldJaeAor4CjFfUax86', 2);