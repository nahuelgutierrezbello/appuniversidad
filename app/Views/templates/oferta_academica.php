<?php
/*
 * Este archivo actúa como el contenedor principal para la sección de oferta académica.
 * Carga dinámicamente el contenido de las carreras, permitiendo cambiarlo con AJAX
 * sin recargar toda la página.
 */
?>
<section id="careers" class="py-5" style="background-color: #f0f2e6;">
    <div class="container">
        <h2 class="display-5 fw-bold text-center mb-5 text-primary">Nuestra Oferta Académica</h2>
        <div id="oferta-academica-content">
            <?php include('oferta_academica_default.php'); ?>
        </div>
    </div>
</section>