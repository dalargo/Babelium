<?php
// Archivo para verificar autenticación
function verificarAutenticacion($tipo_requerido = null) {
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: /auth/login.php");
        exit();
    }
    
    if ($tipo_requerido && $_SESSION['usuario_tipo'] !== $tipo_requerido) {
        header("Location: /index.php");
        exit();
    }
    
    return true;
}

function obtenerUsuarioActual() {
    if (!isset($_SESSION['usuario_id'])) {
        return null;
    }
    
    return [
        'id' => $_SESSION['usuario_id'],
        'tipo' => $_SESSION['usuario_tipo'],
        'nombre' => $_SESSION['usuario_nombre'],
        'apellidos' => $_SESSION['usuario_apellidos'],
        'email' => $_SESSION['usuario_email'],
        'identificador' => $_SESSION['usuario_identificador']
    ];
}

function estaLogueado() {
    return isset($_SESSION['usuario_id']);
}

function esAdmin() {
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin';
}

function esProfesor() {
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'profesor';
}

function esAlumno() {
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'alumno';
}
?>