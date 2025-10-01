<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($titulo) ? esc($titulo) : 'Shenmi' ?></title>

  <!-- CSS global -->
  <link rel="stylesheet" href="<?= base_url('SRC.2/CSS/navbar.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('SRC.2/CSS/login.css'); ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body style="background: url('<?= base_url('SRC.2/IMG/fondo.jpg'); ?>') no-repeat center/cover; padding-top: 0px">

  <!-- Navbar completo aquí -->
  <nav class="navbar-principal">
    <!-- Móvil -->
    <div class="mobile">
      <div class="header">
        <button id="bmenu"><i class="fa-solid fa-list"></i></button>
        <a href="<?= base_url('/'); ?>">
          <img src="<?= base_url('SRC.2/IMG/Shenmy Kappai.png'); ?>" width="60" alt="Logo" />
        </a>
        <div>
          <a href="<?= base_url('/login'); ?>"><i class="fa-solid fa-user"></i></a>
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
      </div>
      <div class="links" id="links">
        <a href="#">Juegos</a>
        <a href="<?= base_url('/soporte'); ?>">Soporte técnico</a>
      </div>
    </div>

    <!-- Escritorio -->
    <ul class="nav-left">
      <li><a href="<?= base_url('/'); ?>"><img src="<?= base_url('SRC.2/IMG/Shenmy Kappai.png'); ?>" width="60" alt="Logo"></a></li>
      <li><a href="#" class="link link-hide">Juegos</a></li>
      <li><a href="<?= base_url('/soporte'); ?>" class="link link-hide">Soporte técnico</a></li>
    </ul>

    <ul class="nav-right">
      <li><a href="#"><i class="fa-solid fa-search"></i></a></li>
      <li><a href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>
      <li><a href="<?= base_url('/login'); ?>"><i class="fa-solid fa-user"></i></a></li>
    </ul>
  </nav>

  <!--  Aquí se incrusta el contenido de cada página -->
  <main>
    <?= $this->renderSection('contenido') ?>
  </main>

  <!-- Scripts -->
  <script>
    document.getElementById('bmenu')?.addEventListener('click', () => {
      document.getElementById('links').classList.toggle('show');
    });
  </script>
</body>
</html>
