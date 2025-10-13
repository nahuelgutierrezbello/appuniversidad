<?php


namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * --- Migración para la tabla 'Profesor' ---
 * Define la estructura de la tabla de Profesores.
 */
class CreateTablaProfesor extends Migration
{
    public function up()
    {
        // Define la estructura de la tabla 'Profesor'.
        $this->forge->addField([
            // Campo 'id': Clave primaria, autoincremental.
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            // Campo 'legajo': Número de legajo único para cada profesor.
            'legajo' => [
                'type'       => 'INT',
                'unique'     => true,
                'null'       => false
            ],
            // Campo 'nombre_profesor': Nombre del profesor.
            'nombre_profesor' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => false
            ],
        ]);
        // Define 'id' como la clave primaria.
        $this->forge->addKey('id', true); // La clave única 'legajo' ya se define en addField.
        // Crea la tabla 'Profesor'.
        $this->forge->createTable('Profesor');
    }

    /**
     * El método down() se ejecuta para ELIMINAR la tabla.
     */
    public function down()
    {
        // Elimina la tabla 'Profesor'.
        $this->forge->dropTable('Profesor');
    }
}