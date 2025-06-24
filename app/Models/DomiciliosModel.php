<?php

namespace App\Models;

use CodeIgniter\Model;

class DomiciliosModel extends Model
{
    protected $table = 'domicilios';
    protected $primaryKey = 'id_domicilio';
    protected $allowedFields = ['calle', 
        'numero', 
        'codigo_postal', 
        'localidad', 
        'provincia', 
        'pais', 
        'telefono', 
        'activo'];
    public $useTimestamps = false;
}