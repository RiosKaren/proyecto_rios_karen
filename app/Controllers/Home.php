<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\TallesProductoModel;
use CodeIgniter\Controller;

class Home extends BaseController
{
    protected $productoModel;
    protected $talleModel;

    public function __construct()
    {
        $this->productoModel = new ProductosModel();
        $this->talleModel = new TallesProductoModel();
    }

    public function index()
    {
        $productos = $this->productoModel->where('activo', 1)->findAll();

        foreach ($productos as &$producto) {
            $producto['talles'] = $this->talleModel
                ->where('id_producto', $producto['id_producto'])
                ->findAll();
            
            //Calcular si tiene stock disponible
            $tieneStock = false;
            foreach ($producto['talles'] as $talle) {
                if ($talle['stock'] > 0) {
                    $tieneStock = true;
                    break;
                }
            }
            $producto['tiene_stock'] = $tieneStock;
        }

        //Ordenar productos: primero los que tienen stock, después los que no
        usort($productos, function($a, $b) {
            if ($a['tiene_stock'] == $b['tiene_stock']) {
                return 0; //Si ambos tienen el mismo estado de stock, mantener orden original
            }
            return $a['tiene_stock'] ? -1 : 1; //Los que tienen stock van primero
        });

        $data = [
            'title' => 'Inicio',
            'productos' => $productos
        ];

        return view('templates/layout', [
            'title' => $data['title'],
            'content' => view('pages/inicio', $data)
        ]);
    }

    public function quienes_somos()
    {
        return view('templates/layout', [
            'title' => 'Quienes somos',
            'content' => view('pages/quienes_somos')
        ]);
    }

    public function terminos()
    {
        return view('templates/layout', [
            'title' => 'Terminos y usos',
            'content' => view('pages/terminos')
        ]);
    }

    public function contacto()
    {
        return view('templates/layout', [
            'title' => 'Contacto',
            'content' => view('pages/contacto')
        ]);
    }

    public function comercializacion()
    {
        return view('templates/layout', [
            'title' => 'Comercializacion',
            'content' => view('pages/comercializacion')
        ]);
    }

    public function suscribir()
    {
        return redirect()->back()
                         ->with('success', 'Has sido suscrito con éxito.');
    }
}
