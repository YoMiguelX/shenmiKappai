<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuario'; // Nombre real  tabla en la BD
    protected $primaryKey       = 'ID_USUARIO'; // clave primaria si se llama así

    protected $allowedFields = [
    'TIPO_DOCUMENTO',
    'DOC_USUARIO',
    'NOMBRE_USUARIO',
    'APELLIDO_USUARIO',
    'TEL_USUARIO',
    'CORREO_USUARIO',
    'CONTRASENA',
    'ESTADO_USUARIO',
    'FECHA_CREACION',
    'rol_ID_ROL',
    'reset_token',
    'reset_token_expiration'
];

  public function verificarUsuario($correo, $password)
    {
        // Buscar solo usuarios activos
        $usuario = $this->where('CORREO_USUARIO', $correo)
                        ->where('ESTADO_USUARIO', 'Activo')
                        ->first();

        if ($usuario) {
            // Verificar la contraseña cifrada
            if (password_verify($password, $usuario['CONTRASENA'])) {
                return $usuario;
            }
        }

        return null; // Usuario no encontrado o contraseña incorrecta
    }
    public function guardarToken($correo, $token, $expira)
{
    return $this->where('CORREO_USUARIO', $correo)
        ->set(['token_recuperacion' => $token, 'token_expira' => $expira])
        ->update();
}

public function buscarPorToken($token)
{
    return $this->where('token_recuperacion', $token)
                ->where('token_expira >=', date('Y-m-d H:i:s'))
                ->first();
}


}
