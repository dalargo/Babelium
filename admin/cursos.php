<?php
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
                $nivel_id = (int)$_POST['nivel_id'];
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']);
                $orden = (int)$_POST['orden'];
                $activo = isset($_POST['activo']) ? 1 : 0;
                
                if (!empty($nombre) && $nivel_id > 0) {
                    // Verificar si ya existe un curso con ese nombre en el mismo nivel
                    $stmt = $conexion->prepare("SELECT id FROM cursos WHERE nombre = ? AND nivel_id = ?");
                    $stmt->bind_param("si", $nombre, $nivel_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $mensaje = "Ya existe un curso con ese nombre en este nivel";
                        $tipo_mensaje = "error";
                    } else {
                        // Insertar nuevo curso
                        $stmt = $conexion->prepare("INSERT INTO cursos (nivel_id, nombre, descripcion, orden, activo) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("issii", $nivel_id, $nombre, $descripcion, $orden, $activo);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Curso creado exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al crear el curso";
                            $tipo_mensaje = "error";
                        }
                    }
                    $stmt->close();
                }
                break;
                
            case 'edit':
                $id = (int)$_POST['id'];
                $nivel_id = (int)$_POST['nivel_id'];
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']);
                $orden = (int)$_POST['orden'];
                $activo = isset($_POST['activo']) ? 1 : 0;
                
                if ($id > 0 && !empty($nombre) && $nivel_id > 0) {
                    // Verificar si ya existe otro curso con ese nombre en el mismo nivel
                    $stmt = $conexion->prepare("SELECT id FROM cursos WHERE nombre = ? AND nivel_id = ? AND id != ?");
                    $stmt->bind_param("sii", $nombre, $nivel_id, $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $mensaje = "Ya existe otro curso con ese nombre en este nivel";
                        $tipo_mensaje = "error";
                    } else {
                        // Actualizar curso
                        $stmt = $conexion->prepare("UPDATE cursos SET nivel_id = ?, nombre = ?, descripcion = ?, orden = ?, activo = ? WHERE id = ?");
                        $stmt->bind_param("issiii", $nivel_id, $nombre, $descripcion, $orden, $activo, $id);
                        
                        if ($stmt->execute()) {
                            $mensaje = "Curso actualizado exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al actualizar el curso";
                            $tipo_mensaje = "error";
                        }
                    }
                    $stmt->close();
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                if ($id > 0) {
                    // Verificar si hay modalidades asociadas
                    $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM modalidades_curso WHERE curso_id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $total_modalidades = $row['total'];
                    $stmt->close();
                    
                    // Eliminar curso (la BD maneja la cascada)
                    $stmt = $conexion->prepare("DELETE FROM cursos WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    
                    if ($stmt->execute()) {
                        if ($total_modalidades > 0) {
                            $mensaje = "Curso eliminado exitosamente junto con {$total_modalidades} modalidad(es) asociada(s)";
                        } else {
                            $mensaje = "Curso eliminado exitosamente";
                        }
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al eliminar el curso";
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
                    $stmt = $conexion->prepare("UPDATE cursos SET activo = ? WHERE id = ?");
                    $stmt->bind_param("ii", $nuevo_estado, $id);
                    
                    if ($stmt->execute()) {
                        $mensaje = "Estado del curso actualizado exitosamente";
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al actualizar el estado del curso";
                        $tipo_mensaje = "error";
                    }
                    $stmt->close();
                }
                break;
        }
    }
}

// Filtros
$filtro_nivel = isset($_GET['nivel']) ? (int)$_GET['nivel'] : 0;

