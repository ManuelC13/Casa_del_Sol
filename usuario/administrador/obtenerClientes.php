<?php

//Conexión a la base de datos en un servidor remoto
require '../../conexion/conexion.php';

//Verifica la conexión
if($conexion){
    $consulta = "SELECT * FROM usuario";
    $datos = $conexion->query($consulta);

    //Verifica si hay resultados
    if($datos->num_rows > 0){
        $contador = 0;

        //Imprime los datos en la tabla
        while($fila = $datos->fetch_assoc()){
            $idTabla = $contador+=1;
            $idCliente = $fila['Id'];
            $nombre = $fila['Nombre'];
            $apellido = $fila['Apellido'];
            $edad = $fila['Edad'];
            $fechaRegistro = $fila['FechaRegistro'];
            $rol = $fila['Rol'];

            //Asigna el nombre del rol basado en el RolId
            switch ($rol) {
                case 0:
                    $rol = "Usuario";
                    break;
                case 1:
                    $rol = "Administrador";
                    break;
                default:
                    $rol = "Desconocido"; //En caso de que no coincida con ningún valor
                    break;
            }
?>
            <tr style="width: 680px" onclick="usuarioSeleccionado(event, '<?=$idCliente?>')" data-id="<?=$idCliente?>">
                <td style="width: 25px"><?= $idTabla ?></td>
                <td style="width: 25px"><?= $idCliente ?></td>
                <td style="width: 250px"><?= $nombre ?></a></td>
                <td style="width: 250px"><?= $apellido ?></td>
                <td style="width: 100px"><?= $edad ?></td>
                <td style="width: 250px"><?= $fechaRegistro ?></td>
                <td style="width: 25px"><?= $rol ?></td>
            </tr>
<?php
        }
    }
    //Cierra la conexión a la base de datos
    $conexion->close();
} else {
    //Imprime un mensaje si no se encontraron datos
    echo "<tr><td colspan='6'>No se encontraron datos</td></tr>";
}
?>