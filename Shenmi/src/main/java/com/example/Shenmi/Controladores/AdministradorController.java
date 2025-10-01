package com.example.Shenmi.Controladores;

import java.io.IOException;
import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
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

import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;


@Controller
@RequestMapping("/admin")  // <- coincide con redirect:/admin/lista
public class AdministradorController {

    @Autowired
    private UsuarioService usuarioService;

   @GetMapping("/lista")
    public String listarUsuarios(FiltroDTO filtros, Model model) {
        List<Usuario> administradores = usuarioService.filtrar("1",
                filtros.getNombre(), filtros.getApellido(), filtros.getCorreo(), filtros.getTelefono());

        List<Usuario> usuarios = usuarioService.filtrar("2",
                filtros.getNombre(), filtros.getApellido(), filtros.getCorreo(), filtros.getTelefono());

        model.addAttribute("administradores", administradores);
        model.addAttribute("usuarios", usuarios);
        model.addAttribute("filtros", filtros);

        return "admin/lista";
    }

    @GetMapping("/eliminar/{id}")
    public String eliminarUsuario(@PathVariable("id") Integer id) {
        usuarioService.eliminar(id);
        return "redirect:/admin/lista";
    }

    
    // ===== NUEVOS MÉTODOS PARA ADMINISTRACIÓN =====

    // Mostrar lista de usuarios y administradores
    @GetMapping("/admin/lista-usuarios")
    public String listarUsuarios(
            @RequestParam(required = false) String nombre,
            @RequestParam(required = false) String apellido,
            @RequestParam(required = false) String correo,
            @RequestParam(required = false) String telefono,
            HttpSession session,
            Model model) {
        
        // Verificar que el usuario esté autenticado y sea admin
        if (session.getAttribute("usuarioId") == null) {
            return "redirect:/login";
        }
        
        Integer usuarioId = (Integer) session.getAttribute("usuarioId");
        Usuario usuarioActual = usuarioService.buscarPorId(usuarioId);
        
        if (usuarioActual == null || usuarioActual.getRolIdRol() != 1) {
            return "redirect:/login";
        }
        
        List<Usuario> administradores;
        List<Usuario> usuarios;
        
        // Aplicar filtros si existen
        if (nombre != null || apellido != null || correo != null || telefono != null) {
            administradores = usuarioService.obtenerAdministradoresConFiltros(nombre, apellido, correo, telefono);
            usuarios = usuarioService.obtenerUsuariosConFiltros(nombre, apellido, correo, telefono);
        } else {
            administradores = usuarioService.obtenerAdministradores();
            usuarios = usuarioService.obtenerUsuarios();
        }
        
        model.addAttribute("administradores", administradores);
        model.addAttribute("usuarios", usuarios);
        model.addAttribute("filtros", new FiltroUsuario(nombre, apellido, correo, telefono));
        
        return "usuarios/lista";
    }
    
    // Mostrar formulario para crear administrador
    @GetMapping("/admin/crear")
    public String mostrarFormularioCrear(HttpSession session, Model model) {
        // Verificar autenticación
        if (session.getAttribute("usuarioId") == null) {
            return "redirect:/login";
        }
        
        model.addAttribute("usuario", new Usuario());
        return "usuarios/crear_admin";
    }
    
    // Crear nuevo administrador
    @PostMapping("/admin/crear")
    public String crearAdministrador(@ModelAttribute Usuario usuario, 
                                   HttpSession session,
                                   RedirectAttributes redirectAttributes) {
        // Verificar autenticación
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
    
    // Mostrar formulario para editar usuario
    @GetMapping("/admin/editar/{id}")
    public String mostrarFormularioEditar(@PathVariable Integer id, 
                                        HttpSession session,
                                        Model model, 
                                        RedirectAttributes redirectAttributes) {
        // Verificar autenticación
        if (session.getAttribute("usuarioId") == null) {
            return "redirect:/login";
        }
        
        Usuario usuario = usuarioService.buscarPorId(id);
        if (usuario != null) {
            model.addAttribute("usuario", usuario);
            return "usuarios/editar";
        } else {
            redirectAttributes.addFlashAttribute("mensaje", "Usuario no encontrado");
            redirectAttributes.addFlashAttribute("tipoMensaje", "danger");
            return "redirect:/admin/lista";
        }
    }
    
    // Actualizar usuario
    @PostMapping("/admin/editar/{id}")
    public String actualizarUsuario(@PathVariable Integer id, 
                                  @ModelAttribute Usuario usuario,
                                  HttpSession session,
                                  RedirectAttributes redirectAttributes) {
        // Verificar autenticación
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
    
    
    @Autowired
private ExcelExportService excelExportService;
@GetMapping("/admin/exportarExcel")
public void exportarExcel(HttpServletResponse response,
                        @RequestParam(required = false) String nombre,
                        @RequestParam(required = false) String apellido,
                        @RequestParam(required = false) String correo,
                        @RequestParam(required = false) String telefono,
                        HttpSession session) throws IOException {
    
    // Verificar autenticación
    if (session.getAttribute("usuarioId") == null) {
        response.sendRedirect("/login");
        return;
    }
        
       // Configurar headers de respuesta
    response.setContentType("application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    response.setHeader("Content-Disposition", "attachment; filename=usuarios_" + 
                      java.time.LocalDateTime.now().format(java.time.format.DateTimeFormatter.ofPattern("yyyyMMdd_HHmmss")) + 
                      ".xlsx");
    
    List<Usuario> todosLosUsuarios;
    
    // Aplicar filtros si existen
    if (nombre != null || apellido != null || correo != null || telefono != null) {
        todosLosUsuarios = usuarioService.filtrar(null, nombre, apellido, correo, telefono);
    } else {
        todosLosUsuarios = usuarioService.obtenerTodosLosUsuarios();
    }
    
    // Usar el servicio de Excel para generar el archivo
    excelExportService.exportarUsuariosAExcel(todosLosUsuarios, response);
    response.getOutputStream().flush();
    }
    
    // Ruta para ver el perfil del jugador (manteniendo compatibilidad)
    @GetMapping("/jugador")
    public String verPerfilJugador(HttpSession session, Model model) {
        if (session.getAttribute("usuarioId") == null) {
            return "redirect:/login";
        }
        
        Integer usuarioId = (Integer) session.getAttribute("usuarioId");
        Usuario usuario = usuarioService.buscarPorId(usuarioId);
        
        model.addAttribute("usuario", usuario);
        return "perfil_jugador"; // Asegúrate de tener esta vista
    }
    
    // Cerrar sesión (ruta alternativa para mantener compatibilidad con las vistas)
    @GetMapping("/perfil/salir")
    public String cerrarSesion(HttpSession session) {
        if (session != null) {
            session.invalidate();
        }
        return "redirect:/login?logout=true";
    }
    
    // Clase interna para manejar filtros
    public static class FiltroUsuario {
        private String nombre;
        private String apellido;
        private String correo;
        private String telefono;
        
        public FiltroUsuario() {}
        
        public FiltroUsuario(String nombre, String apellido, String correo, String telefono) {
            this.nombre = nombre;
            this.apellido = apellido;
            this.correo = correo;
            this.telefono = telefono;
        }
        
        // Getters y setters
        public String getNombre() { return nombre; }
        public void setNombre(String nombre) { this.nombre = nombre; }
        public String getApellido() { return apellido; }
        public void setApellido(String apellido) { this.apellido = apellido; }
        public String getCorreo() { return correo; }
        public void setCorreo(String correo) { this.correo = correo; }
        public String getTelefono() { return telefono; }
        public void setTelefono(String telefono) { this.telefono = telefono; }
    }
}
