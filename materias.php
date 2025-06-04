<?php
// Incluir archivo de conexión
require_once 'db/connection.php';

// Obtener parámetros de la URL
$curso_id = isset($_GET['curso_id']) ? (int)$_GET['curso_id'] : 0;
$modalidad_id = isset($_GET['modalidad_id']) ? (int)$_GET['modalidad_id'] : 0;

// Variables para almacenar información
$curso_info = null;
$modalidad_info = null;
$nivel_info = null;
$materias = [];

// Determinar si viene de curso directo o modalidad
if ($curso_id > 0) {
    // Obtener información del curso y nivel
    $query_curso = "SELECT c.id, c.nombre, c.descripcion, ne.id as nivel_id, ne.nombre as nivel_nombre 
                   FROM cursos c 
                   JOIN niveles_educativos ne ON c.nivel_id = ne.id 
                   WHERE c.id = $curso_id AND c.activo = 1";
    $resultado_curso = $conexion->query($query_curso);
    $curso_info = $resultado_curso ? $resultado_curso->fetch_assoc() : null;
    
    if (!$curso_info) {
        header("Location: niveles.php");
        exit();
    }
    
    // Obtener materias del curso (modalidad sin rama)
    $query_materias = "SELECT m.id, m.nombre, m.descripcion, m.creditos, m.obligatoria 
                      FROM materias m 
                      JOIN modalidades_curso mc ON m.modalidad_curso_id = mc.id 
                      WHERE mc.curso_id = $curso_id AND mc.rama_id IS NULL AND m.activo = 1 
                      ORDER BY m.obligatoria DESC, m.nombre ASC";
    
} elseif ($modalidad_id > 0) {
    // Obtener información de la modalidad, curso y nivel
    $query_modalidad = "SELECT mc.id, mc.nombre, mc.descripcion, 
                              c.id as curso_id, c.nombre as curso_nombre,
                              ne.id as nivel_id, ne.nombre as nivel_nombre,
                              r.nombre as rama_nombre
                       FROM modalidades_curso mc 
                       JOIN cursos c ON mc.curso_id = c.id 
                       JOIN niveles_educativos ne ON c.nivel_id = ne.id 
                       LEFT JOIN ramas r ON mc.rama_id = r.id 
                       WHERE mc.id = $modalidad_id AND mc.activo = 1";
    $resultado_modalidad = $conexion->query($query_modalidad);
    $modalidad_info = $resultado_modalidad ? $resultado_modalidad->fetch_assoc() : null;
    
    if (!$modalidad_info) {
        header("Location: niveles.php");
        exit();
    }
    
    // Obtener materias de la modalidad
    $query_materias = "SELECT m.id, m.nombre, m.descripcion, m.creditos, m.obligatoria 
                      FROM materias m 
                      WHERE m.modalidad_curso_id = $modalidad_id AND m.activo = 1 
                      ORDER BY m.obligatoria DESC, m.nombre ASC";
} else {
    header("Location: niveles.php");
    exit();
}

// Ejecutar consulta de materias
$resultado_materias = $conexion->query($query_materias);
if ($resultado_materias && $resultado_materias->num_rows > 0) {
    while ($fila = $resultado_materias->fetch_assoc()) {
        $materias[] = $fila;
    }
}

