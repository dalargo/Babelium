-- Script final para crear usuarios de demostración
-- Solo ejecutar si necesitas usuarios adicionales

-- Verificar usuarios existentes
SELECT 'Usuarios existentes:' as info;
SELECT id, tipo, nombre, apellidos, email FROM usuarios WHERE activo = 1 ORDER BY tipo;

-- Crear usuarios demo adicionales si no existen
INSERT IGNORE INTO usuarios (tipo, identificador, nombre, apellidos, email, password, fecha_registro, activo) VALUES
('admin', '00000001A', 'Admin', 'Demo', 'admin@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), TRUE),
('profesor', '11111111B', 'Profesor', 'Demo', 'profesor@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), TRUE),
('alumno', 'ALU12345', 'Alumno', 'Demo', 'alumno@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), TRUE);

-- Mostrar todos los usuarios finales
SELECT 'Usuarios finales:' as info;
SELECT 
    id, 
    tipo, 
    nombre, 
    apellidos, 
    email,
    CASE 
        WHEN email LIKE '%babelium.edu' THEN CONCAT(tipo, '123')
        WHEN email LIKE '%demo.com' THEN 'demo123'
        ELSE 'password123'
    END as password_sugerida
FROM usuarios 
WHERE activo = 1 
ORDER BY tipo, email;
