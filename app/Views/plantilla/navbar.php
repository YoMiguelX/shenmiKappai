<nav class="navbar-principal">
  <!-- Versión móvil -->
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
      <a href="#" style="padding-bottom: 0px;">Juegos</a>
      <a href="<?= base_url('/soporte'); ?>"; >Soporte técnico</a>
    </div>
  </div>

  <!-- Escritorio -->
  <ul class="nav-left">
    <li><a href="<?= base_url('/'); ?>"><img src="<?= base_url('SRC.2/IMG/Shenmy Kappai.png'); ?>" width="60" alt="Logo"></a></li>
    <li><a href="#" class="link link-hide">Juegos</a></li>
    <li><a href="<?= base_url('/soporte'); ?>" class="link link-hide " >Soporte técnico</a></li>
    <li class="more">
  
      </div>
    </li>
  </ul>

  <ul class="nav-right">
    <li><a href="#" class="link"><i class="fa-solid fa-search"></i></a></li>
    <li><a href="#"><i class="fa-solid fa-cart-shopping"></i></a></li>
    <li><a href="<?= base_url('/login'); ?>" class="link"><i class="fa-solid fa-user"></i></a></li>
  </ul>
</nav>

<!-- Script -->
<script>
  document.getElementById('bmenu')?.addEventListener('click', () => {
    document.getElementById('links').classList.toggle('show');
  });
  document.getElementById('bmore')?.addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('menu').classList.toggle('show');
  });
</script>
