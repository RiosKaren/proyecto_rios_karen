<div id="carritoSidebar" class="carrito-sidebar">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-white">CARRITO DE COMPRAS</h5>
    <button onclick="cerrarCarrito()" class="btn btn-sm btn-outline-light">×</button>
  </div>

  <?php 
    $carrito = session()->get('carrito') ?? [];
    $total = 0;
  ?>

  <?php if (empty($carrito)): ?>
    <p class="text-center text-white">Tu carrito está vacío.</p>
  <?php else: ?>
    <?php foreach ($carrito as $id => $item): 
      $subtotal = $item['precio'] * $item['cantidad'];
      $total += $subtotal;
    ?>
    <div class="d-flex border-bottom border-secondary py-3">
      <div class="me-3 d-flex align-items-start">
        <img 
          src="<?= base_url('assets/img/uploads/' . $item['imagen']) ?>" 
          alt="Imagen producto" 
          style="width: 70px; height: 70px; object-fit: contain; border: 1px solid #555; padding: 2px;">
      </div>

      <div class="flex-grow-1">
        <div class="d-flex justify-content-between">
          <div class="fw-bold text-white"><?= esc($item['nombre']) ?> (<?= esc($item['talle']) ?>)</div>
          <div class="text-end fw-semibold text-white">$<?= number_format($item['precio'], 2) ?></div>
        </div>

        <div class="d-flex align-items-center mt-2" style="gap: 8px;">
          <!--Botón restar-->
          <form action="<?= base_url('carrito/actualizar') ?>" method="post" style="display: inline;">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="accion" value="restar">
            <button class="btn btn-outline-light btn-sm px-2" type="submit" <?= $item['cantidad'] <= 1 ? 'disabled' : '' ?>>−</button>
          </form>

          <span class="px-2 text-white"><?= $item['cantidad'] ?></span>

          <!--Botón sumar-->
          <form action="<?= base_url('carrito/actualizar') ?>" method="post" style="display: inline;">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="accion" value="sumar">
            <button class="btn btn-outline-light btn-sm px-2" type="submit">+</button>
          </form>

          <!--Botón eliminar-->
          <a href="<?= base_url('carrito/eliminar/' . $id) ?>" class="text-danger small ms-auto"><i class="bi bi-trash3-fill"></i></a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <div class="border-top border-secondary mt-3 pt-3">
      <p class="mb-1 text-white">Subtotal (sin envío): <span class="float-end fw-semibold text-white">$<?= number_format($total, 2) ?></span></p>
      <hr class="border-secondary">
      <h5 class="fw-bold text-white">Total: <span class="float-end text-white">$<?= number_format($total, 2) ?></span></h5>
    </div>

    <a href="<?= base_url('/checkout') ?>" class="btn btn-light text-dark w-100 mt-3 fw-bold">INICIAR COMPRA</a>
    <div class="text-center mt-2">
      <a href="<?= base_url('/') ?>" class="text-decoration-underline small text-white">
        Ver más productos
      </a>
    </div>
  <?php endif; ?>
</div>

<style>
.carrito-sidebar {
  position: fixed;
  right: -500px;
  top: 0;
  width: 420px;
  height: 100vh;
  background: #1e1e21;
  box-shadow: -3px 0 15px rgba(0, 0, 0, 0.2);
  transition: right 0.3s ease;
  z-index: 9999;
  padding: 1.5rem;
  overflow-y: auto;
}
.carrito-sidebar.abierto {
  right: 0;
}


.carrito-sidebar * {
  color: white !important;
}


.carrito-sidebar .btn-light {
  color: #1e1e21 !important;
}

.carrito-sidebar .text-danger {
  color: #dc3545 !important;
}
</style>

<script>
function abrirCarrito() {
  document.getElementById('carritoSidebar').classList.add('abierto');
}
function cerrarCarrito() {
  document.getElementById('carritoSidebar').classList.remove('abierto');
}
</script>