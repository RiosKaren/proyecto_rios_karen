<div class="container py-5">
    <div class="row">
        <!--Imagen-->
        <div class="col-md-6 text-center">
            <?php 
            //Verificar si tiene stock
            $tieneStock = false;
            foreach ($producto['talles'] as $talle) {
                if ($talle['stock'] > 0) {
                    $tieneStock = true;
                    break;
                }
            }
            ?>
            
            <div class="position-relative">
                <?php if (!$tieneStock): ?>
                    <div class="position-absolute top-0 start-0 bg-danger text-white px-3 py-2 rounded-end" style="z-index: 10;">
                        Sin stock
                    </div>
                <?php endif; ?>
                
                <img src="<?= base_url('assets/img/uploads/' . $producto['url_imagen']) ?>" 
                     alt="<?= esc($producto['nombre']) ?>" 
                     class="img-fluid producto-imagen <?= !$tieneStock ? 'filter-grayscale opacity-75' : '' ?>"
                     onerror="this.onerror=null;this.src='<?= base_url('assets/img/default.png') ?>';">
            </div>

            <!--Descripción-->
            <div class="descripcion text-light mb-4 text-start">
                <?= esc($producto['descripcion']) ?>
            </div>
        </div>

        <!--Detalles-->
        <div class="col-md-6">
            <!--Título del producto-->
            <h2 class="fw-bold text-white mb-3 fs-4">
                <?= esc($producto['nombre']) ?>
            </h2>
            <!--Precio-->
            <h3 class="precio-principal mb-3">$<?= number_format($producto['precio'], 2) ?></h3>

            <!--Cuadro de cuotas-->
            <div class="cuotas-box w-50 mb-4">
                <div class="cuotas-principal">
                    6 CUOTAS SIN INTERÉS DE $<?= number_format($producto['precio'] / 6, 2) ?>
                </div>
                <div class="cuotas-secundario">
                    HASTA 4 CUOTAS SIN INTERÉS CON TARJETA DE DÉBITO
                </div>
                <!--Logos de tarjetas-->
                <div class="tarjetas-logos-nuevo mt-3">
                    <img src="<?= base_url('assets/img/visa.png') ?>" alt="Visa" class="tarjeta-logo">
                    <img src="<?= base_url('assets/img/mc.png') ?>" alt="Mastercard" class="tarjeta-logo">
                    <img src="<?= base_url('assets/img/amex.png') ?>" alt="American Express" class="tarjeta-logo">
                </div>
            </div>

            <!--Envío-->
            <div class="envio-info mb-0">
                <i class="fas fa-truck text-success me-0"></i>
                <span class="text-success fw-bold">Envío a todo el país</span>
            </div>

            <?php if (!$tieneStock): ?>
                <div class="alert alert-warning" role="alert">
                    <strong>¡Producto agotado!</strong> Este producto no tiene stock disponible en ningún talle.
                </div>
            <?php endif; ?>

            <!--ALERTAS-->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <!--Formulario de compra-->
            <?php if ($tieneStock): ?>
                <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mt-4">
                    <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

                    <!--Selector de talle-->
                    <div class="mb-2">
                        <label class="form-label text-white fw-bold">TALLE:</label>
                        <div class="talles-container">
                            <?php foreach ($producto['talles'] as $t): ?>
                                <?php if ($t['stock'] > 0): ?>
                                    <input type="radio"
                                        name="talle"
                                        value="<?= esc($t['talle']) ?>"
                                        id="talle_<?= esc($t['talle']) ?>"
                                        class="talle-radio">
                                    <label for="talle_<?= esc($t['talle']) ?>" class="talle-label">
                                        <?= esc($t['talle']) ?>
                                    </label>
                                <?php else: ?>
                                    <label class="talle-label talle-sin-stock">
                                        <?= esc($t['talle']) ?>
                                    </label>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- ALERTA DE TALLE -->
                        <div id="alerta-talle" class="alert alert-warning mt-2" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Por favor, selecciona un talle antes de agregar al carrito.
                        </div>

                        <div class="stock-info mt-2" id="stock-info" style="display: none;">
                            <span class="text-warning">
                                ¡Solo quedan <span id="stock-cantidad">2</span> en stock!
                            </span>
                        </div>
                    </div>

                    <!--Selector de cantidad y botón en la misma fila-->
                    <div class="mb-4">
                        <label for="cantidad" class="form-label text-white fw-bold">CANTIDAD</label>
                        
                        <!--Alerta para seleccionar talle-->
                        <div id="alerta-talle" class="alert alert-warning mb-2" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Por favor, selecciona un talle antes de cambiar la cantidad.
                        </div>
                        
                        <div class="d-flex gap-2">
                            <div class="cantidad-wrapper">
                                <button type="button" class="btn-cantidad" onclick="decrementar()">-</button>
                                <input type="number" name="cantidad" id="cantidad" class="form-control cantidad-input-inline" 
                                       min="1" max="10" value="1" required readonly>
                                <button type="button" class="btn-cantidad" onclick="incrementar()">+</button>
                            </div>
                            <button type="submit" class="btn btn-agregar-carrito flex-grow-1">
                                AGREGAR AL CARRITO
                            </button>
                        </div>
                    </div>
                </form>
            <?php else: ?>
                <!--Mostrar talles sin stock-->
                <div class="mt-4">
                    <h6 class="text-white">Talles disponibles:</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($producto['talles'] as $t): ?>
                            <span class="badge bg-secondary">
                                <?= esc($t['talle']) ?> (Sin stock)
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-secondary mt-3 w-100" disabled>
                        Producto agotado
                    </button>
                </div>
            <?php endif; ?>

            <a href="<?= base_url('/') ?>" class="btn btn-outline-light mt-0">Volver al inicio</a>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    body {
        background-color: #1a1a1a !important;
    }
    
    .container {
        background-color: #1a1a1a;
    }

    /* Imagen del producto */
    .producto-imagen {
        max-width: 350px;
        width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .filter-grayscale {
        filter: grayscale(100%);
    }

    /* Precio principal */
    .precio-principal {
        color: #28a745 !important;
        font-weight: bold;
        font-size: 1.3rem;
    }

    /* Cuadro de cuotas */
    .cuotas-box {
        background-color: #1a1a1a;
        border: 2px solid #28a745;
        color: #333;
        padding: 10px;
        border-radius: 8px;
        text-align: left;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 0.5rem !important; 
    }

    .cuotas-principal {
        color: #28a745;
        font-weight: bold;
        font-size: 0.7rem;
        margin-bottom: 8px;
    }

    .cuotas-secundario {
        color: #28a745;
        font-size: 0.6rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .tarjetas-logos-nuevo {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .tarjeta-logo {
        height: 30px;
        width: auto;
        object-fit: contain;
    }

    /* Información de envío */
    .envio-info {
        font-size: 0.9rem;
    }

    /* Descripción del producto */
    .descripcion {
        white-space: pre-line;
        color: #ccc !important;
        line-height: 1.5;
    }

    /* Selector de talles */
    .talles-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
    }

    .talle-radio {
        display: none;
    }

    .talle-label {
        display: inline-block;
        padding: 2px 5px;
        border: 2px solid #666;
        color: #ccc;
        background-color: transparent;
        cursor: pointer;
        border-radius: 5px;
        transition: all 0.3s ease;
        min-width: 50px;
        text-align: center;
    }

    .talle-label:hover {
        border-color: #dc3545;
        color: #dc3545;
    }

    .talle-radio:checked + .talle-label {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .talle-sin-stock {
        opacity: 0.5;
        cursor: not-allowed;
        text-decoration: line-through;
    }

    .stock-info {
        font-size: 0.9rem;
    }

    /* Selector de cantidad inline */
    .cantidad-wrapper {
        display: flex;
        align-items: center;
        background-color: #333;
        border: 1px solid #666;
        border-radius: 5px;
        overflow: hidden;
    }

    .btn-cantidad {
        background-color: transparent;
        border: none;
        color: #ccc;
        padding: 1px 15px;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-cantidad:hover {
        background-color: #555;
        color: white;
    }

    .cantidad-input-inline {
        background-color: transparent;
        border: none;
        color: white;
        text-align: center;
        width: 60px;
        padding: 10px 5px;
        font-size: 1rem;
    }

    .cantidad-input-inline:focus {
        background-color: transparent;
        border: none;
        color: white;
        box-shadow: none;
        outline: none;
    }

    /* Input de cantidad original */
    .cantidad-input {
        background-color: #333;
        border: 1px solid #666;
        color: white;
        padding: 10px;
        border-radius: 5px;
    }

    .cantidad-input:focus {
        background-color: #333;
        border-color: #28a745;
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
    }

    /* Botón agregar al carrito */
    .btn-agregar-carrito {
        background-color: #dc3545; 
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-agregar-carrito:hover {
        background-color: #a71d2a; 
        color: white;
    }

    /* Labels */
    .form-label {
        color: white !important;
        font-weight: bold;
        margin-bottom: 4px;
    }

    /* Botón volver */
    .btn-outline-light {
        border-color: #666;
        color: #ccc;
    }

    .btn-outline-light:hover {
        background-color: #666;
        border-color: #666;
        color: white;
    }

    /* Alertas */
    .alert {
        border-radius: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .precio-principal {
            font-size: 2rem;
        }
        
        .cuotas-box {
            padding: 12px;
        }
        
        .cuotas-text {
            font-size: 1rem;
        }
        
        .talles-container {
            justify-content: center;
        }
    }
</style>

<script>
//Script para controlar la cantidad y mostrar el stock dinámicamente
document.addEventListener('DOMContentLoaded', function() {
    const talleRadios = document.querySelectorAll('.talle-radio');
    const stockCantidad = document.getElementById('stock-cantidad');
    const cantidadInput = document.querySelector('#cantidad');
    const alertaTalle = document.getElementById('alerta-talle');
    let talleSeleccionado = false;
    
    //Datos de stock por talle
    const stockPorTalle = {
        <?php foreach ($producto['talles'] as $t): ?>
            '<?= esc($t["talle"]) ?>': <?= $t['stock'] ?>,
        <?php endforeach; ?>
    };
    
    talleRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                talleSeleccionado = true;
                const stock = stockPorTalle[this.value];
                
                //Ocultar alerta si estaba visible
                if (alertaTalle) {
                    alertaTalle.style.display = 'none';
                }
                
                //Mostrar información de stock
                const stockInfo = document.getElementById('stock-info');
                if (stockInfo && stockCantidad) {
                    stockCantidad.textContent = stock;
                    stockInfo.style.display = 'block';
                }
                
                //Actualizar el max del input de cantidad
                if (cantidadInput) {
                    cantidadInput.max = stock;
                    if (parseInt(cantidadInput.value) > stock) {
                        cantidadInput.value = stock;
                    }
                }
            }
        });
    });
    
    //Validar formulario antes de enviar
    const form = document.querySelector('form[action*="carrito/agregar"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!talleSeleccionado) {
                e.preventDefault();
                mostrarAlertaTalle();
            }
        });
    }
});

//Función para mostrar alerta de talle
function mostrarAlertaTalle() {
    const alertaTalle = document.getElementById('alerta-talle');
    if (alertaTalle) {
        alertaTalle.style.display = 'block';
        //Auto-ocultar después de 3 segundos
        setTimeout(() => {
            alertaTalle.style.display = 'none';
        }, 3000);
    }
}

//Función para verificar si hay talle seleccionado
function verificarTalleSeleccionado() {
    const talleSeleccionado = document.querySelector('.talle-radio:checked');
    return talleSeleccionado !== null;
}

//Funciones para incrementar/decrementar cantidad
function incrementar() {
    if (!verificarTalleSeleccionado()) {
        mostrarAlertaTalle();
        return;
    }
    
    const input = document.getElementById('cantidad');
    const max = parseInt(input.max) || 10;
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decrementar() {
    if (!verificarTalleSeleccionado()) {
        mostrarAlertaTalle();
        return;
    }
    
    const input = document.getElementById('cantidad');
    const min = parseInt(input.min) || 1;
    if (parseInt(input.value) > min) {
        input.value = parseInt(input.value) - 1;
    }
}
</script>