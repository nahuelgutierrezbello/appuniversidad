<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RolModel;

class Usuarios extends BaseController
{
    protected $usuarioModel;
    protected $rolModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->rolModel = new RolModel();
    }

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        $data['roles'] = $this->rolModel->findAll();
        return view('administrador/usuarios', $data);
    }

    public function registrar()
    {
        $data = [
            'usuario' => $this->request->getPost('usuario'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol_id' => $this->request->getPost('rol_id'),
            'activo' => $this->request->getPost('activo') ? 1 : 0,
        ];

        if ($this->usuarioModel->insert($data)) {
            return redirect()->to('/administrador/usuarios')->with('success', 'Usuario registrado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->usuarioModel->errors());
        }
    }

    public function edit($id)
    {
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usuario no encontrado');
        }
        return $this->response->setJSON($usuario);
    }

    public function update($id)
    {
        $data = [
            'usuario' => $this->request->getPost('usuario'),
            'rol_id' => $this->request->getPost('rol_id'),
            'activo' => $this->request->getPost('activo') ? 1 : 0,
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($this->usuarioModel->update($id, $data)) {
            return redirect()->to('/administrador/usuarios')->with('success', 'Usuario actualizado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->usuarioModel->errors());
        }
    }

    public function delete($id)
    {
        if ($this->usuarioModel->delete($id)) {
            return redirect()->to('/administrador/usuarios')->with('success', 'Usuario eliminado exitosamente.');
        } else {
            return redirect()->to('/administrador/usuarios')->with('error', 'Error al eliminar el usuario.');
        }
    }

    public function search($id)
    {
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return $this->response->setJSON(['error' => 'Usuario no encontrado']);
        }
        return $this->response->setJSON($usuario);
    }
}
