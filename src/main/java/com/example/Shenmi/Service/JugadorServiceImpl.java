package com.example.Shenmi.Service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Service;

import com.example.Shenmi.dao.JugadorDao;
import com.example.Shenmi.domain.Jugador;

@Service
public class JugadorServiceImpl implements JugadorService {

    @Autowired
    private JugadorDao jugadorDao;

    @Override
    public Page<Jugador> buscarConFiltros(String nombreJugador, String nombreUsuario, String mundo, String estado, Pageable pageable) {
        // Aquí puedes implementar filtros con consultas personalizadas en JugadorDao
        return jugadorDao.findAll(pageable);
    }

    @Override
    public long contarTotal() {
        return jugadorDao.count();
    }

    @Override
    public long contarActivos() {
        return jugadorDao.findAll().stream()
                .filter(j -> "ACTIVO".equalsIgnoreCase(j.getEstado()))
                .count();
    }
    
   
}
