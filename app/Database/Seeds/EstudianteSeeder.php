<?php

// Define el espacio de nombres para organizar la clase.
namespace App\Database\Seeds;

// Importa la clase base 'Seeder' de CodeIgniter.
use CodeIgniter\Database\Seeder;

// Define la clase 'EstudianteSeeder' para poblar la tabla 'Estudiante'.
class EstudianteSeeder extends Seeder
{
    /**
     * El método run() se ejecuta cuando se llama a este seeder.
     * Contiene la lógica para insertar los datos iniciales de los estudiantes.
     */
    public function run()
    {
        // Crea una instancia del Query Builder apuntando a la tabla 'Estudiante'.
        $builder = $this->db->table('Estudiante');

        // Define un array con los datos de los estudiantes de ejemplo.
        // El campo 'carrera_id' es una clave foránea que se corresponde con el ID de una carrera.
        $estudiantes = [
            ['dni' => '12345678', 'nombre_estudiante' => 'Juan Pérez', 'fecha_nacimiento' => '2000-05-10', 'edad' => '24', 'email' => 'juan@email.com', 'carrera_id' => 1], // Inscrito en Desarrollo de Software
            ['dni' => '23456789', 'nombre_estudiante' => 'Lucía Fernández', 'fecha_nacimiento' => '2001-08-22', 'edad' => '23', 'email' => 'lucia@email.com', 'carrera_id' => 2], // Inscrita en Profesorado de Inglés
        ];

        // Vacía la tabla 'Estudiante' para evitar duplicados.
        $builder->truncate();
        // Inserta el lote de estudiantes en la base de datos.
        $builder->insertBatch($estudiantes);
    }
}