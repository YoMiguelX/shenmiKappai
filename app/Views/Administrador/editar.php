<?php $mensaje = session('msg'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrador</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url('SRC.2/CSS/login.css'); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url('<?= base_url('/imagenes/fondo.jpg'); ?>'); background-size: cover; background-position: center;" class="flex items-center justify-center min-h-screen">

    <button onclick="history.back()" type="button" class="btn btn-danger btn-volver">
        Volver
    </button>

    <form action="<?= base_url('/administrador/actualizar/' . $admin['ID_USUARIO']); ?>" method="POST" class="bg-slate-900 bg-opacity-90 p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-white text-2xl font-bold mb-6 text-center">Editar Administrador</h2>

        <?php if ($mensaje): ?>
            <div class="bg-green-600 text-white p-3 mb-4 text-center rounded"> 
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <!-- Tipo de documento y documento -->
        <div class="flex gap-4 mb-4">
            <div class="w-1/2">
                <label class="block text-white">Tipo de Documento</label>
                <select name="TIPO_DOCUMENTO" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
                    <option value="">Seleccione</option>
                    <option value="CC" <?= $admin['TIPO_DOCUMENTO'] == 'CC' ? 'selected' : '' ?>>CC</option>
                    <option value="TI" <?= $admin['TIPO_DOCUMENTO'] == 'TI' ? 'selected' : '' ?>>TI</option>
                </select>
            </div>
            <div class="w-1/2">
                <label class="block text-white">Documento</label>
                <input type="text" name="DOC_USUARIO" value="<?= esc($admin['DOC_USUARIO']) ?>" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
            </div>
        </div>

        <!-- Nombre y Apellido -->
        <div class="flex gap-4 mb-4">
            <div class="w-1/2">
                <label class="block text-white">Nombre</label>
                <input type="text" name="NOMBRE_USUARIO" value="<?= esc($admin['NOMBRE_USUARIO']) ?>" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
            </div>
            <div class="w-1/2">
                <label class="block text-white">Apellido</label>
                <input type="text" name="APELLIDO_USUARIO" value="<?= esc($admin['APELLIDO_USUARIO']) ?>" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
            </div>
        </div>

        <!-- Teléfono -->
        <div class="mb-4">
            <label class="block text-white">Teléfono</label>
            <input type="text" name="TEL_USUARIO" value="<?= esc($admin['TEL_USUARIO']) ?>" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
        </div>

        <!-- Correo -->
        <div class="mb-4">
            <label class="block text-white">Correo Electrónico</label>
            <input type="email" name="CORREO_USUARIO" value="<?= esc($admin['CORREO_USUARIO']) ?>" class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
        </div>

        <!-- Botón actualizar -->
        <div>
            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">
                Actualizar Administrador
            </button>
        </div>
    </form>

</body>
</html>
