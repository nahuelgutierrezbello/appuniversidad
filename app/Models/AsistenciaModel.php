<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo para interactuar con la tabla 'Asistencia'.
 */
class AsistenciaModel extends Model
{
    protected $table      = 'Asistencia';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'estudiante_id', 'materia_id', 'fecha', 'estado', 'observaciones', 'inscripcion_id'];
    protected $useTimestamps = false;
    protected $validationRules = [
        'estudiante_id' => 'required|integer',
        'materia_id' => 'required|integer',
        'fecha' => 'required|valid_date',
        'estado' => 'required|in_list[Presente,Ausente,Tarde]',
    ];
    protected $validationMessages = [
        'estado' => [
            'in_list' => 'El estado debe ser Presente, Ausente o Tarde.'
        ],
        'fecha' => [
            'valid_date' => 'La fecha debe ser una fecha válida.'
        ],
    ];

    /**
     * Método: getAsistenciaPorFecha($materia_id, $start, $end)
     * Propósito: Obtiene la asistencia agrupada por fecha para una materia en un rango de fechas.
     * @param int $materia_id El ID de la materia.
     * @param string $start Fecha de inicio.
     * @param string $end Fecha de fin.
     * @return array
     */
    public function getAsistenciaPorFecha($materia_id, $start, $end)
    {
        return $this->select('fecha, 
                             SUM(CASE WHEN estado = "Presente" THEN 1 ELSE 0 END) as presentes,
                             SUM(CASE WHEN estado = "Ausente" THEN 1 ELSE 0 END) as ausentes,
                             SUM(CASE WHEN estado = "Tarde" THEN 1 ELSE 0 END) as justificados')
                   ->where('materia_id', $materia_id)
                   ->where('fecha >=', $start)
                   ->where('fecha <=', $end)
                   ->groupBy('fecha')
                   ->orderBy('fecha', 'ASC')
                   ->findAll();
    }

    /**
     * Método: getEstadisticasMes($materia_id)
     * Propósito: Obtiene las estadísticas del mes actual para una materia.
     * @param int $materia_id El ID de la materia.
     * @return array
     */
    public function getEstadisticasMes($materia_id)
    {
        $mes_actual = date('Y-m');

        return $this->select('
                        COUNT(*) as total_clases,
                        SUM(CASE WHEN estado = "Presente" THEN 1 ELSE 0 END) as total_presentes,
                        SUM(CASE WHEN estado = "Ausente" THEN 1 ELSE 0 END) as total_ausentes,
                        SUM(CASE WHEN estado = "Tarde" THEN 1 ELSE 0 END) as total_tarde,
                        ROUND((SUM(CASE WHEN estado = "Presente" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as porcentaje_presentes,
                        ROUND((SUM(CASE WHEN estado = "Ausente" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as porcentaje_ausentes,
                        ROUND((SUM(CASE WHEN estado = "Tarde" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as porcentaje_tarde')
                   ->where('materia_id', $materia_id)
                   ->where('DATE_FORMAT(fecha, "%Y-%m")', $mes_actual)
                   ->first();
    }

    /**
     * Método: getResumenPorEstudiante($materia_id)
     * Propósito: Obtiene el resumen de asistencia por estudiante para una materia.
     * @param int $materia_id El ID de la materia.
     * @return array
     */
    public function getResumenPorEstudiante($materia_id)
    {
        return $this->select('estudiante.nombre_estudiante, estudiante.apellido_estudiante,
                             COUNT(*) as total_clases,
                             SUM(CASE WHEN Asistencia.estado = "Presente" THEN 1 ELSE 0 END) as presentes,
                             SUM(CASE WHEN Asistencia.estado = "Ausente" THEN 1 ELSE 0 END) as ausentes,
                             SUM(CASE WHEN Asistencia.estado = "Tarde" THEN 1 ELSE 0 END) as tarde,
                             ROUND((SUM(CASE WHEN Asistencia.estado = "Presente" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as porcentaje_asistencia')
                   ->join('estudiante', 'estudiante.id = Asistencia.estudiante_id')
                   ->where('Asistencia.materia_id', $materia_id)
                   ->groupBy('Asistencia.estudiante_id')
                   ->orderBy('estudiante.apellido_estudiante', 'ASC')
                   ->findAll();
    }

    /**
     * Método: getAsistenciasMensuales($materia_id, $mes, $anio)
     * Propósito: Obtiene todas las asistencias de un mes específico para una materia.
     * @param int $materia_id El ID de la materia.
     * @param int $mes El mes (1-12).
     * @param int $anio El año.
     * @return array
     */
    public function getAsistenciasMensuales($materia_id, $mes, $anio)
    {
        $fechaInicio = sprintf('%04d-%02d-01', $anio, $mes);
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        return $this->where('materia_id', $materia_id)
                   ->where('fecha >=', $fechaInicio)
                   ->where('fecha <=', $fechaFin)
                   ->findAll();
    }

    /**
     * Método: getEstudiantesConAsistencia($materia_id, $mes, $anio)
     * Propósito: Obtiene estudiantes inscritos en una materia con su asistencia mensual.
     * @param int $materia_id El ID de la materia.
     * @param int $mes El mes (1-12).
     * @param int $anio El año.
     * @return array
     */
    public function getEstudiantesConAsistencia($materia_id, $mes, $anio)
    {
        $fechaInicio = sprintf('%04d-%02d-01', $anio, $mes);
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        // Obtener estudiantes inscritos
        $estudiantes = $this->db->table('Inscripcion')
            ->select('Estudiante.id, Estudiante.nombre_estudiante, Estudiante.apellido_estudiante')
            ->join('Estudiante', 'Estudiante.id = Inscripcion.estudiante_id')
            ->where('Inscripcion.materia_id', $materia_id)
            ->where('Inscripcion.estado_inscripcion', 'Activa')
            ->orderBy('Estudiante.apellido_estudiante', 'ASC')
            ->get()
            ->getResultArray();

        // Para cada estudiante, obtener su asistencia del mes
        foreach ($estudiantes as &$estudiante) {
            $asistencias = $this->where('estudiante_id', $estudiante['id'])
                               ->where('materia_id', $materia_id)
                               ->where('fecha >=', $fechaInicio)
                               ->where('fecha <=', $fechaFin)
                               ->findAll();

            // Crear array de asistencia por fecha
            $asistenciaPorFecha = [];
            foreach ($asistencias as $asistencia) {
                $dia = date('j', strtotime($asistencia['fecha']));
                $asistenciaPorFecha[$dia] = $asistencia['estado'];
            }

            $estudiante['asistencia'] = $asistenciaPorFecha;
        }

        return $estudiantes;
    }

    /**
     * Método: guardarAsistenciasMensuales($materia_id, $asistencias)
     * Propósito: Guarda múltiples asistencias para un mes.
     * @param int $materia_id El ID de la materia.
     * @param array $asistencias Array de asistencias a guardar.
     * @return bool
     */
    public function guardarAsistenciasMensuales($materia_id, $asistencias)
    {
        $this->db->transStart();

        foreach ($asistencias as $asistencia) {
            $fecha = $asistencia['fecha'];
            $estudiante_id = $asistencia['estudiante_id'];
            $estado = $asistencia['estado'];

            // Verificar si ya existe
            $existing = $this->where('estudiante_id', $estudiante_id)
                           ->where('materia_id', $materia_id)
                           ->where('fecha', $fecha)
                           ->first();

            if ($existing) {
                // Actualizar
                $this->update($existing['id'], [
                    'estado' => $estado,
                    'observaciones' => $asistencia['observaciones'] ?? ''
                ]);
            } else {
                // Insertar
                $this->insert([
                    'estudiante_id' => $estudiante_id,
                    'materia_id' => $materia_id,
                    'fecha' => $fecha,
                    'estado' => $estado,
                    'observaciones' => $asistencia['observaciones'] ?? ''
                ]);
            }
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Método: getEstadisticasMensuales($materia_id, $mes, $anio)
     * Propósito: Obtiene estadísticas de asistencia para un mes específico.
     * @param int $materia_id El ID de la materia.
     * @param int $mes El mes (1-12).
     * @param int $anio El año.
     * @return array
     */
    public function getEstadisticasMensuales($materia_id, $mes, $anio)
    {
        $fechaInicio = sprintf('%04d-%02d-01', $anio, $mes);
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        $result = $this->select('
                        COUNT(*) as total_registros,
                        SUM(CASE WHEN estado = "Presente" THEN 1 ELSE 0 END) as total_presentes,
                        SUM(CASE WHEN estado = "Ausente" THEN 1 ELSE 0 END) as total_ausentes,
                        SUM(CASE WHEN estado = "Tarde" THEN 1 ELSE 0 END) as total_tarde,
                        COUNT(DISTINCT estudiante_id) as total_estudiantes,
                        COUNT(DISTINCT fecha) as total_dias_clase')
                   ->where('materia_id', $materia_id)
                   ->where('fecha >=', $fechaInicio)
                   ->where('fecha <=', $fechaFin)
                   ->first();

        if ($result) {
            $result['porcentaje_presentes'] = $result['total_registros'] > 0 ?
                round(($result['total_presentes'] / $result['total_registros']) * 100, 1) : 0;
            $result['porcentaje_ausentes'] = $result['total_registros'] > 0 ?
                round(($result['total_ausentes'] / $result['total_registros']) * 100, 1) : 0;
            $result['porcentaje_tarde'] = $result['total_registros'] > 0 ?
                round(($result['total_tarde'] / $result['total_registros']) * 100, 1) : 0;
        }

        return $result ?: [
            'total_registros' => 0,
            'total_presentes' => 0,
            'total_ausentes' => 0,
            'total_tarde' => 0,
            'total_estudiantes' => 0,
            'total_dias_clase' => 0,
            'porcentaje_presentes' => 0,
            'porcentaje_ausentes' => 0,
            'porcentaje_tarde' => 0
        ];
    }
}
