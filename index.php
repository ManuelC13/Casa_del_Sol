<?php
session_start();
require 'carrito/funcionesCarrito.php';

function mostrarInfoProductos(){

    global $conexion; // Accede a la variable $conexion declarada fuera de la función
    $sql = "SELECT producto.Sku, 
                producto.Nombre AS NombreProducto, 
                categoria.Nombre AS NombreCategoria, 
                producto.Precio, producto.Imagen,
                producto.Stock, 
                producto.Descripcion
            FROM producto 
            INNER JOIN categoria ON producto.IdCategoria = categoria.Id;";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $productos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = $fila;
        }
        return $productos; //Retorna el array de resultados
    } else {
        return []; //Retorna un array vacío si no hay resultados
    }
}

?>

<?php include 'componentes/header.php'; ?>

<!-- Carrusel -->
<section>
    <div id="carrusel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carrusel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active contenedorImagenes">
                <img src="recursos/imagenes/trompo.jpg" class="d-block w-100 imagenCarrusel" alt="...">
                <div class="carousel-caption top-0 mt-5 d-md-block mb-5 style=bottom: 60%;">
                    <h1 class="display-1 fw-bolder text-capitalize mt-5">Casa del sol</h1>
                    <p class="fs-5 texto">Aquí encontrarás toda clase de artículos artesanales</p>
                    <a href="#seccionProductos" class="btn boton-personalizado px-4 py-1 fs-5 mt-5">Comprar ahora</a>
                </div>
            </div>
            <div class="carousel-item contenedorImagenes">
                <img src="recursos/imagenes/cestas.jpg" class="d-block w-100 imagenCarrusel" alt="...">
                <div class="carousel-caption top-0 mt-5 d-md-block mb-5 style=bottom: 60%;">
                    <h1 class="display-1 fw-bolder mt-5">Descubre el arte detrás de cada pieza</h1>
                </div>
            </div>
            <div class="carousel-item contenedorImagenes">
                <img src="recursos/imagenes/barro.jpg" class="d-block w-100 imagenCarrusel" alt="...">
                <div class="carousel-caption top-0 mt-5 d-md-block mb-5 style=bottom: 60%;">
                    <h1 class="display-1 fw-bolder mt-5">Calidad artesanal que se siente y se ve</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tarjetas Beneficios -->
