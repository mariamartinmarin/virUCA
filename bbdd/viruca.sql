-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2017 a las 21:14:02
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=139 ;

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
  `iId_Titulacion` int(11) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sNombre` varchar(256) NOT NULL,
  `sDescripcion` varchar(2048) NOT NULL,
  `sColor` varchar(8) NOT NULL COMMENT 'Código hex del color de la categoría.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Preguntas VirUCA' AUTO_INCREMENT=16 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

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
-- Estructura de tabla para la tabla `panel`
--

CREATE TABLE IF NOT EXISTS `panel` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iCasillas` int(32) NOT NULL COMMENT 'Número de casillas del panel.',
  `sNombre` varchar(32) NOT NULL COMMENT 'Nombre del panel',
  `bActivo` tinyint(1) NOT NULL DEFAULT '0',
  `bEliminar` tinyint(1) NOT NULL DEFAULT '1',
  `iId_Propietario` int(11) NOT NULL COMMENT 'Identificador del usuario que ha creado el panel.',
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE IF NOT EXISTS `parametros` (
  `iActiva` int(32) NOT NULL,
  `iId` int(8) NOT NULL,
  PRIMARY KEY (`iId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Partida VirUCA.' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE IF NOT EXISTS `pregunta` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sPregunta` varchar(512) NOT NULL,
  `nPuntuacion` float NOT NULL,
  `bActiva` tinyint(1) NOT NULL,
  `iId_Usuario` int(11) NOT NULL,
  `iId_Categoria` int(11) NOT NULL,
  `sObservaciones` varchar(3000) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Preguntas VirUCA. Esta tabla almacenará las preguntas del juego.' AUTO_INCREMENT=24 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Respuestas VirUCA. Se almacenarán las diferentes respuestas.' AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `titulacion`
--

CREATE TABLE IF NOT EXISTS `titulacion` (
  `iId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sTitulacion` varchar(128) NOT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

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
  `iId_Titulacion` int(11) NOT NULL,
  `token` varchar(64) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `request_token` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iId`),
  UNIQUE KEY `iId` (`iId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Usuarios VIRUCA' AUTO_INCREMENT=46 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
