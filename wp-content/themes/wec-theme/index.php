<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WEC — World English Center</title>
  <?php wp_head(); ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    /* ruta base para assets */
    #hero { background-image: url('<?php echo get_template_directory_uri(); ?>/assets/hero.jpg'); }
  </style>
</head>
<body>

<?php $base = get_template_directory_uri(); ?>

<!-- ══ NAVEGACIÓN ══ -->
<nav>
  <a href="#inicio"><img class="logo" src="<?php echo $base; ?>/assets/logo.png" alt="WEC English Academy"></a>
  <div class="nav-toggle" onclick="this.nextElementSibling.classList.toggle('open')">
    <span></span><span></span><span></span>
  </div>
  <ul>
    <li><a href="#info">¿Quiénes somos?</a></li>
    <li><a href="#talleres">Talleres</a></li>
    <li><a href="#galeria">Galería</a></li>
    <li><a href="#contacto">Contacto</a></li>
  </ul>
</nav>

<!-- ══ HERO ══ -->
<section id="inicio">
  <div id="hero">
    <div class="hero-content">
      <h1>Aprende inglés de verdad.<br>Vive la experiencia WEC.</h1>
      <p>Academia de inglés en La Rioja — cursos, talleres y mucho más</p>
      <a href="#contacto" class="btn">Contacta con nosotros</a>
    </div>
  </div>
</section>

<!-- ══ INFORMACIÓN ══ -->
<section id="info">
  <div class="contenedor">
    <h2 class="titulo">¿Quiénes somos?</h2>
    <div class="linea"></div>
    <p class="subtitulo">En WEC llevamos años ayudando a estudiantes de todas las edades a alcanzar sus metas en inglés.</p>
    <div class="cards-info">
      <div class="card-info">
        <div class="icono">🎓</div>
        <h3>Formación de calidad</h3>
        <p>Metodología comunicativa y enfoque práctico adaptado a cada nivel, desde A1 hasta C2.</p>
      </div>
      <div class="card-info">
        <div class="icono">👩‍🏫</div>
        <h3>Profesores nativos</h3>
        <p>Nuestro equipo docente combina profesores nativos y especializados con amplia experiencia.</p>
      </div>
      <div class="card-info">
        <div class="icono">📚</div>
        <h3>Preparación oficial</h3>
        <p>Preparamos para Cambridge, IELTS, TOEFL y otros exámenes de certificación internacional.</p>
      </div>
      <div class="card-info">
        <div class="icono">🌍</div>
        <h3>Cultura anglosajona</h3>
        <p>Talleres creativos, actividades culturales y proyectos que van más allá del aula.</p>
      </div>
    </div>
  </div>
</section>

<!-- ══ TALLERES ══ -->
<section id="talleres">
  <div class="contenedor">
    <h2 class="titulo">Talleres</h2>
    <div class="linea"></div>
    <div class="tabs">
      <button class="tab-btn activo" onclick="mostrarTab('realizados', this)">Realizados</button>
      <button class="tab-btn"       onclick="mostrarTab('proximos',   this)">Próximos</button>
    </div>

    <!-- Talleres realizados -->
    <div id="tab-realizados" class="tab-content activo">
      <div class="taller-card">
        <img src="<?php echo $base; ?>/assets/taller-scrapbooking.jpg" alt="Taller de Scrapbooking en inglés">
        <div class="taller-info">
          <span class="badge badge-realizado">Realizado</span>
          <h3>Taller de Scrapbooking en inglés</h3>
          <p>Los alumnos crearon álbumes creativos mientras practicaban vocabulario y expresión oral en inglés. Una experiencia única que une arte e idioma.</p>
        </div>
      </div>
      <div class="taller-card">
        <img src="<?php echo $base; ?>/assets/taller-b2.jpg" alt="Intensivo B2 Adolescentes">
        <div class="taller-info">
          <span class="badge badge-realizado">Realizado</span>
          <h3>Intensivo B2 Adolescentes</h3>
          <p>Curso intensivo de preparación para el examen B2 de Cambridge dirigido a jóvenes, con simulacros y técnicas de examen.</p>
        </div>
      </div>
    </div>

    <!-- Próximos talleres -->
    <div id="tab-proximos" class="tab-content">
      <div class="taller-card">
        <img src="<?php echo $base; ?>/assets/hero.jpg" alt="Halloween en inglés">
        <div class="taller-info">
          <span class="badge badge-proximo">Próximamente</span>
          <h3>Halloween en inglés 🎃</h3>
          <p>Un taller especial de Halloween donde los alumnos practicarán el vocabulario y las tradiciones anglosajonas de una forma divertida y diferente.</p>
        </div>
      </div>
      <div class="taller-card">
        <img src="<?php echo $base; ?>/assets/hero.jpg" alt="Christmas Workshop">
        <div class="taller-info">
          <span class="badge badge-proximo">Próximamente</span>
          <h3>Christmas Workshop 🎄</h3>
          <p>Actividades navideñas en inglés: canciones, manualidades y juegos para celebrar la Navidad anglosajona con nuestros estudiantes.</p>
        </div>
      </div>
      <div class="taller-card">
        <img src="<?php echo $base; ?>/assets/hero.jpg" alt="Club de Lectura en inglés">
        <div class="taller-info">
          <span class="badge badge-proximo">Próximamente</span>
          <h3>Club de Lectura en inglés 📖</h3>
          <p>Sesiones mensuales para mejorar la comprensión lectora y la expresión oral debatiendo sobre libros en inglés adaptados a cada nivel.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══ GALERÍA ══ -->
