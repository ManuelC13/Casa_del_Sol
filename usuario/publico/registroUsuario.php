<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require("../../conexion/conexion.php");
        session_start();

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
        $confirmacionContrasenia = $_POST['confirmacionDeContrasenia'];
        $esAdministrador = isset($_POST['administrador']) ? $_POST['administrador'] : '';
        $claveProporcionada= $_POST['claveDeAdministrador'];

        // Recuperar datos de su dirección
        $calle = $_POST['calle'];
        $cruzamientos = $_POST['cruzamientos'];
        $ciudad = $_POST['ciudad'];
        $codigoPostal = $_POST['codigoPostal'];
        $numeroDeCasa = $_POST['numeroDeCasa'];

        $claveAdministrador = 'admin2024';

        // Generar un ID único para el usuario
        $idUsuario = substr(uniqid(true),0,8);
    
        if ($genero == 'Masculino') {
            $genero = 'M';
        } else if ($genero == 'Femenino') {
            $genero = 'F';
        }

        if($esAdministrador === 'Si') {
            if ($claveProporcionada !== $claveAdministrador) { // Validar que la clave de administrador proporcionada sea correcta
                //echo "<p>ERROR: La clave de administrador proporcionada es incorrecta.</p>";
                $_SESSION['messageRegistrar'] = "La clave de administrador es incorrecta: " . $conexion->error;
                $_SESSION['message_type'] = "danger"; // Tipo de mensaje
                header("Location: inicioDeSesion.php");
                exit();
                

            } else {
                $siEsAdministrador = 1;

                $sql_usuario = "INSERT INTO usuario (Id, Nombre, Apellido, Genero, Email, Telefono, Edad, Contrasenia, Intereses, Rol) VALUES ('$idUsuario', '$nombre', '$apellido', '$genero', '$correoElectronico', '$telefono', '$edad', '$contrasenia', '$listaIntereses', '$siEsAdministrador')";
                $sql_direccion = "INSERT INTO direccion (UsuarioId, Calle, CodigoPostal, NumeroCasa, Cruzamiento, Ciudad) VALUES ('$idUsuario', '$calle', '$codigoPostal', '$numeroDeCasa', '$cruzamientos', '$ciudad')";

                if ($conexion->query($sql_usuario) === TRUE and $conexion->query($sql_direccion) === TRUE) {
                    $_SESSION['messageRegistrar'] = "Has sido registrado exitosamente.";
                    $_SESSION['message_type'] = "success"; //Tipo de mensaje
    
                    //echo "<p class='linke'><a href='inicioDeSesion.html'>Iniciar sesión</a></p>";
                } else {
                    //echo "Error al registrar el usuario: " . $conn->error;
                    $_SESSION['messageRegistrar'] = "Hubo un error en tu registro: " . $conexion->error;
                    $_SESSION['message_type'] = "danger"; // Tipo de mensaje
                }
            }

        } else {
            $siEsAdministrador = 0;

            $registrarUsuario = "INSERT INTO usuario (Id, Nombre, Apellido, Genero, Email, Telefono, Edad, Contrasenia, Intereses, Rol) VALUES ('$idUsuario', '$nombre', '$apellido', '$genero', '$correoElectronico', '$telefono', '$edad', '$contrasenia', '$listaIntereses', '$siEsAdministrador')";
            $registrarDireccion = "INSERT INTO direccion (UsuarioId, Calle, CodigoPostal, NumeroCasa, Cruzamiento, Ciudad) VALUES ('$idUsuario', '$calle', '$codigoPostal', '$numeroDeCasa', '$cruzamientos', '$ciudad')";

            if ($conexion->query($registrarUsuario) === TRUE and $conexion->query($registrarDireccion) === TRUE) {
                //echo "<h1>Registro exitoso</h1>";
                //echo "<p class='linke'><a href='inicioDeSesion.html'>Iniciar sesión</a></p>";
                $_SESSION['messageRegistrar'] = "Has sido registrado exitosamente.";
                $_SESSION['message_type'] = "success"; //Tipo de mensaje
            } else {
                //echo "Error al registrar el usuario: " . $conexion->error;
                $_SESSION['messageRegistrar'] = "Hubo un error en tu registro: " . $conexion->error;
                $_SESSION['message_type'] = "danger"; // Tipo de mensaje
            }
        }

        $conexion->close();
        //Redirige a la página de nuevoProducto.php
        header("Location: inicioDeSesion.php");
        exit();
    
    ?>
</body>
</html>