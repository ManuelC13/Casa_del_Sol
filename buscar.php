<?php 
// Incluir header
include 'componentes/header.php'; 

// Incluir conexión a la base de datos
require 'conexion/conexion.php'; 

// Recuperar el término de búsqueda
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Verifica si la conexión es válida
if ($conexion === null) {
    die("Error de conexión a la base de datos.");
}

function mostrarInfoProductos()
{
    global $conexion; // Accede a la variable $conexion declarada fuera de la función
    $sql = "SELECT * FROM producto INNER JOIN categoria ON producto.IdCategoria = categoria.Id;";

    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $productos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = $fila;
        }
        return $productos; // Retorna el array de resultados
    } else {
        return []; // Retorna un array vacío si no hay resultados
    }
}
?>

<section class="min-vh-100">
    <div class="container mt-5 pt-5">
        <h2 class="text-center">Resultados de Búsqueda</h2>
        <div class="row">
            <?php
            if (!empty($query)) {
                $stmt = $conexion->prepare("SELECT * FROM producto WHERE Nombre LIKE ?");
                
                if ($stmt === false) {
                    die("Error al preparar la consulta.");
                }

                $searchTerm = "%$query%";
                $stmt->bind_param("s", $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($producto = $result->fetch_assoc()) {
                        $foto = 'producto/imgProductos/' . $producto['Imagen']; 
                        ?>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h4 class="titulo-producto"><?php echo htmlspecialchars($producto['Nombre']); ?></h4>
                                </div>
                                <div class="card-body text-center">
                                    <?php if (file_exists($foto)) { ?>
                                        <img src="<?php echo $foto; ?>" class="img-fluid">
                                    <?php } else { ?>
                                        <img src="../producto/imgProductos/noHayImagen.jpg" class="img-fluid">
                                    <?php } ?>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="carrito/carrito.php?sku=<?php echo $producto['Sku']; ?>" class="btn btn-success w-100">
                                        <i class="bi bi-cart-fill"></i> Agregar al carrito
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p class='text-center'>No se encontraron productos con el término '<strong>" . htmlspecialchars($query) . "</strong>'</p>";
                }
            } else {
                echo "<p class='text-center'>Ingrese un término de búsqueda.</p>";
            }
            ?>
        </div>
    </div>
</section>
<?php 
// Incluir footer
include 'componentes/footer.php'; 
?>
