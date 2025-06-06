<?php
session_start();
require_once('../db/connection.php');
require_once '../includes/auth_check.php';

// Verificar que sea administrador
verificarAutenticacion('admin');

// Obtener todas las tablas de la base de datos
$query_tables = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES 
                 WHERE TABLE_SCHEMA = DATABASE() 
                 ORDER BY TABLE_NAME";
$result_tables = $conexion->query($query_tables);
$tables = [];

if ($result_tables) {
    while ($row = $result_tables->fetch_assoc()) {
        $tables[] = $row['TABLE_NAME'];
    }
}

// Obtener información de la tabla seleccionada
$selected_table = isset($_GET['table']) ? $_GET['table'] : (count($tables) > 0 ? $tables[0] : '');
$table_info = [];
$columns = [];
$foreign_keys = [];
$indexes = [];

if (!empty($selected_table)) {
    // Obtener columnas de la tabla
    $query_columns = "SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_KEY, COLUMN_DEFAULT, EXTRA 
                      FROM INFORMATION_SCHEMA.COLUMNS 
                      WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? 
                      ORDER BY ORDINAL_POSITION";
    $stmt = $conexion->prepare($query_columns);
    $stmt->bind_param("s", $selected_table);
    $stmt->execute();
    $result_columns = $stmt->get_result();
    
    while ($row = $result_columns->fetch_assoc()) {
        $columns[] = $row;
    }
    
    // Obtener claves foráneas
    $query_fk = "SELECT 
                    CONSTRAINT_NAME,
                    COLUMN_NAME,
                    REFERENCED_TABLE_NAME,
                    REFERENCED_COLUMN_NAME
                 FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                 WHERE TABLE_SCHEMA = DATABASE() 
                   AND TABLE_NAME = ?
                   AND REFERENCED_TABLE_NAME IS NOT NULL";
    $stmt = $conexion->prepare($query_fk);
    $stmt->bind_param("s", $selected_table);
    $stmt->execute();
    $result_fk = $stmt->get_result();
    
    while ($row = $result_fk->fetch_assoc()) {
        $foreign_keys[] = $row;
    }
    
    // Obtener índices
    $query_indexes = "SHOW INDEX FROM `$selected_table`";
    $result_indexes = $conexion->query($query_indexes);
    
    if ($result_indexes) {
        $temp_indexes = [];
        while ($row = $result_indexes->fetch_assoc()) {
            $index_name = $row['Key_name'];
            if (!isset($temp_indexes[$index_name])) {
                $temp_indexes[$index_name] = [
                    'name' => $index_name,
                    'unique' => $row['Non_unique'] == 0 ? 'Sí' : 'No',
                    'columns' => []
                ];
            }
            $temp_indexes[$index_name]['columns'][] = $row['Column_name'];
        }
        
        foreach ($temp_indexes as $index) {
            $indexes[] = $index;
        }
    }
    
    // Obtener información de la tabla
    $query_table_info = "SHOW TABLE STATUS WHERE Name = ?";
    $stmt = $conexion->prepare($query_table_info);
    $stmt->bind_param("s", $selected_table);
    $stmt->execute();
    $result_table_info = $stmt->get_result();
    
    if ($row = $result_table_info->fetch_assoc()) {
        $table_info = $row;
    }
}

// Obtener tablas relacionadas (que tienen FK a esta tabla)
$related_tables = [];
if (!empty($selected_table)) {
    $query_related = "SELECT 
                        TABLE_NAME,
                        COLUMN_NAME,
                        CONSTRAINT_NAME,
                        REFERENCED_COLUMN_NAME
                     FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                     WHERE TABLE_SCHEMA = DATABASE() 
                       AND REFERENCED_TABLE_NAME = ?";
    $stmt = $conexion->prepare($query_related);
    $stmt->bind_param("s", $selected_table);
    $stmt->execute();
    $result_related = $stmt->get_result();
    
    while ($row = $result_related->fetch_assoc()) {
        $related_tables[] = $row;
    }
}

