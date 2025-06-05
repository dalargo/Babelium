<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros - Babelium</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sobre-nosotros.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <?php include_once "includes/header.php" ?>

    <main>
    <!-- Hero Section -->
    <section class="hero-about">
        <div class="hero-content">
            <div class="hero-animation">
                <i class="fas fa-graduation-cap"></i>
                <i class="fas fa-book-open"></i>
                <i class="fas fa-users"></i>
                <i class="fas fa-globe"></i>
            </div>
            <h1>Transformando la Educación</h1>
            <p>Conoce la historia, misión y visión detrás de Babelium</p>
            <div class="scroll-indicator">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Misión y Visión -->
    <section class="mission-vision">
        <div class="container">
            <div class="section-grid">
                <div class="mission-card">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Nuestra Misión</h3>
                    <p>Democratizar el acceso a la educación de calidad mediante una plataforma digital innovadora que conecte estudiantes, educadores y contenido educativo de manera efectiva y accesible.</p>
                </div>
                <div class="vision-card">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Nuestra Visión</h3>
                    <p>Ser la plataforma educativa líder que transforme la manera en que las personas aprenden, eliminando barreras geográficas y socioeconómicas para crear un futuro más equitativo.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ¿Qué es Babelium? -->
    <section class="what-is-babelium">
        <div class="container">
            <div class="content-wrapper">
                <div class="text-content">
                    <h2>¿Qué es Babelium?</h2>
                    <p>Babelium es una plataforma educativa digital diseñada para revolucionar la forma en que accedemos y consumimos contenido educativo. Nuestro nombre se inspira en la Torre de Babel, simbolizando nuestra misión de unir diferentes idiomas, culturas y formas de aprendizaje en un solo lugar.</p>
                    
                    <div class="features-list">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Contenido educativo estructurado por niveles</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Acceso gratuito y universal</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Interfaz intuitiva y moderna</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Adaptable a diferentes dispositivos</span>
                        </div>
                    </div>
                </div>
                <div class="visual-content">
                    <div class="platform-preview">
                        <svg width="600" height="400" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
                            <!-- Fondo de la plataforma -->
                            <rect width="600" height="400" fill="#f8f9fa"/>
                            
                            <!-- Header de la plataforma -->
                            <rect width="600" height="60" fill="#667eea"/>
                            <text x="30" y="35" fill="white" font-family="Arial, sans-serif" font-size="18" font-weight="bold">Babelium</text>
                            
                            <!-- Navegación -->
                            <text x="150" y="35" fill="white" font-family="Arial, sans-serif" font-size="14">Niveles</text>
                            <text x="220" y="35" fill="white" font-family="Arial, sans-serif" font-size="14">Materias</text>
                            <text x="290" y="35" fill="white" font-family="Arial, sans-serif" font-size="14">Progreso</text>
                            
                            <!-- Icono de usuario -->
                            <circle cx="550" cy="30" r="15" fill="rgba(255,255,255,0.2)"/>
                            <text x="545" y="35" fill="white" font-family="Arial, sans-serif" font-size="12">👤</text>
                            
                            <!-- Título principal -->
                            <text x="30" y="100" fill="#333" font-family="Arial, sans-serif" font-size="24" font-weight="bold">Educación Primaria</text>
                            <text x="30" y="125" fill="#666" font-family="Arial, sans-serif" font-size="14">Explora contenido educativo de calidad</text>
                            
                            <!-- Tarjetas de materias -->
                            <!-- Matemáticas -->
                            <rect x="30" y="150" width="160" height="120" rx="10" fill="white" stroke="#e9ecef" stroke-width="1"/>
                            <rect x="30" y="150" width="160" height="4" rx="2" fill="#28a745"/>
                            <circle cx="60" cy="180" r="15" fill="#28a745"/>
                            <text x="55" y="185" fill="white" font-family="Arial, sans-serif" font-size="12">📊</text>
                            <text x="85" y="185" fill="#333" font-family="Arial, sans-serif" font-size="14" font-weight="bold">Matemáticas</text>
                            <text x="40" y="205" fill="#666" font-family="Arial, sans-serif" font-size="12">Números y operaciones</text>
                            <text x="40" y="220" fill="#666" font-family="Arial, sans-serif" font-size="12">Geometría básica</text>
                            <rect x="40" y="235" width="80" height="20" rx="10" fill="#28a745"/>
                            <text x="70" y="248" fill="white" font-family="Arial, sans-serif" font-size="10">Comenzar</text>
                            
                            <!-- Lengua -->
                            <rect x="220" y="150" width="160" height="120" rx="10" fill="white" stroke="#e9ecef" stroke-width="1"/>
                            <rect x="220" y="150" width="160" height="4" rx="2" fill="#007bff"/>
                            <circle cx="250" cy="180" r="15" fill="#007bff"/>
                            <text x="245" y="185" fill="white" font-family="Arial, sans-serif" font-size="12">📚</text>
                            <text x="275" y="185" fill="#333" font-family="Arial, sans-serif" font-size="14" font-weight="bold">Lengua</text>
                            <text x="230" y="205" fill="#666" font-family="Arial, sans-serif" font-size="12">Lectura comprensiva</text>
                            <text x="230" y="220" fill="#666" font-family="Arial, sans-serif" font-size="12">Escritura creativa</text>
                            <rect x="230" y="235" width="80" height="20" rx="10" fill="#007bff"/>
                            <text x="260" y="248" fill="white" font-family="Arial, sans-serif" font-size="10">Comenzar</text>
                            
                            <!-- Ciencias -->
                            <rect x="410" y="150" width="160" height="120" rx="10" fill="white" stroke="#e9ecef" stroke-width="1"/>
                            <rect x="410" y="150" width="160" height="4" rx="2" fill="#ffc107"/>
                            <circle cx="440" cy="180" r="15" fill="#ffc107"/>
                            <text x="435" y="185" fill="white" font-family="Arial, sans-serif" font-size="12">🔬</text>
                            <text x="465" y="185" fill="#333" font-family="Arial, sans-serif" font-size="14" font-weight="bold">Ciencias</text>
                            <text x="420" y="205" fill="#666" font-family="Arial, sans-serif" font-size="12">El cuerpo humano</text>
                            <text x="420" y="220" fill="#666" font-family="Arial, sans-serif" font-size="12">Plantas y animales</text>
                            <rect x="420" y="235" width="80" height="20" rx="10" fill="#ffc107"/>
                            <text x="450" y="248" fill="white" font-family="Arial, sans-serif" font-size="10">Comenzar</text>
                            
                            <!-- Barra de progreso general -->
                            <text x="30" y="310" fill="#333" font-family="Arial, sans-serif" font-size="16" font-weight="bold">Tu Progreso</text>
                            <rect x="30" y="320" width="540" height="8" rx="4" fill="#e9ecef"/>
                            <rect x="30" y="320" width="216" height="8" rx="4" fill="#667eea"/>
                            <text x="30" y="345" fill="#666" font-family="Arial, sans-serif" font-size="12">40% completado - ¡Sigue así!</text>
                            
                            <!-- Estadísticas -->
                            <rect x="30" y="360" width="120" height="30" rx="5" fill="rgba(103, 126, 234, 0.1)"/>
                            <text x="40" y="375" fill="#667eea" font-family="Arial, sans-serif" font-size="10">📈 12 lecciones</text>
                            <text x="40" y="385" fill="#667eea" font-family="Arial, sans-serif" font-size="10">completadas</text>
                            
                            <rect x="170" y="360" width="120" height="30" rx="5" fill="rgba(40, 167, 69, 0.1)"/>
                            <text x="180" y="375" fill="#28a745" font-family="Arial, sans-serif" font-size="10">⭐ 8 logros</text>
                            <text x="180" y="385" fill="#28a745" font-family="Arial, sans-serif" font-size="10">desbloqueados</text>
                            
                            <rect x="310" y="360" width="120" height="30" rx="5" fill="rgba(255, 193, 7, 0.1)"/>
                            <text x="320" y="375" fill="#ffc107" font-family="Arial, sans-serif" font-size="10">🎯 5 días</text>
                            <text x="320" y="385" fill="#ffc107" font-family="Arial, sans-serif" font-size="10">consecutivos</text>
                        </svg>
                        <div class="preview-overlay">
                            <i class="fas fa-play-circle"></i>
                            <span>Ver demo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- A quién nos dirigimos -->
    <section class="target-audience">
        <div class="container">
            <h2>¿A Quién Nos Dirigimos?</h2>
            <div class="audience-grid">
                <div class="audience-card">
                    <div class="card-image">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Estudiantes</h3>
                    <p>Desde educación primaria hasta universidad, ofrecemos recursos adaptados a cada nivel educativo.</p>
                </div>
                <div class="audience-card">
                    <div class="card-image">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Educadores</h3>
                    <p>Profesores y formadores que buscan herramientas digitales para enriquecer su enseñanza.</p>
                </div>
                <div class="audience-card">
                    <div class="card-image">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Familias</h3>
                    <p>Padres y tutores que desean apoyar el aprendizaje de sus hijos con recursos de calidad.</p>
                </div>
                <div class="audience-card">
                    <div class="card-image">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Autodidactas</h3>
                    <p>Personas comprometidas con el aprendizaje continuo y el desarrollo personal.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Por qué Babelium -->
    <section class="why-babelium">
        <div class="container">
            <div class="content-split">
                <div class="why-content">
                    <h2>¿Por Qué Nace Babelium?</h2>
                    <div class="reason-item">
                        <div class="reason-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="reason-text">
                            <h4>Brecha Digital Educativa</h4>
                            <p>Identificamos la necesidad urgente de democratizar el acceso a recursos educativos de calidad, especialmente tras la pandemia que evidenció las desigualdades digitales.</p>
                        </div>
                    </div>
                    <div class="reason-item">
                        <div class="reason-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="reason-text">
                            <h4>Innovación Educativa</h4>
                            <p>La educación tradicional necesita evolucionar. Creemos en el poder de la tecnología para crear experiencias de aprendizaje más efectivas y atractivas.</p>
                        </div>
                    </div>
                    <div class="reason-item">
                        <div class="reason-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="reason-text">
                            <h4>Pasión por la Educación</h4>
                            <p>Nuestro compromiso personal con la educación como motor de cambio social y desarrollo humano nos impulsa a crear soluciones innovadoras.</p>
                        </div>
                    </div>
                </div>
                <div class="stats-visual">
                    <div class="stat-item">
                        <div class="stat-number">1.6B</div>
                        <div class="stat-label">Estudiantes afectados por el cierre de escuelas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">463M</div>
                        <div class="stat-label">Niños sin acceso a educación remota</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">70%</div>
                        <div class="stat-label">Aumento en la demanda de plataformas educativas</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ODS -->
    <section class="ods-section">
        <div class="container">
            <h2>Compromiso con los Objetivos de Desarrollo Sostenible</h2>
            <p class="ods-intro">Babelium está alineado con los Objetivos de Desarrollo Sostenible de la ONU, contribuyendo activamente a un futuro más equitativo y sostenible.</p>
            
            <div class="ods-grid">
                <div class="ods-card">
                    <div class="ods-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>ODS 4: Educación de Calidad</h3>
                    <p>Garantizamos una educación inclusiva, equitativa y de calidad, promoviendo oportunidades de aprendizaje durante toda la vida para todos.</p>
                </div>
                <div class="ods-card">
                    <div class="ods-icon">
                        <i class="fas fa-equals"></i>
                    </div>
                    <h3>ODS 10: Reducción de Desigualdades</h3>
                    <p>Reducimos las desigualdades en el acceso a la educación mediante tecnología accesible y contenido gratuito.</p>
                </div>
                <div class="ods-card">
                    <div class="ods-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>ODS 17: Alianzas para los Objetivos</h3>
                    <p>Fomentamos alianzas entre educadores, estudiantes y comunidades para fortalecer el ecosistema educativo.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sobre el Creador -->
    <section class="about-creator">
        <div class="container">
            <div class="creator-content">
                <div class="creator-image">
                    <svg width="300" height="300" viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
                        <!-- Fondo circular -->
                        <circle cx="150" cy="150" r="150" fill="url(#creatorGradient)"/>
                        
                        <!-- Definir gradientes -->
                        <defs>
                            <linearGradient id="creatorGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="shirtGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#4facfe;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#00f2fe;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        
                        <!-- Cuerpo/Camisa -->
                        <ellipse cx="150" cy="280" rx="80" ry="40" fill="url(#shirtGradient)"/>
                        
                        <!-- Cuello -->
                        <rect x="135" y="240" width="30" height="40" fill="#f4c2a1" rx="15"/>
                        
                        <!-- Cara -->
                        <circle cx="150" cy="180" r="50" fill="#f4c2a1"/>
                        
                        <!-- Cabello -->
                        <path d="M 100 160 Q 150 120 200 160 Q 200 140 150 130 Q 100 140 100 160" fill="#8b4513"/>
                        
                        <!-- Ojos -->
                        <circle cx="135" cy="175" r="3" fill="#333"/>
                        <circle cx="165" cy="175" r="3" fill="#333"/>
                        
                        <!-- Cejas -->
                        <path d="M 128 168 Q 135 165 142 168" stroke="#8b4513" stroke-width="2" fill="none"/>
                        <path d="M 158 168 Q 165 165 172 168" stroke="#8b4513" stroke-width="2" fill="none"/>
                        
                        <!-- Nariz -->
                        <ellipse cx="150" cy="185" rx="2" ry="4" fill="#e6a885"/>
                        
                        <!-- Boca -->
                        <path d="M 142 195 Q 150 200 158 195" stroke="#d4956b" stroke-width="2" fill="none"/>
                        
                        <!-- Gafas (opcional, para look de desarrollador) -->
                        <circle cx="135" cy="175" r="15" fill="none" stroke="#333" stroke-width="2"/>
                        <circle cx="165" cy="175" r="15" fill="none" stroke="#333" stroke-width="2"/>
                        <line x1="150" y1="175" x2="150" y2="175" stroke="#333" stroke-width="2"/>
                        
                        <!-- Elementos tecnológicos flotantes -->
                        <g opacity="0.3">
                            <!-- Código -->
                            <text x="50" y="80" fill="white" font-family="monospace" font-size="12">&lt;/&gt;</text>
                            <text x="220" y="100" fill="white" font-family="monospace" font-size="10">{ }</text>
                            
                            <!-- Iconos de tecnología -->
                            <circle cx="80" cy="120" r="8" fill="rgba(255,255,255,0.2)"/>
                            <text x="76" y="125" fill="white" font-size="8">JS</text>
                            
                            <circle cx="230" cy="140" r="8" fill="rgba(255,255,255,0.2)"/>
                            <text x="225" y="145" fill="white" font-size="8">PHP</text>
                            
                            <circle cx="60" cy="200" r="8" fill="rgba(255,255,255,0.2)"/>
                            <text x="55" y="205" fill="white" font-size="8">CSS</text>
                            
                            <circle cx="240" cy="220" r="8" fill="rgba(255,255,255,0.2)"/>
                            <text x="234" y="225" fill="white" font-size="8">SQL</text>
                        </g>
                        
                        <!-- Partículas de inspiración -->
                        <g opacity="0.4">
                            <circle cx="70" cy="60" r="2" fill="white">
                                <animate attributeName="opacity" values="0.4;1;0.4" dur="2s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="250" cy="80" r="1.5" fill="white">
                                <animate attributeName="opacity" values="0.4;1;0.4" dur="2.5s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="40" cy="150" r="1" fill="white">
                                <animate attributeName="opacity" values="0.4;1;0.4" dur="3s" repeatCount="indefinite"/>
                            </circle>
                            <circle cx="260" cy="180" r="2" fill="white">
                                <animate attributeName="opacity" values="0.4;1;0.4" dur="1.8s" repeatCount="indefinite"/>
                            </circle>
                        </g>
                    </svg>
                    <div class="creator-badge">
                        <i class="fas fa-code"></i>
                    </div>
                </div>
                <div class="creator-info">
                    <h2>Sobre el Creador</h2>
                    <h3>Desarrollador Web & Visionario Educativo</h3>
                    <p>Como desarrollador apasionado por la tecnología educativa, he dedicado enfocar este proyecto como una herramienta para todos aquellos que quieran aprender libremente sin tener que inverter mucho en conseguirlo.</p>
                    
                    <div class="creator-stats">
                        <div class="stat">
                            <i class="fas fa-code"></i>
                            <span>Estudiante de Desarrollo de Aplicaciones Web</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Especialista diseño web</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-heart"></i>
                            <span>Comprometido con la educación y la libertad de uso</span>
                        </div>
                    </div>

                    <div class="current-focus">
                        <h4>Enfoque Actual</h4>
                        <p>Actualmente me encuentro finalizando mis estudios y desarrolando nuevas ideas para futuros proyectos de los que siento que podré hacer grandes logros con el fin de mejorar la sociedad desde haciendo uso de mis conocimientos y capacidades.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estado Actual del Proyecto -->
    <section class="project-status">
        <div class="container">
            <h2>Estado Actual del Proyecto</h2>
            <div class="status-timeline">
                <div class="timeline-item completed">
                    <div class="timeline-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Fase 1: Fundamentos</h3>
                        <p>Arquitectura base, sistema de niveles educativos y panel de administración completados.</p>
                        <span class="status-badge completed">Completado</span>
                    </div>
                </div>
                <div class="timeline-item in-progress">
                    <div class="timeline-icon">
                        <i class="fas fa-cog fa-spin"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Fase 2: Contenido y UX</h3>
                        <p>Desarrollo de sistema de contenidos, mejoras en la experiencia de usuario y optimización responsive.</p>
                        <span class="status-badge in-progress">En Progreso</span>
                    </div>
                </div>
                <div class="timeline-item planned">
                    <div class="timeline-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>Fase 3: Funcionalidades Avanzadas</h3>
                        <p>Sistema de usuarios, progreso de aprendizaje, gamificación y herramientas colaborativas.</p>
                        <span class="status-badge planned">Planificado</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ideas Futuras -->
    <section class="future-ideas">
        <div class="container">
            <h2>Visión de Futuro</h2>
            <p class="section-subtitle">Innovaciones que transformarán la experiencia educativa</p>
            
            <div class="ideas-grid">
                <div class="idea-card">
                    <div class="idea-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Inteligencia Artificial</h3>
                    <p>Tutores virtuales personalizados que adapten el contenido al ritmo y estilo de aprendizaje de cada estudiante.</p>
                    <div class="idea-timeline">Q2 2024</div>
                </div>
                
                <div class="idea-card">
                    <div class="idea-icon">
                        <i class="fas fa-vr-cardboard"></i>
                    </div>
                    <h3>Realidad Virtual</h3>
                    <p>Experiencias inmersivas para explorar conceptos complejos en entornos virtuales interactivos.</p>
                    <div class="idea-timeline">Q4 2024</div>
                </div>
                
                <div class="idea-card">
                    <div class="idea-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h3>Gamificación Avanzada</h3>
                    <p>Sistema de logros, rankings y desafíos que motiven el aprendizaje continuo.</p>
                    <div class="idea-timeline">Q3 2024</div>
                </div>
                
                <div class="idea-card">
                    <div class="idea-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Aprendizaje Colaborativo</h3>
                    <p>Herramientas para proyectos grupales, foros de discusión y mentorías entre pares.</p>
                    <div class="idea-timeline">Q1 2024</div>
                </div>
                
                <div class="idea-card">
                    <div class="idea-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>App Móvil Nativa</h3>
                    <p>Aplicación móvil con funcionalidades offline para aprender en cualquier lugar y momento.</p>
                    <div class="idea-timeline">Q2 2024</div>
                </div>
                
                <div class="idea-card">
                    <div class="idea-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics Educativo</h3>
                    <p>Dashboard avanzado para educadores con insights sobre el progreso y rendimiento de estudiantes.</p>
                    <div class="idea-timeline">Q3 2024</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Únete a la Revolución Educativa</h2>
                <p>Sé parte del cambio que está transformando la educación. Juntos podemos crear un futuro donde el aprendizaje sea accesible para todos.</p>
                <div class="cta-buttons">
                    <a href="niveles.php" class="btn-primary">
                        <i class="fas fa-rocket"></i>
                        Explorar Contenido
                    </a>
                    <a href="https://www.linkedin.com/in/dalargo" class="btn-secondary" target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-linkedin"></i>
                        Contacto
                    </a>
                </div>
            </div>
        </div>
    </section>
    </main>

    <!-- Footer -->
    <?php include_once "includes/footer.php" ?>

    <!-- Botón de volver arriba -->
    <button id="scrollToTop" class="scroll-to-top" aria-label="Volver arriba">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script src="js/sobre-nosotros.js"></script>
</body>
</html>
