<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!--Mensaje de confirmación-->
            <div class="alert alert-success text-center mb-4">
                <h4 class="mb-2">¡Compra realizada con éxito!</h4>
                <p class="mb-0">Tu pedido ha sido procesado correctamente. Recibirás un email de confirmación en breve.</p>
            </div>

            <!--Factura-->
            <div class="card shadow-lg border-0">
                <!--Encabezado de la factura-->
                <div class="card-header bg-dark text-white p-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="mb-1 fw-bold">FACTURA</h3>
                            <p class="mb-0 opacity-75">Orden #<?= str_pad($data['id_factura'], 6, '0', STR_PAD_LEFT) ?></p>
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
                    <!--Información del cliente y envío-->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-uppercase mb-2">Facturar a:</h6>
                            <div class="border-start border-3 border-dark ps-3">
                                <p class="mb-1 fw-semibold"><?= esc($data['nombre']) ?> <?= esc($data['apellido']) ?></p>
                                <p class="mb-1 small text-muted"><?= esc($data['email']) ?></p>
                                <p class="mb-0 small text-muted"><?= esc($data['telefono']) ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-uppercase mb-2">Enviar a:</h6>
                            <div class="border-start border-3 border-secondary ps-3">
                                <p class="mb-1"><?= esc($data['direccion']) ?></p>
                                <p class="mb-1"><?= esc($data['localidad']) ?>, <?= esc($data['provincia']) ?></p>
                                <p class="mb-1"><?= esc($data['codigo_postal']) ?>, <?= esc($data['pais']) ?></p>
                                <p class="mb-0 small text-muted">Método: Andreani Estándar</p>
                            </div>
                        </div>
                    </div>

                    <!--Información de la orden-->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Fecha:</strong> <?= $data['fecha'] ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="mb-1"><strong>Estado:</strong> <span class="badge bg-success">Confirmado</span></p>
                        </div>
                    </div>

                    <!--Tabla de productos-->
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
                                <?php foreach ($data['carrito'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('assets/img/uploads/' . $item['imagen']) ?>" 
                                                 alt="<?= esc($item['nombre']) ?>" 
                                                 class="me-3 rounded" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0"><?= esc($item['nombre']) ?></h6>
                                                <small class="text-muted">Código: #<?= $item['id_producto'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-light text-dark"><?= esc($item['talle']) ?></span>
                                    </td>
                                    <td class="text-center align-middle"><?= $item['cantidad'] ?></td>
                                    <td class="text-end align-middle">$<?= number_format($item['precio'], 2) ?></td>
                                    <td class="text-end align-middle fw-semibold">$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
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
                                            <td class="border-0 text-end fw-semibold">$<?= number_format($data['subtotal'], 2) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="border-0 text-end">Costo de envío:</td>
                                            <td class="border-0 text-end fw-semibold">$<?= number_format($data['costo_envio'], 2) ?></td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td class="text-end fs-5 fw-bold">TOTAL:</td>
                                            <td class="text-end fs-5 fw-bold">$<?= number_format($data['total'], 2) ?></td>
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
                            <li>Tu pedido será procesado en 1-2 días hábiles.</li>
                            <li>Recibirás un código de seguimiento por email cuando se despache tu pedido.</li>
                            <li>El tiempo estimado de entrega es de 3-7 días hábiles según tu ubicación.</li>
                            <li>Para cualquier consulta, contactanos a <strong>contacto@plutosneakers.com</strong></li>
                        </ul>
                    </div>
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
                        <a href="<?= base_url('/') ?>" class="btn btn-dark btn-sm">
                            <i class="bi bi-house me-1"></i>Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Estilos para impresión-->
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
}
</style>