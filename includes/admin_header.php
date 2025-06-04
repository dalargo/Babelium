<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/auth_check.php';

$usuario_actual = obtenerUsuarioActual();
?>

<header class="admin-header-top">
    <!-- Izquierda -->
    <div class="logo">
        <i class="fas fa-book-open"></i>
        <a href="../index.php"><span>Babelium</span></a>
        <span class="admin-badge">Admin</span>
    </div>

    <!-- Centro -->
    <nav class="admin-nav">
        <ul>
            <li><a href="../index.php"><i class="fas fa-home"></i> Sitio Web</a></li>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        </ul>
    </nav>

    <!-- Derecha -->
    <div class="auth-buttons">
        <div class="user-menu">
            <button class="user-button" onclick="toggleUserMenu()">
                <i class="fas fa-user-shield"></i>
                <span><?php echo htmlspecialchars($usuario_actual['nombre']); ?></span>
                <i class="fas fa-chevron-down"></i>
            </button>
            
            <div class="user-dropdown" id="userDropdown">
                <div class="user-info">
                    <strong><?php echo htmlspecialchars($usuario_actual['nombre'] . ' ' . $usuario_actual['apellidos']); ?></strong>
                    <small>Administrador</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="../perfil.php" class="dropdown-item">
                    <i class="fas fa-user"></i> Mi Perfil
                </a>
                <a href="configuracion.php" class="dropdown-item">
                    <i class="fas fa-cog"></i> Configuración
                </a>
                <div class="dropdown-divider"></div>
                <a href="../auth/logout.php" class="dropdown-item logout">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </a>
            </div>
        </div>
    </div>
</header>

<script>
function toggleUserMenu() {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('userDropdown');
    
    userMenu.classList.toggle('active');
    dropdown.classList.toggle('show');
}

// Cerrar dropdown al hacer click fuera
document.addEventListener('click', function(event) {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('userDropdown');
    
    if (userMenu && !userMenu.contains(event.target)) {
        userMenu.classList.remove('active');
        dropdown.classList.remove('show');
    }
});

// Cerrar dropdown al presionar Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const userMenu = document.querySelector('.user-menu');
        const dropdown = document.getElementById('userDropdown');
        
        if (userMenu && dropdown) {
            userMenu.classList.remove('active');
            dropdown.classList.remove('show');
        }
    }
});
</script>