<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!--Iconos FontAwesome-->
    <script src="https://kit.fontawesome.com/c570243db9.js" crossorigin="anonymous"></script>
    <!-- Archivo estilos personalizados -->
    <link rel="stylesheet" type="text/css" href="/../css/estiloRegistro.css">
    <!-- Icono para la pestaña de la página en el navegador -->
    <link rel="shortcut icon" href="../recursos/icon/favicon.ico" type="image/x-icon">
    <title>Registro de Usuario | Casa del Sol</title>
</head>
<body>

    <!-- Título y descripción-->
    <div class="container color-naranja contenedor formulario-contenedor mb-5 mt-5 p-4 col-xl-w-50 col bg col-md-5 col-lg-5 col-xl-6">
        <h1 class="fw-bold texto-naranja text-center mb-2">Crear Cuenta</h1>
        <p class="text-center text-muted">Proporciona la siguiente información para registrarte.</p>
        <hr>

        <!-- Formulario -->
        <form id="formulario-registro" action="registroUsuario.php" method="post" onsubmit="return validarContraseña()" class="needs-validation">

            <!-- Nombre y Apellido -->
            <div class="row g-3 ">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre(s):</label>
                    <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label for="apellido" class="form-label">Apellido(s):</label>
                    <input type="text" id="apellido" name="apellido" class="form-control form-control-sm" required>
                </div>
            </div>

            <!-- Género -->
            <div class="mb-3 mt-2">
                <label class="form-label">Género:</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="genero" id="masculino" value="Masculino" required>
                        <label class="form-check-label" for="masculino">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="genero" id="femenino" value="Femenino" required>
                        <label class="form-check-label" for="femenino">Femenino</label>
                    </div>
                </div>
            </div>

            <!-- Intereses -->
            <div class="mb-3">
                <label class="form-label">Intereses:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="accesorios" value="Accesorios">
                    <label class="form-check-label" for="accesorios">Joyería y accesorios</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="decoracion" value="Decoración">
                    <label class="form-check-label" for="decoracion">Decoración para el hogar</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="textiles" value="Textiles">
                    <label class="form-check-label" for="textiles">Ropa y textiles</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="madera" value="Madera">
                    <label class="form-check-label" for="madera">Arte en madera</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="intereses[]" id="ceramica" value="Cerámica">
                    <label class="form-check-label" for="ceramica">Cerámica y alfarería</label>
                </div>
            </div>

            <!-- Edad -->
            <div class="mb-3">
                <label for="edad" class="form-label">Edad:</label>
                <select id="edad" name="edad" class="form-select" required>
                    <option value="" selected disabled>Seleccionar</option>
                    <option value="18-24">18 a 24 años</option>
                    <option value="25-34">25 a 34 años</option>
                    <option value="35-44">35 a 44 años</option>
                    <option value="45">Más de 44 años</option>
                </select>
            </div>

            <!-- Dirección -->
            <h4 class="texto-naranja">Dirección</h4>
            <div class="row g-3">
                <!-- Calle y Cruzamientos -->
                <div class="col-md-6">
                    <label for="calle" class="form-label">Calle:</label>
                    <input type="text" id="calle" name="calle" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label for="cruzamientos" class="form-label">Cruzamientos:</label>
                    <input type="text" id="cruzamientos" name="cruzamientos" class="form-control form-control-sm" required>
                </div>
                <!-- Ciudad y Código Postal -->
                <div class="col-md-6">
                    <label for="ciudad" class="form-label">Ciudad:</label>
                    <input type="text" id="ciudad" name="ciudad" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="codigoPostal" class="form-label">CP:</label>
                    <input type="text" id="codigoPostal" name="codigoPostal" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label for="numeroDeCasa" class="form-label">No. Casa:</label>
                    <input type="text" id="numeroDeCasa" name="numeroDeCasa" class="form-control form-control-sm" required>
                </div>
            </div>

            <!--Contacto-->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correoElectronico" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control form-control-sm" required>
                </div>
            </div>

            <!--Contraseña-->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="contrasenia" class="form-label">Contraseña:</label>
                    <input type="password" id="contrasenia" name="contrasenia" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label for="confirmacionDeContrasenia" class="form-label">Repetir Contraseña:</label>
                    <input type="password" id="confirmacionDeContrasenia" name="confirmacionDeContrasenia" class="form-control form-control-sm" required>
                </div>
            </div>

            <!-- Administrador -->
            <div class="mb-3 mt-4">
                <label class="form-label">¿Eres administrador?</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="administrador" id="si" value="Si" onchange="mostrarCampoClaveAdministrador()" required>
                        <label class="form-check-label" for="si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="administrador" id="no" value="No" onchange="mostrarCampoClaveAdministrador()" required>
                        <label class="form-check-label" for="no">No</label>
                    </div>
                </div>
            </div>
        <div class="mb-3 noVisible" id="campo-administrador" style="display: none;">
            <label for="claveDeAdministrador" class="form-label">Código de administrador:</label>
            <input type="password" id="claveDeAdministrador" name="claveDeAdministrador" class="form-control form-control-sm">
        </div>

            <!-- Botón -->
            <div class="text-center">
                <button type="submit" class="btn boton-personalizado btn-lg">Registrarme</button>
            </div>
            <div class="text-center mt-5">
                <a href="inicioDeSesion.php" class="btn btn-outline-dark">Iniciar Sesión</a>
                <a href="../../index.php" class="btn btn-outline-danger">Cancelar</a>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <?php include '../../componentes/footer.php'; ?>

        <script>
            // Función para mostrar el campo que solicita al usuario la clave de administrador cuando éste ha indicado que lo es
            function mostrarCampoClaveAdministrador() {
            const campoAdministrador = document.getElementById('campo-administrador');
            const esAdministrador = document.getElementById('si');

            if (esAdministrador.checked) {
                campoAdministrador.style.display = "block"; // Mostrar el campo
            } else {
                campoAdministrador.style.display = "none"; // Ocultar el campo
            }
            }

            
            // Función para validar si las contraseñas coinciden
            function validarContraseña() {
                // Obtener el valor de la contraseña y la confirmación de contraseña
                var contrasenia = document.forms["formulario-registro"]["contrasenia"].value;
                var confirmacionDeContrasenia = document.forms["formulario-registro"]["confirmacionDeContrasenia"].value;
                
                //Si las contraseñas son diferentes
                if (contrasenia !== confirmacionDeContrasenia) {
                    alert("Las contraseñas no coinciden. Inténtalo de nuevo.");
                    return false; // Evitar que se envíe el formulario
                }

                return true; // Permitir el envío del formulario
            }

            // Función para validar si las contraseñas de administrador coinciden
            function validarContraseña() {
                // Obtener el valor de la contraseña y la confirmación de contraseña
                var claveAdministrador = document.forms["formulario-registro"]["claveDeAdministrador"].value;
                var confirmarClaveAdministrador = admin2024;
                
                //Si las contraseñas son diferentes
                if (claveAdministrador !== confirmarClaveAdministrador) {
                    alert("Introduce la clave correcta de administrador. Inténtalo de nuevo.");
                    return false; // Evitar que se envíe el formulario
                }

                return true; // Permitir el envío del formulario
            }

        </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>