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
                $curso_id = (int)$_POST['curso_id'];
                $rama_id = isset($_POST['rama_id']) && !empty($_POST['rama_id']) ? (int)$_POST['rama_id'] : null;
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']);
                $activo = isset($_POST['activo']) ? 1 : 0;
                
                if (!empty($nombre) && $curso_id > 0) {
                    // Verificar si ya existe una modalidad con ese nombre en el mismo curso
                    $stmt = $conexion->prepare("SELECT id FROM modalidades_curso WHERE nombre = ? AND curso_id = ?");
                    $stmt->bind_param("si", $nombre, $curso_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $mensaje = "Ya existe una modalidad con ese nombre en este curso";
                        $tipo_mensaje = "error";
                    } else {
                        // Insertar nueva modalidad
                        if ($rama_id) {
                            $stmt = $conexion->prepare("INSERT INTO modalidades_curso (curso_id, rama_id, nombre, descripcion, activo) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("iissi", $curso_id, $rama_id, $nombre, $descripcion, $activo);
                        } else {
                            $stmt = $conexion->prepare("INSERT INTO modalidades_curso (curso_id, nombre, descripcion, activo) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("issi", $curso_id, $nombre, $descripcion, $activo);
                        }
                        
                        if ($stmt->execute()) {
                            $mensaje = "Modalidad creada exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al crear la modalidad";
                            $tipo_mensaje = "error";
                        }
                    }
                    $stmt->close();
                }
                break;
                
            case 'edit':
                $id = (int)$_POST['id'];
                $curso_id = (int)$_POST['curso_id'];
                $rama_id = isset($_POST['rama_id']) && !empty($_POST['rama_id']) ? (int)$_POST['rama_id'] : null;
                $nombre = trim($_POST['nombre']);
                $descripcion = trim($_POST['descripcion']);
                $activo = isset($_POST['activo']) ? 1 : 0;
                
                if ($id > 0 && !empty($nombre) && $curso_id > 0) {
                    // Verificar si ya existe otra modalidad con ese nombre en el mismo curso
                    $stmt = $conexion->prepare("SELECT id FROM modalidades_curso WHERE nombre = ? AND curso_id = ? AND id != ?");
                    $stmt->bind_param("sii", $nombre, $curso_id, $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $mensaje = "Ya existe otra modalidad con ese nombre en este curso";
                        $tipo_mensaje = "error";
                    } else {
                        // Actualizar modalidad
                        if ($rama_id) {
                            $stmt = $conexion->prepare("UPDATE modalidades_curso SET curso_id = ?, rama_id = ?, nombre = ?, descripcion = ?, activo = ? WHERE id = ?");
                            $stmt->bind_param("iissii", $curso_id, $rama_id, $nombre, $descripcion, $activo, $id);
                        } else {
                            $stmt = $conexion->prepare("UPDATE modalidades_curso SET curso_id = ?, rama_id = NULL, nombre = ?, descripcion = ?, activo = ? WHERE id = ?");
                            $stmt->bind_param("issii", $curso_id, $nombre, $descripcion, $activo, $id);
                        }
                        
                        if ($stmt->execute()) {
                            $mensaje = "Modalidad actualizada exitosamente";
                            $tipo_mensaje = "success";
                        } else {
                            $mensaje = "Error al actualizar la modalidad";
                            $tipo_mensaje = "error";
                        }
                    }
                    $stmt->close();
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                if ($id > 0) {
                    // Verificar si hay materias asociadas
                    $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM materias WHERE modalidad_curso_id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $total_materias = $row['total'];
                    $stmt->close();
                    
                    // Eliminar modalidad (la BD maneja la cascada)
                    $stmt = $conexion->prepare("DELETE FROM modalidades_curso WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    
                    if ($stmt->execute()) {
                        if ($total_materias > 0) {
                            $mensaje = "Modalidad eliminada exitosamente junto con {$total_materias} materia(s) asociada(s)";
                        } else {
                            $mensaje = "Modalidad eliminada exitosamente";
                        }
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al eliminar la modalidad";
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
                    $stmt = $conexion->prepare("UPDATE modalidades_curso SET activo = ? WHERE id = ?");
                    $stmt->bind_param("ii", $nuevo_estado, $id);
                    
                    if ($stmt->execute()) {
                        $mensaje = "Estado de la modalidad actualizado exitosamente";
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al actualizar el estado de la modalidad";
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
$filtro_curso = isset($_GET['curso']) ? (int)$_GET['curso'] : 0;

// Obtener modalidades
try {
    $where_conditions = [];
    $params = [];
    $param_types = "";
    
    if ($filtro_nivel > 0) {
        $where_conditions[] = "COALESCE(ne.id, 0) = ?";
        $params[] = $filtro_nivel;
        $param_types .= "i";
    }
    
    if ($filtro_curso > 0) {
        $where_conditions[] = "m.curso_id = ?";
        $params[] = $filtro_curso;
        $param_types .= "i";
    }
    
    $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";
    
    $query = "
        SELECT m.*, 
               COALESCE(c.nombre, 'Sin curso') as curso_nombre,
               COALESCE(ne.nombre, 'Sin nivel') as nivel_nombre,
               COALESCE(r.nombre, 'Sin rama') as rama_nombre,
               COALESCE((SELECT COUNT(*) FROM materias WHERE modalidad_curso_id = m.id), 0) as total_materias
        FROM modalidades_curso m
        LEFT JOIN cursos c ON m.curso_id = c.id
        LEFT JOIN niveles_educativos ne ON c.nivel_id = ne.id
        LEFT JOIN ramas r ON m.rama_id = r.id
        $where_clause
        ORDER BY COALESCE(ne.orden, 999), COALESCE(c.orden, 999), m.nombre
    ";
    
    if (!empty($params)) {
        $stmt = $conexion->prepare($query);
        if (!$stmt) {
            throw new Exception("Error preparando consulta: " . $conexion->error);
        }
        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $modalidades = [];
        while ($row = $result->fetch_assoc()) {
            $modalidades[] = $row;
        }
        $stmt->close();
    } else {
        $result = $conexion->query($query);
        if (!$result) {
            throw new Exception("Error ejecutando consulta: " . $conexion->error);
        }
        $modalidades = [];
        while ($row = $result->fetch_assoc()) {
            $modalidades[] = $row;
        }
    }
} catch (Exception $e) {
    $modalidades = [];
    $mensaje = "Error al cargar las modalidades: " . $e->getMessage();
    $tipo_mensaje = "error";
    
    // Log del error para debugging
    error_log("Error en modalidades.php: " . $e->getMessage());
}

// Obtener niveles para filtros
try {
    $result = $conexion->query("SELECT id, nombre FROM niveles_educativos WHERE activo = 1 ORDER BY orden");
    $niveles = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $niveles[] = $row;
        }
    }
} catch (Exception $e) {
    $niveles = [];
}

// Obtener cursos para filtros y formularios
try {
    $query_cursos = "
        SELECT c.id, c.nombre, COALESCE(ne.nombre, 'Sin nivel') as nivel_nombre
        FROM cursos c
        LEFT JOIN niveles_educativos ne ON c.nivel_id = ne.id
        WHERE c.activo = 1
        ORDER BY COALESCE(ne.orden, 999), c.orden
    ";
    $result = $conexion->query($query_cursos);
    $cursos = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $cursos[] = $row;
        }
    }
} catch (Exception $e) {
    $cursos = [];
}

// Obtener ramas para formularios
try {
    $result = $conexion->query("SELECT id, nombre FROM ramas WHERE activo = 1 ORDER BY nombre");
    $ramas = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $ramas[] = $row;
        }
    }
} catch (Exception $e) {
    $ramas = [];
}

// Estadísticas
$total_modalidades = count($modalidades);
$modalidades_activas = array_filter($modalidades, function($modalidad) {
    return $modalidad['activo'] == 1;
});
$total_activas = count($modalidades_activas);
$total_inactivas = $total_modalidades - $total_activas;
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
    <link rel="stylesheet" href="../css/admin-modalidades.css">
    <link rel="stylesheet" href="../css/components.css">
    <title>Gestión de Modalidades - Babelium Admin</title>
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
                
                <a href="modalidades.php" class="nav-item active">
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
                <h1>Gestión de Modalidades</h1>
                <p>Administra las modalidades de los cursos</p>
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

                    <div class="filter-group">
                        <label for="curso">Curso:</label>
                        <select name="curso" id="curso">
                            <option value="">Todos los cursos</option>
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?php echo $curso['id']; ?>" <?php echo $filtro_curso == $curso['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($curso['nivel_nombre'] . ' - ' . $curso['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                        <a href="modalidades.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </form>

                <div class="content-actions">
                    <button onclick="openModal('createModal')" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nueva Modalidad
                    </button>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="stats-container">
                <div class="stat-card primary">
                    <div class="stat-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_modalidades; ?></div>
                    <div class="stat-label">Modalidades Totales</div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_activas; ?></div>
                    <div class="stat-label">Modalidades Activas</div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <div class="stat-number"><?php echo $total_inactivas; ?></div>
                    <div class="stat-label">Modalidades Inactivas</div>
                </div>
            </div>

            <!-- Lista de modalidades -->
            <div class="modalidad-grid">
                <?php if (empty($modalidades)): ?>
                    <div class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>No se encontraron modalidades</p>
                        <small>Crea una nueva modalidad para empezar</small>
                    </div>
                <?php else: ?>
                    <?php foreach ($modalidades as $modalidad): ?>
                        <div class="modalidad-card <?php echo $modalidad['activo'] ? '' : 'inactivo'; ?>">
                            <div class="modalidad-header">
                                <div class="modalidad-title">
                                    <span class="modalidad-title-text"><?php echo htmlspecialchars($modalidad['nombre']); ?></span>
                                </div>
                                <div class="modalidad-actions">
                                    <button onclick="editModalidad(<?php echo htmlspecialchars(json_encode($modalidad)); ?>)" class="btn btn-sm btn-primary" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="toggle">
                                        <input type="hidden" name="id" value="<?php echo $modalidad['id']; ?>">
                                        <input type="hidden" name="activo" value="<?php echo $modalidad['activo']; ?>">
                                        <button type="submit" class="btn btn-sm <?php echo $modalidad['activo'] ? 'btn-success' : 'btn-secondary'; ?>" title="<?php echo $modalidad['activo'] ? 'Desactivar' : 'Activar'; ?>">
                                            <i class="fas fa-<?php echo $modalidad['activo'] ? 'toggle-on' : 'toggle-off'; ?>"></i>
                                        </button>
                                    </form>
                                    
                                    <button onclick="deleteModalidad(<?php echo $modalidad['id']; ?>, '<?php echo htmlspecialchars($modalidad['nombre']); ?>', <?php echo $modalidad['total_materias']; ?>)" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="modalidad-body">
                                <div class="modalidad-badges">
                                    <span class="nivel-badge"><?php echo htmlspecialchars($modalidad['nivel_nombre']); ?></span>
                                    <span class="curso-badge"><?php echo htmlspecialchars($modalidad['curso_nombre']); ?></span>
                                    <?php if ($modalidad['rama_id']): ?>
                                        <span class="rama-badge"><?php echo htmlspecialchars($modalidad['rama_nombre']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="modalidad-description">
                                    <?php echo !empty($modalidad['descripcion']) ? htmlspecialchars($modalidad['descripcion']) : '<em>Sin descripción</em>'; ?>
                                </div>
                                <div class="modalidad-meta">
                                    <div class="modalidad-meta-item">
                                        <i class="fas fa-book"></i>
                                        <span><?php echo $modalidad['total_materias']; ?> materias</span>
                                    </div>
                                    <div class="modalidad-meta-item">
                                        <span class="estado-badge <?php echo $modalidad['activo'] ? 'estado-activo' : 'estado-inactivo'; ?>">
                                            <?php echo $modalidad['activo'] ? 'Activo' : 'Inactivo'; ?>
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

    <!-- Modal para crear modalidad -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-plus"></i> Nueva Modalidad</h3>
                <button onclick="closeModal('createModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="create">
                
                <div class="form-group">
                    <label for="create_curso_id">Curso *</label>
                    <select name="curso_id" id="create_curso_id" required>
                        <option value="">Seleccionar curso</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?php echo $curso['id']; ?>">
                                <?php echo htmlspecialchars($curso['nivel_nombre'] . ' - ' . $curso['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="create_rama_id">Rama (opcional)</label>
                    <select name="rama_id" id="create_rama_id">
                        <option value="">Sin rama específica</option>
                        <?php foreach ($ramas as $rama): ?>
                            <option value="<?php echo $rama['id']; ?>">
                                <?php echo htmlspecialchars($rama['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="create_nombre">Nombre de la Modalidad *</label>
                    <input type="text" name="nombre" id="create_nombre" required>
                </div>

                <div class="form-group">
                    <label for="create_descripcion">Descripción</label>
                    <textarea name="descripcion" id="create_descripcion" rows="3" placeholder="Descripción de la modalidad..."></textarea>
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
                        <i class="fas fa-save"></i> Crear Modalidad
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar modalidad -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Editar Modalidad</h3>
                <button onclick="closeModal('editModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_curso_id">Curso *</label>
                    <select name="curso_id" id="edit_curso_id" required>
                        <option value="">Seleccionar curso</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?php echo $curso['id']; ?>">
                                <?php echo htmlspecialchars($curso['nivel_nombre'] . ' - ' . $curso['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_rama_id">Rama (opcional)</label>
                    <select name="rama_id" id="edit_rama_id">
                        <option value="">Sin rama específica</option>
                        <?php foreach ($ramas as $rama): ?>
                            <option value="<?php echo $rama['id']; ?>">
                                <?php echo htmlspecialchars($rama['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="edit_nombre">Nombre de la Modalidad *</label>
                    <input type="text" name="nombre" id="edit_nombre" required>
                </div>

                <div class="form-group">
                    <label for="edit_descripcion">Descripción</label>
                    <textarea name="descripcion" id="edit_descripcion" rows="3"></textarea>
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
                        <i class="fas fa-save"></i> Actualizar Modalidad
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
                <p>¿Estás seguro de que deseas eliminar la modalidad <strong id="deleteModalidadTitle"></strong>?</p>
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

        // Función para editar modalidad
        function editModalidad(modalidad) {
            document.getElementById('edit_id').value = modalidad.id;
            document.getElementById('edit_curso_id').value = modalidad.curso_id;
            document.getElementById('edit_rama_id').value = modalidad.rama_id || '';
            document.getElementById('edit_nombre').value = modalidad.nombre;
            document.getElementById('edit_descripcion').value = modalidad.descripcion || '';
            document.getElementById('edit_activo').checked = modalidad.activo == 1;
            
            openModal('editModal');
        }

        // Función para eliminar modalidad
        function deleteModalidad(id, nombre, totalMaterias) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteModalidadTitle').textContent = nombre;
            
            // Actualizar el mensaje según si hay materias asociadas
            const warningText = document.querySelector('#deleteModal .warning-text');
            if (totalMaterias > 0) {
                warningText.innerHTML = `<strong>⚠️ ADVERTENCIA:</strong> Esta modalidad tiene ${totalMaterias} materia(s) asociada(s). Al eliminarla también se eliminarán todas las materias, temas y contenidos relacionados. Esta acción no se puede deshacer.`;
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
