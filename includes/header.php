<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/auth_check.php';

$usuario_actual = obtenerUsuarioActual();
?>

<header>
    <!-- Izquierda -->
    <div class="logo">
        <i class="fas fa-book-open"></i>
        <a href="index.php"><span>Babelium</span></a>
    </div>

    <!-- Centro -->
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="niveles.php">Niveles</a></li>
            <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>
            <?php if ($usuario_actual && esAdmin()): ?>
                <li><a href="admin/dashboard.php">Admin</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Derecha -->
    <div class="auth-buttons">
        <?php if ($usuario_actual): ?>
            <!-- Usuario logueado -->
            <div class="user-menu">
                <button class="user-button" onclick="toggleUserMenu()">
                    <i class="fas fa-user"></i>
                    <span><?php echo htmlspecialchars($usuario_actual['nombre']); ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-info">
                        <strong><?php echo htmlspecialchars($usuario_actual['nombre'] . ' ' . $usuario_actual['apellidos']); ?></strong>
                        <small><?php echo ucfirst($usuario_actual['tipo']); ?></small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="perfil.php" class="dropdown-item">
                        <i class="fas fa-user"></i> Mi Perfil
                    </a>
                    <a href="progreso.php" class="dropdown-item">
                        <i class="fas fa-chart-line"></i> Mi Progreso
                    </a>
                    <a href="favoritos.php" class="dropdown-item">
                        <i class="fas fa-heart"></i> Favoritos
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="auth/logout.php" class="dropdown-item logout">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Usuario no logueado -->
            <a href="auth/login.php">Iniciar sesión</a>
            <a href="auth/register.php">Registrarse</a>
        <?php endif; ?>
    </div>
</header>

<script>
function toggleUserMenu() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('show');
}

// Cerrar dropdown al hacer click fuera
document.addEventListener('click', function(event) {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('userDropdown');
    
    if (userMenu && !userMenu.contains(event.target)) {
        dropdown.classList.remove('show');
    }
});
</script>