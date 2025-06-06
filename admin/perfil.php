<?php
session_start();
require_once('../db/connection.php');
require_once '../includes/auth_check.php';

// Verificar que sea administrador
verificarAutenticacion('admin');

$mensaje = '';
$tipo_mensaje = '';

// Obtener datos del usuario actual
$usuario_id = $_SESSION['usuario_id'];
$query = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    header("Location: login.php");
    exit();
}

// Procesar formulario de actualización de perfil
if ($_POST && isset($_POST['action'])) {
    if ($_POST['action'] === 'actualizar_perfil') {
        $nombre = trim($_POST['nombre']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $telefono = trim($_POST['telefono']);
        $direccion = trim($_POST['direccion']);
        $biografia = trim($_POST['biografia']);
        
        // Validaciones básicas
        if (empty($nombre) || empty($apellidos) || empty($email)) {
            $mensaje = "El nombre, apellidos y email son obligatorios";
            $tipo_mensaje = "error";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mensaje = "El formato del email no es válido";
            $tipo_mensaje = "error";
        } else {
            // Verificar si el email ya existe (excepto el usuario actual)
            $check_email = "SELECT id FROM usuarios WHERE email = ? AND id != ?";
            $stmt_check = $conexion->prepare($check_email);
            $stmt_check->bind_param("si", $email, $usuario_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();
            
            if ($result_check->num_rows > 0) {
                $mensaje = "El email ya está en uso por otro usuario";
                $tipo_mensaje = "error";
            } else {
                // Actualizar datos del usuario
                $update_query = "UPDATE usuarios SET 
                    nombre = ?, 
                    apellidos = ?, 
                    email = ?, 
                    telefono = ?, 
                    direccion = ?, 
                    biografia = ? 
                    WHERE id = ?";
                $stmt_update = $conexion->prepare($update_query);
                $stmt_update->bind_param("ssssssi", $nombre, $apellidos, $email, $telefono, $direccion, $biografia, $usuario_id);
                
                if ($stmt_update->execute()) {
                    $mensaje = "Perfil actualizado exitosamente";
                    $tipo_mensaje = "success";
                    
                    // Actualizar datos en la sesión
                    $_SESSION['usuario_nombre'] = $nombre;
                    $_SESSION['usuario_apellidos'] = $apellidos;
                    $_SESSION['usuario_email'] = $email;
                    
                    // Recargar datos del usuario
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $usuario = $result->fetch_assoc();
                } else {
                    $mensaje = "Error al actualizar el perfil";
                    $tipo_mensaje = "error";
                }
            }
        }
    }
    
    // Procesar subida de foto de perfil
    elseif ($_POST['action'] === 'subir_foto') {
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $archivo = $_FILES['foto'];
            
            // Validar tipo de archivo
            $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($archivo['type'], $tipos_permitidos)) {
                $mensaje = "Solo se permiten archivos de imagen (JPEG, PNG, GIF, WebP)";
                $tipo_mensaje = "error";
            }
            // Validar tamaño (máximo 5MB)
            elseif ($archivo['size'] > 5 * 1024 * 1024) {
                $mensaje = "El archivo es demasiado grande. Máximo 5MB";
                $tipo_mensaje = "error";
            } else {
                // Leer el archivo como blob
                $foto_data = file_get_contents($archivo['tmp_name']);
                
                if ($foto_data !== false) {
                    // Guardar en la base de datos
                    $update_foto = "UPDATE usuarios SET foto = ? WHERE id = ?";
                    $stmt_foto = $conexion->prepare($update_foto);
                    $null = NULL; // Para bind_param con tipo 'b'
                    $stmt_foto->bind_param("bi", $null, $usuario_id);
                    
                    // Vincular el parámetro después de la preparación
                    $stmt_foto->send_long_data(0, $foto_data);
                    
                    if ($stmt_foto->execute()) {
                        $mensaje = "Foto de perfil actualizada exitosamente";
                        $tipo_mensaje = "success";
                        
                        // Recargar datos del usuario
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $usuario = $result->fetch_assoc();
                    } else {
                        $mensaje = "Error al guardar la foto de perfil: " . $conexion->error;
                        $tipo_mensaje = "error";
                    }
                } else {
                    $mensaje = "Error al procesar el archivo de imagen";
                    $tipo_mensaje = "error";
                }
            }
        } else {
            $mensaje = "No se seleccionó ningún archivo o hubo un error en la subida";
            $tipo_mensaje = "error";
        }
    }
    
    // Procesar eliminación de foto
    elseif ($_POST['action'] === 'eliminar_foto') {
        $update_foto = "UPDATE usuarios SET foto = NULL WHERE id = ?";
        $stmt_foto = $conexion->prepare($update_foto);
        $stmt_foto->bind_param("i", $usuario_id);
        
        if ($stmt_foto->execute()) {
            $mensaje = "Foto de perfil eliminada exitosamente";
            $tipo_mensaje = "success";
            
            // Recargar datos del usuario
            $stmt->execute();
            $result = $stmt->get_result();
            $usuario = $result->fetch_assoc();
        } else {
            $mensaje = "Error al eliminar la foto de perfil";
            $tipo_mensaje = "error";
        }
    }
}

