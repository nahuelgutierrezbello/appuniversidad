<?php

// Define el espacio de nombres del controlador.
namespace App\Controllers;
use App\Controllers\BaseController;
// Importa los modelos que este controlador necesita para funcionar.
use App\Models\AdministradorModel;

/**
 * Este es el "director de orquesta" para todo lo relacionado con los administradores.
 * Cada método público corresponde a una acción que el usuario puede realizar,
 * como ver la lista, registrar uno nuevo, editar, etc.
 */
class Administradores extends BaseController
{
    /**
     * Propósito: Muestra la página principal de gestión de administradores.
     * Tareas:
     * 1. Carga el modelo de Administradores.
     * 2. Pide al modelo la lista completa.
     * 3. Pasa todos estos datos a la vista 'administradores.php' para que los muestre.
     * @return string La vista renderizada.
     */
    public function index()
    {
        // Para evitar error de conexión a base de datos, mostramos la vista con datos vacíos si no hay conexión.
        try {
            $administradorModel = new AdministradorModel();
            $data['administradores'] = $administradorModel->getAdministradores();
        } catch (\Exception $e) {
            // Si hay error, mostramos la vista con datos vacíos.
            $data['administradores'] = [];
        }
        return view('administrador/administradores', $data);
    }

    /**
     * Método: registrar()
     * Propósito: Procesa el envío del formulario para crear un nuevo administrador.
     * Tareas:
     * 1. Recoge los datos enviados por el usuario a través del método POST.
     * 2. Llama al método `save()` del modelo. Este método intenta guardar los datos,
     *    pero primero ejecuta las reglas de validación definidas en el modelo.
     * 3. Si la validación falla, `save()` devuelve `false`. El controlador redirige al usuario de vuelta
     *    al formulario (`redirect()->back()`), manteniendo los datos que ya había ingresado (`withInput()`)
     *    y enviando los errores de validación (`with('errors', ...)`).
     * 4. Si todo es correcto, redirige a la página de administradores con un mensaje de éxito.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function registrar()
    {
        $administradorModel = new AdministradorModel();

        // Recoge los datos del formulario usando el objeto 'request'.
        $data = [
            'dni'        => $this->request->getPost('dni'),
            'nadmin'     => $this->request->getPost('nadmin'),
            'edad'       => $this->request->getPost('edad'),
            'email'      => $this->request->getPost('email'),
            'fecha_nac'  => $this->request->getPost('fecha_nac') ?: null,
        ];

        // Intenta guardar los datos. El modelo se encarga de la validación.
        if ($administradorModel->save($data) === false) {
            // Si la validación falla, redirige hacia atrás con los errores.
            return redirect()->to('/administradores')->withInput()->with('errors', 'Error al registrar: ' . implode(', ', $administradorModel->errors()));
        }

        // Si el guardado es exitoso, redirige a la lista de administradores con un mensaje de éxito.
        return redirect()->to('/administradores')->with('success', 'Administrador registrado correctamente.');
    }

    /**
     * Propósito: Obtener los datos de un único administrador para poder editarlos.
     * Tareas:
     * 1. Está diseñado para responder a una petición AJAX (hecha desde el archivo app.js).
     * 2. Busca al administrador por el ID proporcionado.
     * 3. Devuelve los datos del administrador en formato JSON para que JavaScript pueda
     *    rellenar el formulario del modal de edición.
     * @param int $id El ID del administrador.
     */
    public function edit($id)
    {
        $administradorModel = new AdministradorModel();
        $administrador = $administradorModel->find($id);

        // Verifica si la petición es de tipo AJAX.
        if ($this->request->isAJAX()) {
            if ($administrador) {
                // Si se encuentra el administrador, devuelve sus datos como una respuesta JSON.
                return $this->response->setJSON($administrador);
            } else {
                // Si no se encuentra, devuelve un error 404 (No Encontrado) con un mensaje.
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Administrador no encontrado']);
            }
        }
        // Si no es AJAX, podrías redirigir o mostrar una vista de error.
        // Por ahora, se asume que siempre será una llamada AJAX.
    }

    /**
     * Método: update($id)
     * Propósito: Procesa el envío del formulario de edición para actualizar un administrador.
     * Tareas:
     * 1. Recoge los datos del formulario de edición.
     * 2. Llama al método `update()` del modelo, pasándole el ID del administrador a modificar y los nuevos datos.
     *    Este método también ejecuta las validaciones.
     * 3. Redirige a la página de administradores con un mensaje de éxito o error.
     * @param int $id El ID del administrador a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update($id)
    {
        $administradorModel = new AdministradorModel();
        // Recoge todos los datos del formulario de edición.
        $data = $this->request->getPost();
        // Añade el ID a los datos para que la regla de validación 'is_unique' pueda ignorar el registro actual.
        $data['id_admin'] = $id;

        // Intenta actualizar los datos. El modelo se encarga de la validación.
        if ($administradorModel->update($id, $data) === false) {
            return redirect()->to('/administradores')->withInput()->with('errors', 'Error al actualizar: ' . implode(', ', $administradorModel->errors()));
        }

        // Si la actualización es exitosa, redirige con un mensaje de éxito.
        return redirect()->to('/administradores')->with('success', 'Administrador actualizado correctamente.');
    }

    /**
     * Método: delete($id)
     * Propósito: Elimina un administrador de la base de datos.
     * Tareas:
     * 1. Llama al método `delete()` del modelo, pasándole el ID del administrador a eliminar.
     * 2. Redirige a la página de administradores con un mensaje de confirmación.
     * @param int $id El ID del administrador a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        $administradorModel = new AdministradorModel();
        // Intenta eliminar el registro.
        if ($administradorModel->delete($id)) {
            return redirect()->to('/administradores')->with('success', 'Administrador eliminado correctamente.');
        } else {
            // Si por alguna razón falla (ej: un callback del modelo lo impide), redirige con un error.
            return redirect()->to('/administradores')->with('error', 'No se pudo eliminar al administrador.');
        }
    }

    /**
     * Método: search($id)
     * Propósito: Busca un administrador por su ID para mostrar sus detalles.
     * Tareas:
     * 1. Responde a una petición AJAX desde el formulario "Buscar por ID".
     * 2. Usa un método personalizado del modelo para obtener el administrador.
     * 3. Devuelve los datos en formato JSON.
     * @param int $id El ID del administrador a buscar.
     * @return \CodeIgniter\HTTP\ResponseInterface|void
     */
    public function search($id)
    {
        // Verifica si la petición es de tipo AJAX.
        if ($this->request->isAJAX()) {
            $administradorModel = new AdministradorModel();
            // Llama al método personalizado que obtiene el administrador.
            $administrador = $administradorModel->getAdministrador($id);

            if ($administrador) {
                // Si se encuentra, devuelve los datos en formato JSON.
                return $this->response->setJSON($administrador);
            } else {
                // Si no, devuelve un error 404.
                return $this->response->setStatusCode(404)->setJSON(['error' => 'Administrador no encontrado con ese ID.']);
            }
        }
    }
}
