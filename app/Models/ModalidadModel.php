<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalidadModel extends Model
{
    protected $table      = 'Modalidad';
    protected $primaryKey = 'id_mod';
    protected $allowedFields = ['id_mod', 'codigo_modalidad', 'nombre_modalidad', 'carrera_id'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'codigo_modalidad' => 'required|min_length[2]|max_length[20]|is_unique[Modalidad.codigo_modalidad,id_mod,{id_mod}]',
        'nombre_modalidad' => 'required|min_length[2]|max_length[120]',
        'carrera_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'codigo_modalidad' => [
            'is_unique' => 'El código de modalidad ya existe.',
        ],
        'carrera_id' => [
            'integer' => 'La carrera debe ser un número entero.',
        ],
    ];
}
