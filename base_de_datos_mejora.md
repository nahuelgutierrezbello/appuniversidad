queries BD 



-- Crear la base de datos si no existe


CREATE DATABASE IF NOT EXISTS 
appuniversidad CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
USE appuniversidad;

-- ==========================
-- 1️⃣ TABLAS BASE
-- ==========================

-- Carrera
CREATE TABLE Carrera (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre_carrera VARCHAR(120) NOT NULL,
  codigo_carrera VARCHAR(20) NOT NULL UNIQUE,
  categoria_id BIGINT UNSIGNED,
  duracion INT,
  modalidad_id BIGINT UNSIGNED,
  CONSTRAINT fk_carrera_categoria FOREIGN KEY (categoria_id) REFERENCES Categoria(id)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_carrera_modalidad FOREIGN KEY (modalidad_id) REFERENCES Modalidad(id)
    ON UPDATE CASCADE ON DELETE SET NULL
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


  -- Nuevo campo para el asunto, con hasta 80 caracteres
CREATE TABLE consultas_admin (
    id_consulta INT AUTO_INCREMENT PRIMARY KEY,
    email_usuario VARCHAR(255) NOT NULL,
    mensaje VARCHAR(300) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('pendiente', 'en proceso', 'respondida') DEFAULT 'pendiente',
    asunto VARCHAR(80) NOT NULL
);


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



--4 modalidades asociadas a la carrera con id = 1 (Ingeniería en Sistemas).
INSERT INTO Modalidad (codigo_modalidad, nombre_modalidad, carrera_id) VALUES
('MOD-PRE', 'Presencial', 1),
('MOD-SEMI', 'Semipresencial', 1),
('MOD-VIRT', 'Virtual', 1),
('MOD-LIB', 'Libre', 1);

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



















-- ==========================
-- 4️⃣ RELACIONES LÓGICAS
-- ==========================
-- Carrera → Materia → Profesor_Materia → Estudiante_Materia → Nota / Asistencia / Material
-- Permite dashboards personalizados para:
-- - Profesor: materias, alumnos, notas, asistencias, materiales.
-- - Alumno: notas, asistencias y materiales de sus materias.
-- - Admin: control total de carreras, materias y usuarios.
-- - Superadmin: supervisión global.

-- ==========================
-- ✅ FIN DE ESTRUCTURA
-- ==========================


# 🎓 Base de Datos Universitaria — Expansión para Dashboards Personalizados

## 🧩 1. Descripción General

La base de datos actual gestiona la información de una institución universitaria, incluyendo **carreras**, **profesores**, **estudiantes**, **modalidades**, **categorías** y **usuarios con roles**.  

El objetivo de esta ampliación es permitir la creación de **dashboards personalizados** según el tipo de usuario:
- 👩‍🎓 **Alumno:** ve sus materias, notas, asistencias y materiales.  
- 👨‍🏫 **Profesor:** gestiona alumnos, calificaciones y contenidos.  
- 🧑‍💼 **Administrador:** administra carreras, usuarios, materias y reportes.  
- 👑 **Superadmin:** supervisa todo el sistema y controla permisos.

---

## 🗂️ 2. Estructura Actual

### **Carrera**
Define cada carrera universitaria.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_car` | BIGINT | Identificador único. |
| `ncar` | VARCHAR(120) | Nombre de la carrera. |
| `codcar` | VARCHAR(20) | Código único. |

---

### **Estudiante**
Datos personales y académicos del alumno.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_est` | BIGINT | Identificador único. |
| `dni` | CHAR(8) | Documento único. |
| `nest` | VARCHAR(80) | Nombre completo. |
| `fecha_nac` | DATE | Fecha de nacimiento. |
| `edad` | CHAR(2) | Edad. |
| `email` | VARCHAR(50) | Correo institucional o personal. |
| `id_car` | BIGINT | Carrera a la que pertenece. |

🔗 Relación: `id_car` → `Carrera.id_car`

---

### **Profesor**
Registra docentes asociados a una carrera.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_prof` | BIGINT | Identificador único. |
| `legajo` | INT | Número único de profesor. |
| `nprof` | VARCHAR(80) | Nombre completo. |
| `id_car` | BIGINT | Carrera en la que enseña. |

🔗 Relación: `id_car` → `Carrera.id_car`

---

### **Modalidad**
Define cómo se cursa una carrera (presencial, virtual, híbrida).

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_mod` | BIGINT | Identificador único. |
| `codmod` | VARCHAR(20) | Código único. |
| `nmod` | VARCHAR(120) | Descripción. |
| `id_car` | BIGINT | Carrera asociada. |

---

### **Categoría**
Clasifica roles o niveles dentro de una carrera (ej. Titular, Adjunto, Auxiliar).

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_cat` | BIGINT | Identificador único. |
| `codcat` | VARCHAR(20) | Código. |
| `ncat` | VARCHAR(120) | Descripción. |
| `id_car` | BIGINT | Relación con carrera. |

---

### **Rol**
Define el tipo de usuario dentro del sistema.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_rol` | BIGINT | Identificador único. |
| `nrol` | VARCHAR(12) | Nombre del rol (Alumno, Profesor, Admin, Superadmin). |

---

### **Usuarios**
Gestión básica de accesos.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_user` | BIGINT | Identificador único. |
| `rol` | VARCHAR(1) | Código o inicial del rol. |

💡 **Recomendación:**  
Conectar `usuarios` con `rol.id_rol` para tener una estructura más flexible y segura.

---

## 🚧 3. Limitación Actual

La base actual **no contiene información académica detallada**.  
No existen registros de:
- Materias
- Notas
- Asistencias
- Materiales de clase

Por lo tanto, los dashboards no pueden mostrar información personalizada a cada usuario.

---

## 🚀 4. Ampliaciones Necesarias

Para lograr dashboards funcionales y completos, se deben agregar las siguientes tablas y relaciones.

---

### 🧱 **Materia**
Define las asignaturas que pertenecen a cada carrera.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_mat` | BIGINT | Identificador único. |
| `nmat` | VARCHAR(120) | Nombre de la materia. |
| `codmat` | VARCHAR(20) | Código único. |
| `id_car` | BIGINT | Carrera a la que pertenece. |

🔗 Relación: `id_car` → `Carrera.id_car`

---

### 🧑‍🏫 **Profesor_Materia**
Vincula a los profesores con las materias que dictan.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_prof` | BIGINT | Profesor asignado. |
| `id_mat` | BIGINT | Materia correspondiente. |

🔗 Relaciones:
- `id_prof` → `Profesor.id_prof`
- `id_mat` → `Materia.id_mat`

---

### 👩‍🎓 **Estudiante_Materia**
Registra qué alumnos cursan cada materia.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_est` | BIGINT | Estudiante. |
| `id_mat` | BIGINT | Materia. |

🔗 Relaciones:
- `id_est` → `Estudiante.id_est`
- `id_mat` → `Materia.id_mat`

---

### 📝 **Nota**
Guarda las calificaciones obtenidas por los estudiantes en cada materia.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_nota` | BIGINT | Identificador único. |
| `id_est` | BIGINT | Estudiante evaluado. |
| `id_mat` | BIGINT | Materia. |
| `calificacion` | DECIMAL(4,2) | Nota numérica. |
| `fecha_eval` | DATE | Fecha de evaluación. |

🔗 Relaciones:
- `id_est` → `Estudiante.id_est`
- `id_mat` → `Materia.id_mat`

---

### 🕒 **Asistencia**
Registra la presencia o ausencia de los alumnos.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_asist` | BIGINT | Identificador único. |
| `id_est` | BIGINT | Estudiante. |
| `id_mat` | BIGINT | Materia. |
| `fecha` | DATE | Día de clase. |
| `estado` | ENUM('Presente','Ausente','Tarde') | Estado de asistencia. |

---

### 📂 **Material**
Contiene los materiales de clase que suben los profesores.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_mat_arch` | BIGINT | Identificador único. |
| `id_mat` | BIGINT | Materia asociada. |
| `titulo` | VARCHAR(120) | Título del material. |
| `descripcion` | TEXT | Descripción. |
| `archivo_url` | VARCHAR(255) | Ruta o enlace del material. |
| `fecha_subida` | DATE | Fecha de publicación. |

---

## 🧭 5. Dashboards Resultantes

### 👩‍🎓 **Dashboard de Alumno**
El estudiante podrá:
- Ver sus **materias actuales**.
- Consultar sus **notas** por materia.
- Ver su **historial de asistencias**.
- Descargar o visualizar **materiales de estudio** subidos por sus profesores.

---

### 👨‍🏫 **Dashboard de Profesor**
El profesor podrá:
- Ver las **materias que dicta**.
- Ver los **alumnos inscriptos** en cada materia.
- Cargar **notas** y **asistencias**.
- Subir **materiales de clase**.
- Generar reportes de rendimiento y asistencia.

---

### 🧑‍💼 **Dashboard de Administrador**
El administrador podrá:
- Crear, modificar o eliminar **carreras**, **materias**, **profesores** y **alumnos**.
- Asignar profesores a materias y estudiantes a carreras.
- Monitorear estadísticas de notas y asistencias.

---

### 👑 **Dashboard de Superadmin**
El superadmin tiene acceso total:
- Visualiza todos los datos del sistema.
- Crea y gestiona roles y permisos.
- Supervisa dashboards de todos los usuarios.
- Controla auditorías y seguridad del sistema.

---

## ✅ 6. Conclusión

Tu base actual ya cuenta con una **estructura sólida y escalable**.  
Para implementar dashboards completos y funcionales, solo necesitás agregar las tablas académicas clave:

- `Materia`  
- `Profesor_Materia`  
- `Estudiante_Materia`  
- `Nota`  
- `Asistencia`  
- `Material`

Con estas extensiones, cada usuario podrá acceder a su información personalizada, haciendo que el sistema sea **profesional, ordenado y operativo en entorno real**.

---

✍️ **Autor:** Sistema Universitario  
📅 **Versión:** 2.0  
📘 **Formato:** Markdown (README.md)
