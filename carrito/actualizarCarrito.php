<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    require 'funcionesCarrito.php';
    $sku = $_POST['sku'];
    $cantidad = $_POST['cantidad'];

    if(is_numeric($cantidad)){
        if(array_key_exists($sku,$_SESSION['carritos'][$_SESSION['usuario']])){
            actualizarCantidadDelProducto($sku, $cantidad);
        }
    }

    header('Location: carrito.php');
}
?>