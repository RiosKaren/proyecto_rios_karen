
<main class="container-fluid p-0">

<!-- Carrusel principal -->
<div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/img/carrusel1.jpg" class="d-block w-100" alt="Carrusel 1">
    </div>
    <div class="carousel-item">
      <img src="assets/img/carrusel2.jpg" class="d-block w-100" alt="Carrusel 2">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Anterior</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Siguiente</span>
  </button>
</div>

  <!-- Productos destacados -->
  <section class="container py-5">
    <h2 class="text-center mb-4 body">Productos Destacados</h2>
    <div class="row text-center g-4">
      <?php
        $productos = [
          ['nombre' => 'Air Jordan Retro 4 - Black Cat', 'imagen' => 'black-cat-2020.png', 'precio' => '8/10/11US - $250'],
          ['nombre' => 'Air Jordan Retro 4 SB - Pine Green', 'imagen' => 'Pine Green.png', 'precio' => '8/10US - $550'],
          ['nombre' => 'Air Jordan Retro 4 - Yellow Thunder', 'imagen' => 'thunder.png', 'precio' => '8.5/9US - $275'],
          ['nombre' => 'Air Jordan Retro 4 - Travis Scott Olive', 'imagen' => 'Air-Jordan-4-Retro-Travis-Scott-Olive.png', 'precio' => '9/10.5US - $300'],
          ['nombre' => 'Air Jordan Retro 1 High - Off White Chicago', 'imagen' => 'Air-Jordan-1-Retro-High-Off-White-Chicago-Product.png', 'precio' => '9/11/12US - $250'],
          ['nombre' => 'Air Jordan Retro 1 High - Off White UNC ', 'imagen' => 'Air-Jordan-1-Retro-High-Off-White-University-Blue-Product.png', 'precio' => '8/9.5US - $345'],
          ['nombre' => 'Air Jordan Retro 1 High - Dior', 'imagen' => 'Air-Jordan-1-Retro-High-Dior-Product.png', 'precio' => '9/10US - $300'],
          ['nombre' => 'Air Jordan Retro 1 High - Travis Scott Mocha ', 'imagen' => 'Air-Jordan-1-Retro-High-Travis-Scott-Product.png', 'precio' => '8.5/10/11US - $275'],
          ['nombre' => 'Nike Air Force One - Off White Green Spark', 'imagen' => 'Nike-Air-Force-1-Low-Off-White-Light-Green-Spark-Product.png', 'precio' => '9/10.5US - $345'],
          ['nombre' => 'Nike Air Force One - Off White Virgil', 'imagen' => 'Nike-Air-Force-1-07-Virgil-X-Moma-Ns-Product-1.png', 'precio' => '8.5/10/11US - $275'],
          ['nombre' => 'Nike Air Force One - VLONE', 'imagen' => 'Nike-Air-Force-1-Low-VLONE-2017-Product.png', 'precio' => '8/9.5/11US - $250'],
          ['nombre' => 'Nike Air Force One - Travis Scott AF100', 'imagen' => 'Nike-Air-Force-1-Low-Travis-Scott-AF100-Product.png', 'precio' => '9/10/12US - $300']
        ];
         
        foreach ($productos as $p):
      ?>
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card h-100 text-center border-0">
          <img src="<?= base_url('assets/img/' . $p['imagen']) ?>" class="card-img-top" alt="<?= esc($p['nombre']) ?>">
          <div class="card-body">
            <h6 class="card-title mb-2 fw-bold"><?= esc($p['nombre']) ?></h6>
            <p class="text-muted"><?= esc($p['precio']) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>
</main>