<?php /** @var array $producto */ ?>
<?php /** @var array $talles */ ?>

<form action="<?= base_url('/admin/productos/actualizar/' . $producto['id_producto']) ?>" method="post" enctype="multipart/form-data" class="text-white container py-5">
  <h2>Editar Producto</h2>

  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="<?= esc($producto['nombre']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" required><?= esc($producto['descripcion']) ?></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Precio</label>
    <input type="number" name="precio" class="form-control" step="0.01" value="<?= esc($producto['precio']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Imagen actual</label><br>
    <?php if ($producto['url_imagen']): ?>
      <img src="<?= base_url('assets/img/uploads/' . $producto['url_imagen']) ?>" alt="Imagen actual" style="max-width: 150px;">
    <?php else: ?>
      <p>No hay imagen</p>
    <?php endif; ?>
  </div>

  <div class="mb-3">
    <label class="form-label">Nueva Imagen (opcional)</label>
    <input type="file" name="imagen" class="form-control">
  </div>

  <div class="mb-3">
    <label class="form-label">Talles y stock</label>
    <div id="talle-container">
      <?php foreach ($talles as $index => $talle): ?>
        <div class="row mb-2 talle-item">
          <div class="col">
            <input type="text" name="talles[]" class="form-control" placeholder="Talle" value="<?= esc($talle['talle']) ?>" required>
          </div>
          <div class="col">
            <input type="number" name="stocks[]" class="form-control" placeholder="Stock" value="<?= esc($talle['stock']) ?>" required>
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-danger btn-remove-talle">X</button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button type="button" id="agregarTalle" class="btn btn-secondary mt-2">Agregar talle</button>
  </div>

  <button type="submit" class="btn btn-primary">Actualizar producto</button>
</form>

<script>
  document.getElementById('agregarTalle').addEventListener('click', function () {
    const container = document.getElementById('talle-container');
    const row = document.createElement('div');
    row.className = 'row mb-2 talle-item';
    row.innerHTML = `
      <div class="col">
        <input type="text" name="talles[]" class="form-control" placeholder="Talle" required>
      </div>
      <div class="col">
        <input type="number" name="stocks[]" class="form-control" placeholder="Stock" required>
      </div>
      <div class="col-auto">
        <button type="button" class="btn btn-danger btn-remove-talle">X</button>
      </div>
    `;
    container.appendChild(row);
  });

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-remove-talle')) {
      e.target.closest('.talle-item').remove();
    }
  });
</script>
