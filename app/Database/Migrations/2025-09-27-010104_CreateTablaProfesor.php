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
            // Campo 'id_prof': Clave primaria, autoincremental.
            'id_prof' => [
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
            // Campo 'nprof': Nombre del profesor.
            'nprof' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => false
            ],
        ]);
        // Define 'id_prof' como la clave primaria.
        $this->forge->addKey('id_prof', true); // La clave única 'legajo' ya se define en addField.
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