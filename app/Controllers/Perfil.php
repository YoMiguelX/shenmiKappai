<?php

namespace App\Controllers;

class Perfil extends BaseController
{
    public function perfil()
    {
        // Obtener datos desde la sesión
        $usuario = session('usuario');

        if (!$usuario) {
            return redirect()->to('/login');
        }

        return view('paginas/Perfil', ['usuario' => $usuario]);
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    public function seguridad()
{
    return view('paginas/seguridad');
}

public function datosPerfil()
{
    return view('paginas/datos_perfil');
}

public function privacidad()
{
    return view('paginas/privacidad');
}

public function familia()
{
    return view('paginas/familia');
}

}