// Obtener cursos
try {
    $where_clause = "";
    $params = [];
    $param_types = "";
    
    if ($filtro_nivel > 0) {
        $where_clause = "WHERE c.nivel_id = ?";
        $params[] = $filtro_nivel;
        $param_types = "i";
    }
    
    // Primero verificar si las tablas existen
    $check_tables = $conexion->query("SHOW TABLES LIKE 'cursos'");
    if ($check_tables->num_rows == 0) {
        throw new Exception("La tabla 'cursos' no existe");
    }
    
    $check_niveles = $conexion->query("SHOW TABLES LIKE 'niveles_educativos'");
    if ($check_niveles->num_rows == 0) {
        throw new Exception("La tabla 'niveles_educativos' no existe");
    }
    
    // Consulta simplificada primero
    $query = "
        SELECT c.*, 
               COALESCE(ne.nombre, 'Sin nivel') as nivel_nombre,
               COALESCE((SELECT COUNT(*) FROM modalidades_curso WHERE curso_id = c.id), 0) as total_modalidades
        FROM cursos c
        LEFT JOIN niveles_educativos ne ON c.nivel_id = ne.id
        $where_clause
        ORDER BY COALESCE(ne.orden, 999), c.orden, c.nombre
    ";
    
    if (!empty($params)) {
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparando consulta: " . $conexion->error);
        }
        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $cursos = [];
        while ($row = $result->fetch_assoc()) {
            $cursos[] = $row;
        }
        $stmt->close();
    } else {
        $result = $conexion->query($query);
        if (!$result) {
            throw new Exception("Error ejecutando consulta: " . $conexion->error);
        }
        $cursos = [];
        while ($row = $result->fetch_assoc()) {
            $cursos[] = $row;
        }
    }
} catch (Exception $e) {
    $cursos = [];
    $mensaje = "Error al cargar los cursos: " . $e->getMessage();
    $tipo_mensaje = "error";
    
    // Log del error para debugging
    error_log("Error en cursos.php: " . $e->getMessage());
}

// Obtener niveles para filtros y formularios
try {
    $result = $conexion->query("SELECT id, nombre, orden FROM niveles_educativos WHERE activo = 1 ORDER BY orden");
    $niveles = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $niveles[] = $row;
        }
    }
} catch (Exception $e) {
    $niveles = [];
    // Si no existe la tabla niveles_educativos, crear un nivel por defecto
    $niveles = [['id' => 1, 'nombre' => 'Nivel por defecto']];
}

// Estadísticas
$total_cursos = count($cursos);
$cursos_activos = array_filter($cursos, function($curso) {
    return $curso['activo'] == 1;
});
$total_activos = count($cursos_activos);
$total_inactivos = $total_cursos - $total_activos;

