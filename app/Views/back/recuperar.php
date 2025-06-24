<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%; border-radius: 1rem; background-color: #1a1a1a;">
    <h2 class="text-center text-white mb-4">Recuperar contraseña</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger text-center">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success text-center">
        <?= session()->getFlashdata('success') ?>
      </div>
      <div class="d-grid mt-3">
        <a href="<?= base_url('/login') ?>" class="btn btn-danger">
          Iniciar sesión
        </a>
      </div>
    <?php else: ?>
      <form method="post" action="<?= base_url('/recuperar') ?>">
        <div class="mb-3">
          <label for="email" class="form-label text-white">Correo electrónico</label>
          <div class="input-group">
            <span class="input-group-text bg-dark border-dark text-white">
              <i class="bi bi-envelope"></i>
            </span>
            <input
              type="email"
              class="form-control bg-dark border-dark text-white"
              id="email"
              name="email"
              required
              placeholder="tucorreo@ejemplo.com"
            >
          </div>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-danger">
            Enviar enlace de recuperación
          </button>
        </div>

        <div class="text-center mt-3">
          <a href="<?= base_url('/login') ?>" class="text-white">
            Iniciar sesión
          </a>
        </div>
      </form>
    <?php endif; ?>

  </div>
</div>
