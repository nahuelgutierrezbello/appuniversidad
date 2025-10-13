<?php

namespace App\Controllers;

use App\Models\RolModel;

class Rol extends BaseController
{
    protected $rolModel;

    public function __construct()
    {
        $this->rolModel = new RolModel();
    }

    public function index()
    {
        $data['roles'] = $this->rolModel->findAll();
        return view('administrador/rol', $data);
    }

    public function registrar()
    {
        $data = [
            'nombre_rol' => $this->request->getPost('nombre_rol'),
        ];

        if ($this->rolModel->insert($data)) {
            return redirect()->to('/administrador/rol')->with('success', 'Rol registrado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->rolModel->errors());
        }
    }

    public function edit($id)
    {
        $rol = $this->rolModel->find($id);
        if (!$rol) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Rol no encontrado');
        }
        return $this->response->setJSON($rol);
    }

    public function update($id)
    {
        $data = [
            'nombre_rol' => $this->request->getPost('nombre_rol'),
        ];

        if ($this->rolModel->update($id, $data)) {
            return redirect()->to('/administrador/rol')->with('success', 'Rol actualizado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->rolModel->errors());
        }
    }

    public function delete($id)
    {
        if ($this->rolModel->delete($id)) {
            return redirect()->to('/administrador/rol')->with('success', 'Rol eliminado exitosamente.');
        } else {
            return redirect()->to('/administrador/rol')->with('error', 'Error al eliminar el rol.');
        }
    }

    public function search($id)
    {
        $rol = $this->rolModel->find($id);
        if (!$rol) {
            return $this->response->setJSON(['error' => 'Rol no encontrado']);
        }
        return $this->response->setJSON($rol);
    }
}