<section id="galeria">
  <div class="contenedor">
    <h2 class="titulo">Galería</h2>
    <div class="linea"></div>
    <p class="subtitulo">Momentos de nuestros talleres y actividades</p>
    <div class="galeria">
      <img src="<?php echo $base; ?>/assets/galeria-1.png" alt="Taller scrapbooking 1" onclick="abrirLb(this.src)">
      <img src="<?php echo $base; ?>/assets/galeria-2.png" alt="Taller scrapbooking 2" onclick="abrirLb(this.src)">
      <img src="<?php echo $base; ?>/assets/galeria-3.png" alt="Taller scrapbooking 3" onclick="abrirLb(this.src)">
      <img src="<?php echo $base; ?>/assets/galeria-4.png" alt="Taller scrapbooking 4" onclick="abrirLb(this.src)">
      <img src="<?php echo $base; ?>/assets/taller-b2.jpg"           alt="Curso B2"           onclick="abrirLb(this.src)">
      <img src="<?php echo $base; ?>/assets/taller-scrapbooking.jpg" alt="Taller scrapbooking" onclick="abrirLb(this.src)">
    </div>
  </div>
</section>

<!-- Lightbox -->
<div class="lb-overlay" id="lightbox" onclick="cerrarLb()">
  <span class="lb-close">✕</span>
  <img id="lb-img" src="" alt="Imagen ampliada">
</div>

<!-- ══ CONTACTO ══ -->
<section id="contacto">
  <div class="contenedor">
    <h2 class="titulo">Contacto</h2>
    <div class="linea"></div>
    <div class="contacto-grid">
      <div class="contacto-datos">
        <h3>¡Hablemos!</h3>
        <p>Si tienes alguna pregunta sobre nuestros cursos, talleres o precios, escríbenos o llámanos. Estaremos encantados de ayudarte.</p>
        <br>
        <p class="icono-linea">📍 <span>La Rioja, España</span></p>
        <p class="icono-linea">📞 <a href="tel:+34000000000">+34 000 000 000</a></p>
        <p class="icono-linea">✉️ <a href="mailto:info@wec.jamezcuarodriguez.es">info@wec.jamezcuarodriguez.es</a></p>
        <p class="icono-linea">🕘 <span>Lun–Vie: 9:00 – 21:00</span></p>
      </div>
      <div>
        <form onsubmit="enviarForm(event)">
          <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" placeholder="Tu nombre" required>
          </div>
          <div class="campo">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" placeholder="tu@email.com" required>
          </div>
          <div class="campo">
            <label for="interes">Me interesa…</label>
            <select id="interes">
              <option value="">— Selecciona —</option>
              <option>Cursos de inglés general</option>
              <option>Preparación B2 / C1</option>
              <option>Inglés para niños</option>
              <option>Talleres creativos</option>
              <option>Información general</option>
            </select>
          </div>
          <div class="campo">
            <label for="mensaje">Mensaje</label>
            <textarea id="mensaje" placeholder="Cuéntanos qué necesitas…"></textarea>
          </div>
          <button type="submit">Enviar mensaje →</button>
          <div class="form-ok" id="form-ok">✅ ¡Mensaje enviado! Te contactaremos pronto.</div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ══ FOOTER ══ -->
<footer>
  <p>© <?php echo date('Y'); ?> <strong>WEC English Academy</strong> · La Rioja, España</p>
  <p style="margin-top:.4rem">
    <a href="mailto:info@wec.jamezcuarodriguez.es">info@wec.jamezcuarodriguez.es</a>
  </p>
</footer>

<script>
function mostrarTab(id, btn) {
  document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('activo'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('activo'));
  document.getElementById('tab-' + id).classList.add('activo');
  btn.classList.add('activo');
}
function abrirLb(src) {
  document.getElementById('lb-img').src = src;
  document.getElementById('lightbox').classList.add('open');
}
function cerrarLb() {
  document.getElementById('lightbox').classList.remove('open');
}
function enviarForm(e) {
  e.preventDefault();
  document.getElementById('form-ok').style.display = 'block';
  e.target.reset();
}
</script>

<?php wp_footer(); ?>
</body>
</html>
