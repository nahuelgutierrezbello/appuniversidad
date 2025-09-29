# Informe Técnico: Arquitectura y Decisiones de Diseño

Este documento detalla la arquitectura, las decisiones técnicas y las consideraciones de rendimiento del Sistema de Gestión Académica.

## 1. Arquitectura del Proyecto

El sistema está construido sobre **CodeIgniter 4**, siguiendo estrictamente el patrón de diseño **Modelo-Vista-Controlador (MVC)** para garantizar una clara separación de responsabilidades y facilitar el mantenimiento.

-   **Modelos (`app/Models/`)**:
    -   Son los encargados de la lógica de negocio y la interacción directa con la base de datos.
    -   Cada modelo (`EstudianteModel`, `CarreraModel`, etc.) está mapeado a una tabla de la base de datos.
    -   **Centralizan las reglas de validación**, lo que previene la duplicación de código y asegura la integridad de los datos desde una única fuente de verdad.

-   **Vistas (`app/Views/`)**:
    -   Son responsables de la capa de presentación (el HTML que ve el usuario).
    -   Utilizan una combinación de **Bootstrap 5** para el diseño responsivo y PHP para renderizar los datos proporcionados por los controladores.
    -   Se ha hecho un uso extensivo de la función `esc()` de CodeIgniter en toda la salida de datos para **prevenir ataques de Cross-Site Scripting (XSS)**.

-   **Controladores (`app/Controllers/`)**:
    -   Actúan como intermediarios entre los Modelos y las Vistas.
    -   Reciben las peticiones HTTP del usuario, solicitan los datos necesarios a los Modelos, procesan la información y finalmente cargan la Vista adecuada, pasándole los datos que necesita mostrar.

## 2. Decisiones de Diseño Clave

Se tomaron varias decisiones para mejorar la experiencia del usuario (UX) y la robustez del sistema.

-   **Frontend Dinámico con AJAX**: En lugar de utilizar el enfoque tradicional de recarga de página para cada acción, se optó por una interfaz de aplicación de página única (SPA-like) mediante **jQuery y AJAX**. Esto se aplica en:
    -   **Edición en Modales**: Al editar un registro, los datos se cargan dinámicamente en una ventana modal, proporcionando una experiencia fluida.
    -   **Búsquedas Instantáneas**: Las funciones de búsqueda por ID o por carrera consultan al servidor en segundo plano y muestran los resultados sin necesidad de recargar la página.

-   **Librerías de Frontend**:
    -   **DataTables.js**: Se integró para transformar las tablas HTML estáticas en componentes interactivos con paginación, búsqueda en tiempo real y ordenamiento del lado del cliente.
    -   **SweetAlert2**: Se utiliza para todas las notificaciones (éxito, error) y diálogos de confirmación (borrado), ofreciendo una estética mucho más profesional que las alertas nativas del navegador.

-   **Seguridad**:
    -   **Protección CSRF**: Habilitada globalmente en `app/Config/Filters.php` y aplicada en todos los formularios con `csrf_field()`. Esto protege la aplicación contra ataques de falsificación de petición en sitios cruzados.
    -   **Prevención de Inyección SQL**: Se utiliza exclusivamente el **Query Builder y los Modelos de CodeIgniter** para todas las interacciones con la base de datos. El framework se encarga de escapar automáticamente todas las entradas, eliminando el riesgo de inyección SQL.

## 3. Rendimiento y Índices de la Base de Datos

Para garantizar que las consultas a la base de datos sean rápidas y eficientes, incluso con un gran volumen de datos, se ha prestado especial atención a la creación de **índices**.

Un índice de base de datos funciona como el índice de un libro: permite al motor de la base de datos encontrar filas específicas muy rápidamente sin tener que leer toda la tabla ("Full Table Scan").

En este proyecto, los índices se definen directamente en las **migraciones** (`app/Database/Migrations/`):

-   **Claves Primarias (`PRIMARY KEY`)**: `id_est`, `id_car`, etc. Son indexadas automáticamente y garantizan la búsqueda más rápida posible por ID.
-   **Claves Únicas (`UNIQUE KEY`)**: Campos como `dni` en `Estudiante` y `codcar` en `Carrera`. Además de asegurar que no haya datos duplicados, crean un índice de alto rendimiento que acelera las búsquedas y las validaciones `is_unique`.
-   **Claves Foráneas (`FOREIGN KEY`)**: Campos como `id_car` en la tabla `Estudiante`. CodeIgniter y MySQL también crean índices en estas columnas para optimizar las operaciones de `JOIN`.

### Ejemplo de `EXPLAIN ANALYZE`

`EXPLAIN ANALYZE` es un comando de base de datos que no solo muestra el plan de ejecución de una consulta, sino que también la ejecuta y mide los tiempos reales. Es la herramienta fundamental para diagnosticar consultas lentas.

Si ejecutamos una consulta para buscar un estudiante por su DNI, podemos confirmar que se está utilizando el índice `dni`:

**Consulta:**
```sql
EXPLAIN ANALYZE SELECT * FROM estudiante WHERE dni = '12345678';
```

**Resultado Esperado (Conceptual):**

El plan de ejecución mostrará que se realiza un `-> Index lookup on estudiante using dni...` (búsqueda por índice), lo que confirma que la consulta es extremadamente eficiente y no requiere un escaneo completo de la tabla. El costo (`cost=...`) y el tiempo de ejecución (`actual time=...`) serán muy bajos.

*(Aquí se podría adjuntar una imagen con el resultado real de la consulta en una herramienta como phpMyAdmin o DBeaver para una demostración visual).*

!Ejemplo de EXPLAIN ANALYZE