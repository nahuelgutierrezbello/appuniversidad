<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Seeds;

// Importa la clase base 'Seeder' de CodeIgniter.
use CodeIgniter\Database\Seeder;

// Define la clase 'ProfesorSeeder' para poblar la tabla 'Profesor'.
class ProfesorSeeder extends Seeder
{
    /**
     * El método run() se ejecuta cuando se llama a este seeder.
     * Contiene la lógica para insertar los datos iniciales de los profesores.
     */
    public function run()
    {
        // Crea una instancia del Query Builder apuntando a la tabla 'Profesor'.
        $builder = $this->db->table('Profesor');


        // Vacía la tabla 'Profesor' para evitar duplicados.
        $builder->truncate();
        // Inserta el lote de profesores en la base de datos.
        $builder->insertBatch($profesores);
    }
}