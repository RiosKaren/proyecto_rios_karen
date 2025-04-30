<?php // contacto.php ?>

<main class="container py-5 fade-in bg-dark text-white">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <h1 class="text-center mb-4 fw-bold text-uppercase text-danger">Contacto</h1>
      
      <p class="text-center mb-5">
        ¿Tenés dudas? ¿Querés saber el estado de tu pedido? ¿Queres ver los nuevos lanzamientos?<br>
        Acá te dejamos todos los canales para que te contactes con nosotros 👇
      </p>

      <!-- Información de contacto -->
      <div class="mb-5">
        <ul class="list-unstyled text-center">
          <li><strong>Instagram:</strong> @plutosneakers</li>
          <li><strong>Email:</strong> contacto@plutosneakers.com</li>
          <li><strong>Horario de atención:</strong> Lunes a viernes de 10 a 18 h.</li>
        </ul>
      </div>

      <!-- Formulario de contacto -->
      <form>
        <div class="row g-3">
          <div class="col-lg-6">
            <input type="text" class="form-control" placeholder="Nombre" required>
          </div>
          <div class="col-lg-6">
            <input type="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="col-12">
            <select class="form-select" required>
              <option selected disabled>Asunto</option>
              <option>Seguimiento de pedido</option>
              <option>Cambios o devoluciones</option>
              <option>Consultas generales</option>
            </select>
          </div>
          <div class="col-12">
            <textarea class="form-control" rows="5" placeholder="Mensaje" required></textarea>
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-danger mt-3">Enviar mensaje</button>
          </div>
        </div>
        <p class="text-center mt-2 small">
          🔒 Respondemos en menos de 24 hs. Tus datos están protegidos. 🔒
        </p>
      </form>

      <!-- Mapa de ubicación -->
      <div class="mt-5">
       <div style="position: relative; width: 100%; padding-bottom: 30%;">
          <iframe 
             src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3540.0900624775913!2d-58.83478922513155!3d-27.466455376321473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca6d24ec0c9%3A0xb92ce3fedb0d7729!2sFacultad%20de%20Ciencias%20Exactas%20y%20Naturales%20y%20Agrimensura!5e0!3m2!1sen!2sar!4v1745889162738!5m2!1sen!2sar" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
           </iframe>
       </div>
        <p class="text-center mt-2">Corrientes, Corrientes, Argentina. Atención online.</p>
      </div>

      <!-- Preguntas frecuentes en formato acordeón -->

      <!-- Cambio -->
      <div class="mt-5">
        <h2 class="text-danger text-center mb-4 fw-bold">Preguntas Frecuentes</h2>
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item bg-dark text-white">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                ¿Cómo hago un cambio?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Para hacer un cambio, escribinos por Instagram o email indicando tu número de pedido y el motivo. Te respondemos con los pasos a seguir.
              </div>
            </div>
          </div>
           <!-- Pedido Confirmado -->
          <div class="accordion-item bg-dark text-white">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                ¿Cómo sé si mi pedido fue confirmado?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Al realizar tu compra, te enviamos un mail de confirmación con los detalles del pedido. Si no lo recibiste, revisá la carpeta de spam o escribinos.
              </div>
            </div>
          </div>
           <!-- Guia de Talles -->
          <div class="accordion-item bg-dark text-white">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                ¿Qué talles manejan?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-center">
                <p>Contamos con una guía de talles actualizada para ayudarte a elegir tu número perfecto.</p>
                <img src="<?= base_url('assets/img/unisex.jpg') ?>" class="img-fluid rounded" alt="Guía de talles">
              </div>
            </div>
          </div>
           <!-- Tiempo estimado de pedido -->
          <div class="accordion-item bg-dark text-white">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                ¿Cuánto tarda en llegar mi pedido?
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Los tiempos de entrega varían según tu localidad. En promedio, los envíos demoran entre 2 y 7 días hábiles desde la confirmación del pago.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>