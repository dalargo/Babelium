<?php
session_start();
require_once '../db/connection.php';
require_once '../includes/auth_check.php';

// Verificar que sea administrador
verificarAutenticacion('admin');

// Obtener estadísticas generales
$stats = [];

// Total de usuarios
$result = $conexion->query("SELECT COUNT(*) as total FROM usuarios WHERE activo = 1");
$stats['usuarios'] = $result->fetch_assoc()['total'];

// Total de contenidos
$result = $conexion->query("SELECT COUNT(*) as total FROM contenidos");
$stats['contenidos'] = $result->fetch_assoc()['total'];

// Total de temas
$result = $conexion->query("SELECT COUNT(*) as total FROM temas");
$stats['temas'] = $result->fetch_assoc()['total'];

// Total de materias
$result = $conexion->query("SELECT COUNT(*) as total FROM materias");
$stats['materias'] = $result->fetch_assoc()['total'];

// Usuarios por tipo
$usuarios_tipo = [];
$result = $conexion->query("SELECT tipo, COUNT(*) as total FROM usuarios WHERE activo = 1 GROUP BY tipo");
while ($row = $result->fetch_assoc()) {
  $usuarios_tipo[$row['tipo']] = $row['total'];
}

// Últimos usuarios registrados
$ultimos_usuarios = [];
$result = $conexion->query("SELECT nombre, apellidos, email, tipo, fecha_registro FROM usuarios WHERE activo = 1 ORDER BY fecha_registro DESC LIMIT 5");
while ($row = $result->fetch_assoc()) {
  $ultimos_usuarios[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/admin.css">
  <title>Panel de Administración - Babelium</title>
</head>
<body>
  <?php include_once "../includes/admin_header.php" ?>

  <div class="admin-container">
      <aside class="admin-sidebar">
          <div class="sidebar-header">
              <h3><i class="fas fa-cogs"></i> Panel de Control</h3>
          </div>
          <nav class="sidebar-nav">
              <!-- Dashboard -->
              <a href="dashboard.php" class="nav-item active">
                  <i class="fas fa-tachometer-alt"></i>
                  Dashboard
              </a>
              
              <!-- Gestión de Usuarios -->
              <a href="usuarios.php" class="nav-item">
                  <i class="fas fa-users"></i>
                  Usuarios
              </a>
              
              <!-- Separador -->
              <div class="nav-separator">Gestión Académica</div>
              
              <a href="niveles.php" class="nav-item">
                  <i class="fas fa-layer-group"></i>
                  Niveles Educativos
              </a>
              
              <a href="cursos.php" class="nav-item">
                  <i class="fas fa-graduation-cap"></i>
                  Cursos
              </a>
              
              <a href="modalidades.php" class="nav-item">
                  <i class="fas fa-sitemap"></i>
                  Modalidades
              </a>
              
              <a href="materias.php" class="nav-item">
                  <i class="fas fa-book"></i>
                  Materias
              </a>
              
              <a href="temas.php" class="nav-item">
                  <i class="fas fa-list"></i>
                  Temas
              </a>
              
              <!-- Separador -->
              <div class="nav-separator">Contenidos</div>
              
              <a href="contenidos.php" class="nav-item">
                  <i class="fas fa-file-alt"></i>
                  Gestión de Contenidos
              </a>
              
              <!-- Separador -->
              <div class="nav-separator">Herramientas</div>
              
              <a href="estadisticas.php" class="nav-item">
                  <i class="fas fa-chart-bar"></i>
                  Estadísticas
              </a>
              
              <a href="configuracion.php" class="nav-item">
                  <i class="fas fa-cog"></i>
                  Configuración
              </a>
          </nav>
      </aside>

      <main class="admin-main">
          <div class="admin-header">
              <h1>Dashboard</h1>
              <p>Bienvenido al panel de administración, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></p>
          </div>

          <!-- Estadísticas generales -->
          <div class="stats-grid">
              <div class="stat-card">
                  <div class="stat-icon">
                      <i class="fas fa-users"></i>
                  </div>
                  <div class="stat-content">
                      <h3><?php echo $stats['usuarios']; ?></h3>
                      <p>Usuarios Activos</p>
                  </div>
              </div>

              <div class="stat-card">
                  <div class="stat-icon">
                      <i class="fas fa-book"></i>
                  </div>
                  <div class="stat-content">
                      <h3><?php echo $stats['contenidos']; ?></h3>
                      <p>Contenidos</p>
                  </div>
              </div>

              <div class="stat-card">
                  <div class="stat-icon">
                      <i class="fas fa-list"></i>
                  </div>
                  <div class="stat-content">
                      <h3><?php echo $stats['temas']; ?></h3>
                      <p>Temas</p>
                  </div>
              </div>

              <div class="stat-card">
                  <div class="stat-icon">
                      <i class="fas fa-graduation-cap"></i>
                  </div>
                  <div class="stat-content">
                      <h3><?php echo $stats['materias']; ?></h3>
                      <p>Materias</p>
                  </div>
              </div>
          </div>

          <!-- Resto del contenido del dashboard original -->
          <div class="dashboard-grid">
              <!-- Distribución de usuarios -->
              <div class="dashboard-card">
                  <div class="card-header">
                      <h3><i class="fas fa-pie-chart"></i> Distribución de Usuarios</h3>
                  </div>
                  <div class="card-content">
                      <div class="user-distribution">
                          <?php foreach ($usuarios_tipo as $tipo => $total): ?>
                              <div class="user-type">
                                  <span class="type-label"><?php echo ucfirst($tipo); ?>:</span>
                                  <span class="type-count"><?php echo $total; ?></span>
                                  <div class="type-bar">
                                      <div class="type-fill" style="width: <?php echo ($total / $stats['usuarios']) * 100; ?>%"></div>
                                  </div>
                              </div>
                          <?php endforeach; ?>
                      </div>
                  </div>
              </div>

              <!-- Últimos usuarios -->
              <div class="dashboard-card">
                  <div class="card-header">
                      <h3><i class="fas fa-user-plus"></i> Últimos Usuarios Registrados</h3>
                  </div>
                  <div class="card-content">
                      <div class="recent-users">
                          <?php foreach ($ultimos_usuarios as $usuario): ?>
                              <div class="user-item">
                                  <div class="user-avatar">
                                      <i class="fas fa-user"></i>
                                  </div>
                                  <div class="user-info">
                                      <strong><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?></strong>
                                      <small><?php echo htmlspecialchars($usuario['email']); ?></small>
                                      <span class="user-type-badge <?php echo $usuario['tipo']; ?>">
                                          <?php echo ucfirst($usuario['tipo']); ?>
                                      </span>
                                  </div>
                                  <div class="user-date">
                                      <?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?>
                                  </div>
                              </div>
                          <?php endforeach; ?>
                      </div>
                  </div>
              </div>

              <!-- Acciones rápidas -->
              <div class="dashboard-card">
                  <div class="card-header">
                      <h3><i class="fas fa-bolt"></i> Acciones Rápidas</h3>
                  </div>
                  <div class="card-content">
                      <div class="quick-actions">
                          <a href="usuarios.php?action=create" class="quick-action">
                              <i class="fas fa-user-plus"></i>
                              <span>Crear Usuario</span>
                          </a>
                          <a href="contenidos.php?action=create" class="quick-action">
                              <i class="fas fa-plus"></i>
                              <span>Nuevo Contenido</span>
                          </a>
                          <a href="niveles.php" class="quick-action">
                              <i class="fas fa-layer-group"></i>
                              <span>Gestionar Niveles</span>
                          </a>
                          <a href="../index.php" class="quick-action">
                              <i class="fas fa-eye"></i>
                              <span>Ver Sitio Web</span>
                          </a>
                      </div>
                  </div>
              </div>

              <!-- Estado del sistema -->
              <div class="dashboard-card">
                  <div class="card-header">
                      <h3><i class="fas fa-server"></i> Estado del Sistema</h3>
                  </div>
                  <div class="card-content">
                      <div class="system-status">
                          <div class="status-item">
                              <span class="status-label">Base de Datos:</span>
                              <span class="status-value online">
                                  <i class="fas fa-circle"></i> Conectada
                              </span>
                          </div>
                          <div class="status-item">
                              <span class="status-label">Servidor Web:</span>
                              <span class="status-value online">
                                  <i class="fas fa-circle"></i> Funcionando
                              </span>
                          </div>
                          <div class="status-item">
                              <span class="status-label">Última actualización:</span>
                              <span class="status-value">
                                  <?php echo date('d/m/Y H:i'); ?>
                              </span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </main>
  </div>

  <script>
      // Auto-refresh cada 5 minutos
      setTimeout(function() {
          location.reload();
      }, 300000);

      // Animación de las barras de progreso
      document.addEventListener('DOMContentLoaded', function() {
          const bars = document.querySelectorAll('.type-fill');
          bars.forEach(bar => {
              const width = bar.style.width;
              bar.style.width = '0%';
              setTimeout(() => {
                  bar.style.width = width;
              }, 500);
          });
      });
  </script>
  
  <style>
      .nav-separator {
          padding: 0.5rem 1.5rem;
          color: rgba(255,255,255,0.6);
          font-size: 0.8rem;
          font-weight: 600;
          text-transform: uppercase;
          border-top: 1px solid rgba(255,255,255,0.1);
          margin-top: 1rem;
      }
      
      .nav-separator:first-of-type {
          margin-top: 1rem;
      }
  </style>
</body>
</html>