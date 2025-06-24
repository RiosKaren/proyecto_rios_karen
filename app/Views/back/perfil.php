<div class="container py-5">
    <div class="row">
        <!--Sidebar de navegación-->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Mi Cuenta</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#datos-personales" class="list-group-item list-group-item-action active" data-bs-toggle="pill">
                        <i class="bi bi-person me-2"></i>Datos Personales
                    </a>
                    <a href="#cambiar-password" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                        <i class="bi bi-lock me-2"></i>Cambiar Contraseña
                    </a>
                    
                    <?php 
                    //Solo mostrar "Mis Órdenes" y "Mis Consultas" si NO es admin
                    //Asumiendo que el rol admin tiene id_rol = 1 o descripcion = 'admin'
                    if ($usuario['id_rol'] != 1): // Cambia el 1 por el ID que corresponda al rol admin
                    ?>
                    <a href="#mis-ordenes" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                        <i class="bi bi-bag me-2"></i>Mis Órdenes
                    </a>
                    <a href="#mis-consultas" class="list-group-item list-group-item-action" data-bs-toggle="pill">
                        <i class="bi bi-chat-dots me-2"></i>Mis Consultas
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!--Contenido principal-->
        <div class="col-lg-9">
            <div class="tab-content">
                <!--Datos Personales-->
                <div class="tab-pane fade show active" id="datos-personales">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Datos Personales</h5>
                        </div>
                        <div class="card-body">
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                            <?php endif; ?>

                            <form action="<?= base_url('/perfil/actualizar-datos') ?>" method="post">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" value="<?= esc($usuario['nombre']) ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Apellido</label>
                                        <input type="text" class="form-control" name="apellido" value="<?= esc($usuario['apellido']) ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= esc($usuario['email']) ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-2"></i>Actualizar Datos
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!--Cambiar Contraseña-->
                <div class="tab-pane fade" id="cambiar-password">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Cambiar Contraseña</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('/perfil/cambiar-password') ?>" method="post">
                                <div class="mb-3">
                                    <label class="form-label">Contraseña Actual</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-dark text-white"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="password_actual" name="password_actual" required placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_actual', this)">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-dark text-white"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="password_nueva" name="password_nueva" required minlength="6" placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_nueva', this)">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirmar Nueva Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-dark text-white"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="password_confirmar" name="password_confirmar" required minlength="6" placeholder="••••••••">
                                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmar', this)">
                                            <i class="bi bi-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-shield-lock me-2"></i>Cambiar Contraseña
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php 
                //Solo mostrar las secciones de órdenes y consultas si NO es admin
                if ($usuario['id_rol'] != 1): 
                ?>
                <!--Mis Órdenes-->
                <div class="tab-pane fade" id="mis-ordenes">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Mis Órdenes</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($ordenes)): ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-bag-x display-4 text-muted"></i>
                                    <p class="text-muted mt-2">No tienes órdenes realizadas</p>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Orden #</th>
                                                <th>Fecha</th>
                                                <th>Total</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ordenes as $orden): ?>
                                            <tr>
                                                <td>#<?= str_pad($orden['id_orden'], 6, '0', STR_PAD_LEFT) ?></td>
                                                <td><?= date('d/m/Y', strtotime($orden['fecha_creacion'])) ?></td>
                                                <td>$<?= number_format($orden['importe_total'], 2) ?></td>
                                                <td>
                                                    <span class="badge bg-success">Pagado</span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('/perfil/orden/' . $orden['id_orden']) ?>"
                                                        class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-eye me-1"></i> Ver Detalles
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!--Mis Consultas-->
                <div class="tab-pane fade" id="mis-consultas">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Mis Consultas</h5>
                        </div>
                        <div class="card-body">
                            <?php if (empty($consultas)): ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-chat-dots-fill display-4 text-muted"></i>
                                    <p class="text-muted mt-2">No tienes consultas realizadas</p>
                                    <a href="<?= base_url('/contacto') ?>" class="btn btn-primary">Realizar Consulta</a>
                                </div>
                            <?php else: ?>
                                <?php foreach ($consultas as $consulta): ?>
                                <div class="card mb-3">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Consulta del <?= date('d/m/Y H:i', strtotime($consulta['hora_creada'])) ?></span>
                                        <span class="badge <?= $consulta['estado'] == 'respondido' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= ucfirst($consulta['estado']) ?>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <h6>Tu consulta:</h6>
                                        <p class="text-muted"><?= esc($consulta['mensaje']) ?></p>
                                        
                                        <?php if ($consulta['respuesta']): ?>
                                            <hr>
                                            <h6>Respuesta:</h6>
                                            <div class="alert alert-info">
                                                <?= esc($consulta['respuesta']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>

.table-active .btn-outline-danger {
  color: #fff;
  background-color: #dc3545;
  border-color: #dc3545;
}

.list-group-item.active {
    background-color: #dc3545 !important; 
    border-color: #dc3545 !important;
    color: white !important;
}


.btn-primary {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}

.btn-primary:hover {
    background-color: #c82333 !important;
    border-color: #bd2130 !important;
}

.btn-primary:focus, .btn-primary.focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5) !important;
}

.text-primary {
    color: #dc3545 !important;
}
</style>

<script>

//Activar tab según hash en URL
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash) {
        const tab = document.querySelector(`[href="${hash}"]`);
        if (tab) {
            tab.click();
        }
    }
});

//Función para mostrar/ocultar contraseña
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
}
</script>