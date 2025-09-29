<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Migrations;

// Importa la clase base 'Migration' de CodeIgniter.
use CodeIgniter\Database\Migration;

// Define la clase 'CreateTablaUsuarios' para crear la tabla de usuarios.
class CreateTablaUsuarios extends Migration
{
    /**
     * El método up() se ejecuta para CREAR la tabla.
     */
    public function up()
    {
        // Define la estructura de la tabla 'usuarios'.
        // Esta tabla parece ser un ejemplo o un placeholder para una futura implementación
        // de un sistema de usuarios más complejo.
        $this->forge->addField([
            // Campo 'id_user': Clave primaria, autoincremental.
            'id_user' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            // Campo 'rol': Un código de una letra para el rol, debe ser único.
            'rol'       => ['type' => 'VARCHAR', 'constraint' => 1, 'null' => false, 'unique' => true],
        ]);
        // Define 'id_user' como la clave primaria.
        $this->forge->addKey('id_user', true);
        // Crea la tabla 'usuarios'.
        $this->forge->createTable('usuarios');
    }

    /**
     * El método down() se ejecuta para ELIMINAR la tabla.
     */
    public function down()
    {
        // Elimina la tabla 'usuarios'.
        $this->forge->dropTable('usuarios');
    }
}