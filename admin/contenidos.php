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
                $titulo = trim($_POST['titulo']);
                $contenido = trim($_POST['contenido']);
                $tema_id = (int)$_POST['tema_id'];
                $orden = (int)$_POST['orden'];
                $tipo = $_POST['tipo'];
                $duracion_estimada = (int)$_POST['duracion_estimada'];
                
                if (!empty($titulo) && !empty($contenido) && $tema_id > 0) {
                    $stmt = $conexion->prepare("INSERT INTO contenidos (tema_id, titulo, contenido, tipo, orden, duracion_estimada, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->bind_param("isssii", $tema_id, $titulo, $contenido, $tipo, $orden, $duracion_estimada);
                    
                    if ($stmt->execute()) {
                        $mensaje = "Contenido creado exitosamente";
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al crear el contenido";
                        $tipo_mensaje = "error";
                    }
                    $stmt->close();
                }
                break;
                
            case 'edit':
                $id = (int)$_POST['id'];
                $titulo = trim($_POST['titulo']);
                $contenido = trim($_POST['contenido']);
                $tema_id = (int)$_POST['tema_id'];
                $orden = (int)$_POST['orden'];
                $tipo = $_POST['tipo'];
                $duracion_estimada = (int)$_POST['duracion_estimada'];
                
                if ($id > 0 && !empty($titulo) && !empty($contenido)) {
                    $stmt = $conexion->prepare("UPDATE contenidos SET titulo = ?, contenido = ?, tema_id = ?, tipo = ?, orden = ?, duracion_estimada = ?, fecha_actualizacion = NOW() WHERE id = ?");
                    $stmt->bind_param("ssissii", $titulo, $contenido, $tema_id, $tipo, $orden, $duracion_estimada, $id);
                    
                    if ($stmt->execute()) {
                        $mensaje = "Contenido actualizado exitosamente";
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al actualizar el contenido";
                        $tipo_mensaje = "error";
                    }
                    $stmt->close();
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                if ($id > 0) {
                    $stmt = $conexion->prepare("DELETE FROM contenidos WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    
                    if ($stmt->execute()) {
                        $mensaje = "Contenido eliminado exitosamente";
                        $tipo_mensaje = "success";
                    } else {
                        $mensaje = "Error al eliminar el contenido";
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
$filtro_tema = isset($_GET['tema']) ? (int)$_GET['tema'] : 0;
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Construir consulta para MySQLi
$where_conditions = [];
$params = [];
$param_types = "";

if ($filtro_materia > 0) {
    $where_conditions[] = "t.materia_id = ?";
    $params[] = $filtro_materia;
    $param_types .= "i";
}

if ($filtro_tema > 0) {
    $where_conditions[] = "c.tema_id = ?";
    $params[] = $filtro_tema;
    $param_types .= "i";
}

if (!empty($busqueda)) {
    $where_conditions[] = "(c.titulo LIKE ? OR c.contenido LIKE ?)";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
    $param_types .= "ss";
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Consulta para MySQLi
try {
    $query = "
        SELECT c.*, 
               t.titulo as tema_nombre, 
               m.nombre as materia_nombre
        FROM contenidos c
        JOIN temas t ON c.tema_id = t.id
        JOIN materias m ON t.materia_id = m.id
        $where_clause
        ORDER BY m.nombre, t.orden, c.orden
    ";
    
    if (!empty($params)) {
        $stmt = $conexion->prepare($query);
        $stmt->bind_param($param_types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $contenidos = [];
        while ($row = $result->fetch_assoc()) {
            $contenidos[] = $row;
        }
        $stmt->close();
    } else {
        $result = $conexion->query($query);
        $contenidos = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $contenidos[] = $row;
            }
        }
    }
} catch (Exception $e) {
    $contenidos = [];
    $mensaje = "Error al cargar los contenidos";
    $tipo_mensaje = "error";
}

// Obtener materias para filtros
try {
    $result = $conexion->query("SELECT id, nombre FROM materias ORDER BY nombre");
    $materias = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row;
        }
    }
} catch (Exception $e) {
    $materias = [];
}

// Obtener temas para el formulario
try {
    $query_temas = "
        SELECT t.id, t.titulo as nombre, m.nombre as materia_nombre
        FROM temas t
        JOIN materias m ON t.materia_id = m.id
        ORDER BY m.nombre, t.orden
    ";
    $result = $conexion->query($query_temas);
    $temas = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $temas[] = $row;
        }
    }
} catch (Exception $e) {
    $temas = [];
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
    <link rel="stylesheet" href="../css/admin-contenidos.css">
    <link rel="stylesheet" href="../css/components.css">
    <title>Gestión de Contenidos - Babelium Admin</title>
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
                
                <a href="contenidos.php" class="nav-item active">
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
                <h1>Gestión de Contenidos</h1>
                <p>Administra todo el contenido educativo de la plataforma</p>
            </div>

            <!-- Mensajes -->
            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                    <i class="fas fa-<?php echo $tipo_mensaje === 'success' ? 'check-circle' : ($tipo_mensaje === 'warning' ? 'exclamation-triangle' : 'exclamation-triangle'); ?>"></i>
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <!-- Filtros y búsqueda -->
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

                    <div class="filter-group">
                        <label for="tema">Tema:</label>
                        <select name="tema" id="tema">
                            <option value="">Todos los temas</option>
                            <?php foreach ($temas as $tema): ?>
                                <option value="<?php echo $tema['id']; ?>" <?php echo $filtro_tema == $tema['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($tema['materia_nombre'] . ' - ' . $tema['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="busqueda">Buscar:</label>
                        <input type="text" name="busqueda" id="busqueda" placeholder="Título o contenido..." value="<?php echo htmlspecialchars($busqueda); ?>">
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filtrar
                        </button>
                        <a href="contenidos.php" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </form>

                <div class="content-actions">
                    <button onclick="openModal('createModal')" class="btn btn-success">
                        <i class="fas fa-plus"></i> Nuevo Contenido
                    </button>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="content-stats">
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($contenidos); ?></span>
                    <span class="stat-label">Contenidos encontrados</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($materias); ?></span>
                    <span class="stat-label">Materias disponibles</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo count($temas); ?></span>
                    <span class="stat-label">Temas disponibles</span>
                </div>
            </div>

            <!-- Tabla de contenidos -->
            <div class="content-table-container">
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Materia</th>
                            <th>Tema</th>
                            <th>Tipo</th>
                            <th>Orden</th>
                            <th>Duración</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($contenidos)): ?>
                            <tr>
                                <td colspan="8" class="no-data">
                                    <i class="fas fa-inbox"></i>
                                    <p>No se encontraron contenidos</p>
                                    <small>Usa los filtros o crea un nuevo contenido</small>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($contenidos as $contenido): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($contenido['titulo']); ?></strong>
                                        <small><?php echo htmlspecialchars(substr($contenido['contenido'], 0, 100)) . '...'; ?></small>
                                    </td>
                                    <td>
                                        <span class="materia-badge">
                                            <?php echo htmlspecialchars($contenido['materia_nombre']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($contenido['tema_nombre']); ?></td>
                                    <td>
                                        <span class="tipo-badge tipo-<?php echo $contenido['tipo']; ?>">
                                            <?php echo ucfirst($contenido['tipo']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo $contenido['orden']; ?></td>
                                    <td><?php echo isset($contenido['duracion_estimada']) ? $contenido['duracion_estimada'] . ' min' : 'N/A'; ?></td>
                                    <td><?php echo isset($contenido['fecha_creacion']) ? date('d/m/Y', strtotime($contenido['fecha_creacion'])) : 'N/A'; ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button onclick="editContent(<?php echo htmlspecialchars(json_encode($contenido)); ?>)" class="btn btn-sm btn-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteContent(<?php echo $contenido['id']; ?>, '<?php echo htmlspecialchars($contenido['titulo']); ?>')" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <a href="../contenido.php?id=<?php echo $contenido['id']; ?>" target="_blank" class="btn btn-sm btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal para crear contenido -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-plus"></i> Nuevo Contenido</h3>
                <button onclick="closeModal('createModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="create">
                
                <div class="form-group">
                    <label for="create_titulo">Título *</label>
                    <input type="text" name="titulo" id="create_titulo" required>
                </div>

                <div class="form-group">
                    <label for="create_tema_id">Tema *</label>
                    <select name="tema_id" id="create_tema_id" required>
                        <option value="">Seleccionar tema</option>
                        <?php foreach ($temas as $tema): ?>
                            <option value="<?php echo $tema['id']; ?>">
                                <?php echo htmlspecialchars($tema['materia_nombre'] . ' - ' . $tema['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="create_tipo">Tipo</label>
                        <select name="tipo" id="create_tipo">
                            <option value="texto">Texto</option>
                            <option value="imagen">Imagen</option>
                            <option value="video">Video</option>
                            <option value="archivo">Archivo</option>
                            <option value="enlace">Enlace</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="create_orden">Orden</label>
                        <input type="number" name="orden" id="create_orden" value="1" min="1">
                    </div>

                    <div class="form-group">
                        <label for="create_duracion">Duración (min)</label>
                        <input type="number" name="duracion_estimada" id="create_duracion" value="15" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label for="create_contenido">Contenido *</label>
                    <textarea name="contenido" id="create_contenido" rows="10" required placeholder="Escribe aquí el contenido educativo..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="closeModal('createModal')" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Crear Contenido
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar contenido -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Editar Contenido</h3>
                <button onclick="closeModal('editModal')" class="modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form method="POST" class="modal-form">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                
                <div class="form-group">
                    <label for="edit_titulo">Título *</label>
                    <input type="text" name="titulo" id="edit_titulo" required>
                </div>

                <div class="form-group">
                    <label for="edit_tema_id">Tema *</label>
                    <select name="tema_id" id="edit_tema_id" required>
                        <option value="">Seleccionar tema</option>
                        <?php foreach ($temas as $tema): ?>
                            <option value="<?php echo $tema['id']; ?>">
                                <?php echo htmlspecialchars($tema['materia_nombre'] . ' - ' . $tema['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_tipo">Tipo</label>
                        <select name="tipo" id="edit_tipo">
                            <option value="texto">Texto</option>
                            <option value="imagen">Imagen</option>
                            <option value="video">Video</option>
                            <option value="archivo">Archivo</option>
                            <option value="enlace">Enlace</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_orden">Orden</label>
                        <input type="number" name="orden" id="edit_orden" min="1">
                    </div>

                    <div class="form-group">
                        <label for="edit_duracion">Duración (min)</label>
                        <input type="number" name="duracion_estimada" id="edit_duracion" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_contenido">Contenido *</label>
                    <textarea name="contenido" id="edit_contenido" rows="10" required></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" onclick="closeModal('editModal')" class="btn btn-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Contenido
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
                <p>¿Estás seguro de que deseas eliminar el contenido <strong id="deleteContentTitle"></strong>?</p>
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

        // Función para editar contenido
        function editContent(content) {
            document.getElementById('edit_id').value = content.id;
            document.getElementById('edit_titulo').value = content.titulo;
            document.getElementById('edit_tema_id').value = content.tema_id;
            document.getElementById('edit_tipo').value = content.tipo;
            document.getElementById('edit_orden').value = content.orden;
            document.getElementById('edit_duracion').value = content.duracion_estimada || 15;
            document.getElementById('edit_contenido').value = content.contenido;
            
            openModal('editModal');
        }

        // Función para eliminar contenido
        function deleteContent(id, titulo) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteContentTitle').textContent = titulo;
            
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
