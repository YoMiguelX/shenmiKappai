<?= $this->extend('plantilla/layout'); ?>
<?= $this->section('contenido'); ?>
<?= view('plantilla/navbar'); ?>

<?php
$usuario = session('usuario');
if (!$usuario) {
    return redirect()->to('/login');
}
$mensaje = session()->getFlashdata('success');
?>

<div class="relative h-screen w-screen" style="background-image: url('<?= base_url('/imagenes/fondo.jpg'); ?>'); background-size: cover; background-position: center;">

  <a href="javascript:history.back()" 
     class="absolute top-4 right-4 z-20 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-lg transition">
    Volver
  </a>

  <!-- Contenedor centrado -->
  <div class="flex items-center justify-center h-full w-full px-4">
    <form action="<?= base_url('/perfil/actualizar') ?>" method="POST"
          class="bg-slate-900 bg-opacity-90 p-8 rounded shadow-md w-full max-w-md">
      <h2 class="text-white text-2xl font-bold mb-6 text-center">Editar Perfil</h2>

      <!-- Mensaje éxito -->
      <?php if ($mensaje): ?>
        <div class="bg-green-600 text-white p-3 mb-4 text-center rounded">
          <?= esc($mensaje) ?>
        </div>
      <?php endif; ?>

      <!-- Nombre -->
      <div class="mb-4">
        <label class="block text-white">Nombre</label>
        <input type="text" name="nombre" value="<?= esc($usuario['NOMBRE_USUARIO']) ?>"
               class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
      </div>

      <!-- Apellido -->
      <div class="mb-4">
        <label class="block text-white">Apellido</label>
        <input type="text" name="apellido" value="<?= esc($usuario['APELLIDO_USUARIO']) ?>"
               class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
      </div>

      <!-- Correo Electrónico -->
      <div class="mb-6">
        <label class="block text-white">Correo Electrónico</label>
        <input type="email" name="email" value="<?= esc($usuario['CORREO_USUARIO']) ?>"
               class="w-full mt-1 p-2 bg-gray-800 text-white border border-green-500 rounded" required>
      </div>
          <!-- numero de teléfono -->


      <!-- Botón Guardar Cambios -->
      <div>
        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
          Guardar Cambios
        </button>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection(); ?>
