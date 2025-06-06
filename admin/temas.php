<?php
// admin/temas.php

session_start();
require_once('../db/connection.php');
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
                $materia_id = (int)$_POST['materia_id'];
                $titulo = trim($_POST['titulo']);
                $descripcion = trim($_POST['descripcion']);
                $orden = (int)$_POST['orden'];
                $activo = isset($_POST['activo']) ? 1 : 0;
                
                if (!empty($titulo) && $materia_id > 0) {
                    // Verificar si ya existe un tema con ese título en la misma materia
                    $stmt = $conexion->prepare("SELECT id FROM temas WHERE titulo = ? AND materia_id = ?");
                    $stmt->bind_param("si", $titulo, $materia_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $mensaje = "Ya existe un tema con ese título en esta materia";
                        $tipo_mensaje = "error";
                    } else {
                        // Insertar nuevo tema
                        $stmt = $conexion->prepare("INSERT INTO temas (materia_id, titulo, descripcion, orden, activo) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("issii", $materia_id, $titulo, $descripcion, $orden, $activo);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Tema creado exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al crear el tema";
                            $tipo_mensaje = "error";
                        }
                    }
                    $stmt->close();
                }
                break;
                
            case 'edit':
                $id = (int)$_POST['id'];
                $materia_id = (int)$_POST['materia_id'];
                $titulo = trim($_POST['titulo']);
                $descripcion = trim($_POST['descripcion']);
                $orden = (int)$_POST['orden'];
                $activo = isset($_POST['activo']) ? 1 : 0;
                
                if ($id > 0 && !empty($titulo) && $materia_id > 0) {
                    // Verificar si ya existe otro tema con ese título en la misma materia
                    $stmt = $conexion->prepare("SELECT id FROM temas WHERE titulo = ? AND materia_id = ? AND id != ?");
                    $stmt->bind_param("sii", $titulo, $materia_id, $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $mensaje = "Ya existe otro tema con ese título en esta materia";
                        $tipo_mensaje = "error";
                    } else {
                        // Actualizar tema
                        $stmt = $conexion->prepare("UPDATE temas SET materia_id = ?, titulo = ?, descripcion = ?, orden = ?, activo = ? WHERE id = ?");
                        $stmt->bind_param("issiii", $materia_id, $titulo, $descripcion, $orden, $activo, $id);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Tema actualizado exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al actualizar el tema";
                            $tipo_mensaje = "error";
                        }
                    }
                    $stmt->close();
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                if ($id > 0) {
                    // Verificar si hay contenidos asociados
                    $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM contenidos WHERE tema_id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $total_contenidos = $row['total'];
                    $stmt->close();
                    
                    // Eliminar tema (la BD maneja la cascada)
                    $stmt = $conexion->prepare("DELETE FROM temas WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    
                    if ($stmt->execute()) {
                        if ($total_contenidos > 0) {
                            $mensaje = "Tema eliminado exitosamente junto con {$total_contenidos} contenido(s) asociado(s)";
                        } else {
                            $mensaje = "Tema eliminado exitosamente";
                        }
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al eliminar el tema";
                        $tipo_mensaje = "error";
                    }
                    $stmt->close();
                }
                break;
                
            case 'toggle':
                $id = (int)$_POST['id'];
                $activo = (int)$_POST['activo'];
                $nuevo_estado = $activo ? 0 : 1;
                
                if ($id > 0) {
                    $stmt = $conexion->prepare("UPDATE temas SET activo = ? WHERE id = ?");
                    $stmt->bind_param("ii", $nuevo_estado, $id);
                    
                    if ($stmt->execute()) {
                        $mensaje = "Estado del tema actualizado exitosamente";
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al actualizar el estado del tema";
                        $tipo_mensaje = "error";
                    }
                    $stmt->close();
                }
                break;
        }
    }
}

// Filtros
$filtro_materia = isset($_GET['materia']) ? (int)$_GET['materia'] : 0;