// Obtener la creación de la tabla (CREATE TABLE)
$create_table_sql = '';
if (!empty($selected_table)) {
    $query_create = "SHOW CREATE TABLE `$selected_table`";
    $result_create = $conexion->query($query_create);
    
    if ($result_create && $row = $result_create->fetch_assoc()) {
        $create_table_sql = $row['Create Table'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estructura de la Base de Datos - Babelium Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin-estructura.css">
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
                
                <a href="estructura.php" class="nav-item active">
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
                <h1><i class="fas fa-database"></i> Estructura de la Base de Datos</h1>
                <p>Visualiza la estructura de las tablas y sus relaciones</p>
            </div>

            <div class="structure-container">
                <!-- Sidebar con lista de tablas -->
                <div class="tables-sidebar">
                    <h3>
                        <i class="fas fa-table"></i>
                        Tablas de la Base de Datos
                    </h3>
                    
                    <?php if (empty($tables)): ?>
                        <div class="no-data">
                            <i class="fas fa-inbox"></i>
                            <p>No se encontraron tablas</p>
                        </div>
                    <?php else: ?>
                        <ul class="tables-list">
                            <?php foreach ($tables as $table): ?>
                                <li>
                                    <a href="?table=<?php echo urlencode($table); ?>" class="<?php echo $selected_table === $table ? 'active' : ''; ?>">
                                        <i class="fas fa-table"></i>
                                        <?php echo htmlspecialchars($table); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <!-- Contenido principal con estructura de la tabla -->
                <div class="table-structure">
                    <?php if (empty($selected_table)): ?>
                        <div class="no-data">
                            <i class="fas fa-database"></i>
                            <p>Selecciona una tabla para ver su estructura</p>
                            <small>Elige una tabla del panel lateral para comenzar</small>
                        </div>
                    <?php else: ?>
                        <div class="table-header">
                            <h2>
                                <i class="fas fa-table"></i>
                                Tabla: <?php echo htmlspecialchars($selected_table); ?>
                            </h2>
                        </div>
                        
                        <!-- Información general de la tabla -->
                        <?php if (!empty($table_info)): ?>
                            <div class="section-title">
                                <i class="fas fa-info-circle"></i>
                                Información General
                            </div>
                            
                            <div class="table-info">
                                <div class="table-info-grid">
                                    <div class="info-item">
                                        <span class="info-label">Motor</span>
                                        <span class="info-value"><?php echo htmlspecialchars($table_info['Engine']); ?></span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Collation</span>
                                        <span class="info-value"><?php echo htmlspecialchars($table_info['Collation']); ?></span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Filas (aprox.)</span>
                                        <span class="info-value"><?php echo number_format($table_info['Rows']); ?></span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Tamaño de datos</span>
                                        <span class="info-value"><?php echo formatBytes($table_info['Data_length']); ?></span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Creación</span>
                                        <span class="info-value"><?php echo $table_info['Create_time'] ? date('d/m/Y H:i', strtotime($table_info['Create_time'])) : 'N/A'; ?></span>
                                    </div>
                                    
                                    <div class="info-item">
                                        <span class="info-label">Actualización</span>
                                        <span class="info-value"><?php echo $table_info['Update_time'] ? date('d/m/Y H:i', strtotime($table_info['Update_time'])) : 'N/A'; ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Columnas de la tabla -->
                        <div class="section-title">
                            <i class="fas fa-columns"></i>
                            Columnas (<?php echo count($columns); ?>)
                        </div>
                        
                        <div class="table-responsive">
                            <table class="structure-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Nulo</th>
                                        <th>Clave</th>
                                        <th>Predeterminado</th>
                                        <th>Extra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($columns)): ?>
                                        <tr>
                                            <td colspan="6" class="no-data">No se encontraron columnas</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($columns as $column): ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                    // Mostrar icono según el tipo de clave
                                                    if ($column['COLUMN_KEY'] === 'PRI') {
                                                        echo '<span class="key-icon primary-key" title="Clave Primaria"><i class="fas fa-key"></i></span>';
                                                    } elseif ($column['COLUMN_KEY'] === 'MUL') {
                                                        echo '<span class="key-icon foreign-key" title="Clave Foránea"><i class="fas fa-link"></i></span>';
                                                    } elseif ($column['COLUMN_KEY'] === 'UNI') {
                                                        echo '<span class="key-icon unique-key" title="Clave Única"><i class="fas fa-fingerprint"></i></span>';
                                                    }
                                                    
                                                    echo '<strong>' . htmlspecialchars($column['COLUMN_NAME']) . '</strong>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <code><?php echo htmlspecialchars($column['COLUMN_TYPE']); ?></code>
                                                </td>
                                                <td>
                                                    <?php if ($column['IS_NULLABLE'] === 'YES'): ?>
                                                        <span style="color: #28a745;">✓ Sí</span>
                                                    <?php else: ?>
                                                        <span style="color: #dc3545;">✗ No</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    switch ($column['COLUMN_KEY']) {
                                                        case 'PRI':
                                                            echo '<span style="color: #e74c3c; font-weight: 600;">Primaria</span>';
                                                            break;
                                                        case 'MUL':
                                                            echo '<span style="color: #3498db; font-weight: 600;">Foránea</span>';
                                                            break;
                                                        case 'UNI':
                                                            echo '<span style="color: #2ecc71; font-weight: 600;">Única</span>';
                                                            break;
                                                        default:
                                                            echo '<span style="color: #6c757d;">-</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($column['COLUMN_DEFAULT'] !== null): ?>
                                                        <code><?php echo htmlspecialchars($column['COLUMN_DEFAULT']); ?></code>
                                                    <?php else: ?>
                                                        <em style="color: #6c757d;">NULL</em>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($column['EXTRA'])): ?>
                                                        <span style="color: #f39c12; font-weight: 600;"><?php echo htmlspecialchars($column['EXTRA']); ?></span>
                                                    <?php else: ?>
                                                        <span style="color: #6c757d;">-</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Claves foráneas -->
                        <?php if (!empty($foreign_keys)): ?>
                            <div class="section-title">
                                <i class="fas fa-link"></i>
                                Claves Foráneas (<?php echo count($foreign_keys); ?>)
                            </div>
                            
                            <div class="table-responsive">
                                <table class="structure-table">
                                    <thead>
                                        <tr>
                                            <th>Nombre de la Restricción</th>
                                            <th>Columna</th>
                                            <th>Tabla Referenciada</th>
                                            <th>Columna Referenciada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($foreign_keys as $fk): ?>
                                            <tr>
                                                <td><code><?php echo htmlspecialchars($fk['CONSTRAINT_NAME']); ?></code></td>
                                                <td><strong><?php echo htmlspecialchars($fk['COLUMN_NAME']); ?></strong></td>
                                                <td>
                                                    <a href="?table=<?php echo urlencode($fk['REFERENCED_TABLE_NAME']); ?>">
                                                        <i class="fas fa-external-link-alt"></i>
                                                        <?php echo htmlspecialchars($fk['REFERENCED_TABLE_NAME']); ?>
                                                    </a>
                                                </td>
                                                <td><strong><?php echo htmlspecialchars($fk['REFERENCED_COLUMN_NAME']); ?></strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Tablas relacionadas -->
                        <?php if (!empty($related_tables)): ?>
                            <div class="section-title">
                                <i class="fas fa-project-diagram"></i>
                                Tablas Relacionadas (<?php echo count($related_tables); ?>)
                            </div>
                            
                            <div class="table-responsive">
                                <table class="structure-table">
                                    <thead>
                                        <tr>
                                            <th>Tabla</th>
                                            <th>Columna</th>
                                            <th>Nombre de la Restricción</th>
                                            <th>Columna Referenciada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($related_tables as $rel): ?>
                                            <tr>
                                                <td>
                                                    <a href="?table=<?php echo urlencode($rel['TABLE_NAME']); ?>">
                                                        <i class="fas fa-external-link-alt"></i>
                                                        <?php echo htmlspecialchars($rel['TABLE_NAME']); ?>
                                                    </a>
                                                </td>
                                                <td><strong><?php echo htmlspecialchars($rel['COLUMN_NAME']); ?></strong></td>
                                                <td><code><?php echo htmlspecialchars($rel['CONSTRAINT_NAME']); ?></code></td>
                                                <td><strong><?php echo htmlspecialchars($rel['REFERENCED_COLUMN_NAME']); ?></strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Índices -->
                        <?php if (!empty($indexes)): ?>
                            <div class="section-title">
                                <i class="fas fa-search"></i>
                                Índices (<?php echo count($indexes); ?>)
                            </div>
                            
                            <div class="table-responsive">
                                <table class="structure-table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Único</th>
                                            <th>Columnas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($indexes as $index): ?>
                                            <tr>
                                                <td>
                                                    <?php 
                                                    if ($index['name'] === 'PRIMARY') {
                                                        echo '<span class="key-icon primary-key" title="Clave Primaria"><i class="fas fa-key"></i></span>';
                                                    } else {
                                                        echo '<span class="key-icon index-key" title="Índice"><i class="fas fa-search"></i></span>';
                                                    }
                                                    
                                                    echo '<strong>' . htmlspecialchars($index['name']) . '</strong>'; 
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($index['unique'] === 'Sí'): ?>
                                                        <span style="color: #28a745;">✓ Sí</span>
                                                    <?php else: ?>
                                                        <span style="color: #6c757d;">✗ No</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><code><?php echo htmlspecialchars(implode(', ', $index['columns'])); ?></code></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                        
                        <!-- SQL de creación -->
                        <?php if (!empty($create_table_sql)): ?>
                            <div class="section-title">
                                <i class="fas fa-code"></i>
                                SQL de Creación
                            </div>
                            
                            <div class="code-block"><?php 
                                // Formatear el SQL para resaltar palabras clave
                                $formatted_sql = htmlspecialchars($create_table_sql);
                                $keywords = ['CREATE', 'TABLE', 'INT', 'VARCHAR', 'TEXT', 'TIMESTAMP', 'DEFAULT', 'NOT NULL', 'AUTO_INCREMENT', 'PRIMARY KEY', 'FOREIGN KEY', 'REFERENCES', 'ON DELETE', 'ON UPDATE', 'CASCADE', 'RESTRICT', 'SET NULL', 'UNIQUE', 'INDEX', 'CONSTRAINT'];
                                
                                foreach ($keywords as $keyword) {
                                    $formatted_sql = str_replace($keyword, '<span class="code-keyword">' . $keyword . '</span>', $formatted_sql);
                                }
                                
                                echo $formatted_sql;
                            ?></div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php include 'footer.php'; ?>
    
    <script>
        // Función para resaltar la sintaxis SQL
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar tooltips dinámicos
            const keyIcons = document.querySelectorAll('.key-icon');
            keyIcons.forEach(icon => {
                icon.addEventListener('mouseenter', function() {
                    const tooltip = this.getAttribute('title');
                    if (tooltip) {
                        this.setAttribute('data-tooltip', tooltip);
                        this.classList.add('tooltip');
                    }
                });
            });
            
            // Smooth scroll para enlaces internos
            const tableLinks = document.querySelectorAll('a[href^="?table="]');
            tableLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Agregar una pequeña animación de carga
                    const tableStructure = document.querySelector('.table-structure');
                    if (tableStructure) {
                        tableStructure.style.opacity = '0.7';
                        setTimeout(() => {
                            tableStructure.style.opacity = '1';
                        }, 300);
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
// Función para formatear bytes a unidades legibles
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, $precision) . ' ' . $units[$pow];
}
?>
