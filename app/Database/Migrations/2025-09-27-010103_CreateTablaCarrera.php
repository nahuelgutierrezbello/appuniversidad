<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * --- Migración para la tabla 'Carrera' ---
 * Define la estructura de la tabla de Carreras, que es central en el sistema.
 */
class CreateTablaCarrera extends Migration
{
    /**
     * El método up() se ejecuta para CREAR la tabla 'Carrera' y sus relaciones.
     */
    public function up()
    {
        // Define la estructura de la tabla 'Carrera'.
        $this->forge->addField([
            // Campo 'id_car': Clave primaria, autoincremental.
            'id_car' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            // Campo 'ncar': Nombre de la carrera.
            'ncar' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => false
            ],
            // Campo 'codcar': Código único para la carrera.
            'codcar' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
                'null'       => false
            ],
            // Campo 'duracion': Duración de la carrera en años.
            'duracion' => [
                'type'       => 'TINYINT',
                'unsigned'   => true,
                'null'       => true
            ],
            // Campo 'id_mod': Clave foránea que apunta a la tabla 'Modalidad'.
            'id_mod' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true,
            ],
            // Campo 'id_cat': Clave foránea que apunta a la tabla 'Categoria'.
            'id_cat' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true
            ],
        ]);
        // Define 'id_car' como la clave primaria.
        $this->forge->addKey('id_car', true); // La clave única 'codcar' ya se define en addField.

        // Define la primera clave foránea: una carrera pertenece a una categoría.
        $this->forge->addForeignKey(
            'id_cat',           // Columna en esta tabla (Carrera)
            'Categoria',        // Tabla a la que se referencia
            'id_cat',           // Columna en la tabla referenciada
            'SET NULL',         // Acción en DELETE: si se borra una categoría, este campo se pone a NULL.
            'CASCADE'           // Acción en UPDATE: si el ID de una categoría cambia, se actualiza aquí también.
        );

        // Define la segunda clave foránea: una carrera tiene una modalidad.
        // Se pueden encadenar las llamadas a addForeignKey.
        $this->forge->addForeignKey(
            'id_mod',
            'Modalidad',
            'id_mod',
            'SET NULL',
            'CASCADE'
        );
        
        // Finalmente, crea la tabla 'Carrera' con toda la estructura definida.
        $this->forge->createTable('Carrera');
    }

    /**
     * El método down() se ejecuta para ELIMINAR la tabla.
     */
    public function down()
    {
        // Elimina la tabla 'Carrera'.
        $this->forge->dropTable('Carrera');
    }
}
