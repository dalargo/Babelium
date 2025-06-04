<?php
session_start();
require_once '../db/connection.php';
require_once '../includes/auth_check.php';

// Verificar que sea administrador
verificarAutenticacion('admin');

// Procesar acciones
$mensaje = '';
$tipo_mensaje = '';

if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']);
                $orden = (int)$_POST['orden'];
                $activo = isset($_POST['activo']) ? 1 : 0;
                
                if (!empty($nombre)) {
                    // Verificar si ya existe un nivel con ese nombre
                    $stmt = $conexion->prepare("SELECT id FROM niveles_educativos WHERE nombre = ?");
                    $stmt->bind_param("s", $nombre);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $mensaje = "Ya existe un nivel educativo con ese nombre";
                        $tipo_mensaje = "error";
                    } else {
                        // Insertar nuevo nivel
                        $stmt = $conexion->prepare("INSERT INTO niveles_educativos (nombre, descripcion, orden, activo) VALUES (?, ?, ?, ?)");
                        $stmt->bind_param("ssii", $nombre, $descripcion, $orden, $activo);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Nivel educativo creado exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al crear el nivel educativo";
                            $tipo_mensaje = "error";
                        }
                    }
                    $stmt->close();
                }
                break;
                
            case 'edit':
                $id = (int)$_POST['id'];
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']);
                $orden = (int)$_POST['orden'];
                $activo = isset($_POST['activo']) ? 1 : 0;
                
                if ($id > 0 && !empty($nombre)) {
                    // Verificar si ya existe otro nivel con ese nombre
                    $stmt = $conexion->prepare("SELECT id FROM niveles_educativos WHERE nombre = ? AND id != ?");
                    $stmt->bind_param("si", $nombre, $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $mensaje = "Ya existe otro nivel educativo con ese nombre";
                        $tipo_mensaje = "error";
                    } else {
                        // Actualizar nivel
                        $stmt = $conexion->prepare("UPDATE niveles_educativos SET nombre = ?, descripcion = ?, orden = ?, activo = ? WHERE id = ?");
                        $stmt->bind_param("ssiii", $nombre, $descripcion, $orden, $activo, $id);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Nivel educativo actualizado exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al actualizar el nivel educativo";
                            $tipo_mensaje = "error";
                        }
                    }
                    $stmt->close();
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                if ($id > 0) {
                    // Verificar si hay cursos asociados y mostrar advertencia
                    $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM cursos WHERE nivel_id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $total_cursos = $row['total'];
                    $stmt->close();
                    
                    // Permitir eliminación pero con advertencia si hay cursos
                    if ($total_cursos > 0) {
                        // Eliminar en cascada (la BD ya está configurada para esto)
                        $stmt = $conexion->prepare("DELETE FROM niveles_educativos WHERE id = ?");
                        $stmt->bind_param("i", $id);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Nivel educativo eliminado exitosamente junto con {$total_cursos} curso(s) asociado(s)";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al eliminar el nivel educativo";
                            $tipo_mensaje = "error";
                        }
                        $stmt->close();
                    } else {
                        // Eliminar nivel sin cursos
                        $stmt = $conexion->prepare("DELETE FROM niveles_educativos WHERE id = ?");
                        $stmt->bind_param("i", $id);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Nivel educativo eliminado exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al eliminar el nivel educativo";
                            $tipo_mensaje = "error";
                        }
                        $stmt->close();
                    }
                }
                break;
                
            case 'toggle':
                $id = (int)$_POST['id'];
                $activo = (int)$_POST['activo'];
                $nuevo_estado = $activo ? 0 : 1;
                
                if ($id > 0) {
                    // Cambiar estado
                    $stmt = $conexion->prepare("UPDATE niveles_educativos SET activo = ? WHERE id = ?");
                    $stmt->bind_param("ii", $nuevo_estado, $id);
                    
                    if ($stmt->execute()) {
                        $mensaje = "Estado del nivel educativo actualizado exitosamente";
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al actualizar el estado del nivel educativo";
                        $tipo_mensaje = "error";
                    }
                    $stmt->close();
                }
                break;
        }
    }
}

