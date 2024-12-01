<!-- Mostrar el mensaje de exito de registro si existe cuando se registra un producto -->
<?php
        // Incluir el header
        include '../../componentes/headerAdmin.php';


        if (isset($_SESSION['messageActualizar'])) {
            $message = $_SESSION['messageActualizar'];
            $alertClass = strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success';
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = new bootstrap.Modal(document.getElementById('resultadoModalActualizar'));
                    document.getElementById('resultadoMensajeActualizar').innerHTML = '<div class=\"alert $alertClass\">$message</div>';
                    modal.show();
                });
            </script>";
            unset($_SESSION['messageActualizar']); // Limpiar el mensaje después de mostrarlo
        }
?>
    
  </head>
  <body>
        <!-- Modal de mensaje de exito cuando se registra un nuevo producto -->
        <div class="modal fade" id="resultadoModalActualizar" tabindex="-1" aria-labelledby="resultadoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabel">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="resultadoMensajeActualizar">
                        <!-- Aquí se mostrará el mensaje -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn boton3" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    <h1 class="text-center mb-3">Gestión de productos</h1>
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
              <th style="width: 30px" scope="col">#</th>
              <th style="width: 30px" scope="col">SKU</th>
              <th style="width: 200px" scope="col">Nombre producto</th>
              <th style="width: 300px" scope="col">Descripción</th>
              <th style="width: 50px" scope="col">Stock</th>
              <th style="width: 30px" scope="col">Precio</th>
              <th style="width: 200px" scope="col">Categoria</th>
              <th style="width: 70px" scope="col">Imagen</th>
            </tr>
          </thead>
          <tbody class="table-id">
            <?php require_once 'obtenerProductos.php' ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Botón para realizar la acción con el sku del producto -->
    <div class="text-center flex-wrap justify-content-evenly gap-3">
        <a href="nuevoProducto.php" class="col btn boton3 text-dark text-center mt-2 flex-grow-1"><i class="fa fa-plus-circle"></i> Nuevo producto</a>
        <button id="updateBtn" class="col btn boton3 text-dark text-center mt-2"><i class="fa fa-sync-alt"></i> Actualizar producto</button>
        <button id="eliminarProductoBtn" class="col btn btn-danger text-light mt-2 text-center" disabled><i class="fa fa-trash-alt"></i> Eliminar producto</button>

        <!--Botón para generar los reportes-->
        <button type="button" class="col btn boton3 dropdown-toggle mt-2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-file-pdf"></i> Generar reporte</button>
        <ul class="dropdown-menu">
            <!--<li><a id="reporteCategoriaBtn" class="dropdown-item" href="../../fpdf/reporteProductos.php?tipo=categoria" target="_blank">Por categoría</a></li>-->
            <li><a id="reporteCategoriaBtn" class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalSeleccionarCategoria">Por categoría</a></li>
            <li><a id="reporteMasVendidosBtn" class="dropdown-item" href="../../fpdf/reporteProductos.php?tipo=masVendidos" target="_blank">Por productos más vendidos</a></li>

            <li><a id="reporteMenorVentaBtn" class="dropdown-item" href="../../fpdf/reporteProductos.php?tipo=menosVendidos" target="_blank">Por productos menos vendidos</a></li>
        </ul>
    </div>
    

    <?php include '../../conexion/conexion.php'; ?>
    <!-- Modal Para seleecionar una categoria para el reporte-->
    <div class="modal fade" id="modalSeleccionarCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Seleccione una categoría:</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <!--CUERPO DEL MODAL-->
          <div class="modal-body">

            <form id="formSeleccionarCategoria" action="../../fpdf/reporteProductos.php" method="GET">
              <input type="hidden" name="tipo" value="categoria">

              <div class="form-group">
                <label for="categoria" class="text-center">Categoría:</label>
                <select id="categoria" name="categoria" class="form-control mt-1" required>
                  <?php
                  $consulta = $conexion->query("SELECT Id, Nombre FROM categoria");
                  while ($categoria = $consulta->fetch_assoc()) {
                      echo "<option value='{$categoria['Id']}'>{$categoria['Nombre']}</option>";
                  }
                  ?>
                </select>
              </div>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn boton3" form="formSeleccionarCategoria">
                <i class="fa-regular fa-file-pdf"></i> Generar Reporte
            </button>

          </div>
        </div>
      </div>
    </div>


    <div class="enlace-regresar text-center mt-4 mb-4">
            <a class="btn btn-danger text-light text-center" href="menuDeAdministracion.php">&lt; Regresar</a>
    </div>

    <!-- Modal de confirmación para eliminar al usuario -->
    <div class="modal fade " id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Confirmación de eliminación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            ¿Estás seguro de que deseas eliminar este producto?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
          </div>
        </div>
      </div>
    </div>

    
    <?php include '../../componentes/footer.php'; ?>


  <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>-->
  <script src="scriptProductos.js"></script>
  <script src="../../javasCript/buscador.js"></script>

  </body>
</html>