// Función para obtener el icono según la materia
function getMateriaIcon($nombre) {
    $nombre_lower = strtolower($nombre);
    
    if (strpos($nombre_lower, 'matemáticas') !== false || strpos($nombre_lower, 'matematicas') !== false) {
        return 'fas fa-calculator';
    } elseif (strpos($nombre_lower, 'lengua') !== false || strpos($nombre_lower, 'literatura') !== false) {
        return 'fas fa-book';
    } elseif (strpos($nombre_lower, 'inglés') !== false || strpos($nombre_lower, 'ingles') !== false || strpos($nombre_lower, 'extranjera') !== false) {
        return 'fas fa-globe';
    } elseif (strpos($nombre_lower, 'ciencias') !== false || strpos($nombre_lower, 'biología') !== false || strpos($nombre_lower, 'física') !== false || strpos($nombre_lower, 'química') !== false) {
        return 'fas fa-flask';
    } elseif (strpos($nombre_lower, 'historia') !== false || strpos($nombre_lower, 'geografía') !== false) {
        return 'fas fa-map';
    } elseif (strpos($nombre_lower, 'educación física') !== false || strpos($nombre_lower, 'deporte') !== false) {
        return 'fas fa-running';
    } elseif (strpos($nombre_lower, 'música') !== false) {
        return 'fas fa-music';
    } elseif (strpos($nombre_lower, 'arte') !== false || strpos($nombre_lower, 'plástica') !== false || strpos($nombre_lower, 'visual') !== false) {
        return 'fas fa-palette';
    } elseif (strpos($nombre_lower, 'tecnología') !== false || strpos($nombre_lower, 'informática') !== false) {
        return 'fas fa-laptop-code';
    } elseif (strpos($nombre_lower, 'filosofía') !== false) {
        return 'fas fa-brain';
    } elseif (strpos($nombre_lower, 'economía') !== false) {
        return 'fas fa-chart-line';
    } elseif (strpos($nombre_lower, 'derecho') !== false) {
        return 'fas fa-balance-scale';
    } elseif (strpos($nombre_lower, 'medicina') !== false || strpos($nombre_lower, 'salud') !== false) {
        return 'fas fa-heartbeat';
    } elseif (strpos($nombre_lower, 'ingeniería') !== false) {
        return 'fas fa-cogs';
    } else {
        return 'fas fa-book-open';
    }
}

