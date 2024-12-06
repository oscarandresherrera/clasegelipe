-- Crear base de datos 'prueba'
CREATE DATABASE IF NOT EXISTS prueba;

-- Seleccionar la base de datos 'prueba'
USE prueba;

-- Crear tabla 'usuarios'
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar algunos datos de prueba en la tabla 'usuarios'
INSERT INTO usuarios (nombre, correo)
VALUES 
    ('Juan Pérez', 'juan.perez@example.com'),
    ('Ana Gómez', 'ana.gomez@example.com'),
    ('Carlos López', 'carlos.lopez@example.com'),
    ('María García', 'maria.garcia@example.com');

-- Consultar los datos de la tabla 'usuarios'
SELECT * FROM usuarios;

-- Comando para verificar la creación de la tabla
SHOW TABLES;
