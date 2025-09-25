package com.example.Shenmi.Controladores;

import java.time.LocalDateTime;
import java.util.UUID;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;

import com.example.Shenmi.Service.EmailService;
import com.example.Shenmi.Service.UsuarioService;
import com.example.Shenmi.domain.Usuario;

import jakarta.servlet.http.HttpServletRequest;

@Controller
@RequestMapping("/restablecer")
public class RestablecerController {

    @Autowired
    private UsuarioService usuarioService;
    @Autowired
private EmailService emailService;


    @GetMapping
    public String mostrarFormulario() {
        return "restablecer";
    }

    @PostMapping("/enviar")
    public String enviarEnlace(@RequestParam("email") String email, Model model, HttpServletRequest request) {
        Usuario usuario = usuarioService.buscarPorCorreo(email);
        if (usuario == null) {
            model.addAttribute("msg", "No existe una cuenta con ese correo.");
            return "restablecer";
        }

        // Generar token y guardarlo
        String token = UUID.randomUUID().toString();
        usuario.setResetToken(token);
        usuario.setResetTokenExpiration(LocalDateTime.now().plusHours(1));
        usuarioService.guardar(usuario);

        
// Crear enlace
String enlace = request.getScheme() + "://" + request.getServerName() + ":" +
        request.getServerPort() + "/restablecer/nueva?token=" + token;

// Enviar correo real
String asunto = "Restablecer contraseña - Shenmi";
String contenido = "Hola " + usuario.getNombreUsuario() + ",\n\n" +
        "Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace:\n" +
        enlace + "\n\n" +
        "Este enlace expirará en 1 hora.\n\n" +
        "Si no solicitaste este cambio, ignora este mensaje.";

emailService.enviarCorreo(usuario.getCorreoUsuario(), asunto, contenido);

        model.addAttribute("msg", "Hemos enviado un enlace a tu correo.");
        return "restablecer";
    }

    @GetMapping("/nueva")
    public String mostrarNueva(@RequestParam("token") String token, Model model) {
        Usuario usuario = usuarioService.buscarPorToken(token);
        if (usuario == null) {
            model.addAttribute("msg", "El enlace no es válido o expiró.");
            return "restablecer";
        }

        model.addAttribute("token", token);
        return "nueva_contrasena";
    }

    @PostMapping("/nueva")
    public String guardarNueva(@RequestParam("token") String token,
                               @RequestParam("password") String password,
                               @RequestParam("password2") String password2,
                               Model model) {
        Usuario usuario = usuarioService.buscarPorToken(token);
        if (usuario == null) {
            model.addAttribute("msg", "El enlace no es válido o expiró.");
            return "restablecer";
        }

        if (!password.equals(password2)) {
            model.addAttribute("msg", "Las contraseñas no coinciden.");
            model.addAttribute("token", token);
            return "nueva_contrasena";
        }

        // ✅ Encriptar antes de guardar
        BCryptPasswordEncoder encoder = new BCryptPasswordEncoder();
      usuario.setContrasena(password); // en texto plano
usuario.setResetToken(null);
usuario.setResetTokenExpiration(null);
usuarioService.guardarUsuario(usuario);


        model.addAttribute("msg", "Tu contraseña fue restablecida. Ahora puedes iniciar sesión.");
        return "login";
    }
}
