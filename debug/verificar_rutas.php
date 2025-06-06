<?php
// Archivo para verificar las rutas y estructura
echo "<h2>Diagnóstico de Rutas - Babelium</h2>";

echo "<h3>1. Información del servidor:</h3>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";

echo "<h3>2. Verificación de archivos:</h3>";

// Verificar estructura de directorios
$archivos_verificar = [
    '../admin/perfil.php',
    '../includes/admin_header.php',
    '../db/connection.php',
    '../includes/auth_check.php',
    '../css/admin-perfil.css'
];

foreach ($archivos_verificar as $archivo) {
    $ruta_completa = __DIR__ . '/' . $archivo;
    if (file_exists($ruta_completa)) {
        echo "✅ $archivo - EXISTE<br>";
    } else {
        echo "❌ $archivo - NO EXISTE<br>";
        echo "   Ruta buscada: $ruta_completa<br>";
    }
}

echo "<h3>3. Contenido del directorio admin:</h3>";
$admin_dir = __DIR__ . '/../admin/';
if (is_dir($admin_dir)) {
    $archivos = scandir($admin_dir);
    foreach ($archivos as $archivo) {
        if ($archivo != '.' && $archivo != '..') {
            echo "📁 $archivo<br>";
        }
    }
} else {
    echo "❌ Directorio admin no encontrado<br>";
}

echo "<h3>4. Verificación de permisos:</h3>";
if (is_readable(__DIR__ . '/../admin/perfil.php')) {
    echo "✅ perfil.php es legible<br>";
} else {
    echo "❌ perfil.php no es legible o no existe<br>";
}

echo "<h3>5. URL de prueba:</h3>";
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
echo "Base URL: $base_url<br>";
echo "URL perfil: $base_url/../admin/perfil.php<br>";

echo "<h3>6. Verificación de .htaccess:</h3>";
$htaccess_files = [
    __DIR__ . '/../.htaccess',
    __DIR__ . '/../admin/.htaccess'
];

foreach ($htaccess_files as $htaccess) {
    if (file_exists($htaccess)) {
        echo "📄 .htaccess encontrado en: $htaccess<br>";
        echo "Contenido:<br>";
        echo "<pre>" . htmlspecialchars(file_get_contents($htaccess)) . "</pre>";
    }
}
?>
