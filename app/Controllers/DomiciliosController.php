<?php

namespace App\Controllers;

use App\Models\DomiciliosModel; 

class DomiciliosController extends BaseController
{
    public function guardar($data)
    {
        $domicilioModel = new DomiciliosModel(); 
        $domicilio = [
            'calle'         => $data['calle'],
            'numero'        => $data['numero'],
            'codigo_postal' => $data['codigo_postal'],
            'localidad'     => $data['localidad'],
            'provincia'     => $data['provincia'],
            'pais'          => $data['pais'],
            'telefono'      => $data['telefono'],
            'activo'        => 1
        ];

        $domicilioModel->insert($domicilio);
        return $domicilioModel->getInsertID();
    }
}