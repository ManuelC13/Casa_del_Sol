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
    <link rel="stylesheet" type="text/css" href="../css/carrito.css">
    <!-- Icono para la pestaña de la página en el navegador -->
    <link rel="shortcut icon" href="../recursos/icon/favicon.ico" type="image/x-icon">
    <title>Carrito de Compras | Casa del Sol</title>
</head>

<body>
    <!-- Header -->
    <header class="fondo-negro text-white py-0">
        <div class="container d-flex justify-content-between py-2">
            <div class="d-flex align-items-center">
                <img src="../recursos/imagenes/logo.png" alt="..." width="150" height="auto">
            </div>

            <div class="d-flex align-items-center">
                <!-- <?php
                    if (isset($_SESSION['usuario'])) {
                        print '<p>Bienvenido : ' . htmlspecialchars($_SESSION['usuario']) . '</p>';
                    }
                    ?> -->
                <!-- Icono carrito de compras -->
                <a href="#" class="btn btn-outline-primary boton-personalizado mx-2">
                    <i class="bi bi-cart-fill"></i>
                    <span class="badge bg-secondary"><?php if (isset($_SESSION['usuario'])) print contarNumeroDeProductos(); ?></span>
                </a>
                <!-- Botón inicio de sesión / registro -->
                <div class="btn-group" role="group">
                    <button type="button" class="btn boton-personalizado dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user me-3"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <?php if (isset($_SESSION['usuario'])) {
                        echo '<li><a class="dropdown-item" href="../usuario/publico/cerrarSesion.php">Cerrar Sesion</a></li>';
                        } else {
                        echo '<li><a class="dropdown-item" href="../usuario/publico/inicioDeSesion.php">Iniciar Sesión</a></li>
                                <li><a class="dropdown-item" href="../usuario/publico/registroDeUsuario.html">Registrarme</a></li>';
                        } ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Menú de navegación -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3" id="menu-navegacion">
            <div class="container">
                <!-- Menú de hamburguesa para pantallas pequeñas -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars text-white"></i>
                </button>

                <!-- Enlaces del navbar -->
                <div class="collapse navbar-collapse menu" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../index.php">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../index#seccionBeneficios">Beneficios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../index#seccionProductos">Productos</a>
                        </li>
                        <li class="nav-item me-3">
                            <a class="nav-link text-white" href="../index#seccionNosotros">Nosotros</a>
                        </li>
                    </ul>
                    <!-- Barra de búsqueda -->
                    <form class="d-flex mt-2" method="GET" action="../buscar.php">
                        <input type="search" name="query" class="form-control me-2" placeholder="Buscar productos..." required>
                        <button type="submit" class="btn btn-outline-light"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>