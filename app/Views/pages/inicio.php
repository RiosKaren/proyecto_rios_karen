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

<!-- Productos Destacados desde la base -->
<section class="container py-5">
  <h2 class="text-center mb-4 text-white">Productos Destacados</h2>
  <div class="row text-center g-4">
    <?php if (empty($productos)): ?>
      <p class="text-center text-light">No hay productos disponibles en este momento.</p>
    <?php else: ?>
      <?php foreach ($productos as $p): ?>
        <div class="col-12 col-sm-6 col-lg-3">
          <a href="<?= base_url('producto/' . $p['id_producto']) ?>" class="text-decoration-none">
            <div class="card custom-card h-100 text-center border-0 position-relative <?= !$p['tiene_stock'] ? 'opacity-75' : '' ?>">
              
              <!-- Etiqueta "Sin stock" -->
              <?php if (!$p['tiene_stock']): ?>
                <div class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end" style="z-index: 10; font-size: 0.8rem;">
                  Sin stock
                </div>
              <?php endif; ?>
              
              <img src="<?= base_url('assets/img/uploads/' . $p['url_imagen']) ?>"
                   class="card-img-top px-3 pt-3 <?= !$p['tiene_stock'] ? 'filter-grayscale' : '' ?>"
                   alt="<?= esc($p['nombre']) ?>"
                   onerror="this.onerror=null;this.src='<?= base_url('assets/img/default.png') ?>';">
              <div class="card-body text-white">
                <h6 class="card-title mb-2 fw-bold"><?= esc($p['nombre']) ?></h6>
                <p class="text-success fw-semibold">$<?= number_format($p['precio'], 2) ?></p>
                <?php if (!$p['tiene_stock']): ?>
                  <p class="text-danger small mb-0">Producto agotado</p>
                <?php endif; ?>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<style>
  body {
    background-color: #111; /* fondo general negro */
  }

  .custom-card {
    background-color: #1f1f1f; /* gris oscuro */
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .custom-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 20px rgba(144, 57, 35, 0.18);
  }

  .filter-grayscale {
    filter: grayscale(100%);
  }

  .card:hover .filter-grayscale {
    filter: grayscale(50%);
    transition: filter 0.3s ease;
  }

  .card.opacity-75:hover {
    opacity: 0.9 !important;
    transition: opacity 0.3s ease;
  }

  .card-title, .text-muted {
    color: #fff !important;
  }
</style>