// Obtener el próximo orden sugerido
$proximo_orden = 1;
if (!empty($cursos)) {
    $max_orden = max(array_column($cursos, 'orden'));
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
    <link rel="stylesheet" href="../css/admin-cursos.css">
    <link rel="stylesheet" href="../css/components.css">
    <title>Gestión de Cursos - Babelium Admin</title>
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
                
                <a href="cursos.php" class="nav-item active">
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
                <h1>Gestión de Cursos</h1>
                <p>Administra los cursos por nivel educativo</p>
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
                        <label for="nivel">Nivel Educativo:</label>
                        <select name="nivel" id="nivel">
                            <option value="">Todos los niveles</option>
                            <?php foreach ($niveles as $nivel): ?>
                                <option value="<?php echo $nivel['id']; ?>" <?php echo $filtro_nivel == $nivel['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($nivel['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="cursos.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </form>

                <div class="content-actions">
                    <button onclick="openModal('createModal')" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nuevo Curso
                    </button>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-card primary">
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_cursos; ?></div>
                    <div class="stat-label">Cursos Totales</div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_activos; ?></div>
                    <div class="stat-label">Cursos Activos</div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_inactivos; ?></div>
                    <div class="stat-label">Cursos Inactivos</div>
                </div>
            </div>

            <!-- Lista de cursos -->
            <div class="curso-grid">
                <?php if (empty($cursos)): ?>
                    <div class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>No se encontraron cursos</p>
                        <small>Crea un nuevo curso para empezar</small>
                    </div>
                <?php else: ?>
                    <?php foreach ($cursos as $curso): ?>
                        <div class="curso-card <?php echo $curso['activo'] ? '' : 'inactivo'; ?>">
                            <div class="curso-header">
                                <div class="curso-title">
                                    <span class="orden"><?php echo $curso['orden']; ?></span>
                                    <span class="curso-title-text"><?php echo htmlspecialchars($curso['nombre']); ?></span>
                                </div>
                                <div class="curso-actions">
                                    <button onclick="editCurso(<?php echo htmlspecialchars(json_encode($curso)); ?>)" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="toggle">
                                        <input type="hidden" name="id" value="<?php echo $curso['id']; ?>">
                                        <input type="hidden" name="activo" value="<?php echo $curso['activo']; ?>">
                                        <button type="submit" class="btn btn-sm <?php echo $curso['activo'] ? 'btn-success' : 'btn-secondary'; ?>" title="<?php echo $curso['activo'] ? 'Desactivar' : 'Activar'; ?>">
                                            <i class="fas fa-<?php echo $curso['activo'] ? 'toggle-on' : 'toggle-off'; ?>"></i>
                                        </button>
                                    </form>
                                    
                                    <button onclick="deleteCurso(<?php echo $curso['id']; ?>, '<?php echo htmlspecialchars($curso['nombre']); ?>', <?php echo $curso['total_modalidades']; ?>)" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="curso-body">
                                <div class="curso-nivel">
                                    <span class="nivel-badge"><?php echo htmlspecialchars($curso['nivel_nombre']); ?></span>
                                </div>
                                <div class="curso-description">
                                    <?php echo !empty($curso['descripcion']) ? htmlspecialchars($curso['descripcion']) : '<em>Sin descripción</em>'; ?>
                                </div>
                                <div class="curso-meta">
                                    <div class="curso-meta-item">
                                        <i class="fas fa-sitemap"></i>
                                        <span><?php echo $curso['total_modalidades']; ?> modalidades</span>
                                    </div>
                                    <div class="curso-meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Creado: <?php echo isset($curso['fecha_creacion']) ? date('d/m/Y', strtotime($curso['fecha_creacion'])) : 'N/A'; ?></span>
                                    </div>
                                    <div class="curso-meta-item">
                                        <span class="estado-badge <?php echo $curso['activo'] ? 'estado-activo' : 'estado-inactivo'; ?>">
                                            <?php echo $curso['activo'] ? 'Activo' : 'Inactivo'; ?>
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

    <!-- Modal para crear curso -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-plus"></i> Nuevo Curso</h3>
                <button onclick="closeModal('createModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="create">
                
                <div class="form-group">
                    <label for="create_nivel_id">Nivel Educativo *</label>
                    <select name="nivel_id" id="create_nivel_id" required>
                        <option value="">Seleccionar nivel</option>
                        <?php foreach ($niveles as $nivel): ?>
                            <option value="<?php echo $nivel['id']; ?>">
                                <?php echo htmlspecialchars($nivel['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="create_nombre">Nombre del Curso *</label>
                    <input type="text" name="nombre" id="create_nombre" required>
                </div>

                <div class="form-group">
                    <label for="create_descripcion">Descripción</label>
                    <textarea name="descripcion" id="create_descripcion" rows="3" placeholder="Descripción del curso..."></textarea>
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
                        <i class="fas fa-save"></i> Crear Curso
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar curso -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Editar Curso</h3>
                <button onclick="closeModal('editModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_nivel_id">Nivel Educativo *</label>
                    <select name="nivel_id" id="edit_nivel_id" required>
                        <option value="">Seleccionar nivel</option>
                        <?php foreach ($niveles as $nivel): ?>
                            <option value="<?php echo $nivel['id']; ?>">
                                <?php echo htmlspecialchars($nivel['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_nombre">Nombre del Curso *</label>
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
                        <i class="fas fa-save"></i> Actualizar Curso
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
                <p>¿Estás seguro de que deseas eliminar el curso <strong id="deleteCursoTitle"></strong>?</p>
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

        // Función para editar curso
        function editCurso(curso) {
            document.getElementById('edit_id').value = curso.id;
            document.getElementById('edit_nivel_id').value = curso.nivel_id;
            document.getElementById('edit_nombre').value = curso.nombre;
            document.getElementById('edit_descripcion').value = curso.descripcion || '';
            document.getElementById('edit_orden').value = curso.orden;
            document.getElementById('edit_activo').checked = curso.activo == 1;
            
            openModal('editModal');
        }

        // Función para eliminar curso
        function deleteCurso(id, nombre, totalModalidades) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteCursoTitle').textContent = nombre;
            
            // Actualizar el mensaje según si hay modalidades asociadas
            const warningText = document.querySelector('#deleteModal .warning-text');
            if (totalModalidades > 0) {
                warningText.innerHTML = `<strong>⚠️ ADVERTENCIA:</strong> Este curso tiene ${totalModalidades} modalidad(es) asociada(s). Al eliminarlo también se eliminarán todas las modalidades, materias, temas y contenidos relacionados. Esta acción no se puede deshacer.`;
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