// Obtener temas con una consulta simplificada
try {
    $where_conditions = [];
    $params = [];
    $param_types = "";
    
    if ($filtro_materia > 0) {
        $where_conditions[] = "t.materia_id = ?";
        $params[] = $filtro_materia;
        $param_types .= "i";
    }
    
    $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
    
    // Consulta simplificada que solo usa las columnas que existen
    $query = "
        SELECT t.*, 
               COALESCE(mat.nombre, 'Sin materia') as materia_nombre,
               COALESCE((SELECT COUNT(*) FROM contenidos WHERE tema_id = t.id), 0) as total_contenidos
        FROM temas t
        LEFT JOIN materias mat ON t.materia_id = mat.id
        $where_clause
        ORDER BY COALESCE(mat.nombre, 'ZZZ'), t.orden, t.titulo
    ";
    
    if (!empty($params)) {
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparando consulta: " . $conexion->error);
        }
        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $temas = [];
        while ($row = $result->fetch_assoc()) {
            $temas[] = $row;
        }
        $stmt->close();
    } else {
        $result = $conexion->query($query);
        if (!$result) {
            throw new Exception("Error ejecutando consulta: " . $conexion->error);
        }
        $temas = [];
        while ($row = $result->fetch_assoc()) {
            $temas[] = $row;
        }
    }
} catch (Exception $e) {
    $temas = [];
    $mensaje = "Error al cargar los temas: " . $e->getMessage();
    $tipo_mensaje = "error";
    
    // Log del error para debugging
    error_log("Error en temas.php: " . $e->getMessage());
}

// Obtener materias para filtros y formularios
try {
    $query_materias = "SELECT id, nombre FROM materias WHERE activo = 1 ORDER BY nombre";
    $result = $conexion->query($query_materias);
    $materias = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row;
        }
    }
} catch (Exception $e) {
    $materias = [];
}

