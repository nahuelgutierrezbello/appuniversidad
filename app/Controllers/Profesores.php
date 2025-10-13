<?php

// Define el espacio de nombres del controlador.
namespace App\Controllers;
use App\Controllers\BaseController;
// Importa los modelos que este controlador necesita para funcionar.
use App\Models\ProfesorModel;

/**
 * Este es el "director de orquesta" para todo lo relacionado con los profesores.
 * Cada método público corresponde a una acción que el usuario puede realizar,
 * como ver la lista, registrar uno nuevo, editar, etc.
 */
class Profesores extends BaseController
{
    /**
     * Propósito: Muestra la página principal de gestión de profesores.
     * Tareas:
     * 1. Carga el modelo de Profesores.
     * 2. Pide al modelo la lista completa.
     * 3. Pasa todos estos datos a la vista 'profesores.php' para que los muestre.
     * @return string La vista renderizada.
     */
    public function index()
    {
        // Para evitar error de conexión a base de datos, mostramos la vista con datos vacíos si no hay conexión.
        try {
            $profesorModel = new ProfesorModel();
            $data['profesores'] = $profesorModel->getProfesores();
            $data['carreras'] = $this->db->table('Carrera')->get()->getResultArray();
        } catch (\Exception $e) {
            // Si hay error, mostramos la vista con datos vacíos.
            $data['profesores'] = [];
            $data['carreras'] = [];
        }
        return view('administrador/profesores', $data);
    }

    /**
     * Método: registrar()
     * Propósito: Procesa el envío del formulario para crear un nuevo profesor.
     * Tareas:
     * 1. Recoge los datos enviados por el usuario a través del método POST.
     * 2. Llama al método `save()` del modelo. Este método intenta guardar los datos,
     *    pero primero ejecuta las reglas de validación definidas en el modelo.
     * 3. Si la validación falla, `save()` devuelve `false`. El controlador redirige al usuario de vuelta
     *    al formulario (`redirect()->back()`), manteniendo los datos que ya había ingresado (`withInput()`)
     *    y enviando los errores de validación (`with('errors', ...)`).
     * 4. Si todo es correcto, redirige a la página de profesores con un mensaje de éxito.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function registrar()
    {
        $profesorModel = new ProfesorModel();

        // Recoge los datos del formulario usando el objeto 'request'.
        $data = [
            'legajo' => $this->request->getPost('legajo'),
            'nombre_profesor'  => $this->request->getPost('nombre_profesor'),
            'carrera_id' => $this->request->getPost('carrera_id'),
        ];

        // Intenta guardar los datos. El modelo se encarga de la validación.
        if ($profesorModel->save($data) === false) {
            // Si la validación falla, redirige hacia atrás con los errores.
            return redirect()->to('/profesores')->withInput()->with('errors', 'Error al registrar: ' . implode(', ', $profesorModel->errors()));
        }

        // Si el guardado es exitoso, redirige a la lista de profesores con un mensaje de éxito.
        return redirect()->to('/profesores')->with('success', 'Profesor registrado correctamente.');
    }

    /**
     * Propósito: Obtener los datos de un único profesor para poder editarlos.
     * Tareas:
     * 1. Está diseñado para responder a una petición AJAX (hecha desde el archivo app.js).
     * 2. Busca al profesor por el ID proporcionado.
     * 3. Devuelve los datos del profesor en formato JSON para que JavaScript pueda
     *    rellenar el formulario del modal de edición.
     * @param int $id El ID del profesor.
     */
    public function edit($id)
    {
        $profesorModel = new ProfesorModel();
        $profesor = $profesorModel->find($id);

        // Verifica si la petición es de tipo AJAX.
        if ($this->request->isAJAX()) {
            if ($profesor) {
                // Si se encuentra el profesor, devuelve sus datos como una respuesta JSON.
                return $this->response->setJSON($profesor);
            } else {
                // Si no se encuentra, devuelve un error 404 (No Encontrado) con un mensaje.
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Profesor no encontrado']);
            }
        }
        // Si no es AJAX, podrías redirigir o mostrar una vista de error.
        // Por ahora, se asume que siempre será una llamada AJAX.
    }

