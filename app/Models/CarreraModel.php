<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Models;
// Importa la clase base 'Model' de CodeIgniter.
use CodeIgniter\Model;

// Define la clase 'CarreraModel' que hereda de la clase Model de CodeIgniter.
// Esta clase se encarga de toda la interacción con la tabla 'Carrera'.
class CarreraModel extends Model
{
    // --- Propiedades de Configuración del Modelo ---

    // Especifica la tabla de la base de datos que este modelo representa.
    protected $table      = 'Carrera';
    // Especifica el nombre de la columna que es la clave primaria de la tabla.
    protected $primaryKey = 'id';
    // Define los campos de la tabla que se pueden insertar o actualizar masivamente.
    // Es una medida de seguridad para prevenir ataques de "Mass Assignment".
    protected $allowedFields = ['id', 'nombre_carrera', 'codigo_carrera', 'categoria_id', 'duracion', 'modalidad_id'];
    // Desactiva los campos de timestamp automáticos ('created_at', 'updated_at').
    protected $useTimestamps = false;

    // Define las reglas de validación que se aplicarán automáticamente antes de
    // cualquier operación de inserción (save) o actualización (update).
    protected $validationRules = [
        // 'id' no es requerido para la creación, pero debe ser un entero si se proporciona.
        'id'    => 'permit_empty|integer', // Cambiado a permit_empty para permitir la creación
        // 'nombre_carrera' es obligatorio, con una longitud mínima de 2 y máxima de 120 caracteres.
        'nombre_carrera'      => 'required|min_length[2]|max_length[120]',
        // 'codigo_carrera' es obligatorio, único en la tabla 'Carrera' (ignorando el registro actual en una actualización),
        // y con una longitud entre 2 y 20 caracteres.
        'codigo_carrera'    => 'required|min_length[2]|max_length[20]|is_unique[Carrera.codigo_carrera,id,{id}]',
        // 'duracion' no es obligatorio, pero si se proporciona, debe ser un número natural mayor que cero y menor o igual a 12.
        'duracion'  => 'permit_empty|is_natural_no_zero|less_than_equal_to[12]', // CORREGIDO: La regla es less_than_equal_to
        // 'modalidad_id' e 'categoria_id' no son obligatorios, pero deben ser enteros si se proporcionan.
        'modalidad_id'    => 'permit_empty|integer',
        'categoria_id'    => 'permit_empty|integer',
    ];
    // Define mensajes de error personalizados para las reglas de validación.
    protected $validationMessages = [
        'codigo_carrera' => [
            'is_unique'=>'El código de carrera ya existe.'
        ],
    ];

    // --- Métodos Personalizados ---

    /**
     * Obtiene todas las carreras con el nombre de su categoría y modalidad.
     * Este método es útil para mostrar información completa en las vistas.
     * @return array
     */
    public function getCarrerasCompletas()
    {
        // Construye una consulta SELECT que une la tabla 'Carrera' con 'Categoria' y 'Modalidad'.
        return $this->select('Carrera.*, Categoria.nombre_categoria, Modalidad.nombre_modalidad')
            ->join('Categoria', 'Categoria.id = Carrera.categoria_id', 'left') // 'left' join para mostrar carreras incluso si no tienen categoría.
            ->join('Modalidad', 'Modalidad.id = Carrera.modalidad_id', 'left') // 'left' join para mostrar carreras incluso si no tienen modalidad.
            ->findAll(); // Ejecuta la consulta y devuelve todos los resultados.
    }

    /**
     * Obtiene una carrera específica con el nombre de su categoría y modalidad.
     * @param int $id El ID de la carrera.
     * @return array|object|null
     */
    public function getCarreraCompleta($id)
    {
        // Construye la misma consulta que el método anterior, pero para un solo registro.
        return $this->select('Carrera.*, Categoria.nombre_categoria, Modalidad.nombre_modalidad')
            ->join('Categoria', 'Categoria.id = Carrera.categoria_id', 'left')
            ->join('Modalidad', 'Modalidad.id = Carrera.modalidad_id', 'left')
            ->find($id); // Ejecuta la consulta y devuelve solo el registro que coincide con el ID.
    }
}