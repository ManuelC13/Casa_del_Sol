<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuario/publico/inicioDeSesion.php');
    exit();
}

require 'funcionesCarrito.php';

// Verificar que el carrito esté asociado al usuario específico
if(!isset($_SESSION['carritos'][$_SESSION['usuario']])) {
    $_SESSION['carritos'][$_SESSION['usuario']] = []; // Crear carrito vacío si no existe
}

if(isset($_GET['sku'])){
    $sku = $_GET['sku'];
    require "../conexion/conexion.php";
    $resultado = mostrarPorSku($sku);

    if(!$resultado){
        header('Location: ../index.php');
    }

    // Si el producto ya está en el carrito
    if(isset($_SESSION['carritos'][$_SESSION['usuario']][$sku])){ 
        actualizarCantidadDelProducto($sku);
    } else {
        agregarProducto($resultado, $sku);
    }
}

function mostrarPorSku($Sku){
    global $conexion;
    $sql = "SELECT * FROM producto WHERE Sku = '$Sku'";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc(); 
    }

    return false; 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sku'], $_POST['cantidad'])) {
    $sku = $_POST['sku'];
    $cantidad = intval($_POST['cantidad']);

    if ($cantidad > 0 && isset($_SESSION['carritos'][$_SESSION['usuario']][$sku])) {
        actualizarCantidadDelProducto($sku, $cantidad);
    } else {
        echo "<script>alert('Cantidad inválida');</script>";
    }
}


// Se guada la información del carrito del usuario actual en una cookie 
function guardarCarritoEnCookie() {
    if (isset($_SESSION['carritos'][$_SESSION['usuario']])) {
        $carritoJson = json_encode($_SESSION['carritos'][$_SESSION['usuario']]);
        $idUsuario = $_SESSION['idUsuario'];
        setcookie('carrito_usuario_' . $idUsuario, $carritoJson, time() + (86400 * 30), "/"); // Cookie válida por 30 días
    }
}

guardarCarritoEnCookie();
?>

<?php include '../componentes/headerCarrito.php'; ?>
    
    <!-- Contenedor principal -->
    <div class="container min-vh-100 mt-1 pt-5 contenedor-general">
        <?php if (isset($_SESSION['carritos'][$_SESSION['usuario']]) && !empty($_SESSION['carritos'][$_SESSION['usuario']])) { ?>
            <div class="row g-3">
                <h3 class="text-lg-start text-center"><strong>Carrito de Compras</strong></h3>
                <?php 
                $numArticulo = 0;
                foreach ($_SESSION['carritos'][$_SESSION['usuario']] as $indice => $value) { 
                    $numArticulo++;
                    $subTotal = $value['precio'] * $value['cantidad'];
                ?>
                <div class="col-12">
                    <div class="card shadow-sm p-3">
                        <div class="row g-3 align-items-center">
                            <!-- Imagen del producto -->
                            <div class="col-md-2 text-center">
                                <?php 
                                $foto = '../producto/imgProductos/' . $value['imagen'];
                                if (file_exists($foto)) { ?>
                                    <img src="<?php print $foto; ?>" class="img-fluid rounded" alt="<?php print $value['nombre']; ?>" style="max-height: 100px;">
                                <?php } else { ?>
                                    <img src="../imgProductos/noHayImagen.jpg" class="img-fluid rounded" alt="Sin imagen" style="max-height: 100px;">
                                <?php } ?>
                            </div>
                            <!-- Información del producto -->
                            <div class="col-md-6">
                                <h5 class="card-title"><?php print $value['nombre']; ?></h5>
                                <p class="text-muted mb-1">Precio unitario: <strong>$<?php print $value['precio']; ?></strong></p>
                                <p class="text-muted">Subtotal: <strong>$<?php print $subTotal; ?></strong></p>
                            </div>
                            <!-- Cantidad y acciones -->
                            <div class="col-md-4 text-end">
                                <form action="actualizarCarrito.php" method="post" class="d-inline">
                                    <input type="hidden" name="sku" value="<?php print $value['sku']; ?>">
                                    <div class="input-group mb-2">
                                        <input type="number" name="cantidad" class="form-control" value="<?php print $value['cantidad']; ?>" min="1">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                </form>
                                <a href="eliminarCarrito.php?sku=<?php print $value['sku']; ?>" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash3-fill"></i> Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- Total y botones -->
            <div class="row mt-4 mb-5">
                <div class="col-lg-6 col-12  text-lg-start text-center">
                    <a href="../index.php" class="btn boton-personalizado col-lg-5 col-12">Seguir comprando</a>
                </div>
                <div class="col-lg-6 col-12 text-lg-end text-center mt-3 mt-lg-0">
                    <span class="me-2 col-lg-8 col-12">Total: <strong>$<?php print calcularCostoTotal(); ?></strong></span>
                    <a href="comprar.php" class="btn btn-success boton-compra mt-3 mt-lg-0 col-lg-4 col-12">Realizar compra</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="text-center my-5 mb-5">
                <h4>No hay productos en el carrito</h4>
                <a href="../index.php" class="btn boton-personalizado mt-3">Ir a comprar</a>
            </div>
        <?php } ?>
    </div>

    <?php include '../componentes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>