// Obtener niveles educativos
try {
    $query = "
        SELECT ne.*, 
               COALESCE((SELECT COUNT(*) FROM cursos WHERE nivel_id = ne.id), 0) as total_cursos
        FROM niveles_educativos ne
        ORDER BY ne.orden, ne.nombre
    ";
    
    $result = $conexion->query($query);
    $niveles = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $niveles[] = $row;
        }
    }
} catch (Exception $e) {
    $niveles = [];
    $mensaje = "Error al cargar los niveles educativos";
    $tipo_mensaje = "error";
}

// Estadísticas
$total_niveles = count($niveles);
$niveles_activos = array_filter($niveles, function($nivel) {
    return $nivel['activo'] == 1;
});
$total_activos = count($niveles_activos);
$total_inactivos = $total_niveles - $total_activos;

// Obtener el próximo orden sugerido
$proximo_orden = 1;
if (!empty($niveles)) {
    $max_orden = max(array_column($niveles, 'orden'));
    $proximo_orden = $max_orden + 1;
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
    <link rel="stylesheet" href="../css/admin-niveles.css">
    <link rel="stylesheet" href="../css/components.css">
    <title>Gestión de Niveles Educativos - Babelium Admin</title>
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
                
                <a href="niveles.php" class="nav-item active">
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
                
                <a href="configuracion.php" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Gestión de Niveles Educativos</h1>
                <p>Administra los niveles educativos del sistema</p>
            </div>

            <!-- Mensajes -->
            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                    <i class="fas fa-<?php echo $tipo_mensaje === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-card primary">
                    <div class="stat-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_niveles; ?></div>
                    <div class="stat-label">Niveles Totales</div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_activos; ?></div>
                    <div class="stat-label">Niveles Activos</div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_inactivos; ?></div>
                    <div class="stat-label">Niveles Inactivos</div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="content-actions">
                <button onclick="openModal('createModal')" class="btn btn-success">
                    <i class="fas fa-plus"></i> Nuevo Nivel Educativo
                </button>
            </div>

            <!-- Lista de niveles -->
            <div class="nivel-grid">
                <?php if (empty($niveles)): ?>
                    <div class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>No se encontraron niveles educativos</p>
                        <small>Crea un nuevo nivel para empezar</small>
                    </div>
                <?php else: ?>
                    <?php foreach ($niveles as $nivel): ?>
                        <div class="nivel-card <?php echo $nivel['activo'] ? '' : 'inactivo'; ?>">
                            <div class="nivel-header">
                                <div class="nivel-title">
                                    <span class="orden"><?php echo $nivel['orden']; ?></span>
                                    <span class="nivel-title-text"><?php echo htmlspecialchars($nivel['nombre']); ?></span>
                                </div>
                                <div class="nivel-actions">
                                    <button onclick="editNivel(<?php echo htmlspecialchars(json_encode($nivel)); ?>)" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="toggle">
                                        <input type="hidden" name="id" value="<?php echo $nivel['id']; ?>">
                                        <input type="hidden" name="activo" value="<?php echo $nivel['activo']; ?>">
                                        <button type="submit" class="btn btn-sm <?php echo $nivel['activo'] ? 'btn-success' : 'btn-secondary'; ?>" title="<?php echo $nivel['activo'] ? 'Desactivar' : 'Activar'; ?>">
                                            <i class="fas fa-<?php echo $nivel['activo'] ? 'toggle-on' : 'toggle-off'; ?>"></i>
                                        </button>
                                    </form>
                                    
                                    <button onclick="deleteNivel(<?php echo $nivel['id']; ?>, '<?php echo htmlspecialchars($nivel['nombre']); ?>', <?php echo $nivel['total_cursos']; ?>)" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="nivel-body">
                                <div class="nivel-description">
                                    <?php echo !empty($nivel['descripcion']) ? htmlspecialchars($nivel['descripcion']) : '<em>Sin descripción</em>'; ?>
                                </div>
                                <div class="nivel-meta">
                                    <div class="nivel-meta-item">
                                        <i class="fas fa-graduation-cap"></i>
                                        <span><?php echo $nivel['total_cursos']; ?> cursos</span>
                                    </div>
                                    <div class="nivel-meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Creado: <?php echo isset($nivel['fecha_creacion']) ? date('d/m/Y', strtotime($nivel['fecha_creacion'])) : 'N/A'; ?></span>
                                    </div>
                                    <div class="nivel-meta-item">
                                        <span class="estado-badge <?php echo $nivel['activo'] ? 'estado-activo' : 'estado-inactivo'; ?>">
                                            <?php echo $nivel['activo'] ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modal para crear nivel -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-plus"></i> Nuevo Nivel Educativo</h3>
                <button onclick="closeModal('createModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="create">
                
                <div class="form-group">
                    <label for="create_nombre">Nombre *</label>
                    <input type="text" name="nombre" id="create_nombre" required>
                </div>

                <div class="form-group">
                    <label for="create_descripcion">Descripción</label>
                    <textarea name="descripcion" id="create_descripcion" rows="3" placeholder="Descripción del nivel educativo..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="create_orden">Orden</label>
                        <input type="number" name="orden" id="create_orden" value="<?php echo $proximo_orden; ?>" min="1">
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="activo" checked>
                            <span>Activo</span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="closeModal('createModal')" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Crear Nivel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar nivel -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Editar Nivel Educativo</h3>
                <button onclick="closeModal('editModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_nombre">Nombre *</label>
                    <input type="text" name="nombre" id="edit_nombre" required>
                </div>

                <div class="form-group">
                    <label for="edit_descripcion">Descripción</label>
                    <textarea name="descripcion" id="edit_descripcion" rows="3"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_orden">Orden</label>
                        <input type="number" name="orden" id="edit_orden" min="1">
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="activo" id="edit_activo">
                            <span>Activo</span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="closeModal('editModal')" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Nivel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmación para eliminar -->
    <div id="deleteModal" class="modal">
        <div class="modal-content modal-small">
            <div class="modal-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación</h3>
                <button onclick="closeModal('deleteModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar el nivel educativo <strong id="deleteNivelTitle"></strong>?</p>
                <p class="warning-text">Esta acción no se puede deshacer.</p>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" id="delete_id">
                
                <div class="form-actions">
                    <button type="button" onclick="closeModal('deleteModal')" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funciones para modales
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Función para editar nivel
        function editNivel(nivel) {
            document.getElementById('edit_id').value = nivel.id;
            document.getElementById('edit_nombre').value = nivel.nombre;
            document.getElementById('edit_descripcion').value = nivel.descripcion || '';
            document.getElementById('edit_orden').value = nivel.orden;
            document.getElementById('edit_activo').checked = nivel.activo == 1;
            
            openModal('editModal');
        }

        // Función para eliminar nivel
        function deleteNivel(id, nombre, totalCursos) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteNivelTitle').textContent = nombre;
            
            // Actualizar el mensaje según si hay cursos asociados
            const warningText = document.querySelector('#deleteModal .warning-text');
            if (totalCursos > 0) {
                warningText.innerHTML = `<strong>⚠️ ADVERTENCIA:</strong> Este nivel tiene ${totalCursos} curso(s) asociado(s). Al eliminarlo también se eliminarán todos los cursos, materias, temas y contenidos relacionados. Esta acción no se puede deshacer.`;
                warningText.style.color = '#e74c3c';
                warningText.style.fontWeight = 'bold';
            } else {
                warningText.textContent = 'Esta acción no se puede deshacer.';
                warningText.style.color = '';
                warningText.style.fontWeight = '';
            }
            
            openModal('deleteModal');
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

        // Cerrar modales con Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => {
                    if (modal.style.display === 'flex') {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // Auto-resize textareas
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            });
        });
    </script>
</body>
</html>
