<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pluto Sneakers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom py-3 fixed-top">
  <div class="container-fluid d-flex align-items-center">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center me-4" href="<?php echo base_url(); ?>">
      <img src="assets/img/logo.png" alt="Pluto Sneakers Logo">
    </a>

    <!-- Botón para abrir el offcanvas (Responsive) -->
    <button class="navbar-toggler text-white ms-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
      aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <i class="bi bi-list" style="font-size: 1.5rem;"></i>
    </button>

    <!-- Menú normal para pantallas grandes -->
    <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
      <ul class="navbar-nav d-flex flex-row align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>quienes_somos">Quiénes somos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>comercializacion">Comercialización</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>contacto">Información de contacto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>terminos">Términos y usos</a>
        </li>
      </ul>
    </div>

  </div>
</nav>

<!-- Offcanvas para telefonos -->
<div class="offcanvas offcanvas-start offcanvas-custom" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav justify-content-start flex-grow-1">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>quienes_somos">Quiénes somos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>comercializacion">Comercialización</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>contacto">Información de contacto</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>terminos">Términos y usos</a>
      </li>
    </ul>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>