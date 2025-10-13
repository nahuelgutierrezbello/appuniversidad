<?php

namespace App\Controllers;

use App\Models\ModalidadModel;
use App\Models\CarreraModel;

class Modalidades extends BaseController
{
    protected $modalidadModel;
    protected $carreraModel;

    public function __construct()
    {
        $this->modalidadModel = new ModalidadModel();
        $this->carreraModel = new CarreraModel();
    }

    public function index()
    {
        $data['modalidades'] = $this->modalidadModel->findAll();
        $data['carreras'] = $this->carreraModel->findAll();
        return view('administrador/modalidades', $data);
    }

    public function registrar()
    {
        $data = [
            'codigo_modalidad' => $this->request->getPost('codigo_modalidad'),
            'nombre_modalidad' => $this->request->getPost('nombre_modalidad'),
            'carrera_id' => $this->request->getPost('carrera_id'),
        ];

        if ($this->modalidadModel->insert($data)) {
            return redirect()->to('/administrador/modalidades')->with('success', 'Modalidad registrada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->modalidadModel->errors());
        }
    }

    public function edit($id)
    {
        $modalidad = $this->modalidadModel->find($id);
        if (!$modalidad) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Modalidad no encontrada');
        }
        return $this->response->setJSON($modalidad);
    }

    public function update($id)
    {
        $data = [
            'codigo_modalidad' => $this->request->getPost('codigo_modalidad'),
            'nombre_modalidad' => $this->request->getPost('nombre_modalidad'),
            'carrera_id' => $this->request->getPost('carrera_id'),
        ];

        if ($this->modalidadModel->update($id, $data)) {
            return redirect()->to('/administrador/modalidades')->with('success', 'Modalidad actualizada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->modalidadModel->errors());
        }
    }

    public function delete($id)
    {
        if ($this->modalidadModel->delete($id)) {
            return redirect()->to('/administrador/modalidades')->with('success', 'Modalidad eliminada exitosamente.');
        } else {
            return redirect()->to('/administrador/modalidades')->with('error', 'Error al eliminar la modalidad.');
        }
    }

    public function search($id)
    {
        $modalidad = $this->modalidadModel->find($id);
        if (!$modalidad) {
            return $this->response->setJSON(['error' => 'Modalidad no encontrada']);
        }
        return $this->response->setJSON($modalidad);
    }
}
