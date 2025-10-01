package com.example.Shenmi.Service;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Optional;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;

import com.example.Shenmi.dao.JugadorDao;
import com.example.Shenmi.dao.UsuarioDao;
import com.example.Shenmi.domain.Usuario;
import com.example.Shenmi.dto.RegistroUsuarioDTO;

@Service
public class UsuarioServiceImpl implements UsuarioService {


      @Autowired
    private JugadorDao jugadorDao;
    @Autowired
    private UsuarioDao usuarioDao;

    private final BCryptPasswordEncoder passwordEncoder = new BCryptPasswordEncoder();

@Override
public Usuario registrarUsuario(RegistroUsuarioDTO dto) {
    // Verificar si ya existe un usuario con ese correo
  Usuario existente = usuarioDao.findByCorreoUsuario(dto.getCorreoUsuario())
                              .orElse(null);

    if (existente != null) {
        throw new RuntimeException("El correo ya está registrado.");
    }

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
public List<Usuario> filtrar(Integer rol, String nombre, String apellido, String correo, String telefono) {
    return usuarioDao.filtrar(rol, nombre, apellido, correo, telefono);
}

@Override
public void eliminar(Integer id) {
 usuarioDao.eliminar(id.intValue());
}

    // ===== MÉTODOS NUEVOS PARA LA PÁGINA DE ADMINISTRACIÓN =====
    
 @Override
public List<Usuario> obtenerTodosLosAdmins() {
    return usuarioDao.findByRolIdRol(1); // 1 = Admin
}

@Override
public List<Usuario> obtenerUsuarios() {
    return usuarioDao.findByRolIdRol(2); // 2 = Usuario
}
    
@Override
public List<Usuario> obtenerAdministradoresConFiltros(String nombre, String apellido, String correo, String telefono) {
    return filtrar(1, nombre, apellido, correo, telefono); // ✅ Ahora usa Integer
}

@Override
public List<Usuario> obtenerUsuariosConFiltros(String nombre, String apellido, String correo, String telefono) {
    return filtrar(2, nombre, apellido, correo, telefono); // ✅ Ahora usa Integer
}
 @Override
    public void guardar(Usuario usuario) {
        usuarioDao.save(usuario);
    }


 @Override
public Usuario guardarUsuario(Usuario usuario) {
    Usuario existente = null;

    if (usuario.getIdUsuario() != null) {
        existente = usuarioDao.findById(usuario.getIdUsuario()).orElse(null);
    }

    // Si no envió contraseña, mantener la existente
    if (usuario.getContrasena() == null || usuario.getContrasena().isEmpty()) {
        if (existente != null) {
            usuario.setContrasena(existente.getContrasena());
        }
    } else {
        // Si envió contraseña nueva, encriptar
        usuario.setContrasena(passwordEncoder.encode(usuario.getContrasena()));
    }

    // Fecha creación
    if (usuario.getFechaCreacion() == null && existente != null) {
        usuario.setFechaCreacion(existente.getFechaCreacion());
    } else if (usuario.getFechaCreacion() == null) {
        usuario.setFechaCreacion(LocalDateTime.now());
    }

    // Estado
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
 
  @Override
    public Usuario validarLogin(String correo, String contrasena) {
        Optional<Usuario> opt = usuarioDao.findByCorreoUsuario(correo);

        if (opt.isPresent()) {
            Usuario usuario = opt.get();
            // Comparar contraseña encriptada con la ingresada
            if (passwordEncoder.matches(contrasena, usuario.getContrasena())) {
                return usuario;
            }
        }
        return null;
    }

    @Override
    public void save(Usuario usuarioActual) {
        throw new UnsupportedOperationException("Not supported yet.");
    }
 
}
