<div class="container mt-5">
    <h2>Administrar Productos</h2>
    <a href="<?= base_url('admin/productos/crear') ?>" class="btn btn-danger mb-4">Agregar nuevo producto</a>

    <!--Productos activos-->
    <h4>Productos activos</h4>
    <div class="table-responsive mb-5">
        <table class="table table-bordered table-hover align-middle text-wrap">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Talles y stock</th>
                    <th>Stock total</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <?php if ((int)$producto['activo'] === 1): ?>
                        <tr>
                            <td>
                                <img 
                                    src="<?= base_url('assets/img/uploads/' . $producto['url_imagen']) ?>" 
                                    width="60" 
                                    alt="Imagen del producto"
                                    onerror="this.onerror=null;this.src='<?= base_url('assets/img/default.png') ?>';">
                            </td>
                            <td><?= esc($producto['nombre']) ?></td>
                            <td style="white-space: normal; word-break: break-word;"><?= esc($producto['descripcion']) ?></td>
                            <td>$<?= esc(number_format($producto['precio'], 2)) ?></td>
                            <td>
                                <?php if (!empty($producto['talles'])): ?>
                                    <?php foreach ($producto['talles'] as $t): ?>
                                        <?= esc($t['talle']) ?> (<?= esc($t['stock']) ?>)<br>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <em>Sin talles</em>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($producto['stock']) ?></td>
                            <td>Sí</td>
                            <td>
                                <a href="<?= base_url('admin/productos/editar/' . $producto['id_producto']) ?>" class="btn btn-sm btn-warning mb-1">Editar</a>
                                <a href="<?= base_url('admin/productos/deshabilitar/' . $producto['id_producto']) ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('¿Seguro que querés deshabilitar este producto?');">Deshabilitar</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!--Productos inactivos-->
    <h4>Productos inactivos</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-wrap">
            <thead class="table-secondary">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Talles y stock</th>
                    <th>Stock total</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <?php if ((int)$producto['activo'] === 0): ?>
                        <tr>
                            <td>
                                <img 
                                    src="<?= base_url('assets/img/uploads/' . $producto['url_imagen']) ?>" 
                                    width="60" 
                                    alt="Imagen del producto"
                                    onerror="this.onerror=null;this.src='<?= base_url('assets/img/default.png') ?>';">
                            </td>
                            <td><?= esc($producto['nombre']) ?></td>
                            <td style="white-space: normal; word-break: break-word;"><?= esc($producto['descripcion']) ?></td>
                            <td>$<?= esc(number_format($producto['precio'], 2)) ?></td>
                            <td>
                                <?php if (!empty($producto['talles'])): ?>
                                    <?php foreach ($producto['talles'] as $t): ?>
                                        <?= esc($t['talle']) ?> (<?= esc($t['stock']) ?>)<br>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <em>Sin talles</em>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($producto['stock']) ?></td>
                            <td>No</td>
                            <td>
                                <a href="<?= base_url('admin/productos/editar/' . $producto['id_producto']) ?>" class="btn btn-sm btn-warning mb-1">Editar</a>
                                <a href="<?= base_url('admin/productos/habilitar/' . $producto['id_producto']) ?>" class="btn btn-sm btn-success mb-1" onclick="return confirm('¿Seguro que querés habilitar este producto?');">Habilitar</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
