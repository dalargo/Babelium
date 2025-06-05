<?php
// Incluir verificación de autenticación
require_once('../auth.php');

// Incluir conexión a la base de datos
require_once('../db.php');

// Establecer la conexión a la base de datos
$conn = connectDB();

// Variables para la paginación
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$resultados_por_pagina = 10;
$indice_inicio = ($pagina - 1) * $resultados_por_pagina;

// Manejar envíos de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear nuevo contenido
    if (isset($_POST['crear'])) {
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $tipo = $_POST['tipo'];
        $autor = $_SESSION['usuario']; // Asumiendo que tienes la sesión del usuario

        $sql = "INSERT INTO contenidos (titulo, contenido, tipo, autor) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $titulo, $contenido, $tipo, $autor);

        if ($stmt->execute()) {
            echo "<script>alert('Contenido creado exitosamente.'); window.location.href='contenidos.php';</script>";
        } else {
            echo "<script>alert('Error al crear el contenido: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    // Actualizar contenido existente
    if (isset($_POST['actualizar'])) {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $tipo = $_POST['tipo'];

        $sql = "UPDATE contenidos SET titulo = ?, contenido = ?, tipo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $titulo, $contenido, $tipo, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Contenido actualizado exitosamente.'); window.location.href='contenidos.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar el contenido: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    // Eliminar contenido
    if (isset($_POST['eliminar'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM contenidos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Contenido eliminado exitosamente.'); window.location.href='contenidos.php';</script>";
        } else {
            echo "<script>alert('Error al eliminar el contenido: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
}

// Obtener parámetros de filtro
$filtro_tipo = isset($_GET['filtro_tipo']) ? $_GET['filtro_tipo'] : '';
$filtro_titulo = isset($_GET['filtro_titulo']) ? $_GET['filtro_titulo'] : '';

// Construir consulta con filtros
$sql = "SELECT * FROM contenidos WHERE 1=1"; // 1=1 para facilitar la concatenación de condiciones

if (!empty($filtro_tipo)) {
    $sql .= " AND tipo = '$filtro_tipo'";
}

if (!empty($filtro_titulo)) {
    $sql .= " AND titulo LIKE '%$filtro_titulo%'";
}

// Obtener todos los contenidos con paginación
$sql_total = $sql; // Guardar la consulta para contar el total sin LIMIT
$sql .= " ORDER BY id DESC LIMIT $indice_inicio, $resultados_por_pagina";

$result = $conn->query($sql);
$contenidos = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $contenidos[] = $row;
    }
}

// Obtener el número total de resultados (sin LIMIT)
$result_total = $conn->query($sql_total);
$total_resultados = $result_total->num_rows;
$total_paginas = ceil($total_resultados / $resultados_por_pagina);

// Función para obtener la etiqueta del tipo de contenido
function getTipoBadge($tipo) {
    switch ($tipo) {
        case 1:
            return '<span class="badge bg-primary">Noticia</span>';
        case 2:
            return '<span class="badge bg-success">Artículo</span>';
        case 3:
            return '<span class="badge bg-warning text-dark">Evento</span>';
        default:
            return '<span class="badge bg-secondary">Desconocido</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Contenidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Administración de Contenidos</h2>
        <a href="../logout.php" class="btn btn-danger float-end">Cerrar Sesión</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearContenidoModal">
            Crear Nuevo Contenido
        </button>

        <hr>

        <!-- Formulario de Filtro -->
        <form method="GET" action="contenidos.php" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="filtro_tipo" class="form-label">Filtrar por Tipo:</label>
                    <select class="form-select" id="filtro_tipo" name="filtro_tipo">
                        <option value="">Todos</option>
                        <option value="1" <?php if ($filtro_tipo == '1') echo 'selected'; ?>>Noticia</option>
                        <option value="2" <?php if ($filtro_tipo == '2') echo 'selected'; ?>>Artículo</option>
                        <option value="3" <?php if ($filtro_tipo == '3') echo 'selected'; ?>>Evento</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filtro_titulo" class="form-label">Filtrar por Título:</label>
                    <input type="text" class="form-control" id="filtro_titulo" name="filtro_titulo" value="<?php echo htmlspecialchars($filtro_titulo); ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary mt-4">Filtrar</button>
                    <a href="contenidos.php" class="btn btn-secondary mt-4">Limpiar Filtros</a>
                </div>
            </div>
        </form>

        <!-- Tabla de Contenidos -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Contenido</th>
                        <th>Tipo</th>
                        <th>Autor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contenidos as $contenido): ?>
                        <tr>
                            <td><?php echo $contenido['id']; ?></td>
                            <td><?php echo htmlspecialchars($contenido['titulo']); ?></td>
                            <td><?php echo substr(htmlspecialchars($contenido['contenido']), 0, 50); ?>...</td>
                            <td><?php echo getTipoBadge($contenido['tipo']); ?></td>
                            <td><?php echo $contenido['autor']; ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarContenidoModal<?php echo $contenido['id']; ?>">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarContenidoModal<?php echo $contenido['id']; ?>">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </td>
                        </tr>

                        <!-- Modal de Editar Contenido -->
                        <div class="modal fade" id="editarContenidoModal<?php echo $contenido['id']; ?>" tabindex="-1" aria-labelledby="editarContenidoModalLabel<?php echo $contenido['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarContenidoModalLabel<?php echo $contenido['id']; ?>">Editar Contenido</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="contenidos.php">
                                            <input type="hidden" name="id" value="<?php echo $contenido['id']; ?>">
                                            <div class="mb-3">
                                                <label for="titulo" class="form-label">Título</label>
                                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($contenido['titulo']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="contenido" class="form-label">Contenido</label>
                                                <textarea class="form-control" id="contenido" name="contenido" rows="3" required><?php echo htmlspecialchars($contenido['contenido']); ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tipo" class="form-label">Tipo</label>
                                                <select class="form-select" id="tipo" name="tipo" required>
                                                    <option value="1" <?php if ($contenido['tipo'] == 1) echo 'selected'; ?>>Noticia</option>
                                                    <option value="2" <?php if ($contenido['tipo'] == 2) echo 'selected'; ?>>Artículo</option>
                                                    <option value="3" <?php if ($contenido['tipo'] == 3) echo 'selected'; ?>>Evento</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="actualizar">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Eliminar Contenido -->
                        <div class="modal fade" id="eliminarContenidoModal<?php echo $contenido['id']; ?>" tabindex="-1" aria-labelledby="eliminarContenidoModalLabel<?php echo $contenido['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="eliminarContenidoModalLabel<?php echo $contenido['id']; ?>">Eliminar Contenido</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que quieres eliminar el contenido "<?php echo htmlspecialchars($contenido['titulo']); ?>"?</p>
                                        <form method="POST" action="contenidos.php">
                                            <input type="hidden" name="id" value="<?php echo $contenido['id']; ?>">
                                            <button type="submit" class="btn btn-danger" name="eliminar">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php if ($pagina <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>&filtro_tipo=<?php echo htmlspecialchars($filtro_tipo); ?>&filtro_titulo=<?php echo htmlspecialchars($filtro_titulo); ?>">Anterior</a>
                </li>
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?php if ($pagina == $i) echo 'active'; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>&filtro_tipo=<?php echo htmlspecialchars($filtro_tipo); ?>&filtro_titulo=<?php echo htmlspecialchars($filtro_titulo); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($pagina >= $total_paginas) echo 'disabled'; ?>">
                    <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>&filtro_tipo=<?php echo htmlspecialchars($filtro_tipo); ?>&filtro_titulo=<?php echo htmlspecialchars($filtro_titulo); ?>">Siguiente</a>
                </li>
            </ul>
        </nav>

        <!-- Modal de Crear Contenido -->
        <div class="modal fade" id="crearContenidoModal" tabindex="-1" aria-labelledby="crearContenidoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearContenidoModalLabel">Crear Nuevo Contenido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="contenidos.php">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="mb-3">
                                <label for="contenido" class="form-label">Contenido</label>
                                <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="1">Noticia</option>
                                    <option value="2">Artículo</option>
                                    <option value="3">Evento</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="crear">Crear Contenido</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    // Funciones de filtrado
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Puedes agregar aquí funciones JavaScript para mejorar el filtrado si es necesario.
        });
    </script>
    // Funciones de paginación
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Puedes agregar aquí funciones JavaScript para mejorar la paginación si es necesario.
        });
    </script>
</body>
</html>
