package com.example.Shenmi.Service;

import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;

import com.example.Shenmi.domain.Jugador;

public interface JugadorService {
   Page<Jugador> buscarConFiltros(String nombreJugador, String nombreUsuario, String mundo, String estado, Pageable pageable);
    long contarTotal();
    long contarActivos();
}
