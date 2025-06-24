<DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  ontent="width-device-width, initial-scale=1.0">
    <title>Pluto Sneakers</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!--CSS CUSTOM-->
    <link href="<?= base_url('assets/css/mycustom.css'); ?>" rel="stylesheet">
</head>

<body>

<!--Encabezado-->
<?= view('components/header') ?>

<!--Contenido principal--> 
<main>
<?= $content ?? ''?>
</main>

<!--Pie de página-->
 <?= view('components/footer') ?>

<!--Bootstrap JS Bundle (con Popper incluido para collapse)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-sb2rPzJxv3bQRYzS3NdR5kXv1lqM8Wq0TxY3PGKrgzIk3hLEvMeMrCkNV7TgijPu" crossorigin="anonymous"></script>
</body>
</html>