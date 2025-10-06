# Explicación del Manejo de Vistas, Templates y JavaScript en la Aplicación

## Introducción

Esta aplicación utiliza un enfoque modular para manejar la presentación y la interacción del usuario, basado en vistas, templates y JavaScript. El objetivo principal es permitir la carga dinámica de contenido sin recargar toda la página, mejorando la experiencia del usuario y facilitando el mantenimiento del código.

## Estructura de Vistas

### Vista Principal (`app/Views/index.php`)

Esta es la vista principal de la página de inicio. Incluye:

- La plantilla `oferta_academica.php` que contiene el contenedor donde se carga dinámicamente el contenido de las carreras.
- Secciones estáticas como "Vida Estudiantil" y "Contáctanos".

La vista principal no incluye directamente el header, navbar o footer, ya que estos se manejan automáticamente por el layout general de la aplicación.

### Vistas Parciales

- `ciencia_datos.php`: Vista específica para la carrera de Ciencia de Datos.
- `programacion_web_content.php`: Vista específica para la carrera de Programación Web.
- `oferta_academica_default.php`: Vista por defecto que muestra la lista general de carreras.

Estas vistas son fragmentos de HTML que se cargan dinámicamente en el contenedor `#careers`.

## Templates

Los templates son plantillas reutilizables que estructuran partes comunes de la aplicación:

- `oferta_academica.php`: Contenedor principal para la sección de oferta académica. Incluye el div `#careers` donde se carga el contenido dinámico.
- `Navbar.php`: Barra de navegación con enlaces a las diferentes carreras.
- `footer.php`: Pie de página.
- `head.php`: Encabezado HTML con enlaces a CSS y JavaScript.

El layout general (`layout.php`) combina estos templates automáticamente para cada página, evitando duplicaciones.

## Controlador AJAX (`AjaxController.php`)

Este controlador maneja las peticiones AJAX para cargar contenido dinámico:

- `ciencia_datos()`: Devuelve la vista `ciencia_datos.php`.
- `programacion_web()`: Devuelve la vista `programacion_web_content.php`.
- `oferta_academica_default()`: Devuelve la vista `oferta_academica_default.php`.

Las rutas están definidas en `app/Config/Routes.php`:

```php
$routes->get('ajax/ciencia_datos', 'AjaxController::ciencia_datos');
$routes->get('ajax/programacion_web', 'AjaxController::programacion_web');
$routes->get('ajax/oferta_academica_default', 'AjaxController::oferta_academica_default');
```

## JavaScript (`public/app.js`)

El archivo `public/app.js` contiene toda la lógica del lado cliente:

### Función Principal: `cargarContenidoCarrera(url)`

Esta función reutilizable carga contenido dinámicamente vía AJAX:

```javascript
function cargarContenidoCarrera(url) {
    const contentContainer = $('#careers');
    contentContainer.addClass('loading-content');
    contentContainer.fadeOut(200, function() {
        $.ajax({
            url: `${BASE_URL}${url}`,
            type: 'GET',
            success: function(response) {
                contentContainer.html(response).removeClass('loading-content').fadeIn(300);
                AOS.init({ once: false });
            },
            error: function() {
                contentContainer.html('<p class="text-center text-danger">Error al cargar el contenido.</p>').removeClass('loading-content').fadeIn(300);
            }
        });
    });
}
```

### Eventos de Clic

Se usan eventos delegados para manejar clics en enlaces del navbar:

```javascript
$('body').on('click', '#ciencia-datos-link, #ver-detalle-ciencia-datos', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('.navbar-collapse').collapse('hide');
    cargarContenidoCarrera('ajax/ciencia_datos');
});
```

### Otras Funcionalidades

- Gestión de estudiantes, carreras y categorías con AJAX.
- Generación de códigos de carrera en tiempo real.
- Manejo de mensajes flash de éxito/error.
- Confirmaciones de eliminación con SweetAlert.

## Flujo de Carga Dinámica

1. El usuario hace clic en "Ciencia de Datos" en el navbar.
2. Se dispara el evento click en `public/app.js`.
3. Se llama a `cargarContenidoCarrera('ajax/ciencia_datos')`.
4. Se realiza una petición AJAX a `http://localhost:8080/ajax/ciencia_datos`.
5. El `AjaxController` devuelve la vista `ciencia_datos.php`.
6. El contenido se inserta en el div `#careers` con efectos de fade.
7. Se reinicializan las animaciones AOS para el nuevo contenido.

## Beneficios del Enfoque

- **Experiencia de Usuario Mejorada**: Carga rápida sin recargas completas de página.
- **Mantenimiento Simplificado**: Separación clara entre presentación, lógica y datos.
- **Escalabilidad**: Fácil agregar nuevas carreras o secciones dinámicas.
- **Reutilización**: Templates y funciones JavaScript reutilizables.
- **Rendimiento**: Solo se carga el contenido necesario.

Este patrón modular permite una aplicación flexible y fácil de mantener, donde cada componente tiene una responsabilidad clara.
