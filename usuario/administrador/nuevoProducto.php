<!-- Mostrar el mensaje de exito de registro si existe cuando se registra un producto -->
<?php
        //session_start();
        include '../../componentes/headerAdmin.php';
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            $alertClass = strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success';
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = new bootstrap.Modal(document.getElementById('resultadoModal'));
                    document.getElementById('resultadoMensaje').innerHTML = '<div class=\"alert $alertClass\">$message</div>';
                    modal.show();
                });
            </script>";
            unset($_SESSION['message']); // Limpiar el mensaje después de mostrarlo
        }
?>

<!-- Manejo de errores modal-->
<?php
        if (isset($_SESSION['messageError'])) {
            $message = $_SESSION['messageError'];
            $alertClass = strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success';
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = new bootstrap.Modal(document.getElementById('resultadoModal'));
                    document.getElementById('resultadoMensaje').innerHTML = '<div class=\"alert $alertClass\">$message</div>';
                    modal.show();
                });
            </script>";
            unset($_SESSION['messageError']); // Limpiar el mensaje después de mostrarlo
        }
?>
    <!--ESTILO PERSONALIZADO-->
    <link rel="stylesheet" href="../../css/nuevoProducto.css">

<body>
    
    <!--Sección principal-->
    <main>
        <h1 class="text-center ">Alta de producto</h1>
        <!-- Modal de mensaje de exito cuando se registra un nuevo producto -->
        <div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="resultadoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabel">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="resultadoMensaje">
                        <!-- Aquí se mostrará el mensaje -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <form class="formProducto" action="../../producto/altaProductos.php" method="post" enctype="multipart/form-data">
            <div class="contenedor-tabla">
                <div>
                    <label for="sku">SKU:</label>
                    <input type="text" id="sku" name="sku" required>
                    <span id="sku-error" style="color: red; display: none;">Debe tener 9 caracteres.</span>
                </div>
                
                <div>
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" required min="1">
                </div>
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div>
                    <label for="precio">Precio:</label>
                    <input type="number" step="0.01" id="precio" name="precio" required min="0.01">
                </div>
                <div>
                    <label for="categoria">Categoría:</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccionar</option>
                        <option value="1">Joyería</option>
                        <option value="2">Hogar</option>
                        <option value="3">Textiles</option>
                        <option value="4">Madera</option>
                        <option value="5">Cerámica</option>
                    </select>
                </div>
                <div>
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion" required>
                </div>
                <div class="subir-imagen">
                    <label for="cargar-imagen">Cargar imagen:</label>
                    <input type="file" id="cargar-imagen" name="cargar-imagen" accept=".jpg, .jpeg, .png, .webp" required>
                </div>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <button type="submit">Dar de alta nuevo producto</button>
            </div>
        </form>
        
        <!-- Enlace para regresar a la página de gestión de productos -->
        <div class="enlace-regresar text-center mb-5 mt-4">
            <a class="btn btn-danger text-light text-center" href="../administrador/gestionProductos.php">&lt; Regresar</a>
        </div>
        
    </main>

    <?php include '../../componentes/footer.php'; ?>

    <!--Script para el menú desplegable-->
    <script>
        const reporteBtn = document.getElementById("generar-reporte-btn");
        const menuReporte = document.getElementById("menu-reporte");
        
        //Función para alternar la visibilidad del menú
        reporteBtn.addEventListener("click", () => {
            menuReporte.style.display = (menuReporte.style.display === "none" || menuReporte.style.display === "") ? "block" : "none";
        });
    </script>

    
    <!--Script para validar el SKU
    <script>
        const form = document.querySelector('.formProducto');
        const skuInput = document.getElementById('sku'); 
        const skuError = document.getElementById('sku-error');

        form.addEventListener('submit', (event) => {
            const skuValue = skuInput.value.trim(); // Asegurarnos de eliminar espacios adicionales
            if (skuValue.length !== 9) {
                skuError.style.display = 'block'; // Mostrar el mensaje de error
                event.preventDefault(); // Evitar que el formulario se envíe
            } else {
                skuError.style.display = 'none'; // Ocultar el mensaje si es válido
            }
        });
    </script>-->
    <!-- Script para validar el SKU -->
    <script>
        const form = document.querySelector('.formProducto');
        const skuInput = document.getElementById('sku'); 
        const skuError = document.getElementById('sku-error');

        form.addEventListener('submit', (event) => {
            const skuValue = skuInput.value.trim(); // Eliminar espacios adicionales
            const skuPattern = /^[A-Z]{5}\d{4}$/; // 5 letras mayúsculas y 4 números

            if (!skuPattern.test(skuValue)) {
                skuError.style.display = 'block'; // Mostrar el mensaje de error
                skuError.textContent = 'FORMATO: ABCDE1234.';
                event.preventDefault(); // Evitar que el formulario se envíe
            } else {
                skuError.style.display = 'none'; // Ocultar el mensaje si es válido
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
