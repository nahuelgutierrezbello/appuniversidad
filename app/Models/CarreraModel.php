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
    protected $primaryKey = 'id_car';
    // Define los campos de la tabla que se pueden insertar o actualizar masivamente.
    // Es una medida de seguridad para prevenir ataques de "Mass Assignment".
    protected $allowedFields = ['id_car', 'ncar', 'codcar', 'id_cat', 'duracion', 'id_mod'];
    // Desactiva los campos de timestamp automáticos ('created_at', 'updated_at').
    protected $useTimestamps = false;

    // Define las reglas de validación que se aplicarán automáticamente antes de
    // cualquier operación de inserción (save) o actualización (update).
    protected $validationRules = [
        // 'id_car' no es requerido para la creación, pero debe ser un entero si se proporciona.
        'id_car'    => 'permit_empty|integer', // Cambiado a permit_empty para permitir la creación
        // 'ncar' es obligatorio, con una longitud mínima de 2 y máxima de 120 caracteres.
        'ncar'      => 'required|min_length[2]|max_length[120]',
        // 'codcar' es obligatorio, único en la tabla 'Carrera' (ignorando el registro actual en una actualización),
        // y con una longitud entre 2 y 20 caracteres.
        'codcar'    => 'required|min_length[2]|max_length[20]|is_unique[Carrera.codcar,id_car,{id_car}]',
        // 'duracion' no es obligatorio, pero si se proporciona, debe ser un número natural mayor que cero y menor o igual a 12.
        'duracion'  => 'permit_empty|is_natural_no_zero|less_than_equal_to[12]', // CORREGIDO: La regla es less_than_equal_to
        // 'id_mod' e 'id_cat' no son obligatorios, pero deben ser enteros si se proporcionan.
        'id_mod'    => 'permit_empty|integer',
        'id_cat'    => 'permit_empty|integer',
    ];
    // Define mensajes de error personalizados para las reglas de validación.
    protected $validationMessages = [
        'codcar' => [
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
        return $this->select('Carrera.*, Categoria.ncat, Modalidad.nmod')
            ->join('Categoria', 'Categoria.id_cat = Carrera.id_cat', 'left') // 'left' join para mostrar carreras incluso si no tienen categoría.
            ->join('Modalidad', 'Modalidad.id_mod = Carrera.id_mod', 'left') // 'left' join para mostrar carreras incluso si no tienen modalidad.
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
        return $this->select('Carrera.*, Categoria.ncat, Modalidad.nmod')
            ->join('Categoria', 'Categoria.id_cat = Carrera.id_cat', 'left')
            ->join('Modalidad', 'Modalidad.id_mod = Carrera.id_mod', 'left')
            ->find($id); // Ejecuta la consulta y devuelve solo el registro que coincide con el ID.
    }
}