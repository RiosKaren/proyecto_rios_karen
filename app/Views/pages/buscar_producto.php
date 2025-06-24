<?php
$busqueda = $busqueda ?? '';
$productos = $productos ?? [];
$totalResultados = count($productos);
?>

<div class="container py-5">
  <!--Header de búsqueda-->
  <div class="row mb-4">
    <div class="col-12">
      <div class="search-header text-center text-white">
        <?php if (!empty($busqueda)): ?>
          <h2 class="mb-3">Resultados para: <span class="text-danger"><?= esc($busqueda) ?></span></h2>
          <p class="mb-1">Se encontraron <?= $totalResultados ?> producto<?= $totalResultados != 1 ? 's' : '' ?></p>
        <?php else: ?>
          <h2 class="mb-3">Todos los productos</h2>
          <p class="text-muted">Mostrando <?= $totalResultados ?> producto<?= $totalResultados != 1 ? 's' : '' ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!--Resultados de busqueda-->
  <div class="row">
    <?php if (empty($productos)): ?>
      <!--Sin resultados-->
      <div class="col-12">
        <div class="no-results text-center text-white py-0">
          <div class="no-results-icon mb-4">
            <i class="bi bi-search" style="font-size: 4rem; opacity: 0.3;"></i>
          </div>
          <?php if (!empty($busqueda)): ?>
            <h3 class="mb-3">No se encontraron productos</h3>
            <p class="mb-4">Tu búsqueda "<?= esc($busqueda) ?>" no coincide con ningún producto.</p>
            <div class="suggestions">
              <h5 class="mb-3">Sugerencias:</h5>
              <ul class="list-unstyled mb-3">
                <li>• Verifica la ortografía de las palabras</li>
                <li>• Intenta con términos más generales</li>
                <li>• Usa menos palabras clave</li>
                <li>• Prueba con sinónimos</li>
              </ul>
            </div>
          <?php else: ?>
            <h3 class="mb-3">No hay productos disponibles</h3>
            <p class="text-muted">No hay productos para mostrar en este momento.</p>
          <?php endif; ?>
          
          <div class="mt-4">
            <a href="<?= base_url() ?>" class="btn btn-danger">
                <i class="bi bi-house"></i> Volver al inicio
            </a>
          </div>
        </div>
      </div>
    <?php else: ?>
      <!--Lista de productos-->
      <div class="col-12">
        <div class="productos-grid">
          <div class="row g-4">
            <?php foreach ($productos as $p): ?>
              <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <a href="<?= base_url('producto/' . $p['id_producto']) ?>" class="text-decoration-none">
                  <div class="card product-card h-100 text-center border-0 position-relative <?= !$p['tiene_stock'] ? 'opacity-75' : '' ?>">
                    
                    <!--Etiqueta "Sin stock"-->
                    <?php if (!$p['tiene_stock']): ?>
                      <div class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end stock-badge">
                        Sin stock
                      </div>
                    <?php endif; ?>
                    
                    <!--Imagen del producto-->
                    <div class="product-image-container">
                      <img src="<?= base_url('assets/img/uploads/' . $p['url_imagen']) ?>"
                           class="card-img-top product-image <?= !$p['tiene_stock'] ? 'filter-grayscale' : '' ?>"
                           alt="<?= esc($p['nombre']) ?>"
                           onerror="this.onerror=null;this.src='<?= base_url('assets/img/default.png') ?>';">
                      
                      <!--Overlay con botón-->
                      <div class="product-overlay">
                        <div class="overlay-content">
                          <?php if ($p['tiene_stock']): ?>
                            <button class="btn btn-overlay">
                              <i class="bi bi-eye"></i> Ver detalles
                            </button>
                          <?php else: ?>
                            <button class="btn btn-overlay btn-disabled">
                              <i class="bi bi-x-circle"></i> Sin stock
                            </button>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    
                    <!--Información del producto-->
                    <div class="card-body text-white d-flex flex-column">
                      <h6 class="card-title mb-2 fw-bold product-title"><?= esc($p['nombre']) ?></h6>
                      
                      <div class="mt-auto">
                        <p class="text-success fw-semibold mb-1 product-price">$<?= number_format($p['precio'], 2) ?></p>
                        
                        <?php if (!$p['tiene_stock']): ?>
                          <p class="text-danger small mb-0">Producto agotado</p>
                        <?php else: ?>
                          <p class="text-danger small mb-0"><?= $p['stock'] ?> disponible<?= $p['stock'] != 1 ? 's' : '' ?></p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!--Volver a inicio si hay resultados-->
  <?php if (!empty($productos)): ?>
    <div class="row mt-5">
      <div class="col-12 text-center">
        <a href="<?= base_url() ?>" class="btn btn-outline-light">
          <i class="bi bi-arrow-left"></i> Volver al inicio
        </a>
      </div>
    </div>
  <?php endif; ?>
