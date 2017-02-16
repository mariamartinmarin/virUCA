-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-02-2017 a las 20:49:20
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
  `dFecha` date NOT NULL,
  `sIP` varchar(64) NOT NULL,
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sNombre` varchar(256) NOT NULL,
  `sDescripcion` varchar(2048) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Preguntas VirUCA' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Titulacion` int(8) NOT NULL,
  `iId_Asignatura` int(8) NOT NULL,
  `sCurso` varchar(128) NOT NULL COMMENT 'Aqui ponemos el Curso académico.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Curso Partida VirUCA' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE IF NOT EXISTS `partida` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dFecha` date NOT NULL,
  `nGrupos` int(2) NOT NULL COMMENT 'Número de grupos que se crean en la partida.',
  `bFinalizada` tinyint(1) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Partida VirUCA.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE IF NOT EXISTS `pregunta` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sPregunta` varchar(512) NOT NULL,
  `nPuntuacion` float NOT NULL,
  `bActiva` tinyint(1) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Preguntas VirUCA. Esta tabla almacenará las preguntas del juego.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE IF NOT EXISTS `respuesta` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iId_Pregunta` int(16) NOT NULL,
  `sRespuesta` varchar(512) NOT NULL,
  `bVerdadera` tinyint(1) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Respuestas VirUCA. Se almacenarán las diferentes respuestas.' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulacion`
--

CREATE TABLE IF NOT EXISTS `titulacion` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sTitulacion` varchar(128) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `titulacion`
--

INSERT INTO `titulacion` (`iId`, `sTitulacion`) VALUES
(1, 'Grado en Biotecnología'),
(2, 'Grado en Ingeniería Informática'),
(3, 'Grado en Ingeniería Industrial'),
(4, 'Ciencias de la Salud');

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
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Usuarios VIRUCA' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`iId`, `sNombre`, `sApellidos`, `sUsuario`, `sPassword`, `sEmail`, `iPerfil`) VALUES
(1, 'María', 'Martín Marín', 'mariamartin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'maria.martin.marin@gmail.com', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;