// Función para mostrar la foto de perfil
function mostrarFotoPerfil($foto_data) {
    if ($foto_data) {
        $foto_base64 = base64_encode($foto_data);
        return "data:image/jpeg;base64," . $foto_base64;
    }
    return null;
}

// Función para obtener valor seguro de array
function obtenerValorSeguro($array, $key, $default = '') {
    return isset($array[$key]) ? $array[$key] : $default;
}

// Función para capitalizar el tipo/rol
function capitalizarTipo($tipo) {
    switch($tipo) {
        case 'admin': return 'Administrador';
        case 'profesor': return 'Profesor';
        case 'alumno': return 'Alumno';
        default: return ucfirst($tipo);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Babelium Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin-perfil.css">
</head>
<body>
    <?php include_once "../includes/admin_header.php" ?>

    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <h3>
                    <i class="fas fa-cogs"></i>
                    Panel de Control
                </h3>
            </div>
            
            <nav class="sidebar-nav">
                <!-- Dashboard -->
                <a href="dashboard.php" class="nav-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <!-- Gestión de Usuarios -->
                <a href="usuarios.php" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>Usuarios</span>
                </a>
                
                <!-- Separador -->
                <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 1rem 0;"></div>
                
                <!-- Gestión Académica -->
                <div style="padding: 0.5rem 1.5rem; color: rgba(255,255,255,0.6); font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">
                    Gestión Académica
                </div>
                
                <a href="niveles.php" class="nav-item">
                    <i class="fas fa-layer-group"></i>
                    <span>Niveles Educativos</span>
                </a>
                
                <a href="cursos.php" class="nav-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Cursos</span>
                </a>
                
                <a href="modalidades.php" class="nav-item">
                    <i class="fas fa-sitemap"></i>
                    <span>Modalidades</span>
                </a>
                
                <a href="materias.php" class="nav-item">
                    <i class="fas fa-book"></i>
                    <span>Materias</span>
                </a>
                
                <a href="temas.php" class="nav-item">
                    <i class="fas fa-list"></i>
                    <span>Temas</span>
                </a>
                
                <!-- Separador -->
                <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 1rem 0;"></div>
                
                <!-- Gestión de Contenidos -->
                <div style="padding: 0.5rem 1.5rem; color: rgba(255,255,255,0.6); font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">
                    Contenidos
                </div>
                
                <a href="contenidos.php" class="nav-item">
                    <i class="fas fa-file-alt"></i>
                    <span>Gestión de Contenidos</span>
                </a>
                
                <!-- Separador -->
                <div style="border-top: 1px solid rgba(255,255,255,0.1); margin: 1rem 0;"></div>
                
                <!-- Herramientas -->
                <div style="padding: 0.5rem 1.5rem; color: rgba(255,255,255,0.6); font-size: 0.8rem; font-weight: 600; text-transform: uppercase;">
                    Herramientas
                </div>
                
                <a href="estructura.php" class="nav-item">
                    <i class="fas fa-project-diagram"></i>
                    <span>Vista de Estructura</span>
                </a>
                
                <a href="perfil.php" class="nav-item active">
                    <i class="fas fa-user-circle"></i>
                    <span>Mi Perfil</span>
                </a>
                
                <a href="configuracion.php" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="perfil-container">
                <!-- Header del perfil -->
                <div class="perfil-header">
                    <h1><i class="fas fa-user-circle"></i> Mi Perfil</h1>
                    <p>Gestiona tu información personal y configuración de cuenta</p>
                </div>

                <!-- Mensajes -->
                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?>" style="grid-column: 1 / -1;">
                        <i class="fas fa-<?php echo $tipo_mensaje === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                        <?php echo htmlspecialchars($mensaje); ?>
                    </div>
                <?php endif; ?>

                <!-- Card de foto de perfil -->
                <div class="foto-perfil-card">
                    <div class="foto-perfil-container">
                        <?php if ($usuario['foto']): ?>
                            <img src="<?php echo mostrarFotoPerfil($usuario['foto']); ?>" alt="Foto de perfil" class="foto-perfil">
                        <?php else: ?>
                            <div class="foto-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                        <button class="cambiar-foto-btn" onclick="openModal('fotoModal')" title="Cambiar foto">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    
                    <h3><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellidos']); ?></h3>
                    <p style="color: var(--perfil-text-muted); margin: 0.5rem 0;">
                        <i class="fas fa-shield-alt"></i> 
                        <?php echo capitalizarTipo($usuario['tipo']); ?>
                    </p>
                    
                    <div class="foto-info">
                        <p><strong>Formatos permitidos:</strong> JPEG, PNG, GIF, WebP</p>
                        <p><strong>Tamaño máximo:</strong> 5MB</p>
                        <p><strong>Recomendado:</strong> 400x400 píxeles</p>
                    </div>
                    
                    <?php if ($usuario['foto']): ?>
                        <form method="POST" style="margin-top: 1rem;">
                            <input type="hidden" name="action" value="eliminar_foto">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar tu foto de perfil?')">
                                <i class="fas fa-trash"></i> Eliminar Foto
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <!-- Card de información del perfil -->
                <div class="info-perfil-card">
                    <h2>
                        <i class="fas fa-edit"></i>
                        Información Personal
                    </h2>

                    <form method="POST" class="perfil-form">
                        <input type="hidden" name="action" value="actualizar_perfil">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombre">
                                    <i class="fas fa-user"></i>
                                    Nombre *
                                </label>
                                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="apellidos">
                                    <i class="fas fa-user"></i>
                                    Apellidos *
                                </label>
                                <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email *
                                </label>
                                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="identificador">
                                    <i class="fas fa-id-card"></i>
                                    Identificador
                                </label>
                                <input type="text" id="identificador" value="<?php echo htmlspecialchars($usuario['identificador']); ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="telefono">
                                    <i class="fas fa-phone"></i>
                                    Teléfono
                                </label>
                                <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars(obtenerValorSeguro($usuario, 'telefono')); ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="tipo">
                                    <i class="fas fa-shield-alt"></i>
                                    Tipo de Usuario
                                </label>
                                <input type="text" id="tipo" value="<?php echo capitalizarTipo($usuario['tipo']); ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="direccion">
                                <i class="fas fa-map-marker-alt"></i>
                                Dirección
                            </label>
                            <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars(obtenerValorSeguro($usuario, 'direccion')); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="biografia">
                                <i class="fas fa-quote-left"></i>
                                Biografía
                            </label>
                            <textarea id="biografia" name="biografia" placeholder="Cuéntanos un poco sobre ti..."><?php echo htmlspecialchars(obtenerValorSeguro($usuario, 'biografia')); ?></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="location.reload()">
                                <i class="fas fa-undo"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                    
                    <!-- Información adicional -->
                    <div class="info-adicional">
                        <h3>
                            <i class="fas fa-info-circle"></i>
                            Información de la Cuenta
                        </h3>
                        <ul class="info-list">
                            <li class="info-item">
                                <i class="fas fa-calendar-plus"></i>
                                <span class="info-label">Fecha de registro:</span>
                                <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_registro'])); ?></span>
                            </li>
                            
                            <?php if (obtenerValorSeguro($usuario, 'fecha_creacion')): ?>
                            <li class="info-item">
                                <i class="fas fa-calendar-plus"></i>
                                <span class="info-label">Fecha de creación:</span>
                                <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_creacion'])); ?></span>
                            </li>
                            <?php endif; ?>
                            
                            <?php if (obtenerValorSeguro($usuario, 'fecha_actualizacion')): ?>
                            <li class="info-item">
                                <i class="fas fa-calendar-check"></i>
                                <span class="info-label">Última actualización:</span>
                                <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_actualizacion'])); ?></span>
                            </li>
                            <?php endif; ?>
                            
                            <li class="info-item">
                                <i class="fas fa-key"></i>
                                <span class="info-label">ID de usuario:</span>
                                <span class="info-value">#<?php echo $usuario['id']; ?></span>
                            </li>
                            
                            <li class="info-item">
                                <i class="fas fa-toggle-on"></i>
                                <span class="info-label">Estado:</span>
                                <span class="info-value">
                                    <?php if ($usuario['activo']): ?>
                                        <span style="color: var(--perfil-success); font-weight: 600;">✓ Activo</span>
                                    <?php else: ?>
                                        <span style="color: var(--perfil-danger); font-weight: 600;">✗ Inactivo</span>
                                    <?php endif; ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para cambiar foto -->
    <div id="fotoModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>
                    <i class="fas fa-camera"></i>
                    Cambiar Foto de Perfil
                </h3>
                <button onclick="closeModal('fotoModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="fotoForm">
                    <input type="hidden" name="action" value="subir_foto">
                    
                    <div class="file-upload-area" onclick="document.getElementById('fotoInput').click()">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">Haz clic aquí para seleccionar una imagen</div>
                        <div class="upload-hint">o arrastra y suelta un archivo</div>
                    </div>
                    
                    <input type="file" id="fotoInput" name="foto" accept="image/*" class="file-input">
                    
                    <div id="imagePreview" class="image-preview" style="display: none;">
                        <img id="previewImg" class="preview-image" alt="Vista previa">
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" onclick="closeModal('fotoModal')" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success" id="subirBtn" disabled>
                            <i class="fas fa-upload"></i> Subir Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Funciones para modales
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
            
            // Limpiar preview
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('fotoInput').value = '';
            document.getElementById('subirBtn').disabled = true;
        }

        // Cerrar modales al hacer click fuera
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    closeModal(modal.id);
                }
            });
        }

        // Manejo del input de archivo
        document.getElementById('fotoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validar tipo de archivo
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Solo se permiten archivos de imagen (JPEG, PNG, GIF, WebP)');
                    this.value = '';
                    return;
                }
                
                // Validar tamaño (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('El archivo es demasiado grande. Máximo 5MB');
                    this.value = '';
                    return;
                }
                
                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                    document.getElementById('subirBtn').disabled = false;
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop
        const uploadArea = document.querySelector('.file-upload-area');
        
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('fotoInput').files = files;
                document.getElementById('fotoInput').dispatchEvent(new Event('change'));
            }
        });

        // Loading state para formularios
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.disabled = true;
                }
            });
        });

        // Auto-resize para textarea
        document.getElementById('biografia').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });

        // Cerrar alertas automáticamente
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>