</div>

<style>

  /* Estilos para la búsqueda */
  .search-header h2 {
    font-weight: 700;
    margin-bottom: 1rem;
  }

  .search-form-container {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 1.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .search-input-secondary {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    color: white;
    padding: 12px 20px;
    font-size: 1rem;
    transition: all 0.3s ease;
  }

  .search-input-secondary:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: #e74c3c;
    box-shadow: 0 0 0 0.2rem rgba(92, 44, 18, 0.25);
    color: white;
  }

  .search-input-secondary::placeholder {
    color: rgba(255, 255, 255, 0.6);
  }

  .btn-search {
    background: linear-gradient(45deg, #e74c3c, #c0392b);
    border: none;
    border-radius: 25px;
    color: white;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
    white-space: nowrap;
  }

  .btn-search:hover {
    background: linear-gradient(45deg, #c0392b, #a93226);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    color: white;
  }

  /* Tarjetas de productos */
  .product-card {
    background: linear-gradient(145deg, #2c2c2c, #1f1f1f);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s ease;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
  }

  .product-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(144, 23, 23, 0.2);
  }

  .product-image-container {
    position: relative;
    overflow: hidden;
    height: 250px;
  }

  .product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.4s ease;
    padding: 1rem;
  }

  .product-card:hover .product-image {
    transform: scale(1.1);
  }

  .product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
  }

  .product-card:hover .product-overlay {
    opacity: 1;
  }

  .btn-overlay {
    background: linear-gradient(45deg, #c0392b, #a93226);
    border: none;
    border-radius: 25px;
    color: white;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
    transform: translateY(20px);
  }

  .product-card:hover .btn-overlay {
    transform: translateY(0);
  }

  .btn-overlay:hover {
    background: linear-gradient(45deg,#c0392b, #a93226);
    transform: scale(1.05);
    color: white;
  }

  .btn-overlay.btn-disabled {
    background: #666;
    cursor: not-allowed;
  }

  .stock-badge {
    z-index: 10;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
  }

  .product-title {
    font-size: 1.1rem;
    line-height: 1.3;
    min-height: 2.6rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .product-description {
    font-size: 0.85rem;
    line-height: 1.4;
    opacity: 0.8;
  }

  .product-price {
    font-size: 1.2rem;
    font-weight: 700;
  }

  .filter-grayscale {
    filter: grayscale(100%);
  }

  .product-card:hover .filter-grayscale {
    filter: grayscale(50%);
  }

  /* Sin resultados */
  .no-results {
    min-height: 50vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .no-results-icon {
    animation: pulse 2s infinite;
  }

  @keyframes pulse {
    0% { opacity: 0.3; }
    50% { opacity: 0.6; }
    100% { opacity: 0.3; }
  }

  .suggestions ul li {
    margin-bottom: 0.5rem;
    text-align: left;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .search-form-container {
      padding: 1rem;
    }
    
    .search-form-container form {
      flex-direction: column;
      gap: 1rem !important;
    }
    
    .btn-search {
      width: 100%;
    }
    
    .product-image-container {
      height: 200px;
    }
    
    .product-card:hover {
      transform: translateY(-5px) scale(1.01);
    }
  }

  @media (max-width: 576px) {
    .search-header h2 {
      font-size: 1.5rem;
    }
    
    .product-image-container {
      height: 180px;
    }
  }
</style>