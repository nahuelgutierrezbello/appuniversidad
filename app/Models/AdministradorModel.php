<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Models;
// Importa la clase base 'Model' de CodeIgniter.
use CodeIgniter\Model;
/**
 * Modelo para interactuar con la tabla 'Administrador'.
 * Define los campos permitidos, reglas de validación y métodos personalizados.
 */
class AdministradorModel extends Model
{
    // --- Propiedades de Configuración del Modelo ---

    // Especifica la tabla de la base de datos que este modelo representa.
    protected $table      = 'Administrador';
    // Especifica el nombre de la columna que es la clave primaria.
    protected $primaryKey = 'id_admin';
    // Define los campos que se pueden insertar o actualizar masivamente.
    protected $allowedFields = ['id_admin', 'dni','nadmin','fecha_nac','edad','email'];
    // Desactiva los campos de timestamp automáticos ('created_at', 'updated_at').
    protected $useTimestamps = false;

    // Define las reglas de validación que se aplicarán antes de guardar o actualizar.
    protected $validationRules = [
        // 'id_admin' no es requerido para la creación.
        'id_admin' => 'permit_empty|integer', // Cambiado a permit_empty para permitir la creación
        // 'dni' es obligatorio, debe tener exactamente 8 dígitos numéricos y ser único en la tabla.
        'dni'   => 'required|regex_match[/^[0-9]{8}$/]|is_unique[Administrador.dni,id_admin,{id_admin}]',
        // 'nadmin' es obligatorio, con una longitud entre 2 y 80 caracteres.
        'nadmin'  => 'required|min_length[2]|max_length[80]',
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
     * Obtiene todos los administradores.
     * @return array
     */
    public function getAdministradores()
    {
        // Construye una consulta SELECT que devuelve todos los administradores.
        return $this->findAll(); // Ejecuta la consulta y devuelve todos los resultados.
    }

    /**
     * Obtiene un administrador específico por ID.
     * @param int $id El ID del administrador.
     * @return array|object|null Devuelve el administrador o null si no se encuentra.
     */
    public function getAdministrador($id)
    {
        // Construye la consulta para un solo registro.
        return $this->find($id); // Ejecuta la consulta y devuelve el registro que coincide con el ID.
    }
}
