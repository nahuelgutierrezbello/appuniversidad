<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table      = 'Rol';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre_rol'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'nombre_rol' => 'required|min_length[2]|max_length[20]|is_unique[Rol.nombre_rol,id,{id}]',
    ];

    protected $validationMessages = [
        'nombre_rol' => [
            'is_unique' => 'El nombre del rol ya existe.',
        ],
    ];
}
