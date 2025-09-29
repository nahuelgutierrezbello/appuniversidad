<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Seeds;

// Importa la clase base 'Seeder' de CodeIgniter.
use CodeIgniter\Database\Seeder;

// Define la clase 'RolSeeder' para poblar la tabla 'rol'.
class RolSeeder extends Seeder
{
    /**
     * El método run() se ejecuta cuando se llama a este seeder.
     * Contiene la lógica para insertar los roles de usuario iniciales.
     */
    public function run()
    {
        // Crea una instancia del Query Builder apuntando a la tabla 'rol'.
        $builder = $this->db->table('rol');
        // Vacía la tabla 'rol' para evitar duplicados.
        $builder->truncate();

        // Define un array con los nombres de los roles.
        $roles = [
            ['nrol' => 'admin'],
            ['nrol' => 'profesor'],
            ['nrol' => 'alumno'],
        ];

        // Inserta el lote de roles en la base de datos.
        $builder->insertBatch($roles);
    }
}