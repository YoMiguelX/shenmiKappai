<?= view('plantilla/navbar'); ?>

<?php
$usuario = session('usuario');

if (!$usuario) {
    header('Location: ' . base_url('/login'));
    exit;
}

$nombre         = $usuario['NOMBRE_USUARIO'] ?? 'Nombre';
$apellido       = $usuario['APELLIDO_USUARIO'] ?? 'Apellido';
$email          = $usuario['CORREO_USUARIO'] ?? 'correo@ejemplo.com';
$usuarioTag     = $usuario['NOMBRE_USUARIO'] ?? 'usuario_xxx';
$nombreCompleto = $nombre . ' ' . $apellido;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-800 to-black min-h-screen flex items-center justify-center text-white">

    <div class="bg-gray-900 shadow-lg rounded-2xl w-full max-w-2xl p-8 space-y-6">
        <!-- Encabezado con imagen -->
        <div class="flex items-center space-x-4">
            <img src="<?= base_url('img/usuario.jpg') ?>" alt="Usuario" class="w-20 h-20 rounded-full border-2 border-green-400">
            <div>
                <h2 class="text-xl font-bold"><?= esc($nombreCompleto) ?></h2>
                <p class="text-sm text-gray-400"><?= esc($email) ?></p>
            </div>
        </div>

        <!-- Información detallada -->
        <div class="space-y-2">
            <div>
                <label class="text-gray-400">Nombre completo</label>
                <div class="bg-gray-800 p-2 rounded border border-green-500"><?= esc($nombreCompleto) ?></div>
            </div>
            <div>
                <label class="text-gray-400">Correo electrónico</label>
                <div class="bg-gray-800 p-2 rounded border border-green-500"><?= esc($email) ?></div>
            </div>
            <div>
                <label class="text-gray-400">Nombre de usuario</label>
                <div class="bg-gray-800 p-2 rounded border border-green-500"><?= esc($usuarioTag) ?></div>
            </div>
        </div>

       <!-- Botones de navegación -->
<div class="grid grid-cols-2 gap-4 mt-6">
    <a href="<?= base_url('/perfil/seguridad'); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded text-center">Seguridad</a>
    <a href="<?= base_url('/perfil/perfil'); ?>" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded text-center">Perfil</a>
    
    
</div>

<!-- Botón cerrar sesión -->
<div class="mt-4">
    <a href="<?= base_url('/perfil/salir'); ?>" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded block text-center">
        Cerrar sesión
    </a>
</div>


    </div>

</body>
</html>
