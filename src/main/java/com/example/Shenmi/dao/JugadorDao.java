package com.example.Shenmi.dao;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.example.Shenmi.domain.Jugador;

@Repository
public interface JugadorDao extends JpaRepository<Jugador, Integer> {
    // Aquí puedes agregar consultas personalizadas si lo necesitas
}
