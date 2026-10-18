CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_username (username)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

INSERT IGNORE INTO users (username, password_hash) VALUES
    ('admin', '$2y$10$PYp8cJm70gMuSzn9sDWvv.z6tCDxkjWy2eu44wXwPG5gemog9hJ5.'),
    ('bladimir', '$2y$10$7bAYvF3xfPxIe.0qokV/YOduW5BKAfkNTCrGrcots9mdLRdENYS/e');
