<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para interactuar con la tabla 'Nota'.
 */
class NotaModel extends Model
{
    protected $table      = 'Nota';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'estudiante_id', 'materia_id', 'calificacion', 'fecha_evaluacion', 'observaciones', 'inscripcion_id'];
    protected $useTimestamps = false;
    protected $validationRules = [
        'estudiante_id' => 'required|integer',
        'materia_id' => 'required|integer',
        'calificacion' => 'required|decimal',
        'fecha_evaluacion' => 'permit_empty|valid_date',
    ];
    protected $validationMessages = [
        'calificacion' => [
            'decimal' => 'La calificación debe ser un número decimal.'
        ],
        'fecha_evaluacion' => [
            'valid_date' => 'La fecha de evaluación debe ser una fecha válida.'
        ],
    ];

    /**
     * Obtiene las notas de una materia específica.
     * @param int $materia_id El ID de la materia.
     * @return array Devuelve un array de notas.
     */
    public function getNotasPorMateria($materia_id)
    {
        return $this->select('Nota.*, Estudiante.nombre_estudiante')
            ->join('Estudiante', 'Estudiante.id = Nota.estudiante_id')
            ->where('Nota.materia_id', $materia_id)
            ->findAll();
    }
}
