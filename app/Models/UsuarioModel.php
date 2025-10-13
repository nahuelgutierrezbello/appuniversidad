<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'Usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['usuario', 'password', 'fecha_registro', 'fecha_ultimo_ingreso', 'rol_id', 'activo'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'usuario' => 'required|min_length[3]|max_length[50]|is_unique[Usuarios.usuario,id,{id}]',
        'password' => 'required|min_length[6]',
        'rol_id' => 'required|integer',
        'activo' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'usuario' => [
            'is_unique' => 'El nombre de usuario ya existe.',
        ],
        'rol_id' => [
            'integer' => 'El rol debe ser un número entero.',
        ],
    ];
}
