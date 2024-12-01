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
    <!-- Iconos FontAwesome -->
    <script src="https://kit.fontawesome.com/c570243db9.js" crossorigin="anonymous"></script>
    <!-- Archivo estilos personalizados -->
    <link rel="stylesheet" type="text/css" href="/../css/carrito.css">
    <link rel="stylesheet" href="/../css/menuAdmin.css">
    <link rel="stylesheet" href="/../css/estilosTabla.css">
    <link rel="stylesheet" type="text/css" href="/../css/estiloRegistro.css">
    <!-- Icono para la pestaña de la página en el navegador -->
    <link rel="shortcut icon" href="/../recursos/icon/favicon.ico" type="image/x-icon">
    <title>Administración | Casa del Sol</title>
</head>

<body>
    <!-- Header -->
    <header class="fondo-negro text-white py-0">
        <div class="container d-flex justify-content-between py-2">
        <div class="d-flex align-items-center">
            <img src="/../recursos/imagenes/logo.png" alt="..." width="150" height="auto">
        </div>

        <div class="d-flex align-items-center">
            <!-- <?php
                if (isset($_SESSION['usuario'])) {
                    print '<p>Bienvenido : ' . htmlspecialchars($_SESSION['usuario']) . '</p>';
                }
                ?> -->
            <!-- Botón inicio de sesión / registro -->
            <div class="btn-group" role="group">
            <button type="button" class="btn boton-personalizado dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user me-3"></i>
            </button>

            <ul class="dropdown-menu">
                <?php if (isset($_SESSION['usuario'])) {
                echo '<li><a class="dropdown-item" href="../../usuario/publico/cerrarSesion.php">Cerrar Sesion</a></li>';
                echo '<li><a class="dropdown-item" href="../../usuario/publico/editarDatosAdmin.php">Administrar perfil</a></li>';
                }
                ?>
            </ul>
            </div>
        </div>
        </div>
    </header>
</body>
