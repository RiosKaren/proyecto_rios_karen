<!--LOGIN-->
<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%; border-radius: 1rem; background-color: #1a1a1a;">
    <h2 class="text-center text-white mb-4">Iniciar sesión</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!--Formulario-->
    <form method="post" action="<?= base_url('/login'); ?>">
      <!--Email-->
      <div class="mb-3">
        <label for="email" class="form-label text-white">Correo electrónico</label>
        <div class="input-group">
          <span class="input-group-text bg-dark border-dark text-white"><i class="bi bi-envelope"></i></span>
          <input type="email" class="form-control bg-dark border-dark text-white" id="email" name="email" required placeholder="tucorreo@ejemplo.com">
        </div>
      </div>

      <!--Contraseña-->
      <div class="mb-3">
        <label for="password" class="form-label text-white">Contraseña</label>
        <div class="input-group">
          <span class="input-group-text bg-dark border-dark text-white"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control bg-dark border-dark text-white" id="password" name="password" required placeholder="••••••••">
          <button class="btn btn-outline-secondary bg-dark text-white border-dark" type="button" onclick="togglePassword('password', this)">
            <i class="bi bi-eye-slash"></i>
          </button>
        </div>
      </div>

      <!--Botón-->
      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-danger">Ingresar</button>
      </div>
    </form>

    <!--Links-->
    <div class="mt-4 text-center">
      <a href="<?= base_url('/recuperar'); ?>" class="text-decoration-none text-secondary">¿Olvidaste tu contraseña?</a><br>
      <a href="<?= base_url('/registro'); ?>" class="text-decoration-none text-light fw-bold">Crear una cuenta</a>
    </div>
  </div>
</div>

<script>
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
