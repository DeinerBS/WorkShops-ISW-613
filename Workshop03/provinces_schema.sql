-- Run after auth_schema.sql
CREATE TABLE IF NOT EXISTS provinces (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_provinces_name (name)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO provinces (name) VALUES
    ('San José'),
    ('Alajuela'),
    ('Cartago'),
    ('Heredia'),
    ('Guanacaste'),
    ('Puntarenas'),
    ('Limón');

-- Nullable so existing users (admin, bladimir) remain valid until they pick a province in their profile
ALTER TABLE users
    ADD COLUMN province_id INT UNSIGNED NULL AFTER password_hash,
    ADD CONSTRAINT fk_users_province
        FOREIGN KEY (province_id) REFERENCES provinces (id)
        ON UPDATE CASCADE
        ON DELETE SET NULL;
