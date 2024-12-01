<?php
include '../conexion/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Categoría</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body class="container mt-5">

    <h1 class="text-center">Seleccione una Categoría</h1>

    <form action="reporteProductos.php" method="GET" class="mt-4">
        <input type="hidden" name="tipo" value="categoria">
        <div class="form-group">
            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" class="form-control" required>
                <option value="" disabled selected>Seleccione una categoría</option>
                <?php
                $consulta = $conexion->query("SELECT Id, Nombre FROM categoria");
                while ($categoria = $consulta->fetch_assoc()) {
                    echo "<option value='{$categoria['Id']}'>{$categoria['Nombre']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3"><i class="fa-regular fa-file-pdf"></i>  Generar Reporte</button>
    </form>
</body>
</html>
