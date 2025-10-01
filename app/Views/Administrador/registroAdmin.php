<?php
// Verificar si el usuario está logeado
if (!session()->get('isLoggedIn')) {
    return redirect()->to('/login')->with('error', 'Por favor inicia sesión');
}


// Bloquear caché
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url('SRC.2/CSS/login.css') ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url('<?= base_url('/imagenes/fondo.jpg'); ?>'); background-size: cover; background-position: center;" class="flex items-center justify-center min-h-screen">

    <button onclick="history.back()" type="button" class="btn btn-danger btn-volver">
        Volver
    </button>

    <form action="<?= base_url('/administrador/guardar'); ?>" method="POST" class="bg-slate-900 bg-opacity-90 p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-white text-2xl font-bold mb-6 text-center">Registro de Administrador</h2>

       


        <!-- Tipo de Documento y Documento -->
        <div class="flex gap-4 mb-4">
            <div class="w-1/2">
                <label class="block text-white">Tipo de Documento</label>
                <select 
                    name="TIPO_DOCUMENTO"
                    class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" 
                    required>
                    <option value="">Seleccione</option>
                    <option value="CC">Cédula de Ciudadanía (CC)</option>
                    <option value="TI">Tarjeta de Identidad (TI)</option>
                    <option value="CE">Cédula de Extranjería (CE)</option>
                </select>
            </div>
            <div class="w-1/2">
                <label class="block text-white">Documento</label>
                <input type="text" name="DOC_USUARIO" 
                    class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="123456789" required>
            </div>
        </div>

        <!-- Nombre y Apellido -->
        <div class="flex gap-4 mb-4">
            <div class="w-1/2">
                <label class="block text-white">Nombre</label>
                <input type="text" name="NOMBRE_USUARIO" 
                      class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="Miguel" required>
            </div>
            <div class="w-1/2">
                <label class="block text-white">Apellido</label>
                <input type="text" name="APELLIDO_USUARIO" 
                      class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="Arevalo" required>
            </div>
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label class="block text-white">Teléfono</label>
            <input type="text" name="TEL_USUARIO" 
                  class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="300000000" required>
        </div>

        <!-- Correo -->
        <div class="mb-4">
            <label class="block text-white">Correo Electrónico</label>
            <input type="email" name="CORREO_USUARIO" 
                  class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="micorreo@gmail.com" required>
        </div>

        <!-- Contraseña -->
        <div class="mb-6">
            <label class="block text-white">Contraseña</label>
            <input type="password" name="CONTRASENA" 
                  class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50"  placeholder="Contraseña321." required>
        </div>

        <!-- Botón -->
        <div>
            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                Registrar Administrador
            </button>
            <p class="text-white text-sm mt-4 text-center">
                ¿Ya tienes una cuenta? 
                <a href="<?= base_url('/login'); ?>" class="text-blue-400 hover:underline">Inicia sesión</a>
            </p>
        </div>
    </form>

</body>
</html>
