-- ==============================================
-- 🏫 BASE DE DATOS UNIVERSITARIA COMPLETA
-- Incluye estructura base + ampliaciones académicas
-- ==============================================

CREATE DATABASE IF NOT EXISTS app_uni CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE app_uni;

-- ==========================
-- 1️⃣ TABLAS BASE
-- ==========================

CREATE TABLE Carrera (
  id_car BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ncar VARCHAR(120) NOT NULL,
  codcar VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE Estudiante (
  id_est BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  dni CHAR(8) NOT NULL UNIQUE,
  nest VARCHAR(80) NOT NULL,
  fecha_nac DATE,
  edad CHAR(2),
  email VARCHAR(50) NOT NULL,
  id_car BIGINT UNSIGNED,
  CONSTRAINT fk_estudiante_carrera FOREIGN KEY (id_car) REFERENCES Carrera(id_car)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT chk_dni_valido CHECK (dni REGEXP '^[0-9]{8}$')
) ENGINE=InnoDB;

CREATE TABLE Profesor (
  id_prof BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  legajo INT NOT NULL UNIQUE,
  nprof VARCHAR(80) NOT NULL,
  id_car BIGINT UNSIGNED,
  CONSTRAINT fk_profesor_carrera FOREIGN KEY (id_car) REFERENCES Carrera(id_car)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Categoria (
  id_cat BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codcat VARCHAR(20) NOT NULL UNIQUE,
  ncat VARCHAR(120) NOT NULL,
  id_car BIGINT UNSIGNED,
  CONSTRAINT fk_categoria_carrera FOREIGN KEY (id_car) REFERENCES Carrera(id_car)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Modalidad (
  id_mod BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codmod VARCHAR(20) NOT NULL UNIQUE,
  nmod VARCHAR(120) NOT NULL,
  id_car BIGINT UNSIGNED,
  CONSTRAINT fk_modalidad_carrera FOREIGN KEY (id_car) REFERENCES Carrera(id_car)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE Rol (
  id_rol BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nrol VARCHAR(20) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE Usuarios (
  id_user BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  id_rol BIGINT UNSIGNED,
  activo BOOLEAN DEFAULT TRUE,
  CONSTRAINT fk_usuario_rol FOREIGN KEY (id_rol) REFERENCES Rol(id_rol)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- ==========================
-- 2️⃣ TABLAS ACADÉMICAS
-- ==========================

-- MATERIAS DE CADA CARRERA
CREATE TABLE Materia (
  id_mat BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nmat VARCHAR(120) NOT NULL,
  codmat VARCHAR(20) NOT NULL UNIQUE,
  id_car BIGINT UNSIGNED,
  CONSTRAINT fk_materia_carrera FOREIGN KEY (id_car) REFERENCES Carrera(id_car)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB;

-- RELACIÓN PROFESOR ↔ MATERIA
CREATE TABLE Profesor_Materia (
  id_prof BIGINT UNSIGNED,
  id_mat BIGINT UNSIGNED,
  PRIMARY KEY (id_prof, id_mat),
  CONSTRAINT fk_prof_mat_profesor FOREIGN KEY (id_prof) REFERENCES Profesor(id_prof)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_prof_mat_materia FOREIGN KEY (id_mat) REFERENCES Materia(id_mat)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- RELACIÓN ESTUDIANTE ↔ MATERIA
CREATE TABLE Estudiante_Materia (
  id_est BIGINT UNSIGNED,
  id_mat BIGINT UNSIGNED,
  PRIMARY KEY (id_est, id_mat),
  CONSTRAINT fk_est_mat_estudiante FOREIGN KEY (id_est) REFERENCES Estudiante(id_est)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_est_mat_materia FOREIGN KEY (id_mat) REFERENCES Materia(id_mat)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- NOTAS DE LOS ESTUDIANTES
CREATE TABLE Nota (
  id_nota BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_est BIGINT UNSIGNED,
  id_mat BIGINT UNSIGNED,
  calificacion DECIMAL(4,2),
  fecha_eval DATE,
  observaciones VARCHAR(255),
  CONSTRAINT fk_nota_est FOREIGN KEY (id_est) REFERENCES Estudiante(id_est)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_nota_mat FOREIGN KEY (id_mat) REFERENCES Materia(id_mat)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- ASISTENCIAS DE LOS ESTUDIANTES
CREATE TABLE Asistencia (
  id_asist BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_est BIGINT UNSIGNED,
  id_mat BIGINT UNSIGNED,
  fecha DATE NOT NULL,
  estado ENUM('Presente','Ausente','Tarde') NOT NULL,
  observaciones VARCHAR(255),
  CONSTRAINT fk_asist_est FOREIGN KEY (id_est) REFERENCES Estudiante(id_est)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_asist_mat FOREIGN KEY (id_mat) REFERENCES Materia(id_mat)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- MATERIALES DE CLASE
CREATE TABLE Material (
  id_mat_arch BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_mat BIGINT UNSIGNED,
  titulo VARCHAR(120) NOT NULL,
  descripcion TEXT,
  archivo_url VARCHAR(255),
  fecha_subida DATE,
  CONSTRAINT fk_material_materia FOREIGN KEY (id_mat) REFERENCES Materia(id_mat)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================
-- 3️⃣ USUARIOS Y ROLES BASE
-- ==========================

INSERT INTO Rol (nrol) VALUES
('Superadmin'),
('Administrador'),
('Profesor'),
('Estudiante');

-- Ejemplo de usuarios iniciales
INSERT INTO Usuarios (usuario, password, id_rol) VALUES
('superadmin', 'hash_superadmin', 1),
('admin', 'hash_admin', 2),
('profesor_demo', 'hash_profesor', 3),
('alumno_demo', 'hash_alumno', 4);

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
