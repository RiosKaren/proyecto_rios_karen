<?php?>

<style>
    td.wrap-text {
        white-space: normal !important;
        word-break: break-word;
    }
</style>

<div class="container mt-5">
    <h2 class="mb-4">Solicitudes de Contacto</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success text-center">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!--Tabla de solicitudes sin contestar-->
    <h4 class="mt-4">Solicitudes sin contestar</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white align-middle text-wrap">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Mensaje</th>
                    <th>Respuesta</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultas as $consulta): ?>
                    <?php if ($consulta['estado'] != 'respondido' && $consulta['estado'] != 'cerrado'): ?>
                        <tr>
                            <td><?= $consulta['id_consulta'] ?></td>
                            <td><?= esc($consulta['nombre'] ?? 'Usuario desconocido') ?></td>
                            <td><?= esc($consulta['email'] ?? 'Sin email') ?></td>
                            <td class="wrap-text"><?= esc($consulta['mensaje']) ?></td>
                            <td class="wrap-text">
                                <form action="<?= base_url('admin/solicitudes/responder/' . $consulta['id_consulta']) ?>" method="post">
                                    <textarea name="respuesta" class="form-control mb-2" rows="3"><?= esc($consulta['respuesta']) ?></textarea>
                                    <button class="btn btn-primary btn-sm" type="submit">Enviar</button>
                                </form>
                            </td>
                            <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                            <td><?= date('d/m/Y H:i', strtotime($consulta['hora_creada'])) ?></td>
                            <td>
                                <?php if ($consulta['id_usuario']): ?>
                                    <span class="badge bg-success">Registrado</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Invitado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!--Tabla de solicitudes resueltas-->
    <h4 class="mt-5">Solicitudes resueltas</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-dark text-white align-middle text-wrap mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Mensaje</th>
                    <th>Respuesta</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($consultas as $consulta): ?>
                    <?php if ($consulta['estado'] == 'respondido' || $consulta['estado'] == 'cerrado'): ?>
                        <tr>
                            <td><?= $consulta['id_consulta'] ?></td>
                            <td><?= esc($consulta['nombre'] ?? 'Usuario desconocido') ?></td>
                            <td><?= esc($consulta['email'] ?? 'Sin email') ?></td>
                            <td class="wrap-text"><?= esc($consulta['mensaje']) ?></td>
                            <td class="wrap-text"><?= esc($consulta['respuesta']) ?></td>
                            <td>
                                <span class="badge <?= $consulta['estado'] == 'cerrado' ? 'bg-secondary' : 'bg-success' ?>">
                                    <?= ucfirst($consulta['estado']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($consulta['hora_creada'])) ?></td>
                            <td>
                                <?php if ($consulta['id_usuario']): ?>
                                    <span class="badge bg-success">Registrado</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Invitado</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="<?= base_url('admin/solicitudes/cambiar-estado/' . $consulta['id_consulta']) ?>" method="post">
                                    <input type="hidden" name="estado" value="pendiente">
                                    <button class="btn btn-outline-warning btn-sm">Reabrir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
