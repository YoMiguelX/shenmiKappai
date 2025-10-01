<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Login extends BaseController
{
    public function index()
    {
        return view('paginas/login');
    }

    public function acceder()
    {
        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('contrasena');

        $model = new UsuarioModel();
        $usuario = $model->verificarUsuario($correo, $password);

        if ($usuario) {
            // Guardar los datos completos en sesión bajo 'usuario'
            session()->set([
                'usuario' => [
                    'ID_USUARIO'       => $usuario['ID_USUARIO'],
                    'NOMBRE_USUARIO'   => $usuario['NOMBRE_USUARIO'],
                    'APELLIDO_USUARIO' => $usuario['APELLIDO_USUARIO'],
                    'CORREO_USUARIO'   => $usuario['CORREO_USUARIO'],
                    'TEL_USUARIO'      => $usuario['TEL_USUARIO'],
                    'rol_ID_ROL'       => $usuario['rol_ID_ROL']
                ],
                'logueado' => true
            ]);

            // Redirección por rol
            switch ($usuario['rol_ID_ROL']) {
                case 1:
                    return redirect()->to('/administrador');
                case 2:
                    return redirect()->to('/perfil');
                default:
                    return redirect()->to('/login');
            }
        } else {
            return redirect()->back()->with('success', 'Usuario o contraseña incorrectos.');
        }
    }

    public function salir()
    {
        session()->destroy();

        return redirect()->to('/login')
                         ->with('msg', 'Has cerrado sesión correctamente.')
                         ->withHeaders([
                             'Cache-Control' => 'no-cache, no-store, must-revalidate',
                             'Pragma' => 'no-cache',
                             'Expires' => '0',
                         ]);
    }

    public function restablecer()
    {
        return view('paginas/restablecer');
    }

    public function mostrarFormularioRestablecer($token)
    {
        $model = new UsuarioModel();
        $usuario = $model->where('reset_token', $token)
                         ->where('reset_token_expiration >=', date('Y-m-d H:i:s'))
                         ->first();

        if ($usuario) {
            return view('paginas/nueva_clave', ['token' => $token]);
        } else {
            return redirect()->to('/login')->with('error', 'El enlace ha expirado o no es válido.');
        }
    }

    public function enviarRestablecimiento()
    {
        $correo = $this->request->getPost('email');
        $model = new UsuarioModel();
        $usuario = $model->where('CORREO_USUARIO', $correo)->first();

        if ($usuario) {
            $token = bin2hex(random_bytes(32));
            $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $model->update($usuario['ID_USUARIO'], [
                'reset_token' => $token,
                'reset_token_expiration' => $expiracion
            ]);

            $enlace = base_url("restablecer/$token");

            $email = \Config\Services::email();
            $email->setTo($correo);
            $email->setFrom('shenmikappai@gmail.com', 'Shenmi Kappai - Soporte');
            $email->setSubject('Restablecimiento de Contraseña');
            $email->setMessage("
                <h3>Hola {$usuario['NOMBRE_USUARIO']}</h3>
                <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                <p><a href='{$enlace}'>{$enlace}</a></p>
                <p>Este enlace expirará en 1 hora.</p>
            ");

            if ($email->send()) {
                return redirect()->to('/login')->with('success', 'Correo enviado correctamente.');
            } else {
                return redirect()->back()->with('msg', 'No se pudo enviar el correo. Intenta más tarde.');
            }
        } else {
            return redirect()->back()->with('msg', 'El correo no está registrado.');
        }
    }

    public function guardarNuevaClave()
    {
        $token = $this->request->getPost('token');
        $nuevaClave = $this->request->getPost('contrasena');

        $model = new UsuarioModel();
        $usuario = $model->where('reset_token', $token)
                         ->where('reset_token_expiration >=', date('Y-m-d H:i:s'))
                         ->first();

        if ($usuario) {
            $model->update($usuario['ID_USUARIO'], [
                'CONTRASENA' => password_hash($nuevaClave, PASSWORD_DEFAULT),
                'reset_token' => null,
                'reset_token_expiration' => null
            ]);

            return redirect()->to('/login')->with('success', 'Contraseña actualizada correctamente.');
        } else {
            return redirect()->to('/login')->with('msg', 'Token inválido o expirado.');
        }
    }
}
