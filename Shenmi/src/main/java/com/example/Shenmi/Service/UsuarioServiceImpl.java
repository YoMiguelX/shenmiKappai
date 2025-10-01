package com.example.Shenmi.Service;

import java.time.LocalDateTime;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;

import com.example.Shenmi.dao.UsuarioDao;
import com.example.Shenmi.domain.Usuario;
import com.example.Shenmi.dto.RegistroUsuarioDTO;

@Service
public class UsuarioServiceImpl implements UsuarioService {

    @Autowired
    private UsuarioDao usuarioDao;

    private final BCryptPasswordEncoder passwordEncoder = new BCryptPasswordEncoder();

    @Override
    public Usuario registrarUsuario(RegistroUsuarioDTO dto) {
        Usuario usuario = new Usuario();
     
        usuario.setNombreUsuario(dto.getNombreUsuario());
        usuario.setApellidoUsuario(dto.getApellidoUsuario());
        usuario.setTelUsuario(dto.getTelUsuario());
        usuario.setCorreoUsuario(dto.getCorreoUsuario());
        usuario.setContrasena(passwordEncoder.encode(dto.getContrasena()));
        usuario.setEstadoUsuario("Activo");
        usuario.setFechaCreacion(LocalDateTime.now());
        usuario.setRolIdRol(2);
        return usuarioDao.save(usuario);
    }

    @Override
    public Usuario verificarUsuario(String correo, String contrasena) {
        return usuarioDao.findByCorreoUsuario(correo)
                .filter(u -> passwordEncoder.matches(contrasena, u.getContrasena()))
                .orElse(null);
    }

    @Override
    public Usuario buscarPorToken(String token) {
        return usuarioDao.findByResetToken(token)
                .filter(u -> u.getResetTokenExpiration().isAfter(LocalDateTime.now()))
                .orElse(null);
    }
    @Override
public Usuario buscarPorCorreo(String correo) {
    return usuarioDao.buscarPorCorreo(correo);
}


   @Override
    public Usuario buscarPorId(Integer id) {
        return usuarioDao.findById(id).orElse(null);
    }
  @Override
public List<Usuario> filtrar(String rol, String nombre, String apellido, String correo, String telefono) {
    return usuarioDao.filtrar(rol, nombre, apellido, correo, telefono); // debe devolver List<Usuario>
}

@Override
public void eliminar(Integer id) {
 usuarioDao.eliminar(id.intValue());
}

    // ===== MÉTODOS NUEVOS PARA LA PÁGINA DE ADMINISTRACIÓN =====
    
    @Override
    public List<Usuario> obtenerAdministradores() {
        // Asumiendo que los administradores tienen rolIdRol = 1
        return usuarioDao.findByRolIdRol(1);
    }
    
    @Override
    public List<Usuario> obtenerUsuarios() {
        // Usuarios regulares tienen rolIdRol = 2
        return usuarioDao.findByRolIdRol(2);
    }
    
    @Override
    public List<Usuario> obtenerAdministradoresConFiltros(String nombre, String apellido, String correo, String telefono) {
        return filtrar("1", nombre, apellido, correo, telefono); // 1 = ADMIN
    }
    
    @Override
    public List<Usuario> obtenerUsuariosConFiltros(String nombre, String apellido, String correo, String telefono) {
        return filtrar("2", nombre, apellido, correo, telefono); // 2 = USER
    }
    
    @Override
    public Usuario guardarUsuario(Usuario usuario) {
        // Si no tiene fecha de creación, asignar la actual
        if (usuario.getFechaCreacion() == null) {
            usuario.setFechaCreacion(LocalDateTime.now());
        }
        // Si no tiene estado, asignar "Activo"
        if (usuario.getEstadoUsuario() == null) {
            usuario.setEstadoUsuario("Activo");
        }
        return usuarioDao.save(usuario);
    }
    
    @Override
    public List<Usuario> obtenerTodosLosUsuarios() {
        return usuarioDao.findAll();
    }
    
    @Override
    public boolean existeUsuario(Integer id) {
        return usuarioDao.existsById(id);
    }
    
    @Override
    public Usuario crearAdministrador(Usuario usuario) {
        // Encriptar contraseña si está presente
        if (usuario.getContrasena() != null && !usuario.getContrasena().isEmpty()) {
            usuario.setContrasena(passwordEncoder.encode(usuario.getContrasena()));
        }
        
        // Establecer como administrador
        usuario.setRolIdRol(1); // 1 = ADMIN
        usuario.setEstadoUsuario("Activo");
        usuario.setFechaCreacion(LocalDateTime.now());
        
        return usuarioDao.save(usuario);
    }


}
