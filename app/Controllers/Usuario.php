<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuario extends BaseController
{
    public function registro()
    {
        return view('/registro'); // Asegúrate de que exista la vista app/Views/registro.php
    }
}
?>
