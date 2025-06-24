<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = [
        'id_rol',
        'id_domicilio',
        'nombre',
        'apellido',
        'email',
        'contraseña',
        'activo'
    ];
}
