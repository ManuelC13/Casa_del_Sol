<?php include '../../componentes/headerAdmin.php'; ?>
    
</head>
<body>
    <main class="py-5 min-vh-100">
        <!-- Contenedor principal para los botones -->
        <div class="contenedor-admin container contenedor p-4 rounded-3 col-12 col-md-8 col-lg-6">

            <!-- Título -->
            <div class="text-center mb-4">
                <h1 class="text-title text-dark">Administrador</h1>
            </div>
    
            <!-- Contenedor de acciones -->
            <div class="d-flex flex-wrap py-2 justify-content-evenly gap-3">
                <!-- Botón para gestionar clientes -->
                <a href="../administrador/gestionClientes.php" class="btn boton-clientes focus-ring flex-grow-1 text-center"><i class="fa-solid fa-user-pen"></i> Gestionar clientes</a>

                <!-- Botón para gestionar productos -->
                <a href="../administrador/gestionProductos.php" class="btn boton-productos focus-ring flex-grow-1 text-center"><i class="fa-solid fa-sheet-plastic"></i> Gestionar productos</a>
    
                <!-- Botón para gestionar ventas -->
                <a href="../administrador/gestionVentas.php" class="btn boton-ventas focus-ring flex-grow-1 text-center"><i class="fa-solid fa-truck-moving"></i> Gestionar ventas</a>
            </div>
        </div>
    </main>
    
    <?php include '../../componentes/footer.php'; ?>
</body>
</html>