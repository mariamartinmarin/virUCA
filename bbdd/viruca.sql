-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2017 a las 21:37:35
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `viruca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE IF NOT EXISTS `acceso` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Usuario` int(16) NOT NULL,
  `dFecha` datetime NOT NULL,
  `sIP` varchar(64) NOT NULL,
  `sNombreCompleto` varchar(128) NOT NULL,
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=239 ;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`iId`, `iId_Usuario`, `dFecha`, `sIP`, `sNombreCompleto`) VALUES
(10, 1, '2017-03-13 17:54:56', '::1', 'María, Martín Marín'),
(11, 1, '2017-03-15 21:01:45', '::1', 'María, Martín Marín'),
(12, 1, '2017-03-16 09:48:28', '::1', 'María, Martín Marín'),
(14, 2, '2017-03-16 10:29:55', '::1', 'alumno, alumno alumno'),
(15, 1, '2017-03-16 11:03:59', '::1', 'María, Martín Marín'),
(16, 1, '2017-03-16 11:29:15', '::1', 'María, Martín Marín'),
(17, 1, '2017-03-16 12:00:42', '::1', 'María, Martín Marín'),
(18, 2, '2017-03-16 13:03:35', '::1', 'alumno, alumno alumno'),
(19, 1, '2017-03-16 13:03:49', '::1', 'María, Martín Marín'),
(20, 1, '2017-03-16 13:04:18', '::1', 'María, Martín Marín'),
(21, 1, '2017-03-16 19:53:47', '::1', 'María, Martín Marín'),
(22, 1, '2017-03-17 19:02:00', '::1', 'María, Martín Marín'),
(23, 1, '2017-03-22 17:34:00', '::1', 'María, Martín Marín'),
(24, 2, '2017-03-23 10:02:49', '::1', 'alumno, alumno alumno'),
(25, 1, '2017-03-23 17:30:29', '::1', 'María, Martín Marín'),
(26, 2, '2017-03-23 17:30:53', '::1', 'alumno, alumno alumno'),
(27, 1, '2017-03-23 20:18:01', '::1', 'María, Martín Marín'),
(28, 1, '2017-03-27 17:16:06', '::1', 'María, Martín Marín'),
(33, 2, '2017-03-30 11:59:55', '::1', 'alumno, alumno alumno'),
(34, 1, '2017-03-30 12:17:21', '::1', 'María, Martín Marín'),
(35, 2, '2017-03-30 12:24:11', '::1', 'alumno, alumno alumno'),
(36, 1, '2017-03-30 12:24:59', '::1', 'María, Martín Marín'),
(37, 1, '2017-03-30 12:27:05', '::1', 'María, Martín Marín'),
(38, 1, '2017-04-05 17:33:00', '::1', 'María, Martín Marín'),
(39, 1, '2017-04-06 18:34:28', '::1', 'María, Martín Marín'),
(41, 1, '2017-04-06 22:03:45', '::1', 'María, Martín Marín'),
(43, 1, '2017-04-07 10:55:00', '::1', 'María, Martín Marín'),
(44, 2, '2017-04-07 19:52:08', '::1', 'alumno, alumno alumno'),
(45, 1, '2017-04-07 19:57:29', '::1', 'María Consolación, Martín Marín'),
(46, 1, '2017-04-08 21:09:32', '::1', 'María, Martín Marín'),
(47, 1, '2017-04-08 21:46:37', '::1', 'María, Martín Marín'),
(48, 1, '2017-04-08 21:47:01', '::1', 'María, Martín Marín'),
(52, 2, '2017-04-11 19:18:59', '::1', 'alumno, alumno alumno'),
(53, 2, '2017-04-11 19:53:13', '::1', 'alumno, alumno alumno'),
(54, 2, '2017-04-11 20:00:49', '::1', 'alumno, alumno alumno'),
(56, 1, '2017-04-12 09:27:57', '::1', 'María, Martín Marín'),
(57, 1, '2017-04-12 09:28:37', '::1', 'María, Martín Marín'),
(58, 1, '2017-04-12 09:41:49', '::1', 'María, Martín Marín'),
(59, 1, '2017-04-17 18:28:42', '::1', 'María, Martín Marín'),
(60, 1, '2017-04-17 18:28:44', '::1', 'María, Martín Marín'),
(61, 1, '2017-04-17 18:29:16', '::1', 'María, Martín Marín'),
(63, 1, '2017-04-17 18:35:33', '::1', 'María, Martín Marín'),
(65, 1, '2017-04-17 18:37:57', '::1', 'María, Martín Marín'),
(66, 1, '2017-04-17 18:38:23', '::1', 'María, Martín Marín'),
(67, 1, '2017-04-17 18:50:17', '::1', 'María, Martín Marín'),
(68, 1, '2017-04-17 18:50:41', '::1', 'María, Martín Marín'),
(69, 1, '2017-04-17 18:53:48', '::1', 'María, Martín Marín'),
(70, 1, '2017-04-17 19:00:18', '::1', 'María, Martín Marín'),
(71, 1, '2017-04-17 19:01:05', '::1', 'María, Martín Marín'),
(72, 1, '2017-04-17 19:01:17', '::1', 'María, Martín Marín'),
(73, 1, '2017-04-17 19:02:07', '::1', 'María, Martín Marín'),
(74, 1, '2017-04-17 19:02:59', '::1', 'María, Martín Marín'),
(75, 1, '2017-04-17 19:03:17', '::1', 'María, Martín Marín'),
(76, 1, '2017-04-17 19:08:53', '::1', 'María, Martín Marín'),
(77, 1, '2017-04-17 19:09:03', '::1', 'María, Martín Marín'),
(78, 1, '2017-04-17 19:09:48', '::1', 'María, Martín Marín'),
(79, 1, '2017-04-17 19:10:21', '::1', 'María, Martín Marín'),
(80, 1, '2017-04-17 19:10:55', '::1', 'María, Martín Marín'),
(81, 1, '2017-04-17 19:11:16', '::1', 'María, Martín Marín'),
(82, 1, '2017-04-17 19:17:43', '::1', 'María, Martín Marín'),
(83, 1, '2017-04-17 19:23:36', '::1', 'María, Martín Marín'),
(84, 1, '2017-04-17 19:23:59', '::1', 'María, Martín Marín'),
(85, 1, '2017-04-17 19:25:25', '::1', 'María, Martín Marín'),
(86, 1, '2017-04-17 19:26:01', '::1', 'María, Martín Marín'),
(87, 1, '2017-04-17 19:36:53', '::1', 'María, Martín Marín'),
(88, 1, '2017-04-19 16:41:01', '::1', 'María, Martín Marín'),
(89, 2, '2017-04-19 20:39:43', '::1', 'alumno, alumno alumno'),
(90, 1, '2017-04-19 20:44:47', '::1', 'María, Martín Marín'),
(92, 1, '2017-04-20 17:19:02', '::1', 'María, Martín Marín'),
(93, 1, '2017-04-21 18:18:28', '::1', 'María, Martín Marín'),
(94, 2, '2017-04-21 21:54:35', '::1', 'alumno, alumno alumno'),
(95, 1, '2017-04-21 22:04:17', '::1', 'María, Martín Marín'),
(96, 1, '2017-04-23 21:09:19', '::1', 'María, Martín Marín'),
(97, 2, '2017-04-23 21:21:02', '::1', 'alumno, alumno alumno'),
(98, 1, '2017-04-23 21:21:53', '::1', 'María, Martín Marín'),
(99, 2, '2017-04-23 21:30:53', '::1', 'alumno, alumno alumno'),
(100, 1, '2017-04-23 21:45:26', '::1', 'María, Martín Marín'),
(101, 2, '2017-04-23 22:58:18', '::1', 'alumno, alumno alumno'),
(102, 1, '2017-04-23 22:58:46', '::1', 'María, Martín Marín'),
(103, 1, '2017-04-24 17:17:49', '::1', 'María, Martín Marín'),
(104, 1, '2017-04-24 20:26:33', '::1', 'María, Martín Marín'),
(105, 1, '2017-04-24 20:49:27', '::1', 'María, Martín Marín'),
(106, 1, '2017-04-25 19:09:39', '::1', 'María, Martín Marín'),
(107, 1, '2017-04-26 09:33:42', '::1', 'María, Martín Marín'),
(108, 1, '2017-04-26 17:54:41', '::1', 'María, Martín Marín'),
(109, 1, '2017-04-27 11:01:20', '::1', 'María, Martín Marín'),
(110, 43, '2017-04-27 11:42:15', '::1', 'alumno, alumno'),
(111, 1, '2017-04-27 11:44:42', '::1', 'María, Martín Marín'),
(112, 43, '2017-04-27 11:46:54', '::1', 'alumno, alumno'),
(113, 1, '2017-04-27 11:55:25', '::1', 'María, Martín Marín'),
(114, 43, '2017-04-27 12:07:05', '::1', 'alumno, alumno'),
(115, 43, '2017-04-27 12:31:04', '::1', 'alumno, alumno'),
(116, 1, '2017-04-27 21:03:45', '::1', 'María, Martín Marín'),
(117, 1, '2017-04-28 13:39:56', '::1', 'María, Martín Marín'),
(118, 1, '2017-04-28 17:40:12', '::1', 'María, Martín Marín'),
(119, 44, '2017-04-28 18:38:42', '::1', 'prueba borrar, prpuas'),
(120, 44, '2017-04-28 18:39:39', '::1', 'prueba borrar, prpuas'),
(121, 1, '2017-04-28 18:39:51', '::1', 'María, Martín Marín'),
(122, 45, '2017-04-28 18:58:40', '::1', 'profeb, kjsklsdfj'),
(123, 45, '2017-04-28 18:59:41', '::1', 'profeb, kjsklsdfj'),
(124, 1, '2017-04-28 18:59:52', '::1', 'María, Martín Marín'),
(125, 1, '2017-04-29 14:01:49', '::1', 'María, Martín Marín'),
(126, 1, '2017-04-29 20:13:28', '::1', 'María, Martín Marín'),
(127, 1, '2017-04-30 20:55:45', '::1', 'María, Martín Marín'),
(128, 1, '2017-05-01 19:08:57', '::1', 'María, Martín Marín'),
(129, 1, '2017-05-02 18:30:11', '::1', 'María, Martín Marín'),
(130, 1, '2017-05-03 20:58:48', '::1', 'María, Martín Marín'),
(131, 1, '2017-05-04 11:03:38', '::1', 'María, Martín Marín'),
(132, 1, '2017-05-04 18:57:44', '::1', 'María, Martín Marín'),
(133, 1, '2017-05-08 09:19:20', '::1', 'María, Martín Marín'),
(134, 1, '2017-05-08 17:55:46', '::1', 'María, Martín Marín'),
(135, 1, '2017-05-10 12:36:02', '::1', 'María, Martín Marín'),
(136, 1, '2017-05-10 17:14:48', '::1', 'María, Martín Marín'),
(137, 1, '2017-05-11 12:26:55', '::1', 'María, Martín Marín'),
(138, 1, '2017-05-11 17:21:10', '::1', 'María, Martín Marín'),
(139, 1, '2017-05-12 08:46:44', '::1', 'María, Martín Marín'),
(140, 1, '2017-05-12 17:09:58', '::1', 'María, Martín Marín'),
(141, 1, '2017-05-15 17:47:10', '::1', 'María, Martín Marín'),
(142, 1, '2017-05-16 09:59:13', '::1', 'María, Martín Marín'),
(143, 1, '2017-05-16 17:01:01', '::1', 'María, Martín Marín'),
(144, 1, '2017-05-17 16:53:57', '::1', 'María, Martín Marín'),
(145, 1, '2017-05-18 11:10:23', '::1', 'María, Martín Marín'),
(146, 1, '2017-05-18 13:14:12', '::1', 'María, Martín Marín'),
(147, 1, '2017-05-18 14:06:40', '::1', 'María, Martín Marín'),
(148, 1, '2017-05-18 21:49:59', '::1', 'María, Martín Marín'),
(149, 1, '2017-05-21 11:56:46', '::1', 'María, Martín Marín'),
(150, 1, '2017-05-21 13:27:16', '::1', 'María, Martín Marín'),
(151, 1, '2017-05-21 16:58:39', '::1', 'María, Martín Marín'),
(152, 1, '2017-05-21 16:58:39', '::1', 'María, Martín Marín'),
(153, 1, '2017-05-22 09:13:41', '::1', 'María, Martín Marín'),
(154, 1, '2017-05-22 12:26:21', '::1', 'María, Martín Marín'),
(155, 1, '2017-05-22 15:29:16', '::1', 'María, Martín Marín'),
(156, 1, '2017-05-22 18:35:24', '::1', 'María, Martín Marín'),
(157, 1, '2017-05-23 19:04:00', '::1', 'María, Martín Marín'),
(158, 1, '2017-05-24 09:43:26', '::1', 'María, Martín Marín'),
(159, 1, '2017-05-24 15:57:37', '::1', 'María, Martín Marín'),
(160, 1, '2017-05-25 10:50:17', '::1', 'María, Martín Marín'),
(161, 1, '2017-05-25 17:34:56', '::1', 'María, Martín Marín'),
(162, 1, '2017-05-26 11:45:26', '::1', 'María, Martín Marín'),
(163, 1, '2017-05-26 20:42:31', '::1', 'María, Martín Marín'),
(164, 1, '2017-05-26 22:48:18', '::1', 'María, Martín Marín'),
(165, 46, '2017-05-26 23:41:02', '::1', 'María, Martín Marín'),
(166, 1, '2017-05-27 18:48:43', '::1', 'María, Martín Marín'),
(167, 1, '2017-05-28 12:47:57', '::1', 'María, Martín Marín'),
(168, 1, '2017-05-28 18:29:23', '::1', 'María, Martín Marín'),
(169, 47, '2017-05-28 19:27:53', '::1', 'pruebas, pruebas'),
(170, 1, '2017-05-29 10:23:30', '::1', 'María, Martín Marín'),
(171, 1, '2017-05-29 15:59:37', '::1', 'María, Martín Marín'),
(172, 1, '2017-06-01 10:56:25', '::1', 'María, Martín Marín'),
(173, 1, '2017-06-01 20:48:30', '::1', 'María, Martín Marín'),
(174, 1, '2017-06-02 00:14:47', '::1', 'María, Martín Marín'),
(175, 1, '2017-06-02 14:27:06', '::1', 'María, Martín Marín'),
(176, 1, '2017-06-24 17:40:13', '::1', 'María, Martín Marín'),
(177, 1, '2017-06-28 17:08:19', '::1', 'María, Martín Marín'),
(178, 1, '2017-07-11 06:06:53', '::1', 'María, Martín Marín'),
(179, 1, '2017-07-11 19:50:49', '::1', 'María, Martín Marín'),
(180, 1, '2017-07-12 07:57:41', '::1', 'María, Martín Marín'),
(181, 1, '2017-07-12 09:47:38', '::1', 'María, Martín Marín'),
(182, 1, '2017-07-12 09:48:29', '::1', 'María, Martín Marín'),
(183, 1, '2017-07-12 09:49:00', '::1', 'María, Martín Marín'),
(184, 1, '2017-07-12 09:49:41', '::1', 'María, Martín Marín'),
(185, 1, '2017-07-12 17:10:50', '::1', 'María, Martín Marín'),
(186, 48, '2017-07-12 20:15:09', '::1', 'Usuario, No Administrador'),
(187, 1, '2017-07-12 20:24:33', '::1', 'María, Martín Marín'),
(188, 48, '2017-07-12 20:25:59', '::1', 'Usuario, No Administrador'),
(189, 1, '2017-07-12 20:46:00', '::1', 'María, Martín Marín'),
(191, 1, '2017-07-14 08:33:50', '::1', 'María, Martín Marín'),
(194, 1, '2017-07-19 08:14:24', '::1', 'María, Martín Marín'),
(196, 1, '2017-07-20 17:08:24', '::1', 'María, Martín Marín'),
(199, 1, '2017-07-24 18:07:08', '::1', 'María, Martín Marín'),
(230, 50, '2017-07-26 20:17:47', '::1', 'Marco, Melandri'),
(231, 1, '2017-07-27 08:24:41', '::1', 'María, Martín Marín'),
(232, 50, '2017-07-27 09:00:45', '::1', 'Marco, Melandri'),
(233, 1, '2017-07-27 09:07:51', '::1', 'María, Martín Marín'),
(234, 1, '2017-07-27 17:06:43', '::1', 'María, Martín Marín'),
(235, 1, '2017-07-28 12:08:55', '::1', 'María, Martín Marín'),
(236, 1, '2017-07-28 16:13:17', '::1', 'María, Martín Marín'),
(237, 1, '2017-07-30 10:15:47', '::1', 'María, Martín Marín'),
(238, 1, '2017-07-31 17:23:40', '::1', 'María, Martín Marín');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnoscursos`
--

CREATE TABLE IF NOT EXISTS `alumnoscursos` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Alumno` int(8) NOT NULL,
  `iId_Curso` int(8) NOT NULL,
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE IF NOT EXISTS `asignatura` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sNombre` varchar(128) NOT NULL,
  `iId_Titulacion` int(32) NOT NULL,
  `iId_Universidad` int(32) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`),
  UNIQUE KEY `iId_2` (`iId`),
  UNIQUE KEY `iId_3` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `asignatura`
