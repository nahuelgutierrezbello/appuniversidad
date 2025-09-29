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
        // Carga y devuelve la vista ubicada en 'app/Views/index.php'.
        return view('index');
    }
}
