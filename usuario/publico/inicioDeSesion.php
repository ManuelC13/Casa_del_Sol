    <!-- Mostrar el mensaje de exito de registro si existe cuando se registra un usuario-->
    <?php
        session_start();

        if (isset($_SESSION['messageRegistrar'])) {
            $message = $_SESSION['messageRegistrar'];
            $alertClass = strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-success';
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    const modal = new bootstrap.Modal(document.getElementById('resultadoModalRegistro'));
                    document.getElementById('resultadoMensaje').innerHTML = '<div class=\"alert $alertClass\">$message</div>';
                    modal.show();
                });
            </script>";
            unset($_SESSION['messageRegistrar']); //Limpia el mensaje después de mostrarlo
        }
    ?>
<?php

//Mostrar el mensaje de error si existe
if (isset($_SESSION['messageLogin'])) {
    $message = $_SESSION['messageLogin'];
    $alertClass = $_SESSION['alertClass'] !== false ? 'alert-danger' : 'alert-success';
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = new bootstrap.Modal(document.getElementById('resultadoModalRegistro'));
            document.getElementById('resultadoMensaje').innerHTML = '<div class=\"alert $alertClass\">$message</div>';
            modal.show();
        });
    </script>";
    unset($_SESSION['messageLogin']); //Limpiar el mensaje después de mostrarlo
    unset($_SESSION['alertClass']); //Limpiar la clase de alerta
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Iconos FontAwesome-->
    <script src="https://kit.fontawesome.com/c570243db9.js" crossorigin="anonymous"></script>
    <!-- Archivo estilos personalizados -->
    <link rel="stylesheet" type="text/css" href="/../css/index.css">
    <!-- Icono para la pestaña de la página en el navegador -->
    <link rel="shortcut icon" href="/../recursos/icon/favicon.ico" type="image/x-icon">
    <title>Inicio de Sesión | Casa del Sol</title>
    <!--Estilos-->
    <style>
        
        .bg{
            background-image: url("../../recursos/imagenes/logoLogin.png");
            background-position:center center;
        }

        .Rent {
        width: 80%;
        }
    </style>

</head>
<body>
    <section class="min-vh-100 d-flex justify-content-center align-items-center">

        <!-- Modal de mensaje de exito cuando se registra un nuevo usuario -->
        <div class="modal fade" id="resultadoModalRegistro" tabindex="-1" aria-labelledby="resultadoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultadoModalLabel">Resultado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="resultadoMensaje">
                        <!-- Aquí se mostrará el mensaje -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container w-50 mt-5 rounded shadow mb-5">
            <div class="row align-items-stretch shadow">
                <div class="col bg d-none d-lg-block col-md-5 col-lg-5 col-xl-6 rounded">
                    <!--IMAGEN DE LA PRESENTACIÓN DEL FORMULARIO-->
                </div>

                <!--Formulario-->
                <div class="col p-2 rounded-end shadow" style="background-color:#fdfefe ;">

                    <!--Logo esquina superior-->
                    <div class="text-end">
                        <img src="/../recursos/logoSol/logoSol.png" width="60" alt="">
                    </div>

                    <h2 class="fw-bold text-center mb-2 ">Iniciar Sesión</h2>

                    <!--Datos del login-->
                    <form id="inicioDeSesion" action="inicioSesion.php" method="post">
                        <div class="container pt-3">
                            <div class="mb-2">
                                <label for="correoElectronico" class="form-label">Correo Electrónico:</label>
                                <input type="email" id="correoElectronico" class="form-control form-control-sm" name="correoElectronico" required>
                            </div>
                            <div class="mb-2">
                                <label for="contrasenia" class="form-label">Contraseña:</label>
                                <input type="password" id="contrasenia" class="form-control form-control-sm" name="contrasenia" required>
                            </div>
                        </div>
                        <!--Botón para enviar el formulario-->
                        <div class="mb-2 my-4 text-center">
                            <button type="submit" class="btn boton-personalizado fw-bold text-white">Iniciar sesión</button>
                        </div>

                        <div class="my-3">
                            <p class="text-center">
                                ¿Aún no tienes una cuenta?
                                <p class="text-center">
                                    <a href='registroDeUsuario.php' class="btn btn-outline-dark">Regístrate</a>
                                    <a href='../../index.php' class="btn btn-outline-danger">Cancelar</a>
                                </p>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include '../../componentes/footer.php'; ?>

        <!--JavaScript de Bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>