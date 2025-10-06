<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Ajax extends Controller
{
    public function ciencia_datos()
    {
        return view('ciencia_datos');
    }

    public function test()
    {
        return view('ajax_test');
    }

    public function programacion_web()
    {
        return view('programacion_web_content');
    }
}
