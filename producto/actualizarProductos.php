<?php
// Conexión a la base de datos
include '../componentes/headerAdmin.php';
require("../conexion/conexion.php"); // Conecta con la BD

// Obtener el SKU desde la URL
$sku = isset($_GET['sku']) ? trim($_GET['sku']) : null;

// Variable para el mensaje de error
$errorMessage = '';
$producto = null;

if (!empty($sku)) {
    // Usa una consulta preparada para evitar inyección SQL
    $sql = "SELECT * FROM producto WHERE Sku = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $sku); // Usa "s" para cadenas
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtiene los detalles del producto
        $producto = $result->fetch_assoc();
    } else {
        $errorMessage = 'Producto no encontrado.';
    }

    // Cierra la sentencia
    $stmt->close();
} else {
    $errorMessage = 'SKU no válido.';
}

//Cierra la conexión a la base de datos
$conexion->close();

// Manejo de errores
if (!empty($errorMessage)) {
    echo "<script>alert('$errorMessage'); window.location.href = '../usuario/administrador/gestionProductos.php';</script>";
    exit;
}
?>
    <!--Estilos para la página-->
    <link rel="stylesheet" href="../css/nuevoProducto.css">

<body>

    <!--Sección principal-->
    <main>
        <h1 class="text-center">Actualizar producto</h1>
        <form class="formProducto" action="editarProducto.php" method="post" enctype="multipart/form-data">
            <div class="contenedor-tabla">
                <div>
                    <label for="sku">SKU:</label>
                    <input type="text" id="sku" name="sku" value="<?php echo $producto['Sku']; ?>" style="background-color: #dbdada; color: #888; border: 1px solid #ccc;" readonly>
                </div>
                <div>
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" value="<?php echo $producto['Stock']; ?>" required >
                </div>
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $producto['Nombre']; ?>" style="background-color: #dbdada; color: #888; border: 1px solid #ccc;" readonly>
                </div>
                <div>
                    <label for="precio">Precio:</label>
                    <input type="number" step="0.01" id="precio" name="precio" value="<?php echo $producto['Precio']; ?>" required>
                </div>
                <div>
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccionar</option>
                        <option value="1" <?php echo ($producto['IdCategoria'] == 1) ? 'selected' : ''; ?>>Joyeria</option>
                        <option value="2" <?php echo ($producto['IdCategoria'] == 2) ? 'selected' : ''; ?>>Hogar</option>
                        <option value="3" <?php echo ($producto['IdCategoria'] == 3) ? 'selected' : ''; ?>>Textiles</option>
                        <option value="4" <?php echo ($producto['IdCategoria'] == 4) ? 'selected' : ''; ?>>Madera</option>
                        <option value="5" <?php echo ($producto['IdCategoria'] == 5) ? 'selected' : ''; ?>>Cerámica</option>
                    </select>
                </div>
                <div>
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" value="<?php echo $producto['Descripcion']; ?>">
                </div>
                <div>
                    <label for="fecha-registro">Fecha de registro:</label>
                    <input type="text" id="fecha-registro" name="fecha-registro" value="<?php echo $producto['FechaRegistro']; ?>" style="background-color: #dbdada; color: #888; border: 1px solid #ccc;" readonly>
                </div>
                <div class="subir-imagen">
                    <label for="cargar-imagen-actualizar">Cargar imagen:</label>
                    <input type="file" id="cargar-imagen-actualizar" name="cargar-imagen-actualizar">
                    <input type="hidden" name="fotoTemporal" value="<?php print $producto['Imagen']?>">
                </div>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <button type="submit">Actualizar</button>
            </div>
        </form>

        <!-- Enlace para regresar a la página de gestión de productos -->
        <div class="enlace-regresar text-center mb-4 mt-4">
            <a class="btn btn-danger text-light text-center" href="../usuario/administrador/gestionProductos.php">&lt; Regresar</a>
        </div>
        
        
    </main>

    <?php include '../componentes/footer.php'; ?>

    <!--Script menú desplegable-->
    <script>
        const reporteBtn = document.getElementById("generar-reporte-btn");
        const menuReporte = document.getElementById("menu-reporte");
        
        // Función para alternar la visibilidad del menú
        reporteBtn.addEventListener("click", () => {
            menuReporte.style.display = (menuReporte.style.display === "none" || menuReporte.style.display === "") ? "block" : "none";
        });
    </script>

    <?php if ($errorMessage != ''): ?>
        <script>
            alert('<?php echo $errorMessage; ?>');
        </script>
    <?php endif; ?>

</body>
</html>