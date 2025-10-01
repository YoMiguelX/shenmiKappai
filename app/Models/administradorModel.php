<?php
namespace App\Models;

use CodeIgniter\Model;

class AdministradorModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'ID_USUARIO';
    protected $allowedFields = [
        'TIPO_DOCUMENTO', 'DOC_USUARIO', 'NOMBRE_USUARIO', 'APELLIDO_USUARIO',
        'TEL_USUARIO', 'CORREO_USUARIO', 'CONTRASENA',
        'ESTADO_USUARIO', 'FECHA_CREACION', 'rol_ID_ROL'
    ];
}
