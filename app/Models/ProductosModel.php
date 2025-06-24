<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'url_imagen',
        'activo'
    ];
}
