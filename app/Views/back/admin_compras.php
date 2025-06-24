<div class="container py-5">
    <h2 class="mb-4">Listado de Compras</h2>

    <?php foreach ($facturas as $factura): ?>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>Factura N° <?= esc($factura['id_orden']) ?></strong> -
                    <?= esc($factura['usuario']['nombre']) . ' ' . esc($factura['usuario']['apellido']) ?> |
                    <?= esc($factura['usuario']['email']) ?>
                    <?php if (!empty($factura['usuario']['telefono'])): ?>
                        | Tel: <?= esc($factura['usuario']['telefono']) ?>
                    <?php endif; ?>
                </div>
                <div>
                    <span class="me-3"><?= esc($factura['fecha_creacion']) ?></span>
                    <!--Botón para ver detalles-->
                    <a href="<?= base_url('/admin/compras/detalle/' . $factura['id_orden']) ?>" 
                       class="btn btn-danger btn-sm">
                        <i class="bi bi-eye me-1"></i>Ver Detalles
                    </a>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($factura['detalles'] as $detalle): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <!--Imagen del producto-->
                                <div class="me-3">
                                    <?php if (!empty($detalle['producto']['url_imagen'])): ?>
                                        <img src="<?= base_url('assets/img/uploads/' . $detalle['producto']['url_imagen']) ?>" 
                                             alt="<?= esc($detalle['producto']['nombre']) ?>"
                                             class="rounded"
                                             style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #dee2e6;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="bg-light rounded d-none align-items-center justify-content-center"
                                             style="width: 80px; height: 80px; border: 1px solid #dee2e6;">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width: 80px; height: 80px; border: 1px solid #dee2e6;">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!--Información del producto-->
                                <div>
                                    <h6 class="mb-1"><?= esc($detalle['producto']['nombre']) ?></h6>
                                    <small class="text-muted">Talle: <?= esc($detalle['talle']) ?></small>
                                    <br><small>Cantidad: <?= esc($detalle['cantidad']) ?> x $<?= esc($detalle['precio_unitario']) ?></small>
                                </div>
                            </div>
                            <div class="fw-bold text-end">
                                <div class="h5 mb-0">$<?= esc($detalle['subtotal']) ?></div>
                                <?php if (!empty($detalle['descuento']) && $detalle['descuento'] > 0): ?>
                                    <small class="text-success">Descuento: -$<?= esc($detalle['descuento']) ?></small>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    <?php if (!empty($factura['usuario']['domicilio'])): ?>
                        <small class="text-muted">
                            <i class="bi bi-geo-alt me-1"></i>
                            <?= esc($factura['usuario']['domicilio']['calle']) ?> <?= esc($factura['usuario']['domicilio']['numero']) ?>, 
                            <?= esc($factura['usuario']['domicilio']['localidad']) ?>, <?= esc($factura['usuario']['domicilio']['provincia']) ?>
                        </small>
                    <?php endif; ?>
                </div>
                <div class="text-end">
                    <?php if (!empty($factura['descuento']) && $factura['descuento'] > 0): ?>
                        <div><small class="text-success">Descuento total: -$<?= esc($factura['descuento']) ?></small></div>
                    <?php endif; ?>
                    <strong class="h5">Total: $<?= esc($factura['importe_total']) ?></strong>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($facturas)): ?>
        <div class="text-center py-5">
            <i class="bi bi-cart-x display-4 text-muted"></i>
            <p class="text-muted mt-3">No hay compras registradas.</p>
        </div>
    <?php endif; ?>
</div>

<style>
    .list-group-item {
        padding: 1rem;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    /* Responsive: apilar la imagen y el contenido */
    @media (max-width: 576px) {
        .list-group-item .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .list-group-item .me-3 {
            margin-right: 0 !important;
            margin-bottom: 0.75rem;
            align-self: center;
        }
    }
</style>