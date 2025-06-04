<?php
require_once "db/connection.php";

// Obtener el ID del nivel desde la URL
$nivel_id = isset($_GET['nivel_id']) ? (int)$_GET['nivel_id'] : 0;

// Obtener información del nivel educativo
$query_nivel = "SELECT id, nombre, descripcion FROM niveles_educativos WHERE id = $nivel_id AND activo = 1";
$resultado_nivel = $conexion->query($query_nivel);
$nivel = $resultado_nivel ? $resultado_nivel->fetch_assoc() : null;

// Si no existe el nivel, redirigir
if (!$nivel) {
    header("Location: niveles.php");
    exit();
}

// Consulta para obtener los cursos del nivel
$query_cursos = "SELECT c.id, c.nombre, c.descripcion, c.orden 
                FROM cursos c 
                WHERE c.nivel_id = $nivel_id AND c.activo = 1 
                ORDER BY c.orden ASC";
$resultado_cursos = $conexion->query($query_cursos);

// Obtener los cursos
$cursos = [];
if ($resultado_cursos && $resultado_cursos->num_rows > 0) {
    while ($fila = $resultado_cursos->fetch_assoc()) {
        $cursos[] = $fila;
    }
}

// Consulta para obtener las modalidades de curso (para niveles con ramas)
$query_modalidades = "SELECT mc.id, mc.nombre, mc.descripcion, c.nombre as curso_nombre, r.nombre as rama_nombre
                     FROM modalidades_curso mc
                     JOIN cursos c ON mc.curso_id = c.id
                     LEFT JOIN ramas r ON mc.rama_id = r.id
                     WHERE c.nivel_id = $nivel_id AND mc.activo = 1
                     ORDER BY c.orden ASC, r.nombre ASC";
$resultado_modalidades = $conexion->query($query_modalidades);

// Obtener las modalidades
$modalidades = [];
if ($resultado_modalidades && $resultado_modalidades->num_rows > 0) {
    while ($fila = $resultado_modalidades->fetch_assoc()) {
        $modalidades[] = $fila;
    }
}

// Esta parte es más que nada estética para la visualización de cada apartado

