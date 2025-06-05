<?php
// Incluir archivo de conexión
require_once 'db/connection.php';

// Obtener el ID del tema desde la URL
$tema_id = isset($_GET['tema_id']) ? (int)$_GET['tema_id'] : 0;
$contenido_id = isset($_GET['contenido_id']) ? (int)$_GET['contenido_id'] : 0;

// Variables para almacenar información
$tema_info = null;
$materia_info = null;
$contenidos = [];
$contenido_actual = null;
$contenido_index = 0;

if ($tema_id > 0) {
    // Obtener información completa del tema, materia, curso y nivel
    $query_tema = "SELECT t.id, t.titulo, t.descripcion, t.orden as tema_orden,
                         m.id as materia_id, m.nombre as materia_nombre,
                         mc.id as modalidad_id, mc.nombre as modalidad_nombre,
                         c.id as curso_id, c.nombre as curso_nombre,
                         ne.id as nivel_id, ne.nombre as nivel_nombre,
                         r.nombre as rama_nombre
                  FROM temas t
                  JOIN materias m ON t.materia_id = m.id
                  JOIN modalidades_curso mc ON m.modalidad_curso_id = mc.id
                  JOIN cursos c ON mc.curso_id = c.id
                  JOIN niveles_educativos ne ON c.nivel_id = ne.id
                  LEFT JOIN ramas r ON mc.rama_id = r.id
                  WHERE t.id = $tema_id AND t.activo = 1";
    
    $resultado_tema = $conexion->query($query_tema);
    $tema_info = $resultado_tema ? $resultado_tema->fetch_assoc() : null;
    
    if (!$tema_info) {
        header("Location: niveles.php");
        exit();
    }
    
    // Obtener todos los contenidos del tema
    $query_contenidos = "SELECT id, tipo, titulo, contenido, url, orden, fecha_creacion
                        FROM contenidos 
                        WHERE tema_id = $tema_id AND activo = 1 
                        ORDER BY orden ASC";
    
    $resultado_contenidos = $conexion->query($query_contenidos);
    if ($resultado_contenidos && $resultado_contenidos->num_rows > 0) {
        while ($fila = $resultado_contenidos->fetch_assoc()) {
            $contenidos[] = $fila;
        }
    }
    
    // Determinar el contenido actual
    if ($contenido_id > 0) {
        foreach ($contenidos as $index => $contenido) {
            if ($contenido['id'] == $contenido_id) {
                $contenido_actual = $contenido;
                $contenido_index = $index;
                break;
            }
        }
    } else if (!empty($contenidos)) {
        $contenido_actual = $contenidos[0];
        $contenido_index = 0;
    }
    
} else {
    header("Location: niveles.php");
    exit();
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

// Función para obtener el icono según el tipo de contenido
function getContenidoIcon($tipo) {
    switch ($tipo) {
        case 'texto':
            return 'fas fa-file-alt';
        case 'imagen':
            return 'fas fa-image';
        case 'video':
            return 'fas fa-play-circle';
        case 'archivo':
            return 'fas fa-file-download';
        case 'enlace':
            return 'fas fa-external-link-alt';
        default:
            return 'fas fa-file';
    }
}

// Función para formatear el contenido según su tipo
function formatearContenido($contenido) {
    $tipo = $contenido['tipo'];
    $texto = $contenido['contenido'];
    $url = $contenido['url'];
    
    switch ($tipo) {
        case 'texto':
            return '<div class="contenido-texto">' . nl2br(htmlspecialchars($texto)) . '</div>';
        case 'imagen':
            $src = $url ?: '/placeholder.svg?height=400&width=600&text=' . urlencode($contenido['titulo']);
            return '<div class="contenido-imagen">
                        <img src="' . htmlspecialchars($src) . '" alt="' . htmlspecialchars($contenido['titulo']) . '" />
                        <p class="imagen-descripcion">' . htmlspecialchars($texto) . '</p>
                    </div>';
        case 'video':
            if ($url) {
                return '<div class="contenido-video">
                            <video controls>
                                <source src="' . htmlspecialchars($url) . '" type="video/mp4">
                                Tu navegador no soporta el elemento video.
                            </video>
                            <p class="video-descripcion">' . htmlspecialchars($texto) . '</p>
                        </div>';
            } else {
                return '<div class="contenido-placeholder">
                            <i class="fas fa-play-circle"></i>
                            <h4>' . htmlspecialchars($contenido['titulo']) . '</h4>
                            <p>' . htmlspecialchars($texto) . '</p>
                            <small>Video no disponible</small>
                        </div>';
            }
        case 'archivo':
            if ($url) {
                return '<div class="contenido-archivo">
                            <a href="' . htmlspecialchars($url) . '" download class="archivo-link">
                                <i class="fas fa-file-download"></i>
                                <span>Descargar: ' . htmlspecialchars($contenido['titulo']) . '</span>
                            </a>
                            <p class="archivo-descripcion">' . htmlspecialchars($texto) . '</p>
                        </div>';
            } else {
                return '<div class="contenido-placeholder">
                            <i class="fas fa-file"></i>
                            <h4>' . htmlspecialchars($contenido['titulo']) . '</h4>
                            <p>' . htmlspecialchars($texto) . '</p>
                            <small>Archivo no disponible</small>
                        </div>';
            }
        case 'enlace':
            if ($url) {
                return '<div class="contenido-enlace">
                            <a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer" class="enlace-externo">
                                <i class="fas fa-external-link-alt"></i>
                                <span>' . htmlspecialchars($contenido['titulo']) . '</span>
                            </a>
                            <p class="enlace-descripcion">' . htmlspecialchars($texto) . '</p>
                        </div>';
            } else {
                return '<div class="contenido-placeholder">
                            <i class="fas fa-link"></i>
                            <h4>' . htmlspecialchars($contenido['titulo']) . '</h4>
                            <p>' . htmlspecialchars($texto) . '</p>
                            <small>Enlace no disponible</small>
                        </div>';
            }
        default:
            return '<div class="contenido-texto">' . nl2br(htmlspecialchars($texto)) . '</div>';
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
    <link rel="stylesheet" href="css/contenido.css">
    <title><?php echo htmlspecialchars($tema_info['titulo']); ?> - Babelium</title>
</head>
<body>
    <?php include_once "includes/header.php" ?>

    <main class="contenido-main">
        <!-- Hero Section -->
        <section class="contenido-hero <?php echo getNivelColorClass($tema_info['nivel_nombre']); ?>">
            <div class="hero-content">
                <div class="hero-badges">
                    <div class="hero-badge nivel">
                        <?php echo htmlspecialchars($tema_info['nivel_nombre']); ?>
                    </div>
                    <div class="hero-badge materia">
                        <?php echo htmlspecialchars($tema_info['materia_nombre']); ?>
                    </div>
                </div>
                
                <h1><?php echo htmlspecialchars($tema_info['titulo']); ?></h1>
                
                <p class="hero-description">
                    <?php echo htmlspecialchars($tema_info['descripcion']); ?>
                </p>
                
                <div class="hero-stats">
                    <div class="stat">
                        <i class="fas fa-list"></i>
                        <span><?php echo count($contenidos); ?> contenidos</span>
                    </div>
                    <?php if ($contenido_actual): ?>
                    <div class="stat">
                        <i class="fas fa-bookmark"></i>
                        <span>Contenido <?php echo $contenido_index + 1; ?> de <?php echo count($contenidos); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="stat">
                        <i class="fas fa-clock"></i>
                        <span>~<?php echo count($contenidos) * 5; ?> min</span>
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
                <a href="cursos.php?nivel_id=<?php echo $tema_info['nivel_id']; ?>" class="breadcrumb-link">
                    <?php echo htmlspecialchars($tema_info['nivel_nombre']); ?>
                </a>
                <span class="breadcrumb-separator">></span>
                <?php if ($tema_info['rama_nombre']): ?>
                    <a href="materias.php?modalidad_id=<?php echo $tema_info['modalidad_id']; ?>" class="breadcrumb-link">
                        <?php echo htmlspecialchars($tema_info['modalidad_nombre']); ?>
                    </a>
                <?php else: ?>
                    <a href="materias.php?curso_id=<?php echo $tema_info['curso_id']; ?>" class="breadcrumb-link">
                        <?php echo htmlspecialchars($tema_info['curso_nombre']); ?>
                    </a>
                <?php endif; ?>
                <span class="breadcrumb-separator">></span>
                <a href="temas.php?materia_id=<?php echo $tema_info['materia_id']; ?>" class="breadcrumb-link">
                    <?php echo htmlspecialchars($tema_info['materia_nombre']); ?>
                </a>
                <span class="breadcrumb-separator">></span>
                <span class="breadcrumb-current"><?php echo htmlspecialchars($tema_info['titulo']); ?></span>
            </div>
        </section>

        <!-- Contenido Principal -->
        <section class="contenido-section">
            <div class="contenido-container">
                
                <?php if (empty($contenidos)): ?>
                    <div class="no-contenidos">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>No hay contenidos disponibles</h3>
                        <p>Este tema aún no tiene contenidos configurados.</p>
                        <a href="temas.php?materia_id=<?php echo $tema_info['materia_id']; ?>" class="back-button">
                            <i class="fas fa-arrow-left"></i> Volver a temas
                        </a>
                    </div>
                <?php else: ?>
                
                    <!-- Sidebar con lista de contenidos -->
                    <aside class="contenidos-sidebar">
                        <div class="sidebar-header">
                            <h3>Contenidos del tema</h3>
                            <div class="progreso-tema">
                                <div class="progreso-bar">
                                    <div class="progreso-fill" style="width: <?php echo round(($contenido_index + 1) / count($contenidos) * 100); ?>%"></div>
                                </div>
                                <span class="progreso-text"><?php echo $contenido_index + 1; ?>/<?php echo count($contenidos); ?></span>
                            </div>
                        </div>
                        
                        <nav class="contenidos-nav">
                            <?php foreach ($contenidos as $index => $contenido): ?>
                                <a href="contenido.php?tema_id=<?php echo $tema_id; ?>&contenido_id=<?php echo $contenido['id']; ?>" 
                                   class="contenido-nav-item <?php echo ($contenido['id'] == ($contenido_actual['id'] ?? 0)) ? 'active' : ''; ?>">
                                    <div class="nav-item-icon">
                                        <i class="<?php echo getContenidoIcon($contenido['tipo']); ?>"></i>
                                    </div>
                                    <div class="nav-item-content">
                                        <h4><?php echo htmlspecialchars($contenido['titulo']); ?></h4>
                                        <span class="nav-item-tipo"><?php echo ucfirst($contenido['tipo']); ?></span>
                                    </div>
                                    <div class="nav-item-number">
                                        <?php echo $index + 1; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </nav>
                    </aside>

                    <!-- Contenido principal -->
                    <main class="contenido-principal">
                        <?php if ($contenido_actual): ?>
                            
                            <article class="contenido-article">
                                <header class="contenido-header">
                                    <div class="contenido-meta">
                                        <span class="contenido-tipo">
                                            <i class="<?php echo getContenidoIcon($contenido_actual['tipo']); ?>"></i>
                                            <?php echo ucfirst($contenido_actual['tipo']); ?>
                                        </span>
                                        <span class="contenido-numero">
                                            Contenido <?php echo $contenido_index + 1; ?> de <?php echo count($contenidos); ?>
                                        </span>
                                    </div>
                                    <h2><?php echo htmlspecialchars($contenido_actual['titulo']); ?></h2>
                                </header>

                                <div class="contenido-body">
                                    <?php echo formatearContenido($contenido_actual); ?>
                                </div>

                                <footer class="contenido-footer">
                                    <div class="contenido-actions">
                                        <button class="action-button completar" onclick="marcarCompletado(<?php echo $contenido_actual['id']; ?>)">
                                            <i class="fas fa-check"></i>
                                            Marcar como completado
                                        </button>
                                        
                                        <button class="action-button favorito" onclick="toggleFavorito(<?php echo $contenido_actual['id']; ?>)">
                                            <i class="far fa-heart"></i>
                                            Añadir a favoritos
                                        </button>
                                    </div>
                                </footer>
                            </article>

                            <!-- Navegación entre contenidos -->
                            <nav class="contenido-navigation">
                                <?php if ($contenido_index > 0): ?>
                                    <a href="contenido.php?tema_id=<?php echo $tema_id; ?>&contenido_id=<?php echo $contenidos[$contenido_index - 1]['id']; ?>" 
                                       class="nav-button prev">
                                        <div class="arrow-direction">
                                            <i class="fas fa-chevron-left aligned-icon"></i>
                                            <span>Anterior</span>
                                        </div>
                                        <small><?php echo htmlspecialchars($contenidos[$contenido_index - 1]['titulo']); ?></small>
                                    </a>
                                <?php endif; ?>

                                <?php if ($contenido_index < count($contenidos) - 1): ?>
                                    <a href="contenido.php?tema_id=<?php echo $tema_id; ?>&contenido_id=<?php echo $contenidos[$contenido_index + 1]['id']; ?>" 
                                       class="nav-button next">
                                        <div class="arrow-direction"> 
                                            <span>Siguiente</span>
                                            <i class="fas fa-chevron-right aligned-icon"></i>
                                        </div>
                                        <small><?php echo htmlspecialchars($contenidos[$contenido_index + 1]['titulo']); ?></small>
                                    </a>
                                <?php else: ?>
                                    <a href="temas.php?materia_id=<?php echo $tema_info['materia_id']; ?>" 
                                       class="nav-button complete">
                                        <span>Tema completado</span>
                                        <i class="fas fa-trophy"></i>
                                        <small>Volver a temas</small>
                                    </a>
                                <?php endif; ?>
                            </nav>
                            
                        <?php endif; ?>
                    </main>
                    
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include_once "includes/footer.php" ?>

    <script>
        // Función para marcar contenido como completado
        function marcarCompletado(contenidoId) {
            const button = event.target.closest('.completar');
            const icon = button.querySelector('i');
            const text = button.querySelector('span') || button;
            
            // Simular marcado como completado
            if (button.classList.contains('completado')) {
                button.classList.remove('completado');
                icon.className = 'fas fa-check';
                text.textContent = 'Marcar como completado';
            } else {
                button.classList.add('completado');
                icon.className = 'fas fa-check-circle';
                text.textContent = 'Completado';
                
                // Mostrar mensaje de éxito
                mostrarNotificacion('Contenido marcado como completado', 'success');
            }
        }

        // Función para toggle favorito
        function toggleFavorito(contenidoId) {
            const button = event.target.closest('.favorito');
            const icon = button.querySelector('i');
            const text = button.querySelector('span') || button;
            
            if (button.classList.contains('favorito-activo')) {
                button.classList.remove('favorito-activo');
                icon.className = 'far fa-heart';
                text.textContent = 'Añadir a favoritos';
                mostrarNotificacion('Eliminado de favoritos', 'info');
            } else {
                button.classList.add('favorito-activo');
                icon.className = 'fas fa-heart';
                text.textContent = 'En favoritos';
                mostrarNotificacion('Añadido a favoritos', 'success');
            }
        }

        // Función para mostrar notificaciones
        function mostrarNotificacion(mensaje, tipo = 'info') {
            const notificacion = document.createElement('div');
            notificacion.className = `notificacion ${tipo}`;
            notificacion.innerHTML = `
                <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'info-circle'}"></i>
                <span>${mensaje}</span>
            `;
            
            document.body.appendChild(notificacion);
            
            // Mostrar notificación
            setTimeout(() => notificacion.classList.add('show'), 100);
            
            // Ocultar después de 3 segundos
            setTimeout(() => {
                notificacion.classList.remove('show');
                setTimeout(() => document.body.removeChild(notificacion), 300);
            }, 3000);
        }

        // Navegación con teclado
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                const prevButton = document.querySelector('.nav-button.prev');
                if (prevButton) prevButton.click();
            } else if (e.key === 'ArrowRight') {
                const nextButton = document.querySelector('.nav-button.next');
                if (nextButton) nextButton.click();
            }
        });

        // Auto-scroll del sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const activeItem = document.querySelector('.contenido-nav-item.active');
            if (activeItem) {
                activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    </script>
</body>
</html>