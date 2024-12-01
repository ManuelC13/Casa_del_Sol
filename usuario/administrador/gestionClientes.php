<?php include '../../componentes/headerAdmin.php';?>

  <body style="background-color: #f4f1ea;">
  
    <!-- Gestión de clientes -->
    <h1 class="text-center mb-4">Gestión de clientes</h1>

    <!-- contenedor general de la tabla -->
    <div class="contenedor container w-75 rounded">

      <!-- Barra de búsqueda centrada -->
      <div class="container">
        <form class="d-flex justify-content-center">
          <input 
            class="form-control me-2 w-50 light-table-filter shadow-sm" 
            data-table="table-id" 
            type="text"
            placeholder="Buscar cliente" 
            aria-label="Buscar"
          >
        </form>
      </div>

      <div class="container w-100 rounded shadow">
        <!-- Tabla de clientes -->
      <table class="table table-id table-hover table-fixed table-responsive">
        <caption>Lista de clientes</caption>
        <!-- Encabezado de la tabla -->
        <thead>
        <!-- Fila de encabezado -->
          <tr class="table-active text-uppercase text-white">
            <th style="width: 25px" scope="col">#</th>
            <th style="width: 150px" scope="col">ID</th>
            <th style="width: 250px" scope="col">Nombre</th>
            <th style="width: 250px" scope="col">Apellido</th>
            <th style="width: 100px" scope="col">Edad</th>
            <th style="width: 450px" scope="col">Fecha de registro</th>
            <th style="width: 250px" scope="col">Rol</th>
          </tr>
        </thead>
        <!-- Cuerpo de la tabla -->
        <tbody>
          <?php require_once 'obtenerClientes.php' ?>
        </tbody>
      </table>
      </div>      
    </div>

    <!-- Botón para realizar la acción con el ID del cliente -->
    <div class="text-center">
        <button id="eliminarClienteBtn" class="btn btn-danger text-light mt-2 text-center" disabled><i class="fa fa-trash-alt"></i> Eliminar cliente</button>
        <a href="../../fpdf/reporteClientes.php" target="_blank" id="generarReporteBtn" class="btn boton3 text-dark mt-2 text-center"><i class="fa-regular fa-file-pdf"></i>Generar reporte</a>
    </div>

    <!-- Botón para regresar al menú de administración -->
    <div class="enlace-regresar text-center mt-4 mb-5">
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
            ¿Estás seguro de que deseas eliminar este usuario?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
          </div>
        </div>
      </div>
    </div>

    <?php include '../../componentes/footer.php'; ?>
  <script src="scriptClientes.js"></script>
  <script src="../../javasCript/buscador.js"></script>

  </body>
</html>