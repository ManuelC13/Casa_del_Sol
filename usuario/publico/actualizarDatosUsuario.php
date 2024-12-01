<?php
session_start();

require_once '../../conexion/conexion.php';

if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../../usuario/publico/inicioDeSesion.php");
    exit;
}

// Recuperar datos del usuario del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$genero = isset($_POST['genero']) ? $_POST['genero'] : '';
$intereses = isset($_POST['intereses']) ? $_POST['intereses'] : [];
$listaIntereses = implode(",", $intereses); // Se guardarán separados por comas
$edad= $_POST['edad'];
$correoElectronico = $_POST['correoElectronico'];
$telefono = $_POST['telefono'];
$contrasenia = $_POST['contrasenia'];

// Recuperar el ID del usuario desde la sesión
$idUsuario = $_SESSION['idUsuario'];

// Recuperar datos de su dirección
$calle = $_POST['calle'];
$cruzamientos = $_POST['cruzamientos'];
$ciudad = $_POST['ciudad'];
$codigoPostal = $_POST['codigoPostal'];
$numeroDeCasa = $_POST['numeroDeCasa'];

if ($genero == 'Masculino') {
    $genero = 'M';
} else if ($genero == 'Femenino') {
    $genero = 'F';
}

    $registrarUsuario = "UPDATE usuario SET Nombre = '$nombre', Apellido = '$apellido', Genero = '$genero', Email = '$correoElectronico', Telefono = '$telefono', Edad = '$edad', Contrasenia = '$contrasenia', Intereses = '$listaIntereses' WHERE Id = '$idUsuario'";
    $registrarDireccion = "UPDATE direccion SET Calle = '$calle', CodigoPostal = '$codigoPostal', NumeroCasa = '$numeroDeCasa', Cruzamiento = '$cruzamientos', Ciudad = '$ciudad' WHERE UsuarioId = '$idUsuario'";


    if ($conexion->query($registrarUsuario) === TRUE and $conexion->query($registrarDireccion) === TRUE) {
        //echo "<h1>Registro exitoso</h1>";
        //echo "<p class='linke'><a href='inicioDeSesion.html'>Iniciar sesión</a></p>";
        $_SESSION['messageRegistrar'] = "Tus datos han sido actualizados, inicia sesion nuevamente para validar los cambios.";
        $_SESSION['message_type'] = "success"; //Tipo de mensaje
    } else {
        //echo "Error al registrar el usuario: " . $conexion->error;
        $_SESSION['messageRegistrar'] = "Hubo al actualizar los datos: " . $conexion->error;
        $_SESSION['message_type'] = "danger"; // Tipo de mensaje
    }

$conexion->close();
//Redirige a la página de nuevoProducto.php
header("Location: inicioDeSesion.php");
exit();
?>