-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 17:30:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `babelium_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_profesor`
--

CREATE TABLE `asignaciones_profesor` (
  `id` int(11) NOT NULL,
  `profesor_id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `fecha_asignacion` datetime DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `campos_dinamicos`
--

CREATE TABLE `campos_dinamicos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` enum('texto','imagen','archivo') NOT NULL,
  `entidad` enum('materia','tema','contenido') NOT NULL,
  `entidad_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `contenido_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_comentario` datetime DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos`
--

CREATE TABLE `contenidos` (
  `id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  `tipo` enum('texto','imagen','video','archivo','enlace') NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `creador_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `duracion_estimada` int(11) DEFAULT 15 COMMENT 'Duración estimada en minutos',
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp() COMMENT 'Fecha de última actualización'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contenidos`
--

INSERT INTO `contenidos` (`id`, `tema_id`, `tipo`, `titulo`, `contenido`, `url`, `orden`, `fecha_creacion`, `creador_id`, `activo`, `duracion_estimada`, `fecha_actualizacion`) VALUES
(4, 1, 'texto', 'Introducción a las vocales', 'Las vocales son las letras a, e, i, o, u. Son muy importantes porque aparecen en todas las palabras.', NULL, 1, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(5, 1, 'texto', 'La vocal A', 'La letra A es la primera vocal. Suena como \"aaa\". Ejemplos: árbol, agua, amor.', NULL, 2, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(6, 1, 'texto', 'Ejercicios con vocales', 'Practica escribiendo las vocales y encuentra palabras que empiecen con cada una.', NULL, 3, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(7, 5, 'texto', 'Conociendo los números', 'Los números nos ayudan a contar. Vamos a aprender del 1 al 10.', NULL, 1, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(8, 5, 'texto', 'Contar objetos', 'Practica contando objetos: 1 manzana, 2 pelotas, 3 lápices...', NULL, 2, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(9, 38, 'texto', 'Definición de números naturales', 'Los números naturales son los números que usamos para contar: 1, 2, 3, 4, 5...', NULL, 1, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(10, 38, 'texto', 'Propiedades de los números naturales', 'Los números naturales tienen propiedades importantes como la propiedad conmutativa y asociativa.', NULL, 2, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(11, 38, 'texto', 'Operaciones básicas', 'Con los números naturales podemos hacer sumas, restas, multiplicaciones y divisiones.', NULL, 3, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(12, 43, 'texto', 'Elementos de la comunicación', 'La comunicación tiene varios elementos: emisor, receptor, mensaje, canal, código y contexto.', NULL, 1, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(13, 43, 'texto', 'Tipos de comunicación', 'Existen diferentes tipos de comunicación: verbal, no verbal, escrita, oral...', NULL, 2, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(14, 51, 'texto', 'Basic Greetings', 'Learn basic greetings: Hello, Hi, Good morning, Good afternoon, Good evening.', NULL, 1, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(15, 51, 'texto', 'Introducing Yourself', 'How to introduce yourself: My name is..., I am..., Nice to meet you.', NULL, 2, '2025-06-04 07:12:06', 1, 1, 15, '2025-06-04 12:31:25'),
(16, 64, 'texto', 'Conjuntos numéricos', 'Repaso de los conjuntos numéricos: naturales, enteros, racionales e irracionales.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(17, 64, 'texto', 'Propiedades de los números reales', 'Propiedades algebraicas y de orden de los números reales.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(18, 65, 'texto', 'Polinomios', 'Operaciones con polinomios y factorización.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(19, 65, 'texto', 'Ecuaciones', 'Resolución de ecuaciones de primer y segundo grado.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(20, 67, 'texto', 'Ley de conservación de la masa', 'En una reacción química, la masa de los reactivos es igual a la masa de los productos.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(21, 67, 'texto', 'Ley de las proporciones definidas', 'En un compuesto químico puro, los elementos que lo forman están siempre en la misma proporción en masa.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(22, 68, 'texto', 'Movimiento rectilíneo uniforme', 'Estudio del movimiento con velocidad constante.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(23, 68, 'texto', 'Movimiento rectilíneo uniformemente acelerado', 'Estudio del movimiento con aceleración constante.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(24, 73, 'texto', 'Características políticas', 'Monarquía absoluta como forma de gobierno predominante.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(25, 73, 'texto', 'Características económicas', 'Economía agraria y sistema gremial.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(26, 74, 'texto', 'Primera Revolución Industrial', 'Surgimiento de la industria textil y la máquina de vapor.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(27, 74, 'texto', 'Segunda Revolución Industrial', 'Desarrollo de la electricidad, el petróleo y la química.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(28, 82, 'texto', 'Componentes básicos', 'Identificación de los componentes básicos de un ordenador: placa base, procesador, memoria, etc.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(29, 82, 'texto', 'Ensamblaje de un ordenador', 'Pasos para ensamblar correctamente un ordenador.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(30, 83, 'texto', 'Instalación de Windows', 'Proceso de instalación de Windows paso a paso.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(31, 83, 'texto', 'Instalación de Linux', 'Proceso de instalación de una distribución Linux.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(32, 85, 'texto', 'Leyes de Newton', 'Enunciado y aplicaciones de las tres leyes de Newton.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(33, 85, 'texto', 'Trabajo y energía', 'Conceptos de trabajo, energía cinética y potencial.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(34, 86, 'texto', 'Primer principio de la termodinámica', 'La energía no se crea ni se destruye, solo se transforma.', NULL, 1, '2025-06-04 07:12:16', 1, 1, 15, '2025-06-04 12:31:25'),
(35, 86, 'texto', 'Segundo principio de la termodinámica', 'La entropía del universo tiende a aumentar.', NULL, 2, '2025-06-04 07:12:16', 1, 1, 19, '2025-06-04 12:27:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nivel_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nivel_id`, `nombre`, `descripcion`, `orden`, `activo`) VALUES
(1, 1, 'Primero de Primaria', 'Primer curso de Educación Primaria para niños de 6-7 años.', 1, 1),
(2, 1, 'Segundo de Primaria', 'Segundo curso de Educación Primaria para niños de 7-8 años.', 2, 1),
(3, 1, 'Tercero de Primaria', 'Tercer curso de Educación Primaria para niños de 8-9 años.', 3, 1),
(4, 1, 'Cuarto de Primaria', 'Cuarto curso de Educación Primaria para niños de 9-10 años.', 4, 1),
(5, 1, 'Quinto de Primaria', 'Quinto curso de Educación Primaria para niños de 10-11 años.', 5, 1),
(6, 1, 'Sexto de Primaria', 'Sexto curso de Educación Primaria para niños de 11-12 años.', 6, 1),
(7, 2, 'Primero de ESO', 'Primer curso de Educación Secundaria Obligatoria para estudiantes de 12-13 años.', 1, 1),
(8, 2, 'Segundo de ESO', 'Segundo curso de Educación Secundaria Obligatoria para estudiantes de 13-14 años.', 2, 1),
(9, 2, 'Tercero de ESO', 'Tercer curso de Educación Secundaria Obligatoria para estudiantes de 14-15 años.', 3, 1),
(10, 2, 'Cuarto de ESO', 'Cuarto curso de Educación Secundaria Obligatoria para estudiantes de 15-16 años.', 4, 1),
(11, 3, 'Primero de Bachillerato', 'Primer curso de Bachillerato para estudiantes de 16-17 años.', 1, 1),
(12, 3, 'Segundo de Bachillerato', 'Segundo curso de Bachillerato para estudiantes de 17-18 años.', 2, 1),
(13, 4, 'Primero de FP Básica', 'Primer curso de Formación Profesional Básica.', 1, 1),
(14, 4, 'Segundo de FP Básica', 'Segundo curso de Formación Profesional Básica.', 2, 1),
(15, 5, 'Primero de FP Grado Medio', 'Primer curso de Formación Profesional de Grado Medio.', 1, 1),
(16, 5, 'Segundo de FP Grado Medio', 'Segundo curso de Formación Profesional de Grado Medio.', 2, 1),
(17, 6, 'Primero de FP Grado Superior', 'Primer curso de Formación Profesional de Grado Superior.', 1, 1),
(18, 6, 'Segundo de FP Grado Superior', 'Segundo curso de Formación Profesional de Grado Superior.', 2, 1),
(19, 7, 'Primer curso', 'Primer curso de Grado Universitario.', 1, 1),
(20, 7, 'Segundo curso', 'Segundo curso de Grado Universitario.', 2, 1),
(21, 7, 'Tercer curso', 'Tercer curso de Grado Universitario.', 3, 1),
(22, 7, 'Cuarto curso', 'Cuarto curso de Grado Universitario.', 4, 1),
(23, 7, 'Quinto curso', 'Quinto curso de Grado Universitario (para grados de 5 años).', 5, 1),
(24, 7, 'Sexto curso', 'Sexto curso de Grado Universitario (para grados de 6 años como Medicina).', 6, 1),
(25, 1, '1º Primaria', 'Primer curso de Educación Primaria', 1, 1),
(26, 1, '2º Primaria', 'Segundo curso de Educación Primaria', 2, 1),
(27, 1, '3º Primaria', 'Tercer curso de Educación Primaria', 3, 1),
(28, 1, '4º Primaria', 'Cuarto curso de Educación Primaria', 4, 1),
(29, 1, '5º Primaria', 'Quinto curso de Educación Primaria', 5, 1),
(30, 1, '6º Primaria', 'Sexto curso de Educación Primaria', 6, 1),
(31, 2, '1º ESO', 'Primer curso de Educación Secundaria Obligatoria', 1, 1),
(32, 2, '2º ESO', 'Segundo curso de Educación Secundaria Obligatoria', 2, 1),
(33, 2, '3º ESO', 'Tercer curso de Educación Secundaria Obligatoria', 3, 1),
(34, 2, '4º ESO', 'Cuarto curso de Educación Secundaria Obligatoria', 4, 1),
(35, 3, '1º Bachillerato', 'Primer curso de Bachillerato', 1, 1),
(36, 3, '2º Bachillerato', 'Segundo curso de Bachillerato', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `modalidad_curso_id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `creditos` int(11) DEFAULT 0,
  `obligatoria` tinyint(1) DEFAULT 1,
  `activo` tinyint(1) DEFAULT 1,
  `nivel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `modalidad_curso_id`, `nombre`, `descripcion`, `creditos`, `obligatoria`, `activo`, `nivel_id`) VALUES
(1, 41, 'Título Profesional Básico en Informática de Oficina', 'Formación básica en informática de oficina.', 0, 1, 1, NULL),
(2, 41, 'Título Profesional Básico en Informática y Comunicaciones', 'Formación básica en informática y comunicaciones.', 0, 1, 1, NULL),
(3, 30, 'Título Profesional Básico en Servicios Administrativos', 'Formación básica en servicios administrativos.', 0, 1, 1, NULL),
(4, 35, 'Título Profesional Básico en Electricidad y Electrónica', 'Formación básica en electricidad y electrónica.', 0, 1, 1, NULL),
(5, 38, 'Título Profesional Básico en Cocina y Restauración', 'Formación básica en cocina y restauración.', 0, 1, 1, NULL),
(6, 47, 'Título Profesional Básico en Mantenimiento de Vehículos', 'Formación básica en mantenimiento de vehículos.', 0, 1, 1, NULL),
(7, 107, 'Técnico en Sistemas Microinformáticos y Redes', 'Formación en sistemas microinformáticos y redes.', 0, 1, 1, NULL),
(8, 93, 'Técnico en Gestión Administrativa', 'Formación en gestión administrativa.', 0, 1, 1, NULL),
(9, 98, 'Técnico en Instalaciones Eléctricas y Automáticas', 'Formación en instalaciones eléctricas y automáticas.', 0, 1, 1, NULL),
(10, 112, 'Técnico en Cuidados Auxiliares de Enfermería', 'Formación en cuidados auxiliares de enfermería.', 0, 1, 1, NULL),
(11, 112, 'Técnico en Farmacia y Parafarmacia', 'Formación en farmacia y parafarmacia.', 0, 1, 1, NULL),
(12, 169, 'Técnico Superior en Desarrollo de Aplicaciones Web', 'Formación en desarrollo de aplicaciones web.', 0, 1, 1, NULL),
(13, 169, 'Técnico Superior en Desarrollo de Aplicaciones Multiplataforma', 'Formación en desarrollo de aplicaciones multiplataforma.', 0, 1, 1, NULL),
(14, 169, 'Técnico Superior en Administración de Sistemas Informáticos en Red', 'Formación en administración de sistemas informáticos en red.', 0, 1, 1, NULL),
(15, 156, 'Técnico Superior en Administración y Finanzas', 'Formación en administración y finanzas.', 0, 1, 1, NULL),
(16, 174, 'Técnico Superior en Laboratorio Clínico y Biomédico', 'Formación en laboratorio clínico y biomédico.', 0, 1, 1, NULL),
(17, 174, 'Técnico Superior en Imagen para el Diagnóstico y Medicina Nuclear', 'Formación en imagen para el diagnóstico y medicina nuclear.', 0, 1, 1, NULL),
(18, 219, 'Grado en Filología Hispánica', 'Estudios de lengua y literatura española.', 240, 1, 1, NULL),
(19, 219, 'Grado en Historia', 'Estudios de historia universal y de España.', 240, 1, 1, NULL),
(20, 219, 'Grado en Filosofía', 'Estudios de filosofía y pensamiento crítico.', 240, 1, 1, NULL),
(21, 219, 'Grado en Bellas Artes', 'Estudios de expresión artística y creación.', 240, 1, 1, NULL),
(22, 225, 'Grado en Física', 'Estudios de física teórica y aplicada.', 240, 1, 1, NULL),
(23, 225, 'Grado en Química', 'Estudios de química orgánica e inorgánica.', 240, 1, 1, NULL),
(24, 225, 'Grado en Biología', 'Estudios de biología celular y molecular.', 240, 1, 1, NULL),
(25, 225, 'Grado en Matemáticas', 'Estudios de matemáticas puras y aplicadas.', 240, 1, 1, NULL),
(26, 231, 'Grado en Medicina', 'Estudios de medicina general y especialidades médicas.', 360, 1, 1, NULL),
(27, 231, 'Grado en Enfermería', 'Estudios de cuidados de enfermería y salud.', 240, 1, 1, NULL),
(28, 231, 'Grado en Farmacia', 'Estudios de farmacología y farmacoterapia.', 300, 1, 1, NULL),
(29, 231, 'Grado en Psicología', 'Estudios de psicología clínica y social.', 240, 1, 1, NULL),
(30, 237, 'Grado en Derecho', 'Estudios de derecho civil, penal y administrativo.', 240, 1, 1, NULL),
(31, 237, 'Grado en Administración y Dirección de Empresas', 'Estudios de gestión y administración empresarial.', 240, 1, 1, NULL),
(32, 237, 'Grado en Economía', 'Estudios de economía teórica y aplicada.', 240, 1, 1, NULL),
(33, 237, 'Grado en Educación Primaria', 'Estudios de pedagogía y didáctica para educación primaria.', 240, 1, 1, NULL),
(34, 243, 'Grado en Ingeniería Informática', 'Estudios de programación, sistemas y redes.', 240, 1, 1, NULL),
(35, 243, 'Grado en Arquitectura', 'Estudios de diseño arquitectónico y urbanismo.', 300, 1, 1, NULL),
(36, 243, 'Grado en Ingeniería Industrial', 'Estudios de procesos industriales y producción.', 240, 1, 1, NULL),
(37, 243, 'Grado en Ingeniería de Telecomunicaciones', 'Estudios de sistemas de comunicación y redes.', 240, 1, 1, NULL),
(38, 1, 'Lengua Castellana y Literatura', 'Aprendizaje de la lectura, escritura y expresión oral.', 0, 1, 1, NULL),
(39, 1, 'Matemáticas', 'Aprendizaje de números, operaciones básicas y geometría.', 0, 1, 1, NULL),
(40, 1, 'Ciencias de la Naturaleza', 'Conocimiento del entorno natural y los seres vivos.', 0, 1, 1, NULL),
(41, 1, 'Ciencias Sociales', 'Conocimiento del entorno social, cultural y geográfico.', 0, 1, 1, NULL),
(42, 1, 'Educación Artística', 'Expresión plástica y musical.', 0, 1, 1, NULL),
(43, 1, 'Educación Física', 'Desarrollo de habilidades motrices y deportivas.', 0, 1, 1, NULL),
(44, 1, 'Primera Lengua Extranjera (Inglés)', 'Introducción al idioma inglés.', 0, 1, 1, NULL),
(45, 2, 'Lengua Castellana y Literatura', 'Consolidación de la lectura, escritura y expresión oral.', 0, 1, 1, NULL),
(46, 2, 'Matemáticas', 'Ampliación de números, operaciones y geometría.', 0, 1, 1, NULL),
(47, 2, 'Ciencias de la Naturaleza', 'Profundización en el conocimiento del entorno natural.', 0, 1, 1, NULL),
(48, 2, 'Ciencias Sociales', 'Profundización en el conocimiento del entorno social.', 0, 1, 1, NULL),
(49, 2, 'Educación Artística', 'Desarrollo de la expresión plástica y musical.', 0, 1, 1, NULL),
(50, 2, 'Educación Física', 'Desarrollo de habilidades motrices y deportivas.', 0, 1, 1, NULL),
(51, 2, 'Primera Lengua Extranjera (Inglés)', 'Desarrollo de habilidades básicas en inglés.', 0, 1, 1, NULL),
(52, 3, 'Lengua Castellana y Literatura', 'Desarrollo de la comprensión y expresión escrita.', 0, 1, 1, NULL),
(53, 3, 'Matemáticas', 'Operaciones con números naturales y fracciones.', 0, 1, 1, NULL),
(54, 3, 'Ciencias de la Naturaleza', 'Estudio de los seres vivos y el medio ambiente.', 0, 1, 1, NULL),
(55, 3, 'Ciencias Sociales', 'Estudio de la geografía y la historia local.', 0, 1, 1, NULL),
(56, 3, 'Educación Artística', 'Desarrollo de técnicas artísticas y musicales.', 0, 1, 1, NULL),
(57, 3, 'Educación Física', 'Desarrollo de habilidades deportivas y juegos.', 0, 1, 1, NULL),
(58, 3, 'Primera Lengua Extranjera (Inglés)', 'Ampliación de vocabulario y estructuras en inglés.', 0, 1, 1, NULL),
(59, 4, 'Lengua Castellana y Literatura', 'Profundización en la comprensión y expresión escrita.', 0, 1, 1, NULL),
(60, 4, 'Matemáticas', 'Operaciones con decimales y geometría.', 0, 1, 1, NULL),
(61, 4, 'Ciencias de la Naturaleza', 'Estudio de la materia, energía y tecnología.', 0, 1, 1, NULL),
(62, 4, 'Ciencias Sociales', 'Estudio de la geografía e historia de España.', 0, 1, 1, NULL),
(63, 4, 'Educación Artística', 'Desarrollo de proyectos artísticos y musicales.', 0, 1, 1, NULL),
(64, 4, 'Educación Física', 'Desarrollo de habilidades deportivas y juegos.', 0, 1, 1, NULL),
(65, 4, 'Primera Lengua Extranjera (Inglés)', 'Comunicación básica en inglés.', 0, 1, 1, NULL),
(66, 5, 'Lengua Castellana y Literatura', 'Análisis de textos y producción escrita.', 0, 1, 1, NULL),
(67, 5, 'Matemáticas', 'Operaciones con fracciones y porcentajes.', 0, 1, 1, NULL),
(68, 5, 'Ciencias de la Naturaleza', 'Estudio del cuerpo humano y la salud.', 0, 1, 1, NULL),
(69, 5, 'Ciencias Sociales', 'Estudio de la geografía e historia de Europa.', 0, 1, 1, NULL),
(70, 5, 'Educación Artística', 'Desarrollo de proyectos artísticos complejos.', 0, 1, 1, NULL),
(71, 5, 'Educación Física', 'Desarrollo de habilidades deportivas y juegos.', 0, 1, 1, NULL),
(72, 5, 'Primera Lengua Extranjera (Inglés)', 'Comunicación en inglés en diferentes contextos.', 0, 1, 1, NULL),
(73, 6, 'Lengua Castellana y Literatura', 'Análisis de textos literarios y producción escrita.', 0, 1, 1, NULL),
(74, 6, 'Matemáticas', 'Álgebra básica y resolución de problemas.', 0, 1, 1, NULL),
(75, 6, 'Ciencias de la Naturaleza', 'Estudio de ecosistemas y medio ambiente.', 0, 1, 1, NULL),
(76, 6, 'Ciencias Sociales', 'Estudio de la geografía e historia mundial.', 0, 1, 1, NULL),
(77, 6, 'Educación Artística', 'Desarrollo de proyectos artísticos y musicales avanzados.', 0, 1, 1, NULL),
(78, 6, 'Educación Física', 'Desarrollo de habilidades deportivas y juegos.', 0, 1, 1, NULL),
(79, 6, 'Primera Lengua Extranjera (Inglés)', 'Comunicación fluida en inglés.', 0, 1, 1, NULL),
(137, 8, 'Lengua Castellana y Literatura', 'Estudio de la lengua y literatura española.', 0, 1, 1, NULL),
(138, 8, 'Matemáticas', 'Álgebra, geometría y estadística básica.', 0, 1, 1, NULL),
(139, 8, 'Biología y Geología', 'Estudio de los seres vivos y la Tierra.', 0, 1, 1, NULL),
(140, 8, 'Geografía e Historia', 'Estudio de la geografía física y humana.', 0, 1, 1, NULL),
(141, 8, 'Educación Física', 'Desarrollo de habilidades físicas y deportivas.', 0, 1, 1, NULL),
(142, 8, 'Primera Lengua Extranjera (Inglés)', 'Desarrollo de competencias comunicativas en inglés.', 0, 1, 1, NULL),
(143, 8, 'Educación Plástica, Visual y Audiovisual', 'Desarrollo de la expresión artística.', 0, 1, 1, NULL),
(144, 8, 'Música', 'Estudio de la teoría musical y práctica instrumental.', 0, 1, 1, NULL),
(145, 15, 'Matemáticas I', 'Álgebra, análisis, geometría y estadística para ciencias.', 0, 1, 1, NULL),
(146, 15, 'Física y Química', 'Estudio de los principios fundamentales de la física y la química.', 0, 1, 1, NULL),
(147, 15, 'Biología y Geología', 'Estudio de los seres vivos y la estructura de la Tierra.', 0, 0, 1, NULL),
(148, 15, 'Dibujo Técnico I', 'Sistemas de representación y normalización.', 0, 0, 1, NULL),
(149, 15, 'Lengua Castellana y Literatura I', 'Estudio avanzado de la lengua y literatura española.', 0, 1, 1, NULL),
(150, 15, 'Primera Lengua Extranjera I', 'Desarrollo avanzado de competencias en inglés.', 0, 1, 1, NULL),
(151, 15, 'Filosofía', 'Introducción al pensamiento filosófico.', 0, 1, 1, NULL),
(152, 15, 'Educación Física', 'Desarrollo de habilidades físicas y deportivas.', 0, 1, 1, NULL),
(153, 19, 'Matemáticas II', 'Continuación de matemáticas para ciencias.', 0, 1, 1, NULL),
(154, 19, 'Física', 'Estudio avanzado de los principios y leyes de la física.', 0, 0, 1, NULL),
(155, 19, 'Química', 'Estudio avanzado de la estructura y propiedades de la materia.', 0, 0, 1, NULL),
(156, 19, 'Biología', 'Estudio avanzado de los seres vivos y sus procesos.', 0, 0, 1, NULL),
(157, 19, 'Dibujo Técnico II', 'Sistemas de representación avanzados.', 0, 0, 1, NULL),
(158, 19, 'Lengua Castellana y Literatura II', 'Profundización en lengua y literatura española.', 0, 1, 1, NULL),
(159, 19, 'Primera Lengua Extranjera II', 'Nivel avanzado de inglés.', 0, 1, 1, NULL),
(160, 19, 'Historia de España', 'Estudio de la historia de España.', 0, 1, 1, NULL),
(161, 17, 'Latín I', 'Estudio de la lengua latina y su cultura (para Humanidades).', 0, 0, 1, NULL),
(162, 17, 'Matemáticas Aplicadas a las Ciencias Sociales I', 'Matemáticas orientadas a ciencias sociales.', 0, 0, 1, NULL),
(163, 17, 'Economía', 'Introducción a los conceptos económicos básicos.', 0, 0, 1, NULL),
(164, 17, 'Historia del Mundo Contemporáneo', 'Estudio de la historia mundial desde el siglo XVIII.', 0, 0, 1, NULL),
(165, 17, 'Literatura Universal', 'Estudio de las principales obras de la literatura mundial.', 0, 0, 1, NULL),
(166, 17, 'Lengua Castellana y Literatura I', 'Estudio avanzado de la lengua y literatura española.', 0, 1, 1, NULL),
(167, 17, 'Primera Lengua Extranjera I', 'Desarrollo avanzado de competencias en inglés.', 0, 1, 1, NULL),
(168, 17, 'Filosofía', 'Introducción al pensamiento filosófico.', 0, 1, 1, NULL),
(169, 21, 'Latín II', 'Continuación del estudio de la lengua latina (para Humanidades).', 0, 0, 1, NULL),
(170, 21, 'Matemáticas Aplicadas a las Ciencias Sociales II', 'Continuación de matemáticas para ciencias sociales.', 0, 0, 1, NULL),
(171, 21, 'Economía de la Empresa', 'Estudio de la organización y funcionamiento de las empresas.', 0, 0, 1, NULL),
(172, 21, 'Geografía', 'Estudio del espacio geográfico español y mundial.', 0, 0, 1, NULL),
(173, 21, 'Historia del Arte', 'Estudio de las principales manifestaciones artísticas.', 0, 0, 1, NULL),
(174, 21, 'Lengua Castellana y Literatura II', 'Profundización en lengua y literatura española.', 0, 1, 1, NULL),
(175, 21, 'Primera Lengua Extranjera II', 'Nivel avanzado de inglés.', 0, 1, 1, NULL),
(176, 21, 'Historia de España', 'Estudio de la historia de España.', 0, 1, 1, NULL),
(177, 14, 'Fundamentos del Arte I', 'Estudio de los fundamentos artísticos a lo largo de la historia.', 0, 1, 1, NULL),
(178, 14, 'Cultura Audiovisual I', 'Análisis de los elementos audiovisuales y su contexto.', 0, 0, 1, NULL),
(179, 14, 'Historia del Mundo Contemporáneo', 'Estudio de la historia mundial desde el siglo XVIII.', 0, 0, 1, NULL),
(180, 14, 'Literatura Universal', 'Estudio de las principales obras de la literatura mundial.', 0, 0, 1, NULL),
(181, 14, 'Dibujo Artístico I', 'Técnicas de dibujo y expresión gráfica.', 0, 0, 1, NULL),
(182, 14, 'Volumen', 'Técnicas de modelado y creación tridimensional.', 0, 0, 1, NULL),
(183, 14, 'Lengua Castellana y Literatura I', 'Estudio avanzado de la lengua y literatura española.', 0, 1, 1, NULL),
(184, 14, 'Primera Lengua Extranjera I', 'Desarrollo avanzado de competencias en inglés.', 0, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `modalidad_curso_id` int(11) NOT NULL,
  `fecha_matricula` datetime DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidades`
--

CREATE TABLE `modalidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidades_curso`
--

CREATE TABLE `modalidades_curso` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `rama_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `modalidades_curso`
--

INSERT INTO `modalidades_curso` (`id`, `curso_id`, `rama_id`, `nombre`, `descripcion`, `activo`) VALUES
(1, 1, NULL, 'Primero de Primaria', 'Primer curso de Educación Primaria para niños de 6-7 años.', 1),
(2, 2, NULL, 'Segundo de Primaria', 'Segundo curso de Educación Primaria para niños de 7-8 años.', 1),
(3, 3, NULL, 'Tercero de Primaria', 'Tercer curso de Educación Primaria para niños de 8-9 años.', 1),
(4, 4, NULL, 'Cuarto de Primaria', 'Cuarto curso de Educación Primaria para niños de 9-10 años.', 1),
(5, 5, NULL, 'Quinto de Primaria', 'Quinto curso de Educación Primaria para niños de 10-11 años.', 1),
(6, 6, NULL, 'Sexto de Primaria', 'Sexto curso de Educación Primaria para niños de 11-12 años.', 1),
(8, 7, NULL, 'Primero de ESO', 'Primer curso de Educación Secundaria Obligatoria para estudiantes de 12-13 años.', 1),
(9, 8, NULL, 'Segundo de ESO', 'Segundo curso de Educación Secundaria Obligatoria para estudiantes de 13-14 años.', 1),
(10, 9, NULL, 'Tercero de ESO', 'Tercer curso de Educación Secundaria Obligatoria para estudiantes de 14-15 años.', 1),
(11, 10, 1, 'Cuarto de ESO - Académicas - Ciencias', 'Modalidad de Académicas - Ciencias para Cuarto de ESO', 1),
(12, 10, 2, 'Cuarto de ESO - Académicas - Humanidades', 'Modalidad de Académicas - Humanidades para Cuarto de ESO', 1),
(13, 10, 3, 'Cuarto de ESO - Aplicadas', 'Modalidad de Aplicadas para Cuarto de ESO', 1),
(14, 11, 6, 'Primero de Bachillerato - Artes', 'Modalidad de Artes para Primero de Bachillerato', 1),
(15, 11, 4, 'Primero de Bachillerato - Ciencias', 'Modalidad de Ciencias para Primero de Bachillerato', 1),
(16, 11, 7, 'Primero de Bachillerato - General', 'Modalidad de General para Primero de Bachillerato', 1),
(17, 11, 5, 'Primero de Bachillerato - Humanidades y Ciencias Sociales', 'Modalidad de Humanidades y Ciencias Sociales para Primero de Bachillerato', 1),
(18, 12, 6, 'Segundo de Bachillerato - Artes', 'Modalidad de Artes para Segundo de Bachillerato', 1),
(19, 12, 4, 'Segundo de Bachillerato - Ciencias', 'Modalidad de Ciencias para Segundo de Bachillerato', 1),
(20, 12, 7, 'Segundo de Bachillerato - General', 'Modalidad de General para Segundo de Bachillerato', 1),
(21, 12, 5, 'Segundo de Bachillerato - Humanidades y Ciencias Sociales', 'Modalidad de Humanidades y Ciencias Sociales para Segundo de Bachillerato', 1),
(29, 13, 16, 'Actividades Físicas y Deportivas - 1º', 'Ciclo de FP Básica de Actividades Físicas y Deportivas - Primero de FP Básica', 1),
(30, 13, 17, 'Administración y Gestión - 1º', 'Ciclo de FP Básica de Administración y Gestión - Primero de FP Básica', 1),
(31, 13, 18, 'Agraria - 1º', 'Ciclo de FP Básica de Agraria - Primero de FP Básica', 1),
(32, 13, 19, 'Artes Gráficas - 1º', 'Ciclo de FP Básica de Artes Gráficas - Primero de FP Básica', 1),
(33, 13, 20, 'Comercio y Marketing - 1º', 'Ciclo de FP Básica de Comercio y Marketing - Primero de FP Básica', 1),
(34, 13, 21, 'Edificación y Obra Civil - 1º', 'Ciclo de FP Básica de Edificación y Obra Civil - Primero de FP Básica', 1),
(35, 13, 22, 'Electricidad y Electrónica - 1º', 'Ciclo de FP Básica de Electricidad y Electrónica - Primero de FP Básica', 1),
(36, 13, 23, 'Fabricación Mecánica - 1º', 'Ciclo de FP Básica de Fabricación Mecánica - Primero de FP Básica', 1),
(37, 13, 13, 'Familias Profesionales FP Básica - 1º', 'Ciclo de FP Básica de Familias Profesionales FP Básica - Primero de FP Básica', 1),
(38, 13, 24, 'Hostelería y Turismo - 1º', 'Ciclo de FP Básica de Hostelería y Turismo - Primero de FP Básica', 1),
(39, 13, 25, 'Imagen Personal - 1º', 'Ciclo de FP Básica de Imagen Personal - Primero de FP Básica', 1),
(40, 13, 26, 'Industrias Alimentarias - 1º', 'Ciclo de FP Básica de Industrias Alimentarias - Primero de FP Básica', 1),
(41, 13, 27, 'Informática y Comunicaciones - 1º', 'Ciclo de FP Básica de Informática y Comunicaciones - Primero de FP Básica', 1),
(42, 13, 28, 'Instalación y Mantenimiento - 1º', 'Ciclo de FP Básica de Instalación y Mantenimiento - Primero de FP Básica', 1),
(43, 13, 29, 'Madera, Mueble y Corcho - 1º', 'Ciclo de FP Básica de Madera, Mueble y Corcho - Primero de FP Básica', 1),
(44, 13, 30, 'Marítimo-Pesquera - 1º', 'Ciclo de FP Básica de Marítimo-Pesquera - Primero de FP Básica', 1),
(45, 13, 31, 'Servicios Socioculturales y a la Comunidad - 1º', 'Ciclo de FP Básica de Servicios Socioculturales y a la Comunidad - Primero de FP Básica', 1),
(46, 13, 32, 'Textil, Confección y Piel - 1º', 'Ciclo de FP Básica de Textil, Confección y Piel - Primero de FP Básica', 1),
(47, 13, 33, 'Transporte y Mantenimiento de Vehículos - 1º', 'Ciclo de FP Básica de Transporte y Mantenimiento de Vehículos - Primero de FP Básica', 1),
(48, 13, 34, 'Vidrio y Cerámica - 1º', 'Ciclo de FP Básica de Vidrio y Cerámica - Primero de FP Básica', 1),
(49, 14, 16, 'Actividades Físicas y Deportivas - 2º', 'Ciclo de FP Básica de Actividades Físicas y Deportivas - Segundo de FP Básica', 1),
(50, 14, 17, 'Administración y Gestión - 2º', 'Ciclo de FP Básica de Administración y Gestión - Segundo de FP Básica', 1),
(51, 14, 18, 'Agraria - 2º', 'Ciclo de FP Básica de Agraria - Segundo de FP Básica', 1),
(52, 14, 19, 'Artes Gráficas - 2º', 'Ciclo de FP Básica de Artes Gráficas - Segundo de FP Básica', 1),
(53, 14, 20, 'Comercio y Marketing - 2º', 'Ciclo de FP Básica de Comercio y Marketing - Segundo de FP Básica', 1),
(54, 14, 21, 'Edificación y Obra Civil - 2º', 'Ciclo de FP Básica de Edificación y Obra Civil - Segundo de FP Básica', 1),
(55, 14, 22, 'Electricidad y Electrónica - 2º', 'Ciclo de FP Básica de Electricidad y Electrónica - Segundo de FP Básica', 1),
(56, 14, 23, 'Fabricación Mecánica - 2º', 'Ciclo de FP Básica de Fabricación Mecánica - Segundo de FP Básica', 1),
(57, 14, 13, 'Familias Profesionales FP Básica - 2º', 'Ciclo de FP Básica de Familias Profesionales FP Básica - Segundo de FP Básica', 1),
(58, 14, 24, 'Hostelería y Turismo - 2º', 'Ciclo de FP Básica de Hostelería y Turismo - Segundo de FP Básica', 1),
(59, 14, 25, 'Imagen Personal - 2º', 'Ciclo de FP Básica de Imagen Personal - Segundo de FP Básica', 1),
(60, 14, 26, 'Industrias Alimentarias - 2º', 'Ciclo de FP Básica de Industrias Alimentarias - Segundo de FP Básica', 1),
(61, 14, 27, 'Informática y Comunicaciones - 2º', 'Ciclo de FP Básica de Informática y Comunicaciones - Segundo de FP Básica', 1),
(62, 14, 28, 'Instalación y Mantenimiento - 2º', 'Ciclo de FP Básica de Instalación y Mantenimiento - Segundo de FP Básica', 1),
(63, 14, 29, 'Madera, Mueble y Corcho - 2º', 'Ciclo de FP Básica de Madera, Mueble y Corcho - Segundo de FP Básica', 1),
(64, 14, 30, 'Marítimo-Pesquera - 2º', 'Ciclo de FP Básica de Marítimo-Pesquera - Segundo de FP Básica', 1),
(65, 14, 31, 'Servicios Socioculturales y a la Comunidad - 2º', 'Ciclo de FP Básica de Servicios Socioculturales y a la Comunidad - Segundo de FP Básica', 1),
(66, 14, 32, 'Textil, Confección y Piel - 2º', 'Ciclo de FP Básica de Textil, Confección y Piel - Segundo de FP Básica', 1),
(67, 14, 33, 'Transporte y Mantenimiento de Vehículos - 2º', 'Ciclo de FP Básica de Transporte y Mantenimiento de Vehículos - Segundo de FP Básica', 1),
(68, 14, 34, 'Vidrio y Cerámica - 2º', 'Ciclo de FP Básica de Vidrio y Cerámica - Segundo de FP Básica', 1),
(92, 15, 35, 'Actividades Físicas y Deportivas - 1º', 'Ciclo de FP Grado Medio de Actividades Físicas y Deportivas - Primero de FP Grado Medio', 1),
(93, 15, 36, 'Administración y Gestión - 1º', 'Ciclo de FP Grado Medio de Administración y Gestión - Primero de FP Grado Medio', 1),
(94, 15, 37, 'Agraria - 1º', 'Ciclo de FP Grado Medio de Agraria - Primero de FP Grado Medio', 1),
(95, 15, 38, 'Artes Gráficas - 1º', 'Ciclo de FP Grado Medio de Artes Gráficas - Primero de FP Grado Medio', 1),
(96, 15, 39, 'Comercio y Marketing - 1º', 'Ciclo de FP Grado Medio de Comercio y Marketing - Primero de FP Grado Medio', 1),
(97, 15, 40, 'Edificación y Obra Civil - 1º', 'Ciclo de FP Grado Medio de Edificación y Obra Civil - Primero de FP Grado Medio', 1),
(98, 15, 41, 'Electricidad y Electrónica - 1º', 'Ciclo de FP Grado Medio de Electricidad y Electrónica - Primero de FP Grado Medio', 1),
(99, 15, 42, 'Energía y Agua - 1º', 'Ciclo de FP Grado Medio de Energía y Agua - Primero de FP Grado Medio', 1),
(100, 15, 43, 'Fabricación Mecánica - 1º', 'Ciclo de FP Grado Medio de Fabricación Mecánica - Primero de FP Grado Medio', 1),
(101, 15, 14, 'Familias Profesionales FP Grado Medio - 1º', 'Ciclo de FP Grado Medio de Familias Profesionales FP Grado Medio - Primero de FP Grado Medio', 1),
(102, 15, 44, 'Hostelería y Turismo - 1º', 'Ciclo de FP Grado Medio de Hostelería y Turismo - Primero de FP Grado Medio', 1),
(103, 15, 45, 'Imagen Personal - 1º', 'Ciclo de FP Grado Medio de Imagen Personal - Primero de FP Grado Medio', 1),
(104, 15, 46, 'Imagen y Sonido - 1º', 'Ciclo de FP Grado Medio de Imagen y Sonido - Primero de FP Grado Medio', 1),
(105, 15, 47, 'Industrias Alimentarias - 1º', 'Ciclo de FP Grado Medio de Industrias Alimentarias - Primero de FP Grado Medio', 1),
(106, 15, 48, 'Industrias Extractivas - 1º', 'Ciclo de FP Grado Medio de Industrias Extractivas - Primero de FP Grado Medio', 1),
(107, 15, 49, 'Informática y Comunicaciones - 1º', 'Ciclo de FP Grado Medio de Informática y Comunicaciones - Primero de FP Grado Medio', 1),
(108, 15, 50, 'Instalación y Mantenimiento - 1º', 'Ciclo de FP Grado Medio de Instalación y Mantenimiento - Primero de FP Grado Medio', 1),
(109, 15, 51, 'Madera, Mueble y Corcho - 1º', 'Ciclo de FP Grado Medio de Madera, Mueble y Corcho - Primero de FP Grado Medio', 1),
(110, 15, 52, 'Marítimo-Pesquera - 1º', 'Ciclo de FP Grado Medio de Marítimo-Pesquera - Primero de FP Grado Medio', 1),
(111, 15, 53, 'Química - 1º', 'Ciclo de FP Grado Medio de Química - Primero de FP Grado Medio', 1),
(112, 15, 54, 'Sanidad - 1º', 'Ciclo de FP Grado Medio de Sanidad - Primero de FP Grado Medio', 1),
(113, 15, 55, 'Seguridad y Medio Ambiente - 1º', 'Ciclo de FP Grado Medio de Seguridad y Medio Ambiente - Primero de FP Grado Medio', 1),
(114, 15, 56, 'Servicios Socioculturales y a la Comunidad - 1º', 'Ciclo de FP Grado Medio de Servicios Socioculturales y a la Comunidad - Primero de FP Grado Medio', 1),
(115, 15, 57, 'Textil, Confección y Piel - 1º', 'Ciclo de FP Grado Medio de Textil, Confección y Piel - Primero de FP Grado Medio', 1),
(116, 15, 58, 'Transporte y Mantenimiento de Vehículos - 1º', 'Ciclo de FP Grado Medio de Transporte y Mantenimiento de Vehículos - Primero de FP Grado Medio', 1),
(117, 15, 59, 'Vidrio y Cerámica - 1º', 'Ciclo de FP Grado Medio de Vidrio y Cerámica - Primero de FP Grado Medio', 1),
(118, 16, 35, 'Actividades Físicas y Deportivas - 2º', 'Ciclo de FP Grado Medio de Actividades Físicas y Deportivas - Segundo de FP Grado Medio', 1),
(119, 16, 36, 'Administración y Gestión - 2º', 'Ciclo de FP Grado Medio de Administración y Gestión - Segundo de FP Grado Medio', 1),
(120, 16, 37, 'Agraria - 2º', 'Ciclo de FP Grado Medio de Agraria - Segundo de FP Grado Medio', 1),
(121, 16, 38, 'Artes Gráficas - 2º', 'Ciclo de FP Grado Medio de Artes Gráficas - Segundo de FP Grado Medio', 1),
(122, 16, 39, 'Comercio y Marketing - 2º', 'Ciclo de FP Grado Medio de Comercio y Marketing - Segundo de FP Grado Medio', 1),
(123, 16, 40, 'Edificación y Obra Civil - 2º', 'Ciclo de FP Grado Medio de Edificación y Obra Civil - Segundo de FP Grado Medio', 1),
(124, 16, 41, 'Electricidad y Electrónica - 2º', 'Ciclo de FP Grado Medio de Electricidad y Electrónica - Segundo de FP Grado Medio', 1),
(125, 16, 42, 'Energía y Agua - 2º', 'Ciclo de FP Grado Medio de Energía y Agua - Segundo de FP Grado Medio', 1),
(126, 16, 43, 'Fabricación Mecánica - 2º', 'Ciclo de FP Grado Medio de Fabricación Mecánica - Segundo de FP Grado Medio', 1),
(127, 16, 14, 'Familias Profesionales FP Grado Medio - 2º', 'Ciclo de FP Grado Medio de Familias Profesionales FP Grado Medio - Segundo de FP Grado Medio', 1),
(128, 16, 44, 'Hostelería y Turismo - 2º', 'Ciclo de FP Grado Medio de Hostelería y Turismo - Segundo de FP Grado Medio', 1),
(129, 16, 45, 'Imagen Personal - 2º', 'Ciclo de FP Grado Medio de Imagen Personal - Segundo de FP Grado Medio', 1),
(130, 16, 46, 'Imagen y Sonido - 2º', 'Ciclo de FP Grado Medio de Imagen y Sonido - Segundo de FP Grado Medio', 1),
(131, 16, 47, 'Industrias Alimentarias - 2º', 'Ciclo de FP Grado Medio de Industrias Alimentarias - Segundo de FP Grado Medio', 1),
(132, 16, 48, 'Industrias Extractivas - 2º', 'Ciclo de FP Grado Medio de Industrias Extractivas - Segundo de FP Grado Medio', 1),
(133, 16, 49, 'Informática y Comunicaciones - 2º', 'Ciclo de FP Grado Medio de Informática y Comunicaciones - Segundo de FP Grado Medio', 1),
(134, 16, 50, 'Instalación y Mantenimiento - 2º', 'Ciclo de FP Grado Medio de Instalación y Mantenimiento - Segundo de FP Grado Medio', 1),
(135, 16, 51, 'Madera, Mueble y Corcho - 2º', 'Ciclo de FP Grado Medio de Madera, Mueble y Corcho - Segundo de FP Grado Medio', 1),
(136, 16, 52, 'Marítimo-Pesquera - 2º', 'Ciclo de FP Grado Medio de Marítimo-Pesquera - Segundo de FP Grado Medio', 1),
(137, 16, 53, 'Química - 2º', 'Ciclo de FP Grado Medio de Química - Segundo de FP Grado Medio', 1),
(138, 16, 54, 'Sanidad - 2º', 'Ciclo de FP Grado Medio de Sanidad - Segundo de FP Grado Medio', 1),
(139, 16, 55, 'Seguridad y Medio Ambiente - 2º', 'Ciclo de FP Grado Medio de Seguridad y Medio Ambiente - Segundo de FP Grado Medio', 1),
(140, 16, 56, 'Servicios Socioculturales y a la Comunidad - 2º', 'Ciclo de FP Grado Medio de Servicios Socioculturales y a la Comunidad - Segundo de FP Grado Medio', 1),
(141, 16, 57, 'Textil, Confección y Piel - 2º', 'Ciclo de FP Grado Medio de Textil, Confección y Piel - Segundo de FP Grado Medio', 1),
(142, 16, 58, 'Transporte y Mantenimiento de Vehículos - 2º', 'Ciclo de FP Grado Medio de Transporte y Mantenimiento de Vehículos - Segundo de FP Grado Medio', 1),
(143, 16, 59, 'Vidrio y Cerámica - 2º', 'Ciclo de FP Grado Medio de Vidrio y Cerámica - Segundo de FP Grado Medio', 1),
(155, 17, 60, 'Actividades Físicas y Deportivas - 1º', 'Ciclo de FP Grado Superior de Actividades Físicas y Deportivas - Primero de FP Grado Superior', 1),
(156, 17, 61, 'Administración y Gestión - 1º', 'Ciclo de FP Grado Superior de Administración y Gestión - Primero de FP Grado Superior', 1),
(157, 17, 62, 'Agraria - 1º', 'Ciclo de FP Grado Superior de Agraria - Primero de FP Grado Superior', 1),
(158, 17, 63, 'Artes Gráficas - 1º', 'Ciclo de FP Grado Superior de Artes Gráficas - Primero de FP Grado Superior', 1),
(159, 17, 64, 'Comercio y Marketing - 1º', 'Ciclo de FP Grado Superior de Comercio y Marketing - Primero de FP Grado Superior', 1),
(160, 17, 65, 'Edificación y Obra Civil - 1º', 'Ciclo de FP Grado Superior de Edificación y Obra Civil - Primero de FP Grado Superior', 1),
(161, 17, 66, 'Electricidad y Electrónica - 1º', 'Ciclo de FP Grado Superior de Electricidad y Electrónica - Primero de FP Grado Superior', 1),
(162, 17, 67, 'Energía y Agua - 1º', 'Ciclo de FP Grado Superior de Energía y Agua - Primero de FP Grado Superior', 1),
(163, 17, 68, 'Fabricación Mecánica - 1º', 'Ciclo de FP Grado Superior de Fabricación Mecánica - Primero de FP Grado Superior', 1),
(164, 17, 15, 'Familias Profesionales FP Grado Superior - 1º', 'Ciclo de FP Grado Superior de Familias Profesionales FP Grado Superior - Primero de FP Grado Superior', 1),
(165, 17, 69, 'Hostelería y Turismo - 1º', 'Ciclo de FP Grado Superior de Hostelería y Turismo - Primero de FP Grado Superior', 1),
(166, 17, 70, 'Imagen Personal - 1º', 'Ciclo de FP Grado Superior de Imagen Personal - Primero de FP Grado Superior', 1),
(167, 17, 71, 'Imagen y Sonido - 1º', 'Ciclo de FP Grado Superior de Imagen y Sonido - Primero de FP Grado Superior', 1),
(168, 17, 72, 'Industrias Alimentarias - 1º', 'Ciclo de FP Grado Superior de Industrias Alimentarias - Primero de FP Grado Superior', 1),
(169, 17, 73, 'Informática y Comunicaciones - 1º', 'Ciclo de FP Grado Superior de Informática y Comunicaciones - Primero de FP Grado Superior', 1),
(170, 17, 74, 'Instalación y Mantenimiento - 1º', 'Ciclo de FP Grado Superior de Instalación y Mantenimiento - Primero de FP Grado Superior', 1),
(171, 17, 75, 'Madera, Mueble y Corcho - 1º', 'Ciclo de FP Grado Superior de Madera, Mueble y Corcho - Primero de FP Grado Superior', 1),
(172, 17, 76, 'Marítimo-Pesquera - 1º', 'Ciclo de FP Grado Superior de Marítimo-Pesquera - Primero de FP Grado Superior', 1),
(173, 17, 77, 'Química - 1º', 'Ciclo de FP Grado Superior de Química - Primero de FP Grado Superior', 1),
(174, 17, 78, 'Sanidad - 1º', 'Ciclo de FP Grado Superior de Sanidad - Primero de FP Grado Superior', 1),
(175, 17, 79, 'Seguridad y Medio Ambiente - 1º', 'Ciclo de FP Grado Superior de Seguridad y Medio Ambiente - Primero de FP Grado Superior', 1),
(176, 17, 80, 'Servicios Socioculturales y a la Comunidad - 1º', 'Ciclo de FP Grado Superior de Servicios Socioculturales y a la Comunidad - Primero de FP Grado Superior', 1),
(177, 17, 81, 'Textil, Confección y Piel - 1º', 'Ciclo de FP Grado Superior de Textil, Confección y Piel - Primero de FP Grado Superior', 1),
(178, 17, 82, 'Transporte y Mantenimiento de Vehículos - 1º', 'Ciclo de FP Grado Superior de Transporte y Mantenimiento de Vehículos - Primero de FP Grado Superior', 1),
(179, 18, 60, 'Actividades Físicas y Deportivas - 2º', 'Ciclo de FP Grado Superior de Actividades Físicas y Deportivas - Segundo de FP Grado Superior', 1),
(180, 18, 61, 'Administración y Gestión - 2º', 'Ciclo de FP Grado Superior de Administración y Gestión - Segundo de FP Grado Superior', 1),
(181, 18, 62, 'Agraria - 2º', 'Ciclo de FP Grado Superior de Agraria - Segundo de FP Grado Superior', 1),
(182, 18, 63, 'Artes Gráficas - 2º', 'Ciclo de FP Grado Superior de Artes Gráficas - Segundo de FP Grado Superior', 1),
(183, 18, 64, 'Comercio y Marketing - 2º', 'Ciclo de FP Grado Superior de Comercio y Marketing - Segundo de FP Grado Superior', 1),
(184, 18, 65, 'Edificación y Obra Civil - 2º', 'Ciclo de FP Grado Superior de Edificación y Obra Civil - Segundo de FP Grado Superior', 1),
(185, 18, 66, 'Electricidad y Electrónica - 2º', 'Ciclo de FP Grado Superior de Electricidad y Electrónica - Segundo de FP Grado Superior', 1),
(186, 18, 67, 'Energía y Agua - 2º', 'Ciclo de FP Grado Superior de Energía y Agua - Segundo de FP Grado Superior', 1),
(187, 18, 68, 'Fabricación Mecánica - 2º', 'Ciclo de FP Grado Superior de Fabricación Mecánica - Segundo de FP Grado Superior', 1),
(188, 18, 15, 'Familias Profesionales FP Grado Superior - 2º', 'Ciclo de FP Grado Superior de Familias Profesionales FP Grado Superior - Segundo de FP Grado Superior', 1),
(189, 18, 69, 'Hostelería y Turismo - 2º', 'Ciclo de FP Grado Superior de Hostelería y Turismo - Segundo de FP Grado Superior', 1),
(190, 18, 70, 'Imagen Personal - 2º', 'Ciclo de FP Grado Superior de Imagen Personal - Segundo de FP Grado Superior', 1),
(191, 18, 71, 'Imagen y Sonido - 2º', 'Ciclo de FP Grado Superior de Imagen y Sonido - Segundo de FP Grado Superior', 1),
(192, 18, 72, 'Industrias Alimentarias - 2º', 'Ciclo de FP Grado Superior de Industrias Alimentarias - Segundo de FP Grado Superior', 1),
(193, 18, 73, 'Informática y Comunicaciones - 2º', 'Ciclo de FP Grado Superior de Informática y Comunicaciones - Segundo de FP Grado Superior', 1),
(194, 18, 74, 'Instalación y Mantenimiento - 2º', 'Ciclo de FP Grado Superior de Instalación y Mantenimiento - Segundo de FP Grado Superior', 1),
(195, 18, 75, 'Madera, Mueble y Corcho - 2º', 'Ciclo de FP Grado Superior de Madera, Mueble y Corcho - Segundo de FP Grado Superior', 1),
(196, 18, 76, 'Marítimo-Pesquera - 2º', 'Ciclo de FP Grado Superior de Marítimo-Pesquera - Segundo de FP Grado Superior', 1),
(197, 18, 77, 'Química - 2º', 'Ciclo de FP Grado Superior de Química - Segundo de FP Grado Superior', 1),
(198, 18, 78, 'Sanidad - 2º', 'Ciclo de FP Grado Superior de Sanidad - Segundo de FP Grado Superior', 1),
(199, 18, 79, 'Seguridad y Medio Ambiente - 2º', 'Ciclo de FP Grado Superior de Seguridad y Medio Ambiente - Segundo de FP Grado Superior', 1),
(200, 18, 80, 'Servicios Socioculturales y a la Comunidad - 2º', 'Ciclo de FP Grado Superior de Servicios Socioculturales y a la Comunidad - Segundo de FP Grado Superior', 1),
(201, 18, 81, 'Textil, Confección y Piel - 2º', 'Ciclo de FP Grado Superior de Textil, Confección y Piel - Segundo de FP Grado Superior', 1),
(202, 18, 82, 'Transporte y Mantenimiento de Vehículos - 2º', 'Ciclo de FP Grado Superior de Transporte y Mantenimiento de Vehículos - Segundo de FP Grado Superior', 1),
(218, 22, 8, 'Artes y Humanidades - Cuarto curso', 'Grados universitarios de la rama de Artes y Humanidades - Cuarto curso', 1),
(219, 19, 8, 'Artes y Humanidades - Primer curso', 'Grados universitarios de la rama de Artes y Humanidades - Primer curso', 1),
(220, 23, 8, 'Artes y Humanidades - Quinto curso', 'Grados universitarios de la rama de Artes y Humanidades - Quinto curso', 1),
(221, 20, 8, 'Artes y Humanidades - Segundo curso', 'Grados universitarios de la rama de Artes y Humanidades - Segundo curso', 1),
(222, 24, 8, 'Artes y Humanidades - Sexto curso', 'Grados universitarios de la rama de Artes y Humanidades - Sexto curso', 1),
(223, 21, 8, 'Artes y Humanidades - Tercer curso', 'Grados universitarios de la rama de Artes y Humanidades - Tercer curso', 1),
(224, 22, 9, 'Ciencias - Cuarto curso', 'Grados universitarios de la rama de Ciencias - Cuarto curso', 1),
(225, 19, 9, 'Ciencias - Primer curso', 'Grados universitarios de la rama de Ciencias - Primer curso', 1),
(226, 23, 9, 'Ciencias - Quinto curso', 'Grados universitarios de la rama de Ciencias - Quinto curso', 1),
(227, 20, 9, 'Ciencias - Segundo curso', 'Grados universitarios de la rama de Ciencias - Segundo curso', 1),
(228, 24, 9, 'Ciencias - Sexto curso', 'Grados universitarios de la rama de Ciencias - Sexto curso', 1),
(229, 21, 9, 'Ciencias - Tercer curso', 'Grados universitarios de la rama de Ciencias - Tercer curso', 1),
(230, 22, 10, 'Ciencias de la Salud - Cuarto curso', 'Grados universitarios de la rama de Ciencias de la Salud - Cuarto curso', 1),
(231, 19, 10, 'Ciencias de la Salud - Primer curso', 'Grados universitarios de la rama de Ciencias de la Salud - Primer curso', 1),
(232, 23, 10, 'Ciencias de la Salud - Quinto curso', 'Grados universitarios de la rama de Ciencias de la Salud - Quinto curso', 1),
(233, 20, 10, 'Ciencias de la Salud - Segundo curso', 'Grados universitarios de la rama de Ciencias de la Salud - Segundo curso', 1),
(234, 24, 10, 'Ciencias de la Salud - Sexto curso', 'Grados universitarios de la rama de Ciencias de la Salud - Sexto curso', 1),
(235, 21, 10, 'Ciencias de la Salud - Tercer curso', 'Grados universitarios de la rama de Ciencias de la Salud - Tercer curso', 1),
(236, 22, 11, 'Ciencias Sociales y Jurídicas - Cuarto curso', 'Grados universitarios de la rama de Ciencias Sociales y Jurídicas - Cuarto curso', 1),
(237, 19, 11, 'Ciencias Sociales y Jurídicas - Primer curso', 'Grados universitarios de la rama de Ciencias Sociales y Jurídicas - Primer curso', 1),
(238, 23, 11, 'Ciencias Sociales y Jurídicas - Quinto curso', 'Grados universitarios de la rama de Ciencias Sociales y Jurídicas - Quinto curso', 1),
(239, 20, 11, 'Ciencias Sociales y Jurídicas - Segundo curso', 'Grados universitarios de la rama de Ciencias Sociales y Jurídicas - Segundo curso', 1),
(240, 24, 11, 'Ciencias Sociales y Jurídicas - Sexto curso', 'Grados universitarios de la rama de Ciencias Sociales y Jurídicas - Sexto curso', 1),
(241, 21, 11, 'Ciencias Sociales y Jurídicas - Tercer curso', 'Grados universitarios de la rama de Ciencias Sociales y Jurídicas - Tercer curso', 1),
(242, 22, 12, 'Ingeniería y Arquitectura - Cuarto curso', 'Grados universitarios de la rama de Ingeniería y Arquitectura - Cuarto curso', 1),
(243, 19, 12, 'Ingeniería y Arquitectura - Primer curso', 'Grados universitarios de la rama de Ingeniería y Arquitectura - Primer curso', 1),
(244, 23, 12, 'Ingeniería y Arquitectura - Quinto curso', 'Grados universitarios de la rama de Ingeniería y Arquitectura - Quinto curso', 1),
(245, 20, 12, 'Ingeniería y Arquitectura - Segundo curso', 'Grados universitarios de la rama de Ingeniería y Arquitectura - Segundo curso', 1),
(246, 24, 12, 'Ingeniería y Arquitectura - Sexto curso', 'Grados universitarios de la rama de Ingeniería y Arquitectura - Sexto curso', 1),
(247, 21, 12, 'Ingeniería y Arquitectura - Tercer curso', 'Grados universitarios de la rama de Ingeniería y Arquitectura - Tercer curso', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles_educativos`
--

CREATE TABLE `niveles_educativos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `niveles_educativos`
--

INSERT INTO `niveles_educativos` (`id`, `nombre`, `descripcion`, `orden`, `activo`) VALUES
(1, 'Educación Primaria', 'Nivel educativo obligatorio que comprende seis cursos académicos desde los 6 a los 12 años.', 1, 1),
(2, 'Educación Secundaria Obligatoria (ESO)', 'Nivel educativo obligatorio que comprende cuatro cursos académicos desde los 12 a los 16 años.', 2, 1),
(3, 'Bachillerato', 'Nivel educativo no obligatorio que comprende dos cursos académicos desde los 16 a los 18 años.', 3, 1),
(4, 'Formación Profesional Básica', 'Ciclos de formación profesional básica como parte de la formación profesional del sistema educativo.', 4, 1),
(5, 'Formación Profesional Grado Medio', 'Ciclos formativos de grado medio que forman parte de la educación secundaria post-obligatoria.', 5, 1),
(6, 'Formación Profesional Grado Superior', 'Ciclos formativos de grado superior que forman parte de la educación superior.', 6, 1),
(7, 'Grado Universitario', 'Estudios universitarios oficiales de Grado que tienen como finalidad la obtención de una formación general orientada a la preparación para el ejercicio de actividades profesionales.', 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso_alumno`
--

CREATE TABLE `progreso_alumno` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `contenido_id` int(11) NOT NULL,
  `completado` tinyint(1) DEFAULT 0,
  `puntuacion` int(11) DEFAULT 0,
  `fecha_ultimo_acceso` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ramas`
--

CREATE TABLE `ramas` (
  `id` int(11) NOT NULL,
  `nivel_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ramas`
--

INSERT INTO `ramas` (`id`, `nivel_id`, `nombre`, `descripcion`, `activo`) VALUES
(1, 2, 'Académicas - Ciencias', 'Orientación académica enfocada a ciencias para 4º de ESO.', 1),
(2, 2, 'Académicas - Humanidades', 'Orientación académica enfocada a humanidades para 4º de ESO.', 1),
(3, 2, 'Aplicadas', 'Orientación aplicada para 4º de ESO.', 1),
(4, 3, 'Ciencias', 'Modalidad de Ciencias y Tecnología.', 1),
(5, 3, 'Humanidades y Ciencias Sociales', 'Modalidad de Humanidades y Ciencias Sociales.', 1),
(6, 3, 'Artes', 'Modalidad de Artes.', 1),
(7, 3, 'General', 'Modalidad General (nueva modalidad).', 1),
(8, 7, 'Artes y Humanidades', 'Estudios relacionados con el arte, la filosofía, la historia, las lenguas, la literatura.', 1),
(9, 7, 'Ciencias', 'Estudios relacionados con la biología, la física, la química, las matemáticas.', 1),
(10, 7, 'Ciencias de la Salud', 'Estudios relacionados con la medicina, la enfermería, la farmacia, la psicología.', 1),
(11, 7, 'Ciencias Sociales y Jurídicas', 'Estudios relacionados con el derecho, la economía, la educación, la comunicación.', 1),
(12, 7, 'Ingeniería y Arquitectura', 'Estudios relacionados con las ingenierías, la arquitectura, la informática.', 1),
(13, 4, 'Familias Profesionales FP Básica', 'Familias profesionales para ciclos de FP Básica.', 1),
(14, 5, 'Familias Profesionales FP Grado Medio', 'Familias profesionales para ciclos de FP Grado Medio.', 1),
(15, 6, 'Familias Profesionales FP Grado Superior', 'Familias profesionales para ciclos de FP Grado Superior.', 1),
(16, 4, 'Actividades Físicas y Deportivas', 'Familia profesional relacionada con actividades físicas y deportivas.', 1),
(17, 4, 'Administración y Gestión', 'Familia profesional relacionada con administración y gestión.', 1),
(18, 4, 'Agraria', 'Familia profesional relacionada con actividades agrarias.', 1),
(19, 4, 'Artes Gráficas', 'Familia profesional relacionada con artes gráficas.', 1),
(20, 4, 'Comercio y Marketing', 'Familia profesional relacionada con comercio y marketing.', 1),
(21, 4, 'Edificación y Obra Civil', 'Familia profesional relacionada con edificación y obra civil.', 1),
(22, 4, 'Electricidad y Electrónica', 'Familia profesional relacionada con electricidad y electrónica.', 1),
(23, 4, 'Fabricación Mecánica', 'Familia profesional relacionada con fabricación mecánica.', 1),
(24, 4, 'Hostelería y Turismo', 'Familia profesional relacionada con hostelería y turismo.', 1),
(25, 4, 'Imagen Personal', 'Familia profesional relacionada con imagen personal.', 1),
(26, 4, 'Industrias Alimentarias', 'Familia profesional relacionada con industrias alimentarias.', 1),
(27, 4, 'Informática y Comunicaciones', 'Familia profesional relacionada con informática y comunicaciones.', 1),
(28, 4, 'Instalación y Mantenimiento', 'Familia profesional relacionada con instalación y mantenimiento.', 1),
(29, 4, 'Madera, Mueble y Corcho', 'Familia profesional relacionada con madera, mueble y corcho.', 1),
(30, 4, 'Marítimo-Pesquera', 'Familia profesional relacionada con actividades marítimo-pesqueras.', 1),
(31, 4, 'Servicios Socioculturales y a la Comunidad', 'Familia profesional relacionada con servicios socioculturales y a la comunidad.', 1),
(32, 4, 'Textil, Confección y Piel', 'Familia profesional relacionada con textil, confección y piel.', 1),
(33, 4, 'Transporte y Mantenimiento de Vehículos', 'Familia profesional relacionada con transporte y mantenimiento de vehículos.', 1),
(34, 4, 'Vidrio y Cerámica', 'Familia profesional relacionada con vidrio y cerámica.', 1),
(35, 5, 'Actividades Físicas y Deportivas', 'Familia profesional relacionada con actividades físicas y deportivas.', 1),
(36, 5, 'Administración y Gestión', 'Familia profesional relacionada con administración y gestión.', 1),
(37, 5, 'Agraria', 'Familia profesional relacionada con actividades agrarias.', 1),
(38, 5, 'Artes Gráficas', 'Familia profesional relacionada con artes gráficas.', 1),
(39, 5, 'Comercio y Marketing', 'Familia profesional relacionada con comercio y marketing.', 1),
(40, 5, 'Edificación y Obra Civil', 'Familia profesional relacionada con edificación y obra civil.', 1),
(41, 5, 'Electricidad y Electrónica', 'Familia profesional relacionada con electricidad y electrónica.', 1),
(42, 5, 'Energía y Agua', 'Familia profesional relacionada con energía y agua.', 1),
(43, 5, 'Fabricación Mecánica', 'Familia profesional relacionada con fabricación mecánica.', 1),
(44, 5, 'Hostelería y Turismo', 'Familia profesional relacionada con hostelería y turismo.', 1),
(45, 5, 'Imagen Personal', 'Familia profesional relacionada con imagen personal.', 1),
(46, 5, 'Imagen y Sonido', 'Familia profesional relacionada con imagen y sonido.', 1),
(47, 5, 'Industrias Alimentarias', 'Familia profesional relacionada con industrias alimentarias.', 1),
(48, 5, 'Industrias Extractivas', 'Familia profesional relacionada con industrias extractivas.', 1),
(49, 5, 'Informática y Comunicaciones', 'Familia profesional relacionada con informática y comunicaciones.', 1),
(50, 5, 'Instalación y Mantenimiento', 'Familia profesional relacionada con instalación y mantenimiento.', 1),
(51, 5, 'Madera, Mueble y Corcho', 'Familia profesional relacionada con madera, mueble y corcho.', 1),
(52, 5, 'Marítimo-Pesquera', 'Familia profesional relacionada con actividades marítimo-pesqueras.', 1),
(53, 5, 'Química', 'Familia profesional relacionada con química.', 1),
(54, 5, 'Sanidad', 'Familia profesional relacionada con sanidad.', 1),
(55, 5, 'Seguridad y Medio Ambiente', 'Familia profesional relacionada con seguridad y medio ambiente.', 1),
(56, 5, 'Servicios Socioculturales y a la Comunidad', 'Familia profesional relacionada con servicios socioculturales y a la comunidad.', 1),
(57, 5, 'Textil, Confección y Piel', 'Familia profesional relacionada con textil, confección y piel.', 1),
(58, 5, 'Transporte y Mantenimiento de Vehículos', 'Familia profesional relacionada con transporte y mantenimiento de vehículos.', 1),
(59, 5, 'Vidrio y Cerámica', 'Familia profesional relacionada con vidrio y cerámica.', 1),
(60, 6, 'Actividades Físicas y Deportivas', 'Familia profesional relacionada con actividades físicas y deportivas.', 1),
(61, 6, 'Administración y Gestión', 'Familia profesional relacionada con administración y gestión.', 1),
(62, 6, 'Agraria', 'Familia profesional relacionada con actividades agrarias.', 1),
(63, 6, 'Artes Gráficas', 'Familia profesional relacionada con artes gráficas.', 1),
(64, 6, 'Comercio y Marketing', 'Familia profesional relacionada con comercio y marketing.', 1),
(65, 6, 'Edificación y Obra Civil', 'Familia profesional relacionada con edificación y obra civil.', 1),
(66, 6, 'Electricidad y Electrónica', 'Familia profesional relacionada con electricidad y electrónica.', 1),
(67, 6, 'Energía y Agua', 'Familia profesional relacionada con energía y agua.', 1),
(68, 6, 'Fabricación Mecánica', 'Familia profesional relacionada con fabricación mecánica.', 1),
(69, 6, 'Hostelería y Turismo', 'Familia profesional relacionada con hostelería y turismo.', 1),
(70, 6, 'Imagen Personal', 'Familia profesional relacionada con imagen personal.', 1),
(71, 6, 'Imagen y Sonido', 'Familia profesional relacionada con imagen y sonido.', 1),
(72, 6, 'Industrias Alimentarias', 'Familia profesional relacionada con industrias alimentarias.', 1),
(73, 6, 'Informática y Comunicaciones', 'Familia profesional relacionada con informática y comunicaciones.', 1),
(74, 6, 'Instalación y Mantenimiento', 'Familia profesional relacionada con instalación y mantenimiento.', 1),
(75, 6, 'Madera, Mueble y Corcho', 'Familia profesional relacionada con madera, mueble y corcho.', 1),
(76, 6, 'Marítimo-Pesquera', 'Familia profesional relacionada con actividades marítimo-pesqueras.', 1),
(77, 6, 'Química', 'Familia profesional relacionada con química.', 1),
(78, 6, 'Sanidad', 'Familia profesional relacionada con sanidad.', 1),
(79, 6, 'Seguridad y Medio Ambiente', 'Familia profesional relacionada con seguridad y medio ambiente.', 1),
(80, 6, 'Servicios Socioculturales y a la Comunidad', 'Familia profesional relacionada con servicios socioculturales y a la comunidad.', 1),
(81, 6, 'Textil, Confección y Piel', 'Familia profesional relacionada con textil, confección y piel.', 1),
(82, 6, 'Transporte y Mantenimiento de Vehículos', 'Familia profesional relacionada con transporte y mantenimiento de vehículos.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id` int(11) NOT NULL,
  `materia_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id`, `materia_id`, `titulo`, `descripcion`, `orden`, `activo`) VALUES
(1, 38, 'Las vocales', 'Aprendemos a reconocer y escribir las cinco vocales: a, e, i, o, u.', 1, 1),
(2, 38, 'Las consonantes', 'Introducción a las consonantes más comunes y su sonido.', 2, 1),
(3, 38, 'Primeras palabras', 'Formación de palabras sencillas combinando vocales y consonantes.', 3, 1),
(4, 38, 'Lectura de frases', 'Lectura comprensiva de frases cortas y sencillas.', 4, 1),
(5, 39, 'Los números del 1 al 10', 'Reconocimiento y escritura de los números del 1 al 10.', 1, 1),
(6, 39, 'Sumas sencillas', 'Introducción a la suma con números del 1 al 10.', 2, 1),
(7, 39, 'Restas básicas', 'Primeras restas con números pequeños.', 3, 1),
(8, 39, 'Formas geométricas', 'Reconocimiento de círculos, cuadrados y triángulos.', 4, 1),
(30, 38, 'Las vocales', 'Aprendemos a reconocer y escribir las cinco vocales: a, e, i, o, u.', 1, 1),
(31, 38, 'Las consonantes', 'Introducción a las consonantes más comunes y su sonido.', 2, 1),
(32, 38, 'Primeras palabras', 'Formación de palabras sencillas combinando vocales y consonantes.', 3, 1),
(33, 38, 'Lectura de frases', 'Lectura comprensiva de frases cortas y sencillas.', 4, 1),
(34, 39, 'Los números del 1 al 10', 'Reconocimiento y escritura de los números del 1 al 10.', 1, 1),
(35, 39, 'Sumas sencillas', 'Introducción a la suma con números del 1 al 10.', 2, 1),
(36, 39, 'Restas básicas', 'Primeras restas con números pequeños.', 3, 1),
(37, 39, 'Formas geométricas', 'Reconocimiento de círculos, cuadrados y triángulos.', 4, 1),
(38, 138, 'Números naturales', 'Propiedades y operaciones con números naturales.', 1, 1),
(39, 138, 'Números enteros', 'Introducción a los números negativos y operaciones.', 2, 1),
(40, 138, 'Fracciones', 'Concepto de fracción y operaciones básicas.', 3, 1),
(41, 138, 'Álgebra básica', 'Introducción a las expresiones algebraicas.', 4, 1),
(42, 138, 'Geometría plana', 'Figuras geométricas y cálculo de áreas.', 5, 1),
(43, 137, 'La comunicación', 'Elementos de la comunicación y tipos de textos.', 1, 1),
(44, 137, 'Clases de palabras', 'Sustantivos, adjetivos, verbos y determinantes.', 2, 1),
(45, 137, 'La oración simple', 'Estructura de la oración: sujeto y predicado.', 3, 1),
(46, 137, 'Géneros literarios', 'Introducción a la épica, lírica y dramática.', 4, 1),
(47, 139, 'La Tierra en el Universo', 'El sistema solar y la posición de la Tierra.', 1, 1),
(48, 139, 'La atmósfera', 'Composición y capas de la atmósfera terrestre.', 2, 1),
(49, 139, 'La hidrosfera', 'El agua en la Tierra: océanos, ríos y lagos.', 3, 1),
(50, 139, 'Los seres vivos', 'Características y clasificación de los seres vivos.', 4, 1),
(51, 142, 'Greetings and Introductions', 'Saludos y presentaciones en inglés.', 1, 1),
(52, 142, 'Family and Friends', 'Vocabulario sobre familia y amigos.', 2, 1),
(53, 142, 'Present Simple', 'El presente simple en inglés: afirmativo, negativo e interrogativo.', 3, 1),
(54, 142, 'Daily Routines', 'Rutinas diarias y expresiones de tiempo.', 4, 1),
(59, 140, 'La Tierra y su representación', 'Estudio de los mapas y la representación de la Tierra.', 1, 1),
(60, 140, 'El relieve terrestre', 'Las principales formas del relieve continental y oceánico.', 2, 1),
(61, 140, 'La Prehistoria', 'Desde los primeros homínidos hasta las primeras civilizaciones.', 3, 1),
(62, 141, 'Condición física y salud', 'Desarrollo de las capacidades físicas básicas.', 1, 1),
(63, 141, 'Juegos y deportes', 'Fundamentos técnicos y tácticos de diferentes deportes.', 2, 1),
(64, 145, 'Números reales', 'Propiedades y operaciones con números reales.', 1, 1),
(65, 145, 'Álgebra', 'Polinomios, ecuaciones e inecuaciones.', 2, 1),
(66, 145, 'Geometría', 'Vectores, rectas y planos en el espacio.', 3, 1),
(67, 146, 'Leyes fundamentales de la química', 'Leyes ponderales y volumétricas.', 1, 1),
(68, 146, 'Cinemática', 'Estudio del movimiento.', 2, 1),
(69, 146, 'Dinámica', 'Fuerzas y leyes de Newton.', 3, 1),
(70, 161, 'El alfabeto latino', 'Origen y evolución del alfabeto latino.', 1, 1),
(71, 161, 'Morfología nominal', 'Declinaciones y casos.', 2, 1),
(72, 161, 'Morfología verbal', 'Conjugaciones y tiempos verbales.', 3, 1),
(73, 179, 'El Antiguo Régimen', 'Características políticas, económicas y sociales.', 1, 1),
(74, 179, 'Las revoluciones industriales', 'Causas y consecuencias de la industrialización.', 2, 1),
(75, 179, 'La Primera Guerra Mundial', 'Causas, desarrollo y consecuencias.', 3, 1),
(76, 177, 'Arte en la Prehistoria', 'Manifestaciones artísticas prehistóricas.', 1, 1),
(77, 177, 'Arte en Mesopotamia y Egipto', 'Características y obras principales.', 2, 1),
(78, 177, 'Arte clásico: Grecia y Roma', 'Arquitectura, escultura y pintura.', 3, 1),
(79, 181, 'Materiales y técnicas', 'Conocimiento y uso de diferentes materiales de dibujo.', 1, 1),
(80, 181, 'La línea y la forma', 'Estudio de la línea como elemento configurador de la forma.', 2, 1),
(81, 181, 'La composición', 'Principios de la composición y organización espacial.', 3, 1),
(82, 7, 'Montaje y mantenimiento de equipos', 'Componentes de un ordenador y su ensamblaje.', 1, 1),
(83, 7, 'Sistemas operativos monopuesto', 'Instalación y configuración de sistemas operativos.', 2, 1),
(84, 7, 'Redes locales', 'Diseño e implementación de redes de área local.', 3, 1),
(85, 22, 'Mecánica clásica', 'Leyes de Newton y aplicaciones.', 1, 1),
(86, 22, 'Termodinámica', 'Principios y leyes de la termodinámica.', 2, 1),
(87, 22, 'Electromagnetismo', 'Campos eléctricos y magnéticos.', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `tipo` enum('alumno','profesor','admin') NOT NULL,
  `identificador` varchar(20) NOT NULL COMMENT 'NIA para alumnos, DNI para profesores y admins',
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `identificador`, `nombre`, `apellidos`, `email`, `password`, `foto`, `fecha_registro`, `activo`) VALUES
(1, 'admin', '00000000A', 'Admin', 'Sistema', 'admin@babelium.edu', '$2y$10$Qggb/0MNdlLfCakJA7jlX.H71M6ECc..Et4zeo7q8m4SGC.0hn3kG', NULL, '2025-06-04 07:10:59', 1),
(2, 'profesor', '12345678B', 'María', 'García López', 'profesor@babelium.edu', '$2y$10$LL5uwye6xgWvMjbmNOQBCeQCQ2BHTnkWksU9o.LpzLCsn4jWXj.S2', NULL, '2025-06-04 07:41:05', 1),
(3, 'alumno', 'ALU001234', 'Juan', 'Pérez Martínez', 'alumno@babelium.edu', '$2y$10$szmo2xxAnc4NykksAm36KO5DPDwfs/axWHfmgmPKHwwEH73LF.Y8K', NULL, '2025-06-04 07:41:05', 1),
(5, 'alumno', '54289804Y', 'Douglas Alexis', 'Largo Moreno', 'malfidos30@gmail.com', '$2y$10$NtvhLwHZHeRRd9RhGGnd0ejs.5zgiMMpXS6ytbx59Rs6iW1ISTCmi', NULL, '2025-06-04 07:47:35', 1),
(10, 'alumno', '65473828J', 'Nicolle', 'LArgo Moreno', 'nicolle.94@gmail.com', '$2y$10$i6ufkh9dq.r5Y3q88IJHw.lNtkbbTNyTIxJiw0A6EYyGn.gYPtjf2', NULL, '2025-06-04 10:46:55', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valores_campos_dinamicos`
--

CREATE TABLE `valores_campos_dinamicos` (
  `id` int(11) NOT NULL,
  `campo_id` int(11) NOT NULL,
  `valor` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `creador_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones_profesor`
--
ALTER TABLE `asignaciones_profesor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profesor_id` (`profesor_id`,`materia_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indices de la tabla `campos_dinamicos`
--
ALTER TABLE `campos_dinamicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `contenido_id` (`contenido_id`);

--
-- Indices de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tema_id` (`tema_id`),
  ADD KEY `creador_id` (`creador_id`),
  ADD KEY `idx_contenidos_tipo` (`tipo`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nivel_id` (`nivel_id`,`nombre`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `modalidad_curso_id` (`modalidad_curso_id`,`nombre`),
  ADD KEY `idx_materias_modalidad` (`modalidad_curso_id`),
  ADD KEY `nivel_id` (`nivel_id`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`modalidad_curso_id`),
  ADD KEY `modalidad_curso_id` (`modalidad_curso_id`);

--
-- Indices de la tabla `modalidades`
--
ALTER TABLE `modalidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `modalidades_curso`
--
ALTER TABLE `modalidades_curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rama_id` (`rama_id`),
  ADD KEY `idx_modalidades_curso` (`curso_id`,`rama_id`);

--
-- Indices de la tabla `niveles_educativos`
--
ALTER TABLE `niveles_educativos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `progreso_alumno`
--
ALTER TABLE `progreso_alumno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`contenido_id`),
  ADD KEY `contenido_id` (`contenido_id`);

--
-- Indices de la tabla `ramas`
--
ALTER TABLE `ramas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nivel_id` (`nivel_id`,`nombre`);

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_temas_materia` (`materia_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificador` (`identificador`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `tipo` (`tipo`,`identificador`),
  ADD KEY `idx_usuarios_tipo` (`tipo`);

--
-- Indices de la tabla `valores_campos_dinamicos`
--
ALTER TABLE `valores_campos_dinamicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campo_id` (`campo_id`),
  ADD KEY `creador_id` (`creador_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones_profesor`
--
ALTER TABLE `asignaciones_profesor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `campos_dinamicos`
--
ALTER TABLE `campos_dinamicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modalidades`
--
ALTER TABLE `modalidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modalidades_curso`
--
ALTER TABLE `modalidades_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT de la tabla `niveles_educativos`
--
ALTER TABLE `niveles_educativos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `progreso_alumno`
--
ALTER TABLE `progreso_alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ramas`
--
ALTER TABLE `ramas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `valores_campos_dinamicos`
--
ALTER TABLE `valores_campos_dinamicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones_profesor`
--
ALTER TABLE `asignaciones_profesor`
  ADD CONSTRAINT `asignaciones_profesor_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaciones_profesor_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`contenido_id`) REFERENCES `contenidos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD CONSTRAINT `contenidos_ibfk_1` FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contenidos_ibfk_2` FOREIGN KEY (`creador_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`nivel_id`) REFERENCES `niveles_educativos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `materias_ibfk_1` FOREIGN KEY (`modalidad_curso_id`) REFERENCES `modalidades_curso` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materias_ibfk_2` FOREIGN KEY (`nivel_id`) REFERENCES `niveles_educativos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`modalidad_curso_id`) REFERENCES `modalidades_curso` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `modalidades`
--
ALTER TABLE `modalidades`
  ADD CONSTRAINT `modalidades_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `modalidades_curso`
--
ALTER TABLE `modalidades_curso`
  ADD CONSTRAINT `modalidades_curso_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `modalidades_curso_ibfk_2` FOREIGN KEY (`rama_id`) REFERENCES `ramas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `progreso_alumno`
--
ALTER TABLE `progreso_alumno`
  ADD CONSTRAINT `progreso_alumno_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `progreso_alumno_ibfk_2` FOREIGN KEY (`contenido_id`) REFERENCES `contenidos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ramas`
--
ALTER TABLE `ramas`
  ADD CONSTRAINT `ramas_ibfk_1` FOREIGN KEY (`nivel_id`) REFERENCES `niveles_educativos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `temas`
--
ALTER TABLE `temas`
  ADD CONSTRAINT `temas_ibfk_1` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `valores_campos_dinamicos`
--
ALTER TABLE `valores_campos_dinamicos`
  ADD CONSTRAINT `valores_campos_dinamicos_ibfk_1` FOREIGN KEY (`campo_id`) REFERENCES `campos_dinamicos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `valores_campos_dinamicos_ibfk_2` FOREIGN KEY (`creador_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
