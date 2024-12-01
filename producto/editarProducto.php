<?php
// Conexión a la base de datos
require "../conexion/conexion.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Obtiene los datos del formulario
    $sku = $_POST['sku'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $descripcion = $_POST['descripcion'];
    $fecha_registro = $_POST['fecha-registro'];
    $foto = subirFoto();
    
    // Si no se sube una nueva foto, se utiliza la foto temporal
    if ($foto === null) {
        $foto = $_POST['fotoTemporal'];
    }

    $sql = "UPDATE producto SET Descripcion = '$descripcion', Stock = '$cantidad', Precio = '$precio', IdCategoria = '$categoria', Imagen = '$foto' WHERE Sku = '$sku'";

    //Ejecuta la consulta
    if ($conexion->query($sql) === TRUE) {
        $_SESSION['messageActualizar'] = "Producto actualizado exitosamente.";
        $_SESSION['message_type'] = "success"; //Tipo de mensaje
    } else {
        $_SESSION['messageActualizar'] = "Error al actualizar el producto: " . $conexion->error;
        $_SESSION['message_type'] = "danger"; // Tipo de mensaje
    }
    
    //Cierra la conexión
    $conexion->close();

    //Redirige a la página de nuevoProducto.php
    header("Location: ../usuario/administrador/gestionProductos.php");
    exit();
}

function subirFoto() {
    // Verifica si se ha enviado un archivo
    if (isset($_FILES['cargar-imagen-actualizar']) && $_FILES['cargar-imagen-actualizar']['error'] === 0) {
        // Obtiene la imagen
        $imagen = $_FILES['cargar-imagen-actualizar'];

        //Define una carpeta donde se guardarán las imágenes
        $carpetaAlmacenamiento = __DIR__.'/imgProductos/';

        //Obtiene el nombre del archivo
        $archivo = $carpetaAlmacenamiento.$imagen['name'];

        // Obtiene el tipo de archivo
        $tipoImagen = $imagen['type'];

        // Valida que sea una imagen JPEG, PNG o GIF
        $extensionesPermitidas = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($tipoImagen, $extensionesPermitidas)) {
            die("Solo se permiten imágenes JPEG, PNG o GIF.");
            return false;
        } else {
            move_uploaded_file($imagen['tmp_name'], $archivo); // Mueve la imagen a la carpeta
            return $imagen['name']; // Devuelve el nombre del archivo cargado
        }
    }
    return null; // Si no se ha enviado imagen, devuelve null
}

?>
