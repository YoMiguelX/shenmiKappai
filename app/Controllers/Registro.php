<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Registro extends BaseController
{
    public function index()
    {
        return view('/paginas/registro'); // Asegúrate de tener app/Views/registro.php
    }

    public function guardar()
    {
        $usuarioModel = new UsuarioModel();

        $data = [
            'TIPO_DOCUMENTO'     => $this->request->getPost('TIPO_DOCUMENTO'),
            'DOC_USUARIO'        => $this->request->getPost('DOC_USUARIO'),
            'NOMBRE_USUARIO'     => $this->request->getPost('NOMBRE_USUARIO'),
            'APELLIDO_USUARIO'   => $this->request->getPost('APELLIDO_USUARIO'),
            'TEL_USUARIO'        => $this->request->getPost('TEL_USUARIO'),
            'CORREO_USUARIO'     => $this->request->getPost('CORREO_USUARIO'),
            'CONTRASENA' => password_hash($this->request->getPost('CONTRASENA'), PASSWORD_DEFAULT),


            'ESTADO_USUARIO' => 'activo',
            'FECHA_CREACION' =>  date('Y-m-d H:i:s'),
            'rol_ID_ROL' =>2 // usuario como usuario normal 
        ];

        // Guardar en la base de datos
        $usuarioModel->insert($data);

        // Redirigir al login con mensaje
        return redirect()->to('/login')->with('success', '¡Registro exitoso! Ahora puedes iniciar sesión.');
    
   

    }
}
