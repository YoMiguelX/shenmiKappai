package com.example.Shenmi.Controladores;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

import com.example.Shenmi.Service.UsuarioService;
import com.example.Shenmi.domain.Usuario;

import jakarta.servlet.http.HttpServletResponse;
import jakarta.servlet.http.HttpSession;

@Controller
public class PerfilController {

 @Autowired
    private UsuarioService usuarioService;

    @GetMapping("/perfil")
    public String mostrarPerfil(HttpSession session, Model model , HttpServletResponse response) {

        response.setHeader("Cache-Control", "no-cache, no-store, must-revalidate"); 
    response.setHeader("Pragma", "no-cache"); 
    response.setDateHeader("Expires", 0);
        // recuperar el ID del usuario desde la sesión
        Integer usuarioId = (Integer) session.getAttribute("usuarioId");

        if (usuarioId == null) {
            return "redirect:/login"; // si no está logueado, redirigir
        }

        // buscar el usuario real en la BD
        Usuario usuario = usuarioService.buscarPorId(usuarioId);
        if (usuario == null) {
            return "redirect:/login"; // seguridad extra
        }

        model.addAttribute("usuario", usuario);
        return "perfil"; // busca perfil.html
    }



}
