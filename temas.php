<?php
// Incluir archivo de conexión
require_once 'db/connection.php';

// Obtener el ID de la materia desde la URL
$materia_id = isset($_GET['materia_id']) ? (int)$_GET['materia_id'] : 0;

// Variables para almacenar información
$materia_info = null;
$curso_info = null;
$nivel_info = null;
$temas = [];

if ($materia_id > 0) {
    // Obtener información completa de la materia, curso y nivel
    $query_materia = "SELECT m.id, m.nombre, m.descripcion, m.creditos, m.obligatoria,
                            mc.id as modalidad_id, mc.nombre as modalidad_nombre,
                            c.id as curso_id, c.nombre as curso_nombre,
                            ne.id as nivel_id, ne.nombre as nivel_nombre,
                            r.nombre as rama_nombre
                     FROM materias m
                     JOIN modalidades_curso mc ON m.modalidad_curso_id = mc.id
                     JOIN cursos c ON mc.curso_id = c.id
                     JOIN niveles_educativos ne ON c.nivel_id = ne.id
                     LEFT JOIN ramas r ON mc.rama_id = r.id
                     WHERE m.id = $materia_id AND m.activo = 1";
    
    $resultado_materia = $conexion->query($query_materia);
    $materia_info = $resultado_materia ? $resultado_materia->fetch_assoc() : null;
    
    if (!$materia_info) {
        header("Location: niveles.php");
        exit();
    }
    
    // Obtener los temas de la materia
    $query_temas = "SELECT t.id, t.titulo, t.descripcion, t.orden,
                          COUNT(c.id) as num_contenidos
                   FROM temas t
                   LEFT JOIN contenidos c ON t.id = c.tema_id AND c.activo = 1
                   WHERE t.materia_id = $materia_id AND t.activo = 1
                   GROUP BY t.id, t.titulo, t.descripcion, t.orden
                   ORDER BY t.orden ASC";
    
    $resultado_temas = $conexion->query($query_temas);
    if ($resultado_temas && $resultado_temas->num_rows > 0) {
        while ($fila = $resultado_temas->fetch_assoc()) {
            $temas[] = $fila;
        }
    }
} else {
    header("Location: niveles.php");
    exit();
}

