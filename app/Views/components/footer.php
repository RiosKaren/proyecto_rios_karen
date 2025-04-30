<!-- Footer -->
<footer class="footer-section  text-white text-center pt-5">
  <!-- Banner superior -->
  <div class="footer-banner">
    <div class="banner-content">
      <h2>¿Tienes preguntas sobre nuestras zapatillas?</h2>
      <p><a href="<?php echo base_url(); ?>contacto">Contáctanos</a></p>
    </div>
  </div>

  <div class="container p-3">
    <!-- Primera sección -->
    <div class="row text-center mb-4">
      <div class="col-12 col-md-4 mb-3 mb-md-0">
        <img src="assets/img/envio.png" class="icon" alt="Envíos Gratis">
        <p>ENVIOS GRATIS A TODO EL PAIS</p>
        <p>En compras superiores a $90000</p>
      </div>
      <div class="col-12 col-md-4 mb-3 mb-md-0">
        <img src="assets/img/escudo.png" class="icon" alt="Compra Segura">
        <p>COMPRA SEGURA</p>
        <p>Tus datos totalmente protegidos</p>
      </div>
      <div class="col-12 col-md-4">
        <img src="assets/img/whatsapp.png" class="icon" alt="Asesorate">
        <p>ASESORATE!</p>
        <p>Comunicate con nosotros</p>
      </div>
    </div>

    <!-- Newsletter y redes -->
    <div class="row align-items-center">
    <!-- Botón de Instagram -->
      <div class="col-auto">
        <a href="https://www.instagram.com/" target="_blank" class="social-icon">
        <img src="assets/img/instagram.png" class="icon" alt="Instagram">
        </a>
      </div>
      <!-- Botón de WhatsApp -->
      <div class="col-auto">
        <a href="https://www.whatsapp.com" target="_blank" class="social-icon">
          <img src="assets/img/icons8-whatsapp-48.png" class="icon" alt="WhatsApp">
        </a>
      </div>
    </div>

      <!-- Newsletter -->
      <div class="col-12 col-md-9">
        <div class="d-flex justify-content-end"> 
          <div style="max-width: 400px; width: 100%;">
           <h5 class="text-start">Suscríbete a nuestro Newsletter</h5>
           <form class="w-100" style="max-width: 400px;">
             <div class="input-group mb-2">
              <!-- Campo del Newsletter -->
               <input type="email" class="form-control" placeholder="Tu Email" required>
               <!-- Boton del Newsletter -->
               <button type="submit" class="btn-subscribe">Suscribirse</button>
             </div>
             <!-- Tarjetas aceptadas-->
             <div class="d-flex justify-content-start">
               <img src="assets/img/visa.png" class="payment-icon me-2" alt="Visa">
               <img src="assets/img/mc.png" class="payment-icon me-2" alt="Mastercard">
               <img src="assets/img/amex.png" class="payment-icon" alt="Amex">
             </div>
           </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Copyright -->
    <p>&copy; <?= date('Y') ?> Pluto Sneakers. Todos los derechos reservados.</p>
  </div>
</footer>