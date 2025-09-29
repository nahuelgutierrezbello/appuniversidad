<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Models;
// Importa la clase base 'Model' de CodeIgniter.
use CodeIgniter\Model;

// Define la clase 'CategoriaModel' que se encarga de toda la interacción con la tabla 'Categoria'.
class CategoriaModel extends Model
{
    // --- Propiedades de Configuración del Modelo ---

    // Especifica la tabla de la base de datos que este modelo representa.
    protected $table      = 'Categoria';
    // Especifica el nombre de la columna que es la clave primaria.
    protected $primaryKey = 'id_cat';
    // Define los campos que se pueden insertar o actualizar masivamente.
    protected $allowedFields = ['id_cat', 'codcat','ncat'];
    // Desactiva los campos de timestamp automáticos ('created_at', 'updated_at').
    protected $useTimestamps = false;

    // Define las reglas de validación que se aplicarán antes de guardar o actualizar.
    protected $validationRules = [
        // 'id_cat' no es requerido para la creación.
        'id_cat' => 'permit_empty|integer', // Cambiado a permit_empty para permitir la creación
        // 'codcat' es obligatorio, único en la tabla (ignorando el registro actual en una actualización), y con un máximo de 20 caracteres.
        'codcat' => 'required|is_unique[Categoria.codcat,id_cat,{id_cat}]|max_length[20]',
        // 'ncat' es obligatorio, con una longitud entre 2 y 120 caracteres.
        'ncat'   => 'required|min_length[2]|max_length[120]',
    ];
    // Define mensajes de error personalizados para las reglas de validación.
    protected $validationMessages = [
        'codcat' => [
            'is_unique'=>'El código de categoría ya existe.'
        ]
    ];
}