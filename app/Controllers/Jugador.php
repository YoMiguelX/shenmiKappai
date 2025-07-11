<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class Jugador extends BaseController
{
    public function index()
    {
        $db = Database::connect();

        $query = $db->query("
            SELECT 
                j.ID_JUGADOR,
                j.NOMBRE AS NOMBRE_JUGADOR,
                j.FECHA_REGISTRO,
                j.ULTIMA_CONEXION,
                u.NOMBRE_USUARIO,
                n.NOMBRE_NIVEL AS nivel,
                m.NOMBRE_MUNDO,
                -- Progreso como porcentaje simulado del puntaje del nivel
                ROUND((p.PUNTAJE_NIVEL / 100) * 100, 2) AS progreso
            FROM jugador j
            JOIN usuario u ON j.usuario_ID_USUARIO = u.ID_USUARIO
            JOIN progreso_jugador p ON j.PROGRESO_JUGADOR_ID_PROGRESO_JUGADOR = p.ID_PROGRESO_JUGADOR
            JOIN niveles n ON p.NIVELES_ID_NIVELES = n.ID_NIVELES
            JOIN mundos m ON n.mundos_ID_MUNDOS = m.ID_MUNDOS
        ");

        $data['jugadores'] = $query->getResult();

        return view('paginas/jugador', $data);
    }
}
