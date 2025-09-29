<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Models;
// Importa la clase base 'Model' de CodeIgniter.
use CodeIgniter\Model;

// Define la clase 'ModalidadModel' que se encarga de toda la interacción con la tabla 'Modalidad'.
class ModalidadModel extends Model
{
    // --- Propiedades de Configuración del Modelo ---

    // Especifica la tabla de la base de datos que este modelo representa.
    protected $table      = 'Modalidad';
    // Especifica el nombre de la columna que es la clave primaria.
    protected $primaryKey = 'id_mod';
    // Define los campos que se pueden insertar o actualizar masivamente.
    protected $allowedFields = ['id_mod', 'codmod','nmod'];
    // Desactiva los campos de timestamp automáticos ('created_at', 'updated_at').
    protected $useTimestamps = false;

    // Define las reglas de validación que se aplicarán antes de guardar o actualizar.
    protected $validationRules = [
        // 'id_mod' no es requerido para la creación.
        'id_mod' => 'permit_empty|integer',
        // 'codmod' es obligatorio, único en la tabla (ignorando el registro actual en una actualización), y con un máximo de 20 caracteres.
        'codmod' => 'required|is_unique[Modalidad.codmod,id_mod,{id_mod}]|max_length[20]',
        // 'nmod' es obligatorio, con una longitud entre 2 y 120 caracteres.
        'nmod'   => 'required|min_length[2]|max_length[120]',
    ];
    // Define mensajes de error personalizados para las reglas de validación.
    protected $validationMessages = [
        'codmod' => [
            'is_unique'=>'El código de modalidad ya existe.'
        ]
    ];
}