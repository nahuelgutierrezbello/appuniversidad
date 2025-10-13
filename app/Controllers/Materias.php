<?php

namespace App\Controllers;

use App\Models\MateriaModel;
use App\Models\CarreraModel;

class Materias extends BaseController
{
    protected $materiaModel;
    protected $carreraModel;

    public function __construct()
    {
        $this->materiaModel = new MateriaModel();
        $this->carreraModel = new CarreraModel();
    }

    public function index()
    {
        try {
            $perPage = 10; // Número de registros por página
            $page = $this->request->getVar('page') ?? 1;
            $carreraId = $this->request->getVar('carrera_id');

            if ($carreraId) {
                $this->materiaModel->where('carrera_id', $carreraId);
            }

            $data['materias'] = $this->materiaModel->paginate($perPage, 'default', $page);
            $data['pager'] = $this->materiaModel->pager;

            $data['carreras'] = $this->carreraModel->findAll();
            $data['selectedCarrera'] = $carreraId;
        } catch (\Exception $e) {
            $data['materias'] = [];
            $data['carreras'] = [];
            $data['selectedCarrera'] = null;
            $data['error'] = 'Error al cargar los datos: ' . $e->getMessage();
        }
        return view('administrador/materias', $data);
    }

    public function registrar()
    {
        $data = [
            'nombre_materia' => $this->request->getPost('nombre_materia'),
            'codigo_materia' => $this->request->getPost('codigo_materia'),
            'carrera_id' => $this->request->getPost('carrera_id'),
        ];

        if ($this->materiaModel->insert($data)) {
            return redirect()->to('/administrador/materias')->with('success', 'Materia registrada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->materiaModel->errors());
        }
    }

    public function edit($id)
    {
        $materia = $this->materiaModel->find($id);
        if (!$materia) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Materia no encontrada');
        }
        return $this->response->setJSON($materia);
    }

    public function update($id)
    {
        $data = [
            'nombre_materia' => $this->request->getPost('nombre_materia'),
            'codigo_materia' => $this->request->getPost('codigo_materia'),
            'carrera_id' => $this->request->getPost('carrera_id'),
        ];

        if ($this->materiaModel->update($id, $data)) {
            return redirect()->to('/administrador/materias')->with('success', 'Materia actualizada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->materiaModel->errors());
        }
    }

    public function delete($id)
    {
        if ($this->materiaModel->delete($id)) {
            return redirect()->to('/administrador/materias')->with('success', 'Materia eliminada exitosamente.');
        } else {
            return redirect()->to('/administrador/materias')->with('error', 'Error al eliminar la materia.');
        }
    }

    public function search($id)
    {
        $materia = $this->materiaModel->find($id);
        if (!$materia) {
            return $this->response->setJSON(['error' => 'Materia no encontrada']);
        }
        return $this->response->setJSON($materia);
    }

    public function searchCarrera()
    {
        $searchTerm = $this->request->getPost('search_carrera');
        if (!$searchTerm) {
            return $this->response->setJSON(['error' => 'Término de búsqueda requerido']);
        }

        $carreras = $this->carreraModel->like('ncar', $searchTerm)->findAll();
        return $this->response->setJSON($carreras);
    }
}
