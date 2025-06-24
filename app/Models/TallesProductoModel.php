<?php

namespace App\Models;

use CodeIgniter\Model;

class TallesProductoModel extends Model
{
    protected $table = 'tallesproducto';
    protected $primaryKey = 'id_talle_producto';
    protected $allowedFields = [
        'id_producto',
        'talle',
        'stock'
    ];
}
