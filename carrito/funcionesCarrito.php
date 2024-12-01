<?php
function agregarProducto($resultado, $sku, $cantidad=1){
    // Usar $_SESSION['carritos'][$_SESSION['usuario']] para asegurarse de que el carrito es único para cada usuario
    $_SESSION['carritos'][$_SESSION['usuario']][$sku] = array(
        'sku' => $resultado['Sku'],
        'nombre' => $resultado['Nombre'],
        'descripcion' => $resultado['Descripcion'],
        'stock' => $resultado['Stock'],
        'precio' => $resultado['Precio'],
        'idCategoria' => $resultado['IdCategoria'],
        'imagen' => $resultado['Imagen'],
        'cantidad' => $cantidad
    );
}

//Funcion para actualizar el carrito
function actualizarCantidadDelProducto($sku, $cantidad = null) {
    if ($cantidad !== null && $cantidad < 0) {
        // No permitir cantidades negativas
        return;
    }

    if($cantidad === 0){
        unset($_SESSION['carritos'][$_SESSION['usuario']][$sku]);
    }
    elseif ($cantidad !== null) {
        // Actualizar la cantidad del producto
        $_SESSION['carritos'][$_SESSION['usuario']][$sku]['cantidad'] = $cantidad;
    } else {
        // Incrementar la cantidad en 1 si no se pasa un valor
        $_SESSION['carritos'][$_SESSION['usuario']][$sku]['cantidad'] += 1;
    }
}

function calcularCostoTotal(){
    $precioTotal = 0;
    if(isset($_SESSION['carritos'][$_SESSION['usuario']])){
        foreach($_SESSION['carritos'][$_SESSION['usuario']] as $indice => $value){
            $precioTotal += $value['precio'] * $value['cantidad'];
        }
    }
    return $precioTotal;
}

function contarNumeroDeProductos(){
    $numProductos = 0;
    if(isset($_SESSION['carritos'][$_SESSION['usuario']])){
        foreach($_SESSION['carritos'][$_SESSION['usuario']] as $indice => $value){
            $numProductos++;
        }
    }
    return $numProductos;
}

function procesarCompra($conexion){
    // Verificar si hay productos en el carrito
    if(!isset($_SESSION['carritos'][$_SESSION['usuario']]) || empty($_SESSION['carritos'][$_SESSION['usuario']])) {
        return 'El carrito está vacío.';
    }
    
    $totalCompra = 0;
    $productosParaActualizar = [];

    // Iniciar una transacción
    $conexion->begin_transaction();

    try {
        // Registrar la compra en la tabla de compras
        $sqlCompra = "INSERT INTO compras (usuario_id, total) VALUES (?, ?)";
        $stmtCompra = $conexion->prepare($sqlCompra);
        $usuarioId = $_SESSION['usuario']; // Suponiendo que tienes un ID de usuario en la sesión
        $totalCompra = calcularCostoTotal(); // Utiliza la función para calcular el total de la compra
        $stmtCompra->bind_param("id", $usuarioId, $totalCompra);
        $stmtCompra->execute();
        $compraId = $conexion->insert_id; // ID de la compra registrada

        // Recorrer los productos del carrito para actualizar el stock
        foreach($_SESSION['carritos'][$_SESSION['usuario']] as $sku => $producto) {
            $cantidadCompra = $producto['cantidad'];
            $precioProducto = $producto['precio'];
            
            // Verificar si hay suficiente stock
            $sqlStock = "SELECT stock FROM productos WHERE sku = ?";
            $stmtStock = $conexion->prepare($sqlStock);
            $stmtStock->bind_param("s", $sku);
            $stmtStock->execute();
            $resultadoStock = $stmtStock->get_result()->fetch_assoc();

            if($resultadoStock['stock'] < $cantidadCompra) {
                // Si no hay suficiente stock, lanzar un error
                throw new Exception("No hay suficiente stock para el producto " . $producto['nombre']);
            }

            // Actualizar el stock en la base de datos
            $nuevoStock = $resultadoStock['stock'] - $cantidadCompra;
            $sqlActualizarStock = "UPDATE productos SET stock = ? WHERE sku = ?";
            $stmtActualizarStock = $conexion->prepare($sqlActualizarStock);
            $stmtActualizarStock->bind_param("is", $nuevoStock, $sku);
            $stmtActualizarStock->execute();

            // Registrar el detalle de la compra
            $sqlDetalleCompra = "INSERT INTO detalle_compras (compra_id, sku, cantidad, precio) VALUES (?, ?, ?, ?)";
            $stmtDetalleCompra = $conexion->prepare($sqlDetalleCompra);
            $stmtDetalleCompra->bind_param("isid", $compraId, $sku, $cantidadCompra, $precioProducto);
            $stmtDetalleCompra->execute();
        }

        // Si todo está bien, confirmar la transacción
        $conexion->commit();

        // Vaciar el carrito de compras
        unset($_SESSION['carritos'][$_SESSION['usuario']]);

        return 'Compra realizada con éxito.';
    } catch (Exception $e) {
        // Si hubo un error, deshacer la transacción
        $conexion->rollback();
        return 'Error al procesar la compra: ' . $e->getMessage();
    }
}

?>