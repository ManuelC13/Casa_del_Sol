<?php

require('./fpdf.php');
include '../conexion/conexion.php';

class PDF extends FPDF
{
    function Header()
    {
        include '../conexion/conexion.php'; //llamamos a la conexion BD

        $consulta_info = $conexion->query(" select *from producto"); //traemos datos de la empresa desde BD
        $dato_info = $consulta_info->fetch_object();
        $this->Image('logo.png', 10, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
        $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(45); // Movernos a la derecha
        $this->SetTextColor(0, 0, 0); //color
        
        //creamos una celda o fila
        $this->Cell(110, 15, utf8_decode('Casa del Sol'), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
        $this->Ln(3); // Salto de línea
        $this->SetTextColor(103); //color

        /* TELEFONO */
        $this->Cell(80);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(59, 10, utf8_decode("Teléfono : 9861139975"), 0, 0, '', 0);
        $this->Ln(5);

        /* COREEO */
        $this->Cell(70);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(85, 10, utf8_decode("Correo : casaDelSol@gmail.com"), 0, 0, '', 0);
        $this->Ln(10);


        /* TITULO DE LA TABLA */
        //color
        $this->SetTextColor(0, 95, 189);
        $this->Cell(50); // mover a la derecha
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(100, 10, utf8_decode("REPORTE DE PRODUCTOS"), 0, 1, 'C', 0);
        $this->Ln(7);
    }

    function Footer()
    {
        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
        $hoy = date('d/m/Y');
        $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163);

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'default';
$IdCategoria = isset($_GET['categoria']) ? $_GET['categoria'] : null;

// Generar reporte según el tipo de reporte
switch ($tipo) {
    case 'categoria':
        if (isset($IdCategoria) && !empty($IdCategoria)) {
            // Encabezados
            $headers = ['N°', 'Nombre', 'Precio', 'Descripción'];
    
            // Consulta para obtener los productos de la categoría
            $consulta = "SELECT producto.Sku, producto.Nombre, producto.Precio, producto.Descripcion, producto.Stock
                        FROM producto
                        WHERE IdCategoria = $IdCategoria";
    
            // Consulta para obtener el nombre de la categoría
            $consultaCategoria = $conexion->query("SELECT Nombre FROM categoria WHERE Id = $IdCategoria");
            $nombreCategoria = $consultaCategoria->fetch_assoc()['Nombre'];
    
            $titulo = "Categoría: $nombreCategoria";
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(0, 10, utf8_decode($titulo), 0, 1, 'C');
            $pdf->Ln(5);
    
            // Encabezados de la tabla
            $pdf->SetFillColor(125, 173, 221); // Fondo
            $pdf->SetTextColor(0, 0, 0); // Texto
            $pdf->SetDrawColor(163, 163, 163); // Bordes
            $pdf->SetFont('Arial', 'B', 11);

            $pdf->Cell(10, 10, utf8_decode('N°'), 1, 0, 'C', 1);
            $pdf->Cell(30,10, utf8_decode('Sku'), 1, 0, 'C', 1);
            $pdf->Cell(40, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
            $pdf->Cell(30, 10, utf8_decode('Precio'), 1, 0, 'C', 1);
            $pdf->Cell(15, 10, utf8_decode('Stock'), 1, 0, 'C', 1);
            $pdf->Cell(65, 10, utf8_decode('Descripción'), 1, 0, 'C', 1);
            //$pdf->Cell(20, 10, utf8_decode('Stock'), 1, 0, 'C', 1);

            
            $pdf->Ln(); // Salto de línea después de los encabezados
    
            // Consulta para obtener los productos
            $resultado = $conexion->query($consulta);
    
            // Validar que existan resultados
            if ($resultado->num_rows > 0) {
                $i = 0;
                $pdf->SetFont('Arial', '', 12);
    
                // Iterar sobre los productos
                while ($producto = $resultado->fetch_object()) {
                    $i++;

    // Calcular la altura necesaria para la descripción
    $descripcion = utf8_decode($producto->Descripcion);
    $alturaDescripcion = getMultiCellHeight($pdf, 65, 5, $descripcion);

    // Determinar la altura máxima para toda la fila
    $alturaMaxima = max(10, $alturaDescripcion);

    // Imprimir las celdas con la misma altura
    $pdf->Cell(10, $alturaMaxima, $i, 1, 0, 'C'); // Número
    $pdf->Cell(30, $alturaMaxima, utf8_decode($producto->Sku), 1, 0, 'C'); // Sku
    $pdf->Cell(40, $alturaMaxima, utf8_decode($producto->Nombre), 1, 0, 'C'); // Nombre
    $pdf->Cell(30, $alturaMaxima, number_format($producto->Precio, 2), 1, 0, 'C'); // Precio
    $pdf->Cell(15, $alturaMaxima, number_format($producto->Stock, 2), 1, 0, 'C'); // Stock

    // Guardar posición X e Y antes de MultiCell
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Imprimir MultiCell para la descripción
    $pdf->MultiCell(65, 5, $descripcion, 1, 'L');

    // Establecer posición al final de la celda de MultiCell
    $pdf->SetXY($x + 65, $y);

    // Salto a la siguiente línea
    $pdf->Ln($alturaMaxima);
                    
                }
            } else {
                // Si no hay productos en la categoría
                $pdf->Cell(0, 10, utf8_decode("No hay productos en la categoría seleccionada."), 1, 1, 'C');
            }
        } else {
            die("Error: No se ha seleccionado una categoría.");
        }
    break;

        // case 'masVendidos':
        //     // Consulta para calcular los productos más vendidos
        //     $consulta = "
        //             SELECT 
        //                 producto.Nombre,
        //                 SUM(detalle_compras.Cantidad) AS Ventas
        //             FROM 
        //                 detalle_compras
        //             JOIN 
        //                 producto ON detalle_compras.sku = producto.Sku
        //             GROUP BY 
        //                 detalle_compras.sku
        //             ORDER BY 
        //                 Ventas DESC
        //             LIMIT 10";

        //     $titulo = "Productos Más Vendidos";
        //     $headers = ['Producto', 'Ventas'];

        //     // Añadimos encabezado del reporte
        //     $pdf->SetFont('Arial', 'B', 12);
        //     $pdf->Cell(0, 10, utf8_decode($titulo), 0, 1, 'C');
        //     $pdf->Ln(5);

        //     // Encabezados de la tabla
        //     $pdf->SetFillColor(125, 173, 221); // Fondo
        //     $pdf->SetTextColor(0, 0, 0); // Texto
        //     $pdf->SetDrawColor(163, 163, 163); // Bordes
        //     $pdf->SetFont('Arial', 'B', 11);

        //     $pdf->Cell(80, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
        //     $pdf->Cell(40, 10, utf8_decode('Ventas'), 1, 0, 'C', 1);
        //     $pdf->Ln(); // Salto de línea después de los encabezados

        //     // Ejecutamos la consulta
        //     $resultado = $conexion->query($consulta);

        //     if ($resultado->num_rows > 0) {
        //         $pdf->SetFont('Arial', '', 12);

        //         // Iteramos sobre los resultados
        //         while ($row = $resultado->fetch_assoc()) {
        //             $pdf->Cell(40, 10, $row['Ventas'], 1, 1, 'C');
        //             $pdf->Cell(80, 10, utf8_decode($row['Nombre']), 1, 0, 'C');
        //             $pdf->Cell(40, 10, $row['Ventas'], 1, 1, 'C');
        //         }
        //     } else {
        //         // Si no hay productos vendidos
        //         $pdf->Cell(0, 10, utf8_decode("No se encontraron productos vendidos."), 1, 1, 'C');
        //     }
        //     break;

    case 'masVendidos':
        // Consulta para calcular los productos más vendidos
        $consulta = "
            SELECT 
                producto.Nombre,
                SUM(detalle_compras.Cantidad) AS Ventas
            FROM 
                detalle_compras
            JOIN 
                producto ON detalle_compras.sku = producto.Sku
            GROUP BY 
                detalle_compras.sku
            ORDER BY 
                Ventas DESC
            LIMIT 10";

        $titulo = "Productos Más Vendidos";
        $headers = ['#', 'Producto', 'Ventas'];

        // Añadimos encabezado del reporte
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode($titulo), 0, 1, 'C');
        $pdf->Ln(5);

        // Encabezados de la tabla
        $pdf->SetFillColor(125, 173, 221); // Fondo
        $pdf->SetTextColor(0, 0, 0); // Texto
        $pdf->SetDrawColor(163, 163, 163); // Bordes
        $pdf->SetFont('Arial', 'B', 11);

        $tableWidth = 150; // Ancho total de la tabla
        $xStart = ($pdf->GetPageWidth() - $tableWidth) / 2; // Margen izquierdo

        $pdf->SetX($xStart); // Ajusta el margen izquierdo
        $pdf->Cell(40, 10, utf8_decode('# Ranking'), 1, 0, 'C', 1);
        $pdf->Cell(70, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
        $pdf->Cell(40, 10, utf8_decode('Ventas'), 1, 0, 'C', 1);
        $pdf->Ln(); // Salto de línea después de los encabezados

        // Ejecutamos la consulta
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
            $pdf->SetFont('Arial', '', 12);
            $posicion = 1; // Contador para la posición

            // Iteramos sobre los resultados
            while ($row = $resultado->fetch_assoc()) {
                $pdf->SetX($xStart); // Ajusta el margen izquierdo
                $pdf->Cell(40, 10, $posicion, 1, 0, 'C'); // Posición
                $pdf->Cell(70, 10, utf8_decode($row['Nombre']), 1, 0, 'C'); // Nombre del producto
                $pdf->Cell(40, 10, $row['Ventas'], 1, 1, 'C'); // Cantidad vendida
                $posicion++; // Incrementamos el contador
            }
        } else {
            // Si no hay productos vendidos
            $pdf->Cell(0, 10, utf8_decode("No se encontraron productos vendidos."), 1, 1, 'C');
        }
        break;


    case 'menosVendidos':
        // Consulta para obtener los menos vendidos
        $consulta = "
                SELECT 
                producto.Nombre,
                SUM(detalle_compras.Cantidad) AS Ventas
            FROM 
                detalle_compras
            JOIN 
                producto ON detalle_compras.sku = producto.Sku
            GROUP BY 
                detalle_compras.sku
            ORDER BY 
                Ventas ASC
            LIMIT 10";

        $titulo = "Productos Menos Vendidos";
        $headers = ['#', 'Producto', 'Ventas'];

        // Ancho total de la tabla
        $tableWidth = 150;
        $xStart = ($pdf->GetPageWidth() - $tableWidth) / 2;

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode($titulo), 0, 1, 'C');
        $pdf->Ln(5);

        // Encabezados de la tabla
        $pdf->SetFillColor(125, 173, 221);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(163, 163, 163);
        $pdf->SetFont('Arial', 'B', 11);

        $pdf->SetX($xStart); // Centrar la tabla
        $pdf->Cell(40, 10, utf8_decode('# Ranking'), 1, 0, 'C', 1);
        $pdf->Cell(70, 10, utf8_decode('Producto'), 1, 0, 'C', 1);
        $pdf->Cell(40, 10, utf8_decode('Ventas'), 1, 1, 'C', 1);

        // Resultados de la consulta
        $resultado = $conexion->query($consulta);
        if ($resultado->num_rows > 0) {
            $posicion = 0;
            $pdf->SetFont('Arial', '', 12);

            while ($row = $resultado->fetch_assoc()) {
                $posicion++;
                $pdf->SetX($xStart); // Centrar la tabla
                $pdf->Cell(40, 10, $posicion, 1, 0, 'C'); // Posición
                $pdf->Cell(70, 10, utf8_decode($row['Nombre']), 1, 0, 'C'); // Producto
                $pdf->Cell(40, 10, $row['Ventas'], 1, 1, 'C'); // Ventas
            }
        } else {
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetX($xStart); // Centrar mensaje
            $pdf->Cell($tableWidth, 10, utf8_decode("No hay datos disponibles."), 1, 1, 'C');
        }
        break;


        // case 'mayorVenta':
        //     $consulta = "SELECT productos.Nombre, MAX(Ventas) AS Ventas 
        //                  FROM productos";
        //     $titulo = "Producto con Mayor Venta";
        //     $headers = ['Producto', 'Ventas'];
        //     break;

        // case 'menorVenta':
        //     $consulta = "SELECT productos.Nombre, MIN(Ventas) AS Ventas 
        //                  FROM productos";
        //     $titulo = "Producto con Menor Venta";
        //     $headers = ['Producto', 'Ventas'];
        //     break;

        // default:
        //     $consulta = "SELECT * FROM productos";
        //     $titulo = "Reporte General de Productos";
        //     $headers = ['ID', 'Nombre', 'Categoría', 'Precio', 'Ventas'];
        //     break;
}


$fecha = date('d/m/Y');

$pdf->Output('ReporteProducto_' . $fecha . '.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)


function getMultiCellHeight($pdf, $width, $lineHeight, $text) {
    // Dividir el texto en líneas considerando el ancho disponible
    $cw = $pdf->GetStringWidth(' '); // Ancho de un espacio
    $maxLineWidth = $width;
    $lines = explode("\n", $text); // Dividir el texto en líneas
    $height = 0;

    foreach ($lines as $line) {
        $words = explode(' ', $line);
        $currentWidth = 0;
        $lineCount = 1;

        foreach ($words as $word) {
            $wordWidth = $pdf->GetStringWidth($word . ' ');
            if ($currentWidth + $wordWidth > $maxLineWidth) {
                $height += $lineHeight;
                $currentWidth = $wordWidth;
                $lineCount++;
            } else {
                $currentWidth += $wordWidth;
            }
        }

        $height += $lineHeight; // Agregar la altura por cada línea
    }
    return $height;
}