<?php
// function procesarCompra(){

//     global $conexion;
//     // Verificar si hay productos en el carrito
//     if(!isset($_SESSION['carritos'][$_SESSION['usuario']]) || empty($_SESSION['carritos'][$_SESSION['usuario']])) {
//         return 'El carrito está vacío.';
//     }
    
//     $totalCompra = 0;
//     $productosParaActualizar = [];

//     // Iniciar una transacción
//     $conexion->begin_transaction();

//     try {
//         // Registrar la compra en la tabla de compras
//         $sqlCompra = "INSERT INTO compras (usuario_id, total) VALUES (?, ?)";
//         $stmtCompra = $conexion->prepare($sqlCompra);
//         $usuarioId = $_SESSION['usuario']; // Suponiendo que tienes un ID de usuario en la sesión
//         $totalCompra = calcularCostoTotal(); // Utiliza la función para calcular el total de la compra
//         $stmtCompra->bind_param("id", $usuarioId, $totalCompra);
//         $stmtCompra->execute();
//         $compraId = $conexion->insert_id; // ID de la compra registrada

//         // Recorrer los productos del carrito para actualizar el stock
//         foreach($_SESSION['carritos'][$_SESSION['usuario']] as $sku => $producto) {
//             $cantidadCompra = $producto['cantidad'];
//             $precioProducto = $producto['precio'];
            
//             // Verificar si hay suficiente stock
//             $sqlStock = "SELECT stock FROM productos WHERE sku = ?";
//             $stmtStock = $conexion->prepare($sqlStock);
//             $stmtStock->bind_param("s", $sku);
//             $stmtStock->execute();
//             $resultadoStock = $stmtStock->get_result()->fetch_assoc();

//             if($resultadoStock['stock'] < $cantidadCompra) {
//                 // Si no hay suficiente stock, lanzar un error
//                 throw new Exception("No hay suficiente stock para el producto " . $producto['nombre']);
//             }

//             // Actualizar el stock en la base de datos
//             $nuevoStock = $resultadoStock['stock'] - $cantidadCompra;
//             $sqlActualizarStock = "UPDATE productos SET stock = ? WHERE sku = ?";
//             $stmtActualizarStock = $conexion->prepare($sqlActualizarStock);
//             $stmtActualizarStock->bind_param("is", $nuevoStock, $sku);
//             $stmtActualizarStock->execute();

//             // Registrar el detalle de la compra
//             $sqlDetalleCompra = "INSERT INTO detalle_compras (compra_id, sku, cantidad, precio) VALUES (?, ?, ?, ?)";
//             $stmtDetalleCompra = $conexion->prepare($sqlDetalleCompra);
//             $stmtDetalleCompra->bind_param("isid", $compraId, $sku, $cantidadCompra, $precioProducto);
//             $stmtDetalleCompra->execute();
//         }

//         // Si todo está bien, confirmar la transacción
//         $conexion->commit();

//         // Vaciar el carrito de compras
//         unset($_SESSION['carritos'][$_SESSION['usuario']]);

//         return 'Compra realizada con éxito.';
//     } catch (Exception $e) {
//         // Si hubo un error, deshacer la transacción
//         $conexion->rollback();
//         return 'Error al procesar la compra: ' . $e->getMessage();
//     }
// }

session_start();

include '../conexion/conexion.php'; 

if (!isset($_SESSION['usuario'])) {
    die("Por favor inicia sesión antes de realizar una compra.");
}

$usuario = $_SESSION['usuario'];
$usuario_id = $_SESSION['idUsuario']; // Obtén el ID del usuario logueado
$carrito = $_SESSION['carritos'][$usuario] ?? [];

if (empty($carrito)) {
    die("Tu carrito está vacío.");
}

// Iniciar una transacción
$conexion->begin_transaction();

try {
    // 1. Registrar la compra en la tabla `compras`
    $total = 0;
    foreach ($carrito as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }

    $stmt = $conexion->prepare("INSERT INTO compras (usuario_id, total) VALUES (?, ?)");
    $stmt->bind_param("id", $usuario_id, $total);
    $stmt->execute();
    $compra_id = $stmt->insert_id; // Obtén el ID de la compra generada
    $stmt->close();

    // 2. Registrar los productos en la tabla `detalle_compras` y actualizar el stock
    foreach ($carrito as $sku => $producto) {
        $stmt = $conexion->prepare("INSERT INTO detalle_compras (compra_id, sku, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isid", $compra_id, $sku, $producto['cantidad'], $producto['precio']);
        $stmt->execute();
        $stmt->close();

        // Actualizar el stock del producto
        $stmt = $conexion->prepare("UPDATE producto SET stock = stock - ? WHERE sku = ?");
        $stmt->bind_param("is", $producto['cantidad'], $sku);
        $stmt->execute();
        $stmt->close();
    }

    // 3. Vaciar el carrito
    unset($_SESSION['carritos'][$usuario]);

    // Confirmar la transacción
    $conexion->commit();

    // Redirigir con mensaje de éxito
    header("Location: confirmacion.php?status=success");
    exit;

} catch (Exception $e) {
    // Si algo falla, revertir la transacción
    $conexion->rollback();
    die("Error al procesar la compra: " . $e->getMessage());
}
?>

?>