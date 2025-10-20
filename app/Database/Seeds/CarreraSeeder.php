<?php

// Define el espacio de nombres para organizar la clase dentro de la estructura del proyecto.
namespace App\Database\Seeds;

// Importa la clase base 'Seeder' de CodeIgniter.
use CodeIgniter\Database\Seeder;

// Define la clase 'CarreraSeeder' que se encargará de poblar la tabla 'Carrera'.
class CarreraSeeder extends Seeder
{
    /**
     * El método run() se ejecuta cuando se llama a este seeder.
     * Contiene la lógica para insertar los datos iniciales de las carreras.
     */
    public function run()
    {
        // Crea una instancia del Query Builder apuntando a la tabla 'Carrera'.
        $builder = $this->db->table('Carrera');

        // Define un array con los datos de las carreras de ejemplo.
        $carreras = [
            [
                'nombre_carrera' => 'Desarrollo de Software',
                'codigo_carrera' => 'DS-1',
            ],
            [
                'nombre_carrera' => 'Profesorado de Inglés',
                'codigo_carrera' => 'PI-1',
            ],
        ];

        // Vacía la tabla 'Carrera' para evitar duplicados si el seeder se ejecuta más de una vez.
        $builder->truncate();
        // Inserta el lote de carreras en la base de datos.
        $builder->insertBatch($carreras);
    }
}