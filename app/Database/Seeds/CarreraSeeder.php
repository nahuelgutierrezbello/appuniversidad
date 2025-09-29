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
        // Los campos 'id_cat' y 'id_mod' son claves foráneas que se corresponden
        // con los IDs de las categorías y modalidades insertadas en sus respectivos seeders.
        $carreras = [
            [
                'ncar' => 'Desarrollo de Software',
                'codcar' => 'DS-1',
                'id_cat' => 1, // Corresponde al ID de 'TECNICATURAS SUPERIORES'
                'id_mod' => 1, // Corresponde al ID de 'PRESENCIAL'
            ],
            [
                'ncar' => 'Profesorado de Inglés',
                'codcar' => 'PI-1',
                'id_cat' => 2, // Corresponde al ID de 'PROFESORADOS'
                'id_mod' => 3, // Corresponde al ID de 'HÍBRIDA'
            ],
        ];

        // Vacía la tabla 'Carrera' para evitar duplicados si el seeder se ejecuta más de una vez.
        $builder->truncate();
        // Inserta el lote de carreras en la base de datos.
        $builder->insertBatch($carreras);
    }
}