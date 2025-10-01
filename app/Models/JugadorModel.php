<?php

namespace App\Models;

use CodeIgniter\Model;

class JugadorModel extends Model
{
    protected $table = 'jugador'; 
    protected $primaryKey = 'ID_JUGADOR';
    protected $allowedFields = ['NOMBRE', 'FECHA_REGISTRO', 'ULTIMA_CONEXION', 'PROGRESO_JUGADOR_ID_PROGRESO_JUGADOR', 'usuario_ID_USUARIO']; // columnas reales

    public function obtenerJugadores()
    {
        return $this->findAll();
    }

public function obtenerEstadoJugadores()
{
    return $this->db->table('jugador j')
        ->select('
            u.NOMBRE_USUARIO as usuario,
            n.NOMBRE as mundo,
            p.NIVELES_ID_NIVELES as nivel,
            p.PUNTAJE_NIVEL as puntaje
        ')
        ->join('usuario u', 'j.usuario_ID_USUARIO = u.ID_USUARIO')
        ->join('progreso_jugador p', 'j.PROGRESO_JUGADOR_ID_PROGRESO_JUGADOR = p.ID_PROGRESO_JUGADOR')
        ->join('niveles n', 'p.NIVELES_ID_NIVELES = n.ID_NIVEL') // Asegúrate de que esta tabla exista
        ->get()
        ->getResultArray();
}
public function obtenerJugadoresConInfo()
{
    return $this->db->table('jugador')
        ->select('jugador.*, usuario.nombre as usuario, mundos.nombre as mundos')
        ->join('usuario', 'usuario.id = jugador.usuario_id')
        ->join('mundos', 'mundos.id = jugador.mundos_id')
        ->get()
        ->getResultArray();
}





}
