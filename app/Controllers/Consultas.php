<?php

namespace App\Controllers;

use App\Controllers\BaseController;

/**
 * Controlador para manejar las consultas de estudiantes y profesores al administrador.
 */
class Consultas extends BaseController
{
    /**
     * Método para enviar una consulta desde el dashboard de estudiante o profesor.
     * Guarda la consulta en la base de datos con los datos del usuario y la sesión.
     */
    public function enviar()
    {
        // Validar que sea una petición POST
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Método no permitido.');
        }

        // Obtener datos del formulario
        $asunto = $this->request->getPost('asunto');
        $mensaje = $this->request->getPost('mensaje');
        $usuario_id = $this->request->getPost('usuario_id'); // ID del estudiante o profesor

        // Validar datos básicos
        if (empty($asunto) || empty($mensaje) || empty($usuario_id)) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        // Obtener información del usuario (estudiante o profesor)
        $db = \Config\Database::connect();
        $usuario = null;

        // Intentar buscar en Estudiante
        $estudiante = $db->table('Estudiante')->where('id', $usuario_id)->get()->getRow();
        if ($estudiante) {
            $usuario = [
                'tipo' => 'estudiante',
                'id' => $estudiante->id,
                'nombre' => $estudiante->nombre_estudiante,
                'email' => $estudiante->email,
                'dni' => $estudiante->dni
            ];
        } else {
            // Intentar buscar en Profesor
            $profesor = $db->table('Profesor')->where('id', $usuario_id)->get()->getRow();
            if ($profesor) {
                $usuario = [
                    'tipo' => 'profesor',
                    'id' => $profesor->id,
                    'nombre' => $profesor->nombre_profesor,
                    'email' => 'profesor@universidad.com', // Asumir email genérico o buscar en otra tabla
                    'dni' => $profesor->legajo
                ];
            }
        }

        if (!$usuario) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        // Preparar datos para insertar en consultas_admin
        $data = [
            'email_usuario' => $usuario['email'],
            'mensaje' => $mensaje,
            'asunto' => $asunto,
            'estado' => 'pendiente',
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];

        // Insertar en la base de datos
        $builder = $db->table('consultas_admin');
        if ($builder->insert($data)) {
            return redirect()->back()->with('success', 'Consulta enviada correctamente. El administrador la revisará pronto.');
        } else {
            return redirect()->back()->with('error', 'Error al enviar la consulta. Inténtalo de nuevo.');
        }
    }
}
