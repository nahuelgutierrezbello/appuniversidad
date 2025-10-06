# Guía Técnica: Sistema de Vistas Dinámicas

Este documento detalla la arquitectura y el flujo de funcionamiento del sistema de carga de contenido dinámico para la sección "Oferta Académica" de la aplicación.

## 1. Visión General

El objetivo de este sistema es proporcionar una experiencia de usuario fluida, similar a una *Single-Page Application (SPA)*, donde el contenido de las carreras se puede visualizar sin necesidad de recargar la página completa. Esto se logra mediante el uso de **AJAX** para solicitar vistas parciales al servidor y **JavaScript (jQuery)** para inyectar ese contenido en la página principal.

---

## 2. Componentes Clave

La funcionalidad se basa en la interacción de cuatro componentes principales:

### a. Vistas (Archivos `.php` en `app/Views/`)

-   **`templates/layout.php`**: Es la plantilla principal que define la estructura de la página (cabecera, barra de navegación, pie de página).
-   **`index.php`**: Es el contenido principal de la página de inicio. Incluye la plantilla `oferta_academica.php`.
-   **`templates/oferta_academica.php`**: Actúa como el contenedor principal. Contiene un `div` con `id="careers"` que es donde se inyectará todo el contenido dinámico.
-   **`templates/oferta_academica_default.php`**: Es la vista inicial que se carga dentro de `#careers`. Muestra la grilla con todas las tarjetas de las carreras.
-   **`ciencia_datos.php`, `profesorado_matematica.php`, etc.**: Son "vistas parciales". Contienen únicamente el HTML del detalle de una carrera específica.

### b. Rutas (`app/Config/Routes.php`)

Se definen rutas específicas para que el servidor sepa cómo responder a las peticiones de AJAX. Cada ruta apunta a un método en el `AjaxController`.

```php
// --- RUTAS PARA CARGA DE CONTENIDO DINÁMICO (AJAX) ---
$routes->get('ajax/oferta_academica_default', 'AjaxController::oferta_academica_default');
$routes->get('ajax/ciencia_datos', 'AjaxController::ciencia_datos');
$routes->get('ajax/profesorado_matematica', 'AjaxController::profesorado_matematica');
// ... y así para todas las demás carreras.
```

### c. Controlador (`app/Controllers/AjaxController.php`)

Este controlador está dedicado exclusivamente a responder las peticiones de AJAX. Sus métodos son muy simples: solo cargan y devuelven el contenido de una vista parcial.

```php
namespace App\Controllers;

class AjaxController extends BaseController
{
    // Devuelve la vista de detalle de Ciencia de Datos
    public function ciencia_datos()
    {
        return view('ciencia_datos');
    }

    // Devuelve la vista de detalle de Profesorado de Matemática
    public function profesorado_matematica()
    {
        return view('profesorado_matematica');
    }

    // ... etc.
}
```

### d. JavaScript (`public/app.js`)

Este archivo es el cerebro de toda la operación. Contiene la lógica para interceptar los clics, realizar las llamadas AJAX y manipular el DOM.

-   **Manejador de Eventos Genérico**: Escucha los clics en cualquier enlace cuyo `id` termine en `-link` (como los del menú) o empiece con `ver-detalle-` (como los de las tarjetas).

    ```javascript
    $('body').on('click', 'a[id$="-link"], a[id^="ver-detalle-"]', function(e) {
        // ... lógica para determinar la URL ...
        cargarContenidoCarrera(url);
    });
    ```

-   **Función `cargarContenidoCarrera(url)`**: Es la función principal que se encarga de todo el proceso de carga.

    ```javascript
    function cargarContenidoCarrera(url, containerSelector = '#careers') {
        const contentContainer = $(containerSelector);

        // ... efectos visuales ...

        $.ajax({
            url: `${BASE_URL}${url}`, // Ej: http://localhost/app/public/ajax/ciencia_datos
            type: 'GET',
            success: function(response) {
                // Inyecta el HTML recibido en el contenedor #careers
                contentContainer.html(response); 
                // ... más lógica ...
            },
            error: function() {
                // Maneja errores
            }
        });
    }
    ```

---

## 3. Flujo de Ejecución (Paso a Paso)

1.  **Clic del Usuario**: El usuario hace clic en el enlace "Profesorado de Matemática" en la barra de navegación. El `id` de este enlace es `profesorado-matematica-link`.

2.  **Captura del Evento (JavaScript)**: El manejador de eventos en `app.js` detecta el clic porque el `id` coincide con el selector `a[id$="-link"]`.

3.  **Determinación de la URL**: El script analiza el `id` del enlace y determina que la URL de AJAX correspondiente es `ajax/profesorado_matematica`.

4.  **Llamada a la Función**: Se invoca a `cargarContenidoCarrera('ajax/profesorado_matematica')`.

5.  **Petición AJAX**: La función `cargarContenidoCarrera` realiza una petición `GET` a la URL completa: `http://tu-sitio.com/public/ajax/profesorado_matematica`.

6.  **Enrutamiento (Backend)**: El archivo `Routes.php` de CodeIgniter recibe la petición y, al encontrar una coincidencia, la dirige al método `profesorado_matematica()` del `AjaxController`.

7.  **Respuesta del Controlador**: El controlador ejecuta `return view('profesorado_matematica');`. CodeIgniter renderiza el archivo `profesorado_matematica.php` y devuelve su contenido HTML como respuesta a la petición AJAX.

8.  **Actualización de la Vista (JavaScript)**: De vuelta en el navegador, la función `success` del AJAX recibe el HTML de la vista. Con la línea `contentContainer.html(response)`, reemplaza todo el contenido del `div` con `id="careers"` por la nueva vista de detalle de la carrera.

9.  **Finalización**: Se añaden efectos de `fadeIn`, se inicializan las animaciones `AOS` para el nuevo contenido y se añade dinámicamente el botón "Volver Arriba". El usuario ve la página de la carrera sin que la URL del navegador cambie ni la página se recargue.m