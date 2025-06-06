-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2025 a las 09:00:19
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
  `foto` longblob DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1,
  `rol` varchar(50) DEFAULT 'usuario',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `biografia` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `tipo`, `identificador`, `nombre`, `apellidos`, `email`, `password`, `foto`, `fecha_registro`, `activo`, `rol`, `fecha_creacion`, `fecha_actualizacion`, `telefono`, `direccion`, `biografia`) VALUES
(1, 'admin', '00000000A', 'Douglas', 'Largo', 'admin@babelium.edu', '$2y$10$Qggb/0MNdlLfCakJA7jlX.H71M6ECc..Et4zeo7q8m4SGC.0hn3kG', 0xffd8ffe000104a46494600010100000100010000ffdb0043000503040404030504040405050506070c08070707070f0b0b090c110f1212110f111113161c1713141a1511111821181a1d1d1f1f1f13172224221e241c1e1f1effdb0043010505050706070e08080e1e1411141e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1e1effc00011080190019003012200021101031101ffc4001f0000010501010101010100000000000000000102030405060708090a0bffc400b5100002010303020403050504040000017d01020300041105122131410613516107227114328191a1082342b1c11552d1f02433627282090a161718191a25262728292a3435363738393a434445464748494a535455565758595a636465666768696a737475767778797a838485868788898a92939495969798999aa2a3a4a5a6a7a8a9aab2b3b4b5b6b7b8b9bac2c3c4c5c6c7c8c9cad2d3d4d5d6d7d8d9dae1e2e3e4e5e6e7e8e9eaf1f2f3f4f5f6f7f8f9faffc4001f0100030101010101010101010000000000000102030405060708090a0bffc400b51100020102040403040705040400010277000102031104052131061241510761711322328108144291a1b1c109233352f0156272d10a162434e125f11718191a262728292a35363738393a434445464748494a535455565758595a636465666768696a737475767778797a82838485868788898a92939495969798999aa2a3a4a5a6a7a8a9aab2b3b4b5b6b7b8b9bac2c3c4c5c6c7c8c9cad2d3d4d5d6d7d8d9dae2e3e4e5e6e7e8e9eaf2f3f4f5f6f7f8f9faffda000c03010002110311003f00fb2e8a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a2909006490280168acfd4759d3b4f89a5baba8a35519259b1582de37b79a5d9a7e9da85e75f9e3b7609ff7d1c0ac6b6268d057ab251f5761a4dec75d4571e9e20f105c46cc9a28b66fe11713af3ff7ce6a95dc9e32baff0057a9699623da1798ff003515e2d6e29ca693b3ae9bf2d7f2345466fa1dee47a8a69741d587e75e736fa5f8ac16373e2fdf93c08ec5576fe64d57b9f0df882794c87c6fa94608fba96f1003f4af3e5c739447edb7f265ac35467a70743d187e74ec8f515e56be1bf1444e5e1f1d5eb1c602cd691328f7e0039fc68874cf8856a59a2f18585df70b71a715c7e28ffd2b4a5c6d93d4dea5bd5325d0a8ba1ea94579d5aeade3eb451f6ad3b4bbd00726dee8ab31f657503f5a9078fb53b438d57c29abdb2ff7d235997eb98c9af5b0f9f65b89fe1568bf9dbf321d39add1e834579fe9ff00173c197375f6493548ed2e376df2ee54c2d9ff0081815d969fabe9f7d12cb6b7514a8e32acac083f435eac64a4ae9905ea290107a1a5a6014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514c9644890b3b0007ad003ea39a78a152d238503d4d72f75e2996f2e64b5d12d8dc6c3b5ee5fe5854fa06fe23ec33519b79663bef26370fe87841f41fe39af99cdf8af01965e129734ff00957eaf646d4e84a7aad8d6bad750ee5b18ccee3bf45fceb26e4ea17bff001f37af121fe0838ffc78f3fcaa6db8f61db14a10b36141627b0afce331e36ccf1b2e4a1fbb4f64b77f3dfeeb1d71c3421b952db4eb3b73ba28177f791c9663f52726ad00c3d87e95721d3e79382020f7ab31e92a3efca7f0ae1a3c379c662f9dd37af593b7e7729d6a70d2e660e38e297be6b6174c8075dc7ea69ffd9d6dfdcfd6bd3870066725ef38af991f5b87998878a33ce2b6ce9d6dfdcfd69afa6db91c6e1f4344b803335f0ca2fe61f5b87631b341f6ad2934a1ff002ce4c7d466a0934fb84e855fe95e5e2b84f36c3af7a937e9665aaf4e5d4a840229ad81c0cfe74f916488e248d97dcd37208f6af9d9d29539f24e366ba3567f89b7327b14754d2f4dd56036fa9585ade42df792784383f9d72127c31d2ec26371e15d4f53f0dcd9dc23b598bdb93ef13e571f4c577a003eb411dbb576e0b35c660df361ea38fa3d3eed899538cb747150eb9f113c31cea7a6c3e21b15eb71a6fcb32afab42c727fe024fd2baff0b7c40f0f6bc5a1b7bd8c5cc7c4b03fcb2467d194f23f2a94a0ff00039ae7bc5de0bf0ff89903ea565b2ed4623bdb6730dc47f475e7f03c57dd655e20558350c6c799775bfddb1cd3c2a7f09e8f14b1cab9470c3d8d3ebc16ce5f885f0e6eb75d5ccde2cf0d2ffcbc2a62f6d47fd3451feb147a8e7dabd77c2de27d375fb08eeacae63951d720a9cd7e9380cc70d9852f6b879a92fc57aa38e517176923768a01cf4a2bb890a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28accd7b56874cb432312cec76a228cb3b1e800ee6a652514e52764806f8875dd3f44b23737d3ac6b90aa3ab3b1e8aa07249f415cc4e750d75fccd44b5ad9372968ad8771ff004d08e9fee8fc7d2ab695a55dcfa81d675e9a3b8d4ce7c98d4e61b353fc280f56c757ea7b6056d04da73bb8afc9f8978d2759cb0d8195a3b396cdfa79799df470d6f7a424712451aa46aa88a30aaa30147a01daa40198844059bdaac59d9c970dc8da9ea7bd6bdbdac5026d8d467d6bc6c93847159a7ef6a7b907bbeafd179f76554af186db99d6ba6b31cccc541fe115a50dbc51711a01f854a060e696bf56caf87f0396c57b186bddeafefe9f238a75653dc31ce69451466bdb4662d14993485aa8075069bbfd8d26f149b48079a6918a378a46718ef52e4876623a06186008f7154ee34d824f99728dedd2ae6ff6a50735c38ccb7098e872e229a92f3435370d8c29ed6783ef2ee5fef0aae0f3eb5d230c8c551bbd395fe78b08ddfd0d7e719d7024a09d4c0be65fcbd7e4fafcceba7895b4cca0734119a74b1b44fb645da7f9d257e715294e94dc2a2b35d1e8765f4d08d873924e7d6b89f1078326b7d59bc47e0fb95d37553cdc5b648b5bdff7d47dc7f471f8e6bb9e71ef4ddbc738aedcbf31c4602afb5c3cb95fe0fd7b9328292b4b529f80bc5e9abc4d697d0c967a840db27b798619187f31e847045768082335e7faf68697ce97968e2d751846219c771fdd7f55fe5dab47c1de266ba91f4cd493ecf7f6e76c91b1fd47a83d8d7edbc39c494739a56f86a2dd7eabbafc8f3ab5174df91d851480f1914b5f4a6214514500145145001451450014514500145145001451450014514500145145001451450014514500145151cd22c7197620002802aeb3a8c1a6d93dccec15547e27d80f5ae5ed229eeae86a5a80c4ec0f951139f214f6ff0078f73f8523ccdacea42f9ce6ce06c5b2f6771c17fa0e83df27d2af74393d3f9d7e4dc69c4cea4de070efdd5f135d5f6f45d7bb3bb0f46def481976f5c63d2afd85899312ccb81fc2b4ed32d379134abc7f0e6b51460f157c29c231a918e331b1d37517d7cdfe889af88d79620a817181c0a75069ace1572c401f5afd47dda71ec91c9b8e3464551b8d4624caa7cededd2a84d797329203045f6af98ccf8c32ec0fbbcdcf2ed1d7f1d8d61427236659e28c65dc2fd4d549b52841fdd82ff4ac8c13c9627f1a5c57c4e3bc40c655d30d0505e7abff0023a63858af88bcfaa4ac7088a07bd42d7b74c7ef803d8541457ce62389334aff001d697c9dbf23654a9ae83da79dbacadf9d34b487ac8ff9d2515e54f1988a8ef39b7ead9a282ec197ff009e8ff9d1b9c7fcb47fce8a2a3db4ff0099fdeffcc395761c25987495c7e34e17572bcf9a4fd6a3a2b7a79862e9fc1564bd1b13847aa2caea3703a9523dc54a354707e78c11ec6a8d21af528713e6d476aedfaebf999ba34df43464bcb5b94db2a95f7f4aa32a2a37c920910f434c201eb42a851803158e659dd5cca29e2211735f692b3f9f465429726cc5a28a2bc666a230c8ac3f13e8f25f2c77962e21d4ed813049d030ebe5b7fb27f435b98e7348c09e8457560f195b075e35a8cad28bd3fe09124a4acc8fc07e254d5ed0c33a986ee12639a27e191c7506bab06bcafc596b3e8f791f8a74d525a2c0d4235fe38ffe7a63d57bfb7d2bd0bc3daa43aae9b15cc2e183283c1afdfb22ce29e6d848d78e8faaecff00cbb1e5d4a6e0ec69d1494b5ec99851451400514514005145140051451400514514005145140051451400514514005145213400572fe2ebc92e678b45b572ad302d338fe08c753f53d07d7dab7f51b98ed2ce4b89582aa29249ed5c868c259849a94e0896f087c1fe18ff00817f2e7ea6be678af38feccc0b707efcf48feafe5f99b50a7cf2d4bd0c490a2c71aaa46800550380076abba75b79f2ee61fbb5fd4d578d1a5916351924e3e95bd6f1086354503e5afcdf83b23fed2c4bc45657a707f7bedfe675e22a722b2240817a7029738e69934ab1a9673802b22f2f9e63b223b13d41eb5fa76739ee1328a77a8ef2e915bffc0471d3a72a85ebbbf8e23b17e77f415973cf2cb93237cbd80a8f1ed4b5f90e73c4f8dcce4e32972c3b2dbe7dcefa742301bc1ed8a51c74a5a2be73adfa9b6a145145318514514005145140051451400514514005145140051451400514514005068a0d0c191caa194a90181e083d08ae47c2574fe14f16cbe1f9598585c0f3ac598f1b09e53eaa78fa62bb12324572bf1234f96e7468eeed066fac64fb44181cb607cc9f88cfe38afa7e14ce7fb2f1c949fb93b27fa3f93fc0e7ad4fda47cd1e9c8c1d430e869d5cdfc3fd6e2d6b4082e11c31280d7495fbc9e60b4520a5a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a00434514d91822331ec280394f1c4c6f2e6d3444276dc3ee9f1ff003c97961f8f0bf8d48ab8acdb0737facea3a93740ff0066849f45e588fab1c7fc06b55773b841d4f4afc438cf1d2c7668e8c7551b452f3ebf89e8e1d7242e6968f0820cc47278156eeae1208f7330cf61eb51bcab696c338e0703d4d64cd23cd2177fc057d463735a5c3396c307475aad6be4deedfe862a0eb4f99ec2dccf2dc3e5ce0765a8c0c518e73457e5788c455c4d5756abbc9f57b9dd18a82b2168a28ac8a0a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800aa1ac9c4098ebbaafd67eb7831460e7ef6693d8ba77e656394f015d9f0f78daf74466db6b707ed36be811cf2bf83647e55ebea4150477af10f1da3da8d3bc410fdfb0b80b2e3fe7948403f936d35ebfe1dbc5bed2609d4e7728afdef84b33fed0cae9ce4ef28fbafe5fe6ac7958ba5eceabeccd1a051457d31cc2d14514005145140051451400514514005145140051451400521a5a4a002b2bc577cba7e857574c70238d9bf215ab5c77c4e613585ae9dc1fb55c468c3d57765bf406b9f155d61e84eb3fb29bfb95ca8479a4914fc2d11b6d0ad6271fbcdbba4e73f3b7ccdfa935b96385b8f31f8541b89acdd28f990bffbe4d5d03823b1eb5fce787c6ba78b58a92bbbf37cff00e1cf5ea4357144975335c4a5d8fcbfc23d2a319ee681c52d6188c454c4d5956a8ef26ef708c54559051451591414514500145145001451450014514500145145001451450014514500145145001451450014514500145145001599ad9ff543bf26b4fa563eaefbae02ff0074544f634a5f1a32755b28f51d2aef4f93a5cc2d17d091c1fc0e2af7c0ed59ef7c351c131fdf4398dc1ea19783fad443820fa73587f0de5fec9f88dade93f7627985c463fd99006fe79afd1fc38c672e22b615ecd732f54ecff3fc0e7cce0ad191ecd45252d7eb879002969294500145145001451450014514500145145001451450021a28a2800ae0fc6ce27f15584279f222966c7b85da3ff42aeeebcdf5a9166f19df1ce4c36a8839e9b9c9ff00d96be6f8baafb2c9abbeeadf7bb1d3848f3568a2fe8b262574f51902b56b9fb493cab94909e01adf072057e030d8f5ebab4ae2d145154641451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145260c435837cfbee9c8f5c56e4ee23899d8e0015ce924924f53532d4df0eaf7606b97d4a4fb07c50d1af07ca2f2ccc4c7de36ff06aea2b91f890de45d7872fc70d1ea06227d9d09fe6a2be93832bfb1ce28b6f7bafbd3fd6c18e8f3507e47ba5bb6f811bd40a92a8e87279ba5c0fea82af57efe7ce85028a280168a28a0028a28a0028a28a0028a28a0028a28340094514500237435e6122e7c4faccbdc98533f40c7fad7a73f08df4af2e8893adeb4c72737283e988c57c671ecad934977947f33b300af5d167eb5b5a64de65b804e5978358a7daac584e209c127e56e0d7e1b17667b75a3cd13768a40411914b5a9c614514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451487a1a04d94358976c2231d58d651a9efa5f3ae588fbabc0a82b267752872c42b92f8afc7872ca5c731ea70107eb91fd6badae4fe2c11ff0008ac0bddb51b703fefaaf63875b59ae1edfcebf32315fc197a1ebde106dfa0db13fdc15b1589e0b18f0fdb0ff6056dd7f469f341451450028a29052d0014514500145145001451450014869690d0014514500364fb8df4af2d8030d6f5b52303ed3191ee367ff5abd4cf43f4af2f9814f14eb31b6003e4b8f5fe31fd2be3b8ee1cf93cbca51fccecc03b5744f471de8a2bf0a3e84d4d2ae77af90c72cbf74fa8ad0e723deb9c8dda375653820d6ed9dc0b88830fbc3861e9571671d6a7caee89e8a28ab31b8514521e9c5002d149ba8ebd280b8b451cf7a2800a28a307da95c028a28a6170a28a427147a80b452020d2d2b80514d2dce0726941c923b8a77402d14514005145140087daaaea73f956e429f9df85ab2ec141627000c9358379319ee0bf61f77e952d9a52873322cf38a28ef9a2b33b76415c77c5760746d2e13d65d562007ae031aec7b715c57c4b7f3b56f0bd80e4bdec92918ecab8fe6d5f41c2b4bdae6f417695fee5739f18ed4247b4f84d766856e3fd815ad547434f2f4b817fd8157abfa18f9b0a28a280014b494b4005145140051451400514514005252d2500145145002579aebb1983c753ae00171664fd4a303fc98d7a5d79f7c428cdb788f48be1c2b4c60738ea1d481faedaf0789f0cf1394d78477e5bfddafe86f86972d58b2b514608e3d28f7c1031debf9dcfa60a96da678250e9cff787ad4545171349ab33a082649a31221041a96b02d2e1ede5dcbc83f787ad6d41324d18743906b48bb9c3529b83d09691ba1a5a46e86aae66d9c2fc61f18de783b44b3bbb08a096e2e2e447b6504aed0326b88d33e3d138fed1f0f83ead6f3ff435de78c921bcf12416d731473470d9b314750c32cc00383f435ca6a7e06f0b6a04b49a6240e7f8e16295f7394e5384af8284ab42f2676d1a0a50bb342cfe37f846503ed10ea16cde862ddfcab72c3e2a7812ec0dbafc1131fe1954a915e55ae7c2fd2add7ccb5d62ea02c76c7148824dc7d063935cd5f7c39f13dbc2d30b78668d4f215fe755f52bfd2ba6a70be065f0b6be7ff0025864b63e90b5f197856e4660f1069cdff6d80fe757e2d734698663d5ac587b4ebfe35f285c7823c4891aca34679a3719578486047e159b3689aa5bfcb2e93791fd6135cf2e12a0fe1aafee44fd5bccfb17fb574cc67fb4acff00effaff008d472eb7a3c6bb9f55b251ef3aff008d7c68d04919c3c3227fbca45444463838fc6a5707d3ff009fafeeff00822fab799f61dc78c3c2d6e3336bfa720ffaec2b22ff00e28781ad01ddaec1291da352d5f290f27b04a7298f3b54a8ada1c25865f14dbfb86b0c9753e8ebef8e1e1184136b05fdd1ed88b683f9d737aafc78b8704699e1f44cfdd69e5cfe82bc48ceac7f771bc9db2aa4d5ab5b6bab900db5adccc0ff00722279f7aeea5c378086f1bfabff00862a3422765ae7c57f1c6a48eaba92592153c5b4614fe75f437c3bbf7d4fc13a45f4b234b24b6cbbdd8e4b30e0935f2e59784bc4d7ac3c9d16eb078dcebb47eb5f48fc1bb7bcb1f015969d7e8a97368cf148a1b207391cfd0d799c4d84a14b0b174e296bd08af08c62ac8eca8a28af863982909c504e2b3f52bddb98623f37f11f4a96c718b9bb222d4eeb7b18633c0fbc477aa141a2b3677c22a0ac82a3ba492481d6198c1211f2c81436dfc0f5a92a96ad793d8a473269f3de419fdf98082f1afa85fe21ec2ae946529a51dc6dd95c856f6e6c9962d5c45b1d804bb88623663d030fe03fa573bad8fb7fc5ed1ec40c8b2b1f30fa6646cff25aebad66b3d52c55e231dd5b4e0ab823208fee907a1fad723f0874e8eebe226b7771cb2cf6f05c9b7b7691b7158d3e50a0fa03902bef38130b1ad99bab2569413d3a6ba7ea79b8f9f2d2496ccf7ab55d96d1afa28a96900c00296bf673c50a28a2800a5a4a5a0028a28a0028a28a0028a28a002929692800a28a2800ae43e2a594973e1b965801f3a1c4a847f794ee1fcabafaabaa5badcd8cb0b0cee522a6705522e12d9e834ecee799cd7c248a06b4459a7bb8c491267002919dcc7b0152d9c33448c6e2e9ee26739638c2afb28ec2b3bc3f6d069a3538256db2db4e77bc8f9222c65719e8a39fc4558b3927d4196ecb3c3679cc09d1a51fde6f45f415fcdf99609e0f13570ed69076f5ed6f91f4946a29c54ba9a19a2903a991a356059796507257ebe94b5e5b4d1d0152daccf6f26e43c775ec6a2a284df406935637adae5274ca90187507b54c79e315c9ea9a9c1a3e9f2ea573232c508ce17ef331e1547a927815892f8abc5d62bfdb3a8d9e9cba6ae1e6b08831b88a2eefbf382c3a918ec6bd4c065988c6d394e94744714e83bbe52f6acc66f16ea2dda38628ff0099a8e4748a379246d888a599bd00a89674bad5b54b98983a3dc2ed23baec183fad3ae618ae23304c3721232b9c671cd7e8596c3d9e12926ba2b9df455a091574d8da697fb4ae1089a41fba43cf931f61f53d49abd9c1c8cfbf341fc3f2a2bbadd4d4a16aa6cb526b55c8b7ba0648573c238fbc83d8f502b47712304823b03547588ddacfce887ef6d984c9ef8ea3f2cd5a865496049633b91d438fc680481e289c61e18587bc6a7fa541269da6c830fa759b77e615ff000ab3452d4124513a3e8f824e93647fed88aa173a569579786c23d32d1218b06e9d6200927a463df1c9ad0d72fd74cd2a6bc61b9970b127f7e4270abf9d3f4ab46b2b08e2918b4e7e79df3f7a43cb1fcf8fc2a93f76e2ddd87c767671a858acad23dbc00b128c0ec3a54118367ac8112aac57aa4950a0012af71ee47f2abc3818e0d472431c8d1b3ae5a36dc87d0f4cd09bbea3b126720e73f535b7e0c6c1be8b3c09030fc47ff5ab0f9fa9ed53d8eb369a147a96a17c5842914670a32cec490a8a3bb135e2e794a55706e3157775f9986295e99db1cf6141603a9ae0a1f1aeb36734571e20d1a0b3d327709be29b7496b93f2f9a3a60f4247435d1ddde493fca30a9d383d6be131b81af82928d6566ce154a52762c5fdf6418e03c742d59bfccf5a28ae06ceb841415905145148b0a0123a71fce8a072c06339f4a35e82660f89e43a069b7de23b144dd0c25ee20ced59bd187a3038fad687ecf3a33d9f8712eae07efa6cc8e4f763c935ca7c58b97b91a4785edce64d46e44b381ff003c6339fd5b1f91af69f07582e9fa1dbc0140c20afda3c3ec13a78196267bcdd97f856df8dcf0f319dea72ae86d514515f7c79e1451450014b494b400514514005145140051451400521a5a43400514514005276c52d1401e57f1174858bc4369712314b1bb9162bb5fe1719ca03edbb1f9d47a95d4cb749a6da63edb2824b11c4118e0b9f7f415de78cf488b57d1a7b691739538f6af3af0b2c9e4de35d4865d47cf2b76c463a709f815e7eb9afcb38ff2be49c7308edf0b5e7d1bfcbe48f572eabbd3668d9db436917970827272f2372f237f798fa9a9a8ec0761d0515f96ca4e52bb7a9ec25641477a2a1bcba8ececee2f26ff00576f134adf4519fe94462e4d25d44739a837f6bf8b92d4e1ac34602461fc325d30f941ff0071727f1aada7f8a3c3dad6b373e1fb7bc135c6d6470c3e593821b07bd61ebba94da0fc3196fd9b6ea5aa319093d7cc9493fa2d78de8b792695abdaea1131df6ee24ce7938ebf9d7ebf9760d61b0d1a6ba6fe6fab1a7667bc7c21b25d4ecac6c755ba912d638eeae27659366e11b85425bb00335a9a5dde9babadcdcf8335fb5f15595bb959a28a41f6b831e83f8c7e5f5ae77c2c5d7e1cea972990cfe16bb997eaed9af8c7c39abea9a0dec1a9e89a85ce9d7910dcb35bc851bf1c751ec6beeb2ac9a963b08d3566b67f33e7f198ea986aeacfb7e47df36b7105d02d0481b070c8410e87d194f20d4bd6bc8fe08fc5f97e246b30785fc55a2b1d77c96921d6f4cc248ea8324c89d18ff3f4af58b94bdb083cfba097b640e0df5aa9c2ff00d748faa1f53d3e95e1e6191d7c1c9d95d1ea61333a75d5a5a3241d6a8e943c896e74ff00e185bcc887fb0dcfe878ab91ba491ac91baba30c8656c823d8d53d4b36d736b7eb8c2379337ba3743f4079af1bc8f4fccbd475eb477c641f5c521748d5a495b6a2296624761c9a40da4733aa4cba9fc40d3f471cc1a642750b819e3cc3c460fd3935d39e7393cd79efc24b96d5f55f126bf2824dddc8080f641d07d315e82480a5c9014672c4e00aa968ec4c76e662fe19a6c8e9144d2caeb1c6a3259ce07e7500b9926b796e6d5614b3873e75fddc9e55ac63d771fbdf415e51e37f8e1e13f0f4f245e1c88f8c75a4040bcb95f2f4fb76ff00613abe3d7f5af4f039362716ef15647162f32a58756bdd9ec7a4d96afadb01a45a2a5b9eb79760ac67fdc5eadf5e057357625b8f1668b15daa83149728f12f31b4d1fdd6e7d3923d2be70f0a7c4df1a6b3f187c39adeb7e23bc973a9428d124863856366c15541c05c57bd7c6ab8b9d1ae6faeec2511cb16b12c41bbaacb12e71f9d7a39ae4f1c0538addb670e0b1f3c5d4927a2468ea7e32f09ff006c7fc2357b72d3bdce619709ba3c9e0a96f5feb5bbe0bb99d2dee742be937dde94c23573d65b76e627fcbe53f4af98a552666704ee55c827ae739fcebdebc2bab8b88bc31e23247fa4a1d32f8fb91f213f88af8ce21c0ac5e0e57f8a3ef2fd4f51def73d0c52d295da4a9392292bf275a1414506954679e48f6ef40094a31dc851fc44f61dcd2640e4f02b8df8a9ab4d6fa543e1eb073fda7ac661014f31439f9dfdb3f747d6bbb2ec054cc3150c352d5c9fe1d5fc91956a8a941c990fc37b76f18fc42bef133293651b0b7b2cf6893a11f5393f8d7d011a848d50740315c7fc2bf0ec5a0f876de058c29082bb2afe91c261a9e12842852568c5248f999cdce4e4fa8514515d0485145140052d20a5a0028a28a0028a28a0028a28a00290d2d0680128a28a0028a28a004619520f7af33f1cd8be85ac8d7208d8dac83cbbc451d533c37d54f3f4cd7a6d53d5ac62bfb292de550c1811c8ae5c6e0e96370f3c3d6578c9599509b849491c0060406465752010ca72194f423da96b26dd26d0356fec1bc27ecb231fb04a7a29273e513ffa0fe5e95ac41e402091d457f3be7194d5ca714f0f556db3eeba33e928578d58a92f980ac0f882ec3c257712939b8922b7ff00bedc03fa66b564bc41a8c7611a34b2b279926de90af62df5ec2b27e209dbe1f8df9da97b6e58ff00db40335965b4ef8ca4a6b4725f99ab77d0f37f8f572565d234e5c848d5a42bf4c28fe55e5375f2c4cfe88dfcabd33e3dab7fc2436121c856b72a3ea1abccaf798a55f54c0fc78afd829aba45bd0fa134667d27c2da5cefa79d474e9349167aa5aa1c4bf6775e5e3f52bdc7715f327c6bf85571e05920d6f45ba3abf83efceeb0d41067cacffcb297d187407bd7d71609e4e9d671a8c18ede351ed851595796b1e951dea9d31354f0dea4a46afa395cf07acd08ece3a951d7a8e6bdbc933b960e7ece7f0dcf2f32cb1568f3c773e7bfd8a901f8f7627d2ca723dbe5afb33ec893f8ff005968de48192c21398ce0124b1e4743f8d785fc18f8531f81fe37d8f8a7c3d7a9a9782f53b39458ddeef9a076c6217f7e0807f03cd7bcda311e33f14499184b2847fe3ac6bea31b5a35aaf345ee91e05284a11e567cff00e11f8bde0bf10ebd77a55ec8be0dd763bb9230ee7769f78cac464ffcf327f0af43bedcb09b3d5a016a6e136a4cae1ede707a18e4e87d71d6be0ad6984bacea2e4677de4ac7dfe735ddfc32f8c1e2cf03c634d12c7ad680ec04ba56a19923033d509e50fd38acb31e19a35e3cf4f476d4e8c266f528cb965aa3eb3d3afa699a1b52804d1291764ff09538007a93d6b03c7daa1d23c29af44d27efa460906e3c9593d3e9cd765e13f06da5feb5abcba76aba869d6d22dacc20565936978b760330278cd1e24f86fa54de23d1ff00b72f2ef59b68e3b8945b4fb51199137296da013cd7c94725aca76be87b6f35a7cb74b53cdbe08b5c2f862fdececda54171bbcf9488a04403059a46e001ed935e89e0bb7d23c5b1dddce9ba95af8856ca530cd2212b630ca06768039948c8e4f15f1cfc46f895e2df19cb2596a37cb69a3c32325be9760be4dac6a1881951f78f1d4e6be92fd80a757f00f88ec570be56a81828ec1a35afa3a590d3c252f6b2d59e455cd275e6e0b4467fed4d6d26a5fb3ae93afcf3492dcb5ec2d285f9234077295541c05cf6af925158b24688ccccdb511464927a00057db9f16b42bfd7ff0066fd4340d22d24bbd4975468ad6dd7efbb25c1181f87e55c47c38f86d65f0eaf230f0d9ebbf10dd03b6f1becf4443d1dbfbd27a0ee6bd2a38ea584c339cdea70cf0d3c4555189c7fc2ff00850fa34b61ad78aec9ae75e9b6cfa56801b6f92072b717647dc41d42f535e95f162c6e97e1ecf35fde1bebe6bd8e7b9b92bb77b938e076503000f415d868da645a6acced7125edf5cb799777d3732dcbfa93d80eca381591f14e1337c3cd6147558849f9115f0f9966d571f57de7a23ea7058086169dfed33c0d4eedcc70724fe95e8ff0f64697e1b6bb68092f613a5dc5ea08607fc6bcde329f77a1fbdf857a17c2a257c3fe2c2cc367d8c66b864b9d5bbfea753d8f788e513c31ce0f12a2b8fa119a5aa7a26468961bbafd962cff00df02ae724e3207d6bf12a968c9b5dd8d6c1918e4e05646ad6b7f6d7dfdada6c924ac140bab266ca4e83ba7f75c7b75abda7df5adf7da3ecf26f36d3186742305187623d08efdeb3f4e91f4ad49748b8959ad66dd2584f23f231cb44cc7baf507d3e95d34232849a5bae9dd75339fbde85bb9d5f4db5d0a5d6ee2e4269f1c665793bffbb8fef678c7ad735f09b44bdf15789ee3c65acc051a7205bc47a4310fba83f0ebee4d60c76d27c41f17bd9694f28f0cc1702565c612e671c1900feefa0ee79afa23c3ba541a4e9d15b428142a81c57ec7c1bc3ab2fa4f15557bf3d9758aedeafa9e263712eacb956c8d0890471845180053e8a2bee0e10a28a2800a28a280014b40a2800a28a2800a28a2800a28a2800a28a280128a0d14005145140051451401cff8cfc3b6baee9af04a9f363823a83ea2bcd5f57bad1525d3f595325fc236dab91c5d9ce1413d9b38cfaf5af69ae73c67e18b3d7ac5e3923024c65587041ec41af173bc8f0d9bd1f67556ab67d57fc07d51bd0af2a32ba386b68d345d2a6bbbe90b4e7f7d792639790f451ec38502ab78aa29350f055e24b18b79e4b70e88cd9db203b9573eb902b3efdf51b3d5ec34af13c8ab6504be60bc61c4ec3fd5acbe98e7e6efc56bce4dff0089e3b62730e9c82e251d9a56fb80fae07cdf8d7e298ecb71196627fda57bd17cd7e964f4b77fd34b9ee52aeaa42f13ce3e2c5b7f6df8174cf10dbfcc600af200390ac30df930af1e9137dcc083fe5acd1c78f4cb8afa32dada1d3b58bdf0d5dc60d8ea01ee2cb3f7595bfd645f507903debc83c4be12baf0ff008cb49b565692c6e75187ecd37a8de0ed3ee2bf46c1e22389a6aac3aaff00873ab747bc91b70a3b281fa01499c7238fc69d29fdeb0c7424536a2fbb3a16c8cc864b9f0b5d5cea1a75bbde68d72776a9a5a8e7de7807671dd7bd759a45eda5bc3aaeb916a497fa56ad663ec7763f83646479721ecdf5c7a1ac7076f20e31dfd2b32092e7c3377737fa6592df6937833aae9240c480f59621d03e3aaf7fad7b796e66e9b54aa6ddcf231d80e74e74f7ec7c2963a7ea3ad6b86c34ab29efef6e2e1c450dbaef66258f61fccd7bef837e0c691e109ad2ebc7e875ef124c03d9785ec9f2abdc35cb8fbaa3bff5af59d2eefc356125cda7c1bf0bc1a3497649bed6ee2d4a0833d56356e59bdba0ad4d0344b2d1a293c86927bcb86df75773b6f9ae1bd59bd3d8702be8335e259463eca8ee79982c9dcdf3d4d8e5f52f08f8af56d426d62e7c5b269b7974a824b6b1dc90421061517079c0e334ed13c33e33f0f6b10ebb63e2b6d52eed8305b5bd6668e756fbd1e493b723bf6aeb91d9f5a99031d91dba9c76cb1eb56ebe39e3b11cdcea47d0bc25171e5b1e1bf133e0fe9be33d36f7c69f0c6c9ed35281dbfb67c372712452ff00118ff9e3a1ed5adfb0cea577a6c7e2cd3534fb996f5e784c76ef1b26180218b123803bd7a3ea5a7df45ab43e21f0fdd258eb96e368761fbaba4ff9e528ee3d0f506ad5d78a7c5dae5acda75af87a0f0a79fc5edfac88f2b8efe5003a9fef1e95f57478863530ae155eaac7815b289c6b5e1b324d53569b4cbcbdf0ef852e56e35a966927d475361ba0d33cc39658c7f13fa2f6ea7d2a1d1f4cb5d2acdaded83b33b979a690ee92e1cf5776ee7f953f4ad3ecf4bb18ecac6111411e78c92cc4f5666eacc7a926ad77cf73d4d7cbe3b1d3c5cb5d17447bb84c2430ebcc33595e3087ed1e12d620eef65263f2cd6ad4579189acae213d1e175ffc74d7127ef6c74cb53e5d8dcb2dbe30729bbf0af4ef01d9491fc3cd46555fdeeaf79159c1eff30ce3f235c1f84740bdd77528b4db34259be591f1c4480f24d7bce81a75b9f10e9fa4da28fb0787a1dedfeddc38c283ee064fe3463f131c2e1a751bd97e3d0c1ec766a8b1aac4bf751428fc38a5ce39a5ea78e7d4d55d52fecb4bb192ff0052ba8aced23fbf2cad819ec07a93e839afc7a109ce49455dbe9bea2728a5a99fab2a699aac5ae2e163936dbdff0060509c2487dd4f19f435c6f88f509be226a83c31a02893478660d777ca389dd7f8633d90773fc5f4eb5b53b9f10fc4db83a3e976d3e9fe19661e6b3ae25bc19fe2feea7fb3d4f7f4af6ff87be0eb1f0d6991430c28acaa0702bf5ee17e1295170c663d7bebe15dbb5fcd74ff0033c5c5e2f9af083d09bc07e14b2f0e69715bc112a9551daba9a4a5afd14f3828a28a0028a28a0028a281400b4514500145145001451450014514500145145001494b486800a28a2800a28a2800a28a280327c43a1596b368f05cc28e1863915e5773a1eabe07ba9e4b3b67d434b9dc3cb167f7b1e0601463e83f84f1f4af6aa8ae2de29e329220607d457163f2fc3e6145d1c446f17f7fc9f42e9d4953973459e3b72ba578c74931d95e14921712c4ea36cf6928e8c50f23d0f622b8ff00115e5f6a3aaf87bc3b790476dadc3a989a48dbfd5ceb1a330911bfbadfa1e2bd4bc59f0e6daeae3fb474a964b1be4e52685b6b0ff1fa571492eb36fe31d2b4bf1243672c91195edafb68491b09cae3b939edf957e7f89c83179152a9530cf9e924dd9e928bb6fd9f99eb61f1ded1a8cb7346d6ed6e9a656468a789f1344df7a3279153d60348e3c7b7fb5885690230fa2f7adfabc354956a10a8faa4fef3da83bc428a28ed9e83a9ae8dca039c601c7d05545be89ae0c30c33cc11b63c91afc8a7d327ae2ab5feb50db5dc105bafda1d9d95d539298ace93c4ba2787e28f4fd66f7ec93e5b62b46c43a9390c0d572df525cada3376d6068ee6ee79181333a8403b2a8c7352dc4a9042657dc547a024fe42abe93a8e9fab5b7dab4cbc8af22e85a26c91f51d4566f88fc5fe1fd02e56df51d436ce464c50af98c83fdac74a1260dab1ad69770dc9758c48af1fdf8e45dac3df1e953f43f863f0ac01aa0d54c3a9684ad751a40c3cc68ca2b03d00cf5c7357748d5edef51639098ae1547988e31826a5c75b8d48d2a28e0f4a295c61df150cb2b9992d2d504d75329da87a2a9e0b3fa01fad3e793c9b7966c7fab42e7f01597f0c2fdf524d42f1c7ccf32fe0bce0579f99e2a783c24aac375fa99d59d958c3f0a341e1ef09fd9ecad6397559af67b6855570d713073c9ff640e4fa0aeebc35a40d1f4a5b4f33cfb877335dce7acb2b7de627f41ec2bcc6dfc4969a0f8cf5ab2d1f46bdd6b5c175200f2b85b7b556c1d89d49c9e4915bb0785fe2078d004d775036360c726d2cd4c4847a31eadf89a9c4e4999e7d18452f674b46dbeaeddb7b7dddcf32ae3a14f4dda343c51f10b4cd3276d37478ceb9ab7dd105b9fdd447fe9a38e38f419351f85bc03aef8bf518b5af18dc19b69cc36ca36c300f455febd6bd03c11f0cb44f0fc09b2da3de3be2bbc8628e14091a8503d2bec723e17c1650b9a9ae69ff0033dfe5d8f2abe2a75b7d119da1e8763a4dbac56d0226063815a94b457d21cc14514500145145001451450014a29052d0014514500145145001451450014514500145145001451450025141a2800a28a2800a28a2800a28a2800af29f89915b5cf8df4d826895f6c13c9823a6360ce7b1e6bd5abcabc78a4f8faddbfbb6537ead1d70667fee93f43af02af8889836ba35bdb5e7da84f712485cbe5db3d7b1ad1a28af8ab2492ec7d4a560ec6b335d5be95a086d23df11dc66e7040c569d0785c003078aa5a0ed733b48d2a1b02f29c35cc8773b761ec29daf68da66b969f65d52d5678c64ab670c87d54f6ad0e3072700724f7fc7d2b88f117c4ef0ce8f3c90466e3539a13fbd16801443e858f04d52e793d112dc568cc597e19b41ad793a3f886e2d55e22eec41040ce00383cd5ff07fc3bd26176bfd5667d4ae16675d8e309907193dda9fa17c4af0a5d5fdd4fa85d4fa6ccc11523b84ced41df238e6a26f8a3e15d3ae66b785aef5159672f1c96d16570464f26b4b547a11789e84a15542a80aaa30028e001d001597aa68e2e246b9b5db14cc30fe8c7b367d6ab785bc5fe1df129d9a56a01a70798251b251ff00013d6b78719e99ee73d6b1f7a2f545e925a10d82ce96104772c1a654c391dcd4d4668a4eec7623ba8ccd6b342319910a73ee31585e1ad06fb48b57b117aab6d28532b47c48c413f2e7b0e7ad7434100f6cf7a8a94a1563cb515d038a6eece73e1869f6317c55d7e1fb3a002e10a8c7628a6be818a28e35011028f615e09e093e57c66d597b3c703ffe398fe95efcbca8afbcc0bbe1a1e88f92c4ab5697a8b4514575180514514005145140051451400514502801451451400514514005145140051451400514514005145140051451400521a5a280128a28a0028a28a0028a28a002bcbfe21c6d6fe2eb4ba932b14b0bc01bb0762a573f5da47d715ea1583e33d0e0d6f4a96de45c92bc1ee0d6388a2ab5274df534a351d29a9ae879dfa8e841e7da8aa76334e8d3d96a2d8bbb3e1d8f1e621e8e3f91f7fad5a462dcedc023233d48f5af86ab49d1a8e12dd1f5b4aa46ac14931d4a064e33d6928fc71505b3ccfc4f73e23f1f5ddc685e1af334fd022631ddea92653ed0e382a83a951fad4d69f07bc391da98eeeff52b891c0dee8e22524770a3b5754be27d321f11dcf872f5934eb98555e0f30858ee23619ca9e80e7a8a66b3e34f0b692c52f75ab6f347fcb284f98ff92f4ad9ce764a2ac6768f5388bff83f899e6d33c4642baec297706703d88eb4ed17e0ec11791fdafaf4d32c3cac7691f9609eff0031e6b4ae7e2de808f8b7d2f55b95fef6c083f535258fc57f0dca42de5a6a7619eacf10703f114f9ea8b96051d67e0fe90e527d0f53bbd3aea225e3f35cc89b8f7cf0c2ba6f02cbe2c8a27d2fc5966af3dba8f275185818ee57d08ea187eb4e97c79e0e8ec1ef46bf68e8abb846b9f31fd82e339ad6f0f6a91eb5a35b6ab0c6f147731ee08ff7979e86a65395ad24528abe8cbd45147e5591a05149f78100e31d70738ae27c73abdfdc343e0fb118d4ef7fe3ea48fa4701e841ec5bf4e6b6a141d79a82ea6556b46941cdf4367e17bff6f7c49d4f5bb44cd982b0452769020c16fa139fc2bdfc7415c6fc2ff0adbf877418214882b0519e2bb3afb8a54d528282d91f2339b9c9c9f50a28a2b42428a28a0028a28a0028a28a002968a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a4a5a280128a28a0028a28a002908c8c1a5a2803cf3e26f86da5f2f59b1895ae6d8eedbd9c7753ec6b9982f609ed23b88c92b21e17f8b3dc63d477af65b8896689a37190c315e11f126d750f046b6dadd9dbb5d69329ff4bb71d53fe9a27a1f5f515e3e6b81f6d0f691dd7e28f4b2ec57b29724b67f81b3473daa9e8faa69fabd8c77ba7dd4734520e80fcc0fa11573af7cfbd7caebd4fa24ce17e2cf8426f104106a1610a49796aa55a26eb227b7b8af3cd17c01e24be94a2697f6251f7a4b82107e1dc9af7d048391d69727d7356aac92b227913e8796db7c257d99b9d7955fd238b207e7599ae7c30d6ecd5a5d36787504033b7ee49f91af64a3d3da8f692ee1c88f9fec3c0de27bdba110d1e4b739c34b300aabee4d7b8786f4c4d1b42b4d3237f30411ed67fef3753f8568e5bfbc7f3a43d726a6551c8718a881a8e59a388a090e3cc3853d81f7352633c573be33f15e8fe1db4912f5d2e2765cadaa1f988f56fee8a16bb0376dc9fc61a95af87f4a935c90e2e233e5c5183cdc39e91e3bfd7b558f817e10bbb8b99bc4dae032dfde3f98ecc3a7a01ec0702bce7e1d699ae7c46f1643ac6b25dac6d8edb5879d88beb8f5f7afabb46b18b4fb18ede250a1540e2beb32bc0fd5e1cf3f89fe1fd753e731f8b75a5cb1f8516d142285030053a8a2bd53cf0a28a2800a28a2800a28a2800a5028028a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0028a28a0029314b45002514628a0028a28a002b2bc4ba4dbeafa64b6d3c6ac1948e456ad25007c67e28d3b59f86de3391ec19920949f2370ca3af53191eddabbcf0978ff47d682c176eba75f1eb1c87e463fecb7f4af55f8b3e08b3f156872c2f18f331946039523a11ef5f22ebba55e68daa4fa6ea11159a13c31180ebd9857cce6797a83f6915a33dec0631d45c927a9f4a60950cbf303dc74a0f4e3ffd55f37e9fe21d774d644d3f56ba857aedde4a81f435bd07c47f16c6306f6097feba422bc8749dec8f4e3511ee5f4c500f3ed5e24df137c5678f32cf1ff5c6ab5cfc46f174ce631a845102b9fddc40527465d47ce8f77208193c0f5cf1583aef8bbc3ba303f6cd4e2693b4309dee7f2e2bc3350d7b59d44b2deeab77371c8f3081f90acd650548c727f53551a5aee4ba9a6c7a0f89fe26ea57a24b5d1e1fece85b8f398e6523dbd2b98f096817be2ff112d98df2c5bc35d48c492c73f749ef5916505c6a1730d8da217b998ed1c676fab1afac3e0a780edfc3ba34524918f39865988e49af6b2bc126fda4968b6f53cacc314d2e44f57bfa1d5780fc3367e1fd2a182089548519c0ae9e900006052d7d11e205145140051451400514518a002968a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a2800a28a280131452d18a004a28c514008c03020f435e65f167e1c5a7896c9e58504772a331c8a39535e9d484023046694a2a4acf61a6e2ee8f8775ff0004f89348be923974e6957a2c91f423e9596349d70e7fe24b727dfd6bee9bbd2ac6e8e66b7463ee2ab8f0ee923fe5d53f2af3de5741df73b96635adad9fc8f88468dad639d22f3fef914c6d0f5c338906917846cda4102bee2ff847f4a1ff002e91fe547fc23fa5ff00cfa47f9528e55416d713cc2b3ec7c38ba16bde7b39d1aef05401c0ea2addaf86fc4175288d347b904f76e00afb63fb034bff009f48ff002a923d134d8db725aa03f4a6f2ba0f7bfde1fda35f7b9e31f04be17ff6737f69ea9186b973b8e474f615eeb0c6b14611060014471a46bb51401ed4faef8c54528ad91c529393bb0a28a2a841451462800a314b8a2800c5145140051451400514514005145140051451400514514005145140051451400514514005145140051451400514514005145140051451400514514005145140051451400629314b45002628a5a280128a5a280128a5a280128c52d140098a5c514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145001451450014514500145145007fffd9, '2025-06-04 07:10:59', 1, 'admin', '2025-06-06 05:43:17', '2025-06-06 05:58:05', '600700800', 'C/De La Fuente 18', 'Soy estudiante de programación web'),
(2, 'profesor', '12345678B', 'María', 'García López', 'profesor@babelium.edu', '$2y$10$LL5uwye6xgWvMjbmNOQBCeQCQ2BHTnkWksU9o.LpzLCsn4jWXj.S2', NULL, '2025-06-04 07:41:05', 1, 'profesor', '2025-06-06 05:43:17', '2025-06-06 05:43:17', NULL, NULL, NULL),
(3, 'alumno', 'ALU001234', 'Juan', 'Pérez Martínez', 'alumno@babelium.edu', '$2y$10$szmo2xxAnc4NykksAm36KO5DPDwfs/axWHfmgmPKHwwEH73LF.Y8K', NULL, '2025-06-04 07:41:05', 1, 'alumno', '2025-06-06 05:43:17', '2025-06-06 05:43:17', NULL, NULL, NULL),
(5, 'alumno', '54289804Y', 'Douglas Alexis', 'Largo Moreno', 'malfidos30@gmail.com', '$2y$10$NtvhLwHZHeRRd9RhGGnd0ejs.5zgiMMpXS6ytbx59Rs6iW1ISTCmi', NULL, '2025-06-04 07:47:35', 1, 'alumno', '2025-06-06 05:43:17', '2025-06-06 05:43:17', NULL, NULL, NULL),
(10, 'alumno', '65473828J', 'Nicolle', 'LArgo Moreno', 'nicolle.94@gmail.com', '$2y$10$i6ufkh9dq.r5Y3q88IJHw.lNtkbbTNyTIxJiw0A6EYyGn.gYPtjf2', NULL, '2025-06-04 10:46:55', 1, 'alumno', '2025-06-06 05:43:17', '2025-06-06 05:43:17', NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT de la tabla `modalidades_curso`
--
ALTER TABLE `modalidades_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT de la tabla `niveles_educativos`
--
ALTER TABLE `niveles_educativos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Restricciones para tablas volcadas
--

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
-- Filtros para la tabla `modalidades_curso`
--
ALTER TABLE `modalidades_curso`
  ADD CONSTRAINT `modalidades_curso_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `modalidades_curso_ibfk_2` FOREIGN KEY (`rama_id`) REFERENCES `ramas` (`id`) ON DELETE SET NULL;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
