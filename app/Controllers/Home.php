<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Controllers;

// Define la clase 'Home' que hereda de 'BaseController'.
// Al heredar de BaseController, automáticamente tiene acceso a servicios como la sesión.
class Home extends BaseController
{
    /**
     * El método index() es el método por defecto que se ejecuta cuando un usuario
     * visita la ruta raíz del sitio ('/').
     * @return string Devuelve el contenido HTML de la vista renderizada.
     */
    public function index(): string // Devuelve el contenido HTML de la vista renderizada
    {
        // FORZAMOS LA ESTRUCTURA CORRECTA
        // 1. Prepara los datos que se pasarán a la plantilla principal.
        // 2. Le decimos que el contenido principal ('content') será la vista 'index.php'.
        $data['page_content'] = view('index');
        // 3. Cargamos la plantilla 'layout.php' y le pasamos el contenido.
        return view('templates/layout', $data);
    }
}
