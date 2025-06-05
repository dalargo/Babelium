<?php
// Incluir verificación de autenticación
require_once('../includes/auth_check.php');
// Incluir conexión a la base de datos
require_once('../includes/db_connect.php');

// Manejar envíos de formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear nuevo nivel
    if (isset($_POST['create_level'])) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $icono = $_POST['icono'];
        $orden = $_POST['orden'];

        $sql = "INSERT INTO niveles_educativos (nombre, descripcion, icono, orden, activo) VALUES (?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $descripcion, $icono, $orden);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Nivel educativo creado con éxito.";
        } else {
            $_SESSION['error_message'] = "Error al crear el nivel educativo: " . $stmt->error;
        }
        $stmt->close();
        header("Location: niveles.php");
        exit();
    }

    // Actualizar nivel existente
    if (isset($_POST['update_level'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $icono = $_POST['icono'];
        $orden = $_POST['orden'];

        $sql = "UPDATE niveles_educativos SET nombre = ?, descripcion = ?, icono = ?, orden = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $nombre, $descripcion, $icono, $orden, $id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Nivel educativo actualizado con éxito.";
        } else {
            $_SESSION['error_message'] = "Error al actualizar el nivel educativo: " . $stmt->error;
        }
        $stmt->close();
        header("Location: niveles.php");
        exit();
    }

    // Cambiar estado del nivel
    if (isset($_POST['toggle_status'])) {
        $id = $_POST['id'];
        $activo = $_POST['activo'];

        $nuevo_estado = ($activo == 1) ? 0 : 1;

        $sql = "UPDATE niveles_educativos SET activo = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $nuevo_estado, $id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Estado del nivel educativo actualizado con éxito.";
        } else {
            $_SESSION['error_message'] = "Error al actualizar el estado del nivel educativo: " . $stmt->error;
        }
        $stmt->close();
        header("Location: niveles.php");
        exit();
    }

    // Eliminar nivel
    if (isset($_POST['delete_level'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM niveles_educativos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Nivel educativo eliminado con éxito.";
        } else {
            $_SESSION['error_message'] = "Error al eliminar el nivel educativo: " . $stmt->error;
        }
        $stmt->close();
        header("Location: niveles.php");
        exit();
    }
}

// Obtener todos los niveles educativos
$sql = "SELECT * FROM niveles_educativos ORDER BY orden ASC";
$result = $conn->query($sql);

// Función para obtener el icono del nivel
function obtenerIconoNivel($icono) {
    return '<i class="' . htmlspecialchars($icono) . '"></i>';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Niveles Educativos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include_once('sidebar.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Administrar Niveles Educativos</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addLevelModal">
                            <i class="fas fa-plus"></i> Agregar Nivel
                        </button>
                    </div>
                </div>

                <?php
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                    unset($_SESSION['success_message']);
                }

                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                    unset($_SESSION['error_message']);
                }
                ?>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Icono</th>
                                <th>Orden</th>
                                <th>Activo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["descripcion"]) . "</td>";
                                    echo "<td>" . obtenerIconoNivel($row["icono"]) . "</td>";
                                    echo "<td>" . $row["orden"] . "</td>";
                                    echo "<td>" . ($row["activo"] == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>') . "</td>";
                                    echo "<td>
                                            <button type='button' class='btn btn-sm btn-primary' data-toggle='modal' data-target='#editLevelModal' data-id='" . $row["id"] . "' data-nombre='" . htmlspecialchars($row["nombre"]) . "' data-descripcion='" . htmlspecialchars($row["descripcion"]) . "' data-icono='" . htmlspecialchars($row["icono"]) . "' data-orden='" . $row["orden"] . "'>
                                                <i class='fas fa-edit'></i> Editar
                                            </button>
                                            <form method='post' style='display:inline;'>
                                                <input type='hidden' name='toggle_status' value='1'>
                                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                                <input type='hidden' name='activo' value='" . $row["activo"] . "'>
                                                <button type='submit' class='btn btn-sm " . ($row["activo"] == 1 ? 'btn-warning' : 'btn-success') . "'>
                                                    <i class='fas fa-power-off'></i> " . ($row["activo"] == 1 ? 'Desactivar' : 'Activar') . "
                                                </button>
                                            </form>
                                            <form method='post' style='display:inline;'>
                                                <input type='hidden' name='delete_level' value='1'>
                                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                                <button type='button' class='btn btn-sm btn-danger' onclick='confirmDelete(" . $row["id"] . ")'>
                                                    <i class='fas fa-trash-alt'></i> Eliminar
                                                </button>
                                            </form>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No se encontraron niveles educativos.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal de Agregar Nivel -->
    <div class="modal fade" id="addLevelModal" tabindex="-1" role="dialog" aria-labelledby="addLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLevelModalLabel">Agregar Nivel Educativo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="hidden" name="create_level" value="1">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icono">Icono (Font Awesome Class)</label>
                            <input type="text" class="form-control" id="icono" name="icono">
                        </div>
                        <div class="form-group">
                            <label for="orden">Orden</label>
                            <input type="number" class="form-control" id="orden" name="orden" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Editar Nivel -->
    <div class="modal fade" id="editLevelModal" tabindex="-1" role="dialog" aria-labelledby="editLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLevelModalLabel">Editar Nivel Educativo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="hidden" name="update_level" value="1">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="icono">Icono (Font Awesome Class)</label>
                            <input type="text" class="form-control" id="edit_icono" name="icono">
                        </div>
                        <div class="form-group">
                            <label for="orden">Orden</label>
                            <input type="number" class="form-control" id="edit_orden" name="orden" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Funciones de ventanas modales
        $('#editLevelModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var id = button.data('id')
            var nombre = button.data('nombre')
            var descripcion = button.data('descripcion')
            var icono = button.data('icono')
            var orden = button.data('orden')

            var modal = $(this)
            modal.find('#edit_id').val(id)
            modal.find('#edit_nombre').val(nombre)
            modal.find('#edit_descripcion').val(descripcion)
            modal.find('#edit_icono').val(icono)
            modal.find('#edit_orden').val(orden)
        })

        function confirmDelete(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este nivel educativo?")) {
                // Create a form dynamically
                var form = document.createElement("form");
                form.method = "post";
                form.style.display = "none"; // Hide the form

                // Add the delete_level input
                var deleteInput = document.createElement("input");
                deleteInput.type = "hidden";
                deleteInput.name = "delete_level";
                deleteInput.value = "1";
                form.appendChild(deleteInput);

                // Add the id input
                var idInput = document.createElement("input");
                idInput.type = "hidden";
                idInput.name = "id";
                idInput.value = id;
                form.appendChild(idInput);

                // Append the form to the document body and submit it
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
