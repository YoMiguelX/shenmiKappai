package com.example.Shenmi.dao;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import com.example.Shenmi.domain.Usuario;

@Repository
public interface UsuarioDao extends JpaRepository<Usuario, Integer> {

    // Buscar por correo
    Optional<Usuario> findByCorreoUsuario(String correoUsuario);

    // Buscar por token de restablecimiento
    Optional<Usuario> findByResetToken(String resetToken);

    // Verificar login (correo + contraseña)
    Optional<Usuario> findByCorreoUsuarioAndContrasena(String correoUsuario, String contrasena);

    // 🔎 Filtrar usuarios con criterios opcionales
    @Query("SELECT u FROM Usuario u " +
           "WHERE (:rol IS NULL OR CAST(u.rolIdRol AS string) = :rol) " +
           "AND (:nombre IS NULL OR u.nombreUsuario LIKE %:nombre%) " +
           "AND (:apellido IS NULL OR u.apellidoUsuario LIKE %:apellido%) " +
           "AND (:correo IS NULL OR u.correoUsuario LIKE %:correo%) " +
           "AND (:telefono IS NULL OR u.telUsuario LIKE %:telefono%)")
    List<Usuario> filtrar(
        @Param("rol") String rol,
        @Param("nombre") String nombre,
        @Param("apellido") String apellido,
        @Param("correo") String correo,
        @Param("telefono") String telefono
    );

    // 🔴 Eliminar por ID (ya viene en JpaRepository)
    // → No es necesario definirlo, basta con usar deleteById(id).
    // Si quieres mantenerlo explícito:
    default void eliminar(Integer id) {
        deleteById(id);
    }

    // Buscar usuario por correo (versión alternativa si no quieres usar Optional)
    @Query("SELECT u FROM Usuario u WHERE u.correoUsuario = :correo")
    Usuario buscarPorCorreo(@Param("correo") String correo);

    public List<Usuario> findByRolIdRol(int i);
}
