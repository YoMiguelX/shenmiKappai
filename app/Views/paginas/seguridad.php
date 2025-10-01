<?= view('plantilla/navbar'); ?>

<?php $mensaje = session('msg'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seguridad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url('<?= base_url('/imagenes/fondo.jpg'); ?>'); background-size: cover; background-position: center;" class="flex items-center justify-center min-h-screen relative">

    <!-- Botón Volver -->
    <a href="<?= base_url('/perfil'); ?>"
       class="absolute top-4 right-4 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded shadow">
        Volver
    </a>

    <div class="bg-slate-900 bg-opacity-90 p-8 rounded shadow-md w-full max-w-2xl mx-4">
        <h2 class="text-white text-2xl font-bold mb-6 text-center">Centro de Seguridad</h2>

        <!-- Mostrar mensaje si existe -->
        <?php if ($mensaje): ?>
            <div class="bg-green-600 text-white p-3 mb-4 text-center rounded">
                <?= esc($mensaje) ?>
            </div>
        <?php endif; ?>

        <!-- Cambiar Contraseña -->
        <form action="<?= base_url('/seguridad/cambiar'); ?>" method="POST" class="mb-10">
            <h3 class="text-white text-xl mb-4">Cambiar Contraseña</h3>

            <div class="mb-4">
                <label class="block text-white">Contraseña Actual</label>
                <input type="password" name="actual" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-white">Nueva Contraseña</label>
                <input type="password" name="nueva" id="nueva" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
            </div>

            <div class="mb-6">
                <label class="block text-white">Confirmar Nueva Contraseña</label>
                <input type="password" name="confirmar" id="confirmar" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
                <p id="msg" class="text-red-400 text-sm mt-1 hidden">Las contraseñas no coinciden.</p>
            </div>

            <button type="submit" id="guardar" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">
                Guardar Contraseña
            </button>
        </form>

        <!-- Actividad Reciente -->
        <div>
            <h3 class="text-white text-xl mb-4">Actividad Reciente</h3>
            <ul class="text-gray-300 bg-gray-800 p-4 rounded max-h-40 overflow-y-auto text-sm">
                <?php foreach ($actividad ?? [] as $evento): ?>
                    <li>📌 <?= esc($evento['fecha']) ?> - <?= esc($evento['accion']) ?></li>
                <?php endforeach; ?>
                <?php if (empty($actividad)): ?>
                    <li>No hay actividad registrada.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script>
        const nueva = document.getElementById('nueva');
        const confirmar = document.getElementById('confirmar');
        const mensaje = document.getElementById('msg');
        const boton = document.getElementById('guardar');

        function validar() {
            if (nueva.value !== confirmar.value) {
                mensaje.classList.remove('hidden');
                boton.disabled = true;
            } else {
                mensaje.classList.add('hidden');
                boton.disabled = false;
            }
        }

        nueva.addEventListener('input', validar);
        confirmar.addEventListener('input', validar);
    </script>
</body>
</html>
