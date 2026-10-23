CREATE DATABASE IF NOT EXISTS crud_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crud_app;

CREATE TABLE IF NOT EXISTS students (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    student_no  VARCHAR(20)  NOT NULL UNIQUE,
    first_name  VARCHAR(60)  NOT NULL,
    last_name   VARCHAR(60)  NOT NULL,
    email       VARCHAR(120) NOT NULL UNIQUE,
    course      VARCHAR(60)  NOT NULL,
    year_level  TINYINT UNSIGNED NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO students (student_no, first_name, last_name, email, course, year_level) VALUES
('2023-0001', 'Juan',  'Dela Cruz', 'juan@example.com',  'BSIT', 3),
('2023-0002', 'Maria', 'Santos',    'maria@example.com', 'BSIT', 2);
