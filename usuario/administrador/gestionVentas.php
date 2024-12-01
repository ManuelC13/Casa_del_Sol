<? include '../../componentes/headerAdmin.php';?>

<body>
    <h1 class="text-center mb-4">Gestión de ventas</h1>
        <!-- contenedor general de la tabla -->
        <div class="contenedor container w-75 rounded">

        <!-- Barra de búsqueda centrada -->
        <div class="container">
            <form class="d-flex justify-content-center">
            <input 
                class="form-control me-2 w-50 light-table-filter shadow-sm" 
                data-table="table-id" 
                type="text"
                placeholder="Buscar" 
                aria-label="Buscar"
            >
            </form>
        </div>

        <!-- Tabla de productos centrada -->
        <div class="container w-100 rounded shadow">
            <table class="table-id table table-hover table-fixed table-responsive" id="tablaProductos">
            <caption>Lista de productos</caption>
            <thead>
                <tr class="table-active text-white">
                <th style="width: 60px" scope="col">#</th>
                <th style="width: 30px" scope="col">ID venta</th>
                <th style="width: 200px" scope="col">Nombre usuario</th>
                <th style="width: 400px" scope="col">Productos</th>
                <th style="width: 200px" scope="col">Total</th>
                <th style="width: 300px" scope="col">Fecha de venta</th>
                </tr>
            </thead>
            <tbody class="table-id">
                <?php require_once 'obtenerVentas.php' ?>
            </tbody>
            </table>
        </div>
        </div>

        <!-- Botón para realizar la acción con el ID del cliente -->
        <div class="text-center">
            <a href="../../fpdf/reporteVentas.php" target="_blank" id="generarReporteBtn" class="btn boton3 text-dark mt-2 text-center"><i class="fa-regular fa-file-pdf"></i>Generar reporte</a>
        </div>

        <div class="enlace-regresar text-center mt-4 mb-4">
            <a class="btn btn-danger text-light text-center" href="menuDeAdministracion.php">&lt; Regresar</a>
        </div>

        <?php include '../../componentes/footer.php'; ?>

        <script src="../../javasCript/buscador.js"></script>
</body>
</html>