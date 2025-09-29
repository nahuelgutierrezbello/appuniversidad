<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Migrations;

// Importa la clase base 'Migration' de CodeIgniter.
use CodeIgniter\Database\Migration;

/**
 * --- Migración para la tabla 'Modalidad' ---
 * Define la estructura de la tabla de Modalidades de cursada (Presencial, Virtual, etc.).
 */
class CreateTablaModalidad extends Migration
{
    /**
     * El método up() se ejecuta para CREAR la tabla.
     */
    public function up()
    {
        // Define la estructura de la tabla 'Modalidad'.
        $this->forge->addField([
            // Campo 'id_mod': Clave primaria, autoincremental.
            'id_mod' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            // Campo 'codmod': Código único para la modalidad.
            'codmod' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
                'null'       => false
            ],
            // Campo 'nmod': Nombre de la modalidad.
            'nmod' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => false
            ],
        ]);
        // Define 'id_mod' como la clave primaria.
        // La clave única 'codmod' ya se define inline en addField.
        $this->forge->addKey('id_mod', true);
        // Ejecuta la creación de la tabla 'Modalidad'.
        $this->forge->createTable('Modalidad');
    }

    /**
     * El método down() se ejecuta para ELIMINAR la tabla.
     */
    public function down()
    {
        // Elimina la tabla 'Modalidad'.
        $this->forge->dropTable('Modalidad');
    }
}