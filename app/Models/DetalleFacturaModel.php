<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleFacturaModel extends Model
{
    protected $table = 'detallesfactura';
    protected $primaryKey = 'id_detalle_factura';
    protected $allowedFields = ['id_factura', 
        'id_producto', 
        'talle', 
        'cantidad', 
        'precio_unitario', 
        'subtotal', 
        'descuento', 
        'activo'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
}