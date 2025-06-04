<?php
/**
 * Archivo de ejemplo para la configuración de base de datos
 * 
 * INSTRUCCIONES:
 * 1. Copia este archivo como 'connection.php'
 * 2. Configura los datos de tu base de datos
 * 3. Asegúrate de que 'connection.php' esté en .gitignore
 */

// Configuración de la base de datos
$servidor = "localhost";        // Servidor de base de datos
$usuario = "tu_usuario";        // Usuario de MySQL
$password = "tu_password";      // Contraseña de MySQL
$base_datos = "babelium_db";    // Nombre de la base de datos

// Configuración adicional
$charset = "utf8mb4";           // Codificación de caracteres

try {
    // Crear conexión MySQLi
    $conexion = new mysqli($servidor, $usuario, $password, $base_datos);
    
    // Configurar codificación
    $conexion->set_charset($charset);
    
    // Verificar conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Configurar zona horaria (opcional)
    $conexion->query("SET time_zone = '+00:00'");
    
} catch (Exception $e) {
    // En producción, registrar el error en lugar de mostrarlo
    error_log("Error de base de datos: " . $e->getMessage());
    
    // Mostrar mensaje genérico al usuario
    die("Error: No se pudo conectar a la base de datos. Por favor, contacta al administrador.");
}

// Función auxiliar para escapar datos (opcional)
function limpiar_entrada($data) {
    global $conexion;
    return mysqli_real_escape_string($conexion, trim($data));
}

// Función para cerrar conexión (opcional)
function cerrar_conexion() {
    global $conexion;
    if ($conexion) {
        $conexion->close();
    }
}

/*
EJEMPLO DE USO:

// Incluir el archivo de conexión
require_once 'db/connection.php';

// Realizar consulta
$sql = "SELECT * FROM usuarios WHERE activo = 1";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo $fila['nombre'];
    }
}

// Cerrar conexión al final del script (opcional)
cerrar_conexion();
*/
?>
