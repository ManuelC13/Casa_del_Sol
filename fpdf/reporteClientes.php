<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      include '../conexion/conexion.php';//llamamos a la conexion BD

      $consulta_info = $conexion->query(" select *from usuario ");//traemos datos de la empresa desde BD
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
      $this->Cell(100, 10, utf8_decode("REPORTE DE USUARIOS"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(125, 173, 221); //colorFondo
      $this->SetTextColor(0, 0, 0); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      
      $this->Cell(7, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(20, 10, utf8_decode('ID'), 1, 0, 'C', 1);
      $this->Cell(35, 10, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
      $this->Cell(35, 10, utf8_decode('APELLIDO'), 1, 0, 'C', 1);
      $this->Cell(18, 10, utf8_decode('EDAD'), 1, 0, 'C', 1);
      $this->Cell(45, 10, utf8_decode('FECHA DE REGISTRO'), 1, 0, 'C', 1);
      $this->Cell(30, 10, utf8_decode('ROL'), 1, 1, 'C', 1);
   }

   // Pie de página
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

include '../conexion/conexion.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$consulta_reporteUsuario = $conexion->query("SELECT usuario.Id, usuario.Nombre, usuario.Apellido, usuario.Edad, usuario.FechaRegistro, usuario.Rol FROM usuario");

while ($datos_reporte = $consulta_reporteUsuario->fetch_object()) {  
   $i = $i + 1;

   switch($datos_reporte->Rol){
      case 0:
         $datos_reporte->Rol = "Usuario";
         break;
      case 1:
         $datos_reporte->Rol = "Administrador";
         break;
      default:
         $datos_reporte->Rol = "Desconocido";
         break;
   }

   /* TABLA */
   $pdf->Cell(7, 10, utf8_decode($i), 1, 0, 'C', 0);
   $pdf->Cell(20, 10, utf8_decode($datos_reporte ->Id), 1, 0, 'C', 0);
   $pdf->Cell(35, 10, utf8_decode($datos_reporte ->Nombre), 1, 0, 'C', 0);
   $pdf->Cell(35, 10, utf8_decode($datos_reporte ->Apellido), 1, 0, 'C', 0);
   $pdf->Cell(18, 10, utf8_decode($datos_reporte ->Edad), 1, 0, 'C', 0);
   $pdf->Cell(45, 10, utf8_decode($datos_reporte ->FechaRegistro), 1, 0, 'C', 0);
   $pdf->Cell(30, 10, utf8_decode($datos_reporte ->Rol), 1, 1, 'C', 0); 
}

$fecha = date('d/m/Y');

$pdf->Output('ReporteCliente_'.$fecha.'.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
