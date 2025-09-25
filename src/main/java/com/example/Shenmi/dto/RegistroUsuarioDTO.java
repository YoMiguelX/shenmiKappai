package com.example.Shenmi.dto;

import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;

public class RegistroUsuarioDTO {

   
    @NotBlank(message = "El nombre no puede estar vacío")
    private String nombreUsuario;

    @NotBlank(message = "El apellido no puede estar vacío")
    private String apellidoUsuario;

    @NotBlank(message = "El teléfono no puede estar vacío")
    private String telUsuario;

    @NotBlank(message = "El correo no puede estar vacío")
    @Email(message = "Debe ser un correo válido")
    private String correoUsuario;

    @NotBlank(message = "La contraseña no puede estar vacía")
    private String contrasena;

    private Integer rolIdRol;

    // ✅ Getters y Setters manuales
   

    public String getNombreUsuario() { return nombreUsuario; }
    public void setNombreUsuario(String nombreUsuario) { this.nombreUsuario = nombreUsuario; }

    public String getApellidoUsuario() { return apellidoUsuario; }
    public void setApellidoUsuario(String apellidoUsuario) { this.apellidoUsuario = apellidoUsuario; }

    public String getTelUsuario() { return telUsuario; }
    public void setTelUsuario(String telUsuario) { this.telUsuario = telUsuario; }

    public String getCorreoUsuario() { return correoUsuario; }
    public void setCorreoUsuario(String correoUsuario) { this.correoUsuario = correoUsuario; }

    public String getContrasena() { return contrasena; }
    public void setContrasena(String contrasena) { this.contrasena = contrasena; }

    public Integer getRolIdRol() { return rolIdRol; }
    public void setRolIdRol(Integer rolIdRol) { this.rolIdRol = rolIdRol; }
}
