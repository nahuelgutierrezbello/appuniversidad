<?php

namespace App\Models;
use CodeIgniter\Model;

class ConsultaAdminModel extends Model
{
    protected $table = 'consultas_admin';
    protected $primaryKey = 'id_consulta';
    protected $allowedFields = ['email_usuario', 'mensaje', 'asunto', 'estado', 'fecha_creacion'];
}
