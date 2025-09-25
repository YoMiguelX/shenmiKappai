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
            usuarioService.guardarUsuario(usuario);
            redirectAttrs.addFlashAttribute("success", "Administrador registrado correctamente");
        } catch (Exception e) {
            redirectAttrs.addFlashAttribute("error", "Error al registrar administrador");
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

    
}
