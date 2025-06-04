<?php
session_start();
require_once '../db/connection.php';
require_once '../includes/auth_check.php';

// Verificar que sea administrador
verificarAutenticacion('admin');

$mensaje = '';
$tipo_mensaje = '';

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  
  if ($action === 'create') {
      // Crear nuevo usuario
      $nombre = trim($_POST['nombre']);
      $apellidos = trim($_POST['apellidos']);
      $email = trim($_POST['email']);
      $tipo = $_POST['tipo'];
      $password = $_POST['password'];
      $identificador = trim($_POST['identificador']);
      
      // Validaciones básicas
      if (empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
          $mensaje = 'Todos los campos son obligatorios.';
          $tipo_mensaje = 'error';
      } else {
          // Verificar si el email ya existe
          $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
          $stmt->bind_param("s", $email);
          $stmt->execute();
          
          if ($stmt->get_result()->num_rows > 0) {
              $mensaje = 'El email ya está registrado.';
              $tipo_mensaje = 'error';
          } else {
              // Crear usuario
              $password_hash = password_hash($password, PASSWORD_DEFAULT);
              $stmt = $conexion->prepare("INSERT INTO usuarios (tipo, identificador, nombre, apellidos, email, password, activo, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, 1, NOW())");
              $stmt->bind_param("ssssss", $tipo, $identificador, $nombre, $apellidos, $email, $password_hash);
              
              if ($stmt->execute()) {
                  $mensaje = 'Usuario creado exitosamente.';
                  $tipo_mensaje = 'success';
              } else {
                  $mensaje = 'Error al crear el usuario.';
                  $tipo_mensaje = 'error';
              }
          }
          $stmt->close();
      }
  }
}

// Obtener lista de usuarios
$usuarios = [];
$result = $conexion->query("SELECT id, tipo, identificador, nombre, apellidos, email, activo, fecha_registro FROM usuarios ORDER BY fecha_registro DESC");
while ($row = $result->fetch_assoc()) {
  $usuarios[] = $row;
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
  <link rel="stylesheet" href="../css/admin-usuarios.css">
  <link rel="stylesheet" href="../css/components.css">
  <title>Gestión de Usuarios - Babelium Admin</title>
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
              <a href="dashboard.php" class="nav-item">
                  <i class="fas fa-tachometer-alt"></i>
                  Dashboard
              </a>
              
              <!-- Gestión de Usuarios -->
              <a href="usuarios.php" class="nav-item active">
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
              <h1>Gestión de Usuarios</h1>
              <p>Administra los usuarios del sistema</p>
          </div>

          <?php if ($mensaje): ?>
              <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                  <i class="fas fa-<?php echo $tipo_mensaje === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                  <?php echo htmlspecialchars($mensaje); ?>
              </div>
          <?php endif; ?>

          <div class="admin-actions">
              <button class="btn btn-primary" onclick="toggleCreateForm()">
                  <i class="fas fa-plus"></i> Crear Usuario
              </button>
          </div>

          <!-- Formulario de creación -->
          <div id="createForm" class="form-container" style="display: none;">
              <div class="form-card">
                  <div class="form-header">
                      <h3><i class="fas fa-user-plus"></i> Crear Nuevo Usuario</h3>
                      <button class="close-btn" onclick="toggleCreateForm()">
                          <i class="fas fa-times"></i>
                      </button>
                  </div>
                  <form method="POST" class="admin-form">
                      <input type="hidden" name="action" value="create">
                      
                      <div class="form-row">
                          <div class="form-group">
                              <label for="nombre">Nombre *</label>
                              <input type="text" id="nombre" name="nombre" required>
                          </div>
                          <div class="form-group">
                              <label for="apellidos">Apellidos *</label>
                              <input type="text" id="apellidos" name="apellidos" required>
                          </div>
                      </div>

                      <div class="form-row">
                          <div class="form-group">
                              <label for="email">Email *</label>
                              <input type="email" id="email" name="email" required>
                          </div>
                          <div class="form-group">
                              <label for="tipo">Tipo de Usuario *</label>
                              <select id="tipo" name="tipo" required>
                                  <option value="">Seleccionar...</option>
                                  <option value="alumno">Alumno</option>
                                  <option value="profesor">Profesor</option>
                                  <option value="admin">Administrador</option>
                              </select>
                          </div>
                      </div>

                      <div class="form-row">
                          <div class="form-group">
                              <label for="identificador">Identificador</label>
                              <input type="text" id="identificador" name="identificador" placeholder="DNI, NIE, etc.">
                          </div>
                          <div class="form-group">
                              <label for="password">Contraseña *</label>
                              <input type="password" id="password" name="password" required>
                          </div>
                      </div>

                      <div class="form-actions">
                          <button type="button" class="btn btn-secondary" onclick="toggleCreateForm()">
                              Cancelar
                          </button>
                          <button type="submit" class="btn btn-primary">
                              <i class="fas fa-save"></i> Crear Usuario
                          </button>
                      </div>
                  </form>
              </div>
          </div>

          <!-- Lista de usuarios -->
          <div class="table-container">
              <table class="admin-table">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Email</th>
                          <th>Tipo</th>
                          <th>Estado</th>
                          <th>Fecha Registro</th>
                          <th>Acciones</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($usuarios as $usuario): ?>
                          <tr>
                              <td><?php echo $usuario['id']; ?></td>
                              <td>
                                  <div class="user-cell">
                                      <div class="user-avatar">
                                          <i class="fas fa-user"></i>
                                      </div>
                                      <div>
                                          <strong><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?></strong>
                                          <?php if ($usuario['identificador']): ?>
                                              <small><?php echo htmlspecialchars($usuario['identificador']); ?></small>
                                          <?php endif; ?>
                                      </div>
                                  </div>
                              </td>
                              <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                              <td>
                                  <span class="badge badge-<?php echo $usuario['tipo']; ?>">
                                      <?php echo ucfirst($usuario['tipo']); ?>
                                  </span>
                              </td>
                              <td>
                                  <span class="status-badge <?php echo $usuario['activo'] ? 'active' : 'inactive'; ?>">
                                      <?php echo $usuario['activo'] ? 'Activo' : 'Inactivo'; ?>
                                  </span>
                              </td>
                              <td><?php echo date('d/m/Y', strtotime($usuario['fecha_registro'])); ?></td>
                              <td>
                                  <div class="action-buttons">
                                      <button class="btn-icon btn-edit" title="Editar">
                                          <i class="fas fa-edit"></i>
                                      </button>
                                      <button class="btn-icon btn-delete" title="Eliminar">
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  </div>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
          </div>
      </main>
  </div>

  <script>
      function toggleCreateForm() {
          const form = document.getElementById('createForm');
          form.style.display = form.style.display === 'none' ? 'block' : 'none';
      }

      // Cerrar formulario con Escape
      document.addEventListener('keydown', function(e) {
          if (e.key === 'Escape') {
              document.getElementById('createForm').style.display = 'none';
          }
      });
  </script>
</body>
</html>
