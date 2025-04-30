<?php

namespace App\Controllers;

class Home extends BaseController
{
   

    public function index()
    {
        return view('templates/layout', [
            'title' => 'Inicio',
            'content' => view('pages/inicio')
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
}
