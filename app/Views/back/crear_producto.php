<div class="container mt-5 text-white">
  <h2>Crear Producto</h2>

  <form action="<?= base_url('/admin/productos/guardar') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="descripcion" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Precio</label>
      <input type="number" step="0.01" name="precio" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Imagen</label>
      <input type="file" name="imagen" class="form-control" required>
    </div>

    <div id="talles-container">
      <label class="form-label">Talles y stock</label>
      <div class="row g-2 align-items-center mb-2 talle-group">
        <div class="col-md-5">
        <select name="talles[]" class="form-control" required>
          <option value="">Seleccioná talle</option>
          <?php
            $talles = [
              "6 US","6.5 US","7 US","7.5 US","8 US","8.5 US",
              "9 US","9.5 US","10 US","10.5 US","11 US","11.5 US",
              "12 US","12.5 US"
            ];
            foreach($talles as $t) {
              echo "<option value=\"{$t}\">{$t}</option>";
            }
          ?>
        </select>
      </div>
        <div class="col-md-5">
          <input type="number" name="stocks[]" class="form-control" placeholder="Stock" required>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger btn-remove-talle">X</button>
        </div>
      </div>
    </div>

    <button type="button" class="btn btn-secondary mb-3" id="agregar-talle">+ Agregar talle</button>
    <br>
    <button type="submit" class="btn btn-danger">Guardar Producto</button>
  </form>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("talles-container");
    const btnAgregar = document.getElementById("agregar-talle");

    btnAgregar.addEventListener("click", function () {
      const grupo = document.createElement("div");
      grupo.className = "row g-2 align-items-center mb-2 talle-group";
      grupo.innerHTML = `
        <div class="col-md-5">
          <input type="text" name="talles[]" class="form-control" placeholder="Talle (ej: 9 US)" required>
        </div>
        <div class="col-md-5">
          <input type="number" name="stocks[]" class="form-control" placeholder="Stock" required>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger btn-remove-talle">X</button>
        </div>
      `;
      container.appendChild(grupo);
    });

    container.addEventListener("click", function (e) {
      if (e.target.classList.contains("btn-remove-talle")) {
        const group = e.target.closest(".talle-group");
        if (group) group.remove();
      }
    });
  });
</script>
