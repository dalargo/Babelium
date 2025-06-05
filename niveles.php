<?php
require_once "db/connection.php";

// Consulta para obtener los niveles educativos
$query = "SELECT id, nombre, descripcion, orden FROM niveles_educativos WHERE activo = 1 ORDER BY orden ASC";
$resultado = $conexion->query($query);

// Obtener los resultados
$niveles = [];
if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $niveles[] = $fila;
    }
}

// Función para obtener el icono según el nivel
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

// Función para obtener el color según el nivel
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/niveles.css">
    <title>Niveles Educativos - Babelium</title>
</head>
<body>
    <?php include_once "includes/header.php" ?>

    <main class="niveles-main">
        <!-- Hero Section -->
        <section class="niveles-hero">
            <div class="hero-content">
                <h1>Niveles Educativos</h1>
                <p class="hero-description">
                    Explora todos los niveles educativos oficiales de España. 
                    Desde Educación Primaria hasta estudios universitarios, 
                    encuentra el contenido que necesitas para continuar tu formación.
                </p>
            </div>
        </section>

        <!-- Breadcrumb -->
        <section class="breadcrumb">
            <div class="breadcrumb-container">
                <a href="index.php" class="breadcrumb-link">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <span class="breadcrumb-separator">></span>
                <span class="breadcrumb-current">Niveles Educativos</span>
            </div>
        </section>

        <!-- Niveles Grid -->
        <section class="niveles-section">
            <div class="niveles-container">
                <?php if (empty($niveles)): ?>
                    <div class="no-niveles">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>No hay niveles educativos disponibles</h3>
                        <p>Por favor, contacta con el administrador del sistema.</p>
                    </div>
                <?php else: ?>
                    <div class="niveles-grid">
                        <?php foreach ($niveles as $nivel): ?>
                            <div class="nivel-card <?php echo getNivelColor($nivel['nombre']); ?>" id="<?php echo getNivelColor($nivel['nombre']); ?>">
                                <div class="nivel-icon">
                                    <i class="<?php echo getNivelIcon($nivel['nombre']); ?>"></i>
                                </div>
                                <div class="nivel-content">
                                    <h3 class="nivel-title"><?php echo htmlspecialchars($nivel['nombre']); ?></h3>
                                    <p class="nivel-description">
                                        <?php echo htmlspecialchars($nivel['descripcion']); ?>
                                    </p>
                                </div>
                                <div class="nivel-footer">
                                    <a href="cursos.php?nivel_id=<?php echo $nivel['id']; ?>" class="nivel-button">
                                        Explorar cursos
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Info Section -->
        <section class="info-section">
            <div class="info-container">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Educación Oficial</h3>
                    <p>Todos nuestros contenidos están alineados con el currículo educativo oficial de España.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>A tu ritmo</h3>
                    <p>Estudia cuando quieras y donde quieras, sin límites de tiempo ni restricciones.</p>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Totalmente gratuito</h3>
                    <p>Accede a todo el contenido educativo sin coste alguno, como parte de nuestro compromiso con los ODS.</p>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "includes/footer.php" ?>

    <script>
        // Animación de entrada para las cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.nivel-card');
            
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
        });
    </script>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>