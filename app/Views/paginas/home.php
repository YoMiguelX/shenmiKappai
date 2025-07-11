<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shenmi Kappai</title>

  <!-- Íconos-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="SRC.2/CSS/main.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div id="main-container">
    <header>
      <nav>
  <!-- Versión móvil -->
        <div class="mobile">
          <div class="header">
            <button id="bmenu"><i class="fa-solid fa-list"></i></button>
            <a href="#"><img src="SRC.2/IMG/Shenmy Kappai.png" width="60" alt="Logo" /></a>
            <div>
              <a href="#"><i class="fa-solid fa-user"></i></a>
              <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
          </div>
          <div class="links">
            <a href="#">Juegos</a>
            <!--<a href="#">Comunidad</a>-->
            <a href="#">Soporte</a>
          </div>
        </div>

  <!-- Navegación de escritorio -->
        <ul>
          <li><img src="SRC.2/IMG/Shenmy Kappai.png" width="60" alt="Shenmy Kappai"></li>
          <li><a href="#" class="link link-hide">Juegos</a></li>
          <!--<li><a href="#" class="link link-hide">Comunidad</a></li>-->         <!--Para agregar posteriormente-->
          <li><a href="soporteTecnico.html" class="link link-hide">Soporte técnico</a></li>
          <li class="more">
            <a href="#" class="link" id="bmore">Menú</a>
            <div class="menu">
              <!--<a href="#">Comunidad</a>-->         <!--Para agregar posteriormente-->
              <a href="#">Soporte técnico</a>
            </div>
          </li>
        </ul>

        <!-- Íconos extras -->
        <ul>
          <li><a href="#" class="link"><i class="fa-solid fa-search"></i></a></li>
          <li><a href="#" class="link"><i class="fa-solid fa-cart-shopping"></i></a></li>
          <li><<?= anchor('perfil', 'Perfil', ['class' => 'link']) ?></li>
        </ul>
      </nav>
    </header>

  <!-- Banner -->
    <section id="banner">
      <h2>Shenmi Kappai Game</h2>
      <div style="width: 85%; margin: 0 auto;">
        <p>
          Supera desafíos interactivos y actividades adaptadas a tu ritmo mientras 
          desarrollas habilidades en matemáticas, ciencias, lenguaje y más. 
          ¡Explora, diviértete y crece!
        </p>
        <a href="#" class="green-button">
          Entra Ahora <i class="bi bi-box-arrow-in-right"></i>
        </a>
      </div>
    </section>

    <!-- Videos -->
    <section id="videos">
      <section>
        <h2>DESARROLLA</h2>
      </section>
      <p class="w-75">
        El juego se desenvolverá en cuestionarios, tarjetas y juegos del conocimiento. La idea es aprender mientras avanzas en la historia.
      </p>
      <h3>Trailers y Gameplay</h3>

      <div id="slider">
        <div id="controls">
          <button id="prev"><i class="bi bi-chevron-left"></i></button>
          <button id="next"><i class="bi bi-chevron-right"></i></button>
        </div>
        <div id="current"></div>
        <div id="videos-container"></div>
      </div>
    </section>

    <!-- Multijugador -->
    <section id="multi-player">
      <div class="info">
        <h2>MULTIJUGADOR LEGENDARIO, LIBERADO</h2>
        <p>
          Esta es la era de la tecnología. Celebramos este año dando paso a nuestra inteligencia para seguir progresando, cultivando el aprendizaje. Apuntamos a volvernos vibrantes, curiosos y dispuestos a compartir conocimiento sin límites.
        </p>
      </div>
    </section>

    <!-- Tienda -->    
    <section id="get-the-game">
       <h2>Obtén el juego.</h2>
       <div class="item-store">
         <div class="left">
         <img src="SRC.2/IMG/ESTUDIO.jpg" alt="" />
       </div>

       <div class="right">
         <div class="info-product">
           <h3>Shenmi Kappai Demo</h3>
           <h4>Accede a nuestra demo</h4>
           <p>Explora mundos, retos imposibles, y gana la medalla al jugador más valioso.</p>
        <section>
          <button class="green-button">ÚNETE AL RETO SHENMI<i class="bi bi-controller"></i></button>
        </section>
                            
          <h4>Compra Shenmi Kappai</h4>
          <p>$0.00 USD</p>
        <select>
          <option value="xbox">Xbox</option>  
          <option value="windows">Windows 10 PC</option>
          <option value="steam">Steam</option>
        </select>
          <section> 
            <p>
            <button class="green-button">COMPRA AHORA <i class="bi bi-bag-plus"></i></button>
            </p>
          </section> 
        </div>
        </div>
      </div>
      </section> 

<!-- Footer -->
    <footer class="footer-personalizado">
      <a href="#" class="volver-arriba" aria-label="Volver arriba">
        <i class="fa-solid fa-house"></i>
      </a>

      <div class="iconos-sociales">
        <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://twitch.tv" target="_blank"><i class="fab fa-twitch"></i></a>
        <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
      </div>
 
      <div class="enlaces-footer">
        <a href="#">Opciones de privacidad</a>
        <a href="#">Privacidad y cookies</a>
        <a href="#">Condiciones de uso</a>
      </div>
      <p>&copy; 2025 Shenmi Kappai. Todos los derechos reservados.</p>
    </footer>
  </div>

  <script src="SRC.2/JS/main.js"></script>
</body>
</html>
    

