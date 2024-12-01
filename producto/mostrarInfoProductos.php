<?php

// Conexión a la base de datos
// require("../conexion/conexion.php");

function mostrarInfoProductosPorCategoria($categoria)
{
  global $conexion; // Asegúrate de usar tu conexión existente
  $sql = "SELECT * FROM producto WHERE IdCategoria = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("i", $categoria);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result->fetch_all(MYSQLI_ASSOC);
}
