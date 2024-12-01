<?php

require('./fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        include '../conexion/conexion.php'; // Conexión a la base de datos
        $this->Image('logo.png', 10, 5, 20); // Logo de la empresa
        $this->SetFont('Arial', 'B', 19); 
        $this->Cell(45); 
        $this->SetTextColor(0, 0, 0);
        $this->Cell(110, 15, utf8_decode('Casa del Sol'), 0, 1, 'C', 0);
        $this->Ln(3);

        // Información de contacto
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(80);
        $this->Cell(59, 10, utf8_decode("Teléfono : 9861139975"), 0, 0, '', 0);
        $this->Ln(5);
        $this->Cell(70);
        $this->Cell(85, 10, utf8_decode("Correo : casaDelSol@gmail.com"), 0, 0, '', 0);
        $this->Ln(10);

        // Título del reporte
        $this->SetTextColor(0, 95, 189);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(50);
        $this->Cell(100, 10, utf8_decode("REPORTE DE VENTAS"), 0, 1, 'C', 0);
        $this->Ln(7);

        // Campos de la tabla
        $this->SetFillColor(125, 173, 221);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(163, 163, 163);
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(7, 10, utf8_decode('N°'), 1, 0, 'C', 1);
        $this->Cell(20, 10, utf8_decode('ID Venta'), 1, 0, 'C', 1);
        $this->Cell(25, 10, utf8_decode('Cliente'), 1, 0, 'C', 1);
        $this->Cell(70, 10, utf8_decode('Productos'), 1, 0, 'C', 1);
        $this->Cell(25, 10, utf8_decode('Total'), 1, 0, 'C', 1);
        $this->Cell(35, 10, utf8_decode('Fecha'), 1, 1, 'C', 1);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $hoy = date('d/m/Y');
        $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C');
    }
}

    include '../conexion/conexion.php';

    $pdf = new PDF();
    $pdf->AddPage(); 
    $pdf->AliasNbPages(); 

    $i = 0;
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetDrawColor(163, 163, 163); 

    // Consulta para obtener los datos de ventas
    $consulta_reporteVentas = $conexion->query("
        SELECT 
            c.id AS idVenta,
            CONCAT(u.Nombre, ' ', u.Apellido) AS nombreUsuario,
            GROUP_CONCAT(p.Nombre SEPARATOR ', ') AS productos,
            SUM(dc.cantidad * dc.precio) AS totalVenta,
            c.fecha AS fechaVenta
        FROM 
            compras c
        JOIN 
            usuario u ON c.usuario_id = u.Id
        JOIN 
            detalle_compras dc ON c.id = dc.compra_id
        JOIN 
            producto p ON dc.sku = p.Sku
        GROUP BY 
            c.id, u.Nombre, u.Apellido, c.fecha
        ORDER BY 
            c.fecha DESC
    ");

    while ($datos_reporte = $consulta_reporteVentas->fetch_object()) {  
        $i++;

        /* TABLA */
        $pdf->Cell(7, 10, utf8_decode($i), 1, 0, 'C', 0);
        $pdf->Cell(20, 10, utf8_decode($datos_reporte->idVenta), 1, 0, 'C', 0);
        $pdf->Cell(25, 10, utf8_decode($datos_reporte->nombreUsuario), 1, 0, 'C', 0);
        $pdf->Cell(70, 10, utf8_decode($datos_reporte->productos), 1, 0, 'C', 0);
        $pdf->Cell(25, 10, '$' . number_format($datos_reporte->totalVenta, 2), 1, 0, 'C', 0);
        $pdf->Cell(35, 10, utf8_decode($datos_reporte->fechaVenta), 1, 1, 'C', 0); 
    }

    $fecha = date('d/m/Y');

    $pdf->Output('ReporteVentas_' . $fecha . '.pdf', 'I');
