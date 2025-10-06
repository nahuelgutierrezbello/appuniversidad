<?php

// Define el espacio de nombres para la sección de Administración.
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
// Importa los modelos que este controlador necesita para funcionar.
use App\Models\EstudianteModel;
use App\Models\CarreraModel;

/**
 * Este es el "director de orquesta" para todo lo relacionado con los estudiantes.
 * Cada método público corresponde a una acción que el usuario puede realizar,
 * como ver la lista, registrar uno nuevo, editar, etc.
 */
class Estudiantes extends BaseController
{
    /**
     * Propósito: Muestra la página principal de gestión de estudiantes.
     * Tareas:
     * 1. Carga el modelo de Estudiantes y el de Carreras.
     * 2. Pide al modelo de Estudiantes la lista completa (con el nombre de la carrera).
     * 3. Pide al modelo de Carreras todas las carreras disponibles (para los menús desplegables).
     * 4. Pasa todos estos datos a la vista 'estudiantes.php' para que los muestre.
     * @return string La vista renderizada.
     */
    public function index()
    {
        // Instancia los modelos necesarios.
        $estudianteModel = new EstudianteModel();
        $carreraModel = new CarreraModel();

        // Prepara un array '$data' para pasar información a la vista.
        $data['estudiantes'] = $estudianteModel->getEstudiantesConCarrera();
        $data['carreras'] = $carreraModel->findAll();

        // Carga la vista 'estudiantes.php' y le pasa el array '$data'.
        return view('admin/estudiantes', $data);
    }

    /**
     * Método: registrar()
     * Propósito: Procesa el envío del formulario para crear un nuevo estudiante.
     * Tareas:
     * 1. Recoge los datos enviados por el usuario a través del método POST.
     * 2. Llama al método `save()` del modelo. Este método intenta guardar los datos,
     *    pero primero ejecuta las reglas de validación definidas en el modelo.
     * 3. Si la validación falla, `save()` devuelve `false`. El controlador redirige al usuario de vuelta
     *    al formulario (`redirect()->back()`), manteniendo los datos que ya había ingresado (`withInput()`)
     *    y enviando los errores de validación (`with('errors', ...)`).
     * 4. Si todo es correcto, redirige a la página de estudiantes con un mensaje de éxito.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function registrar()
    {
        $estudianteModel = new EstudianteModel();

        // Recoge los datos del formulario usando el objeto 'request'.
        $data = [
            'dni'        => $this->request->getPost('dni'),
            'nest'       => $this->request->getPost('nest'),
            'edad'       => $this->request->getPost('edad'),
            'email'      => $this->request->getPost('email'),
            'fecha_nac'  => $this->request->getPost('fecha_nac') ?: null,
            'id_car'     => $this->request->getPost('id_car') ?: null,
        ];

        // Intenta guardar los datos. El modelo se encarga de la validación.
        if ($estudianteModel->save($data) === false) {
            // Si la validación falla, redirige hacia atrás con los errores.
            return redirect()->to('/admin/estudiantes')->withInput()->with('errors', 'Error al registrar: ' . implode(', ', $estudianteModel->errors()));
        }

        // Si el guardado es exitoso, redirige a la lista de estudiantes con un mensaje de éxito.
        return redirect()->to('/admin/estudiantes')->with('success', 'Estudiante registrado correctamente.');
    }

    /**
     * Propósito: Obtener los datos de un único estudiante para poder editarlos.
     * Tareas:
     * 1. Está diseñado para responder a una petición AJAX (hecha desde el archivo app.js).
     * 2. Busca al estudiante por el ID proporcionado.
     * 3. Devuelve los datos del estudiante en formato JSON para que JavaScript pueda
     *    rellenar el formulario del modal de edición.
     * @param int $id El ID del estudiante.
     */
    public function edit($id)
    {
        $estudianteModel = new EstudianteModel();
        $estudiante = $estudianteModel->find($id);

        // Verifica si la petición es de tipo AJAX.
        if ($this->request->isAJAX()) {
            if ($estudiante) {
                // Si se encuentra el estudiante, devuelve sus datos como una respuesta JSON.
                return $this->response->setJSON($estudiante);
            } else {
                // Si no se encuentra, devuelve un error 404 (No Encontrado) con un mensaje.
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Estudiante no encontrado']);
            }
        }
        // Si no es AJAX, podrías redirigir o mostrar una vista de error.
        // Por ahora, se asume que siempre será una llamada AJAX.
    }

