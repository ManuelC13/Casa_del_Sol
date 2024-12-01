<?php
// Conexión a la base de datos en un servidor remoto
require '../../conexion/conexion.php';

// Verifica la conexión
if ($conexion) {
    // Consulta SQL mejorada
    $consulta = "
        SELECT 
            c.id AS idVenta,                                    -- ID de la venta
            CONCAT(u.Nombre, ' ', u.Apellido) AS nombreUsuario,  -- Nombre completo del usuario
            GROUP_CONCAT(p.Nombre SEPARATOR ', ') AS productos,  -- Lista de productos comprados en una sola cadena
            SUM(dc.cantidad * dc.precio) AS totalVenta,          -- Total de la venta (cantidad * precio de cada producto)
            c.fecha AS fechaVenta                                -- Fecha en la que se realizó la venta
        FROM 
            compras c                                            -- Tabla de compras
        JOIN 
            usuario u ON c.usuario_id = u.Id                     -- Relación con la tabla de usuarios
        JOIN 
            detalle_compras dc ON c.id = dc.compra_id            -- Relación con la tabla detalle_compras
        JOIN 
            producto p ON dc.sku = p.Sku                         -- Relación con la tabla de productos
        GROUP BY 
            c.id, u.Nombre, u.Apellido, c.fecha                  -- Agrupa por ID de la venta, nombre de usuario y fecha de compra
        ORDER BY 
            c.fecha DESC;                                        -- Ordena los resultados por la fecha de venta de forma descendente

    ";

    $datos = $conexion->query($consulta);

    //Verifica si hay resultados
    if ($datos->num_rows > 0) {
        $contador = 0;

        //Imprime los datos en la tabla
        while ($fila = $datos->fetch_assoc()) {
            $idTabla = ++$contador;
            $idVenta = $fila['idVenta'];
            $nombreUsuario = $fila['nombreUsuario'];
            $productos = $fila['productos'];
            $totalVenta = number_format($fila['totalVenta'], 2); //Formato de dos decimales
            $fechaVenta = $fila['fechaVenta'];
?>
            <tr>
                <td style="width: 60px"><?= $idTabla ?></td>
                <td style="width: 30px"><?= $idVenta ?></td>
                <td style="width: 200px"><?= $nombreUsuario ?></td>
                <td style="width: 400px"><?= $productos ?></td>
                <td style="width: 200px">$<?= $totalVenta ?></td>
                <td style="width: 300px"><?= $fechaVenta ?></td>
            </tr>
<?php
        }
    } else {
        //Imprime un mensaje si no se encontraron datos
        echo "<tr><td colspan='6'>No se encontraron datos</td></tr>";
    }

    // Cierra la conexión a la base de datos
    $conexion->close();
} else {
    echo "<tr><td colspan='6'>Error en la conexión a la base de datos</td></tr>";
}
?>
