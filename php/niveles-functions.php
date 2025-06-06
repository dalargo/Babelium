<?php
/**
 * Funciones para el manejo de niveles educativos
 * Babelium - Sistema de gestión educativa
 */

/**
 * Función para obtener el icono según el nivel educativo
 */
function getNivelIcon($nombre) {
    $nombre_lower = strtolower($nombre);
    
    if (strpos($nombre_lower, 'primaria') !== false) {
        return 'fas fa-child';
    } elseif (strpos($nombre_lower, 'secundaria') !== false || strpos($nombre_lower, 'eso') !== false) {
        return 'fas fa-school';
    } elseif (strpos($nombre_lower, 'bachillerato') !== false) {
        return 'fas fa-user-graduate';
    } elseif (strpos($nombre_lower, 'básica') !== false) {
        return 'fas fa-tools';
    } elseif (strpos($nombre_lower, 'grado medio') !== false) {
        return 'fas fa-cogs';
    } elseif (strpos($nombre_lower, 'grado superior') !== false) {
        return 'fas fa-industry';
    } elseif (strpos($nombre_lower, 'universitario') !== false || strpos($nombre_lower, 'grado') !== false) {
        return 'fas fa-university';
    } else {
        return 'fas fa-book';
    }
}

/**
 * Función para obtener el color según el nivel educativo
 */
function getNivelColor($nombre) {
    $nombre_lower = strtolower($nombre);
    
    if (strpos($nombre_lower, 'primaria') !== false) {
        return 'nivel-primaria';
    } elseif (strpos($nombre_lower, 'secundaria') !== false || strpos($nombre_lower, 'eso') !== false) {
        return 'nivel-secundaria';
    } elseif (strpos($nombre_lower, 'bachillerato') !== false) {
        return 'nivel-bachillerato';
    } elseif (strpos($nombre_lower, 'básica') !== false) {
        return 'nivel-fp-basica';
    } elseif (strpos($nombre_lower, 'grado medio') !== false) {
        return 'nivel-fp-medio';
    } elseif (strpos($nombre_lower, 'grado superior') !== false) {
        return 'nivel-fp-superior';
    } elseif (strpos($nombre_lower, 'universitario') !== false || strpos($nombre_lower, 'grado') !== false) {
        return 'nivel-universidad';
    } else {
        return 'nivel-default';
    }
}
?>
