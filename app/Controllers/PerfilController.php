<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\FacturaModel;
use App\Models\DetalleFacturaModel;
use App\Models\ConsultasClientesModel;

class PerfilController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $usuarioModel = new UsuarioModel();
        $facturaModel = new FacturaModel();
        $consultasModel = new ConsultasClientesModel();

        $idUsuario = session()->get('id_usuario');
        
        //Obtener datos del usuario
        $usuario = $usuarioModel->find($idUsuario);
        
        //Obtener órdenes del usuario
        $ordenes = $facturaModel->where('id_usuario', $idUsuario)
            ->orderBy('fecha_creacion', 'DESC')
            ->findAll();

        //Obtener consultas del usuario
        $consultas = $consultasModel->where('id_usuario', $idUsuario)
            ->orderBy('hora_creada', 'DESC')
            ->findAll();

        $data = [
            'usuario' => $usuario,
            'ordenes' => $ordenes,
            'consultas' => $consultas
        ];

        return view('templates/layout', [
            'title' => 'Mi Perfil',
            'content' => view('back/perfil', $data)
        ]);
    }

    public function actualizarDatos()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $usuarioModel = new UsuarioModel();
        $idUsuario = session()->get('id_usuario');

        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $email = $this->request->getPost('email');

        //Verificar si el email ya existe (excepto el del usuario actual)
        $emailExistente = $usuarioModel->where('email', $email)
            ->where('id_usuario !=', $idUsuario)
            ->first();

        if ($emailExistente) {
            return redirect()->back()->with('error', 'El email ya está en uso por otro usuario.');
        }

        $datos = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email
        ];

        $usuarioModel->update($idUsuario, $datos);

        //Actualizar datos en la sesión
        session()->set([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email
        ]);

        return redirect()->to('back/perfil')->with('success', 'Datos actualizados correctamente.');
    }

    public function cambiarPassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $usuarioModel = new UsuarioModel();
        $idUsuario = session()->get('id_usuario');

        $passwordActual = $this->request->getPost('password_actual');
        $passwordNueva = $this->request->getPost('password_nueva');
        $passwordConfirmar = $this->request->getPost('password_confirmar');

        //Verificar contraseña actual
        $usuario = $usuarioModel->find($idUsuario);
        if (!password_verify($passwordActual, $usuario['contraseña'])) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
        }

        //Verificar que las nuevas contraseñas coincidan
        if ($passwordNueva !== $passwordConfirmar) {
            return redirect()->back()->with('error', 'Las nuevas contraseñas no coinciden.');
        }

        //Validar longitud de contraseña
        if (strlen($passwordNueva) < 6) {
            return redirect()->back()->with('error', 'La nueva contraseña debe tener al menos 6 caracteres.');
        }

        //Actualizar contraseña
        $usuarioModel->update($idUsuario, [
            'contraseña' => password_hash($passwordNueva, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('back/perfil')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function verOrden($idOrden)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $facturaModel = new FacturaModel();
        $detallesModel = new DetalleFacturaModel();
        $idUsuario = session()->get('id_usuario');

        //Verificar que la orden pertenezca al usuario
        $orden = $facturaModel->where('id_orden', $idOrden)
            ->where('id_usuario', $idUsuario)
            ->first();

        if (!$orden) {
            return redirect()->to('back/perfil')->with('error', 'Orden no encontrada.');
        }

        //Obtener detalles de la orden con información de productos
        $detalles = $detallesModel->select('detallesfactura.*, productos.nombre, productos.url_imagen')
            ->join('productos', 'productos.id_producto = detallesfactura.id_producto')
            ->where('id_factura', $idOrden)
            ->findAll();

        $data = [
            'orden' => $orden,
            'detalles' => $detalles,
            'usuario' => [
                'nombre' => session()->get('nombre'),
                'apellido' => session()->get('apellido'),
                'email' => session()->get('email')
            ]
        ];

        return view('templates/layout', [
            'title' => 'Detalle de Orden #' . $idOrden,
            'content' => view('back/detalle_orden', $data)
        ]);
    }
}