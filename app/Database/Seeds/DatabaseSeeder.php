<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Seeds;

// Importa la clase base 'Seeder' de CodeIgniter.
use CodeIgniter\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * El método run() se ejecuta cuando se llama a este seeder.
     * Su propósito es orquestar la ejecución de todos los demás seeders en un orden específico.
     */
    public function run()
    {
        // Obtiene una instancia de la conexión a la base de datos.
        $db = \Config\Database::connect();

        // Ejecuta una consulta SQL nativa para desactivar temporalmente la revisión de claves foráneas.
        // Esto es crucial para poder vaciar (TRUNCATE) las tablas sin que la base de datos genere errores
        // por las relaciones que existen entre ellas.
        $db->query('SET FOREIGN_KEY_CHECKS=0');
        
        // Llama a cada seeder individual usando el método call().
        // El orden es importante: primero se pueblan las tablas maestras (como Categoria y Modalidad)
        // y luego las tablas que dependen de ellas (como Carrera).
        $this->call('CategoriaSeeder');
        $this->call('ModalidadSeeder');
        $this->call('CarreraSeeder');
        $this->call('ProfesorSeeder');
        $this->call('EstudianteSeeder');

        // Llama a los seeders para las tablas de roles y usuarios.
        $this->call('RolSeeder');
        $this->call('UsuarioSeeder');

        // Una vez que todos los seeders han terminado, se vuelven a activar las restricciones de clave foránea.
        // Esto devuelve la base de datos a su estado normal y seguro.
        $db->query('SET FOREIGN_KEY_CHECKS=1');
    }
}