// Función para obtener el icono según el curso
function getCursoIcon($nombre, $nivel_nombre) {
    $nombre_lower = strtolower($nombre);
    $nivel_lower = strtolower($nivel_nombre);
    
    if (strpos($nivel_lower, 'primaria') !== false) {
        if (strpos($nombre_lower, 'primero') !== false || strpos($nombre_lower, 'segundo') !== false) {
            return 'fas fa-baby';
        } else {
            return 'fas fa-child';
        }
    } elseif (strpos($nivel_lower, 'secundaria') !== false || strpos($nivel_lower, 'eso') !== false) {
        return 'fas fa-school';
    } elseif (strpos($nivel_lower, 'bachillerato') !== false) {
        return 'fas fa-user-graduate';
    } elseif (strpos($nivel_lower, 'fp') !== false || strpos($nivel_lower, 'formación') !== false) {
        return 'fas fa-tools';
    } elseif (strpos($nivel_lower, 'universitario') !== false) {
        return 'fas fa-university';
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cursos.css">
    <title>Cursos de <?php echo htmlspecialchars($nivel['nombre']); ?> - Babelium</title>
</head>
<body>
    <?php include_once "includes/header.php" ?>

    <main class="cursos-main">
        <!-- Hero Section -->
        <section class="cursos-hero <?php echo getNivelColorClass($nivel['nombre']); ?>">
            <div class="hero-content">
                <h1><?php echo htmlspecialchars($nivel['nombre']); ?></h1>
                <p class="hero-description">
                    <?php echo htmlspecialchars($nivel['descripcion']); ?>
                </p>
                <div class="hero-stats">
                    <div class="stat">
                        <i class="fas fa-book"></i>
                        <span><?php echo count($cursos); ?> cursos disponibles</span>
                    </div>
                    <?php if (!empty($modalidades)): ?>
                    <div class="stat">
                        <i class="fas fa-layer-group"></i>
                        <span><?php echo count($modalidades); ?> modalidades</span>
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
                <span class="breadcrumb-current"><?php echo htmlspecialchars($nivel['nombre']); ?></span>
            </div>
        </section>

        <!-- Cursos Section -->
        <section class="cursos-section">
            <div class="cursos-container">
                <?php if (empty($cursos) && empty($modalidades)): ?>
                    <div class="no-cursos">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>No hay cursos disponibles</h3>
                        <p>Este nivel educativo aún no tiene cursos configurados.</p>
                        <a href="niveles.php" class="back-button">
                            <i class="fas fa-arrow-left"></i> Volver a niveles
                        </a>
                    </div>
                <?php else: ?>
                    
                    <!-- Cursos simples (sin ramas) -->
                    <?php if (!empty($cursos) && empty($modalidades)): ?>
                        <div class="section-header">
                            <h2>Cursos Disponibles</h2>
                            <p>Selecciona el curso que deseas estudiar</p>
                        </div>
                        
                        <div class="cursos-grid">
                            <?php foreach ($cursos as $curso): ?>
                                <div class="curso-card <?php echo getNivelColorClass($nivel['nombre']); ?>">
                                    <div class="curso-icon">
                                        <i class="<?php echo getCursoIcon($curso['nombre'], $nivel['nombre']); ?>"></i>
                                    </div>
                                    <div class="curso-content">
                                        <h3 class="curso-title"><?php echo htmlspecialchars($curso['nombre']); ?></h3>
                                        <p class="curso-description">
                                            <?php echo htmlspecialchars($curso['descripcion']); ?>
                                        </p>
                                    </div>
                                    <div class="curso-footer">
                                        <a href="materias.php?curso_id=<?php echo $curso['id']; ?>" class="curso-button">
                                            Ver materias
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Modalidades (cursos con ramas) -->
                    <?php if (!empty($modalidades)): ?>
                        <div class="section-header">
                            <h2>Modalidades y Cursos</h2>
                            <p>Selecciona la modalidad y curso que deseas estudiar</p>
                        </div>
                        
                        <div class="modalidades-grid">
                            <?php 
                            $modalidades_agrupadas = [];
                            foreach ($modalidades as $modalidad) {
                                $curso_nombre = $modalidad['curso_nombre'];
                                if (!isset($modalidades_agrupadas[$curso_nombre])) {
                                    $modalidades_agrupadas[$curso_nombre] = [];
                                }
                                $modalidades_agrupadas[$curso_nombre][] = $modalidad;
                            }
                            ?>
                            
                            <?php foreach ($modalidades_agrupadas as $curso_nombre => $mods): ?>
                                <div class="curso-group">
                                    <h3 class="curso-group-title">
                                        <i class="<?php echo getCursoIcon($curso_nombre, $nivel['nombre']); ?>"></i>
                                        <?php echo htmlspecialchars($curso_nombre); ?>
                                    </h3>
                                    
                                    <div class="modalidades-list">
                                        <?php foreach ($mods as $modalidad): ?>
                                            <div class="modalidad-card <?php echo getNivelColorClass($nivel['nombre']); ?>">
                                                <div class="modalidad-content">
                                                    <h4 class="modalidad-title">
                                                        <?php if ($modalidad['rama_nombre']): ?>
                                                            <?php echo htmlspecialchars($modalidad['rama_nombre']); ?>
                                                        <?php else: ?>
                                                            <?php echo htmlspecialchars($modalidad['nombre']); ?>
                                                        <?php endif; ?>
                                                    </h4>
                                                    <p class="modalidad-description">
                                                        <?php echo htmlspecialchars($modalidad['descripcion']); ?>
                                                    </p>
                                                </div>
                                                <div class="modalidad-footer">
                                                    <a href="materias.php?modalidad_id=<?php echo $modalidad['id']; ?>" class="modalidad-button">
                                                        Ver materias
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Contenido Actualizado</h3>
                    <p>Nuestros materiales se actualizan constantemente para seguir el currículo oficial.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Aprende en Comunidad</h3>
                    <p>Conecta con otros estudiantes y profesores en nuestra plataforma educativa.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3>Progreso Personalizado</h3>
                    <p>Sigue tu progreso y obtén certificados al completar los cursos.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "includes/footer.php" ?>

    <script>
        // Animación de entrada para las cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.curso-card, .modalidad-card');
            
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

            // Animación para grupos de cursos
            const groups = document.querySelectorAll('.curso-group');
            groups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                group.style.transition = `opacity 0.8s ease ${index * 0.2}s, transform 0.8s ease ${index * 0.2}s`;
                observer.observe(group);
            });
        });
    </script>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>