<main>
    <section id="seccionBeneficios" tabindex="-1" class="container py-3">
        <h2 class="heading-1 text-center mb-4">Beneficios que Ofrecemos</h2>
        <div class="row g-4">
            <!-- Tarjeta 1 -->
            <div class="col-6 col-md-3">
                <div class="card tarjeta-beneficios h-100 text-center">
                    <i class="fa-solid fa-star"></i>
                    <div class="contenido-informacion">
                        <span class="card-title">Artículos únicos</span>
                        <p class="card-text">Hechos 100% a mano por artistas yucatecos</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 2 -->
            <div class="col-6 col-md-3">
                <div class="card tarjeta-beneficios h-100 text-center">
                    <i class="fa-solid fa-handshake"></i>
                    <div class="contenido-informacion">
                        <span>Trato directo con vendedores</span>
                        <p class="card-text">Para acordar el medio de pago y envío</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3 -->
            <div class="col-6 col-md-3">
                <div class="card tarjeta-beneficios h-100 text-center">
                    <i class="fa-solid fa-dollar-sign"></i>
                    <div class="contenido-informacion">
                        <span>Precios accesibles</span>
                        <p class="card-text">Productos de calidad a los mejores precios</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 4 -->
            <div class="col-6 col-md-3">
                <div class="card tarjeta-beneficios h-100 text-center">
                    <i class="fa-solid fa-place-of-worship"></i>
                    <div class="contenido-informacion">
                        <span>Apoyo a la conservación cultural</span>
                        <p class="card-text">En cada compra que haces contribuyes a mantenerla viva</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tarjetas de productos -->
    <section id="seccionProductos" tabindex="-1">
        <div class="container mt-1 pt-5" id="main">
            <h2 class="text-center mb-4">Nuestros Productos</h2>

            <!-- Formulario para seleccionar categoría -->
            <form method="GET" class="mb-4 text-center">
                <label for="categoria" class="form-label">Elige una categoría:</label>
                <select name="categoria" id="categoria" class="form-select w-auto d-inline-block">
                    <option value="0" selected>Todas</option>
                    <option value="1">Joyeria</option>
                    <option value="2">Hogar</option>
                    <option value="3">Textiles</option>
                    <option value="4">Madera</option>
                    <option value="5">Cerámica</option>
                </select>
                <button type="submit" class="btn boton-personalizado text-white">Filtrar</button>
            </form>

            <div class="row">
                <?php
                require "conexion/conexion.php";
                require "producto/mostrarInfoProductos.php";

                // Obtener categoría seleccionada
                $categoriaSeleccionada = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;

                // Filtrar productos según la categoría
                $informacionProductos = $categoriaSeleccionada > 0
                    ? mostrarInfoProductosPorCategoria($categoriaSeleccionada)
                    : mostrarInfoProductos();

                if (count($informacionProductos) > 0) {
                    foreach ($informacionProductos as $producto) {
                ?>
                        <!-- Tarjeta de producto <div class="col-6 col-md-4 col-lg-3 mb-4">-->
                        <div class="col-6 col-md-4 col-lg-3 mb-4">
                            <!-- Tarjeta de producto -->
                            <div class="card h-100 tarjeta-producto">
                                    <!-- Encabezado de la tarjeta -->
                                <div class="card-header bg-dark text-center">
                                    <!-- <h4 class="titulo-producto">
                                    <?php print $producto['NombreProducto'] ?></h4> -->
                                    <h4 class="mb-2 titulo-producto text-white"><?php  if (isset($producto['NombreProducto'])) print $producto['NombreProducto']; else  print $producto['Nombre'];  ?></h4>
                                </div>

                                <!-- Cuerpo de la tarjeta -->
                                <div class="card-body text-center ratio ratio-1x1">
                                    <?php
                                    $foto = 'producto/imgProductos/' . $producto['Imagen'];
                                    if (file_exists($foto)) {
                                    ?>
                                        <img src="<?php print $foto; ?>" class="img-fluid" >
                                    <?php } else { ?>
                                        <img src="producto/imgProductos/noHayImagen.jpg" class="img-fluid" >
                                    <?php } ?>
                                </div>

                                <!-- Muestra el detalle del producto -->
                                <div class="card-footer text-sm-start overflow-auto p-2 bg-Light scroll-personalizado" >
                                    <?php $descripcion = isset($producto['Descripcion']) ? $producto['Descripcion'] : 'Sin descripción disponible'; ?>
                                    <p class="text-dark text-justify">
                                        <?php echo htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8'); ?>
                                    </p>
                                </div>

                                    <!-- Pie de la tarjeta -->
                                <div class="card-footer bg-dark">
                                    <div class="row mb-2">
                                        <!-- Mostrar precio -->
                                        <div class="col-6 text-start mt-2">
                                            <span class="badge precios">
                                                $<?php echo htmlspecialchars($producto['Precio']); ?>
                                            </span> 
                                        </div>

                                        <!-- Mostrar stock -->
                                        <div class="col-6 text-end mt-2">
                                            <span class="badge disponibilidad">
                                                Stock: <?php echo isset($producto['Stock']) ? htmlspecialchars($producto['Stock']) : 'No disponible'; ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row w-100 mx-auto">
                                        <!-- Botón para agregar al carrito -->
                                        <a class="shadow-lg boton-carrito col text-dark btn w-100 btn-fixed mb-2" href="carrito/carrito.php?sku=<?php print $producto['Sku'] ?>">
                                            <i class="bi bi-cart-fill"></i> Agregar al carrito
                                        </a>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<h4>No hay registros para esta categoría</h4>';
                }
                ?>
            </div>
        </div>
    </section>

    <section id="seccionNosotros" tabindex="-1" class="contenedor sobre-nosotros py-5">
        <h2 class="heading-1 text-center mb-4">Sobre Nosotros</h2>

        <div class="container">
            <div class="row g-4">
                <!-- Tarjeta ¿Quiénes somos? -->
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="card">
                        <div class="contenedor-imagen position-relative">
                            <img src="recursos/imagenes/venta.jpg" class="card-img-top" alt="Imagen nosotros 1">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">¿Quiénes somos?</h3>
                            <p class="card-text text-justify">
                                Somos un equipo de jóvenes estudiantes con un gran intéres sobre nuestra cultura,
                                que busca aportar su granito de arena en su conservación y difusión.
                            </p>
                            <div class="boton-leer-mas">
                                <a href="#" class="btn boton-personalizado">Leer más</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Misión -->
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="card">
                        <div class="contenedor-imagen position-relative">
                            <img src="recursos/imagenes/artesano.jpg" class="card-img-top" alt="Imagen nosotros 2">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">Nuestra Visión</h3>
                            <p class="card-text text-justify">
                                Ser la tienda líder en la venta de productos artesanales únicos,
                                apoyando a la comunidad local y preservando la cultura y
                                tradiciones yucatecas.
                            </p>
                            <div class="boton-leer-mas">
                                <a href="#" class="btn boton-personalizado">Leer más</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Visión -->
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="card">
                        <div class="contenedor-imagen position-relative">
                            <img src="recursos/imagenes/artesana.jpg" class="card-img-top" alt="Imagen nosotros 3">
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">Nuestra Misión</h3>
                            <p class="card-text text-justify">
                                Ofrecer productos hechos a mano de alta calidad, conectando directamente
                                a los compradores con los vendedores, mientras apoyamos la economía local.
                            </p>
                            <div class="boton-leer-mas">
                                <a href="#" class="btn boton-personalizado">Leer más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include 'componentes/footer.php'; ?>