<?php

namespace App\Controllers;
use App\Models\ConsultaAdminModel;

class ConsultasAdmin extends BaseController
{
    public function crear()
    {
        $model = new ConsultaAdminModel();

        $data = [
            'email_usuario' => $this->request->getPost('email_usuario'),
            'mensaje' => $this->request->getPost('mensaje'),
            'asunto' => $this->request->getPost('asunto'),
        ];

        if ($model->insert($data)) {
            return redirect()->back()->with('mensaje', 'Consulta enviada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ocurrió un error al enviar la consulta.');
        }
    }
}