--

INSERT INTO `asignatura` (`iId`, `sNombre`, `iId_Titulacion`, `iId_Universidad`) VALUES
(2, 'Virología II', 1, 3),
(3, 'Estructura de Datos y de la Información', 6, 1),
(4, 'Programación Orientada a Objetos', 2, 1),
(8, 'Programación Concurrente y distribuida', 3, 1),
(9, 'Ingeniería Web', 5, 3),
(10, 'Prueba con Ingeniería del Producto', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sCategoria` varchar(256) NOT NULL,
  `sDescripcion` varchar(2048) NOT NULL,
  `sColor` varchar(8) NOT NULL COMMENT 'Código hex del color de la categoría.',
  `iId_Asignatura` int(8) NOT NULL COMMENT 'Asignatura a la que depende.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Preguntas VirUCA' AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`iId`, `sCategoria`, `sDescripcion`, `sColor`, `iId_Asignatura`) VALUES
(3, 'Microbiología', '', '#f44336', 2),
(4, 'Actualidad y películas', '', '#9c27b0', 2),
(13, 'Virología en el cine', '', '#2196f3', 2),
(15, 'Especialidades médicas', 'Especialdades médicas en las que se tratan temas de virología', '#2e5470', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Titulacion` int(8) NOT NULL,
  `iId_Asignatura` int(8) NOT NULL,
  `sCurso` varchar(128) NOT NULL COMMENT 'Aqui ponemos el Curso académico.',
  `iId_Universidad` int(32) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`iId`, `iId_Titulacion`, `iId_Asignatura`, `sCurso`, `iId_Universidad`) VALUES
