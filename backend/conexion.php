<?php
// Parámetros de conexión a la base de datos local (XAMPP)
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "red_kioscos_umb";

// Crear la conexión usando MySQLi
$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar si hubo errores de conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8 para evitar problemas con tildes y eñes
$conexion->set_charset("utf8");

// Si todo sale bien, la variable $conexion estará lista para usarse en tus consultas del backend
?>