// Función para obtener el icono según el tema
function getTemaIcon($titulo, $materia_nombre) {
    $titulo_lower = strtolower($titulo);
    $materia_lower = strtolower($materia_nombre);
    
    // Iconos específicos según el contenido del tema
    if (strpos($titulo_lower, 'introducción') !== false || strpos($titulo_lower, 'introduccion') !== false) {
        return 'fas fa-play-circle';
    } elseif (strpos($titulo_lower, 'historia') !== false) {
        return 'fas fa-clock';
    } elseif (strpos($titulo_lower, 'teoría') !== false || strpos($titulo_lower, 'teoria') !== false) {
        return 'fas fa-lightbulb';
    } elseif (strpos($titulo_lower, 'práctica') !== false || strpos($titulo_lower, 'practica') !== false) {
        return 'fas fa-tools';
    } elseif (strpos($titulo_lower, 'ejercicio') !== false || strpos($titulo_lower, 'problema') !== false) {
        return 'fas fa-pencil-alt';
    } elseif (strpos($titulo_lower, 'examen') !== false || strpos($titulo_lower, 'evaluación') !== false) {
        return 'fas fa-clipboard-check';
    } elseif (strpos($titulo_lower, 'proyecto') !== false) {
        return 'fas fa-project-diagram';
    } elseif (strpos($titulo_lower, 'laboratorio') !== false) {
        return 'fas fa-flask';
    } elseif (strpos($titulo_lower, 'lectura') !== false || strpos($titulo_lower, 'texto') !== false) {
        return 'fas fa-book-open';
    } elseif (strpos($titulo_lower, 'video') !== false || strpos($titulo_lower, 'multimedia') !== false) {
        return 'fas fa-play';
    } else {
        // Iconos según la materia
        if (strpos($materia_lower, 'matemáticas') !== false) {
            return 'fas fa-calculator';
        } elseif (strpos($materia_lower, 'lengua') !== false || strpos($materia_lower, 'literatura') !== false) {
            return 'fas fa-book';
        } elseif (strpos($materia_lower, 'ciencias') !== false) {
            return 'fas fa-atom';
        } elseif (strpos($materia_lower, 'historia') !== false) {
            return 'fas fa-landmark';
        } elseif (strpos($materia_lower, 'geografía') !== false) {
            return 'fas fa-globe-americas';
        } else {
            return 'fas fa-bookmark';
        }
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

// Función para obtener el progreso estimado (simulado por ahora)
function getProgresoEstimado($num_contenidos) {
    if ($num_contenidos == 0) return 0;
    // Simulamos un progreso aleatorio para demostración
    return rand(0, 100);
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
    <link rel="stylesheet" href="css/temas.css">
    <title>Temas de <?php echo htmlspecialchars($materia_info['nombre']); ?> - Babelium</title>
</head>
<body>
    <?php include_once "includes/header.php" ?>

    <main class="temas-main">
        <!-- Hero Section -->
        <section class="temas-hero <?php echo getNivelColorClass($materia_info['nivel_nombre']); ?>">
            <div class="hero-content">
                <div class="hero-badges">
                    <div class="hero-badge nivel">
                        <?php echo htmlspecialchars($materia_info['nivel_nombre']); ?>
                    </div>
                    <?php if ($materia_info['obligatoria']): ?>
                        <div class="hero-badge obligatoria">
                            <i class="fas fa-star"></i> Obligatoria
                        </div>
                    <?php else: ?>
                        <div class="hero-badge optativa">
                            <i class="fas fa-plus-circle"></i> Optativa
                        </div>
                    <?php endif; ?>
                </div>
                
                <h1><?php echo htmlspecialchars($materia_info['nombre']); ?></h1>
                
                <?php if ($materia_info['rama_nombre']): ?>
                    <div class="hero-rama">
                        <i class="fas fa-tag"></i>
                        <?php echo htmlspecialchars($materia_info['rama_nombre']); ?>
                    </div>
                <?php endif; ?>
                
                <p class="hero-description">
                    <?php echo htmlspecialchars($materia_info['descripcion']); ?>
                </p>
                
                <div class="hero-stats">
                    <div class="stat">
                        <i class="fas fa-list"></i>
                        <span><?php echo count($temas); ?> temas disponibles</span>
                    </div>
                    <?php if ($materia_info['creditos'] > 0): ?>
                    <div class="stat">
                        <i class="fas fa-clock"></i>
                        <span><?php echo $materia_info['creditos']; ?> créditos</span>
                    </div>
                    <?php endif; ?>
                    <div class="stat">
                        <i class="fas fa-file-alt"></i>
                        <span><?php echo array_sum(array_column($temas, 'num_contenidos')); ?> contenidos</span>
                    </div>
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
                <a href="cursos.php?nivel_id=<?php echo $materia_info['nivel_id']; ?>" class="breadcrumb-link">
                    <?php echo htmlspecialchars($materia_info['nivel_nombre']); ?>
                </a>
                <span class="breadcrumb-separator">></span>
                <?php if ($materia_info['rama_nombre']): ?>
                    <a href="materias.php?modalidad_id=<?php echo $materia_info['modalidad_id']; ?>" class="breadcrumb-link">
                        <?php echo htmlspecialchars($materia_info['modalidad_nombre']); ?>
                    </a>
                <?php else: ?>
                    <a href="materias.php?curso_id=<?php echo $materia_info['curso_id']; ?>" class="breadcrumb-link">
                        <?php echo htmlspecialchars($materia_info['curso_nombre']); ?>
                    </a>
                <?php endif; ?>
                <span class="breadcrumb-separator">></span>
                <span class="breadcrumb-current"><?php echo htmlspecialchars($materia_info['nombre']); ?></span>
            </div>
        </section>

        <!-- Temas Section -->
        <section class="temas-section">
            <div class="temas-container">
                <?php if (empty($temas)): ?>
                    <div class="no-temas">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>No hay temas disponibles</h3>
                        <p>Esta materia aún no tiene temas configurados.</p>
                        <?php if ($materia_info['rama_nombre']): ?>
                            <a href="materias.php?modalidad_id=<?php echo $materia_info['modalidad_id']; ?>" class="back-button">
                                <i class="fas fa-arrow-left"></i> Volver a materias
                            </a>
                        <?php else: ?>
                            <a href="materias.php?curso_id=<?php echo $materia_info['curso_id']; ?>" class="back-button">
                                <i class="fas fa-arrow-left"></i> Volver a materias
                            </a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    
                    <div class="section-header">
                        <h2>Temario del Curso</h2>
                        <p>Explora todos los temas de esta materia organizados de forma progresiva</p>
                    </div>
                    
                    <div class="temas-list">
                        <?php foreach ($temas as $index => $tema): ?>
                            <div class="tema-card <?php echo getNivelColorClass($materia_info['nivel_nombre']); ?>">
                                <div class="tema-number">
                                    <?php echo $index + 1; ?>
                                </div>
                                
                                <div class="tema-icon">
                                    <i class="<?php echo getTemaIcon($tema['titulo'], $materia_info['nombre']); ?>"></i>
                                </div>
                                
                                <div class="tema-content">
                                    <h3 class="tema-title"><?php echo htmlspecialchars($tema['titulo']); ?></h3>
                                    <p class="tema-description">
                                        <?php echo htmlspecialchars($tema['descripcion']); ?>
                                    </p>
                                    
                                    <div class="tema-info">
                                        <div class="tema-stat">
                                            <i class="fas fa-file-alt"></i>
                                            <span><?php echo $tema['num_contenidos']; ?> contenidos</span>
                                        </div>
                                        
                                        <?php if ($tema['num_contenidos'] > 0): ?>
                                            <div class="tema-stat">
                                                <i class="fas fa-chart-line"></i>
                                                <span><?php echo getProgresoEstimado($tema['num_contenidos']); ?>% progreso</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($tema['num_contenidos'] > 0): ?>
                                        <div class="tema-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: <?php echo getProgresoEstimado($tema['num_contenidos']); ?>%"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="tema-actions">
                                    <?php if ($tema['num_contenidos'] > 0): ?>
                                        <a href="contenido.php?tema_id=<?php echo $tema['id']; ?>" class="tema-button primary">
                                            <i class="fas fa-play"></i>
                                            Estudiar tema
                                        </a>
                                    <?php else: ?>
                                        <button class="tema-button disabled" disabled>
                                            <i class="fas fa-clock"></i>
                                            Próximamente
                                        </button>
                                    <?php endif; ?>
                                    
                                    <button class="tema-button secondary" onclick="toggleTemaDetails(<?php echo $tema['id']; ?>)">
                                        <i class="fas fa-info-circle"></i>
                                        Detalles
                                    </button>
                                </div>
                                
                                <div class="tema-details" id="details-<?php echo $tema['id']; ?>" style="display: none;">
                                    <div class="details-content">
                                        <h4>Información del tema</h4>
                                        <ul>
                                            <li><strong>Orden:</strong> Tema <?php echo $tema['orden']; ?></li>
                                            <li><strong>Contenidos:</strong> <?php echo $tema['num_contenidos']; ?> elementos</li>
                                            <li><strong>Estado:</strong> 
                                                <?php if ($tema['num_contenidos'] > 0): ?>
                                                    <span class="status disponible">Disponible</span>
                                                <?php else: ?>
                                                    <span class="status pendiente">En desarrollo</span>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                <?php endif; ?>
            </div>
        </section>

        <!-- Resumen de progreso -->
        <?php if (!empty($temas)): ?>
        <section class="progreso-section">
            <div class="progreso-container">
                <h2>Tu Progreso en esta Materia</h2>
                <div class="progreso-cards">
                    <div class="progreso-card">
                        <div class="progreso-icon">
                            <i class="fas fa-list-check"></i>
                        </div>
                        <div class="progreso-info">
                            <h3><?php echo count($temas); ?></h3>
                            <p>Temas totales</p>
                        </div>
                    </div>
                    
                    <div class="progreso-card">
                        <div class="progreso-icon">
                            <i class="fas fa-play-circle"></i>
                        </div>
                        <div class="progreso-info">
                            <h3><?php echo count(array_filter($temas, function($t) { return $t['num_contenidos'] > 0; })); ?></h3>
                            <p>Temas disponibles</p>
                        </div>
                    </div>
                    
                    <div class="progreso-card">
                        <div class="progreso-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="progreso-info">
                            <h3><?php echo array_sum(array_column($temas, 'num_contenidos')); ?></h3>
                            <p>Contenidos totales</p>
                        </div>
                    </div>
                    
                    <div class="progreso-card">
                        <div class="progreso-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="progreso-info">
                            <h3><?php echo rand(0, 100); ?>%</h3>
                            <p>Progreso general</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Info adicional -->
        <section class="info-adicional">
            <div class="info-container">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-route"></i>
                    </div>
                    <h3>Aprendizaje Progresivo</h3>
                    <p>Los temas están organizados de forma secuencial para facilitar tu comprensión.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <h3>Guarda tu Progreso</h3>
                    <p>Tu avance se guarda automáticamente para que puedas continuar donde lo dejaste.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <h3>Soporte Disponible</h3>
                    <p>Si tienes dudas, puedes consultar recursos adicionales o contactar con profesores.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "includes/footer.php" ?>

    <script>
        // Función para mostrar/ocultar detalles del tema
        function toggleTemaDetails(temaId) {
            const details = document.getElementById('details-' + temaId);
            const button = event.target.closest('.tema-button.secondary');
            const icon = button.querySelector('i');
            
            if (details.style.display === 'none' || details.style.display === '') {
                details.style.display = 'block';
                icon.className = 'fas fa-times';
                button.innerHTML = '<i class="fas fa-times"></i> Cerrar';
            } else {
                details.style.display = 'none';
                icon.className = 'fas fa-info-circle';
                button.innerHTML = '<i class="fas fa-info-circle"></i> Detalles';
            }
        }

        // Animación de entrada para las cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.tema-card');
            
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

            // Animación para cards de progreso
            const progresoCards = document.querySelectorAll('.progreso-card');
            progresoCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = `opacity 0.8s ease ${index * 0.2}s, transform 0.8s ease ${index * 0.2}s`;
                observer.observe(card);
            });
        });
    </script>
</body>
</html>