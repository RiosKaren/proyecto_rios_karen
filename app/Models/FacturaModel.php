<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaModel extends Model
{
    protected $table = 'factura';
    protected $primaryKey = 'id_orden';
    protected $allowedFields = ['id_usuario', 
        'importe_total', 
        'descuento', 
        'fecha_creacion'];
    protected $useTimestamps = false;
    protected $returnType = 'array';
}