<?= $this->extend('plantilla/layout'); ?>
<?= $this->section('contenido'); ?>
<?= view('plantilla/navbar'); ?>

<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Estado de Jugadores</h1>
        <a href="<?= base_url('/administrador') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-300">
            ← Volver a Administrador
        </a>
    </div>

    <?php if (!empty($jugadores)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($jugadores as $jugador): ?>
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition duration-300">
                    <h2 class="text-xl font-semibold text-indigo-700 mb-1"><?= esc($jugador->NOMBRE_JUGADOR) ?></h2>
                    <p class="text-gray-500 text-sm mb-4">@<?= esc($jugador->NOMBRE_USUARIO) ?></p>

                    <div class="mb-3">
                        <span class="text-gray-600 font-medium">Nivel:</span>
                        <span class="text-indigo-600 font-semibold"><?= esc($jugador->nivel) ?></span>
                    </div>

                    <div class="mb-3">
                        <span class="text-gray-600 font-medium">Mundo:</span>
                        <span class="text-green-600 font-semibold"><?= esc($jugador->NOMBRE_MUNDO) ?></span>
                    </div>

                    <div class="mb-3 text-sm text-gray-500">
                        <p><strong>Registro:</strong> <?= esc($jugador->FECHA_REGISTRO) ?></p>
                        <p><strong>Última conexión:</strong> <?= esc($jugador->ULTIMA_CONEXION) ?></p>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm text-gray-600 mb-1">Progreso</p>
                        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                            <div class="bg-blue-500 h-4 rounded-full transition-all duration-500 ease-out" style="width: <?= esc($jugador->progreso) ?>%"></div>
                        </div>
                        <div class="text-right text-xs text-gray-500 mt-1"><?= esc($jugador->progreso) ?>%</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-600">No se encontraron jugadores registrados.</p>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
