<div class="container mt-5">
    <h2 class="mb-4">Usuarios Administradores</h2>
    <table class="table table-bordered table-hover mb-0">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Nombre</th><th>Email</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= $admin['id_usuario'] ?></td>
                    <td><?= esc($admin['nombre'] . ' ' . $admin['apellido']) ?></td>
                    <td><?= esc($admin['email']) ?></td>
                    <td>
                        <?php if ($adminCount > 1): ?>
                            <a href="<?= base_url('admin/usuarios/desactivar/' . $admin['id_usuario']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que querés desactivar este admin?');">Desactivar</a>
                        <?php else: ?>
                            <span class="text-muted">No se puede desactivar (único admin)</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5 mb-4">Usuarios Habilitados</h2>
    <table class="table table-bordered table-hover mb-0">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Nombre</th><th>Email</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($habilitados as $user): ?>
                <tr>
                    <td><?= $user['id_usuario'] ?></td>
                    <td><?= esc($user['nombre'] . ' ' . $user['apellido']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/usuarios/desactivar/' . $user['id_usuario']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que querés desactivar este usuario?');">Desactivar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 class="mt-5 mb-4">Usuarios Deshabilitados</h2>
    <table class="table table-bordered table-hover mb-0">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Nombre</th><th>Email</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deshabilitados as $user): ?>
                <tr>
                    <td><?= $user['id_usuario'] ?></td>
                    <td><?= esc($user['nombre'] . ' ' . $user['apellido']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/usuarios/activar/' . $user['id_usuario']) ?>" class="btn btn-sm btn-success" onclick="return confirm('¿Querés activar este usuario?');">Activar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
