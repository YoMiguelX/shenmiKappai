<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Seguridad extends BaseController
{
    public function index()
    {
        // Ejemplo de actividad reciente (puedes adaptar esto según tu modelo)
        $actividad = [
            ['fecha' => '2025-07-01 14:25:00', 'accion' => 'Inicio de sesión'],
            ['fecha' => '2025-06-30 18:40:00', 'accion' => 'Cambio de contraseña'],
        ];

        return view('seguridad', ['actividad' => $actividad]);
    }

    public function cambiar()
    {
        // Verifica que el usuario esté en sesión
        if (!session()->has('usuario') || !isset(session('usuario')['ID_USUARIO'])) {
            return redirect()->to('/login')->with('msg', 'Sesión expirada. Inicia sesión nuevamente.');
        }

        $usuarioId = session('usuario')['ID_USUARIO'];

        $actual    = $this->request->getPost('actual');
        $nueva     = $this->request->getPost('nueva');
        $confirmar = $this->request->getPost('confirmar');

        if ($nueva !== $confirmar) {
            return redirect()->back()->with('msg', 'Las contraseñas no coinciden.');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->back()->with('msg', 'Usuario no encontrado.');
        }

        // Verifica la contraseña actual
        if (!password_verify($actual, $usuario['CONTRASENA'])) {
            return redirect()->back()->with('msg', 'La contraseña actual es incorrecta.');
        }

        // Actualiza la contraseña
        $usuarioModel->update($usuarioId, [
            'CONTRASENA' => password_hash($nueva, PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('msg', 'Contraseña actualizada correctamente.');
    }
}
