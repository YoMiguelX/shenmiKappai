package com.example.Shenmi.Controladores;

import java.io.IOException;
import java.security.Principal;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import com.example.Shenmi.Service.ExcelExportService;
import com.example.Shenmi.Service.UsuarioService;
import com.example.Shenmi.domain.Usuario;
import com.example.Shenmi.dto.FiltroDTO;

import jakarta.servlet.http.Cookie;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;

@Controller
@RequestMapping("/admin")
public class AdministradorController {

    @Autowired
    private UsuarioService usuarioService;

    @Autowired
    private ExcelExportService excelExportService;

    
@Autowired
private PasswordEncoder passwordEncoder; // Si no lo tienes ya


    // ===== LISTAR =====
    @GetMapping("/lista")
    public String listarUsuarios(FiltroDTO filtros, Model model) {
    List<Usuario> administradores = usuarioService.filtrar(1,
        filtros.getNombre(), filtros.getApellido(), filtros.getCorreo(), filtros.getTelefono());

List<Usuario> usuarios = usuarioService.filtrar(2,
        filtros.getNombre(), filtros.getApellido(), filtros.getCorreo(), filtros.getTelefono());

        model.addAttribute("administradores", administradores);
        model.addAttribute("usuarios", usuarios);
        model.addAttribute("filtros", filtros);

        return "admin/lista";
    }

    // ===== ELIMINAR =====
    @GetMapping("/eliminar/{id}")
    public String eliminarUsuario(@PathVariable("id") Integer id) {
        usuarioService.eliminar(id);
        return "redirect:/admin/lista";
    }

       @GetMapping("/crear")
    public String mostrarFormularioCrear(Model model) {
        model.addAttribute("usuario", new Usuario());
        return "admin/crear_admin"; // el HTML en templates/admin/crear_admin.html
    }
@PostMapping("/guardar")
public String guardarAdmin(@ModelAttribute("usuario") Usuario usuario, RedirectAttributes redirectAttrs) {
    try {
        usuario.setRolIdRol(1); // ADMIN

        // Encriptar contraseña
        usuario.setContrasena(passwordEncoder.encode(usuario.getContrasena()));

        usuarioService.guardarUsuario(usuario);
        redirectAttrs.addFlashAttribute("success", "Administrador registrado correctamente");
    } catch (Exception e) {
        redirectAttrs.addFlashAttribute("error", "Error al registrar administrador: " + e.getMessage());
    }
    return "redirect:/admin/crear";
}


    @PostMapping("/crear")
    public String crearAdministrador(@ModelAttribute Usuario usuario,
                                     HttpSession session,
                                     RedirectAttributes redirectAttributes) {
        if (session.getAttribute("usuarioId") == null) {
            return "redirect:/login";
        }

        try {
            usuarioService.crearAdministrador(usuario);
            redirectAttributes.addFlashAttribute("mensaje", "Administrador creado exitosamente");
            redirectAttributes.addFlashAttribute("tipoMensaje", "success");
        } catch (Exception e) {
            redirectAttributes.addFlashAttribute("mensaje", "Error al crear administrador: " + e.getMessage());
            redirectAttributes.addFlashAttribute("tipoMensaje", "danger");
        }
        return "redirect:/admin/lista";
    }

    // ===== EDITAR =====
    @GetMapping("/editar/{id}")
    public String mostrarFormularioEditar(@PathVariable Integer id,
                                          HttpSession session,
                                          Model model,
                                          RedirectAttributes redirectAttributes) {
        if (session.getAttribute("usuarioId") == null) {
            return "redirect:/login";
        }

        Usuario usuario = usuarioService.buscarPorId(id);
        if (usuario != null) {
            model.addAttribute("usuario", usuario);
            return "admin/editar"; // mejor moverlo a templates/admin/
        } else {
            redirectAttributes.addFlashAttribute("mensaje", "Usuario no encontrado");
            redirectAttributes.addFlashAttribute("tipoMensaje", "danger");
            return "redirect:/admin/lista";
        }
    }

