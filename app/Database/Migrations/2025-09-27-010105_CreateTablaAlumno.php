<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * --- Migración para la tabla 'Estudiante' ---
 *
 * Las migraciones son como un control de versiones para tu base de datos.
 * Permiten definir la estructura de las tablas en código PHP.
 * El método `up()` se ejecuta cuando aplicas la migración (php spark migrate).
 * El método `down()` se ejecuta cuando la reviertes (php spark migrate:rollback).
 */
class CreateTablaAlumno extends Migration
{
    /**
     * El método up() se ejecuta para CREAR la tabla 'Estudiante' y sus relaciones.
     */
    public function up()
    {
        // Define la estructura de la tabla 'Estudiante'.
        $this->forge->addField([
            // Campo 'id_est': Clave primaria, autoincremental.
            'id_est' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            // Campo 'dni': Número de documento, único y obligatorio.
            'dni' => [
                'type'       => 'CHAR',
                'constraint' => 8,
                'unique'     => true,
                'null'       => false
            ],
            // Campo 'nest': Nombre del estudiante, obligatorio.
            'nest' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => false
            ],
            // Campo 'fecha_nac': Fecha de nacimiento, puede ser nulo.
            'fecha_nac' => [
                'type' => 'DATE',
                'null' => true
            ],
            // Campo 'edad': Edad del estudiante, obligatorio.
            'edad' => [
                'type'       => 'CHAR',
                'constraint' => 2,
                'null'       => false
            ],
            // Campo 'email': Correo electrónico, obligatorio.
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false
            ],
            // Campo 'id_car': Clave foránea que relaciona al estudiante con una carrera.
            'id_car' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true
            ],
        ]);
        // Define 'id_est' como la clave primaria.
        $this->forge->addKey('id_est', true);
        // La clave única 'dni' ya se define en addField.

        // Define la clave foránea: un estudiante pertenece a una carrera.
        $this->forge->addForeignKey(
            'id_car', 'Carrera', 'id_car',
            'SET NULL', // ON DELETE: si se borra la carrera, el campo 'id_car' del estudiante se pone a NULL.
            'CASCADE'   // ON UPDATE: si el ID de la carrera cambia, se actualiza aquí también.
        );
        // Finalmente, crea la tabla 'Estudiante' con toda la estructura definida.
        $this->forge->createTable('Estudiante');
    }

    /**
     * Elimina la tabla 'Estudiante'. Se usa al revertir la migración.
     */
    public function down()
    {
        // Elimina la tabla 'Estudiante'.
        $this->forge->dropTable('Estudiante');
    }
}
