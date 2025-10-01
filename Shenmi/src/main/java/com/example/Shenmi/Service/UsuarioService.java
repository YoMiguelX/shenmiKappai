package com.example.Shenmi.Service;

import java.util.List;

import com.example.Shenmi.domain.Usuario;
import com.example.Shenmi.dto.RegistroUsuarioDTO;

public interface UsuarioService {
    Usuario registrarUsuario(RegistroUsuarioDTO dto);
    Usuario verificarUsuario(String correo, String contrasena);
    Usuario buscarPorToken(String token);

    


    Usuario buscarPorId(Integer id);
    Usuario buscarPorCorreo(String correo);

   List<Usuario> filtrar(String rol, String nombre, String apellido, String correo, String telefono);
    void eliminar(Integer id);

    
   
    
    // Métodos adicionales que necesitarás para la página de administración
    List<Usuario> obtenerAdministradores();
    List<Usuario> obtenerUsuarios();
    List<Usuario> obtenerAdministradoresConFiltros(String nombre, String apellido, String correo, String telefono);
    List<Usuario> obtenerUsuariosConFiltros(String nombre, String apellido, String correo, String telefono);
    Usuario guardarUsuario(Usuario usuario);
    List<Usuario> obtenerTodosLosUsuarios();
    boolean existeUsuario(Integer id);
    Usuario crearAdministrador(Usuario usuario);

}
