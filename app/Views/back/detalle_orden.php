<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!--Mensaje de estado-->
            <div class="alert alert-info text-center mb-4">
                <h4 class="mb-2">Orden #<?= str_pad($orden['id_orden'], 6, '0', STR_PAD_LEFT) ?></h4>
                <p class="mb-0">Estado: <span class="badge bg-success">Pagado</span> - Envío: <span class="badge bg-primary">Enviado</span></p>
            </div>

            <!--Factura-->
            <div class="card shadow-lg border-0">
                <!--Encabezado de la factura-->
                <div class="card-header bg-dark text-white p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-1 fw-bold">FACTURA</h3>
                            <p class="mb-0 opacity-75">Orden #<?= str_pad($orden['id_orden'], 6, '0', STR_PAD_LEFT) ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h4 class="mb-1 fw-bold">PLUTO SNEAKERS</h4>
                            <p class="mb-0 opacity-75 small">
                                www.plutosneakers.com<br>
                                contacto@plutosneakers.com<br>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!--Información del cliente-->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-uppercase mb-2">Facturar a:</h6>
                            <div class="border-start border-3 border-dark ps-3">
                                <p class="mb-1 fw-semibold"><?= esc($usuario['nombre']) ?> <?= esc($usuario['apellido']) ?></p>
                                <p class="mb-1 small text-muted"><?= esc($usuario['email']) ?></p>
                                <?php if (isset($usuario['telefono'])): ?>
                                <p class="mb-0 small text-muted"><?= esc($usuario['telefono']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-uppercase mb-2">Información de envío:</h6>
                            <div class="border-start border-3 border-secondary ps-3">
                                <?php if (isset($orden['direccion_envio'])): ?>
                                <p class="mb-1"><?= esc($orden['direccion_envio']) ?></p>
                                <p class="mb-1"><?= esc($orden['localidad_envio']) ?>, <?= esc($orden['provincia_envio']) ?></p>
                                <p class="mb-1"><?= esc($orden['codigo_postal_envio']) ?>, <?= esc($orden['pais_envio']) ?></p>
                                <?php endif; ?>
                                <p class="mb-0 small text-muted">
                                    <i class="bi bi-truck me-1"></i>Estado: Enviado
                                </p>
                            </div>
                        </div>
                    </div>

                    <!--Información de la orden-->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($orden['fecha_creacion'])) ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><strong>Estado:</strong> <span class="badge bg-success">Pagado</span></p>
                        </div>
                    </div>

                    <!--Tabla de productos-->
                    <?php if (empty($detalles)): ?>
                        <div class="text-center py-4">
                            <i class="bi bi-exclamation-triangle display-4 text-muted"></i>
                            <p class="text-muted mt-2">No se encontraron detalles para esta orden.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive mb-4">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Producto</th>
                                        <th scope="col" class="text-center">Talle</th>
                                        <th scope="col" class="text-center">Cantidad</th>
                                        <th scope="col" class="text-end">Precio Unit.</th>
                                        <th scope="col" class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $subtotal = 0;
                                    foreach ($detalles as $detalle): 
                                        $subtotal += $detalle['subtotal'];
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($detalle['url_imagen'])): ?>
                                                    <img src="<?= base_url('assets/img/uploads/' . $detalle['url_imagen']) ?>" 
                                                         alt="<?= esc($detalle['nombre']) ?>" 
                                                         class="me-3 rounded" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-0"><?= esc($detalle['nombre']) ?></h6>
                                                    <small class="text-muted">Código: #<?= isset($detalle['id_producto']) ? $detalle['id_producto'] : 'N/A' ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-light text-dark"><?= esc($detalle['talle']) ?></span>
                                        </td>
                                        <td class="text-center align-middle"><?= $detalle['cantidad'] ?></td>
                                        <td class="text-end align-middle">$<?= number_format($detalle['precio_unitario'], 2) ?></td>
                                        <td class="text-end align-middle fw-semibold">$<?= number_format($detalle['subtotal'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!--Totales-->
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td class="border-0 text-end">Subtotal:</td>
                                                <td class="border-0 text-end fw-semibold">$<?= number_format($subtotal, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="border-0 text-end">Costo de envío:</td>
                                                <td class="border-0 text-end fw-semibold">$<?= number_format($orden['importe_total'] - $subtotal, 2) ?></td>
                                            </tr>
                                            <tr class="table-dark">
                                                <td class="text-end fs-5 fw-bold">TOTAL:</td>
                                                <td class="text-end fs-5 fw-bold">$<?= number_format($orden['importe_total'], 2) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!--Información adicional-->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="fw-bold mb-2">Información importante:</h6>
                            <ul class="mb-0 small">
                                <li>Tu pedido ha sido procesado y enviado.</li>
                                <li>Puedes hacer seguimiento del envío con el código que te enviamos por email.</li>
                                <li>El tiempo estimado de entrega es de 3-7 días hábiles según tu ubicación.</li>
                                <li>Para cualquier consulta, contactanos a <strong>contacto@plutosneakers.com</strong></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <!--Pie de la factura-->
                <div class="card-footer bg-light text-center py-3">
                    <p class="mb-2 small text-muted">
                        Gracias por tu compra. Esta es tu factura digital.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-outline-dark btn-sm" onclick="window.print()">
                            <i class="bi bi-printer me-1"></i>Imprimir Factura
                        </button>
                        <?php
                        //Verificar si el usuario es administrador
                        $session = session();
                        $isAdmin = false;
                        
                        $userId = $session->get('id_usuario');

                        if ($userId) {
                            $userModel = new \App\Models\UsuarioModel();
                            $user = $userModel->find($userId);
                            if ($user && $user['id_rol'] === '1') {
                                $isAdmin = true;
                            }
                        }
                        
                         $backUrl = $isAdmin ? base_url('/admin/compras') : base_url('/perfil#mis-ordenes');
                        ?>
                        <a href="<?= $backUrl ?>" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i><?= $isAdmin ? 'Volver a compras' : 'Volver a mis órdenes' ?>
                        </a>
                        <a href="<?= base_url('/') ?>" class="btn btn-dark btn-sm">
                            <i class="bi bi-house me-1"></i>Volver al Inicio
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!--Estilos adicionales para impresión-->
<style>
@media print {
    .container {
        max-width: none !important;
        padding: 0 !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .btn, .alert {
        display: none !important;
    }
    
    .card-footer {
        display: none !important;
    }
    
    .card-header {
        background-color: #f8f9fa !important;
        color: #000 !important;
    }
    
    .badge {
        border: 1px solid #000;
    }
    
    .table-dark {
        background-color: #f8f9fa !important;
        color: #000 !important;
    }
    
    .table-dark th,
    .table-dark td {
        background-color: #f8f9fa !important;
        color: #000 !important;
        border-color: #dee2e6 !important;
    }
}
</style>