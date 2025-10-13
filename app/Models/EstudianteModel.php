<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Models;
// Importa la clase base 'Model' de CodeIgniter.
use CodeIgniter\Model;
/**
 * Modelo para interactuar con la tabla 'Estudiante'.
 * Define los campos permitidos, reglas de validación y métodos personalizados.
 */
class EstudianteModel extends Model
{
    // --- Propiedades de Configuración del Modelo ---

    // Especifica la tabla de la base de datos que este modelo representa.
    protected $table      = 'Estudiante';
    // Especifica el nombre de la columna que es la clave primaria.
    protected $primaryKey = 'id';
    // Define los campos que se pueden insertar o actualizar masivamente.
    protected $allowedFields = ['id', 'dni','nombre_estudiante','fecha_nacimiento','edad','email','carrera_id'];
    // Desactiva los campos de timestamp automáticos ('created_at', 'updated_at').
    protected $useTimestamps = false;

    // Define las reglas de validación que se aplicarán antes de guardar o actualizar.
    protected $validationRules = [
        // 'id' no es requerido para la creación.
        'id' => 'permit_empty|integer', // Cambiado a permit_empty para permitir la creación
        // 'dni' es obligatorio, debe tener exactamente 8 dígitos numéricos y ser único en la tabla.
        'dni'   => 'required|regex_match[/^[0-9]{8}$/]|is_unique[Estudiante.dni,id,{id}]',
        // 'nombre_estudiante' es obligatorio, con una longitud entre 2 y 80 caracteres.
        'nombre_estudiante'  => 'required|min_length[2]|max_length[80]',
        // 'edad' es obligatorio y debe ser un número de 1 o 2 dígitos.
        'edad'  => 'required|regex_match[/^[0-9]{1,2}$/]',
        // 'email' es obligatorio, debe ser un formato de email válido y tener un máximo de 50 caracteres.
        'email' => 'required|valid_email|max_length[50]',
    ];
    // Define mensajes de error personalizados para las reglas de validación.
    protected $validationMessages = [
        'dni' => [
            'regex_match'=>'El DNI debe tener 8 dígitos.',
            'is_unique'=>'El DNI ya existe.'
        ],
        'edad' => [
            'regex_match'=>'La edad debe ser numérica y de 1 o 2 dígitos.'
        ],
        'email' => [
            'valid_email' => 'El campo de email debe contener una dirección de correo válida.'
        ],
    ];

    // --- Métodos Personalizados ---

    /**
     * Obtiene todos los estudiantes junto con el nombre de su carrera.
     * Utiliza un 'left join' para asegurar que se muestren todos los estudiantes,
     * incluso aquellos que no están inscritos en ninguna carrera.
     * @return array
     */
    public function getEstudiantesConCarrera()
    {
        // Construye una consulta SELECT que une la tabla 'Estudiante' con 'Carrera'.
        return $this->select('Estudiante.*, Carrera.nombre_carrera')
            ->join('Carrera', 'Carrera.id = Estudiante.carrera_id', 'left') // 'left' join para incluir estudiantes sin carrera.
            ->findAll(); // Ejecuta la consulta y devuelve todos los resultados.
    }

    /**
     * Obtiene un estudiante específico por ID, junto con el nombre de su carrera.
     * @param int $id El ID del estudiante.
     * @return array|object|null Devuelve el estudiante o null si no se encuentra.
     */
    public function getEstudianteConCarrera($id)
    {
        // Construye la misma consulta que el método anterior, pero para un solo registro.
        return $this->select('Estudiante.*, Carrera.nombre_carrera')
            ->join('Carrera', 'Carrera.id = Estudiante.carrera_id', 'left')
            ->find($id); // Ejecuta la consulta y devuelve solo el registro que coincide con el ID.
    }

    /**
     * Obtiene todos los estudiantes de una carrera específica.
     * @param int $careerId El ID de la carrera.
     * @return array Devuelve un array de estudiantes.
     */
    public function getEstudiantesPorCarrera($careerId)
    {
        // Filtra los estudiantes por la columna 'carrera_id'.
        return $this->where('carrera_id', $careerId)
            ->findAll(); // Devuelve todos los estudiantes que coinciden con el filtro.
    }

    /**
     * Obtiene las notas de un estudiante específico.
     * @param int $id_est El ID del estudiante.
     * @return array Devuelve un array de notas con información de la materia.
     */
    public function getNotas($id_est)
    {
        return $this->db->table('Nota')
            ->select('Nota.*, Materia.nombre_materia')
            ->join('Materia', 'Materia.id = Nota.materia_id')
            ->where('Nota.estudiante_id', $id_est)
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene las materias inscritas de un estudiante específico.
     * @param int $id_est El ID del estudiante.
     * @return array Devuelve un array de inscripciones con información de la materia.
     */
    public function getMateriasInscritas($id_est)
    {
        return $this->db->table('Inscripcion')
            ->select('Inscripcion.*, Materia.nombre_materia, Materia.codigo_materia, Materia.id as materia_id')
            ->join('Materia', 'Materia.id = Inscripcion.materia_id')
            ->where('Inscripcion.estudiante_id', $id_est)
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene estadísticas de un estudiante específico.
     * @param int $id_est El ID del estudiante.
     * @return array Devuelve un array con promedio general, progreso, etc.
     */
    public function getEstadisticas($id_est)
    {
        // Promedio general
        $notas = $this->getNotas($id_est);
        $totalNotas = count($notas);
        $sumaNotas = 0;
        foreach ($notas as $nota) {
            $sumaNotas += $nota['calificacion'];
        }
        $promedio = $totalNotas > 0 ? round($sumaNotas / $totalNotas, 2) : 0;

        // Materias aprobadas (asumiendo >= 6)
        $aprobadas = 0;
        foreach ($notas as $nota) {
            if ($nota['calificacion'] >= 6) {
                $aprobadas++;
            }
        }

        // Total de materias inscritas
        $inscritas = $this->getMateriasInscritas($id_est);
        $totalInscritas = count($inscritas);

        // Progreso (aprobadas / total inscritas * 100)
        $progreso = $totalInscritas > 0 ? round(($aprobadas / $totalInscritas) * 100, 2) : 0;

        return [
            'promedio_general' => $promedio,
            'materias_aprobadas' => $aprobadas,
            'materias_pendientes' => $totalInscritas - $aprobadas,
            'progreso' => $progreso
        ];
    }
}
