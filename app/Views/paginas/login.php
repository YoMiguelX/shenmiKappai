<?= $this->extend('plantilla/layout') ?>

<?= $this->section('contenido') ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inicio de Sesión - Juego Educativo</title>
  <!-- CSS del login -->
  <link rel="stylesheet" href="<?= base_url('SRC.2/CSS/login.css'); ?>" />
  <!-- CSS del navbar -->
  <link rel="stylesheet" href="<?= base_url('SRC.2/CSS/navbar.css'); ?>" />
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body style="background: url('<?= base_url('SRC.2/IMG/fondo.jpg'); ?>') no-repeat center/cover; ">


  <!-- Mensajes flash -->
  <?php if (session()->getFlashdata('mensaje')): ?>
    <div class="alert alert-success text-center">
      <?= session()->getFlashdata('mensaje') ?>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('msg')): ?>
    <div class="alert alert-danger text-center">
      <?= session()->getFlashdata('msg') ?>
    </div>
  <?php endif; ?>

  <!-- Formulario de login -->
  <div class="login-container">
    <div class="login-left">
      <div class="overlay">
        <h1>¡Bienvenido a Shenmi!</h1>
        <p>Ingresa a las filas del aprendizaje usuario.</p>
      </div>
    </div>
    <div class="login-right">
      <form method="POST" action="<?= base_url('/login/acceder'); ?>">
        <h2>INICIAR SESIÓN</h2>
        <input type="email" name="correo" placeholder="Correo electrónico" required />
        <input type="password" name="contrasena" placeholder="Contraseña" required />
        <button type="submit">Acceder</button>
        <div class="acciones">
          <a href="<?= base_url('/restablecer'); ?>">¿Olvidaste tu contraseña?</a>
          <a href="<?= base_url('/registro'); ?>">Registrarme</a>
        </div>
      </form>
    </div>
  </div>

  <!--  Scripts del navbar -->
  <script>
    document.getElementById('bmenu')?.addEventListener('click', () => {
      document.getElementById('links').classList.toggle('show');
    });
  </script>
</body>
</html>

<?= $this->endSection() ?>