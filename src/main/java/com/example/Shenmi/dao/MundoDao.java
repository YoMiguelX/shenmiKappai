package com.example.Shenmi.dao;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.example.Shenmi.domain.Mundo;

@Repository
public interface MundoDao extends JpaRepository<Mundo, Integer> {
    // Aquí puedes agregar consultas personalizadas si lo necesitas
}
