<?php
session_start();
require_once '../db/connection.php';

$error = '';
$success = '';

// Si ya está logueado, redirigir
if (isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
}

// Procesar formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo'] ?? 'alumno';
    $identificador = trim($_POST['identificador'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validaciones
    if (empty($identificador) || empty($nombre) || empty($apellidos) || empty($email) || empty($password)) {
        $error = 'Por favor, completa todos los campos obligatorios.';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } else {
        // Verificar si el email ya existe
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $error = 'Ya existe una cuenta con este correo electrónico.';
        } else {
            // Verificar si el identificador ya existe para este tipo
            $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE tipo = ? AND identificador = ?");
            $stmt->bind_param("ss", $tipo, $identificador);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows > 0) {
                $tipo_texto = $tipo === 'alumno' ? 'NIA' : 'DNI';
                $error = "Ya existe una cuenta con este $tipo_texto.";
            } else {
                // Crear nuevo usuario
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $conexion->prepare("INSERT INTO usuarios (tipo, identificador, nombre, apellidos, email, password, fecha_registro, activo) VALUES (?, ?, ?, ?, ?, ?, NOW(), 1)");
                $stmt->bind_param("ssssss", $tipo, $identificador, $nombre, $apellidos, $email, $password_hash);
                
                if ($stmt->execute()) {
                    $success = 'Cuenta creada exitosamente. Ya puedes iniciar sesión.';
                } else {
                    $error = 'Error al crear la cuenta. Inténtalo de nuevo.';
                }
            }
        }
        $stmt->close();
    }
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
    <link rel="stylesheet" href="../css/auth.css">
    <title>Registrarse - Babelium</title>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card register-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <a href="../index.php">
                        <h1>Babelium</h1>
                    </a>
                </div>
                <h2>Crear Cuenta</h2>
                <p>Únete a nuestra comunidad educativa</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success); ?>
                    <a href="login.php" class="success-link">Iniciar sesión ahora</a>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST">
                <div class="form-group">
                    <label for="tipo">
                        <i class="fas fa-user-tag"></i>
                        Tipo de usuario
                    </label>
                    <select id="tipo" name="tipo" required onchange="updateIdentifierLabel()">
                        <option value="alumno" <?php echo ($_POST['tipo'] ?? 'alumno') === 'alumno' ? 'selected' : ''; ?>>Alumno</option>
                        <option value="profesor" <?php echo ($_POST['tipo'] ?? '') === 'profesor' ? 'selected' : ''; ?>>Profesor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="identificador" id="identificador-label">
                        <i class="fas fa-id-card"></i>
                        NIA (Número de Identificación del Alumno)
                    </label>
                    <input 
                        type="text" 
                        id="identificador" 
                        name="identificador" 
                        value="<?php echo htmlspecialchars($_POST['identificador'] ?? ''); ?>"
                        required 
                        placeholder="Introduce tu NIA"
                    >
                    <small class="form-help">Para alumnos: NIA. Para profesores: DNI</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre">
                            <i class="fas fa-user"></i>
                            Nombre
                        </label>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>"
                            required 
                            placeholder="Tu nombre"
                        >
                    </div>

                    <div class="form-group">
                        <label for="apellidos">
                            <i class="fas fa-user"></i>
                            Apellidos
                        </label>
                        <input 
                            type="text" 
                            id="apellidos" 
                            name="apellidos" 
                            value="<?php echo htmlspecialchars($_POST['apellidos'] ?? ''); ?>"
                            required 
                            placeholder="Tus apellidos"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Correo electrónico
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        required 
                        placeholder="tu@email.com"
                    >
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Contraseña
                        </label>
                        <div class="password-input">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                placeholder="Mínimo 6 caracteres"
                                minlength="6"
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">
                            <i class="fas fa-lock"></i>
                            Confirmar contraseña
                        </label>
                        <div class="password-input">
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password" 
                                required 
                                placeholder="Repite la contraseña"
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword('confirm_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" required>
                        <span class="checkmark"></span>
                        Acepto los<a href="#" target="_blank"> términos y condiciones</a> y la <a href="#" target="_blank">política de privacidad</a>
                    </label>
                </div>

                <button type="submit" class="auth-button">
                    <i class="fas fa-user-plus"></i>
                    Crear Cuenta
                </button>
            </form>

            <div class="auth-footer">
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        function updateIdentifierLabel() {
            const tipo = document.getElementById('tipo').value;
            const label = document.getElementById('identificador-label');
            const input = document.getElementById('identificador');
            
            if (tipo === 'alumno') {
                label.innerHTML = '<i class="fas fa-id-card"></i> NIA (Número de Identificación del Alumno)';
                input.placeholder = 'Introduce tu NIA';
            } else {
                label.innerHTML = '<i class="fas fa-id-card"></i> DNI';
                input.placeholder = 'Introduce tu DNI';
            }
        }

        // Validación de contraseñas en tiempo real
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });

        // Auto-focus en el primer campo
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tipo').focus();
        });
    </script>
</body>
</html>