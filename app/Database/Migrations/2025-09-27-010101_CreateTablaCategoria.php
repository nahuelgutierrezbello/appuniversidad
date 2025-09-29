<?php

// Define el espacio de nombres para organizar la clase dentro de la estructura del proyecto.
namespace App\Database\Migrations;

// Importa la clase base 'Migration' de CodeIgniter, que provee las herramientas para crear y modificar tablas.
use CodeIgniter\Database\Migration;

/**
 * --- Migración para la tabla 'Categoria' ---
 * Define la estructura de la tabla de Categorías a las que pertenecen las carreras.
 */
class CreateTablaCategoria extends Migration
{
    /**
     * El método up() se ejecuta cuando aplicas la migración (con `php spark migrate`).
     * Contiene las instrucciones para CREAR la tabla y sus campos.
     */
    public function up()
    {
        // Utiliza el "Forge" (la forja) de CodeIgniter para definir la estructura de la tabla.
        // addField() recibe un array donde cada elemento es una columna de la tabla.
        $this->forge->addField([
            // Campo 'id_cat': Clave primaria, autoincremental y sin signo.
            'id_cat' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            // Campo 'codcat': Código único para la categoría.
            'codcat' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
                'null'       => false
            ],
            // Campo 'ncat': Nombre de la categoría.
            'ncat' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => false
            ],
        ]);
        // Define 'id_cat' como la clave primaria de la tabla.
        $this->forge->addKey('id_cat', true); // La clave única 'codcat' ya se define en addField.
        // Finalmente, ejecuta la creación de la tabla 'Categoria' en la base de datos.
        $this->forge->createTable('Categoria');
    }

    /**
     * El método down() se ejecuta cuando reviertes la migración (con `php spark migrate:rollback`).
     * Contiene la instrucción para ELIMINAR la tabla.
     */
    public function down()
    {
        // Elimina la tabla 'Categoria' de la base de datos.
        $this->forge->dropTable('Categoria');
    }
}