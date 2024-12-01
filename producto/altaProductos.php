<?php
//Conexión a la base de datos
require_once "../conexion/conexion.php";

//Iniciar la sesión
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Obtiene los datos del formulario
    $sku = $_POST['sku'];
    $cantidad = $_POST['cantidad'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $foto = subirFoto();

    //Inserta el producto en la base de datos
    $sql = "INSERT INTO producto (Sku, Nombre, Descripcion, Stock, Precio, IdCategoria,Imagen) 
            VALUES ('$sku', '$nombre', '$descripcion', '$cantidad','$precio', '$categoria', '$foto')";
    
    //ejecuta la consulta
    if ($conexion->query($sql) === TRUE) {
        $_SESSION['message'] = "Producto añadido exitosamente.";
    } else {
        $_SESSION['message'] = "Error al agregar el producto: " . $conexion->error;
    }

    //Cierra la conexión
    $conexion->close();

    //Redirige a la página de nuevoProducto.php
    header("Location: ../usuario/administrador/nuevoProducto.php");
    exit();
}

//Cargar la foto del producto
function subirFoto() {

    //Obtiene la imagen
    $imagen = $_FILES['cargar-imagen'];

    //Define una carpeta donde se guardarán las imágenes
    $carpetaAlmacenamiento = __DIR__.'/imgProductos/';

    //Obtiene el nombre del archivo
    $archivo = $carpetaAlmacenamiento.$_FILES['cargar-imagen']['name'];

    //Obtiene el tipo de archivo
    $tipoImagen = $imagen['type'];

    //Valida que sea una imagen JPEG, PNG o GIF
    $extensionesPermitidas = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($tipoImagen, $extensionesPermitidas)) {
        die("Solo se permiten imágenes JPEG, PNG o GIF.");
        return false;
    }
    else{
        move_uploaded_file($_FILES['cargar-imagen']['tmp_name'],$archivo); //tmp_name es la ruta temporal en el servidor donde esta almacenada
        return $_FILES['cargar-imagen']['name'];
    }
}

?>
