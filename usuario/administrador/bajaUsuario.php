<?php
//Conexión a la base de datos
require "../../conexion/conexion.php";

// Verifica que se haya pasado el Id a través de GET
if (isset($_GET['Id'])) {
    $Id = $_GET['Id'];

    //Crea la consulta SQL para eliminar el usuario con el Id dado utilizando sentencias preparadas
    $sql = "DELETE FROM usuario WHERE Id = ?";

    //Prepara la consulta
    if ($stmt = $conexion->prepare($sql)) {
        //Vincular el parámetro (en este caso un entero) a la consulta
        $stmt->bind_param("i", $Id);

        //Ejecuta la consulta
        if ($stmt->execute()) {
            //Redirige al administrador a la página de gestión después de la eliminación
            header("Location: gestionDeClientes.php");
            exit();
        } else {
            echo "Error al eliminar usuario: " . $stmt->error;
        }

        //cierra la sentencia preparada
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }

} else {
    echo "No se ha proporcionado un Id.";
}

//Cierra la conexión a la base de datos
$conexion->close();
?>