<!--REGISTRO-->
<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow-lg" style="max-width: 500px; width: 100%; border-radius: 1rem; background-color: #1a1a1a;">
    <h2 class="text-center text-white mb-4">Crear una cuenta</h2>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger text-center"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success text-center"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <!--Formulario-->
    <form method="post" action="<?= base_url('/registro'); ?>" onsubmit="return validarPassword()">

      <!--Nombres-->
      <div class="mb-3">
        <label for="nombre" class="form-label text-white">Nombres</label>
        <div class="input-group">
          <span class="input-group-text bg-dark border-dark text-white"><i class="bi bi-person"></i></span>
          <input type="text" class="form-control bg-dark border-dark text-white" id="nombre" name="nombre" required placeholder="Ej: Paula Andrea">
        </div>
      </div>

      <!--Apellidos-->
      <div class="mb-3">
        <label for="apellido" class="form-label text-white">Apellidos</label>
        <div class="input-group">
          <span class="input-group-text bg-dark border-dark text-white"><i class="bi bi-person-badge"></i></span>
          <input type="text" class="form-control bg-dark border-dark text-white" id="apellido" name="apellido" required placeholder="Ej: Gómez Ríos">
        </div>
      </div>

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

      <!--Repetir contraseña-->
      <div class="mb-4">
        <label for="password_confirm" class="form-label text-white">Repetir contraseña</label>
        <div class="input-group">
          <span class="input-group-text bg-dark border-dark text-white"><i class="bi bi-lock-fill"></i></span>
          <input type="password" class="form-control bg-dark border-dark text-white" id="password_confirm" name="password_confirm" required placeholder="••••••••">
          <button class="btn btn-outline-secondary bg-dark text-white border-dark" type="button" onclick="togglePassword('password_confirm', this)">
            <i class="bi bi-eye-slash"></i>
          </button>
        </div>
      </div>

      <!--Botón-->
      <div class="d-grid">
        <button type="submit" class="btn btn-danger">Registrarme</button>
      </div>
    </form>

    <!--Link a iniciar sesión-->
    <div class="mt-4 text-center">
      <span class="text-secondary">¿Ya tenés cuenta?</span><br>
      <a href="<?= base_url('/login'); ?>" class="text-decoration-none text-light fw-bold">Iniciar sesión</a>
    </div>
  </div>
</div>

<script>
  function validarPassword() {
    const p1 = document.getElementById('password').value;
    const p2 = document.getElementById('password_confirm').value;
    if (p1 !== p2) {
      alert('Las contraseñas no coinciden.');
      return false;
    }
    return true;
  }

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
