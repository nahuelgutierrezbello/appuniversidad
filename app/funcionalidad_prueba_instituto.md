<div align="center">
  <img src="https://raw.githubusercontent.com/codeigniter4/CodeIgniter4/develop/public/assets/images/ci-logo-big.png" alt="CodeIgniter 4" width="150">
  <h1>Sistema de Gestión Académica</h1>
  <p>Una aplicación web robusta y moderna desarrollada con <strong>CodeIgniter 4</strong> para la administración integral de estudiantes, carreras, categorías y modalidades académicas.</p>
  <p>
    <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php" alt="PHP 8.1+">
    <img src="https://img.shields.io/badge/CodeIgniter-4.x-EF4223?style=for-the-badge&logo=codeigniter" alt="CodeIgniter 4">
    <img src="https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap" alt="Bootstrap 5">
    <img src="https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
    <img src="https://img.shields.io/badge/jQuery-3.x-0769AD?style=for-the-badge&logo=jquery" alt="jQuery">
  </p>
</div>

---

## 📜 Índice

1.  [✨ Visión General del Proyecto](#-visión-general-del-proyecto)
2.  [🚀 Funcionalidades Detalladas](#-funcionalidades-detalladas)
    -   [👨‍🎓 Módulo de Estudiantes](#-módulo-de-estudiantes)
    -   [📚 Módulo de Carreras](#-módulo-de-carreras)
    -   [🗂️ Módulos de Categorías y Modalidades](#-módulos-de-categorías-y-modalidades)
3.  [🛠️ Stack Tecnológico](#-stack-tecnológico)
4.  [🏛️ Arquitectura y Decisiones de Diseño](#-arquitectura-y-decisiones-de-diseño)
5.  [🔒 Características de Seguridad](#-características-de-seguridad)
6.  [⚙️ Guía de Instalación Local](#-guía-de-instalación-local)
7.  [⚡ Comandos Útiles de Spark](#-comandos-útiles-de-spark)

---

## ✨ Visión General del Proyecto

Este sistema ofrece una solución completa para la gestión de entidades académicas clave. La interfaz de usuario ha sido diseñada para ser **intuitiva, rápida y eficiente**, minimizando las recargas de página y proporcionando una experiencia de usuario fluida, similar a la de una Single-Page Application (SPA).

> **Nota:** Para una descripción técnica más profunda de la arquitectura, consulta el archivo `readme_arquitectura.md`.

---

## 🚀 Funcionalidades Detalladas

A continuación se detalla cada una de las funcionalidades implementadas en los diferentes módulos del sistema.

### 👨‍🎓 Módulo de Estudiantes

El portal de gestión de estudiantes es el corazón de la aplicación. Estas son sus características principales:

-   **📊 Listado Interactivo con `DataTables.js`**
    -   **Descripción:** Muestra a todos los estudiantes en una tabla profesional que permite buscar, ordenar por columnas y navegar entre páginas sin recargar el sitio.
    -   **Tecnología:** Se utiliza la librería `DataTables.js`.

-   **➕ Registro de Estudiante con Validación Robusta**
    -   **Descripción:** Un formulario permite añadir nuevos estudiantes. El sistema valida en el servidor que los datos sean correctos (ej: DNI único, email válido) antes de guardarlos.
    -   **Tecnología:** Se usan las reglas de validación de los `Modelos de CodeIgniter`.

-   **✏️ Edición Rápida en Ventana Modal**
    -   **Descripción:** Al hacer clic en "Editar", los datos del estudiante se cargan en una ventana emergente (modal) al instante, permitiendo una actualización rápida sin salir de la página principal.
    -   **Tecnología:** Se realiza una petición `AJAX` con `jQuery` para obtener los datos.

-   **🗑️ Eliminación Segura con `SweetAlert2`**
    -   **Descripción:** Antes de borrar un estudiante, el sistema muestra una alerta de confirmación elegante para evitar borrados accidentales.
    -   **Tecnología:** Se utiliza la librería `SweetAlert2`.

-   **🔍 Búsqueda Instantánea por ID**
    -   **Descripción:** Permite buscar un estudiante por su ID y ver sus detalles (nombre y carrera) en una tarjeta de información sin recargar la página.
    -   **Tecnología:** Se usa `AJAX` con `jQuery`.

-   **🔎 Búsqueda de Alumnos por Carrera**
    -   **Descripción:** Un menú desplegable permite seleccionar una carrera y ver una lista de todos los estudiantes inscritos en ella, mostrando los resultados en tarjetas dinámicas.
    -   **Tecnología:** Se usa `AJAX` con `jQuery`.

### 📚 Módulo de Carreras

Gestiona la oferta académica del instituto. Estas son sus características principales:

-   **📊 Listado Interactivo con `DataTables.js`**
    -   Muestra todas las carreras en una tabla profesional.
    -   Incluye paginación, búsqueda instantánea y ordenamiento por columnas.

-   **⚡ Registro con Código Automático en Tiempo Real**
    -   **Descripción:** Al escribir el nombre de una nueva carrera (ej: "Análisis de Sistemas"), el sistema genera un código único (`AS-1`, `AS-2`, etc.) automáticamente y lo muestra en el formulario.
    -   **Tecnología:** Se utiliza `AJAX` con una técnica de `debounce` en JavaScript. Esto evita sobrecargar el servidor, ya que la consulta para verificar el código solo se envía cuando el usuario deja de escribir.

-   **✏️ Edición Rápida en Ventana Modal**
    -   **Descripción:** Al hacer clic en "Editar", los datos de la carrera se cargan en una ventana emergente (modal) sin necesidad de recargar toda la página.
    -   **Tecnología:** Se realiza una petición `AJAX` con `jQuery` para obtener los datos y rellenar el formulario de edición.

-   **🗑️ Eliminación Segura con `SweetAlert2`**
    -   **Descripción:** Antes de borrar una carrera, se muestra una alerta de confirmación elegante y clara para prevenir eliminaciones accidentales.
    -   **Tecnología:** Se utiliza la librería `SweetAlert2` para una mejor experiencia de usuario.

### 🗂️ Módulos de Categorías y Modalidades

Estos módulos permiten clasificar las carreras, y sus datos se utilizan para poblar los menús desplegables en el formulario de registro de carreras.

-   **CRUD Completo:** Ambos módulos cuentan con funcionalidades para crear, leer, actualizar y eliminar registros.
-   **Interfaz Consistente:** Utilizan la misma estructura de tablas interactivas, edición en modal y eliminación segura que los otros módulos.

---

## 🛠️ Stack Tecnológico

A continuación se detallan las tecnologías clave utilizadas para construir este sistema:

-   **Backend (Lógica del Servidor):**
    -   **PHP (8.1+):** Lenguaje de programación principal.
    -   **CodeIgniter 4:** Framework que proporciona la estructura MVC, seguridad y herramientas para un desarrollo rápido.

-   **Frontend (Lo que ve el usuario):**
    -   **HTML5, CSS3, JavaScript:** La base de cualquier sitio web moderno.
    -   **Bootstrap 5:** Framework CSS para un diseño atractivo y adaptable a cualquier dispositivo (móvil, tablet, escritorio).
    -   **jQuery:** Librería de JavaScript que simplifica la manipulación de la página y las llamadas AJAX.

-   **Base de Datos:**
    -   **MySQL / MariaDB:** Sistema utilizado para almacenar toda la información de forma persistente.

-   **Librerías de JavaScript (para mejorar la experiencia):**
    -   **DataTables.js:** Transforma las tablas de datos estáticas en componentes interactivos con búsqueda, paginación y ordenamiento.
    -   **SweetAlert2:** Reemplaza las alertas aburridas del navegador por notificaciones y diálogos de confirmación modernos y elegantes.

-   **Gestión de Dependencias:**
    -   **Composer:** Herramienta para instalar y gestionar todas las librerías y paquetes del lado del servidor (PHP).

---

## 🏛️ Arquitectura y Decisiones de Diseño

El proyecto sigue el patrón **Modelo-Vista-Controlador (MVC)** para una clara separación de responsabilidades.

-   **Modelos (`app/Models/`)**: Centralizan toda la lógica de negocio y la interacción con la base de datos. Contienen las **reglas de validación**, asegurando la integridad de los datos desde una única fuente.
-   **Vistas (`app/Views/`)**: Responsables de la presentación (HTML). Renderizan los datos proporcionados por los controladores y utilizan la función `esc()` para prevenir ataques XSS.
-   **Controladores (`app/Controllers/`)**: Actúan como intermediarios, reciben peticiones, interactúan con los modelos y cargan las vistas correspondientes.

### 🗃️ Gestión de la Base de Datos

-   **Migraciones**: La estructura completa de la base de datos está definida en código a través de los archivos de migración en `app/Database/Migrations/`. Esto permite construir el esquema de forma automática y versionarlo junto con el código.
-   **Seeders**: Se utilizan para poblar la base de datos con datos iniciales de prueba (`app/Database/Seeds/`). Esto es crucial para el desarrollo y las pruebas, permitiendo tener un estado consistente de la base de datos con un solo comando.

---

## 🔒 Características de Seguridad

La seguridad ha sido una prioridad durante el desarrollo.

-   **Protección CSRF (Cross-Site Request Forgery)**: Habilitada globalmente y aplicada en todos los formularios. Previene que un sitio malicioso pueda realizar acciones en nombre de un usuario autenticado.
-   **Prevención de Inyección SQL**: Se utiliza exclusivamente el **Query Builder y los Modelos de CodeIgniter**. El framework se encarga de escapar automáticamente todas las entradas, eliminando este riesgo.
-   **Prevención de XSS (Cross-Site Scripting)**: Todos los datos que se imprimen en las vistas se pasan a través de la función `esc()` de CodeIgniter, que neutraliza cualquier código malicioso que se haya intentado inyectar.

---

## ⚙️ Guía de Instalación Local

Sigue estos pasos para ejecutar el proyecto en tu entorno de desarrollo local.

1.  **Clonar el repositorio:**
    ```bash
    git clone <URL_DEL_REPOSITORIO> instituto_57
    cd instituto_57
    ```

2.  **Instalar dependencias de PHP:**
    ```bash
    composer install
    ```

3.  **Configurar el entorno:**
    Copia el archivo `env` y renómbralo a `.env`. Luego, edita el archivo `.env` para configurar tu base de datos.
    ```dotenv
    # .env
    CI_ENVIRONMENT = development
    
    database.default.hostname = localhost
    database.default.database = base_instituto
    database.default.username = root
    database.default.password = 
    ```

4.  **Crear la base de datos:**
    Asegúrate de haber creado una base de datos vacía llamada `base_instituto` en tu gestor de base de datos (ej: phpMyAdmin, TablePlus).

5.  **Ejecutar las Migraciones:**
    Este comando creará todas las tablas en tu base de datos con la estructura correcta.
    ```bash
    php spark migrate
    ```

6.  **Poblar la base de datos:**
    Este comando llenará las tablas con datos de ejemplo (categorías, modalidades, carreras, etc.).
    ```bash
    php spark db:seed
    ```

7.  **Iniciar el servidor de desarrollo:**
    ```bash
    php spark serve
    ```
    La aplicación estará disponible en `http://localhost:8080`.

---

## ⚡ Comandos Útiles de Spark

-   `php spark serve`: Inicia el servidor de desarrollo.
-   `php spark migrate`: Aplica las migraciones pendientes a la base de datos.
-   `php spark migrate:refresh`: Elimina todas las tablas y vuelve a ejecutar todas las migraciones (ideal para empezar de cero).
-   `php spark db:seed`: Ejecuta el seeder principal (`DatabaseSeeder`) para poblar la base de datos.
-   `php spark test`: Ejecuta el conjunto de pruebas automatizadas.

---

<div align="center">
  <p>Desarrollado con ❤️ y mucho ☕</p>
</div>
