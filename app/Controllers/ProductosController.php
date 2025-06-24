<?php
namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\TallesProductoModel;
use CodeIgniter\Controller;

class ProductosController extends BaseController
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
        $productos = $this->productoModel->findAll();

        foreach ($productos as &$producto) {
            $producto['talles'] = $this->talleModel
                ->where('id_producto', $producto['id_producto'])
                ->findAll();
        }

        return view('templates/layout', [
            'title' => 'Administrar productos',
            'content' => view('back/admin_productos', ['productos' => $productos])
        ]);
    }

    public function crear()
    {
        return view('templates/layout', [
            'title' => 'Crear producto',
            'content' => view('back/crear_producto')
        ]);
    }

    public function guardar()
    {
        $imagen = $this->request->getFile('imagen');

        if (!$imagen->isValid()) {
            return redirect()->back()->with('error', 'Error al subir la imagen.');
        }

        $extension = $imagen->getClientExtension();
        $nombreSinExt = pathinfo($imagen->getRandomName(), PATHINFO_FILENAME);
        $imagenNombre = $nombreSinExt . '.' . $extension;

        $rutaDestino = ROOTPATH . 'public/assets/img/uploads/';
        if (file_exists($rutaDestino . $imagenNombre)) {
            $imagenNombre = time() . '_' . $imagenNombre;
        }

        $imagen->move($rutaDestino, $imagenNombre);

        $this->productoModel->insert([
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'precio'        => $this->request->getPost('precio'),
            'stock'         => 0,
            'url_imagen'    => $imagenNombre,
            'activo'        => 1
        ]);

        $productoId = $this->productoModel->getInsertID();

        $talles = $this->request->getPost('talles');
        $stocks = $this->request->getPost('stocks');

        $totalStock = 0;

        foreach ($talles as $i => $talle) {
            $stock = (int)$stocks[$i];
            $totalStock += $stock;

            $this->talleModel->insert([
                'id_producto' => $productoId,
                'talle' => $talle,
                'stock' => $stock
            ]);
        }

        $this->productoModel->update($productoId, ['stock' => $totalStock]);

        return redirect()->to('/admin/productos')->with('success', 'Producto agregado correctamente.');
    }

    public function editar($id)
    {
        $producto = $this->productoModel->find($id);
        $talles = $this->talleModel->where('id_producto', $id)->findAll();

        return view('templates/layout', [
            'title' => 'Editar producto',
            'content' => view('back/editar_producto', [
                'producto' => $producto,
                'talles' => $talles
            ])
        ]);
    }

    public function actualizar($id)
    {
        $producto = $this->productoModel->find($id);
        if (!$producto) {
            return redirect()->to('/admin/productos')->with('error', 'Producto no encontrado.');
        }

        $imagen = $this->request->getFile('imagen');
        $imagenNombre = $producto['url_imagen'];

        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $rutaAnterior = ROOTPATH . 'public/assets/img/uploads/' . $imagenNombre;
            if (file_exists($rutaAnterior) && is_file($rutaAnterior)) {
                unlink($rutaAnterior);
            }

            $extension = $imagen->getClientExtension();
            $nombreSinExt = pathinfo($imagen->getRandomName(), PATHINFO_FILENAME);
            $imagenNombre = $nombreSinExt . '.' . $extension;

            if (file_exists(ROOTPATH . 'public/assets/img/uploads/' . $imagenNombre)) {
                $imagenNombre = time() . '_' . $imagenNombre;
            }

            $imagen->move(ROOTPATH . 'public/assets/img/uploads/', $imagenNombre);
        }

        $this->productoModel->update($id, [
            'nombre'        => $this->request->getPost('nombre'),
            'descripcion'   => $this->request->getPost('descripcion'),
            'precio'        => $this->request->getPost('precio'),
            'url_imagen'    => $imagenNombre
        ]);

        $talles = $this->request->getPost('talles');
        $stocks = $this->request->getPost('stocks');

        $nuevoStockTotal = 0;

        if ($talles && $stocks) {
            foreach ($talles as $i => $talle) {
                $stock = (int)$stocks[$i];
                $nuevoStockTotal += $stock;

                $existente = $this->talleModel
                    ->where('id_producto', $id)
                    ->where('talle', $talle)
                    ->first();

                if ($existente) {
                    $this->talleModel->update($existente['id_talle_producto'], [
                        'stock' => $stock
                    ]);
                } else {
                    $this->talleModel->insert([
                        'id_producto' => $id,
                        'talle' => $talle,
                        'stock' => $stock
                    ]);
                }
            }
        }

        $this->productoModel->update($id, ['stock' => $nuevoStockTotal]);

        return redirect()->to('/admin/productos')->with('success', 'Producto actualizado correctamente.');
    }

    public function deshabilitar($id)
    {
        $this->productoModel->update($id, ['activo' => 0]);
        return redirect()->to('/admin/productos');
    }

    public function habilitar($id)
    {
        $this->productoModel->update($id, ['activo' => 1]);
        return redirect()->to('/admin/productos')->with('success', 'Producto habilitado correctamente.');
    }

    public function ver($id)
    {
        $producto = $this->productoModel->find($id);

        if (!$producto) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Producto no encontrado");
        }

        $talles = $this->talleModel->where('id_producto', $id)->findAll();
        $producto['talles'] = $talles;

        return view('templates/layout', [
            'title' => $producto['nombre'],
            'content' => view('pages/producto_detalle', ['producto' => $producto])
        ]);
    }

    public function buscar()
    {
        $busqueda = $this->request->getGet('q') ?? '';
        $productos = [];

        if (!empty($busqueda)) {
            //Buscar productos por nombre que contengan el término de búsqueda
            $productos = $this->productoModel
                ->like('nombre', $busqueda)
                ->where('activo', 1)
                ->findAll();
        } else {
            //Si no hay búsqueda, mostrar todos los productos activos
            $productos = $this->productoModel
                ->where('activo', 1)
                ->findAll();
        }

        //Agregar información de stock para cada producto
        foreach ($productos as &$producto) {
            $talles = $this->talleModel
                ->where('id_producto', $producto['id_producto'])
                ->findAll();
            
            $stockTotal = 0;
            foreach ($talles as $talle) {
                $stockTotal += $talle['stock'];
            }
            
            $producto['stock'] = $stockTotal;
            $producto['tiene_stock'] = $stockTotal > 0;
            $producto['talles'] = $talles;
        }

        return view('templates/layout', [
            'title' => !empty($busqueda) ? "Resultados para: {$busqueda}" : 'Todos los productos',
            'content' => view('pages/buscar_producto', [
                'productos' => $productos,
                'busqueda' => $busqueda
            ])
        ]);
    }

    public function catalogo()
    {
        $productos = $this->productoModel
            ->where('activo', 1)
            ->findAll();

        //Agregar información de stock para cada producto
        foreach ($productos as &$producto) {
            $talles = $this->talleModel
                ->where('id_producto', $producto['id_producto'])
                ->findAll();
            
            $stockTotal = 0;
            foreach ($talles as $talle) {
                $stockTotal += $talle['stock'];
            }
            
            $producto['stock'] = $stockTotal;
            $producto['tiene_stock'] = $stockTotal > 0;
            $producto['talles'] = $talles;
        }

        return view('templates/layout', [
            'title' => 'Catálogo de productos',
            'content' => view('pages/buscar_producto', [
                'productos' => $productos,
                'busqueda' => ''
            ])
        ]);
    }

}
