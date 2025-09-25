package com.example.Shenmi.domain;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.Table;


@Entity
@Table(name = "jugador")
public class Jugador {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "ID_JUGADOR")
    private Integer idJugador;

    @Column(name = "NOMBRE", nullable = false, length = 50)
    private String nombre;

    @Column(name = "PROGRESO", nullable = false)
    private int progreso;

    // Relación con usuario
    @ManyToOne
    @JoinColumn(name = "usuario_ID_USUARIO", nullable = false)
    private Usuario usuario;
    @Column(name = "ESTADO", nullable = false, length = 20)
private String estado;

public String getEstado() { return estado; }
public void setEstado(String estado) { this.estado = estado; }
public Integer getIdJugador() {
    return idJugador;
}
public void setIdJugador(Integer idJugador) {
    this.idJugador = idJugador;
}
public String getNombre() {
    return nombre;
}
public void setNombre(String nombre) {
    this.nombre = nombre;
}
public int getProgreso() {
    return progreso;
}
public void setProgreso(int progreso) {
    this.progreso = progreso;
}
public Usuario getUsuario() {
    return usuario;
}
public void setUsuario(Usuario usuario) {
    this.usuario = usuario;
}



}
