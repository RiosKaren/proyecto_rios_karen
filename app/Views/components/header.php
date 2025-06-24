<?php
  $carrito = session()->get('carrito') ?? [];
  $totalItems = 0;
  foreach ($carrito as $item) {
      $totalItems += $item['cantidad'];
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pluto Sneakers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --dark-bg: #1e1e21;
      --light-text: #f5f5f5;
      --accent-color: #e74c3c;
      --cart-badge: #e74c3c;
      --hover-transition: all 0.3s ease;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      padding-top: 50px; /* Espacio para el header fijo */
    }
    
    /* Header Principal */
    .main-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background-color: var(--dark-bg);
      z-index: 1000;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    /* Sección superior del header */
    .header-top {
      padding: 1rem 0;
      border-bottom: 1px solid #333;
    }

    .header-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Ícono de búsqueda */
    .search-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: transparent;
      border: 2px solid var(--light-text);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--light-text);
      cursor: pointer;
      transition: var(--hover-transition);
      text-decoration: none;
    }

    .search-icon:hover {
      background: var(--accent-color);
      border-color: var(--accent-color);
      color: white;
      transform: scale(1.05);
    }

    /* Logo centrado */
    .logo-container {
      flex: 1;
      display: flex;
      justify-content: center;
    }

    .logo {
      font-size: 2rem;
      font-weight: 900;
      color: var(--light-text);
      text-decoration: none;
      letter-spacing: -1px;
      transition: var(--hover-transition);
    }

    .logo:hover img {
      transform: scale(1.05); /* Solo un pequeño efecto de escala al hover */
    }

    .logo img {
      max-height: 60px;
      width: auto;
      transition: var(--hover-transition);
    }

    .logo:hover img {
      filter: brightness(0) invert(1) sepia(1) saturate(5) hue-rotate(0deg) brightness(1.2);
    }

    /* Iconos de la derecha */
    .header-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    /* Dropdown de usuario */
    .user-dropdown {
      position: relative;
    }

    .user-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: transparent;
      border: 2px solid var(--light-text);
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--hover-transition);
    }

    .user-icon:hover {
      background: var(--accent-color);
      border-color: var(--accent-color);
      transform: scale(1.05);
    }

    .user-icon i {
      font-size: 18px;
      color: var(--light-text);
    }

    .user-menu {
      position: absolute;
      top: calc(100% + 10px);
      right: 0;
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      min-width: 220px;
      z-index: 1000;
      display: none;
      overflow: hidden;
    }

    .user-menu.show {
      display: block;
      animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .user-menu-header {
      padding: 16px;
      background: #f8f9fa;
      border-bottom: 1px solid #eee;
    }

    .user-menu-header h6 {
      margin: 0;
      font-weight: 600;
      color: #333;
      font-size: 0.9rem;
    }

    .user-menu-header small {
      color: #666;
      font-size: 0.8rem;
    }

    .user-menu-item {
      display: block;
      padding: 12px 16px;
      text-decoration: none;
      color: #333;
      transition: var(--hover-transition);
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      font-size: 0.9rem;
    }

    .user-menu-item:hover {
      background: var(--accent-color);
      color: white;
    }

    .user-menu-item i {
      margin-right: 10px;
      width: 16px;
    }

    .user-menu-divider {
      height: 1px;
      background: #eee;
      margin: 0;
    }

    /* Botón de login */
    .login-btn {
      color: var(--light-text);
      text-decoration: none;
      padding: 8px 16px;
      border: 2px solid var(--light-text);
      border-radius: 25px;
      transition: var(--hover-transition);
      font-size: 0.9rem;
    }

    .login-btn:hover {
      background: var(--accent-color);
      border-color: var(--accent-color);
      color: white;
    }

    /* Carrito */
    .cart-icon {
      position: relative;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: transparent;
      border: 2px solid var(--light-text);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--light-text);
      cursor: pointer;
      transition: var(--hover-transition);
    }

    .cart-icon:hover {
      background: var(--accent-color);
      border-color: var(--accent-color);
      color: white;
      transform: scale(1.05);
    }

    .cart-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: var(--cart-badge);
      color: white;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: bold;
      border: 2px solid var(--dark-bg);
    }

    /* Navegación inferior */
    .header-nav {
      padding: 0rem 0;
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      justify-content: center;
    }

    .nav-menu {
      display: flex;
      list-style: none;
      gap: 2rem;
      margin: 0;
      padding: 0;
    }

    .nav-item {
      margin: 0;
    }

    .nav-link {
      color: var(--light-text);
      text-decoration: none;
      font-weight: 500;
      font-size: 0.95rem;
      padding: 0.5rem 0;
      position: relative;
      transition: var(--hover-transition);
    }

    .nav-link:hover {
      color: var(--accent-color);
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--accent-color);
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    /* Menú móvil */
    .mobile-menu-btn {
      display: none;
      background: none;
      border: none;
      color: var(--light-text);
      font-size: 1.5rem;
      cursor: pointer;
    }

    .mobile-nav {
      display: none;
      background: var(--dark-bg);
      border-top: 1px solid #333;
      padding: 1rem 0;
    }

    .mobile-nav.show {
      display: block;
    }

    .mobile-nav-menu {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .mobile-nav-link {
      color: var(--light-text);
      text-decoration: none;
      padding: 0.75rem 0;
      border-bottom: 1px solid #333;
      transition: var(--hover-transition);
    }

    .mobile-nav-link:hover {
      color: var(--accent-color);
    }

    /* Carrito Sidebar */
    .carrito-sidebar {
      position: fixed;
      right: -400px;
      top: 0;
      width: 400px;
      height: 100vh;
      background: #fff;
      box-shadow: -2px 0 8px rgba(0,0,0,0.2);
      transition: right 0.3s ease;
      z-index: 9999;
      padding: 1rem;
      overflow-y: auto;
    }

    .carrito-sidebar.abierto {
      right: 0;
    }

    .carrito-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #eee;
    }

    /* Barra de búsqueda */
    .search-bar {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: var(--dark-bg);
      border-top: 1px solid #333;
      border-bottom: 1px solid #333;
      padding: 1rem 0;
      display: none;
      z-index: 999;
    }

    .search-bar.show {
      display: block;
      animation: slideDown 0.3s ease;
    }

    .search-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 1rem;
      display: flex;
      gap: 1rem;
      align-items: center;
    }

    .search-input {
      flex: 1;
      padding: 12px 16px;
      border: 2px solid #333;
      border-radius: 25px;
      background: #2a2a2d;
      color: var(--light-text);
      font-size: 1rem;
      outline: none;
      transition: var(--hover-transition);
    }

    .search-input:focus {
      border-color: var(--accent-color);
      background: #333;
    }

    .search-input::placeholder {
      color: #888;
    }

    .search-btn {
      padding: 12px 24px;
      background: var(--accent-color);
      color: white;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-weight: 600;
      transition: var(--hover-transition);
    }

    .search-btn:hover {
      background: #c0392b;
      transform: translateY(-1px);
    }

    .search-close {
      background: none;
      border: none;
      color: var(--light-text);
      font-size: 1.5rem;
      cursor: pointer;
      padding: 0;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: var(--hover-transition);
    }

    .search-close:hover {
      background: #333;
      color: var(--accent-color);
    }
    /* Responsive */
    @media (max-width: 768px) {
      body {
        padding-top: 100px;
      }

      .header-container {
        padding: 14 0.5rem;
      }

      .logo img {
        max-height: 35px;
      }

      .header-actions {
        gap: 0.5rem;
      }

      .nav-menu {
        display: none;
      }

      .mobile-menu-btn {
        display: block;
      }

      .carrito-sidebar {
        width: 100vw;
        right: -100vw;
      }

      .user-menu {
        right: -50px;
        min-width: 200px;
      }

      .search-container {
        padding: 0 0.5rem;
      }

      .search-input {
        font-size: 0.9rem;
      }

      .search-btn {
        padding: 12px 16px;
        font-size: 0.9rem;
      }
    }

    @media (max-width: 480px) {
      .header-container {
        flex-wrap: wrap;
        gap: 0.5rem;
      }

      .search-icon,
      .user-icon,
      .cart-icon {
        width: 35px;
        height: 35px;
      }

      .logo img {
        max-height: 30px;
      }

      .search-container {
        flex-direction: column;
        gap: 0.5rem;
      }

      .search-input {
        width: 100%;
      }

      .search-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<!--HEADER PRINCIPAL-->
<header class="main-header">
  <!--Sección superior-->
  <div class="header-top">
    <div class="header-container">
      <!--Ícono de búsqueda-->
      <a href="#" class="search-icon" title="Buscar productos" onclick="toggleSearch()">
        <i class="bi bi-search"></i>
      </a>

      <!--Logo centrado-->
      <div class="logo-container">
        <a href="<?php echo base_url(); ?>" class="logo">
          <!--Logo como imagen-->
          <img src="<?= base_url('assets/img/logo1.png') ?>" alt="Pluto Sneakers Logo">
        </a>
      </div>

      <!--Iconos de la derecha-->
      <div class="header-actions">
        <?php if (session()->get('isLoggedIn')): ?>
          <!--Dropdown de usuario-->
          <div class="user-dropdown">
            <div class="user-icon" onclick="toggleUserMenu()">
              <i class="bi bi-person-fill"></i>
            </div>
            <div class="user-menu" id="userMenu">
              <div class="user-menu-header">
                <h6><?= esc(session()->get('nombre')) ?> <?= esc(session()->get('apellido')) ?></h6>
                <small><?= esc(session()->get('email')) ?></small>
              </div>
              <a href="<?= base_url('/perfil'); ?>" class="user-menu-item">
                <i class="bi bi-person"></i>Mi Perfil
              </a>
              <?php if (session()->get('id_rol') == 1): ?>
                <a href="<?= base_url('/admin'); ?>" class="user-menu-item">
                  <i class="bi bi-gear"></i>Panel Admin
                </a>
              <?php endif; ?>
              <div class="user-menu-divider"></div>
              <a href="<?= base_url('/logout'); ?>" class="user-menu-item">
                <i class="bi bi-box-arrow-right"></i>Cerrar sesión
              </a>
            </div>
          </div>
        <?php else: ?>
          <a class="login-btn" href="<?php echo base_url('/login'); ?>">Iniciar sesión</a>
        <?php endif; ?>

        <!--Carrito-->
        <div class="cart-icon" onclick="abrirCarrito()" title="Carrito de compras">
          <i class="bi bi-cart-fill"></i>
          <?php if ($totalItems > 0): ?>
            <span class="cart-badge"><?= $totalItems ?></span>
          <?php endif; ?>
        </div>

        <!--Botón menú móvil-->
        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
          <i class="bi bi-list"></i>
        </button>
      </div>
    </div>
  </div>

  <!--Navegación principal-->
  <nav class="header-nav">
    <div class="nav-container">
      <ul class="nav-menu">
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>quienes_somos">Quiénes Somos</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>comercializacion">Comercialización</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>contacto">Contacto</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>terminos">Términos y Usos</a></li>
      </ul>
    </div>
  </nav>

  <!--Barra de búsqueda-->
  <div class="search-bar" id="searchBar">
    <div class="search-container">
      <input type="text" class="search-input" placeholder="Buscar productos..." id="searchInput">
      <button class="search-btn" onclick="performSearch()">
        <i class="bi bi-search"></i> Buscar
      </button>
      <button class="search-close" onclick="toggleSearch()">
        <i class="bi bi-x"></i>
      </button>
    </div>
  </div>

  <!--Menú móvil-->
  <div class="mobile-nav" id="mobileNav">
    <div class="mobile-nav-menu">
      <a class="mobile-nav-link" href="<?php echo base_url(); ?>">Inicio</a>
      <a class="mobile-nav-link" href="<?php echo base_url(); ?>quienes_somos">Quiénes Somos</a>
      <a class="mobile-nav-link" href="<?php echo base_url(); ?>comercializacion">Comercialización</a>
      <a class="mobile-nav-link" href="<?php echo base_url(); ?>contacto">Contacto</a>
      <a class="mobile-nav-link" href="<?php echo base_url(); ?>terminos">Términos y Usos</a>
    </div>
  </div>
</header>

<!--CARRITO LATERAL-->
<?php include(APPPATH . 'Views/pages/carrito.php'); ?>

<script>
  //Función para abrir carrito
  function abrirCarrito() {
    document.querySelector('.carrito-sidebar').classList.add('abierto');
  }
  
  //Función para cerrar carrito
  function cerrarCarrito() {
    document.querySelector('.carrito-sidebar').classList.remove('abierto');
  }
  
  //Toggle menú de usuario
  function toggleUserMenu() {
    const menu = document.getElementById('userMenu');
    menu.classList.toggle('show');
  }
  
  //Toggle menú móvil
  function toggleMobileMenu() {
    const mobileNav = document.getElementById('mobileNav');
    mobileNav.classList.toggle('show');
  }
  
  //Toggle barra de búsqueda
  function toggleSearch() {
    const searchBar = document.getElementById('searchBar');
    const searchInput = document.getElementById('searchInput');
    
    searchBar.classList.toggle('show');
    
    if (searchBar.classList.contains('show')) {
      setTimeout(() => {
        searchInput.focus();
      }, 300);
    }
  }
  
  //Realizar búsqueda
  function performSearch() {
    const searchInput = document.getElementById('searchInput');
    const query = searchInput.value.trim();
    
    if (query) {
      //Redirigir a la página de resultados de búsqueda
      window.location.href = '<?= base_url() ?>productos/buscar?q=' + encodeURIComponent(query);
    } else {
      //Si no hay término de búsqueda, mostrar todos los productos
      window.location.href = '<?= base_url() ?>productos';
    }
  }
  
  // Buscar al presionar Enter
  document.getElementById('searchInput').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
      performSearch();
    }
  });
  
  //Cerrar menús al hacer clic fuera
  document.addEventListener('click', function(event) {
    const userDropdown = document.querySelector('.user-dropdown');
    const userMenu = document.getElementById('userMenu');
    const mobileNav = document.getElementById('mobileNav');
    const mobileBtn = document.querySelector('.mobile-menu-btn');
    const searchBar = document.getElementById('searchBar');
    const searchIcon = document.querySelector('.search-icon');
    
    //Cerrar menú de usuario
    if (userDropdown && !userDropdown.contains(event.target)) {
      userMenu.classList.remove('show');
    }
    
    //Cerrar menú móvil
    if (mobileNav && !mobileNav.contains(event.target) && !mobileBtn.contains(event.target)) {
      mobileNav.classList.remove('show');
    }
    
    //Cerrar carrito al hacer clic fuera
    const cartSidebar = document.querySelector('.carrito-sidebar');
    const cartIcon   = document.querySelector('.cart-icon');
    if (cartSidebar && !cartSidebar.contains(event.target) && !cartIcon.contains(event.target)) {
      cartSidebar.classList.remove('abierto');
    }

    //Cerrar barra de búsqueda
    if (searchBar && !searchBar.contains(event.target) && !searchIcon.contains(event.target)) {
      searchBar.classList.remove('show');
    }
  });
  
  //Cerrar carrito al presionar Escape
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
      cerrarCarrito();
      document.getElementById('userMenu').classList.remove('show');
      document.getElementById('mobileNav').classList.remove('show');
      document.getElementById('searchBar').classList.remove('show');
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>