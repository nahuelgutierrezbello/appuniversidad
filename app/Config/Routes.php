<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(); 

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes

 */

// --- RUTAS PRINCIPALES DE VISTAS ---
// Estas rutas se encargan de mostrar las páginas principales de cada módulo.

$routes->get('/', 'Home::index'); // Muestra la página de inicio institucional.
$routes->get('/home/index', 'Home::index');     // Alias para la página de inicio.
$routes->get('/estudiantes', 'Estudiantes::index'); // Muestra el portal de gestión de estudiantes.
$routes->get('/registrarCarrera', 'RegistrarCarrera::index'); // Muestra el portal de gestión de carreras.
$routes->get('categorias', 'Categorias::index'); // Muestra el portal de gestión de categorías.

// --- RUTAS PARA EL CRUD DE ESTUDIANTES ---
// Definen las acciones para crear, leer, actualizar y borrar estudiantes.

$routes->post('estudiantes/registrar', 'Estudiantes::registrar'); // Procesa el formulario para crear un nuevo estudiante.
$routes->get('estudiantes/edit/(:num)', 'Estudiantes::edit/$1'); // Obtiene datos de un estudiante para el modal de edición (AJAX). (:num) es un placeholder para un número (el ID).
$routes->post('estudiantes/update/(:num)', 'Estudiantes::update/$1'); // Procesa el formulario para actualizar un estudiante.
$routes->post('estudiantes/delete/(:num)', 'Estudiantes::delete/$1'); // Procesa la petición para eliminar un estudiante. Se usa POST por seguridad.
$routes->get('estudiantes/search/(:num)', 'Estudiantes::search/$1'); // Busca un estudiante por ID (AJAX).
$routes->get('estudiantes/search/carrera/(:num)', 'Estudiantes::searchByCareer/$1'); // Busca todos los estudiantes de una carrera (AJAX).

// --- RUTAS PARA EL CRUD DE CATEGORÍAS ---
// Definen las acciones para el módulo de categorías.

$routes->post('categorias/registrar', 'Categorias::registrar'); // Procesa el formulario para crear una nueva categoría.
$routes->get('categorias/edit/(:num)', 'Categorias::edit/$1'); // Obtiene datos de una categoría para el modal de edición (AJAX).
$routes->post('categorias/update/(:num)', 'Categorias::update/$1'); // Procesa el formulario para actualizar una categoría.
$routes->post('categorias/delete/(:num)', 'Categorias::delete/$1'); // Procesa la petición para eliminar una categoría.
$routes->get('categorias/search/(:num)', 'Categorias::search/$1'); // Busca una categoría por ID (AJAX).

// --- RUTAS PARA EL CRUD DE CARRERAS ---
// Definen las acciones para el módulo de carreras.

$routes->post('registrarCarrera/registrar', 'RegistrarCarrera::registrar'); // Procesa el formulario para crear una nueva carrera.
$routes->get('registrarCarrera/edit/(:num)', 'RegistrarCarrera::edit/$1'); // Obtiene datos de una carrera para el modal de edición (AJAX).
$routes->post('registrarCarrera/update/(:num)', 'RegistrarCarrera::update/$1'); // Procesa el formulario para actualizar una carrera.
$routes->post('registrarCarrera/delete/(:num)', 'RegistrarCarrera::delete/$1'); // Procesa la petición para eliminar una carrera.
$routes->get('registrarCarrera/search/(:num)', 'RegistrarCarrera::search/$1'); // Busca una carrera por ID (AJAX).

// Ruta especial para la generación de código de carrera en tiempo real (AJAX).
// (:segment) es un placeholder para cualquier caracter en la URL (el nombre de la carrera).
$routes->get('registrarCarrera/generar-codigo/(:segment)', 'RegistrarCarrera::generarCodigoAjax/$1');
