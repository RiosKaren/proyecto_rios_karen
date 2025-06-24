<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\TallesProductoModel;
use CodeIgniter\Controller;

class CarritoController extends BaseController
{
    protected $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductosModel();
    }

    public function index()
    {
        return redirect()->to(previous_url())->with('success', 'Carrito actualizado.');

    }

    public function agregar()
    {
        $session = session();
        $carrito = $session->get('carrito') ?? [];

        $id_producto = $this->request->getPost('id_producto');
        $talle = $this->request->getPost('talle');
        $cantidad = (int) $this->request->getPost('cantidad');

        //Validaciones básicas
        if (!$id_producto || !$talle || $cantidad <= 0) {
            return redirect()->back()->with('error', 'Datos incompletos o inválidos.');
        }

        //Verificar que el producto existe
        $producto = $this->productoModel->find($id_producto);
        if (!$producto) {
            return redirect()->back()->with('error', 'Producto no encontrado.');
        }

        $tallesModel = new TallesProductoModel();
        $talleData = $tallesModel
            ->where('id_producto', $id_producto)
            ->where('talle', $talle)
            ->first();

        //Si no encuentra el talle, mostrar información útil
        if (!$talleData) {
            //Obtener todos los talles disponibles para este producto
            $tallesDisponibles = $tallesModel->where('id_producto', $id_producto)->findAll();
            $tallesTexto = '';
            foreach ($tallesDisponibles as $t) {
                $tallesTexto .= $t['talle'] . ' (ID: ' . $t['id_talle_producto'] . '), ';
            }
            
            return redirect()->back()->with('error', 
                'Talle no encontrado. Producto ID: ' . $id_producto . 
                ', Talle solicitado: "' . $talle . '"' .
                ', Talles disponibles: ' . rtrim($tallesTexto, ', ')
            );
        }

        $key = $id_producto . '_' . $talle;

        //Verificar cuánto hay en el carrito ya agregado
        $cantidadExistente = isset($carrito[$key]) ? $carrito[$key]['cantidad'] : 0;
        $nuevaCantidadTotal = $cantidadExistente + $cantidad;

        //Verificación de stock
        if ($nuevaCantidadTotal > $talleData['stock']) {
            return redirect()->back()
                ->with('error', 'Stock insuficiente. Solo hay ' . $talleData['stock'] . ' unidades disponibles para el talle seleccionado.');
        }

        //Obtener datos del producto para el carrito
        $carritoItem = [
            'id_producto' => $id_producto,
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'imagen' => $producto['url_imagen'],
            'talle' => $talle,
            'cantidad' => $nuevaCantidadTotal
        ];

        //Si pasa la validación, se agrega o actualiza
        $carrito[$key] = $carritoItem;

        $session->set('carrito', $carrito);
        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    public function eliminar($clave)
    {
        $carrito = session()->get('carrito') ?? [];

        if (isset($carrito[$clave])) {
            unset($carrito[$clave]);
            session()->set('carrito', $carrito);
        }

        return redirect()->back();
    }

    public function vaciar()
    {
        session()->remove('carrito');
        return redirect()->back();
    }


    public function actualizarCantidad()
    {
        $id = $this->request->getPost('id'); //clave: id_talle_producto
        $accion = $this->request->getPost('accion');

        $carrito = session()->get('carrito') ?? [];

        if (!isset($carrito[$id])) {
            return redirect()->back();
        }

        //Separar ID del producto y talle
        [$idProducto, $talle] = explode('_', $id);

        $talleModel = new \App\Models\TallesProductoModel();
        $talleData = $talleModel
            ->where('id_producto', $idProducto)
            ->where('talle', $talle)
            ->first();

        if (!$talleData) {
            return redirect()->back()->with('error', 'Talle no válido.');
        }

        $stockDisponible = $talleData['stock'];
        $cantidadActual = $carrito[$id]['cantidad'];

        if ($accion === 'sumar') {
            if ($cantidadActual < $stockDisponible) {
                $carrito[$id]['cantidad']++;
            } else {
                return redirect()->to('/carrito')->with('error', 'No hay más stock disponible para ese talle.');
            }
        }

        if ($accion === 'restar' && $cantidadActual > 1) {
            $carrito[$id]['cantidad']--;
        }

        session()->set('carrito', $carrito);
        return redirect()->to('/carrito');
    }
}
