<?php
session_start();

if(!isset($_GET['sku'])){
    header('Location: carrito.php');
}

$sku = $_GET['sku'];

if(isset($_SESSION['carritos'][$_SESSION['usuario']])){
    unset($_SESSION['carritos'][$_SESSION['usuario']][$sku]);
    header('Location: carrito.php');
} else {
    header('Location: ../index.php');
}
?>