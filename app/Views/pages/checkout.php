<div class="container py-5">
  <div class="row">
    <!--Paso visual del checkout-->
    <div class="col-12 mb-4 text-center">
      <div class="d-inline-flex align-items-center gap-3">
        <span class="fw-bold">Carrito</span>
        <i class="bi bi-arrow-right"></i>
        <span class="fw-bold text-decoration-underline">Entrega</span>
        <i class="bi bi-arrow-right"></i>
        <span class="fw-light">Pago</span>
      </div>
    </div>

    <!--Información del usuario logueado-->
    <div class="col-12 mb-4">
      <div class="alert alert-info">
        <h6 class="mb-2">Datos del usuario:</h6>
        <p class="mb-1"><strong>Nombre:</strong> <?= esc(session()->get('nombre')) ?> <?= esc(session()->get('apellido')) ?></p>
        <p class="mb-0"><strong>Email:</strong> <?= esc(session()->get('email')) ?></p>
      </div>
    </div>

    <!--Formulario de contacto y envío-->
    <div class="col-md-7">
      <form action="<?= base_url('/checkout/procesar') ?>" method="post">

        <!--Método de envío-->
        <div class="mb-4">
          <label class="form-label d-block">Entrega</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="envio" value="andreani" checked>
            <label class="form-check-label">
              Andreani Estándar "Envío a domicilio"
            </label>
          </div>
        </div>

        <!--Datos de envío-->
        <h5 class="mb-3">Dirección de entrega</h5>
        <div class="mb-3">
          <label class="form-label">Teléfono</label>
          <input type="tel" name="telefono" class="form-control" required>
        </div>
        <div class="row">
          <div class="col-md-8 mb-3">
            <label class="form-label">Calle</label>
            <input type="text" name="calle" class="form-control" required>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Número</label>
            <input type="text" name="numero" class="form-control" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="form-label">Código Postal</label>
            <input type="text" name="codigo_postal" class="form-control" required>
          </div>
          <div class="col-md-8 mb-3">
            <label class="form-label">Localidad</label>
            <input type="text" name="localidad" class="form-control" required>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Provincia</label>
            <input type="text" name="provincia" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">País</label>
            <input type="text" name="pais" class="form-control" value="Argentina" required>
          </div>
        </div>

        <button type="submit" class="btn btn-dark w-100 mt-3">Confirmar compra</button>
      </form>
    </div>

    <!--Resumen del carrito-->
    <div class="col-md-5 ps-md-5 mt-4 mt-md-0">
      <h5 class="fw-bold">Resumen del pedido</h5>
      <div class="border p-3 bg-light-subtle rounded text-dark">
        <?php 
          $carrito = session()->get('carrito') ?? [];
          $subtotal = 0;
          $envio = 15;
        ?>
        <?php foreach ($carrito as $item): 
          $subtotal += $item['precio'] * $item['cantidad'];
        ?>
          <div class="d-flex justify-content-between mb-2">
            <div>
              <img src="<?= base_url('assets/img/uploads/' . $item['imagen']) ?>" width="50" alt="Imagen producto">
              <span class="ms-2"><?= esc($item['nombre']) ?> (<?= esc($item['talle']) ?>) × <?= $item['cantidad'] ?></span>
            </div>
            <div>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></div>
          </div>
        <?php endforeach; ?>

        <hr>
        <div class="d-flex justify-content-between mb-1">
          <span class="text-muted">Subtotal (sin envío):</span>
          <span>$<?= number_format($subtotal, 2) ?></span>
        </div>
        <div class="d-flex justify-content-between mb-1">
          <span class="text-muted">Costo de envío:</span>
          <span>$<?= number_format($envio, 2) ?></span>
        </div>
        <hr>
        <div class="d-flex justify-content-between fw-bold fs-5">
          <span>Total:</span>
          <span>$<?= number_format($subtotal + $envio, 2) ?></span>
        </div>
      </div>
    </div>
  </div>
</div>