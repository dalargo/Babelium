<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Babelium</title>
</head>
<body>
    <?php include_once "includes/header.php" ?>

    <main class="main-content">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Babelium</h1>
                <p class="tagline">Educación sin límites para todos</p>
                <p class="description">Retoma o amplía tus estudios sin barreras económicas ni temporales. Accede a todos los niveles educativos oficiales de España.</p>
                <a href="#cursos" class="cta-button">Explorar cursos</a>
            </div>
            <div class="hero-image">
                <img src="img/education-illustration.svg" alt="Ilustración de educación inclusiva">
            </div>
        </section>

        <!-- ODS Section -->
        <section class="ods-section">
            <h2>Comprometidos con los Objetivos de Desarrollo Sostenible</h2>
            <div class="ods-container">
                <div class="ods-card">
                    <div class="ods-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3>Educación de Calidad</h3>
                    <p>Garantizamos acceso a una educación inclusiva, equitativa y de calidad para todos.</p>
                </div>
                <div class="ods-card">
                    <div class="ods-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Reducción de Desigualdades</h3>
                    <p>Eliminamos barreras económicas para que todos puedan acceder al conocimiento.</p>
                </div>
                <div class="ods-card">
                    <div class="ods-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Comunidades Sostenibles</h3>
                    <p>Fomentamos el desarrollo personal y profesional para construir comunidades más fuertes.</p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <h2>¿Por qué elegir Babelium?</h2>
            <div class="features-container">
                <div class="feature">
                    <i class="fas fa-infinity"></i>
                    <h3>Sin límite de tiempo</h3>
                    <p>Estudia a tu ritmo, cuando quieras y donde quieras.</p>
                </div>
                <div class="feature">
                    <i class="fas fa-euro-sign"></i>
                    <h3>Totalmente gratuito</h3>
                    <p>Accede a todo el contenido sin costes adicionales ni suscripciones.</p>
                </div>
                <div class="feature">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Todos los niveles</h3>
                    <p>Desde primaria hasta estudios superiores, encuentra lo que necesitas.</p>
                </div>
                <div class="feature">
                    <i class="fas fa-certificate"></i>
                    <h3>Contenido oficial</h3>
                    <p>Materiales alineados con el currículo educativo español.</p>
                </div>
            </div>
        </section>

        <!-- Courses Preview Section -->
        <section id="cursos" class="courses-section">
            <h2>Explora nuestros niveles educativos</h2>
            <div class="courses-container">
                <div class="course-level">
                    <div class="course-icon">
                        <i class="fas fa-child"></i>
                    </div>
                    <h3>Educación Primaria</h3>
                    <p>6-12 años</p>
                    <a href="#" class="level-link">Ver cursos</a>
                </div>
                <div class="course-level">
                    <div class="course-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <h3>Educación Secundaria</h3>
                    <p>12-16 años</p>
                    <a href="#" class="level-link">Ver cursos</a>
                </div>
                <div class="course-level">
                    <div class="course-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Bachillerato</h3>
                    <p>16-18 años</p>
                    <a href="#" class="level-link">Ver cursos</a>
                </div>
                <div class="course-level">
                    <div class="course-icon">
                        <i class="fas fa-university"></i>
                    </div>
                    <h3>Formación Profesional</h3>
                    <p>Grado medio y superior</p>
                    <a href="#" class="level-link">Ver cursos</a>
                </div>
                <div class="course-level">
                    <div class="course-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3>Universidad</h3>
                    <p>Estudios superiores</p>
                    <a href="#" class="level-link">Ver cursos</a>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="cta-section">
            <div class="cta-content">
                <h2>Comienza tu viaje educativo hoy mismo</h2>
                <p>Únete a miles de estudiantes que ya están ampliando sus conocimientos con Babelium.</p>
                <div class="cta-buttons">
                    <a href="#cursos" class="cta-button">Explorar cursos</a>
                    <a href="#" class="secondary-button">Saber más</a>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "includes/footer.php" ?>

    <script>
        // Simple smooth scroll for the "Explorar cursos" button
        document.addEventListener('DOMContentLoaded', function() {
            const ctaButtons = document.querySelectorAll('a[href="#cursos"]');
            ctaButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('#cursos').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });
    </script>
</body>
</html>