<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Migrations;

// Importa la clase base 'Migration' de CodeIgniter.
use CodeIgniter\Database\Migration;

/**
 * --- Migración para la tabla 'Inscripcion' ---
 * Esta tabla actúa como una "tabla pivote" o "tabla de unión".
 * Su propósito es registrar la relación de "muchos a muchos" entre Estudiantes y Carreras.
 * Un estudiante puede inscribirse en varias carreras, y una carrera puede tener muchos estudiantes.
 */
class CreateTablaInscripcion extends Migration
{
    /**
     * El método up() se ejecuta para CREAR la tabla.
     */
    public function up()
    {
        // Define la estructura de la tabla 'Inscripcion'.
        $this->forge->addField([
            // Campo 'id_inscripcion': Clave primaria, autoincremental.
            'id_inscripcion' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            // Campo 'id_est': Clave foránea que apunta al ID del estudiante.
            'id_est'         => ['type' => 'BIGINT', 'unsigned' => true],
            // Campo 'id_car': Clave foránea que apunta al ID de la carrera.
            'id_car'         => ['type' => 'BIGINT', 'unsigned' => true],
            // Campo 'fecha_inscripcion': Guarda la fecha y hora de la inscripción.
            'fecha_inscripcion' => ['type' => 'DATETIME', 'null' => true],
        ]);
        // Define 'id_inscripcion' como la clave primaria.
        $this->forge->addKey('id_inscripcion', true);
        // Define la relación con la tabla 'Estudiante'. 'CASCADE' significa que si se borra un estudiante, sus inscripciones también se borran.
        $this->forge->addForeignKey('id_est', 'Estudiante', 'id_est', 'CASCADE', 'CASCADE');
        // Define la relación con la tabla 'Carrera'. 'CASCADE' significa que si se borra una carrera, las inscripciones a esa carrera también se borran.
        $this->forge->addForeignKey('id_car', 'Carrera', 'id_car', 'CASCADE', 'CASCADE');
        // Crea la tabla 'Inscripcion'.
        $this->forge->createTable('Inscripcion');
    }

    /**
     * El método down() se ejecuta para ELIMINAR la tabla.
     */
    public function down()
    {
        // Elimina la tabla 'Inscripcion'.
        $this->forge->dropTable('Inscripcion');
    }
}
