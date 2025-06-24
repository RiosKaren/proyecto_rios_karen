<?php

namespace App\Controllers;

use App\Models\FacturaModel;
use App\Models\DetalleFacturaModel;
use App\Models\UsuarioModel;
use App\Models\ProductosModel;
use App\Models\DomiciliosModel; 

class ComprasAdminController extends BaseController
{
    public function index()
    {
        $facturaModel    = new FacturaModel();
        $detalleModel    = new DetalleFacturaModel();
        $usuarioModel    = new UsuarioModel();
        $productoModel   = new ProductosModel();
        $domiciliosModel = new DomiciliosModel(); 

        $facturas = $facturaModel
            ->orderBy('id_orden', 'DESC')
            ->findAll();

        foreach ($facturas as &$factura) {
            $usuario = $usuarioModel->find($factura['id_usuario']);

            //Obtener el domicilio si existe
            if (!empty($usuario['id_domicilio'])) {
                $domicilio = $domiciliosModel->find($usuario['id_domicilio']);
                if ($domicilio) {
                    $usuario['domicilio'] = $domicilio;
                    //El teléfono viene del domicilio según tu estructura
                    $usuario['telefono'] = $domicilio['telefono'] ?? '';
                }
            }

            $factura['usuario'] = $usuario;

            $factura['detalles'] = $detalleModel
                ->where('id_factura', $factura['id_orden'])
                ->findAll();

            foreach ($factura['detalles'] as &$detalle) {
                $detalle['producto'] = $productoModel->find($detalle['id_producto']);
            }
        }

        return view('templates/layout', [
            'title'   => 'Compras Realizadas',
            'content' => view('back/admin_compras', ['facturas' => $facturas])
        ]);
    }

    //mostrar el detalle de una factura específica
    public function detalle($id)
    {
        $facturaModel    = new FacturaModel();
        $detalleModel    = new DetalleFacturaModel();
        $usuarioModel    = new UsuarioModel();
        $productoModel   = new ProductosModel();
        $domiciliosModel = new DomiciliosModel();

        //Obtener la orden/factura
        $orden = $facturaModel->find($id);
        if (!$orden) {
            return redirect()->to('/admin/compras')->with('error', 'Factura no encontrada.');
        }

        //Obtener el usuario
        $usuario = $usuarioModel->find($orden['id_usuario']);
        if (!$usuario) {
            return redirect()->to('/admin/compras')->with('error', 'Usuario no encontrado.');
        }

        //Obtener domicilio si existe
        if (!empty($usuario['id_domicilio'])) {
            $domicilio = $domiciliosModel->find($usuario['id_domicilio']);
            if ($domicilio) {
                $usuario['domicilio'] = $domicilio;
                $usuario['telefono'] = $domicilio['telefono'] ?? '';
            }
        }

        //Obtener detalles de la factura con información de productos
        $detalles = $detalleModel->where('id_factura', $id)->findAll();
        
        foreach ($detalles as &$detalle) {
            $producto = $productoModel->find($detalle['id_producto']);
            if ($producto) {
                //Fusionar datos del producto con el detalle
                $detalle = array_merge($detalle, $producto);
            }
        }

        return view('templates/layout', [
            'title' => 'Detalle de Factura #' . str_pad($id, 6, '0', STR_PAD_LEFT),
            'content' => view('back/detalle_orden', [
                'orden' => $orden,
                'usuario' => $usuario,
                'detalles' => $detalles
            ])
        ]);
    }
}