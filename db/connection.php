<?php
// Configuración de la base de datos
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'babelium_db';

// Conexión a la base de datos con MySQLi
$conexion = new mysqli($host, $username, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer charset
$conexion->set_charset("utf8mb4");