(4, 2, 3, 'Curso de Prueba II', 1),
(7, 1, 4, 'Curso 2017/2018', 1),
(8, 1, 2, 'Curso 2016/2017', 1),
(10, 1, 2, 'Curso 2017/2018', 1),
(16, 1, 2, 'Curso 2016/2017', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursopartida`
--

CREATE TABLE IF NOT EXISTS `cursopartida` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Partida` int(8) NOT NULL,
  `iId_Pregunta` int(8) NOT NULL,
  `iId_Curso` int(8) NOT NULL,
  `nRespuesta` int(8) NOT NULL COMMENT 'Respuesta del alumno, de 1 a 4Curs',
  `bAcierto` tinyint(1) NOT NULL,
  `dFecha` date NOT NULL,
  `iGrupo` int(11) NOT NULL COMMENT 'Señala el grupo que contesta esa pregunta. Será un INT de 1 a N.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Curso Partida VirUCA' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `panel`
--

CREATE TABLE IF NOT EXISTS `panel` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iCasillas` int(32) NOT NULL COMMENT 'Número de casillas del panel.',
  `sNombre` varchar(32) NOT NULL COMMENT 'Nombre del panel',
  `bActivo` int(8) NOT NULL DEFAULT '0',
  `bEliminar` tinyint(1) NOT NULL DEFAULT '1',
  `iId_Propietario` int(11) NOT NULL COMMENT 'Identificador del usuario que ha creado el panel.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `panel`
--

INSERT INTO `panel` (`iId`, `iCasillas`, `sNombre`, `bActivo`, `bEliminar`, `iId_Propietario`) VALUES
(1, 20, 'Panel por defecto', 1, 0, 1),
(10, 18, 'Panel virología', 1, 1, 1),
(11, 10, 'Otra prueba', 0, 1, 1),
(12, 12, 'Prueba', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `panelcasillas`
--

CREATE TABLE IF NOT EXISTS `panelcasillas` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Panel` int(32) NOT NULL,
  `iId_Categoria` int(32) NOT NULL,
  `eFuncion` enum('Ninguno','Viento','Retroceder') NOT NULL DEFAULT 'Ninguno' COMMENT 'Tipología de la casilla.',
  `iNumCasilla` int(11) NOT NULL,
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

--
-- Volcado de datos para la tabla `panelcasillas`
--

INSERT INTO `panelcasillas` (`iId`, `iId_Panel`, `iId_Categoria`, `eFuncion`, `iNumCasilla`) VALUES
(1, 1, 3, 'Ninguno', 1),
(2, 1, 4, 'Ninguno', 2),
(3, 1, 13, 'Ninguno', 3),
(4, 1, 15, 'Ninguno', 4),
(5, 1, 3, 'Retroceder', 5),
(7, 1, 13, 'Ninguno', 7),
(8, 1, 15, 'Viento', 8),
(11, 1, 13, 'Ninguno', 10),
(13, 1, 3, 'Ninguno', 12),
(14, 1, 4, 'Ninguno', 13),
(15, 1, 13, 'Ninguno', 14),
(16, 1, 15, 'Ninguno', 15),
(17, 1, 3, 'Ninguno', 16),
(18, 1, 4, 'Viento', 17),
(19, 1, 13, 'Retroceder', 18),
(20, 1, 15, 'Ninguno', 19),
(22, 1, 4, 'Ninguno', 20),
(24, 1, 15, 'Ninguno', 21),
(25, 1, 3, 'Ninguno', 22),
(29, 1, 4, 'Ninguno', 23),
(42, 10, 15, 'Viento', 1),
(43, 10, 13, 'Viento', 2),
(44, 10, 4, 'Retroceder', 3),
(45, 10, 4, 'Viento', 4),
(47, 10, 3, 'Ninguno', 5),
(48, 10, 3, 'Ninguno', 6),
(49, 10, 3, 'Ninguno', 7),
(50, 10, 3, 'Ninguno', 8),
(51, 10, 3, 'Ninguno', 9),
(52, 10, 3, 'Ninguno', 10),
(53, 10, 3, 'Ninguno', 11),
(54, 10, 3, 'Ninguno', 12),
(55, 10, 3, 'Ninguno', 13),
(56, 10, 3, 'Ninguno', 14),
(57, 10, 3, 'Ninguno', 15),
(58, 10, 3, 'Ninguno', 16),
(59, 10, 3, 'Ninguno', 17),
(60, 10, 3, 'Ninguno', 18),
(62, 11, 15, 'Viento', 1),
(63, 11, 4, 'Retroceder', 2),
(64, 11, 4, 'Ninguno', 3),
(65, 11, 3, 'Viento', 4),
(66, 11, 3, 'Ninguno', 5),
(67, 11, 13, 'Ninguno', 6),
(68, 11, 3, 'Ninguno', 7),
(69, 11, 13, 'Ninguno', 8),
(70, 11, 4, 'Ninguno', 9),
(71, 11, 3, 'Ninguno', 10),
(72, 12, 15, 'Ninguno', 1),
(73, 12, 15, 'Ninguno', 2),
(75, 12, 3, 'Ninguno', 3),
(77, 12, 15, 'Ninguno', 4),
(78, 12, 15, 'Ninguno', 5),
(79, 12, 3, 'Ninguno', 6),
(80, 12, 4, 'Ninguno', 7),
(81, 12, 15, 'Ninguno', 8),
(82, 12, 4, 'Ninguno', 9),
(92, 12, 3, 'Ninguno', 10),
(93, 12, 4, 'Retroceder', 11),
(94, 12, 3, 'Ninguno', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE IF NOT EXISTS `parametros` (
  `iActiva` int(32) NOT NULL,
  `iId` int(8) NOT NULL,
  `iEdicion` int(8) NOT NULL COMMENT 'Activa o Desactiva la edición de preguntas por parte de los alumnos.',
  PRIMARY KEY (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`iActiva`, `iId`, `iEdicion`) VALUES
(1, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE IF NOT EXISTS `partida` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dFecha` date NOT NULL,
  `nGrupos` int(2) NOT NULL COMMENT 'Número de grupos que se crean en la partida.',
  `bFinalizada` tinyint(1) NOT NULL DEFAULT '0',
  `iId_Panel` int(11) NOT NULL,
  `iId_Curso` int(8) NOT NULL,
  `iId_Profesor` int(11) NOT NULL,
  `bEmpezada` tinyint(1) NOT NULL DEFAULT '0',
  `bAbierta` int(8) NOT NULL,
  `iTurno` int(8) NOT NULL DEFAULT '1' COMMENT 'Equipo que tiene el turno de la partida.',
  `iId_Profesor_Act` int(8) NOT NULL DEFAULT '0' COMMENT 'Este es el ID del profesor que está jugando en ese momento. Si es 0 es que la partida no está siendo jugada.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Partida VirUCA.' AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`iId`, `dFecha`, `nGrupos`, `bFinalizada`, `iId_Panel`, `iId_Curso`, `iId_Profesor`, `bEmpezada`, `bAbierta`, `iTurno`, `iId_Profesor_Act`) VALUES
(11, '2017-05-22', 5, 1, 10, 10, 1, 1, 0, 4, 0),
(14, '2017-05-25', 4, 1, 1, 3, 1, 1, 0, 1, 1),
(19, '2017-05-29', 3, 1, 10, 4, 1, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE IF NOT EXISTS `pregunta` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sPregunta` varchar(512) NOT NULL,
  `nPuntuacion` float NOT NULL,
  `bActiva` tinyint(1) NOT NULL DEFAULT '0',
  `iId_Usuario` int(11) NOT NULL,
  `iId_Categoria` int(11) NOT NULL,
  `sObservaciones` varchar(3000) NOT NULL,
  `iId_Titulacion` int(32) NOT NULL,
  `iId_Asignatura` int(32) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Preguntas VirUCA. Esta tabla almacenará las preguntas del juego.' AUTO_INCREMENT=36 ;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`iId`, `sPregunta`, `nPuntuacion`, `bActiva`, `iId_Usuario`, `iId_Categoria`, `sObservaciones`, `iId_Titulacion`, `iId_Asignatura`) VALUES
(4, 'Lorem Ipsum', 6, 0, 1, 13, 'j', 0, 0),
(10, 'Dolor sit a met', 2.5, 0, 1, 4, 'ffjfjfjjfjfjf', 0, 0),
(11, 'Lorem Ipsum Lorem Ipsum', 6.8, 1, 1, 3, 'asdasdasdasdasdasd', 0, 0),
(12, 'Dolor sit a met ipsum', 8.7, 1, 1, 13, 'kjjkjkjkjkllklkkj', 0, 0),
(13, 'Ipsum lorem est et sit a met', 2.5, 0, 1, 3, 'asdasdasdasdasd', 0, 0),
(14, 'Lorem Ipsum ', 2.7, 1, 1, 3, 'sdfsdfsdfsdfsdfsdfsdfsdfsdfsdf', 0, 0),
(15, 'Lorem Ipsum est convincit', 2.5, 1, 1, 3, '', 0, 0),
(16, 'Est fascicus no rest', 5.87, 1, 1, 3, '', 0, 0),
(17, 'Dolor est a met sit', 5.7, 1, 1, 3, '', 0, 0),
(19, 'Fervor conciencit est sum', 5.7, 0, 1, 3, '', 0, 0),
(20, 'Requien dolor est, lucius', 6.7, 0, 1, 3, 'esto es una prueba', 0, 0),
(21, 'Est dolor a met', 8, 1, 43, 3, '', 0, 0),
(23, 'Lorem Ipsum orbium est puelorum', 0, 0, 43, 13, '', 0, 0),
(24, '¿Hay virus gordos?', 0, 1, 46, 3, '', 0, 0),
(28, 'Lorencito', 0, 0, 0, 3, '', 0, 0),
(29, 'Loren', 0, 0, 0, 3, '', 0, 0),
(30, 'Lorem Ipsum Lorem Ipsum', 0, 0, 0, 3, '', 0, 0),
(31, 'Lorem Ipsum Lorem Ipsum', 0, 0, 0, 3, '', 0, 0),
(35, 'Mi primera pregunta con ajax!', 0, 0, 50, 4, '', 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntasjugadas`
--

CREATE TABLE IF NOT EXISTS `preguntasjugadas` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Pregunta` int(8) NOT NULL COMMENT 'Pregunta que ha salido.',
  `iId_Categoria` int(8) NOT NULL COMMENT 'Categoría de la pregunta.',
  `iId_Partida` int(8) NOT NULL COMMENT 'Partida en la que se juega.',
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para contabilizar las preguntas que se han hecho en una jugada.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE IF NOT EXISTS `respuesta` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Pregunta` int(16) NOT NULL,
  `sRespuesta` varchar(512) NOT NULL,
  `bVerdadera` tinyint(1) NOT NULL,
  `iOrden` int(11) NOT NULL COMMENT 'Orden de la respuesta a la hora de ser mostrada y modificada.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Respuestas VirUCA. Se almacenarán las diferentes respuestas.' AUTO_INCREMENT=108 ;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`iId`, `iId_Pregunta`, `sRespuesta`, `bVerdadera`, `iOrden`) VALUES
(12, 4, 'Respuesta Incorrecta', 0, 1),
(13, 4, 'Respuesta Incorrecta', 0, 2),
(14, 4, 'Respuesta CORRECTA', 1, 3),
(15, 4, 'Respuesta Incorrecta', 0, 4),
(36, 10, 'Respuesta Incorrecta', 0, 1),
(37, 10, 'Respuesta Incorrecta', 0, 2),
(38, 10, 'Respuesta CORRECTA', 1, 3),
(39, 10, 'Respuesta Incorrecta', 0, 4),
(40, 11, 'Respuesta Incorrecta', 0, 1),
(41, 11, 'Respuesta Incorrecta', 0, 2),
(42, 11, 'Respuesta CORRECTA', 1, 3),
(43, 11, 'Respuesta Incorrecta', 0, 4),
(44, 12, 'Respuesta Incorrecta', 0, 1),
(45, 12, 'Respuesta Incorrecta', 0, 2),
(46, 12, 'Respuesta CORRECTA', 1, 3),
(47, 12, 'Respuesta Incorrecta', 0, 4),
(48, 13, 'Respuesta Incorrecta', 0, 1),
(49, 13, 'Respuesta CORRECTA', 1, 2),
(50, 13, 'Respuesta Incorrecta', 0, 3),
(51, 13, 'Respuesta Incorrecta', 0, 4),
(52, 14, 'Respuesta Incorrecta', 0, 1),
(53, 14, 'Respuesta Incorrecta', 0, 2),
(54, 14, 'Respuesta Incorrecta', 0, 3),
(55, 14, 'Respuesta CORRECTA', 1, 4),
(56, 15, 'Respuesta CORRECTA', 1, 1),
(57, 15, 'Respuesta Incorrecta', 0, 2),
(58, 15, 'Respuesta Incorrecta', 0, 3),
(59, 15, 'Respuesta Incorrecta', 0, 4),
(60, 16, 'Respuesta CORRECTA', 1, 1),
(61, 16, 'Respuesta Incorrecta', 0, 2),
(62, 16, 'Respuesta Incorrecta', 0, 3),
(63, 16, 'Respuesta Incorrecta', 0, 4),
(64, 17, 'Respuesta Incorrecta', 0, 1),
(65, 17, 'Respuesta Incorrecta', 0, 2),
(66, 17, 'Respuesta CORRECTA', 1, 3),
(67, 17, 'Respuesta Incorrecta', 0, 4),
(72, 19, 'Respuesta CORRECTA', 1, 1),
(73, 19, 'Respuesta Incorrecta', 0, 2),
(74, 19, 'Respuesta Incorrecta', 0, 3),
(75, 19, 'Respuesta Incorrecta', 0, 4),
(76, 20, 'Respuesta Incorrecta', 0, 1),
(77, 20, 'Respuesta Incorrecta', 0, 2),
(78, 20, 'Respuesta CORRECTA', 1, 3),
(79, 20, 'Respuesta Incorrecta', 0, 4),
(80, 21, 'Respuesta Incorrecta', 0, 1),
(81, 21, 'Respuesta CORRECTA', 1, 2),
(82, 21, 'Respuesta Incorrecta', 0, 3),
(83, 21, 'Respuesta Incorrecta', 0, 4),
(88, 23, 'Respuesta Incorrecta', 0, 1),
(89, 23, 'Respuesta Incorrecta', 0, 2),
(90, 23, 'Respuesta CORRECTA', 1, 3),
(91, 23, 'Respuesta Incorrecta', 0, 4),
(92, 24, 'Pues no, son todos altos y delgados, de patas finas', 0, 1),
(93, 24, 'Si, por supuesto. Los que comen más de 5 veces al día.', 0, 2),
(94, 24, 'No son gordos, son fáciles de ver.', 1, 3),
(95, 24, 'Si, sin más.', 0, 4),
(104, 35, 'La categoría unicial es actualidad y pelis', 0, 1),
(105, 35, 'esto da igual', 0, 2),
(106, 35, 'esto tambien', 0, 3),
(107, 35, 'y esto igualmente', 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumen`
--

CREATE TABLE IF NOT EXISTS `resumen` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Partida` int(8) NOT NULL,
  `iCasilla` int(8) NOT NULL,
  `iGrupo` int(8) NOT NULL,
  `iPosAnt` int(8) NOT NULL COMMENT 'Posición inmediatamente anterior a la actual.',
  `iPosJuego` int(8) NOT NULL DEFAULT '0' COMMENT 'Orden en el que los grupos van acabando el juego.',
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Volcado de datos para la tabla `resumen`
--

INSERT INTO `resumen` (`iId`, `iId_Partida`, `iCasilla`, `iGrupo`, `iPosAnt`, `iPosJuego`) VALUES
(17, 11, 18, 1, 18, 1),
(18, 11, 18, 2, 17, 4),
(19, 11, 18, 3, 15, 3),
(20, 11, 18, 4, 17, 7),
(21, 11, 18, 5, 14, 5),
(29, 14, 23, 1, 20, 4),
(30, 14, 23, 2, 19, 2),
(31, 14, 23, 3, 22, 3),
(32, 14, 23, 4, 17, 1),
(45, 19, 11, 1, 8, 0),
(46, 19, 17, 2, 12, 0),
(47, 19, 18, 3, 14, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulacion`
--

CREATE TABLE IF NOT EXISTS `titulacion` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sTitulacion` varchar(128) NOT NULL,
  `iId_Universidad` int(32) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `titulacion`
--

INSERT INTO `titulacion` (`iId`, `sTitulacion`, `iId_Universidad`) VALUES
(1, 'Grado en Biotecnología', 3),
(2, 'Grado en Ingeniería Informática', 1),
(3, 'Grado en Ingeniería Industrial', 1),
(5, 'Grado en Ingeniería de Producto', 3),
(6, 'Grado en Ingeniería Naval', 1),
(9, 'asdasdas', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universidad`
--

CREATE TABLE IF NOT EXISTS `universidad` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sUniversidad` varchar(256) NOT NULL,
  `sDireccion` varchar(256) NOT NULL,
  `sCP` varchar(32) NOT NULL,
  `sLocalidad` varchar(125) NOT NULL,
  `sProvincia` varchar(125) NOT NULL,
  `sPais` varchar(64) NOT NULL,
  `nTelefono` varchar(64) NOT NULL,
  `nFax` varchar(64) NOT NULL,
  `sWeb` varchar(125) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `universidad`
--

INSERT INTO `universidad` (`iId`, `sUniversidad`, `sDireccion`, `sCP`, `sLocalidad`, `sProvincia`, `sPais`, `nTelefono`, `nFax`, `sWeb`) VALUES
(1, 'Escuela Superior de Ingeniería (ESI)', 'Avda. Universidad, s/n', '11011', 'Puerto Real', 'Cádiz', 'España', '956772282', '', 'esingenieria.uca.es'),
(3, 'Universidad de Sevilla', 'C/ Caca', '8383838', 'Sevilla', 'Sevilla', 'España', '38383838', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sNombre` varchar(32) NOT NULL,
  `sApellidos` varchar(128) NOT NULL,
  `sUsuario` varchar(32) NOT NULL,
  `sPassword` varchar(64) NOT NULL,
  `sEmail` varchar(128) NOT NULL,
  `iPerfil` int(2) NOT NULL COMMENT '0 (Perfil profesor/Administrador); 1 (Perfil de alumno)',
  `token` varchar(64) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `request_token` timestamp NULL DEFAULT NULL,
  `iAdmin` int(8) NOT NULL DEFAULT '0' COMMENT '1: Admin/ 0: no admin',
  `bActivo` tinyint(1) NOT NULL COMMENT 'Usuario activo o no activo.',
  `bBloqueado` tinyint(1) NOT NULL COMMENT 'Usuario bloqueado por algun motivo de seguridad.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Usuarios VIRUCA' AUTO_INCREMENT=57 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`iId`, `sNombre`, `sApellidos`, `sUsuario`, `sPassword`, `sEmail`, `iPerfil`, `token`, `created_at`, `request_token`, `iAdmin`, `bActivo`, `bBloqueado`) VALUES
(1, 'María', 'Martín Marín', 'mariamartin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'maria.martin.marin@gmail.com', 0, '', '2017-04-11 08:56:41', NULL, 1, 0, 0),
(12, 'Maríass', 'Martín Marín', 'mariamaria', '49518a5bba04f0d047a86e56218d966a', 'maria@jffjf.com', 1, '', '2017-04-11 08:56:41', NULL, 0, 0, 0),
(14, 'Iván', 'Insua Gomes', 'IvanInsua', 'c01e7d92a529a9c48dc3b64d071e3a5e', 'ivandhd@jdjdjd.com', 1, '', '2017-04-11 08:56:41', NULL, 0, 0, 0),
(15, 'Á-qui', 'Insua Gomes', 'AquiInsua', 'c7ad53e3a0c79ad2d40973b3fc523a90', 'aqui@putoenano.es', 1, '', '2017-04-11 08:56:41', NULL, 0, 0, 0),
(17, 'María', 'Martín Marín', 'mariamartin', '15143c59da9c7442c44388756cf363b242b238ff', 'maria.martin.marin@gmail.com', 1, '', '2017-04-11 08:56:41', NULL, 0, 0, 0),
(22, 'Ivancito', 'Insua Gomes', 'sjkdlsjdkfl', '33d491a04880eeb0021c8c55b8ec067c', 'maria.martin.marin@gmail.com', 2, '', '2017-04-20 19:13:44', NULL, 0, 0, 0),
(24, 'Á-qui', 'Insua Gomes', 'ksdjflksdfjlk', '84f2750a12627711a44a29f2b6018bcc', 'mari.martin.marin@gmail.com', 2, '', '2017-04-20 19:18:42', NULL, 0, 0, 0),
(26, 'Alumno', 'Alumno', 'lskdjkdfh', '41ed3ac606de10b4067aebc7f76ead5d91bdc618', 'mari.martin.marin@gmail.com', 1, '', '2017-04-20 19:41:58', NULL, 0, 0, 0),
(43, 'alumno', 'alumno', 'alumno', '79e9bf7414e7b219a77b8e64537ecba3daba52ca', 'mari.martin.marin@gmail.com', 1, '', '2017-04-27 09:41:56', NULL, 0, 0, 0),
(45, 'profeb', 'kjsklsdfj', 'profeborrar', '81c6bb71594729c11483fdbe04739d111ebf1e8e', 'jdjdjdj@jdjdjdjd.com', 2, '', '2017-04-28 16:58:15', NULL, 0, 0, 0),
(46, 'María', 'Martín Marín', 'mariamartin', '855e09a132cd803c747d41abe4764648e3facc72', 'maria.martin.marin@gmail.com', 1, '', '2017-05-26 21:40:40', NULL, 0, 0, 0),
(47, 'pruebas', 'pruebas', 'pruebas', 'c23faad28d4686e546d65f77ecdb95c109947e6b', 'maria.martin.marin@gmail.com', 2, '', '2017-05-28 17:24:09', NULL, 0, 0, 0),
(48, 'Usuario', 'No Administrador', 'mariamartin', '5c4679b3f39de0aa169f129ca4ebe184f817c422', 'majsdjkas@jdjdjd.com', 0, '', '2017-07-12 18:14:19', NULL, 0, 0, 0),
(49, 'Pepe', 'Pómez', 'profesor', '182c9721fe03e9ba2d03dda5f1d5d04aa3854051', 'maria.martin.marin@gmail.com', 0, '', '2017-07-25 09:19:12', NULL, 0, 0, 0),
(50, 'Marco', 'Melandri', 'alumno', '24ba36019fbfba19fdb888d7ef750d6064d5dc14', 'majsdjkas@jdjdjd.com', 1, '', '2017-07-25 09:25:15', NULL, 0, 0, 0),
(51, 'asdasd', 'asdaasdasdsd', 'asdasd', '85136c79cbf9fe36bb9d05d0639c70c265c18d37', 'masdasdasd', 0, '', '2017-07-28 11:35:29', NULL, 0, 1, 0),
(52, 'Prueba', 'Prueba', 'jjdjdj', '234f54819657708bcccc144d949b49d908ed7258', 'sdkjfksjdklj', 0, '', '2017-07-28 11:42:19', NULL, 0, 1, 1),
(54, 'Á-qui', 'Insua Gomes', 'aquicito', 'f9b32533eefe2616d38c244645c14fcbb746d76a', 'aqui@soypequeno.es', 0, '', '2017-07-28 14:26:46', NULL, 1, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarioscurso`
--

CREATE TABLE IF NOT EXISTS `usuarioscurso` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Titulacion` int(8) NOT NULL COMMENT 'Identificador de la titulación',
  `iId_Asignatura` int(8) NOT NULL COMMENT 'Identificador de la asingatura.',
  `iId_Usuario` int(8) NOT NULL COMMENT 'Identificador del alumno o profesor.',
  `iId_Universidad` int(32) NOT NULL,
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `usuarioscurso`
--

INSERT INTO `usuarioscurso` (`iId`, `iId_Titulacion`, `iId_Asignatura`, `iId_Usuario`, `iId_Universidad`) VALUES
(1, 1, 2, 49, 0),
(2, 1, 2, 50, 0),
(4, 2, 3, 50, 0),
(9, 2, 4, 54, 1),
(10, 5, 9, 54, 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
