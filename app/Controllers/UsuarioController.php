<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    //FUNCIONES PÚBLICAS

    public function login()
    {
        helper(['form']);
        return view('templates/layout', [
            'title' => 'Iniciar Sesión',
            'content' => view('back/login')
        ]);
    }

    public function loginPost()
    {
        $session = session();
        $model = new UsuarioModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $model->where('email', $email)->first();

        if ($usuario && !$usuario['activo']) {
            return redirect()->back()->with('error', 'Tu cuenta está deshabilitada. Contactá al administrador.');
        }

        if ($usuario && password_verify($password, $usuario['contraseña'])) {
            $session->set([
                'id_usuario' => $usuario['id_usuario'],
                'nombre'     => $usuario['nombre'],
                'apellido'   => $usuario['apellido'],
                'email'      => $usuario['email'],
                'id_rol'     => $usuario['id_rol'],
                'isLoggedIn' => true
            ]);

            //Verificar si hay una URL de redirección guardada
            $redirectUrl = $session->get('redirect_after_login');
            if ($redirectUrl) {
                $session->remove('redirect_after_login');
                return redirect()->to($redirectUrl);
            }

            //Redirección según rol (comportamiento por defecto)
            if ($usuario['id_rol'] == 1) {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/inicio');
            }

        } else {
            return redirect()->back()->with('error', 'Correo o contraseña incorrectos.');
        }
    }

    public function registro()
    {
        helper(['form']);
        return view('templates/layout', [
            'title' => 'Registro',
            'content' => view('back/registro')
        ]);
    }

    public function registroPost()
    {
        helper(['form']);
        $model = new UsuarioModel();

        $nombre     = $this->request->getPost('nombre');
        $apellido   = $this->request->getPost('apellido');
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');
        $password2  = $this->request->getPost('password_confirm');

        if ($password !== $password2) {
            return redirect()->back()->withInput()->with('error', 'Las contraseñas no coinciden.');
        }

        if ($model->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Ingresaste un correo ya registrado.');
        }

        $data = [
            'nombre'     => $nombre,
            'apellido'   => $apellido,
            'email'      => $email,
            'contraseña' => password_hash($password, PASSWORD_DEFAULT),
            'id_rol'     => 2,
            'activo'     => 1
        ];

        $model->insert($data);

        //Verificar si hay una URL de redirección guardada (para después del registro)
        $redirectUrl = session()->get('redirect_after_login');
        if ($redirectUrl) {
            return redirect()->to('/login')->with('success', 'Registro exitoso. Iniciá sesión para continuar con tu compra.');
        }

        return redirect()->to('/login')->with('success', 'Registro exitoso. Iniciá sesión.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    //PANTALLA PARA ADMIN

    public function admin()
    {
        if (!session()->get('isLoggedIn') || session()->get('id_rol') != 1) {
            return redirect()->to('/login');
        }

        return view('templates/layout', [
            'title' => 'Panel de administración',
            'content' => view('back/panel_admin')
        ]);
    }

    //FUNCIONES PARA GESTIÓN DE USUARIOS (admin)

    public function usuarios()
    {
        $modelo = new UsuarioModel();
        $todos = $modelo->findAll();

        $admins = [];
        $habilitados = [];
        $deshabilitados = [];

        foreach ($todos as $usuario) {
            if ($usuario['id_rol'] == 1 && $usuario['activo']) {
                $admins[] = $usuario;
            } elseif ($usuario['activo']) {
                $habilitados[] = $usuario;
            } else {
                $deshabilitados[] = $usuario;
            }
        }

        $data = [
            'admins' => $admins,
            'habilitados' => $habilitados,
            'deshabilitados' => $deshabilitados,
            'adminCount' => count($admins)
        ];

        return view('templates/layout', [
            'title' => 'Lista de Usuarios',
            'content' => view('back/admin_usuarios', $data)
        ]);
    }

    public function desactivar($id)
    {
        $modelo = new UsuarioModel();
        $usuario = $modelo->find($id);

        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado.');
        }

        //Si es admin, verificar que no sea el último activo
        if ($usuario['id_rol'] == 1 && $usuario['activo']) {
            $adminsActivos = $modelo->where('id_rol', 1)->where('activo', 1)->countAllResults();

            if ($adminsActivos <= 1) {
                return redirect()->to('/admin/usuarios')->with('error', 'No se puede desactivar al único administrador activo.');
            }
        }

        $modelo->update($id, ['activo' => 0]);
        return redirect()->to('/admin/usuarios')->with('success', 'Usuario desactivado correctamente.');
    }

    public function activar($id)
    {
        $modelo = new UsuarioModel();
        $modelo->update($id, ['activo' => 1]);
        return redirect()->to('/admin/usuarios')->with('success', 'Usuario activado correctamente.');
    }

    public function recuperar()
    {
        helper(['form']);
        return view('templates/layout', [
            'title'   => 'Recuperar contraseña',
            'content' => view('back/recuperar')
        ]);
    }

    public function recuperarPost()
    {
        helper(['form']);
        $email = $this->request->getPost('email');
        $model = new \App\Models\UsuarioModel();
        $usuario = $model->where('email', $email)->first();

        if ($usuario) {
            //Acá podrías integrar la librería de Email para enviar el link de recuperación.
            //Por ahora solo mostramos el mensaje de éxito:
            return redirect()->back()->with('success', 'Hemos enviado un correo electrónico para el cambio de tu contraseña. Seguí los pasos indicados.');
        } else {
            return redirect()->back()->with('error', 'El correo electrónico no existe en nuestra base de datos.');
        }
    }
}