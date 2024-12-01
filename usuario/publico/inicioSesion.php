<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../login.css">
	<title>Inicio de Sesión</title>
</head>
<body>

    <?php
	//Iniciar sesión
	session_start();
	
	require("../../conexion/conexion.php");
	//Recuperar datos del formulario
	$correoElectronico = $_POST['correoElectronico'];
	$contrasenia = $_POST['contrasenia'];

	//Consulta SQL para verificar el inicio de sesión
	$sql = "SELECT * FROM usuario WHERE Email = '$correoElectronico' AND Contrasenia = '$contrasenia'";
	$result = $conexion->query($sql);


	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc(); //Obtener la fila del resultado de la consulta
		$rol = $row['Rol']; //Obtener el rol del usuario
		$idUsuario = $row['Id']; // Obtener el ID del usuario


		// Guardar el correo electrónico y el ID del usuario en la sesión
		$_SESSION['usuario'] = $correoElectronico;
		$_SESSION['idUsuario'] = $idUsuario;
		$_SESSION['rol'] = $rol;
	

		//Si el rol es 1 signifca que es adminsitrador
		if($rol == 1) {
			header("Location: ../administrador/menuDeAdministracion.php");
			exit();
		}

		//Si el rol es 2 signifca que es usuario
		else{
			//Inicio de sesión exitoso
			$_SESSION['usuario'] = $correoElectronico;


			// Se carga revisa si hay una cookie asociada al carrito del usuario que ingresó
			if (isset($_COOKIE['carrito_usuario_' . $idUsuario])) {
				$carritoGuardado = json_decode($_COOKIE['carrito_usuario_' . $idUsuario], true);
				$_SESSION['carritos'][$correoElectronico] = $carritoGuardado;
			}
			

			header("Location: ../../index.php");
			exit();
		}
	} else {
		//Inicio de sesión fallido
		$_SESSION['messageLogin'] = 'Error: Usuario o contraseña incorrectos o inexistentes.';
		$_SESSION['alertClass'] = 'danger';
		header("Location: inicioDeSesion.php");
	}

	$conexion->close();
	?>
</body>
</html>