    /**
     * Método: update($id)
     * Propósito: Procesa el envío del formulario de edición para actualizar un profesor.
     * Tareas:
     * 1. Recoge los datos del formulario de edición.
     * 2. Llama al método `update()` del modelo, pasándole el ID del profesor a modificar y los nuevos datos.
     *    Este método también ejecuta las validaciones.
     * 3. Redirige a la página de profesores con un mensaje de éxito o error.
     * @param int $id El ID del profesor a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update($id)
    {
        $profesorModel = new ProfesorModel();
        // Recoge todos los datos del formulario de edición.
        $data = $this->request->getPost();
        // Añade el ID a los datos para que la regla de validación 'is_unique' pueda ignorar el registro actual.
        $data['id'] = $id;

        // Intenta actualizar los datos. El modelo se encarga de la validación.
        if ($profesorModel->update($id, $data) === false) {
            return redirect()->to('/profesores')->withInput()->with('errors', 'Error al actualizar: ' . implode(', ', $profesorModel->errors()));
        }

        // Si la actualización es exitosa, redirige con un mensaje de éxito.
        return redirect()->to('/profesores')->with('success', 'Profesor actualizado correctamente.');
    }

    /**
     * Método: delete($id)
     * Propósito: Elimina un profesor de la base de datos.
     * Tareas:
     * 1. Llama al método `delete()` del modelo, pasándole el ID del profesor a eliminar.
     * 2. Redirige a la página de profesores con un mensaje de confirmación.
     * @param int $id El ID del profesor a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        $profesorModel = new ProfesorModel();
        // Intenta eliminar el registro.
        if ($profesorModel->delete($id)) {
            return redirect()->to('/profesores')->with('success', 'Profesor eliminado correctamente.');
        } else {
            // Si por alguna razón falla (ej: un callback del modelo lo impide), redirige con un error.
            return redirect()->to('/profesores')->with('error', 'No se pudo eliminar al profesor.');
        }
    }

    /**
     * Método: search($id)
     * Propósito: Busca un profesor por su ID para mostrar sus detalles.
     * Tareas:
     * 1. Responde a una petición AJAX desde el formulario "Buscar por ID".
     * 2. Usa un método personalizado del modelo para obtener el profesor.
     * 3. Devuelve los datos en formato JSON.
     * @param int $id El ID del profesor a buscar.
     * @return \CodeIgniter\HTTP\ResponseInterface|void
     */
    public function search($id)
    {
        // Verifica si la petición es de tipo AJAX.
        if ($this->request->isAJAX()) {
            $profesorModel = new ProfesorModel();
            // Llama al método personalizado que obtiene el profesor.
            $profesor = $profesorModel->getProfesor($id);

            if ($profesor) {
                // Si se encuentra, devuelve los datos en formato JSON.
                return $this->response->setJSON($profesor);
            } else {
                // Si no, devuelve un error 404.
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Profesor no encontrado con ese ID.']);
            }
        }
    }

    /**
     * Método: searchByLegajo($legajo)
     * Propósito: Busca un profesor por su legajo para mostrar sus detalles.
     * Tareas:
     * 1. Responde a una petición AJAX desde el formulario "Buscar por Legajo".
     * 2. Usa un método personalizado del modelo para obtener el profesor.
     * 3. Devuelve los datos en formato JSON.
     * @param int $legajo El legajo del profesor a buscar.
     * @return \CodeIgniter\HTTP\ResponseInterface|void
     */
    public function searchByLegajo($legajo)
    {
        // Verifica si la petición es de tipo AJAX.
        if ($this->request->isAJAX()) {
            $profesorModel = new ProfesorModel();
            // Llama al método personalizado que obtiene el profesor por legajo.
            $profesor = $profesorModel->getProfesorByLegajo($legajo);

            if ($profesor) {
                // Si se encuentra, devuelve los datos en formato JSON.
                return $this->response->setJSON($profesor);
            } else {
                // Si no, devuelve un error 404.
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Profesor no encontrado con ese legajo.']);
            }
        }
    }

    /**
     * Método: dashboard()
     * Propósito: Muestra el dashboard del profesor con datos de la base de datos.
     * @return string La vista renderizada.
     */
    public function dashboard()
    {
        // Por ahora, usar profesor con ID 1. En el futuro, usar sesión.
        $id_prof = 1;

        $profesorModel = new ProfesorModel();

        $data['profesor'] = $profesorModel->getProfesorConCarrera($id_prof);
        $data['materias_dictadas'] = $profesorModel->getMateriasDictadas($id_prof);
        $data['estadisticas'] = $profesorModel->getEstadisticas($id_prof);
        $data['estudiantes_por_materia'] = $profesorModel->getEstudiantesPorMateria($id_prof);

        return view('dashboard_profesores', $data);
    }
}
