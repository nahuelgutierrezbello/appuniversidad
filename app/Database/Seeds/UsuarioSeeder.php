<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Seeds;

// Importa la clase base 'Seeder' de CodeIgniter.
use CodeIgniter\Database\Seeder;

// Define la clase 'UsuarioSeeder' para poblar la tabla 'usuarios'.
class UsuarioSeeder extends Seeder
{
    /**
     * El método run() se ejecuta cuando se llama a este seeder.
     * Contiene la lógica para insertar los tipos de usuario iniciales.
     */
    public function run()
    {
        // Crea una instancia del Query Builder apuntando a la tabla 'usuarios'.
        $builder = $this->db->table('usuarios');
        // Vacía la tabla 'usuarios' para evitar duplicados.
        $builder->truncate();

        // Define un array con los códigos de los tipos de usuario.
        // Esta tabla parece ser un ejemplo o un placeholder para una futura
        // implementación de un sistema de usuarios más complejo.
        $usuarios = [
            ['rol' => 'A'], // admin
            ['rol' => 'P'], // profesor
            ['rol' => 'L'], // alumno
        ];

        // Inserta el lote de usuarios en la base de datos.
        $builder->insertBatch($usuarios);
    }
}