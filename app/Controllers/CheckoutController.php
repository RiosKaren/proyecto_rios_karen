<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Controllers\DomiciliosController;
use App\Models\FacturaModel;
use App\Models\DetalleFacturaModel;
use App\Models\ProductosModel;        
use App\Models\TallesProductoModel;   

class CheckoutController extends BaseController
{
    //Muestra la vista del formulario de checkout
    public function index()
    {
        //Verificar si el usuario está logueado
        if (!session()->get('isLoggedIn')) {
            //Guardar la URL de destino para redirigir después del login
            session()->set('redirect_after_login', '/checkout');
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para realizar una compra.');
        }

        //Verificar si el usuario es administrador
        $rolUsuario = session()->get('id_rol');
        if ($rolUsuario == 1) { // Asumiendo que id_rol = 1 es administrador
            return redirect()->to('/login')->with('error', 'No puedes comprar siendo administrador.');
        }

        //Verificar si hay productos en el carrito
        $carrito = session()->get('carrito') ?? [];
        if (empty($carrito)) {
            return redirect()->to('/')->with('error', 'El carrito está vacío.');
        }

        return view('templates/layout', [
            'title' => 'Checkout',
            'content' => view('pages/checkout')
        ]);
    }

    //Procesa el formulario de compra
    public function procesar()
    {
        //Verificar si el usuario está logueado
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para realizar una compra.');
        }

        //Verificar si el usuario es administrador
        $rolUsuario = session()->get('id_rol');
        if ($rolUsuario == 1) { // Asumiendo que id_rol = 1 es administrador
            return redirect()->to('/')->with('error', 'No puedes comprar siendo administrador.');
        }

        $carrito = session()->get('carrito') ?? [];

        if (empty($carrito)) {
            return redirect()->to('/')->with('error', 'El carrito está vacío.');
        }

        //Verificar stock disponible antes de procesar
        if (!$this->verificarStockDisponible($carrito)) {
            return redirect()->to('/carrito')->with('error', 'Algunos productos no tienen stock suficiente.');
        }

        //Obtener datos del usuario logueado
        $idUsuario = session()->get('id_usuario');
        $email     = session()->get('email');
        $nombre    = session()->get('nombre');
        $apellido  = session()->get('apellido');

        // Guardar domicilio en la base de datos
        $domicilioData = [
            'calle'         => $this->request->getPost('calle'),
            'numero'        => $this->request->getPost('numero'),
            'codigo_postal' => $this->request->getPost('codigo_postal'),
            'localidad'     => $this->request->getPost('localidad'),
            'provincia'     => $this->request->getPost('provincia'),
            'pais'          => $this->request->getPost('pais'),
            'telefono'      => $this->request->getPost('telefono'),
            'activo'        => 1
        ];

        //Usamos el controlador correspondiente para guardar
        $domicilioController = new DomiciliosController();
        $idDomicilio = $domicilioController->guardar($domicilioData);

        //Calcular totales
        $subtotal = $this->calcularSubtotal($carrito);
        $envio = 15;
        $total = $subtotal + $envio;

        //Crear la factura
        $facturaModel = new FacturaModel();
        $facturaData = [
            'id_usuario'     => $idUsuario,
            'importe_total'  => $total,
            'descuento'      => 0,
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];
        
        $facturaModel->insert($facturaData);
        $idFactura = $facturaModel->getInsertID();

        //Crear los detalles de la factura
        $detallesModel = new DetalleFacturaModel(); 
        
        foreach ($carrito as $item) {
            $subtotalItem = $item['precio'] * $item['cantidad'];
            
            $detalleData = [
                'id_factura'      => $idFactura,
                'id_producto'     => $item['id_producto'],
                'talle'           => $item['talle'],
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'subtotal'        => $subtotalItem,
                'descuento'       => 0,
                'activo'          => 1
            ];
            
            $detallesModel->insert($detalleData);
        }

        //Actualizar stock después de crear la factura
        $this->actualizarStock($carrito);

        //Consolidar la data para mostrar en confirmación
        $data = [
            'id_factura'    => $idFactura,
            'email'         => $email,
            'nombre'        => $nombre,
            'apellido'      => $apellido,
            'telefono'      => $domicilioData['telefono'],
            'direccion'     => $domicilioData['calle'] . ' ' . $domicilioData['numero'],
            'codigo_postal' => $domicilioData['codigo_postal'],
            'localidad'     => $domicilioData['localidad'],
            'provincia'     => $domicilioData['provincia'],
            'pais'          => $domicilioData['pais'],
            'envio'         => $this->request->getPost('envio'),
            'carrito'       => $carrito,
            'subtotal'      => $subtotal,
            'costo_envio'   => $envio,
            'total'         => $total,
            'fecha'         => date('d/m/Y H:i'),
            'domicilio_guardado' => $idDomicilio
        ];

        //Limpiar el carrito
        session()->remove('carrito');

        return view('templates/layout', [
            'title' => 'Compra Confirmada',
            'content' => view('pages/checkout_confirmado', ['data' => $data])
        ]);
    }

    //Método para verificar stock disponible
    private function verificarStockDisponible($carrito)
    {
        $tallesModel = new TallesProductoModel();
        
        foreach ($carrito as $item) {
            //Buscar el talle específico del producto
            $talleProducto = $tallesModel->where([
                'id_producto' => $item['id_producto'],
                'talle' => $item['talle']
            ])->first();
            
            if (!$talleProducto || $talleProducto['stock'] < $item['cantidad']) {
                return false;
            }
        }
        
        return true;
    }

    //Método para actualizar stock
    private function actualizarStock($carrito)
    {
        $productosModel = new ProductosModel();
        $tallesModel = new TallesProductoModel();
        
        foreach ($carrito as $item) {
            $idProducto = $item['id_producto'];
            $talle = $item['talle'];
            $cantidad = $item['cantidad'];
            
            //1. Actualizar stock del talle específico
            $talleProducto = $tallesModel->where([
                'id_producto' => $idProducto,
                'talle' => $talle
            ])->first();
            
            if ($talleProducto) {
                $nuevoStockTalle = $talleProducto['stock'] - $cantidad;
                $tallesModel->update($talleProducto['id_talle_producto'], [
                    'stock' => max(0, $nuevoStockTalle) //Evitar stock negativo
                ]);
            }
            
            //2. Actualizar stock total del producto
            $producto = $productosModel->find($idProducto);
            if ($producto) {
                $nuevoStockTotal = $producto['stock'] - $cantidad;
                $productosModel->update($idProducto, [
                    'stock' => max(0, $nuevoStockTotal) //Evitar stock negativo
                ]);
            }
        }
    }

    //Calcula el subtotal sin envío
    private function calcularSubtotal($carrito)
    {
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        return $subtotal;
    }

    //Calcula el total con envío
    private function calcularTotal($carrito)
    {
        $subtotal = $this->calcularSubtotal($carrito);
        $envio = 15;
        return $subtotal + $envio;
    }
}