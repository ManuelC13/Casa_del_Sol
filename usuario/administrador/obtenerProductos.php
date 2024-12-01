<?php

//Conexión a la base de datos en un servidor remoto
require '../../conexion/conexion.php';

//Verifica la conexión
if($conexion){
    $consulta = "SELECT * FROM producto";
    $datos = $conexion->query($consulta);

    //Verifica si hay resultados
    if($datos->num_rows > 0){
        $contador = 0;

        //Imprime los datos en la tabla
        while($fila = $datos->fetch_assoc()){
            $idTabla = $contador+=1;
            $sku = $fila['Sku'];
            $nombre = $fila['Nombre'];
            $descripcion = $fila['Descripcion'];
            $Stock = $fila['Stock'];
            $precio = $fila['Precio'];
            $categoria = $fila['IdCategoria'];
            $imagen = $fila['Imagen'];

            //Asigna el nombre del rol basado en el RolId
            switch ($categoria) {
                case 1:
                    $categoria = "Joyería";
                    break;
                case 2:
                    $categoria = "Hogar";
                    break;
                case 3:
                    $categoria = "Textiles";
                    break;
                case 4:
                    $categoria = "Madera";
                    break;
                case 5:
                    $categoria = "Cerámica";
                    break;
                default:
                    $categoria = "Desconocido"; //En caso de que no coincida con ningún valor
                    break;
            }
?>
            <tr style="width: 680px" onclick="productoSeleccionado(event, '<?=$sku?>')" data-id="<?=$sku?>">
                <td style="width: 30px"><?= $idTabla ?></td>
                <td style="width: 30px"><?= $sku ?></td>
                <td style="width: 200px"><?= $nombre ?></a></td>
                <td style="width: 300px"><?= $descripcion ?></td>
                <td style="width: 50px"><?= $Stock ?></td>
                <td style="width: 30px"><?= $precio ?></td>
                <td style="width: 200px"><?= $categoria ?></td>
                <td class="text-center" style="width: 100px">
                <?php
                    $foto = '../../producto/imgProductos/'.$imagen;
                    if(file_exists($foto)){
                ?>
                <img src="<?php print $foto; ?>" width="100px" height="70px">
                <?php } else {?>
                    Sin foto
                <?php } ?>
                </td>
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