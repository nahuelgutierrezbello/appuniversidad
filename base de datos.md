##### 📊 TABLA Carrera - Datos exigidos:

ncar - Nombre de la carrera (OBLIGATORIO)

codcar - Código de la carrera (OBLIGATORIO, ÚNICO)

duracion - Duración en años de la carrera (OPCIONAL)

id_mod - ID de la Modalidad a la que pertenece (OPCIONAL, Relación)

id_cat - ID de la Categoría a la que pertenece (OPCIONAL, Relación)

##### **👨‍🎓 TABLA Estudiante - Datos exigidos:**

dni - DNI (OBLIGATORIO, 8 dígitos, ÚNICO)

nest - Nombre del estudiante (OBLIGATORIO)

edad - Edad (OBLIGATORIO, 2 caracteres)

email - Email (OBLIGATORIO)

fecha\_nac - Fecha nacimiento (OPCIONAL)

id\_car - ID Carrera (OPCIONAL)

##### 👨‍🏫 TABLA Profesor - Datos exigidos:

legajo - Número de legajo (OBLIGATORIO, ÚNICO)

nprof - Nombre del profesor (OBLIGATORIO)


##### 📑 TABLA Categoria - Datos exigidos:

codcat - Código de categoría (OBLIGATORIO, ÚNICO)

ncat - Nombre de categoría (OBLIGATORIO)


##### 🎯 TABLA Modalidad - Datos exigidos:

codmod - Código de modalidad (OBLIGATORIO, ÚNICO)

nmod - Nombre de modalidad (OBLIGATORIO)

--------------------------------------------------------------------------------------

-- ====================================================================================
-- NOTA IMPORTANTE:
-- Este script SQL es una representación para facilitar la comprensión del esquema.
-- La fuente de verdad y la estructura definitiva de la base de datos están
-- definidas en los archivos de MIGRACIÓN de CodeIgniter 4.
-- ====================================================================================


CREATE DATABASE base_instituto
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE base_instituto;

-- ====================================================================================
-- 1. TABLAS MAESTRAS (INDEPENDIENTES)
-- Estas tablas no dependen de ninguna otra y se crean primero.
-- ====================================================================================

CREATE TABLE Categoria (
  id_cat BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codcat VARCHAR(20) NOT NULL UNIQUE,
  ncat VARCHAR(120) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Modalidad (
  id_mod BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codmod VARCHAR(20) NOT NULL UNIQUE,
  nmod VARCHAR(120) NOT NULL
) ENGINE=InnoDB;

-- ====================================================================================
-- 2. TABLAS DEPENDIENTES
-- Estas tablas contienen claves foráneas que apuntan a las tablas maestras.
-- ====================================================================================

CREATE TABLE Carrera (
  id_car BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ncar VARCHAR(120) NOT NULL,
  codcar VARCHAR(20) NOT NULL UNIQUE,
  duracion TINYINT UNSIGNED NULL,
  id_cat BIGINT UNSIGNED NULL,
  id_mod BIGINT UNSIGNED NULL,
  CONSTRAINT fk_carrera_categoria FOREIGN KEY (id_cat) REFERENCES Categoria(id_cat) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT fk_carrera_modalidad FOREIGN KEY (id_mod) REFERENCES Modalidad(id_mod) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Estudiante (
  id_est BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  dni CHAR(8) NOT NULL UNIQUE,
  nest VARCHAR(80) NOT NULL,
  fecha_nac DATE NULL,
  edad CHAR(2) NOT NULL,
  email VARCHAR(50) NOT NULL,
  id_car BIGINT UNSIGNED NULL,
  CONSTRAINT fk_estudiante_carrera FOREIGN KEY (id_car) REFERENCES Carrera(id_car) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Profesor (
  id_prof BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  legajo INT NOT NULL UNIQUE,
  nprof VARCHAR(80) NOT NULL
) ENGINE=InnoDB;


CREATE TABLE rol (
  id_rol BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nrol VARCHAR(12) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE usuarios (
  id_user BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  rol VARCHAR(1) NOT NULL UNIQUE
) ENGINE=InnoDB;

