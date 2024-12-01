<?php 
//Conectarse a la base de datos local
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_casa_del_sol";

$conexion = new mysqli($servername, $username, $password, $database);

//Verifica la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>