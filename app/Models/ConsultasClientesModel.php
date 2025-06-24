<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultasClientesModel extends Model
{
    protected $table = 'consultasclientes';
    protected $primaryKey = 'id_consulta';
    
    protected $allowedFields = [
        'id_usuario',
        'nombre',
        'email',
        'mensaje',
        'respuesta',
        'estado',
        'hora_creada',
        'activo'
    ];

    public $useTimestamps = false;
}
