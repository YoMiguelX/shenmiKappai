package com.example.Shenmi.Controladores;



import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;

import com.example.Shenmi.dao.UsuarioDao;
import com.example.Shenmi.domain.Usuario;
@Controller
public class Controlador {
    @Autowired
    private UsuarioDao individuoDao;

    // Página principal con listado
  

    // Formulario para registrar nuevo individuo
    @GetMapping("/formulario")
    public String mostrarFormulario(Model model) {
        model.addAttribute("individuo", new Usuario());
        return "formulario"; // sin .html
    }   
@GetMapping("/")
    public String home() {
        return "home"; // busca templates/home.html
    }

    @GetMapping("/soporte")
    public String soporte() {
        return "soporte"; // busca templates/soporte.html
    }

}