    @PostMapping("/editar/{id}")
    public String actualizarUsuario(@PathVariable Integer id,
                                    @ModelAttribute Usuario usuario,
                                    HttpSession session,
                                    RedirectAttributes redirectAttributes) {
        if (session.getAttribute("usuarioId") == null) {
            return "redirect:/login";
        }

        try {
            usuario.setIdUsuario(id);
            usuarioService.guardarUsuario(usuario);
            redirectAttributes.addFlashAttribute("mensaje", "Usuario actualizado exitosamente");
            redirectAttributes.addFlashAttribute("tipoMensaje", "success");
        } catch (Exception e) {
            redirectAttributes.addFlashAttribute("mensaje", "Error al actualizar usuario: " + e.getMessage());
            redirectAttributes.addFlashAttribute("tipoMensaje", "danger");
        }
        return "redirect:/admin/lista";
    }

    // ===== EXPORTAR =====
    @GetMapping("/exportarExcel")
    public void exportarExcel(HttpServletResponse response,
                              @RequestParam(required = false) String nombre,
                              @RequestParam(required = false) String apellido,
                              @RequestParam(required = false) String correo,
                              @RequestParam(required = false) String telefono,
                              HttpSession session) throws IOException {
        if (session.getAttribute("usuarioId") == null) {
            response.sendRedirect("/login");
            return;
        }

        response.setContentType("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        response.setHeader("Content-Disposition", "attachment; filename=usuarios_" +
                java.time.LocalDateTime.now().format(java.time.format.DateTimeFormatter.ofPattern("yyyyMMdd_HHmmss")) +
                ".xlsx");

        List<Usuario> todosLosUsuarios;
        if (nombre != null || apellido != null || correo != null || telefono != null) {
            todosLosUsuarios = usuarioService.filtrar(null, nombre, apellido, correo, telefono);
        } else {
            todosLosUsuarios = usuarioService.obtenerTodosLosUsuarios();
        }

        excelExportService.exportarUsuariosAExcel(todosLosUsuarios, response);
        response.getOutputStream().flush();
    }
@GetMapping("/admin/lista")
public String mostrarListaUsuarios(HttpServletResponse response, HttpSession session, Model model) {
    if (session.getAttribute("usuarioId") == null) {
        return "redirect:/login";
    }

    // Evitar caché en el navegador
    response.setHeader("Cache-Control", "no-cache, no-store, must-revalidate"); // HTTP 1.1
    response.setHeader("Pragma", "no-cache"); // HTTP 1.0
    response.setHeader("Expires", "0"); // Proxies
model.addAttribute("administradores", usuarioService.obtenerTodosLosAdmins());
model.addAttribute("usuarios", usuarioService.obtenerUsuarios());

    return "lista"; // tu plantilla
}

@GetMapping("/logout")
public String logout(HttpServletRequest request, HttpServletResponse response) {
    HttpSession session = request.getSession(false);
    if (session != null) {
        session.invalidate();
    }

    // eliminar cookie JSESSIONID del navegador
    Cookie cookie = new Cookie("JSESSIONID", "");
    cookie.setPath(request.getContextPath() == null ? "/" : request.getContextPath());
    cookie.setMaxAge(0);
    response.addCookie(cookie);

    // cabeceras extra de seguridad (por si)
    response.setHeader("Cache-Control", "no-cache, no-store, must-revalidate");
    response.setHeader("Pragma", "no-cache");
    response.setDateHeader("Expires", 0);

    return "redirect:/login";
}
@GetMapping("/cambiar-password")
public String mostrarCambiarPassword() {
    return "admin/cambiar-password"; // Nombre de tu template HTML
}

/**
 * Procesar cambio de contraseña
 */
@PostMapping("/cambiar-password")
public String cambiarPassword(
        @RequestParam("passwordActual") String passwordActual,
        @RequestParam("passwordNueva") String passwordNueva,
        @RequestParam("passwordConfirmar") String passwordConfirmar,
        RedirectAttributes redirectAttributes,
        Principal principal) {
    
    try {
        // Obtener el usuario autenticado actual usando Principal
        String correoUsuario = principal.getName();
        
        // Buscar usuario - ajusta el nombre del método según tu servicio
        Usuario usuarioActual = null;
        
        // Prueba estos métodos según lo que tengas en tu UsuarioService:
        try {
            usuarioActual = usuarioService.buscarPorCorreo(correoUsuario);
        } catch (Exception e) {
            // Si no tienes buscarPorCorreo, prueba con otros nombres comunes:
            // usuarioActual = usuarioService.findByEmail(correoUsuario);
            // usuarioActual = usuarioService.obtenerPorCorreo(correoUsuario);
            // usuarioActual = usuarioService.buscarUsuarioPorCorreo(correoUsuario);
        }
        
        if (usuarioActual == null) {
            redirectAttributes.addFlashAttribute("error", "Usuario no encontrado");
            return "redirect:/admin/cambiar-password";
        }
        
        // Verificar que la contraseña actual sea correcta
        // Ajusta el nombre del getter según tu entidad Usuario:
        String contrasenaActualBD = usuarioActual.getContrasena(); 
        // O prueba: getPassword(), getContrasenaUsuario(), etc.
        
        if (!passwordEncoder.matches(passwordActual, contrasenaActualBD)) {
            redirectAttributes.addFlashAttribute("error", "La contraseña actual es incorrecta");
            return "redirect:/admin/cambiar-password";
        }
        
        // Verificar que las nuevas contraseñas coincidan
        if (!passwordNueva.equals(passwordConfirmar)) {
            redirectAttributes.addFlashAttribute("error", "Las nuevas contraseñas no coinciden");
            return "redirect:/admin/cambiar-password";
        }
        
        // Verificar que la nueva contraseña sea diferente a la actual
        if (passwordEncoder.matches(passwordNueva, contrasenaActualBD)) {
            redirectAttributes.addFlashAttribute("error", "La nueva contraseña debe ser diferente a la actual");
            return "redirect:/admin/cambiar-password";
        }
        
        // Validar fortaleza de la nueva contraseña
        if (!esPasswordSegura(passwordNueva)) {
            redirectAttributes.addFlashAttribute("error", 
                "La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y caracteres especiales");
            return "redirect:/admin/cambiar-password";
        }
        
        // Encriptar y guardar la nueva contraseña
        // Ajusta el nombre del setter según tu entidad Usuario:
        usuarioActual.setContrasena(passwordEncoder.encode(passwordNueva));
        // O prueba: setPassword(), setContrasenaUsuario(), etc.
        
        // Guardar - ajusta el nombre del método según tu servicio:
        usuarioService.save(usuarioActual);
        // O prueba: guardar(), actualizar(), update(), etc.
        
        redirectAttributes.addFlashAttribute("mensaje", "Contraseña cambiada exitosamente");
        return "redirect:/admin/lista";
        
    } catch (Exception e) {
        redirectAttributes.addFlashAttribute("error", "Error al cambiar la contraseña: " + e.getMessage());
        return "redirect:/admin/cambiar-password";
    }
}
/**
     * Validar si una contraseña es segura
     */

/**
 * Validar si una contraseña es segura
 */
private boolean esPasswordSegura(String password) {
    if (password == null || password.length() < 8) {
        return false;
    }
    
    boolean tieneMayuscula = password.matches(".*[A-Z].*");
    boolean tieneMinuscula = password.matches(".*[a-z].*");
    boolean tieneNumero = password.matches(".*[0-9].*");
    boolean tieneEspecial = password.matches(".*[^a-zA-Z0-9].*");
    
    return tieneMayuscula && tieneMinuscula && tieneNumero && tieneEspecial;
}
}
