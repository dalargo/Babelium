-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS babelium_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE babelium_db;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('alumno', 'profesor', 'admin') NOT NULL,
    identificador VARCHAR(20) NOT NULL UNIQUE COMMENT 'NIA para alumnos, DNI para profesores y admins',
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(200) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    UNIQUE KEY (tipo, identificador)
) ENGINE=InnoDB;

-- Tabla de niveles educativos
CREATE TABLE IF NOT EXISTS niveles_educativos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    orden INT NOT NULL,
    activo BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB;

-- Tabla de cursos
CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nivel_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    orden INT NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    UNIQUE KEY (nivel_id, nombre),
    FOREIGN KEY (nivel_id) REFERENCES niveles_educativos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de ramas (científico, humanidades, etc.)
CREATE TABLE IF NOT EXISTS ramas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nivel_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    UNIQUE KEY (nivel_id, nombre),
    FOREIGN KEY (nivel_id) REFERENCES niveles_educativos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de modalidades de curso (combinación de curso y rama)
CREATE TABLE IF NOT EXISTS modalidades_curso (
    id INT AUTO_INCREMENT PRIMARY KEY,
    curso_id INT NOT NULL,
    rama_id INT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE,
    FOREIGN KEY (rama_id) REFERENCES ramas(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla de materias/asignaturas
CREATE TABLE IF NOT EXISTS materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modalidad_curso_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    creditos INT DEFAULT 0,
    obligatoria BOOLEAN DEFAULT TRUE,
    activo BOOLEAN DEFAULT TRUE,
    UNIQUE KEY (modalidad_curso_id, nombre),
    FOREIGN KEY (modalidad_curso_id) REFERENCES modalidades_curso(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de temas
CREATE TABLE IF NOT EXISTS temas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    materia_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    orden INT NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de contenidos
CREATE TABLE IF NOT EXISTS contenidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tema_id INT NOT NULL,
    tipo ENUM('texto', 'imagen', 'video', 'archivo', 'enlace') NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT,
    url VARCHAR(255) DEFAULT NULL,
    orden INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    creador_id INT NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (tema_id) REFERENCES temas(id) ON DELETE CASCADE,
    FOREIGN KEY (creador_id) REFERENCES usuarios(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla de matrículas
CREATE TABLE IF NOT EXISTS matriculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    modalidad_curso_id INT NOT NULL,
    fecha_matricula DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    UNIQUE KEY (usuario_id, modalidad_curso_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (modalidad_curso_id) REFERENCES modalidades_curso(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de asignaciones de profesores a materias
CREATE TABLE IF NOT EXISTS asignaciones_profesor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profesor_id INT NOT NULL,
    materia_id INT NOT NULL,
    fecha_asignacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    UNIQUE KEY (profesor_id, materia_id),
    FOREIGN KEY (profesor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de progreso de alumnos
CREATE TABLE IF NOT EXISTS progreso_alumno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    contenido_id INT NOT NULL,
    completado BOOLEAN DEFAULT FALSE,
    puntuacion INT DEFAULT 0,
    fecha_ultimo_acceso DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (usuario_id, contenido_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (contenido_id) REFERENCES contenidos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de comentarios
CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    contenido_id INT NOT NULL,
    comentario TEXT NOT NULL,
    fecha_comentario DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (contenido_id) REFERENCES contenidos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de campos dinámicos
CREATE TABLE IF NOT EXISTS campos_dinamicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    tipo ENUM('texto', 'imagen', 'archivo') NOT NULL,
    entidad ENUM('materia', 'tema', 'contenido') NOT NULL,
    entidad_id INT NOT NULL,
    activo BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB;

-- Tabla de valores de campos dinámicos
CREATE TABLE IF NOT EXISTS valores_campos_dinamicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    campo_id INT NOT NULL,
    valor TEXT,
    url VARCHAR(255) DEFAULT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    creador_id INT NOT NULL,
    FOREIGN KEY (campo_id) REFERENCES campos_dinamicos(id) ON DELETE CASCADE,
    FOREIGN KEY (creador_id) REFERENCES usuarios(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Índices adicionales para mejorar el rendimiento
CREATE INDEX idx_usuarios_tipo ON usuarios(tipo);
CREATE INDEX idx_contenidos_tipo ON contenidos(tipo);
CREATE INDEX idx_temas_materia ON temas(materia_id);
CREATE INDEX idx_materias_modalidad ON materias(modalidad_curso_id);
CREATE INDEX idx_modalidades_curso ON modalidades_curso(curso_id, rama_id);
