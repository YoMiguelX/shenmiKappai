<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Administrador extends BaseController
{
    // Mostrar lista de administradores y usuarios
    public function index()
    {
    
        $usuarioModel = new UsuarioModel();

        // Administradores (ROL_ID_ROL = 1)
        $administradores = $usuarioModel->where('rol_ID_ROL', 1)->findAll();

        // Usuarios normales (ROL_ID_ROL = 2)
        $usuarios = $usuarioModel->where('rol_ID_ROL', 2)->findAll();

        return view('administrador/lista', [
            'administradores' => $administradores,
            'usuarios' => $usuarios
        ]);
    }

    // Mostrar formulario para crear administrador
    public function crear()
    {
        return view('administrador/registroAdmin');
    }

    // Guardar nuevo administrador
    public function guardar()
    {
        $usuarioModel = new UsuarioModel();

        $data = [
            'TIPO_DOCUMENTO'    => $this->request->getPost('TIPO_DOCUMENTO'),
            'DOC_USUARIO'       => $this->request->getPost('DOC_USUARIO'),
            'NOMBRE_USUARIO'    => $this->request->getPost('NOMBRE_USUARIO'),
            'APELLIDO_USUARIO'  => $this->request->getPost('APELLIDO_USUARIO'),
            'TEL_USUARIO'       => $this->request->getPost('TEL_USUARIO'),
            'CORREO_USUARIO'    => $this->request->getPost('CORREO_USUARIO'),
            'CONTRASENA'        => password_hash($this->request->getPost('CONTRASENA'), PASSWORD_DEFAULT),
            'ESTADO_USUARIO'    => 'activo',
            'FECHA_CREACION'    => date('Y-m-d H:i:s'),
            'ROL_ID_ROL'        => 1 // ROL 1: Administrador
        ];

        $usuarioModel->insert($data);

        return redirect()->to('/administrador')->with('mensaje', 'Administrador creado correctamente.');
    }

    // Mostrar formulario de edición
    public function editar($id)
    {
        $usuarioModel = new UsuarioModel();
        $admin = $usuarioModel->find($id);

        if (!$admin || $admin['rol_ID_ROL'] != 1) {
            return redirect()->to('/administrador')->with('error', 'Administrador no encontrado.');
        }

        return view('administrador/editar', ['admin' => $admin]);
    }

    // Actualizar administrador
    public function actualizar($id)
    {
        $usuarioModel = new UsuarioModel();

        $admin = $usuarioModel->find($id);

        if (!$admin || $admin['rol_ID_ROL'] != 1) {
            return redirect()->to('/administrador')->with('error', 'Administrador no encontrado.');
        }

        $data = [
            'TIPO_DOCUMENTO'    => $this->request->getPost('TIPO_DOCUMENTO'),
            'DOC_USUARIO'       => $this->request->getPost('DOC_USUARIO'),
            'NOMBRE_USUARIO'    => $this->request->getPost('NOMBRE_USUARIO'),
            'APELLIDO_USUARIO'  => $this->request->getPost('APELLIDO_USUARIO'),
            'TEL_USUARIO'       => $this->request->getPost('TEL_USUARIO'),
            'CORREO_USUARIO'    => $this->request->getPost('CORREO_USUARIO'),
        ];

        $usuarioModel->update($id, $data);

        return redirect()->to('/administrador')->with('mensaje', 'Administrador actualizado correctamente.');
    }

    // Eliminar solo usuarios
    public function eliminarUsuario($id)
    {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($id);

        if (!$usuario) {
            return redirect()->to('/administrador')->with('error', 'El usuario no existe.');
        }

        if ($usuario['rol_ID_ROL'] == 2) {
            // Enviar correo antes de eliminar
            $email = \Config\Services::email();

            $email->setTo($usuario['CORREO_USUARIO']);
            $email->setSubject('Cuenta eliminada');
            $email->setMessage("
                <p>Hola <strong>{$usuario['NOMBRE_USUARIO']} {$usuario['APELLIDO_USUARIO']}</strong>,</p>
                <p>Te informamos que tu cuenta ha sido eliminada del sistema por los siguientes motivos:</p>
                <ul>
                    <li>Inactividad prolongada.</li>
                    <li>Incumplimiento de los términos del servicio.</li>
                </ul>
                <p>Si consideras que se trata de un error, contáctanos respondiendo a este correo.</p>
                <p>Atentamente,<br>Equipo de Shenmi Kappai</p>
            ");

            if ($email->send()) {
                // Eliminar después de enviar el correo exitosamente
                $usuarioModel->delete($id);
                return redirect()->to('/administrador')->with('mensaje', 'Usuario eliminado y notificado por correo.');
            } else {
                return redirect()->to('/administrador')->with('error', 'No se pudo enviar el correo al usuario.');
            }
        }

        return redirect()->to('/administrador')->with('error', 'No se puede eliminar este usuario.');
    }

    // Cerrar sesión
    public function cerrarSesion()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
