-- Tabla de carreras, cada curso pertenece a una carrera
CREATE TABLE IF NOT EXISTS careers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_careers_name (name)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO careers (name) VALUES
    ('Ingeniería en Sistemas'),
    ('Administración de Empresas'),
    ('Contabilidad'),
    ('Diseño Gráfico');

-- Tabla de cursos
CREATE TABLE IF NOT EXISTS courses (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL,
    career_id INT UNSIGNED NOT NULL,
    credits TINYINT UNSIGNED NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_courses_code (code),
    CONSTRAINT fk_courses_career
        FOREIGN KEY (career_id) REFERENCES careers (id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Cursos de ejemplo
INSERT IGNORE INTO courses (name, code, career_id, credits, description) VALUES
    ('Programación Ambiente Web', 'ISW-613',
        (SELECT id FROM careers WHERE name = 'Ingeniería del Software'), 4,
        'Desarrollo de aplicaciones web con PHP y MySQL.'),
    ('Sistemas Operativos de Red', 'ISW-612',
        (SELECT id FROM careers WHERE name = 'Ingeniería del Software'), 4,
        'Administración y gestión de servicios y sistemas operativos en red.'),
    ('Comunicacion Visual', 'AC-101',
        (SELECT id FROM careers WHERE name = 'Diseño Gráfico'), 3,
        'Fundamentos teóricos y prácticos de la transmisión de mensajes a través de elementos visuales.');