// Estadísticas
$total_temas = count($temas);
$temas_activos = array_filter($temas, function($tema) {
    return $tema['activo'] == 1;
});
$total_activos = count($temas_activos);
$total_inactivos = $total_temas - $total_activos;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Temas - Babelium Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin-common.css">
    <link rel="stylesheet" href="../css/admin-temas.css">
    <link rel="stylesheet" href="../css/components.css">
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
                
                <a href="temas.php" class="nav-item active">
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
                <h1>Gestión de Temas</h1>
                <p>Administra los temas de las materias</p>
            </div>

            <!-- Mensajes -->
            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                    <i class="fas fa-<?php echo $tipo_mensaje === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <!-- Filtros -->
            <div class="content-filters">
                <form method="GET" class="filters-form">
                    <div class="filter-group">
                        <label for="materia">Materia:</label>
                        <select name="materia" id="materia">
                            <option value="">Todas las materias</option>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?php echo $materia['id']; ?>" <?php echo $filtro_materia == $materia['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($materia['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="temas.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </form>

                <div class="content-actions">
                    <button onclick="openModal('createModal')" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nuevo Tema
                    </button>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-card primary">
                    <div class="stat-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_temas; ?></div>
                    <div class="stat-label">Temas Totales</div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_activos; ?></div>
                    <div class="stat-label">Temas Activos</div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_inactivos; ?></div>
                    <div class="stat-label">Temas Inactivos</div>
                </div>
            </div>

            <!-- Lista de temas -->
            <div class="tema-grid">
                <?php if (empty($temas)): ?>
                    <div class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>No se encontraron temas</p>
                        <small>Crea un nuevo tema para empezar</small>
                    </div>
                <?php else: ?>
                    <?php foreach ($temas as $tema): ?>
                        <div class="tema-card <?php echo $tema['activo'] ? '' : 'inactivo'; ?>">
                            <div class="tema-header">
                                <div class="tema-title">
                                    <div class="color-indicator" style="background-color: #667eea"></div>
                                    <span class="orden"><?php echo $tema['orden']; ?></span>
                                    <span class="tema-title-text"><?php echo htmlspecialchars($tema['titulo']); ?></span>
                                </div>
                                <div class="tema-actions">
                                    <button onclick="editTema(<?php echo htmlspecialchars(json_encode($tema)); ?>)" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="toggle">
                                        <input type="hidden" name="id" value="<?php echo $tema['id']; ?>">
                                        <input type="hidden" name="activo" value="<?php echo $tema['activo']; ?>">
                                        <button type="submit" class="btn btn-sm <?php echo $tema['activo'] ? 'btn-success' : 'btn-secondary'; ?>" title="<?php echo $tema['activo'] ? 'Desactivar' : 'Activar'; ?>">
                                            <i class="fas fa-<?php echo $tema['activo'] ? 'toggle-on' : 'toggle-off'; ?>"></i>
                                        </button>
                                    </form>
                                    
                                    <button onclick="deleteTema(<?php echo $tema['id']; ?>, '<?php echo htmlspecialchars($tema['titulo']); ?>', <?php echo $tema['total_contenidos']; ?>)" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="tema-body">
                                <div class="tema-badges">
                                    <span class="materia-badge" style="background-color: #667eea">
                                        <?php echo htmlspecialchars($tema['materia_nombre']); ?>
                                    </span>
                                </div>
                                <div class="tema-description">
                                    <?php echo !empty($tema['descripcion']) ? htmlspecialchars($tema['descripcion']) : '<em>Sin descripción</em>'; ?>
                                </div>
                                <div class="tema-meta">
                                    <div class="tema-meta-item">
                                        <i class="fas fa-file-alt"></i>
                                        <span><?php echo $tema['total_contenidos']; ?> contenidos</span>
                                    </div>
                                    <div class="tema-meta-item">
                                        <i class="fas fa-sort-numeric-up"></i>
                                        <span>Orden: <?php echo $tema['orden']; ?></span>
                                    </div>
                                    <div class="tema-meta-item">
                                        <span class="estado-badge <?php echo $tema['activo'] ? 'estado-activo' : 'estado-inactivo'; ?>">
                                            <?php echo $tema['activo'] ? 'Activo' : 'Inactivo'; ?>
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

    <!-- Modal para crear tema -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-plus"></i> Nuevo Tema</h3>
                <button onclick="closeModal('createModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="create">
                
                <div class="form-group">
                    <label for="create_materia_id">Materia *</label>
                    <select name="materia_id" id="create_materia_id" required>
                        <option value="">Seleccionar materia</option>
                        <?php foreach ($materias as $materia): ?>
                            <option value="<?php echo $materia['id']; ?>">
                                <?php echo htmlspecialchars($materia['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="create_titulo">Título del Tema *</label>
                    <input type="text" name="titulo" id="create_titulo" required>
                </div>

                <div class="form-group">
                    <label for="create_descripcion">Descripción</label>
                    <textarea name="descripcion" id="create_descripcion" rows="3" placeholder="Descripción del tema..."></textarea>
                </div>

                <div class="form-group">
                    <label for="create_orden">Orden</label>
                    <input type="number" name="orden" id="create_orden" value="1" min="1" max="999">
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="activo" checked>
                        <span>Activo</span>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="closeModal('createModal')" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Crear Tema
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar tema -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Editar Tema</h3>
                <button onclick="closeModal('editModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_materia_id">Materia *</label>
                    <select name="materia_id" id="edit_materia_id" required>
                        <option value="">Seleccionar materia</option>
                        <?php foreach ($materias as $materia): ?>
                            <option value="<?php echo $materia['id']; ?>">
                                <?php echo htmlspecialchars($materia['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_titulo">Título del Tema *</label>
                    <input type="text" name="titulo" id="edit_titulo" required>
                </div>

                <div class="form-group">
                    <label for="edit_descripcion">Descripción</label>
                    <textarea name="descripcion" id="edit_descripcion" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="edit_orden">Orden</label>
                    <input type="number" name="orden" id="edit_orden" min="1" max="999">
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="activo" id="edit_activo">
                        <span>Activo</span>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="closeModal('editModal')" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Tema
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
                <p>¿Estás seguro de que deseas eliminar el tema <strong id="deleteTemaTitle"></strong>?</p>
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
        }

        // Función para editar tema
        function editTema(tema) {
            document.getElementById('edit_id').value = tema.id;
            document.getElementById('edit_materia_id').value = tema.materia_id;
            document.getElementById('edit_titulo').value = tema.titulo;
            document.getElementById('edit_descripcion').value = tema.descripcion || '';
            document.getElementById('edit_orden').value = tema.orden || 1;
            document.getElementById('edit_activo').checked = tema.activo == 1;
            
            openModal('editModal');
        }

        // Función para eliminar tema
        function deleteTema(id, titulo, totalContenidos) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteTemaTitle').textContent = titulo;
            
            // Actualizar el mensaje según si hay contenidos asociados
            const warningText = document.querySelector('#deleteModal .warning-text');
            if (totalContenidos > 0) {
                warningText.innerHTML = `<strong>⚠️ ADVERTENCIA:</strong> Este tema tiene ${totalContenidos} contenido(s) asociado(s). Al eliminarlo también se eliminarán todos los contenidos relacionados. Esta acción no se puede deshacer.`;
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
