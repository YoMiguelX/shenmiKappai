<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Paginas::index');

$routes->post('/Registro', 'Home::registro');
$routes->get('/login', 'Login::index');
$routes->post('/login/acceder', 'Login::acceder');
$routes->get('/salir', 'Login::salir');
$routes->get('/registro', 'Registro::index');         // Muestra el formulario de registro
$routes->post('/registro/guardar', 'Registro::guardar'); // Procesa el registro


$routes->get('/perfil', 'Perfil::perfil');
$routes->get('perfil/salir', 'Perfil::salir');


$routes->get('/index', 'Administrador::index');
$routes->get('/administrador', 'Administrador::index');
$routes->get('/administrador/crear', 'Administrador::crear');
$routes->post('/administrador/guardar', 'Administrador::guardar');
$routes->get('/administrador/editar/(:num)', 'Administrador::editar/$1');
$routes->post('/administrador/actualizar/(:num)', 'Administrador::actualizar/$1');
$routes->get('/administrador/eliminar/(:num)', 'Administrador::eliminar/$1');
$routes->get('/administrador/lista', 'Administrador::lista');
$routes->get('/cerrarSesion', 'Administrador::cerrarSesion');
$routes->get('administrador/eliminarUsuario/(:num)', 'Administrador::eliminarUsuario/$1');


// Restablecer contraseña
$routes->get('/restablecer', 'Login::restablecer');
$routes->post('/restablecer/enviar', 'Login::enviarRestablecimiento');
$routes->post('/restablecer/enviar', 'Login::enviarRecuperacion');
$routes->post('/restablecer/actualizar', 'Login::actualizarContrasena');
$routes->get('restablecer/(:segment)', 'Login::mostrarFormularioRestablecer/$1');
$routes->post('guardar-clave', 'Login::guardarNuevaClave'); // Guardar nueva contraseña

//  Perfil
$routes->get('/perfil/seguridad', 'Perfil::seguridad');
$routes->get('/perfil/perfil', 'Perfil::datosPerfil');
$routes->get('/perfil/salir', 'Perfil::salir');
$routes->get('/perfil', 'Perfil::index');



// Seguridad
$routes->get('/seguridad', 'Seguridad::index');
$routes->post('/seguridad/cambiar', 'Seguridad::cambiar');



// PERFIL DE USUARIO
$routes->get('/perfil/datos', 'Datos_perfil::index'); 
$routes->post('/perfil/actualizar', 'Datos_perfil::actualizar');
$routes->get('/perfil/salir', 'Perfil::salir'); 


$routes->get('/jugador', 'Jugador::index');






