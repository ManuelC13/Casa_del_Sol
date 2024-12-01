<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!--Iconos FontAwesome-->
    <script src="https://kit.fontawesome.com/c570243db9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../css/index.css">
    <title>Tienda en Línea | Casa del Sol</title>
</head>

<body>
    <div class="container text-center py-5 min-vh-100">
        <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <h1>¡Gracias por tu compra!</h1>
            <p>Tu pedido ha sido procesado exitosamente.</p>
            <a href="../index.php" class="btn boton-personalizado">Volver al inicio</a>
        <?php else: ?>
            <h1>Ocurrió un problema</h1>
            <p>No pudimos procesar tu compra. Por favor, inténtalo de nuevo.</p>
            <a href="../index.php" class="btn boton-personalizado">Volver al carrito</a>
        <?php endif; ?>
    </div>
    <?php include '../componentes/footer.php'; ?>
</body>
</html>
