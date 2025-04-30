<DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  ontent="width-device-width, initial-scale=1.0">
    <title>Pluto Sneakers</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!--CSS CUSTOM -->
    <link href="<?= base_url('assets/css/mycustom.css'); ?>" rel="stylesheet">
</head>

<body>

<!-- Encabezado -->
<?= view('components/header') ?>

<!-- Contenido principal (sección que cambiará) --> 
<main>
<?= $content ?? ''?>
</main>

<!-- Pie de página -->
 <?= view('components/footer') ?>

 <!-- Scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>