// Función para obtener el color según el nivel
function getNivelColorClass($nivel_nombre) {
    $nombre_lower = strtolower($nivel_nombre);
    
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

// Determinar información para mostrar
$info_actual = $curso_info ?: $modalidad_info;
$nivel_nombre = $info_actual['nivel_nombre'];
$titulo_pagina = $curso_info ? $curso_info['nombre'] : $modalidad_info['nombre'];
$descripcion_pagina = $curso_info ? $curso_info['descripcion'] : $modalidad_info['descripcion'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/materias.css">
    <title>Materias de <?php echo htmlspecialchars($titulo_pagina); ?> - Babelium</title>
</head>
<body>
    <?php include_once "includes/header.php" ?>

    <main class="materias-main">
        <!-- Hero Section -->
        <section class="materias-hero <?php echo getNivelColorClass($nivel_nombre); ?>">
            <div class="hero-content">
                <div class="hero-badge">
                    <?php echo htmlspecialchars($nivel_nombre); ?>
                </div>
                <h1><?php echo htmlspecialchars($titulo_pagina); ?></h1>
                <?php if ($modalidad_info && $modalidad_info['rama_nombre']): ?>
                    <div class="hero-rama">
                        <i class="fas fa-tag"></i>
                        <?php echo htmlspecialchars($modalidad_info['rama_nombre']); ?>
                    </div>
                <?php endif; ?>
                <p class="hero-description">
                    <?php echo htmlspecialchars($descripcion_pagina); ?>
                </p>
                <div class="hero-stats">
                    <div class="stat">
                        <i class="fas fa-book"></i>
                        <span><?php echo count($materias); ?> materias disponibles</span>
                    </div>
                    <?php 
                    $materias_obligatorias = array_filter($materias, function($m) { return $m['obligatoria']; });
                    $materias_optativas = array_filter($materias, function($m) { return !$m['obligatoria']; });
                    ?>
                    <?php if (count($materias_obligatorias) > 0): ?>
                    <div class="stat">
                        <i class="fas fa-star"></i>
                        <span><?php echo count($materias_obligatorias); ?> obligatorias</span>
                    </div>
                    <?php endif; ?>
                    <?php if (count($materias_optativas) > 0): ?>
                    <div class="stat">
                        <i class="fas fa-plus-circle"></i>
                        <span><?php echo count($materias_optativas); ?> optativas</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Breadcrumb -->
        <section class="breadcrumb">
            <div class="breadcrumb-container">
                <a href="index.php" class="breadcrumb-link">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <span class="breadcrumb-separator">></span>
                <a href="niveles.php" class="breadcrumb-link">Niveles Educativos</a>
                <span class="breadcrumb-separator">></span>
                <a href="cursos.php?nivel_id=<?php echo $info_actual['nivel_id']; ?>" class="breadcrumb-link">
                    <?php echo htmlspecialchars($nivel_nombre); ?>
                </a>
                <span class="breadcrumb-separator">></span>
                <span class="breadcrumb-current"><?php echo htmlspecialchars($titulo_pagina); ?></span>
            </div>
        </section>

        <!-- Materias Section -->
        <section class="materias-section">
            <div class="materias-container">
                <?php if (empty($materias)): ?>
                    <div class="no-materias">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>No hay materias disponibles</h3>
                        <p>Este curso aún no tiene materias configuradas.</p>
                        <a href="cursos.php?nivel_id=<?php echo $info_actual['nivel_id']; ?>" class="back-button">
                            <i class="fas fa-arrow-left"></i> Volver a cursos
                        </a>
                    </div>
                <?php else: ?>
                    
                    <!-- Materias Obligatorias -->
                    <?php if (count($materias_obligatorias) > 0): ?>
                        <div class="materias-group">
                            <div class="group-header">
                                <h2>
                                    <i class="fas fa-star"></i>
                                    Materias Obligatorias
                                </h2>
                                <p>Estas materias son fundamentales para completar el curso</p>
                            </div>
                            
                            <div class="materias-grid">
                                <?php foreach ($materias_obligatorias as $materia): ?>
                                    <div class="materia-card obligatoria <?php echo getNivelColorClass($nivel_nombre); ?>">
                                        <div class="materia-badge">
                                            <i class="fas fa-star"></i>
                                            Obligatoria
                                        </div>
                                        <div class="materia-icon">
                                            <i class="<?php echo getMateriaIcon($materia['nombre']); ?>"></i>
                                        </div>
                                        <div class="materia-content">
                                            <h3 class="materia-title"><?php echo htmlspecialchars($materia['nombre']); ?></h3>
                                            <p class="materia-description">
                                                <?php echo htmlspecialchars($materia['descripcion']); ?>
                                            </p>
                                            <?php if ($materia['creditos'] > 0): ?>
                                                <div class="materia-creditos">
                                                    <i class="fas fa-clock"></i>
                                                    <?php echo $materia['creditos']; ?> créditos
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="materia-footer">
                                            <a href="temas.php?materia_id=<?php echo $materia['id']; ?>" class="materia-button">
                                                Ver temas
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Materias Optativas -->
                    <?php if (count($materias_optativas) > 0): ?>
                        <div class="materias-group">
                            <div class="group-header">
                                <h2>
                                    <i class="fas fa-plus-circle"></i>
                                    Materias Optativas
                                </h2>
                                <p>Materias adicionales para ampliar tus conocimientos</p>
                            </div>
                            
                            <div class="materias-grid">
                                <?php foreach ($materias_optativas as $materia): ?>
                                    <div class="materia-card optativa <?php echo getNivelColorClass($nivel_nombre); ?>">
                                        <div class="materia-badge optativa-badge">
                                            <i class="fas fa-plus-circle"></i>
                                            Optativa
                                        </div>
                                        <div class="materia-icon">
                                            <i class="<?php echo getMateriaIcon($materia['nombre']); ?>"></i>
                                        </div>
                                        <div class="materia-content">
                                            <h3 class="materia-title"><?php echo htmlspecialchars($materia['nombre']); ?></h3>
                                            <p class="materia-description">
                                                <?php echo htmlspecialchars($materia['descripcion']); ?>
                                            </p>
                                            <?php if ($materia['creditos'] > 0): ?>
                                                <div class="materia-creditos">
                                                    <i class="fas fa-clock"></i>
                                                    <?php echo $materia['creditos']; ?> créditos
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="materia-footer">
                                            <a href="temas.php?materia_id=<?php echo $materia['id']; ?>" class="materia-button">
                                                Ver temas
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                <?php endif; ?>
            </div>
        </section>

        <!-- Info adicional -->
        <section class="info-adicional">
            <div class="info-container">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Aprendizaje Estructurado</h3>
                    <p>Cada materia está organizada en temas progresivos para facilitar tu aprendizaje.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Sigue tu Progreso</h3>
                    <p>Registra tu avance en cada tema y materia para mantener un seguimiento completo.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Apoyo Continuo</h3>
                    <p>Accede a recursos adicionales y participa en discusiones sobre cada materia.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "includes/footer.php" ?>

    <script>
        // Animación de entrada para las cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.materia-card');
            
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observer.observe(card);
            });

            // Animación para grupos de materias
            const groups = document.querySelectorAll('.materias-group');
            groups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                group.style.transition = `opacity 0.8s ease ${index * 0.3}s, transform 0.8s ease ${index * 0.3}s`;
                observer.observe(group);
            });
        });
    </script>
</body>
</html>