    /**
     * Método: update($id)
     * Propósito: Procesa el envío del formulario de edición para actualizar un estudiante.
     * Tareas:
     * 1. Recoge los datos del formulario de edición.
     * 2. Llama al método `update()` del modelo, pasándole el ID del estudiante a modificar y los nuevos datos.
     *    Este método también ejecuta las validaciones.
     * 3. Redirige a la página de estudiantes con un mensaje de éxito o error.
     * @param int $id El ID del estudiante a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update($id)
    {
        $estudianteModel = new EstudianteModel();
        // Recoge todos los datos del formulario de edición.
        $data = $this->request->getPost();
        // Añade el ID a los datos para que la regla de validación 'is_unique' pueda ignorar el registro actual.
        $data['id_est'] = $id;

        // Intenta actualizar los datos. El modelo se encarga de la validación.
        if ($estudianteModel->update($id, $data) === false) {
            return redirect()->to('/admin/estudiantes')->withInput()->with('errors', 'Error al actualizar: ' . implode(', ', $estudianteModel->errors()));
        }

        // Si la actualización es exitosa, redirige con un mensaje de éxito.
        return redirect()->to('/admin/estudiantes')->with('success', 'Estudiante actualizado correctamente.');
    }

    /**
     * Método: delete($id)
     * Propósito: Elimina un estudiante de la base de datos.
     * Tareas:
     * 1. Llama al método `delete()` del modelo, pasándole el ID del estudiante a eliminar.
     * 2. Redirige a la página de estudiantes con un mensaje de confirmación.
     * @param int $id El ID del estudiante a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        $estudianteModel = new EstudianteModel();
        // Intenta eliminar el registro.
        if ($estudianteModel->delete($id)) {
            return redirect()->to('/admin/estudiantes')->with('success', 'Estudiante eliminado correctamente.');
        } else {
            // Si por alguna razón falla (ej: un callback del modelo lo impide), redirige con un error.
            return redirect()->to('/admin/estudiantes')->with('error', 'No se pudo eliminar al estudiante.');
        }
    }

    /**
     * Método: search($id)
     * Propósito: Busca un estudiante por su ID para mostrar sus detalles.
     * Tareas:
     * 1. Responde a una petición AJAX desde el formulario "Buscar por ID".
     * 2. Usa un método personalizado del modelo para obtener el estudiante y el nombre de su carrera.
     * 3. Devuelve los datos en formato JSON.
     * @param int $id El ID del estudiante a buscar.
     * @return \CodeIgniter\HTTP\ResponseInterface|void
     */
    public function search($id)
    {
        // Verifica si la petición es de tipo AJAX.
        if ($this->request->isAJAX()) {
            $estudianteModel = new EstudianteModel();
            // Llama al método personalizado que une las tablas Estudiante y Carrera.
            $estudiante = $estudianteModel->getEstudianteConCarrera($id);

            if ($estudiante) {
                // Si se encuentra, devuelve los datos en formato JSON.
                return $this->response->setJSON($estudiante);
            } else {
                // Si no, devuelve un error 404.
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Estudiante no encontrado con ese ID.']);
            }
        }
    }

    /**
     * Método: searchByCareer($careerId)
     * Propósito: Busca todos los estudiantes que pertenecen a una carrera específica.
     * Tareas:
     * 1. Responde a una petición AJAX desde el formulario "Buscar por Carrera".
     * 2. Usa un método personalizado del modelo para obtener la lista de estudiantes.
     * 3. Devuelve la lista en formato JSON para que JavaScript la muestre.
     * @param int $careerId El ID de la carrera.
     * @return \CodeIgniter\HTTP\ResponseInterface|\CodeIgniter\HTTP\RedirectResponse
     */
    public function searchByCareer($careerId)
    {
        // Verifica si la petición es de tipo AJAX.
        if ($this->request->isAJAX()) {
            $estudianteModel = new EstudianteModel();
            // Llama al método del modelo que filtra estudiantes por el ID de la carrera.
            $estudiantes = $estudianteModel->getEstudiantesPorCarrera($careerId);

            // Devuelve la lista de estudiantes (incluso si está vacía) en formato JSON.
            return $this->response->setJSON($estudiantes);
        }
        // Si alguien intenta acceder a esta URL directamente desde el navegador, lo redirige.
        return redirect()->to('/admin/estudiantes');
    }
}