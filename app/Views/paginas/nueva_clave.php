<?= $this->extend('plantilla/layout'); ?>

<?= $this->section('contenido'); ?>
<?= view('plantilla/navbar'); ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Restablecer Contraseña
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600">
        Ingresa tu nueva contraseña para continuar
      </p>
    </div>

    <?php if (session()->getFlashdata('msg')): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline"><?= session()->getFlashdata('msg') ?></span>
      </div>
    <?php endif; ?>

    <form class="mt-8 space-y-6" action="<?= base_url('/guardar-clave') ?>" method="POST" onsubmit="return validarContraseñas()">
      <input type="hidden" name="token" value="<?= esc($token) ?>">

      <div class="rounded-md shadow-sm -space-y-px">
        <div class="mb-4">
          <label for="contrasena" class="block text-gray-700 font-medium mb-1">Nueva Contraseña</label>
          <input id="contrasena" name="contrasena" type="password" required
            class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            placeholder="Nueva contraseña">
        </div>

        <div class="mb-4">
          <label for="contrasena2" class="block text-gray-700 font-medium mb-1">Confirmar Contraseña</label>
          <input id="contrasena2" name="contrasena2" type="password" required
            class="appearance-none rounded relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            placeholder="Confirmar contraseña">
        </div>
      </div>

      <div id="errorMensaje" class="text-red-600 text-sm mb-3 hidden">
        Las contraseñas no coinciden.
      </div>

      <div>
        <button type="submit"
          class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
          Guardar Contraseña
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function validarContraseñas() {
    const pass1 = document.getElementById('contrasena').value;
    const pass2 = document.getElementById('contrasena2').value;
    const error = document.getElementById('errorMensaje');

    if (pass1 !== pass2) {
      error.classList.remove('hidden');
      return false; // Detiene el envío del formulario
    }

    error.classList.add('hidden');
    return true;
  }
</script>

<?= $this->endSection(); ?>
