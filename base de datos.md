queries BD 



-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS appuniversidad 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
USE appuniversidad;

-- ==========================
-- 1️⃣ TABLAS BASE
-- ==========================

-- Carrera
CREATE TABLE Carrera (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre_carrera VARCHAR(120) NOT NULL,
  codigo_carrera VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Rol (independiente)
CREATE TABLE Rol (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre_rol VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Usuarios (depende de Rol) - CON CAMPOS DE FECHAS INTEGRADOS
CREATE TABLE Usuarios (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fecha_ultimo_ingreso TIMESTAMP NULL,
  rol_id BIGINT UNSIGNED,
  activo BOOLEAN DEFAULT TRUE,
  CONSTRAINT fk_usuario_rol FOREIGN KEY (rol_id) REFERENCES Rol(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Estudiante (depende de Carrera)
CREATE TABLE Estudiante (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  dni CHAR(8) NOT NULL UNIQUE,
  nombre_estudiante VARCHAR(80) NOT NULL,
  fecha_nacimiento DATE,
  edad CHAR(2),
  email VARCHAR(50) NOT NULL,
  carrera_id BIGINT UNSIGNED,
  CONSTRAINT fk_estudiante_carrera FOREIGN KEY (carrera_id) REFERENCES Carrera(id)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT chk_dni_valido CHECK (dni REGEXP '^[0-9]{8}$')
) ENGINE=InnoDB;

-- Profesor (depende de Carrera)
CREATE TABLE Profesor (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  legajo INT NOT NULL UNIQUE,
  nombre_profesor VARCHAR(80) NOT NULL,
  carrera_id BIGINT UNSIGNED,
  CONSTRAINT fk_profesor_carrera FOREIGN KEY (carrera_id) REFERENCES Carrera(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Categoria (depende de Carrera)
CREATE TABLE Categoria (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codigo_categoria VARCHAR(20) NOT NULL UNIQUE,
  nombre_categoria VARCHAR(120) NOT NULL,
  carrera_id BIGINT UNSIGNED,
  CONSTRAINT fk_categoria_carrera FOREIGN KEY (carrera_id) REFERENCES Carrera(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Modalidad (depende de Carrera)
CREATE TABLE Modalidad (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codigo_modalidad VARCHAR(20) NOT NULL UNIQUE,
  nombre_modalidad VARCHAR(120) NOT NULL,
  carrera_id BIGINT UNSIGNED,
  CONSTRAINT fk_modalidad_carrera FOREIGN KEY (carrera_id) REFERENCES Carrera(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================
-- 2️⃣ TABLAS ACADÉMICAS
-- ==========================

-- Materia (depende de Carrera)
CREATE TABLE Materia (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre_materia VARCHAR(120) NOT NULL,
  codigo_materia VARCHAR(20) NOT NULL UNIQUE,
  carrera_id BIGINT UNSIGNED,
  CONSTRAINT fk_materia_carrera FOREIGN KEY (carrera_id) REFERENCES Carrera(id)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- Inscripcion (reemplaza Estudiante_Materia; depende de Estudiante y Materia)
CREATE TABLE Inscripcion (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  estudiante_id BIGINT UNSIGNED NOT NULL,
  materia_id BIGINT UNSIGNED NOT NULL,
  fecha_inscripcion DATE NOT NULL DEFAULT CURRENT_DATE,
  estado_inscripcion ENUM('Pendiente', 'Confirmada', 'Anulada', 'Aprobada', 'Reprobada') NOT NULL DEFAULT 'Pendiente',
  observaciones_inscripcion VARCHAR(255),
  fecha_aprobacion DATE,
  cupo_asignado INT DEFAULT 1,
  UNIQUE KEY unique_inscripcion (estudiante_id, materia_id),
  CONSTRAINT fk_inscripcion_estudiante FOREIGN KEY (estudiante_id) REFERENCES Estudiante(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_inscripcion_materia FOREIGN KEY (materia_id) REFERENCES Materia(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- Profesor_Materia (depende de Profesor y Materia)
CREATE TABLE Profesor_Materia (
  profesor_id BIGINT UNSIGNED,
  materia_id BIGINT UNSIGNED,
  PRIMARY KEY (profesor_id, materia_id),
  CONSTRAINT fk_profesor_materia_profesor FOREIGN KEY (profesor_id) REFERENCES Profesor(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_profesor_materia_materia FOREIGN KEY (materia_id) REFERENCES Materia(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- Nota (depende de Estudiante y Materia)
CREATE TABLE Nota (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  estudiante_id BIGINT UNSIGNED,
  materia_id BIGINT UNSIGNED,
  calificacion DECIMAL(4,2),
  fecha_evaluacion DATE,
  observaciones VARCHAR(255),
  CONSTRAINT fk_nota_estudiante FOREIGN KEY (estudiante_id) REFERENCES Estudiante(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_nota_materia FOREIGN KEY (materia_id) REFERENCES Materia(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- Asistencia (depende de Estudiante y Materia)
CREATE TABLE Asistencia (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  estudiante_id BIGINT UNSIGNED,
  materia_id BIGINT UNSIGNED,
  fecha DATE NOT NULL,
  estado ENUM('Presente','Ausente','Tarde') NOT NULL,
  observaciones VARCHAR(255),
  CONSTRAINT fk_asistencia_estudiante FOREIGN KEY (estudiante_id) REFERENCES Estudiante(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_asistencia_materia FOREIGN KEY (materia_id) REFERENCES Materia(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;


-- ==========================
-- 3️⃣ MODIFICACIONES ADICIONALES (ALTER TABLE) - SOLO PARA CAMPOS OPCIONALES
-- ==========================

-- Agregar campos opcionales en Nota y Asistencia para referenciar Inscripcion
ALTER TABLE nota ADD COLUMN inscripcion_id BIGINT UNSIGNED NULL;
ALTER TABLE nota ADD CONSTRAINT fk_nota_inscripcion FOREIGN KEY (inscripcion_id) REFERENCES Inscripcion(id)
  ON UPDATE CASCADE ON DELETE SET NULL;

ALTER TABLE asistencia ADD COLUMN inscripcion_id BIGINT UNSIGNED NULL;
ALTER TABLE asistencia ADD CONSTRAINT fk_asistencia_inscripcion FOREIGN KEY (inscripcion_id) REFERENCES Inscripcion(id)
  ON UPDATE CASCADE ON DELETE SET NULL;

-- ==========================
-- 4️⃣ DATOS INICIALES
-- ==========================

-- Insertar roles
INSERT INTO Rol (nombre_rol) VALUES
('Superadmin'),
('Administrador'),
('Profesor'),
('Estudiante');

-- Insertar usuarios de ejemplo (contraseñas hasheadas en producción; fecha_registro se auto-asigna)
INSERT INTO Usuarios (usuario, password, rol_id) VALUES
('superadmin', 'hash_superadmin', 1),
('admin', 'hash_admin', 2),
('profesor_demo', 'hash_profesor', 3),
('alumno_demo', 'hash_alumno', 4);

-- Datos de ejemplo para probar (Carrera, Estudiante, Materia, Inscripcion)
INSERT INTO Carrera (nombre_carrera, codigo_carrera) VALUES
('Ingeniería en Sistemas', 'ING-SIS');

INSERT INTO Estudiante (dni, nombre_estudiante, fecha_nacimiento, edad, email, carrera_id) VALUES
('12345678', 'Juan Pérez', '2000-05-15', '23', 'juan@example.com', 1);

INSERT INTO Profesor (legajo, nombre_profesor, carrera_id) VALUES
(1001, 'María García', 1);

INSERT INTO Materia (nombre_materia, codigo_materia, carrera_id) VALUES
('Programación I', 'PROG-101', 1);

-- Asignar profesor a materia
INSERT INTO Profesor_Materia (profesor_id, materia_id) VALUES
(1, 1);

-- Inscripcion de ejemplo
INSERT INTO Inscripcion (estudiante_id, materia_id, fecha_inscripcion, estado_inscripcion) VALUES
(1, 1, '2023-08-01', 'Confirmada');

-- Nota de ejemplo
INSERT INTO Nota (estudiante_id, materia_id, calificacion, fecha_evaluacion, inscripcion_id) VALUES
(1, 1, 8.50, '2023-10-15', 1);

-- Asistencia de ejemplo
INSERT INTO Asistencia (estudiante_id, materia_id, fecha, estado, inscripcion_id) VALUES
(1, 1, '2023-10-01', 'Presente', 1);


-- ==========================
-- 5️⃣ TRIGGERS OPCIONALES (para automatizar fechas en Usuarios)
-- ==========================
-- Ejecuta estos si quieres automatización automática. De lo contrario, maneja en la app (recomendado).

DELIMITER $$

-- Trigger para fecha_registro en INSERT (respaldo al DEFAULT)
CREATE TRIGGER trg_usuarios_insert_fecha_registro
BEFORE INSERT ON Usuarios
FOR EACH ROW
BEGIN
    IF NEW.fecha_registro IS NULL THEN
        SET NEW.fecha_registro = CURRENT_TIMESTAMP;
    END IF;
END$$

-- Trigger para fecha_ultimo_ingreso en UPDATE (actualiza en cualquier cambio; usa versión condicional si prefieres)
CREATE TRIGGER trg_usuarios_update_ultimo_ingreso
BEFORE UPDATE ON Usuarios
FOR EACH ROW
BEGIN
    SET NEW.fecha_ultimo_ingreso = CURRENT_TIMESTAMP;
END$$

DELIMITER ;

-- ==========================
-- ✅ FIN DE ESTRUCTURA
-- ==========================

-- Notas:
-- - Este script es secuencial: ejecuta todo de una vez para crear la BD completa.
-- - Si ya existe la BD, usa DROP DATABASE app_uni; antes para resetear.
-- - Verifica la tabla Usuarios con: DESCRIBE Usuarios; (ahora verás fecha_registro y fecha_ultimo_ingreso directamente).
-- - Para CodeIgniter 4: Configura en app/Config/Database.php y usa migrations para futuras cambios.
-- - Pruebas: SELECT * FROM Usuarios; (verás fecha_registro auto-asignada en los inserts).
-- - Si necesitas más datos de ejemplo o ajustes, avísame.