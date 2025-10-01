<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Administradores</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 to-black min-h-screen flex items-center justify-center text-white px-4">

    <div class="w-full max-w-6xl bg-slate-900 rounded-2xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-4">
            <h2 class="text-3xl font-bold"> Lista de Administradores</h2>
            <a href="<?= base_url('/administrador/crear'); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
                 Registrar Administrador
            </a>
        </div>

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
                                <td class="px-4 py-3">
                                    <a href="<?= base_url('administrador/editar/' . $admin['ID_USUARIO']) ?>" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                        Editar
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

</body>
</html>
