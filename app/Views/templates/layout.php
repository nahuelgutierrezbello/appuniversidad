<?php
/*
 * Esta es la plantilla principal (layout) para el SITIO PÚBLICO.
 * Define la estructura HTML común que envuelve el contenido de las páginas públicas.
 */
?>

<?= $this->include('templates/head') ?>

<body>

    <?= $this->include('templates/Navbar') ?>

    <?= $this->include('templates/header_content') ?>

    <main>
        <?php if (isset($page_content)) : ?>
            <?= $page_content; // Muestra el contenido pasado desde el controlador Home ?>
        <?php else : ?>
            <?= $this->renderSection('content') // Mantiene la compatibilidad para otras vistas que usen extend() ?>
        <?php endif; ?>
    </main>

    <?= $this->include('templates/footer') ?>

</body>