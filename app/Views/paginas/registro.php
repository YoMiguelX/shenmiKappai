<?= view('plantilla/navbar'); ?>

<?php
$mensaje = session('msg');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- CSS del navbar -->
<link rel="stylesheet" href="<?= base_url('SRC.2/CSS/navbar.css'); ?>" />
<!-- Iconos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="SRC.2/CSS/login.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="registro-page" style="padding-top: 0px; background: url('<?= base_url('SRC.2/IMG/fondoregistro.jpg'); ?>') no-repeat center/cover; padding-top: 0px">
    <div class="registro-container">
        <!-- Parte izquierda con fondo -->
        <div class="registro-left"></div>

        <!-- Parte derecha con el formulario -->
        <div class="registro-right" style="background-color:black">
            <form action="<?= base_url('/registro/guardar'); ?>" method="POST" >
                <h2 class="text-white text-2xl font-bold mb-6 text-center">Registro de Usuario</h2>

                <?php if ($mensaje): ?>
                    <div class="bg-green-600 text-white p-3 mb-4 text-center rounded">
                        <?= htmlspecialchars($mensaje) ?>
                    </div>
                <?php endif; ?>


                <!-- Nombre y Apellido -->
                <div class="flex gap-4 mb-4">
                    <div class="w-1/2">
                        <label class="block text-white">Nombre</label>
                        <input type="text" name="NOMBRE_USUARIO" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="Miguel" required>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-white">Apellido</label>
                        <input type="text" name="APELLIDO_USUARIO" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="Arevalo" required>
                    </div>
                </div>

                <!-- Teléfono -->
                <div class="mb-4">
                    <label class="block text-white">Teléfono</label>
                    <input type="text" name="TEL_USUARIO" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="300000000" required>
                </div>

                <!-- Correo -->
                <div class="mb-4">
                    <label class="block text-white">Correo Electrónico</label>
                    <input type="email" name="CORREO_USUARIO" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="micorreo@gmail.com" required>
                </div>

                <!-- Contraseña -->
                <div class="mb-6">
                    <label class="block text-white">Contraseña</label>
                    <input type="password" name="CONTRASENA" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded placeholder-gray-400 placeholder-opacity-50" placeholder="Contraseña321." required>
                </div>

                <!-- Botón -->
                <div>
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Registrarse</button>
                    <p class="text-white text-sm mt-4 text-center">
                        ¿Ya tienes una cuenta?
                        <a href="<?= base_url('/login'); ?>" class="text-blue-400 hover:underline">Inicia sesión</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
