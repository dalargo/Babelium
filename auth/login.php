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

// Procesar formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Por favor, completa todos los campos.';
    } else {
        // Buscar usuario en la base de datos
        $stmt = $conexion->prepare("SELECT id, tipo, identificador, nombre, apellidos, email, password, activo FROM usuarios WHERE email = ? AND activo = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($usuario = $resultado->fetch_assoc()) {
            // Verificar contraseña
            if (password_verify($password, $usuario['password'])) {
                // Login exitoso
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_tipo'] = $usuario['tipo'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_apellidos'] = $usuario['apellidos'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_identificador'] = $usuario['identificador'];
                
                // Redirigir según tipo de usuario
                if ($usuario['tipo'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            } else {
                $error = 'Credenciales incorrectas.';
            }
        } else {
            $error = 'Credenciales incorrectas.';
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
    <title>Iniciar Sesión - Babelium</title>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <a href="../index.php">
                        <h1>Babelium</h1>
                    </a>
                </div>
                <h2>Iniciar Sesión</h2>
                <p>Accede a tu cuenta para continuar aprendiendo</p>
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
                </div>
            <?php endif; ?>

            <form class="auth-form" method="POST">
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
                            placeholder="Tu contraseña"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        Recordarme
                    </label>
                    <a href="forgot-password.php" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="auth-button">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </button>
            </form>

            <div class="auth-footer">
                <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
            </div>

            <div class="auth-demo">
                <h4>Cuentas de demostración:</h4>
                <div class="demo-accounts">
                    <button class="demo-button" onclick="fillDemo('admin@babelium.edu', 'admin123')">
                        <i class="fas fa-user-shield"></i>
                        Administrador
                    </button>
                    <button class="demo-button" onclick="fillDemo('profesor@babelium.edu', 'profesor123')">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Profesor
                    </button>
                    <button class="demo-button" onclick="fillDemo('alumno@babelium.edu', 'alumno123')">
                        <i class="fas fa-user-graduate"></i>
                        Alumno
                    </button>
                </div>
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

        function fillDemo(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }

        // Auto-focus en el primer campo
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });
    </script>
</body>
</html>