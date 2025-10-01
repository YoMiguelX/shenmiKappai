package com.example.Shenmi.Controladores;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

import com.example.Shenmi.Service.JugadorService;
import com.example.Shenmi.Service.MundoService;
import com.example.Shenmi.Service.UsuarioService;
import com.example.Shenmi.domain.Jugador;
import com.example.Shenmi.domain.Mundo;
import com.example.Shenmi.domain.Usuario;
import com.example.Shenmi.dto.RegistroUsuarioDTO;

import jakarta.servlet.http.HttpSession;

@Controller
public class UsuarioController {
@Autowired
private JugadorService jugadorService;

@Autowired
private MundoService mundoService;

    @Autowired
    private UsuarioService usuarioService;

    // ===== REGISTRO =====
    @GetMapping("/registro")
    public String mostrarRegistro(Model model) {
        model.addAttribute("usuario", new RegistroUsuarioDTO());
        return "registro"; // busca templates/registro.html
    }

 @PostMapping("/registro")
public String registrarUsuario(@ModelAttribute("usuario") RegistroUsuarioDTO dto, Model model) {
    try {
        usuarioService.registrarUsuario(dto);
        return "redirect:/login?registro=exitoso";
    } catch (RuntimeException e) {
        if (e.getMessage().contains("correo")) {
            // Si ya existe el correo, redirigimos al login con mensaje
            return "redirect:/login?error=correoExistente";
        }
        model.addAttribute("error", "Error al registrar usuario: " + e.getMessage());
        return "registro";
    }
}

    // ===== LOGIN =====
    @GetMapping("/login")
    public String mostrarLogin() {
        return "login"; // busca templates/login.html
    }

   @PostMapping("/login")
public String procesarLogin(
        @RequestParam String correo,
        @RequestParam String contrasena,
        HttpSession session,
        Model model) {

    Usuario usuario = usuarioService.verificarUsuario(correo, contrasena);

    if (usuario != null) {
        session.setAttribute("usuarioId", usuario.getIdUsuario());

        // 🔹 Redirigir según el rol
        if (usuario.getRolIdRol() != null && usuario.getRolIdRol() == 1) { // Admin
            return "redirect:/admin/lista"; // ✅ ahora va a admin/lista
        } else {
            return "redirect:/perfil";
        }
    } else {
        model.addAttribute("error", "Correo o contraseña incorrectos");
        return "login"; // vuelve al login si falla
    }
}


    // ===== LOGOUT =====
    @GetMapping("/logout")
    public String logout(HttpSession session) {
        if (session != null) {
            session.invalidate();
        }
        return "redirect:/login?logout=true";
    }

    // ===== PERFIL DE USUARIO =====


    // Ruta alternativa para perfil de jugador
    @GetMapping("/jugador")
    public String verPerfilJugador(HttpSession session, Model model) {
        if (session.getAttribute("usuarioId") == null) {
            return "redirect:/login";
        }

        Integer usuarioId = (Integer) session.getAttribute("usuarioId");
        Usuario usuario = usuarioService.buscarPorId(usuarioId);

        model.addAttribute("usuario", usuario);
        return "perfil_jugador"; // asegúrate de tener perfil_jugador.html
    }

    // Cerrar sesión desde perfil
    @GetMapping("/perfil/salir")
    public String cerrarSesion(HttpSession session) {
        if (session != null) {
            session.invalidate();
        }
        return "redirect:/login?logout=true";
    }
  @GetMapping("/jugador/estado")
public String estadoJugadores(
        @RequestParam(required = false) String nombreJugador,
        @RequestParam(required = false) String nombreUsuario,
        @RequestParam(required = false) String mundo,
        @RequestParam(required = false) String estado,
        @RequestParam(defaultValue = "0") int page,
        @RequestParam(defaultValue = "12") int size,
        Model model) {

    Pageable pageable = PageRequest.of(page, size);

    Page<Jugador> jugadores = jugadorService.buscarConFiltros(
            nombreJugador,
            nombreUsuario,
            mundo,
            estado,
            pageable
    );

    List<Mundo> mundos = mundoService.findAll();

    model.addAttribute("jugadores", jugadores);
    model.addAttribute("mundos", mundos);
    model.addAttribute("page", jugadores);
    model.addAttribute("totalJugadores", jugadorService.contarTotal());
    model.addAttribute("jugadoresActivos", jugadorService.contarActivos());

    return "jugador/estado";
}

}
