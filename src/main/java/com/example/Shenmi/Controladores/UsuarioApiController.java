package com.example.Shenmi.Controladores;

import java.util.HashMap;
import java.util.Map;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import com.example.Shenmi.dto.LoginRequest;

@RestController
@RequestMapping("/api/usuarios")
public class UsuarioApiController {

    @PostMapping("/login")
    public ResponseEntity<Map<String, Object>> login(@RequestBody LoginRequest request) {
        Map<String, Object> response = new HashMap<>();

        if ("test@test.com".equals(request.getCorreo()) && "123".equals(request.getContrasena())) {
            response.put("success", true);
            response.put("nombre", "Test");
            response.put("id", 1);
            response.put("rol", "Jugador");
            return ResponseEntity.ok(response);
        } else {
            response.put("success", false);
            response.put("mensaje", "Credenciales incorrectas");
            return ResponseEntity.status(401).body(response);
        }
    }
}

