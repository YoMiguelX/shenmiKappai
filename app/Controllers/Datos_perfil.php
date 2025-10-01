<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Datos_perfil extends BaseController
{
    public function actualizar()
    {
        $session = session();
        $usuario = $session->get('usuario');

        if (!$usuario) {
            return redirect()->to('/login');
        }

        $usuarioModel = new UsuarioModel();

        $data = [
            'NOMBRE_USUARIO'     => $this->request->getPost('nombre'),
            'APELLIDO_USUARIO'   => $this->request->getPost('apellido'),
            'CORREO_USUARIO'     => $this->request->getPost('email'),
            'TEL_USUARIO'        => $this->request->getPost('telefono'),
        ];

        // Actualizar por ID del usuario en sesión
        $usuarioModel->update($usuario['ID_USUARIO'], $data);

        // Actualizar los datos de sesión (opcional)
        $usuario['NOMBRE_USUARIO'] = $data['NOMBRE_USUARIO'];
        $usuario['APELLIDO_USUARIO'] = $data['APELLIDO_USUARIO'];
        $usuario['CORREO_USUARIO'] = $data['CORREO_USUARIO'];
        $usuario['TEL_USUARIO'] = $data['TEL_USUARIO'];
        $session->set('usuario', $usuario);

        return redirect()->back()->with('success', 'Datos actualizados correctamente.');
    }
}
