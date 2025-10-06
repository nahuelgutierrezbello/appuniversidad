# 📘 Base de Datos Universitaria — Estructura y Expansión para Dashboard de Profesores

## 🧩 1. Descripción General

Esta base de datos está diseñada para gestionar la información académica de una **universidad**.  
Actualmente, permite manejar **carreras**, **estudiantes**, **profesores**, **categorías**, **modalidades** y **usuarios** con distintos roles (incluido un **superadmin**).

Su estructura está pensada para ser **escalable y relacional**, de modo que puedan agregarse nuevas funcionalidades sin modificar lo existente.

---

## 🗂️ 2. Tablas Existentes

### **Carrera**
Contiene los datos principales de cada carrera universitaria.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_car` | BIGINT | Identificador único. |
| `ncar` | VARCHAR(120) | Nombre completo de la carrera. |
| `codcar` | VARCHAR(20) | Código único de carrera. |

🔗 *Relaciona con*: Estudiante, Profesor, Categoría, Modalidad.

---

### **Estudiante**
Almacena los datos personales y académicos de cada alumno.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_est` | BIGINT | Identificador único. |
| `dni` | CHAR(8) | Documento del estudiante (único). |
| `nest` | VARCHAR(80) | Nombre del estudiante. |
| `fecha_nac` | DATE | Fecha de nacimiento. |
| `edad` | CHAR(2) | Edad actual. |
| `email` | VARCHAR(50) | Correo de contacto. |
| `id_car` | BIGINT | Relación con la carrera. |

🧩 **Relaciones:**
- `id_car` → `Carrera.id_car`
- Restricción de formato en DNI con `CHECK`.

---

### **Profesor**
Registra los docentes asociados a cada carrera.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_prof` | BIGINT | Identificador único. |
| `legajo` | INT | Número interno de docente (único). |
| `nprof` | VARCHAR(80) | Nombre del profesor. |
| `id_car` | BIGINT | Carrera a la que pertenece. |

🔗 *Relaciona con*: Carrera.

---

### **Categoría**
Define tipos o niveles dentro de una carrera (por ejemplo: Docente Titular, Adjunto, Auxiliar).

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_cat` | BIGINT | Identificador único. |
| `codcat` | VARCHAR(20) | Código único de categoría. |
| `ncat` | VARCHAR(120) | Nombre o descripción. |
| `id_car` | BIGINT | Relación con carrera. |

---

### **Modalidad**
Indica la forma en que se cursa una carrera (presencial, virtual, híbrida).

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_mod` | BIGINT | Identificador único. |
| `codmod` | VARCHAR(20) | Código único de modalidad. |
| `nmod` | VARCHAR(120) | Descripción de la modalidad. |
| `id_car` | BIGINT | Relación con carrera. |

---

### **Rol**
Define los diferentes roles dentro del sistema.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_rol` | BIGINT | Identificador único. |
| `nrol` | VARCHAR(12) | Nombre del rol (ej: admin, profesor, estudiante, superadmin). |

---

### **Usuarios**
Contiene los accesos del sistema.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_user` | BIGINT | Identificador único. |
| `rol` | VARCHAR(1) | Código o abreviación del rol asignado. |

💡 **Sugerencia:**  
En una mejora futura, esta tabla debería tener relación con `rol.id_rol` para permitir asignar roles más fácilmente y permitir control de acceso a diferentes dashboards.

---

## 📊 3. Lo que Permite Actualmente

Con esta estructura podés:

- Listar todas las **carreras** disponibles.  
- Ver los **profesores** asociados a una carrera.  
- Ver los **estudiantes** inscritos en cada carrera.  
- Obtener un **dashboard general por carrera**, donde se relacionan profesores y alumnos por pertenecer a la misma carrera.

---

## ⚙️ 4. Limitación Actual

No existe una relación directa entre **Profesor ↔ Estudiante**.

Esto implica que:
- No se puede saber **qué profesor enseña a qué alumno**.
- Todos los alumnos de una carrera se mostrarán como si fueran “de todos los profesores” de esa carrera.

---

## 🚀 5. Lo que Necesitás Agregar para el Dashboard de Profesores

Para que cada profesor tenga su propio panel (dashboard) con sus alumnos y materias, se recomienda agregar las siguientes tablas:

### **Materia**
Guarda las materias o asignaturas que se dictan en cada carrera.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_mat` | BIGINT | Identificador único. |
| `nmat` | VARCHAR(120) | Nombre de la materia. |
| `codmat` | VARCHAR(20) | Código único. |
| `id_car` | BIGINT | Carrera a la que pertenece. |

