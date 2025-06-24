<?php

namespace App\Controllers;

use App\Models\ConsultasClientesModel;
use CodeIgniter\Controller;

class ConsultasClientesController extends BaseController
{
    public function enviar()
    {
        helper(['form']);

        $modelo = new ConsultasClientesModel();

        $id_usuario = session()->get('id_usuario');

        //Si está logueado, tomar de sesión. Si no, tomar del formulario
        $nombre = $id_usuario
            ? session()->get('nombre') . ' ' . session()->get('apellido')
            : $this->request->getPost('nombre');

        $email = $id_usuario
            ? session()->get('email')
            : $this->request->getPost('email');

        $data = [
            'id_usuario'   => $id_usuario,
            'nombre'       => $nombre,
            'email'        => $email,
            'mensaje'      => $this->request->getPost('mensaje'),
            'respuesta'    => null,
            'estado'       => 'pendiente',
            'hora_creada'  => date('Y-m-d H:i:s'),
            'activo'       => 1
        ];

        $modelo->insert($data);

        return redirect()->to('/contacto')->with('success', 'Consulta enviada correctamente. Te responderemos pronto.');
    }

    public function verSolicitudes()
    {
        $modelo = new ConsultasClientesModel();
        $consultas = $modelo->orderBy('hora_creada', 'DESC')->findAll();

        return view('templates/layout', [
            'title' => 'Solicitudes de Contacto',
            'content' => view('back/admin_solicitudes', ['consultas' => $consultas])
        ]);
    }

    public function responder($id)
    {
        $respuesta = $this->request->getPost('respuesta');

        $modelo = new ConsultasClientesModel();
        $modelo->update($id, [
            'respuesta' => $respuesta,
            'estado'    => 'respondido'
        ]);

        return redirect()->to('/admin/solicitudes')->with('success', 'Respuesta enviada correctamente.');
    }

    public function cambiarEstado($id)
    {
        $estado = $this->request->getPost('estado');

        $modelo = new ConsultasClientesModel();
        $modelo->update($id, ['estado' => $estado]);

        return redirect()->to('/admin/solicitudes')->with('success', 'Estado actualizado.');
    }
}
