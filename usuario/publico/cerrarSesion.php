<?php
// Iniciar sesión
session_start();

// Eliminar la sesión
session_unset();
session_destroy();

// Redirigir al usuario a la página principal
header("Location: ../../index.php");
exit();
?>