---

### **Profesor_Materia**
Relaciona los profesores con las materias que dictan.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_prof` | BIGINT | Profesor asignado. |
| `id_mat` | BIGINT | Materia que dicta. |

---

### **Estudiante_Materia**
Relaciona a los alumnos con las materias que cursan.

| Campo | Tipo | Descripción |
|--------|------|-------------|
| `id_est` | BIGINT | Estudiante inscrito. |
| `id_mat` | BIGINT | Materia cursada. |

---

Con estas dos tablas nuevas, se pueden generar dashboards **por profesor**, mostrando:
- Qué materias dicta.
- Cuántos alumnos tiene por materia.
- Qué alumnos tiene asignados en cada materia.

---

## 🔐 6. Rol de Super Admin

El **superadmin** es un rol especial con acceso total al sistema:
- Puede crear, editar o eliminar carreras, profesores, estudiantes, materias, etc.
- Supervisa los dashboards de todos los usuarios.
- Tiene visibilidad completa sobre las relaciones y estadísticas del sistema.

---

## 🧭 7. Conclusión

Tu base actual está **bien estructurada** y permite administrar carreras, estudiantes y profesores a nivel general.

Para avanzar hacia un **dashboard profesional por profesor**, solo necesitás:

1. Agregar las tablas `Materia`, `Profesor_Materia` y `Estudiante_Materia`.  
2. Relacionar `usuarios` con `rol` correctamente.  
3. Generar consultas que filtren la información según el rol del usuario (profesor, admin o superadmin).

---

✍️ **Autor:** Sistema Universitario  
📅 **Versión:** 1.0  
📘 **Formato:** Markdown (README.md)




Flujo de datos en el dashboard

Super Admin

Tiene acceso a todo el sistema (usuarios, carreras, materias, roles, inscripciones, etc.).

Puede crear carreras, profesores, alumnos, modalidades y usuarios.

Supervisa estadísticas globales (alumnos activos, profesores activos, rendimiento general).

Profesor

Ve solo sus materias.

Gestiona asistencias y notas de sus alumnos.

Puede consultar listados e informes de rendimiento.

Alumno

Consulta materias inscriptas.

Ve sus notas y asistencias.

Puede descargar boletines o comprobantes.

Dashboard general (para admin o super admin)

Total de alumnos, profesores y materias.

Cantidad de alumnos por carrera y modalidad.

Promedio general por materia.

Porcentaje de asistencia global.

Profesores activos por carrera.

🔒 Recomendaciones profesionales

Usar roles con permisos diferenciados (lectura, escritura, administración).

Registrar fechas de creación y modificación en todas las tablas.

Controlar integridad con claves foráneas y restricciones de estado.

Evitar duplicados (usar IDs internos).

Preparar vistas SQL o consultas optimizadas para alimentar el dashboard (por ejemplo, alumnos por profesor, rendimiento por materia).

Mantener la tabla Usuarios centralizada para cualquier tipo de acceso (super admin, profesor, alumno, administrativo).

🧮 Ejemplo de estructura general (resumen conceptual)
Nivel	Entidades principales	Conexión
1️⃣ Base	Carrera, Modalidad	Estructura académica
2️⃣ Personal	Profesor, Estudiante	Pertenecen a una carrera
3️⃣ Académico	Materia, Profesor_Materia, Inscripción	Permiten conectar profesores y alumnos
4️⃣ Registro	Nota, Asistencia	Guardan el progreso y la actividad
5️⃣ Seguridad	Usuario, Rol	Control de acceso, incluye Super Admin
✅ Resultado final esperado

Con estas incorporaciones, tu sistema podrá:

Mostrar profesores y sus alumnos reales, no solo por carrera.

Registrar materias, notas y asistencias.

Permitir que cada rol tenga su propio panel de control (dashboard).

Que el Super Admin controle todo el sistema con reportes globales.