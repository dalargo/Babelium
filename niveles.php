<?php
require_once "db/connection.php";
require_once "php/niveles-functions.php";

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

    <script src="js/niveles-animations.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conexion->close();
?>
