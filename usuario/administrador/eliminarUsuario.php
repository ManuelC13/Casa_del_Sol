<?php
//Verifica si se ha enviado el ID
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    //Conectarse a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "db_casa_del_sol");

    //Verifica la conexión
    if (!$conexion) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión']);
        exit;
    }

    //Realiza la consulta para eliminar al usuario
    $consulta = "DELETE FROM usuario WHERE Id = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el usuario']);
    }

    //Cerrar la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
}
?>
