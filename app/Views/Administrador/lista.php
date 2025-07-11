<?php
// Bloquear caché para evitar mostrar información anterior tras cerrar sesión
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
    <title>Lista de Administradores y Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 to-black min-h-screen flex flex-col items-center text-white px-4 py-8 space-y-12">

    <!-- Mensajes Flash -->
    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="bg-green-600 px-6 py-4 rounded-lg shadow-lg text-white mb-4">
            <?= session()->getFlashdata('mensaje') ?>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="bg-red-600 px-6 py-4 rounded-lg shadow-lg text-white mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Encabezado y botones -->
    <div class="w-full max-w-6xl flex justify-between items-center">
        <h1 class="text-4xl font-bold">Panel de Administración</h1>
        <div class="flex space-x-2">
            <a href="<?= base_url('/administrador/crear'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
                Registrar Administrador
            </a>
            <a href="<?= base_url('/cerrarSesion'); ?>" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
                Cerrar Sesión
            </a>
            <a href="<?= base_url('/jugador'); ?>" 
   class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full transition duration-300 shadow-md">
   Ver Estado de Jugadores
</a>

        </div>
    </div>

    <!-- Tabla de Administradores -->
    <div class="w-full max-w-6xl bg-slate-900 rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold mb-6 border-b border-gray-700 pb-4">Lista de Administradores</h2>
        <div class="overflow-x-auto rounded-xl">
            <table class="w-full text-left table-auto">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Documento</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Apellido</th>
                        <th class="px-4 py-2">Correo</th>
                        <th class="px-4 py-2">Teléfono</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-200">
                    <?php if (!empty($administradores)): ?>
                        <?php foreach ($administradores as $i => $admin): ?>
                            <tr class="border-b border-gray-700 hover:bg-slate-800 transition">
                                <td class="px-4 py-3"><?= $i + 1 ?></td>
                                <td class="px-4 py-3"><?= esc($admin['DOC_USUARIO']) ?></td>
                                <td class="px-4 py-3"><?= esc($admin['NOMBRE_USUARIO']) ?></td>
                                <td class="px-4 py-3"><?= esc($admin['APELLIDO_USUARIO']) ?></td>
                                <td class="px-4 py-3"><?= esc($admin['CORREO_USUARIO']) ?></td>
                                <td class="px-4 py-3"><?= esc($admin['TEL_USUARIO']) ?></td>
                                <td class="px-4 py-3 space-x-2">
                                    <a href="<?= base_url('administrador/editar/' . $admin['ID_USUARIO']) ?>" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                        Editar
                                    </a>
                                    <a href="<?= base_url('administrador/eliminarUsuario/' . $admin['ID_USUARIO']) ?>"
                                       class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                                       onclick="return confirm('¿Estás seguro de eliminar este administrador?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-400">No hay administradores registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="w-full max-w-6xl bg-slate-900 rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold mb-6 border-b border-gray-700 pb-4">Lista de Usuarios</h2>
        <div class="overflow-x-auto rounded-xl">
            <table class="w-full text-left table-auto">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Documento</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Apellido</th>
                        <th class="px-4 py-2">Correo</th>
                        <th class="px-4 py-2">Teléfono</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-200">
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $j => $usuario): ?>
                            <tr class="border-b border-gray-700 hover:bg-slate-800 transition">
                                <td class="px-4 py-3"><?= $j + 1 ?></td>
                                <td class="px-4 py-3"><?= esc($usuario['DOC_USUARIO']) ?></td>
                                <td class="px-4 py-3"><?= esc($usuario['NOMBRE_USUARIO']) ?></td>
                                <td class="px-4 py-3"><?= esc($usuario['APELLIDO_USUARIO']) ?></td>
                                <td class="px-4 py-3"><?= esc($usuario['CORREO_USUARIO']) ?></td>
                                <td class="px-4 py-3"><?= esc($usuario['TEL_USUARIO']) ?></td>
                                <td class="px-4 py-3">
                                    <a href="<?= base_url('administrador/eliminarUsuario/' . $usuario['ID_USUARIO']) ?>"
                                       class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded"
                                       onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-400">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
