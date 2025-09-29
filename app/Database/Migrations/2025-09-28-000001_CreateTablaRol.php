<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Migrations;

// Importa la clase base 'Migration' de CodeIgniter.
use CodeIgniter\Database\Migration;

// Define la clase 'CreateTablaRol' para crear la tabla de roles.
class CreateTablaRol extends Migration
{
    /**
     * El método up() se ejecuta para CREAR la tabla.
     */
    public function up()
    {
        // Define la estructura de la tabla 'rol'.
        $this->forge->addField([
            // Campo 'id_rol': Clave primaria, autoincremental.
            'id_rol' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            // Campo 'nrol': Nombre del rol (ej: 'admin', 'profesor').
            'nrol'   => ['type' => 'VARCHAR', 'constraint' => 12, 'null' => false],
        ]);
        // Define 'id_rol' como la clave primaria.
        $this->forge->addKey('id_rol', true);
        // Crea la tabla 'rol'.
        $this->forge->createTable('rol');
    }

    /**
     * El método down() se ejecuta para ELIMINAR la tabla.
     */
    public function down()
    {
        // Elimina la tabla 'rol'.
        $this->forge->dropTable('rol');
    }
}