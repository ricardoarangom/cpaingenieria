-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-06-2024 a las 12:12:53
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cpa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `IdArea` int(11) NOT NULL,
  `area` varchar(70) NOT NULL,
  `IdDirector` int(11) DEFAULT '0',
  `IdSubdirector` int(11) DEFAULT '0',
  `IdEmpresa` int(11) DEFAULT '1',
  `ccostos` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`IdArea`, `area`, `IdDirector`, `IdSubdirector`, `IdEmpresa`, `ccostos`) VALUES
(1, 'PERU', 2, 0, 1, '4106'),
(2, 'EMERAD - EIA LIC AMB CAMPO CAPELLA', 1, 0, 1, '4149'),
(3, 'EMERALD CONSUL AMB BLOQUES PAÍS', 0, 0, 1, '4150'),
(4, 'ENEL - INTERVENTORIA PARQ SOLAR EL PASO', 0, 0, 1, '4151'),
(5, 'EMERALD - CAMPO RICO - MATAMBO CTA CONJU - PLAN DE INVE', 0, 0, 1, '4152'),
(6, 'UT CPA -GEOESTUDIO EST AMBIENTALES', 0, 0, 1, '4154'),
(7, 'UT CPA - GEOTOTAL CANACOL ENERGY COLOMBIA', 0, 0, 1, '4156'),
(8, 'EMERALD INTERVENTORA AMBIENTAL OPERACIONES 100%', 0, 0, 1, '4158'),
(9, 'CODENSA ENEL - MON - ARQ - AT POR DEMANDA', 0, 0, 1, '4163'),
(10, 'ENERGY-PETROLEOS SUD FLORISTA*FORESTAL', 0, 0, 1, '4167'),
(11, 'EMGESA S.A.ESP –GRUPO ENEL Colombia', 0, 0, 1, '4173'),
(12, 'ISA INTERCOLOMBIA-ELAB-EST AMB-SOCIAL', 0, 0, 1, '4175'),
(13, 'ENEL-ARQUEOLOGIA SOLAR FUNDACION', 0, 0, 1, '4176'),
(14, 'PARADOR', 0, 0, 1, '4177'),
(15, 'CORANTIOQUIA-POMCA GUADALUPE', 0, 0, 1, '4179'),
(16, 'ESTUDIOS AMBIENTALES EMBALSE DEL MUÑA', 0, 0, 1, '4182'),
(17, 'PROYECTO ICAS ENEL', 0, 0, 1, '4183'),
(18, 'ECOPETROL S.A - REFINERIA DE CARTAGENA', 0, 0, 1, '4185'),
(19, 'AERONAUTOCA CIVIL EAI TOLÚ', 0, 0, 1, '4186'),
(20, 'ANDINA DE ENERGIA MONITOREOS AMBIENTALES', 0, 0, 1, '4187'),
(21, 'OBRAS SERVICIOS MEDIDAS COMPEN ECOPETROL', 0, 0, 1, '4189'),
(22, 'ENEL- ICA CENTRALES RIO BOGOTÁ', 0, 0, 1, '4190'),
(23, 'GP ENERGIA BOGOTA- EIA LA SUB EST HUILA', 0, 0, 1, '4191'),
(24, 'ENEL- ARQUEOLOGIA AT PM&C POR DEMANDA', 0, 0, 1, '4192'),
(25, 'AERONAUTICA ICA´S - CENTRO SUR Y ORIENTE', 0, 0, 1, '4193'),
(26, 'INGENIERIA', 0, 0, 1, '4088'),
(27, 'GERENCIA', 0, 0, 1, '9001'),
(28, 'SUBGERENCIA', 0, 0, 1, '9002'),
(29, 'LICITACIONES', 0, 0, 1, '9003'),
(30, 'RECURSOS HUMANOS', 0, 0, 1, '9004'),
(31, 'SERVICIOS GENERALES', 0, 0, 1, '9005'),
(32, 'CONTABILIDAD', 0, 0, 1, '9006'),
(33, 'RECEPCIÓN', 0, 0, 1, '9007'),
(34, 'LABORATORIO', 0, 0, 1, '9008'),
(35, 'CASA CALLE 106 NO. 59-21', 0, 0, 1, '9009'),
(36, 'SISTEMAS DE CALIDAD HSEQ', 0, 0, 1, '9010'),
(37, 'CASA LONG', 0, 0, 1, '9011'),
(38, 'CAMPO ALEGRE_CALDAS', 0, 0, 1, '9012'),
(39, 'PROY CAMPO ALEGRE POR ESTAC', 0, 0, 1, '9013'),
(40, 'CASA MAYOR DOMO', 0, 0, 1, '9013MY0'),
(41, 'VEREDA CAMPO ALEGRE', 0, 0, 1, '9013VCA'),
(42, 'CUARTEL', 0, 0, 1, '9013CL0'),
(43, 'CULTIVO', 0, 0, 1, '9013CT0'),
(44, 'AREA DE PRODUCCION', 0, 0, 1, '9013PR0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `IdBanco` int(11) NOT NULL,
  `banco` varchar(50) DEFAULT NULL,
  `nit` varchar(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT '0',
  `codigo` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`IdBanco`, `banco`, `nit`, `IdProveedor`, `codigo`) VALUES
(1, 'BANCO DE BOGOTA', '860002964', 3295, '001'),
(2, 'BANCO POPULAR', '860007738', 3308, '002'),
(3, 'BANCOLOMBIA', '890903938', 3311, '007'),
(4, 'CITIBANK', '860051135', 3313, '009'),
(5, 'BANCO GNB SUDAMERIS', '860050750', 3304, '012'),
(6, 'BBVA COLOMBIA', '860003020', 3139, '013'),
(7, 'BANCO ITAU (SANTANDER)', '890903937', 3161, '006'),
(8, 'SCOTIABANK COLPATRIA S.A', '860034594', 3314, '019'),
(9, 'BANCO DE OCCIDENTE', '890300279', 3302, '023'),
(10, 'BANCO CAJA SOCIAL BCSC SA', '860007335', 3298, '032'),
(11, 'BANCO AGRARIO', '800037800', 3296, '040'),
(12, 'BANCO MUNDO MUJER', '900768933', 3306, NULL),
(13, 'BANCO DAVIVIENDA SA', '860034313', 3301, '051'),
(14, 'BANCO AV VILLAS', '860035827', 3297, '052'),
(15, 'BANCO W S.A.', '900378212', 3310, '053'),
(16, 'BANCO PROCREDIT COLOMBIA', '900200960', 3309, '058'),
(17, 'BANCAMIA S.A.', '900215071', 3317, '059'),
(18, 'BANCO PICHINCHA', '890200756', 3307, '060'),
(19, 'BANCOOMEVA', '900406150', 3312, '061'),
(20, 'BANCO FALABELLA S.A.', '900047981', 3303, '062'),
(21, 'BANCO FINANDINA S.A.', '860051894', 3140, '063'),
(22, 'BANCO MULTIBANK S.A.', '860024414', 3305, NULL),
(23, 'BANCO SANTANDER DE NEGOCIOS COLOMBIA S.A', '900628110', 3315, '065'),
(24, 'BANCO COOPERATIVO COOPCENTRAL', '890203088', 3300, '066'),
(25, 'BANCO COMPARTIR S.A', '860025971', 3299, '067'),
(26, 'BANCO SERFINANZA S.A', '860043186', 3316, '069'),
(27, 'NEQUI', NULL, 0, NULL),
(28, 'DAVIPLATA', NULL, 0, NULL),
(29, 'EFECTY', NULL, 0, NULL),
(30, 'CAJA MENOR', NULL, 0, NULL),
(31, 'UALA', '901502301', 0, NULL),
(32, 'PSE', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasecuenta`
--

CREATE TABLE `clasecuenta` (
  `IdClasecuenta` int(11) NOT NULL,
  `ccuenta` varchar(20) DEFAULT NULL,
  `codigone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clasecuenta`
--

INSERT INTO `clasecuenta` (`IdClasecuenta`, `ccuenta`, `codigone`) VALUES
(1, 'AHORROS', '1-Ahorros'),
(2, 'CORRIENTE', '2-Corriente'),
(3, 'DEPOSITO ELECTRONICO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasesisc`
--

CREATE TABLE `clasesisc` (
  `IdClase` int(11) NOT NULL,
  `clase` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clasesisc`
--

INSERT INTO `clasesisc` (`IdClase`, `clase`) VALUES
(1, 'DOTACION'),
(2, 'EXAMENES MÉDICOS'),
(3, 'CALIBRACIÓN'),
(4, 'MANTENIMIENTOS'),
(5, 'COMPRAS DE INSUMOS'),
(6, 'COMPRAS DE EQUIPOS'),
(7, 'RECURSOS TÉCNICOS'),
(8, 'MONITOREOS'),
(9, 'ANALISIS DE LABORATORIO'),
(10, 'TRANSPORTES'),
(11, 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasproveedores`
--

CREATE TABLE `clasproveedores` (
  `IdClasificacion` int(11) NOT NULL,
  `clasificacion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clasproveedores`
--

INSERT INTO `clasproveedores` (`IdClasificacion`, `clasificacion`) VALUES
(1, 'SERVICIOS DE CONSULTORÍA Y/O PROFESIONALES ESPECIALIZADOS'),
(2, 'EMPRESAS DE SERVICIOS'),
(3, 'SERVICIOS DE ANÁLISIS DE MUESTRAS'),
(4, 'SERVICIOS DE PROFESIONALES ESPECIALIZADOS MONITOREO'),
(5, 'SERVICIOS DE LABORATORIO PARA MONITOREO'),
(6, 'COMPRA DE REACTIVOS'),
(7, 'COMPRA DE REACTIVOS CONTROLADOS'),
(8, 'COMPRA O ALQUILER DE EQUIPOS DE MEDICIÓN'),
(9, 'SERVICIOS DE CALIBRACIÓN, VERIFICACIÓN, MANTENIMIENTO DE EQUIPOS  Y ANÁLISIS DE MUESTRAS'),
(10, 'EXÁMENES MÉDICOS OCUPACIONALES'),
(11, 'PRUEBAS DE LABORATORIO PCR'),
(12, 'SERVICIOS DE EXÁMENES PSICOSENSOMETRICOS PARA CONDUCTORES'),
(13, 'SERVICIOS DE PRUEBAS TEÓRICAS DE CONOCIMIENTO EN CONDUCCIÓN y PRUEBAS PRÁCTICAS DE OPERACIÓN DE VEHÍCULOS  (PRUEBAS PSICOTECNICAS)'),
(14, 'GESTOR DE RECICLAJE'),
(15, 'GESTOR DE RESIDUOS PELIGROSOS'),
(16, 'MANTENIMIENTO DE INFRAESTRUCTURA'),
(17, 'SERVICIO DE TRANSPORTE DE PERSONAL Y CARGA'),
(18, 'SERVICIO DE TALLER DE MECÁNICA AUTOMOTRIZ'),
(19, 'SERVICIO SEGURIDAD PRIVADA'),
(20, 'SERVICIOS DE EVALUACIÓN PSICOTÉCNICA PARA SELECCIÓN DE PERSONAL'),
(21, 'PRODUCTOS DE ASEO'),
(22, 'DOTACIONES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `IdCompra` int(11) NOT NULL,
  `IdOrdencompra` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `comprado` date DEFAULT NULL,
  `recibido` date DEFAULT NULL,
  `calpro` tinyint(4) DEFAULT '0',
  `precio` tinyint(4) DEFAULT '0',
  `condpago` tinyint(4) DEFAULT '0',
  `cumplimiento` tinyint(4) DEFAULT '0',
  `higsegind` tinyint(4) DEFAULT '0',
  `gesamb` tinyint(4) DEFAULT '0',
  `rse` tinyint(4) DEFAULT '0',
  `evaluacion` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`IdCompra`, `IdOrdencompra`, `IdProveedor`, `fecha`, `comprado`, `recibido`, `calpro`, `precio`, `condpago`, `cumplimiento`, `higsegind`, `gesamb`, `rse`, `evaluacion`) VALUES
(1, 1, 1, '2024-01-02', '2024-01-02', '2024-04-26', 20, 16, 16, 13, 16, 10, 9, 100),
(2, 1, 2, '2024-01-02', '2024-01-02', NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 4, 1, '2024-02-09', '2024-02-12', NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 6, 2, '2024-02-09', '2024-02-12', NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 6, 9, '2024-02-09', '2024-02-12', NULL, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `IdCotizacion` int(11) NOT NULL,
  `IdItem` int(11) DEFAULT NULL,
  `IdProveedor` int(11) DEFAULT NULL,
  `precio` decimal(12,2) DEFAULT NULL,
  `descuento` decimal(3,2) DEFAULT NULL,
  `iva` decimal(3,2) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cotizacion` varchar(100) DEFAULT NULL,
  `observaciones` text,
  `autorizada` tinyint(4) DEFAULT '0',
  `IdOrdencompra` int(11) DEFAULT NULL,
  `IdFpago` int(11) DEFAULT '0',
  `IdMpago` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`IdCotizacion`, `IdItem`, `IdProveedor`, `precio`, `descuento`, `iva`, `fecha`, `cotizacion`, `observaciones`, `autorizada`, `IdOrdencompra`, `IdFpago`, `IdMpago`) VALUES
(1, 1, 9, '5000.00', '0.00', '0.00', '2024-02-15', NULL, '', 0, 1, 1, 1),
(2, 1, 3, '4000.00', '0.00', '0.00', '2024-02-15', NULL, '', 1, 1, 2, 2),
(3, 6, 2, '3000.00', '0.00', '0.00', '2024-02-15', NULL, '', 1, 1, 1, 1),
(4, 6, 1, '4000.00', '0.00', '0.00', '2024-02-15', NULL, '', 0, 1, 2, 2),
(5, 7, 1, '5000.00', '0.00', '0.00', '2024-02-15', NULL, '', 1, 1, 3, 4),
(6, 7, 2, '2000.00', '0.00', '0.00', '2024-02-15', NULL, '', 0, 1, 2, 2),
(7, 5, 10, '5.00', '0.00', '0.00', '2024-03-08', 'cotizaciones/20240308110758-5-cotizacion.pdf', '', 0, 3, 1, 1),
(8, 13, 13, '1000.00', '0.00', '0.00', '2024-04-19', NULL, '', 1, 7, 2, 4),
(11, 15, 1, '15000.00', '0.00', '0.00', '2024-04-20', NULL, '', 0, 9, 1, 2),
(12, 15, 14, '150000.00', '0.00', '0.19', '2024-04-20', NULL, '', 1, 9, 1, 1),
(13, 13, 15, '1200.00', '0.05', '0.19', '2024-04-21', NULL, '', 0, 7, 1, 2),
(14, 14, 13, '50000.00', '0.03', '0.19', '2024-04-21', NULL, '', 0, 9, 3, 3),
(15, 14, 15, '30000.00', '0.00', '0.19', '2024-04-21', NULL, '', 1, 9, 2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `IdDepartamento` int(11) NOT NULL,
  `departamentos` varchar(25) NOT NULL,
  `codigo` int(11) NOT NULL,
  `codigo2` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`IdDepartamento`, `departamentos`, `codigo`, `codigo2`) VALUES
(1, 'ANTIOQUIA', 5, '_05_Antioquia'),
(2, 'ATLANTICO', 8, '_08_Atlántico'),
(3, 'BOGOTA D. C.', 11, '_11_Bogotá'),
(4, 'BOLIVAR', 13, '_13_Bolívar'),
(5, 'BOYACA', 15, '_15_Boyacá'),
(6, 'CALDAS', 17, '_17_Caldas'),
(7, 'CAQUETA', 18, '_18_Caquetá'),
(8, 'CAUCA', 19, '_19_Cauca'),
(9, 'CESAR', 20, '_20_Cesar'),
(10, 'CORDOBA', 23, '_23_Córdoba'),
(11, 'CUNDINAMARCA', 25, '_25_Cundinamarca'),
(12, 'CHOCO', 27, '_27_Chocó'),
(13, 'HUILA', 41, '_41_Huila'),
(14, 'LA GUAJIRA', 44, '_44_La_Guajira'),
(15, 'MAGDALENA', 47, '_47_Magdalena'),
(16, 'META', 50, '_50_Meta'),
(17, 'NARIÑO', 52, '_52_Nariño'),
(18, 'NORTE DE SANTANDER', 54, '_54_Norte_de_Santander'),
(19, 'QUINDIO', 63, '_63_Quindío'),
(20, 'RISARALDA', 66, '_66_Risaralda'),
(21, 'SANTANDER', 68, '_68_Santander'),
(22, 'SUCRE', 70, '_70_Sucre'),
(23, 'TOLIMA', 73, '_73_Tolima'),
(24, 'VALLE DEL CAUCA', 76, '_76_Valle_del_Cauca'),
(25, 'ARAUCA', 81, '_81_Arauca'),
(26, 'CASANARE', 85, '_85_Casanare'),
(27, 'PUTUMAYO', 86, '_86_Putumayo'),
(28, 'SAN ANDRES Y PROVIDENCIA', 88, '_88_San_Andrés_y_Providencia'),
(29, 'AMAZONAS', 91, '_91_Amazonas'),
(30, 'GUAINIA', 94, '_94_Guainía'),
(31, 'GUAVIARE', 95, '_95_Guaviare'),
(32, 'VAUPES', 97, '_97_Vaupés'),
(33, 'VICHADA', 99, '_99_Vichada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE `empresas` (
  `IdEmpresa` int(11) NOT NULL,
  `empresa` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nit` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `IdAutorizador` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresas`
--

INSERT INTO `empresas` (`IdEmpresa`, `empresa`, `nit`, `direccion`, `telefono`, `IdAutorizador`) VALUES
(1, 'CPA INGENIERIA S.A.S', '11111111', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fpago`
--

CREATE TABLE `fpago` (
  `IdFpago` int(11) NOT NULL,
  `fpago` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `fpago`
--

INSERT INTO `fpago` (`IdFpago`, `fpago`) VALUES
(1, 'Previo a la entrega'),
(2, 'Contraentrega'),
(3, '30 Dias'),
(4, '60 Dias'),
(5, '90 Dias'),
(6, '% de pago según acuerdo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gviaje`
--

CREATE TABLE `gviaje` (
  `IdGviaje` int(11) NOT NULL,
  `IdSolicitante` int(11) DEFAULT '0',
  `IdArea` int(11) DEFAULT '0',
  `IdMunicipio` int(11) DEFAULT '0',
  `fsalida` date DEFAULT NULL,
  `fregreso` date DEFAULT NULL,
  `actividad` text,
  `beneficiario` varchar(45) DEFAULT NULL,
  `cedula` varchar(12) DEFAULT NULL,
  `IdBanco` int(11) DEFAULT '0',
  `clasecuenta` int(11) DEFAULT NULL,
  `cuenta` varchar(15) DEFAULT NULL,
  `fsolicitud` date DEFAULT NULL,
  `fautorizacion` date DEFAULT NULL,
  `fpago` date DEFAULT NULL,
  `rechazada` tinyint(4) DEFAULT '0',
  `IdAutorizador` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gviaje`
--

INSERT INTO `gviaje` (`IdGviaje`, `IdSolicitante`, `IdArea`, `IdMunicipio`, `fsalida`, `fregreso`, `actividad`, `beneficiario`, `cedula`, `IdBanco`, `clasecuenta`, `cuenta`, `fsolicitud`, `fautorizacion`, `fpago`, `rechazada`, `IdAutorizador`) VALUES
(1, 1, 2, 126, '2024-06-04', '2024-06-10', 'Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto.', 'RICARDO EMIRO ARANGO MURCIA', '79355327', 14, 1, '64700020418', '2024-06-25', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemcompra`
--

CREATE TABLE `itemcompra` (
  `IdItemcompra` int(11) NOT NULL,
  `IdCompra` int(11) DEFAULT NULL,
  `IdCotizacion` int(11) DEFAULT NULL,
  `IdItem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `itemcompra`
--

INSERT INTO `itemcompra` (`IdItemcompra`, `IdCompra`, `IdCotizacion`, `IdItem`) VALUES
(1, 1, 2, 1),
(2, 2, 3, 6),
(3, 3, 5, 7),
(4, 4, 8, 13),
(5, 5, 15, 14),
(6, 6, 12, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemgviaje`
--

CREATE TABLE `itemgviaje` (
  `IdItem` int(11) NOT NULL,
  `IdGviaje` int(11) DEFAULT '0',
  `rubro` varchar(15) DEFAULT NULL,
  `cantidad` float DEFAULT '0',
  `vunitario` decimal(16,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `itemgviaje`
--

INSERT INTO `itemgviaje` (`IdItem`, `IdGviaje`, `rubro`, `cantidad`, `vunitario`) VALUES
(1, 1, 'alojamiento', 1, '88000.00'),
(2, 1, 'hidratacion', 3, '7000.00'),
(3, 1, 'alimentacion', 1, '45000.00'),
(4, 1, 'taeropuerto', 1, '50000.00'),
(5, 1, 'imprevistos', 1, '20400.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemoc`
--

CREATE TABLE `itemoc` (
  `IdItem` int(11) NOT NULL,
  `IdOrdencompra` int(11) NOT NULL,
  `PS` tinyint(4) NOT NULL DEFAULT '1',
  `producto` text NOT NULL,
  `especificacion` text,
  `unidad` varchar(20) DEFAULT NULL,
  `cantidad` decimal(9,2) NOT NULL DEFAULT '0.00',
  `frequerido` date DEFAULT NULL,
  `cotizado` date DEFAULT NULL,
  `autorizado` date DEFAULT NULL,
  `comprado` date DEFAULT NULL,
  `entregado` date DEFAULT NULL,
  `observaciones` varchar(45) DEFAULT NULL,
  `derogada` tinyint(4) DEFAULT '0',
  `observarecibo` text,
  `inspec` decimal(3,2) DEFAULT NULL,
  `cument` tinyint(4) DEFAULT NULL,
  `cumreq` tinyint(4) DEFAULT NULL,
  `muestreo` tinyint(4) DEFAULT NULL,
  `recibidopor` int(11) DEFAULT NULL,
  `conforme` tinyint(4) DEFAULT NULL,
  `cantrreci` decimal(9,2) DEFAULT '0.00',
  `IdCalse` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `itemoc`
--

INSERT INTO `itemoc` (`IdItem`, `IdOrdencompra`, `PS`, `producto`, `especificacion`, `unidad`, `cantidad`, `frequerido`, `cotizado`, `autorizado`, `comprado`, `entregado`, `observaciones`, `derogada`, `observarecibo`, `inspec`, `cument`, `cumreq`, `muestreo`, `recibidopor`, `conforme`, `cantrreci`, `IdCalse`) VALUES
(1, 1, 1, 'aaaaa', 'sfsfdsfgf', 'M3', '2.00', '2023-12-26', '2024-02-15', '2024-02-15', '2024-02-15', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(3, 2, 1, 'aaaaa', 'sfsfdsfgf', 'M3', '1.00', '2023-12-20', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(4, 2, 0, 'bbbbb', 'sffds rhhhg', 'KG', '3.00', '2023-12-20', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(5, 3, 1, 'lhl ñkjñl ñljl ñll', 'hvkh kbjl knk', 'M3', '3.00', '2023-12-27', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(6, 1, 1, 'cccccc', 'sjhdsjdh lsdhlsk kshdks ', 'ML', '2.00', '2023-12-29', '2024-02-15', '2024-02-15', '2024-02-15', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(7, 1, 1, 'mmmmmm', 'fsf gds dag dvd', 'ML', '3.00', '2023-12-30', '2024-02-15', '2024-02-15', '2024-02-15', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(8, 4, 1, 'impresora', 'laser', 'UND', '1.00', '2024-01-21', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(9, 5, 1, 'computador', 'intel', 'UND', '1.00', '2024-01-22', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(10, 5, 1, 'monitor', '17 pulgadas', 'UND', '1.00', '2024-01-22', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(11, 6, 1, 'Memoria RAM', 'Módulo de 16 GB', 'Unidad', '4.00', '2024-02-10', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(12, 6, 1, 'Disco Duro', 'SSD de 1 TB', 'Unidad', '2.00', '2024-02-10', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 0),
(13, 7, 1, 'tonner', 'ggg', 'UND', '10.00', '2024-04-19', '2024-04-21', '2024-04-21', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 9),
(14, 9, 1, 'resmas tamaño carta', '', 'RESMA', '20.00', '2024-04-21', '2024-04-21', '2024-04-21', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 5),
(15, 9, 1, 'impresora', '', 'UND', '1.00', '2024-04-21', '2024-04-21', '2024-04-21', '2024-04-21', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediosp`
--

CREATE TABLE `mediosp` (
  `IdMpago` int(11) NOT NULL,
  `medio` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mediosp`
--

INSERT INTO `mediosp` (`IdMpago`, `medio`) VALUES
(1, 'Efectivo'),
(2, 'Tarjeta de credito'),
(3, 'Cheque'),
(4, 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `IdMunicipio` int(11) NOT NULL,
  `municipio` varchar(100) NOT NULL,
  `IdDepartamento` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `codigo2` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`IdMunicipio`, `municipio`, `IdDepartamento`, `codigo`, `codigo2`) VALUES
(1, 'MEDELLIN', 1, 1, '001-MEDELLÍN'),
(2, 'ABEJORRAL', 1, 2, '002-ABEJORRAL'),
(3, 'ABRIAQUI', 1, 4, '004-ABRIAQUÍ'),
(4, 'ALEJANDRIA', 1, 21, '021-ALEJANDRÍA'),
(5, 'AMAGA', 1, 30, '030-AMAGÁ'),
(6, 'AMALFI', 1, 31, '031-AMALFI'),
(7, 'ANDES', 1, 34, '034-ANDES'),
(8, 'ANGELOPOLIS', 1, 36, '036-ANGELÓPOLIS'),
(9, 'ANGOSTURA', 1, 38, '038-ANGOSTURA'),
(10, 'ANORI', 1, 40, '040-ANORÍ'),
(11, 'SANTAFE DE ANTIOQUIA', 1, 42, '042-SANTA FÉ DE ANTIOQUIA'),
(12, 'ANZA', 1, 44, '044-ANZÁ'),
(13, 'APARTADO', 1, 45, '045-APARTADÓ'),
(14, 'ARBOLETES', 1, 51, '051-ARBOLETES'),
(15, 'ARGELIA', 1, 55, '055-ARGELIA'),
(16, 'ARMENIA', 1, 59, '059-ARMENIA'),
(17, 'BARBOSA', 1, 79, '079-BARBOSA'),
(18, 'BELMIRA', 1, 86, '086-BELMIRA'),
(19, 'BELLO', 1, 88, '088-BELLO'),
(20, 'BETANIA', 1, 91, '091-BETANIA'),
(21, 'BETULIA', 1, 93, '093-BETULIA'),
(22, 'CIUDAD BOLIVAR', 1, 101, '101-CIUDAD BOLÍVAR'),
(23, 'BRICEÑO', 1, 107, '107-BRICEÑO'),
(24, 'BURITICA', 1, 113, '113-BURITICÁ'),
(25, 'CACERES', 1, 120, '120-CÁCERES'),
(26, 'CAICEDO', 1, 125, '125-CAICEDO'),
(27, 'CALDAS', 1, 129, '129-CALDAS'),
(28, 'CAMPAMENTO', 1, 134, '134-CAMPAMENTO'),
(29, 'CAÑASGORDAS', 1, 138, '138-CAÑASGORDAS'),
(30, 'CARACOLI', 1, 142, '142-CARACOLÍ'),
(31, 'CARAMANTA', 1, 145, '145-CARAMANTA'),
(32, 'CAREPA', 1, 147, '147-CAREPA'),
(33, 'EL CARMEN DE VIBORAL', 1, 148, '148-EL CARMEN DE VIBORAL'),
(34, 'CAROLINA', 1, 150, '150-CAROLINA'),
(35, 'CAUCASIA', 1, 154, '154-CAUCASIA'),
(36, 'CHIGORODO', 1, 172, '172-CHIGORODÓ'),
(37, 'CISNEROS', 1, 190, '190-CISNEROS'),
(38, 'COCORNA', 1, 197, '197-COCORNÁ'),
(39, 'CONCEPCION', 1, 206, '206-CONCEPCIÓN'),
(40, 'CONCORDIA', 1, 209, '209-CONCORDIA'),
(41, 'COPACABANA', 1, 212, '212-COPACABANA'),
(42, 'DABEIBA', 1, 234, '234-DABEIBA'),
(43, 'DON MATIAS', 1, 237, '237-DONMATÍAS'),
(44, 'EBEJICO', 1, 240, '240-EBÉJICO'),
(45, 'EL BAGRE', 1, 250, '250-EL BAGRE'),
(46, 'ENTRERRIOS', 1, 264, '264-ENTRERRÍOS'),
(47, 'ENVIGADO', 1, 266, '266-ENVIGADO'),
(48, 'FREDONIA', 1, 282, '282-FREDONIA'),
(49, 'FRONTINO', 1, 284, '284-FRONTINO'),
(50, 'GIRALDO', 1, 306, '306-GIRALDO'),
(51, 'GIRARDOTA', 1, 308, '308-GIRARDOTA'),
(52, 'GOMEZ PLATA', 1, 310, '310-GÓMEZ PLATA'),
(53, 'GRANADA', 1, 313, '313-GRANADA'),
(54, 'GUADALUPE', 1, 315, '315-GUADALUPE'),
(55, 'GUARNE', 1, 318, '318-GUARNE'),
(56, 'GUATAPE', 1, 321, '321-GUATAPÉ'),
(57, 'HELICONIA', 1, 347, '347-HELICONIA'),
(58, 'HISPANIA', 1, 353, '353-HISPANIA'),
(59, 'ITAGÜI', 1, 360, '360-ITAGÜÍ'),
(60, 'ITUANGO', 1, 361, '361-ITUANGO'),
(61, 'JARDIN', 1, 364, '364-JARDÍN'),
(62, 'JERICO', 1, 368, '368-JERICÓ'),
(63, 'LA CEJA', 1, 376, '376-LA CEJA'),
(64, 'LA ESTRELLA', 1, 380, '380-LA ESTRELLA'),
(65, 'LA PINTADA', 1, 390, '390-LA PINTADA'),
(66, 'LA UNION', 1, 400, '400-LA UNIÓN'),
(67, 'LIBORINA', 1, 411, '411-LIBORINA'),
(68, 'MACEO', 1, 425, '425-MACEO'),
(69, 'MARINILLA', 1, 440, '440-MARINILLA'),
(70, 'MONTEBELLO', 1, 467, '467-MONTEBELLO'),
(71, 'MURINDO', 1, 475, '475-MURINDÓ'),
(72, 'MUTATA', 1, 480, '480-MUTATÁ'),
(73, 'NARIÑO', 1, 483, '483-NARIÑO'),
(74, 'NECOCLI', 1, 490, '490-NECOCLÍ'),
(75, 'NECHI', 1, 495, '495-NECHÍ'),
(76, 'OLAYA', 1, 501, '501-OLAYA'),
(77, 'PEÑOL', 1, 541, '541-PEÑOL'),
(78, 'PEQUE', 1, 543, '543-PEQUE'),
(79, 'PUEBLORRICO', 1, 576, '576-PUEBLORRICO'),
(80, 'PUERTO BERRIO', 1, 579, '579-PUERTO BERRÍO'),
(81, 'PUERTO NARE', 1, 585, '585-PUERTO NARE'),
(82, 'PUERTO TRIUNFO', 1, 591, '591-PUERTO TRIUNFO'),
(83, 'REMEDIOS', 1, 604, '604-REMEDIOS'),
(84, 'RETIRO', 1, 607, '607-RETIRO'),
(85, 'RIONEGRO', 1, 615, '615-RIONEGRO'),
(86, 'SABANALARGA', 1, 628, '628-SABANALARGA'),
(87, 'SABANETA', 1, 631, '631-SABANETA'),
(88, 'SALGAR', 1, 642, '642-SALGAR'),
(89, 'SAN ANDRES DE CUERQUIA', 1, 647, '647-SAN ANDRÉS DE CUERQUÍA'),
(90, 'SAN CARLOS', 1, 649, '649-SAN CARLOS'),
(91, 'SAN FRANCISCO', 1, 652, '652-SAN FRANCISCO'),
(92, 'SAN JERONIMO', 1, 656, '656-SAN JERÓNIMO'),
(93, 'SAN JOSE DE LA MONTAÑA', 1, 658, '658-SAN JOSÉ DE LA MONTAÑA'),
(94, 'SAN JUAN DE URABA', 1, 659, '659-SAN JUAN DE URABÁ'),
(95, 'SAN LUIS', 1, 660, '660-SAN LUIS'),
(96, 'SAN PEDRO', 1, 664, '664-SAN PEDRO DE LOS MILAGROS'),
(97, 'SAN PEDRO DE URABA', 1, 665, '665-SAN PEDRO DE URABÁ'),
(98, 'SAN RAFAEL', 1, 667, '667-SAN RAFAEL'),
(99, 'SAN ROQUE', 1, 670, '670-SAN ROQUE'),
(100, 'SAN VICENTE', 1, 674, '674-SAN VICENTE FERRER'),
(101, 'SANTA BARBARA', 1, 679, '679-SANTA BÁRBARA'),
(102, 'SANTA ROSA DE OSOS', 1, 686, '686-SANTA ROSA DE OSOS'),
(103, 'SANTO DOMINGO', 1, 690, '690-SANTO DOMINGO'),
(104, 'EL SANTUARIO', 1, 697, '697-EL SANTUARIO'),
(105, 'SEGOVIA', 1, 736, '736-SEGOVIA'),
(106, 'SONSON', 1, 756, '756-SONSÓN'),
(107, 'SOPETRAN', 1, 761, '761-SOPETRÁN'),
(108, 'TAMESIS', 1, 789, '789-TÁMESIS'),
(109, 'TARAZA', 1, 790, '790-TARAZÁ'),
(110, 'TARSO', 1, 792, '792-TARSO'),
(111, 'TITIRIBI', 1, 809, '809-TITIRIBÍ'),
(112, 'TOLEDO', 1, 819, '819-TOLEDO'),
(113, 'TURBO', 1, 837, '837-TURBO'),
(114, 'URAMITA', 1, 842, '842-URAMITA'),
(115, 'URRAO', 1, 847, '847-URRAO'),
(116, 'VALDIVIA', 1, 854, '854-VALDIVIA'),
(117, 'VALPARAISO', 1, 856, '856-VALPARAÍSO'),
(118, 'VEGACHI', 1, 858, '858-VEGACHÍ'),
(119, 'VENECIA', 1, 861, '861-VENECIA'),
(120, 'VIGIA DEL FUERTE', 1, 873, '873-VIGÍA DEL FUERTE'),
(121, 'YALI', 1, 885, '885-YALÍ'),
(122, 'YARUMAL', 1, 887, '887-YARUMAL'),
(123, 'YOLOMBO', 1, 890, '890-YOLOMBÓ'),
(124, 'YONDO', 1, 893, '893-YONDÓ'),
(125, 'ZARAGOZA', 1, 895, '895-ZARAGOZA'),
(126, 'BARRANQUILLA', 2, 1, '001-BARRANQUILLA'),
(127, 'BARANOA', 2, 78, '078-BARANOA'),
(128, 'CAMPO DE LA CRUZ', 2, 137, '137-CAMPO DE LA CRUZ'),
(129, 'CANDELARIA', 2, 141, '141-CANDELARIA'),
(130, 'GALAPA', 2, 296, '296-GALAPA'),
(131, 'JUAN DE ACOSTA', 2, 372, '372-JUAN DE ACOSTA'),
(132, 'LURUACO', 2, 421, '421-LURUACO'),
(133, 'MALAMBO', 2, 433, '433-MALAMBO'),
(134, 'MANATI', 2, 436, '436-MANATÍ'),
(135, 'PALMAR DE VARELA', 2, 520, '520-PALMAR DE VARELA'),
(136, 'PIOJO', 2, 549, '549-PIOJÓ'),
(137, 'POLONUEVO', 2, 558, '558-POLONUEVO'),
(138, 'PONEDERA', 2, 560, '560-PONEDERA'),
(139, 'PUERTO COLOMBIA', 2, 573, '573-PUERTO COLOMBIA'),
(140, 'REPELON', 2, 606, '606-REPELÓN'),
(141, 'SABANAGRANDE', 2, 634, '634-SABANAGRANDE'),
(142, 'SABANALARGA', 2, 638, '638-SABANALARGA'),
(143, 'SANTA LUCIA', 2, 675, '675-SANTA LUCÍA'),
(144, 'SANTO TOMAS', 2, 685, '685-SANTO TOMÁS'),
(145, 'SOLEDAD', 2, 758, '758-SOLEDAD'),
(146, 'SUAN', 2, 770, '770-SUAN'),
(147, 'TUBARA', 2, 832, '832-TUBARÁ'),
(148, 'USIACURI', 2, 849, '849-USIACURÍ'),
(149, 'BOGOTA D.C.', 3, 1, '001-BOGOTÁ, D.C.'),
(150, 'CARTAGENA', 4, 1, '001-CARTAGENA DE INDIAS'),
(151, 'ACHI', 4, 6, '006-ACHÍ'),
(152, 'ALTOS DEL ROSARIO', 4, 30, '030-ALTOS DEL ROSARIO'),
(153, 'ARENAL', 4, 42, '042-ARENAL'),
(154, 'ARJONA', 4, 52, '052-ARJONA'),
(155, 'ARROYOHONDO', 4, 62, '062-ARROYOHONDO'),
(156, 'BARRANCO DE LOBA', 4, 74, '074-BARRANCO DE LOBA'),
(157, 'CALAMAR', 4, 140, '140-CALAMAR'),
(158, 'CANTAGALLO', 4, 160, '160-CANTAGALLO'),
(159, 'CICUCO', 4, 188, '188-CICUCO'),
(160, 'CORDOBA', 4, 212, '212-CÓRDOBA'),
(161, 'CLEMENCIA', 4, 222, '222-CLEMENCIA'),
(162, 'EL CARMEN DE BOLIVAR', 4, 244, '244-EL CARMEN DE BOLÍVAR'),
(163, 'EL GUAMO', 4, 248, '248-EL GUAMO'),
(164, 'EL PEÑON', 4, 268, '268-EL PEÑÓN'),
(165, 'HATILLO DE LOBA', 4, 300, '300-HATILLO DE LOBA'),
(166, 'MAGANGUE', 4, 430, '430-MAGANGUÉ'),
(167, 'MAHATES', 4, 433, '433-MAHATES'),
(168, 'MARGARITA', 4, 440, '440-MARGARITA'),
(169, 'MARIA LA BAJA', 4, 442, '442-MARÍA LA BAJA'),
(170, 'MONTECRISTO', 4, 458, '458-MONTECRISTO'),
(171, 'MOMPOS', 4, 468, '468-MOMPÓS'),
(172, 'NOROSI', 4, 490, '490-NOROSÍ'),
(173, 'MORALES', 4, 473, '473-MORALES'),
(174, 'PINILLOS', 4, 549, '549-PINILLOS'),
(175, 'REGIDOR', 4, 580, '580-REGIDOR'),
(176, 'RIO VIEJO', 4, 600, '600-RÍO VIEJO'),
(177, 'SAN CRISTOBAL', 4, 620, '620-SAN CRISTÓBAL'),
(178, 'SAN ESTANISLAO', 4, 647, '647-SAN ESTANISLAO'),
(179, 'SAN FERNANDO', 4, 650, '650-SAN FERNANDO'),
(180, 'SAN JACINTO', 4, 654, '654-SAN JACINTO'),
(181, 'SAN JACINTO DEL CAUCA', 4, 655, '655-SAN JACINTO DEL CAUCA'),
(182, 'SAN JUAN NEPOMUCENO', 4, 657, '657-SAN JUAN NEPOMUCENO'),
(183, 'SAN MARTIN DE LOBA', 4, 667, '667-SAN MARTÍN DE LOBA'),
(184, 'SAN PABLO', 4, 670, '670-SAN PABLO SUR'),
(185, 'SANTA CATALINA', 4, 673, '673-SANTA CATALINA'),
(186, 'SANTA ROSA', 4, 683, '683-SANTA ROSA DE LIMA'),
(187, 'SANTA ROSA DEL SUR', 4, 688, '688-SANTA ROSA DEL SUR'),
(188, 'SIMITI', 4, 744, '744-SIMITÍ'),
(189, 'SOPLAVIENTO', 4, 760, '760-SOPLAVIENTO'),
(190, 'TALAIGUA NUEVO', 4, 780, '780-TALAIGUA NUEVO'),
(191, 'TIQUISIO', 4, 810, '810-TIQUISIO'),
(192, 'TURBACO', 4, 836, '836-TURBACO'),
(193, 'TURBANA', 4, 838, '838-TURBANÁ'),
(194, 'VILLANUEVA', 4, 873, '873-VILLANUEVA'),
(195, 'ZAMBRANO', 4, 894, '894-ZAMBRANO'),
(196, 'TUNJA', 5, 1, '001-TUNJA'),
(197, 'ALMEIDA', 5, 22, '022-ALMEIDA'),
(198, 'AQUITANIA', 5, 47, '047-AQUITANIA'),
(199, 'ARCABUCO', 5, 51, '051-ARCABUCO'),
(200, 'BELEN', 5, 87, '087-BELÉN'),
(201, 'BERBEO', 5, 90, '090-BERBEO'),
(202, 'BETEITIVA', 5, 92, '092-BETÉITIVA'),
(203, 'BOAVITA', 5, 97, '097-BOAVITA'),
(204, 'BOYACA', 5, 104, '104-BOYACÁ'),
(205, 'BRICEÑO', 5, 106, '106-BRICEÑO'),
(206, 'BUENAVISTA', 5, 109, '109-BUENAVISTA'),
(207, 'BUSBANZA', 5, 114, '114-BUSBANZÁ'),
(208, 'CALDAS', 5, 131, '131-CALDAS'),
(209, 'CAMPOHERMOSO', 5, 135, '135-CAMPOHERMOSO'),
(210, 'CERINZA', 5, 162, '162-CERINZA'),
(211, 'CHINAVITA', 5, 172, '172-CHINAVITA'),
(212, 'CHIQUINQUIRA', 5, 176, '176-CHIQUINQUIRÁ'),
(213, 'CHISCAS', 5, 180, '180-CHISCAS'),
(214, 'CHITA', 5, 183, '183-CHITA'),
(215, 'CHITARAQUE', 5, 185, '185-CHITARAQUE'),
(216, 'CHIVATA', 5, 187, '187-CHIVATÁ'),
(217, 'CIENEGA', 5, 189, '189-CIÉNEGA'),
(218, 'COMBITA', 5, 204, '204-CÓMBITA'),
(219, 'COPER', 5, 212, '212-COPER'),
(220, 'CORRALES', 5, 215, '215-CORRALES'),
(221, 'COVARACHIA', 5, 218, '218-COVARACHÍA'),
(222, 'CUBARA', 5, 223, '223-CUBARÁ'),
(223, 'CUCAITA', 5, 224, '224-CUCAITA'),
(224, 'CUITIVA', 5, 226, '226-CUÍTIVA'),
(225, 'CHIQUIZA', 5, 232, '232-CHÍQUIZA'),
(226, 'CHIVOR', 5, 236, '236-CHIVOR'),
(227, 'DUITAMA', 5, 238, '238-DUITAMA'),
(228, 'EL COCUY', 5, 244, '244-EL COCUY'),
(229, 'EL ESPINO', 5, 248, '248-EL ESPINO'),
(230, 'FIRAVITOBA', 5, 272, '272-FIRAVITOBA'),
(231, 'FLORESTA', 5, 276, '276-FLORESTA'),
(232, 'GACHANTIVA', 5, 293, '293-GACHANTIVÁ'),
(233, 'GAMEZA', 5, 296, '296-GÁMEZA'),
(234, 'GARAGOA', 5, 299, '299-GARAGOA'),
(235, 'GUACAMAYAS', 5, 317, '317-GUACAMAYAS'),
(236, 'GUATEQUE', 5, 322, '322-GUATEQUE'),
(237, 'GUAYATA', 5, 325, '325-GUAYATÁ'),
(238, 'GÜICAN', 5, 332, '332-GÜICÁN DE LA SIERRA'),
(239, 'IZA', 5, 362, '362-IZA'),
(240, 'JENESANO', 5, 367, '367-JENESANO'),
(241, 'JERICO', 5, 368, '368-JERICÓ'),
(242, 'LABRANZAGRANDE', 5, 377, '377-LABRANZAGRANDE'),
(243, 'LA CAPILLA', 5, 380, '380-LA CAPILLA'),
(244, 'LA VICTORIA', 5, 401, '401-LA VICTORIA'),
(245, 'LA UVITA', 5, 403, '403-LA UVITA'),
(246, 'VILLA DE LEYVA', 5, 407, '407-VILLA DE LEYVA'),
(247, 'MACANAL', 5, 425, '425-MACANAL'),
(248, 'MARIPI', 5, 442, '442-MARIPÍ'),
(249, 'MIRAFLORES', 5, 455, '455-MIRAFLORES'),
(250, 'MONGUA', 5, 464, '464-MONGUA'),
(251, 'MONGUI', 5, 466, '466-MONGUÍ'),
(252, 'MONIQUIRA', 5, 469, '469-MONIQUIRÁ'),
(253, 'MOTAVITA', 5, 476, '476-MOTAVITA'),
(254, 'MUZO', 5, 480, '480-MUZO'),
(255, 'NOBSA', 5, 491, '491-NOBSA'),
(256, 'NUEVO COLON', 5, 494, '494-NUEVO COLÓN'),
(257, 'OICATA', 5, 500, '500-OICATÁ'),
(258, 'OTANCHE', 5, 507, '507-OTANCHE'),
(259, 'PACHAVITA', 5, 511, '511-PACHAVITA'),
(260, 'PAEZ', 5, 514, '514-PÁEZ'),
(261, 'PAIPA', 5, 516, '516-PAIPA'),
(262, 'PAJARITO', 5, 518, '518-PAJARITO'),
(263, 'PANQUEBA', 5, 522, '522-PANQUEBA'),
(264, 'PAUNA', 5, 531, '531-PAUNA'),
(265, 'PAYA', 5, 533, '533-PAYA'),
(266, 'PAZ DE RIO', 5, 537, '537-PAZ DE RÍO'),
(267, 'PESCA', 5, 542, '542-PESCA'),
(268, 'PISBA', 5, 550, '550-PISBA'),
(269, 'PUERTO BOYACA', 5, 572, '572-PUERTO BOYACÁ'),
(270, 'QUIPAMA', 5, 580, '580-QUÍPAMA'),
(271, 'RAMIRIQUI', 5, 599, '599-RAMIRIQUÍ'),
(272, 'RAQUIRA', 5, 600, '600-RÁQUIRA'),
(273, 'RONDON', 5, 621, '621-RONDÓN'),
(274, 'SABOYA', 5, 632, '632-SABOYÁ'),
(275, 'SACHICA', 5, 638, '638-SÁCHICA'),
(276, 'SAMACA', 5, 646, '646-SAMACÁ'),
(277, 'SAN EDUARDO', 5, 660, '660-SAN EDUARDO'),
(278, 'SAN JOSE DE PARE', 5, 664, '664-SAN JOSÉ DE PARE'),
(279, 'SAN LUIS DE GACENO', 5, 667, '667-SAN LUIS DE GACENO'),
(280, 'SAN MATEO', 5, 673, '673-SAN MATEO'),
(281, 'SAN MIGUEL DE SEMA', 5, 676, '676-SAN MIGUEL DE SEMA'),
(282, 'SAN PABLO DE BORBUR', 5, 681, '681-SAN PABLO DE BORBUR'),
(283, 'SANTANA', 5, 686, '686-SANTANA'),
(284, 'SANTA MARIA', 5, 690, '690-SANTA MARÍA'),
(285, 'SANTA ROSA DE VITERBO', 5, 693, '693-SANTA ROSA DE VITERBO'),
(286, 'SANTA SOFIA', 5, 696, '696-SANTA SOFÍA'),
(287, 'SATIVANORTE', 5, 720, '720-SATIVANORTE'),
(288, 'SATIVASUR', 5, 723, '723-SATIVASUR'),
(289, 'SIACHOQUE', 5, 740, '740-SIACHOQUE'),
(290, 'SOATA', 5, 753, '753-SOATÁ'),
(291, 'SOCOTA', 5, 755, '755-SOCOTÁ'),
(292, 'SOCHA', 5, 757, '757-SOCHA'),
(293, 'SOGAMOSO', 5, 759, '759-SOGAMOSO'),
(294, 'SOMONDOCO', 5, 761, '761-SOMONDOCO'),
(295, 'SORA', 5, 762, '762-SORA'),
(296, 'SOTAQUIRA', 5, 763, '763-SOTAQUIRÁ'),
(297, 'SORACA', 5, 764, '764-SORACÁ'),
(298, 'SUSACON', 5, 774, '774-SUSACÓN'),
(299, 'SUTAMARCHAN', 5, 776, '776-SUTAMARCHÁN'),
(300, 'SUTATENZA', 5, 778, '778-SUTATENZA'),
(301, 'TASCO', 5, 790, '790-TASCO'),
(302, 'TENZA', 5, 798, '798-TENZA'),
(303, 'TIBANA', 5, 804, '804-TIBANÁ'),
(304, 'TIBASOSA', 5, 806, '806-TIBASOSA'),
(305, 'TINJACA', 5, 808, '808-TINJACÁ'),
(306, 'TIPACOQUE', 5, 810, '810-TIPACOQUE'),
(307, 'TOCA', 5, 814, '814-TOCA'),
(308, 'TOGÜI', 5, 816, '816-TOGÜÍ'),
(309, 'TOPAGA', 5, 820, '820-TÓPAGA'),
(310, 'TOTA', 5, 822, '822-TOTA'),
(311, 'TUNUNGUA', 5, 832, '832-TUNUNGUÁ'),
(312, 'TURMEQUE', 5, 835, '835-TURMEQUÉ'),
(313, 'TUTA', 5, 837, '837-TUTA'),
(314, 'TUTAZA', 5, 839, '839-TUTAZÁ'),
(315, 'UMBITA', 5, 842, '842-ÚMBITA'),
(316, 'VENTAQUEMADA', 5, 861, '861-VENTAQUEMADA'),
(317, 'VIRACACHA', 5, 879, '879-VIRACACHÁ'),
(318, 'ZETAQUIRA', 5, 897, '897-ZETAQUIRA'),
(319, 'MANIZALES', 6, 1, '001-MANIZALES'),
(320, 'AGUADAS', 6, 13, '013-AGUADAS'),
(321, 'ANSERMA', 6, 42, '042-ANSERMA'),
(322, 'ARANZAZU', 6, 50, '050-ARANZAZU'),
(323, 'BELALCAZAR', 6, 88, '088-BELALCÁZAR'),
(324, 'CHINCHINA', 6, 174, '174-CHINCHINÁ'),
(325, 'FILADELFIA', 6, 272, '272-FILADELFIA'),
(326, 'LA DORADA', 6, 380, '380-LA DORADA'),
(327, 'LA MERCED', 6, 388, '388-LA MERCED'),
(328, 'MANZANARES', 6, 433, '433-MANZANARES'),
(329, 'MARMATO', 6, 442, '442-MARMATO'),
(330, 'MARQUETALIA', 6, 444, '444-MARQUETALIA'),
(331, 'MARULANDA', 6, 446, '446-MARULANDA'),
(332, 'NEIRA', 6, 486, '486-NEIRA'),
(333, 'NORCASIA', 6, 495, '495-NORCASIA'),
(334, 'PACORA', 6, 513, '513-PÁCORA'),
(335, 'PALESTINA', 6, 524, '524-PALESTINA'),
(336, 'PENSILVANIA', 6, 541, '541-PENSILVANIA'),
(337, 'RIOSUCIO', 6, 614, '614-RIOSUCIO'),
(338, 'RISARALDA', 6, 616, '616-RISARALDA'),
(339, 'SALAMINA', 6, 653, '653-SALAMINA'),
(340, 'SAMANA', 6, 662, '662-SAMANÁ'),
(341, 'SAN JOSE', 6, 665, '665-SAN JOSÉ'),
(342, 'SUPIA', 6, 777, '777-SUPÍA'),
(343, 'VICTORIA', 6, 867, '867-VICTORIA'),
(344, 'VILLAMARIA', 6, 873, '873-VILLAMARÍA'),
(345, 'VITERBO', 6, 877, '877-VITERBO'),
(346, 'FLORENCIA', 7, 1, '001-FLORENCIA'),
(347, 'ALBANIA', 7, 29, '029-ALBANIA'),
(348, 'BELEN DE LOS ANDAQUIES', 7, 94, '094-BELÉN DE LOS ANDAQUÍES'),
(349, 'CARTAGENA DEL CHAIRA', 7, 150, '150-CARTAGENA DEL CHAIRÁ'),
(350, 'CURILLO', 7, 205, '205-CURILLO'),
(351, 'EL DONCELLO', 7, 247, '247-EL DONCELLO'),
(352, 'EL PAUJIL', 7, 256, '256-EL PAUJÍL'),
(353, 'LA MONTAÑITA', 7, 410, '410-LA MONTAÑITA'),
(354, 'MILAN', 7, 460, '460-MILÁN'),
(355, 'MORELIA', 7, 479, '479-MORELIA'),
(356, 'PUERTO RICO', 7, 592, '592-PUERTO RICO'),
(357, 'SAN JOSE DEL FRAGUA', 7, 610, '610-SAN JOSÉ DEL FRAGUA'),
(358, 'SAN VICENTE DEL CAGUAN', 7, 753, '753-SAN VICENTE DEL CAGUÁN'),
(359, 'SOLANO', 7, 756, '756-SOLANO'),
(360, 'SOLITA', 7, 785, '785-SOLITA'),
(361, 'VALPARAISO', 7, 860, '860-VALPARAÍSO'),
(362, 'POPAYAN', 8, 1, '001-POPAYÁN'),
(363, 'ALMAGUER', 8, 22, '022-ALMAGUER'),
(364, 'ARGELIA', 8, 50, '050-ARGELIA'),
(365, 'BALBOA', 8, 75, '075-BALBOA'),
(366, 'BOLIVAR', 8, 100, '100-BOLÍVAR'),
(367, 'BUENOS AIRES', 8, 110, '110-BUENOS AIRES'),
(368, 'CAJIBIO', 8, 130, '130-CAJIBÍO'),
(369, 'CALDONO', 8, 137, '137-CALDONO'),
(370, 'CALOTO', 8, 142, '142-CALOTO'),
(371, 'CORINTO', 8, 212, '212-CORINTO'),
(372, 'EL TAMBO', 8, 256, '256-EL TAMBO'),
(373, 'FLORENCIA', 8, 290, '290-FLORENCIA'),
(374, 'GUACHENE', 8, 300, '300-GUACHENÉ'),
(375, 'GUAPI', 8, 318, '318-GUAPÍ'),
(376, 'INZA', 8, 355, '355-INZÁ'),
(377, 'JAMBALO', 8, 364, '364-JAMBALÓ'),
(378, 'LA SIERRA', 8, 392, '392-LA SIERRA'),
(379, 'LA VEGA', 8, 397, '397-LA VEGA'),
(380, 'LOPEZ', 8, 418, '418-LÓPEZ DE MICAY'),
(381, 'MERCADERES', 8, 450, '450-MERCADERES'),
(382, 'MIRANDA', 8, 455, '455-MIRANDA'),
(383, 'MORALES', 8, 473, '473-MORALES'),
(384, 'PADILLA', 8, 513, '513-PADILLA'),
(385, 'PAEZ', 8, 517, '517-PÁEZ ‐ BELALCAZAR'),
(386, 'PATIA', 8, 532, '532-PATÍA – EL BORDO'),
(387, 'PIAMONTE', 8, 533, '533-PIAMONTE'),
(388, 'PIENDAMO', 8, 548, '548-PIENDAMÓ – TUNÍA'),
(389, 'PUERTO TEJADA', 8, 573, '573-PUERTO TEJADA'),
(390, 'PURACE', 8, 585, '585-PURACÉ ‐ COCONUCO'),
(391, 'ROSAS', 8, 622, '622-ROSAS'),
(392, 'SAN SEBASTIAN', 8, 693, '693-SAN SEBASTIÁN'),
(393, 'SANTANDER DE QUILICHAO', 8, 698, '698-SANTANDER DE QUILICHAO'),
(394, 'SANTA ROSA', 8, 701, '701-SANTA ROSA'),
(395, 'SILVIA', 8, 743, '743-SILVIA'),
(396, 'SOTARA', 8, 760, '760-SOTARA'),
(397, 'SUAREZ', 8, 780, '780-SUÁREZ'),
(398, 'SUCRE', 8, 785, '785-SUCRE'),
(399, 'TIMBIO', 8, 807, '807-TIMBÍO'),
(400, 'TIMBIQUI', 8, 809, '809-TIMBIQUÍ'),
(401, 'TORIBIO', 8, 821, '821-TORIBÍO'),
(402, 'TOTORO', 8, 824, '824-TOTORÓ'),
(403, 'VILLA RICA', 8, 845, '845-VILLA RICA'),
(404, 'VALLEDUPAR', 9, 1, '001-VALLEDUPAR'),
(405, 'AGUACHICA', 9, 11, '011-AGUACHICA'),
(406, 'AGUSTIN CODAZZI', 9, 13, '013-AGUSTÍN CODAZZI'),
(407, 'ASTREA', 9, 32, '032-ASTREA'),
(408, 'BECERRIL', 9, 45, '045-BECERRIL'),
(409, 'BOSCONIA', 9, 60, '060-BOSCONIA'),
(410, 'CHIMICHAGUA', 9, 175, '175-CHIMICHAGUA'),
(411, 'CHIRIGUANA', 9, 178, '178-CHIRIGUANÁ'),
(412, 'CURUMANI', 9, 228, '228-CURUMANÍ'),
(413, 'EL COPEY', 9, 238, '238-EL COPEY'),
(414, 'EL PASO', 9, 250, '250-EL PASO'),
(415, 'GAMARRA', 9, 295, '295-GAMARRA'),
(416, 'GONZALEZ', 9, 310, '310-GONZÁLEZ'),
(417, 'LA GLORIA', 9, 383, '383-LA GLORIA'),
(418, 'LA JAGUA DE IBIRICO', 9, 400, '400-LA JAGUA DE IBIRICO'),
(419, 'MANAURE', 9, 443, '443-MANAURE BALCÓN DEL CESAR'),
(420, 'PAILITAS', 9, 517, '517-PAILITAS'),
(421, 'PELAYA', 9, 550, '550-PELAYA'),
(422, 'PUEBLO BELLO', 9, 570, '570-PUEBLO BELLO'),
(423, 'RIO DE ORO', 9, 614, '614-RÍO DE ORO'),
(424, 'LA PAZ', 9, 621, '621-LA PAZ'),
(425, 'SAN ALBERTO', 9, 710, '710-SAN ALBERTO'),
(426, 'SAN DIEGO', 9, 750, '750-SAN DIEGO'),
(427, 'SAN MARTIN', 9, 770, '770-SAN MARTÍN'),
(428, 'TAMALAMEQUE', 9, 787, '787-TAMALAMEQUE'),
(429, 'MONTERIA', 10, 1, '001-MONTERÍA'),
(430, 'AYAPEL', 10, 68, '068-AYAPEL'),
(431, 'BUENAVISTA', 10, 79, '079-BUENAVISTA'),
(432, 'CANALETE', 10, 90, '090-CANALETE'),
(433, 'CERETE', 10, 162, '162-CERETÉ'),
(434, 'CHIMA', 10, 168, '168-CHIMÁ'),
(435, 'CHINU', 10, 182, '182-CHINÚ'),
(436, 'CIENAGA DE ORO', 10, 189, '189-CIÉNAGA DE ORO'),
(437, 'COTORRA', 10, 300, '300-COTORRA'),
(438, 'LA APARTADA', 10, 350, '350-LA APARTADA'),
(439, 'LORICA', 10, 417, '417-LORICA'),
(440, 'LOS CORDOBAS', 10, 419, '419-LOS CÓRDOBAS'),
(441, 'MOMIL', 10, 464, '464-MOMIL'),
(442, 'MONTELIBANO', 10, 466, '466-MONTELÍBANO'),
(443, 'MOÑITOS', 10, 500, '500-MOÑITOS'),
(444, 'PLANETA RICA', 10, 555, '555-PLANETA RICA'),
(445, 'PUEBLO NUEVO', 10, 570, '570-PUEBLO NUEVO'),
(446, 'PUERTO ESCONDIDO', 10, 574, '574-PUERTO ESCONDIDO'),
(447, 'PUERTO LIBERTADOR', 10, 580, '580-PUERTO LIBERTADOR'),
(448, 'PURISIMA', 10, 586, '586-PURÍSIMA DE LA CONCEPCIÓN'),
(449, 'SAHAGUN', 10, 660, '660-SAHAGÚN'),
(450, 'SAN ANDRES SOTAVENTO', 10, 670, '670-SAN ANDRÉS DE SOTAVENTO'),
(451, 'SAN ANTERO', 10, 672, '672-SAN ANTERO'),
(452, 'SAN BERNARDO DEL VIENTO', 10, 675, '675-SAN BERNARDO DEL VIENTO'),
(453, 'SAN CARLOS', 10, 678, '678-SAN CARLOS'),
(454, 'SAN PELAYO', 10, 686, '686-SAN PELAYO'),
(455, 'TIERRALTA', 10, 807, '807-TIERRALTA'),
(456, 'VALENCIA', 10, 855, '855-VALENCIA'),
(457, 'AGUA DE DIOS', 11, 1, '001-AGUA DE DIOS'),
(458, 'ALBAN', 11, 19, '019-ALBÁN'),
(459, 'ANAPOIMA', 11, 35, '035-ANAPOIMA'),
(460, 'ANOLAIMA', 11, 40, '040-ANOLAIMA'),
(461, 'ARBELAEZ', 11, 53, '053-ARBELÁEZ'),
(462, 'BELTRAN', 11, 86, '086-BELTRÁN'),
(463, 'BITUIMA', 11, 95, '095-BITUIMA'),
(464, 'BOJACA', 11, 99, '099-BOJACÁ'),
(465, 'CABRERA', 11, 120, '120-CABRERA'),
(466, 'CACHIPAY', 11, 123, '123-CACHIPAY'),
(467, 'CAJICA', 11, 126, '126-CAJICÁ'),
(468, 'CAPARRAPI', 11, 148, '148-CAPARRAPÍ'),
(469, 'CAQUEZA', 11, 151, '151-CÁQUEZA'),
(470, 'CARMEN DE CARUPA', 11, 154, '154-CARMEN DE CARUPA'),
(471, 'CHAGUANI', 11, 168, '168-CHAGUANÍ'),
(472, 'CHIA', 11, 175, '175-CHÍA'),
(473, 'CHIPAQUE', 11, 178, '178-CHIPAQUE'),
(474, 'CHOACHI', 11, 181, '181-CHOACHÍ'),
(475, 'CHOCONTA', 11, 183, '183-CHOCONTÁ'),
(476, 'COGUA', 11, 200, '200-COGUA'),
(477, 'COTA', 11, 214, '214-COTA'),
(478, 'CUCUNUBA', 11, 224, '224-CUCUNUBÁ'),
(479, 'EL COLEGIO', 11, 245, '245-EL COLEGIO'),
(480, 'EL PEÑON', 11, 258, '258-EL PEÑÓN'),
(481, 'EL ROSAL', 11, 260, '260-EL ROSAL'),
(482, 'FACATATIVA', 11, 269, '269-FACATATIVÁ'),
(483, 'FOMEQUE', 11, 279, '279-FÓMEQUE'),
(484, 'FOSCA', 11, 281, '281-FOSCA'),
(485, 'FUNZA', 11, 286, '286-FUNZA'),
(486, 'FUQUENE', 11, 288, '288-FÚQUENE'),
(487, 'FUSAGASUGA', 11, 290, '290-FUSAGASUGÁ'),
(488, 'GACHALA', 11, 293, '293-GACHALÁ'),
(489, 'GACHANCIPA', 11, 295, '295-GACHANCIPÁ'),
(490, 'GACHETA', 11, 297, '297-GACHETÁ'),
(491, 'GAMA', 11, 299, '299-GAMA'),
(492, 'GIRARDOT', 11, 307, '307-GIRARDOT'),
(493, 'GRANADA', 11, 312, '312-GRANADA'),
(494, 'GUACHETA', 11, 317, '317-GUACHETÁ'),
(495, 'GUADUAS', 11, 320, '320-GUADUAS'),
(496, 'GUASCA', 11, 322, '322-GUASCA'),
(497, 'GUATAQUI', 11, 324, '324-GUATAQUÍ'),
(498, 'GUATAVITA', 11, 326, '326-GUATAVITA'),
(499, 'GUAYABAL DE SIQUIMA', 11, 328, '328-GUAYABAL DE SÍQUIMA'),
(500, 'GUAYABETAL', 11, 335, '335-GUAYABETAL'),
(501, 'GUTIERREZ', 11, 339, '339-GUTIÉRREZ'),
(502, 'JERUSALEN', 11, 368, '368-JERUSALÉN'),
(503, 'JUNIN', 11, 372, '372-JUNÍN'),
(504, 'LA CALERA', 11, 377, '377-LA CALERA'),
(505, 'LA MESA', 11, 386, '386-LA MESA'),
(506, 'LA PALMA', 11, 394, '394-LA PALMA'),
(507, 'LA PEÑA', 11, 398, '398-LA PEÑA'),
(508, 'LA VEGA', 11, 402, '402-LA VEGA'),
(509, 'LENGUAZAQUE', 11, 407, '407-LENGUAZAQUE'),
(510, 'MACHETA', 11, 426, '426-MACHETÁ'),
(511, 'MADRID', 11, 430, '430-MADRID'),
(512, 'MANTA', 11, 436, '436-MANTA'),
(513, 'MEDINA', 11, 438, '438-MEDINA'),
(514, 'MOSQUERA', 11, 473, '473-MOSQUERA'),
(515, 'NARIÑO', 11, 483, '483-NARIÑO'),
(516, 'NEMOCON', 11, 486, '486-NEMOCÓN'),
(517, 'NILO', 11, 488, '488-NILO'),
(518, 'NIMAIMA', 11, 489, '489-NIMAIMA'),
(519, 'NOCAIMA', 11, 491, '491-NOCAIMA'),
(520, 'VENECIA', 11, 506, '506-VENECIA'),
(521, 'PACHO', 11, 513, '513-PACHO'),
(522, 'PAIME', 11, 518, '518-PAIME'),
(523, 'PANDI', 11, 524, '524-PANDI'),
(524, 'PARATEBUENO', 11, 530, '530-PARATEBUENO'),
(525, 'PASCA', 11, 535, '535-PASCA'),
(526, 'PUERTO SALGAR', 11, 572, '572-PUERTO SALGAR'),
(527, 'PULI', 11, 580, '580-PULÍ'),
(528, 'QUEBRADANEGRA', 11, 592, '592-QUEBRADANEGRA'),
(529, 'QUETAME', 11, 594, '594-QUETAME'),
(530, 'QUIPILE', 11, 596, '596-QUIPILE'),
(531, 'APULO', 11, 599, '599-APULO'),
(532, 'RICAURTE', 11, 612, '612-RICAURTE'),
(533, 'SAN ANTONIO DEL TEQUENDAMA', 11, 645, '645-SAN ANTONIO DEL TEQUENDAMA'),
(534, 'SAN BERNARDO', 11, 649, '649-SAN BERNARDO'),
(535, 'SAN CAYETANO', 11, 653, '653-SAN CAYETANO'),
(536, 'SAN FRANCISCO', 11, 658, '658-SAN FRANCISCO'),
(537, 'SAN JUAN DE RIO SECO', 11, 662, '662-SAN JUAN DE RIOSECO'),
(538, 'SASAIMA', 11, 718, '718-SASAIMA'),
(539, 'SESQUILE', 11, 736, '736-SESQUILÉ'),
(540, 'SIBATE', 11, 740, '740-SIBATÉ'),
(541, 'SILVANIA', 11, 743, '743-SILVANIA'),
(542, 'SIMIJACA', 11, 745, '745-SIMIJACA'),
(543, 'SOACHA', 11, 754, '754-SOACHA'),
(544, 'SOPO', 11, 758, '758-SOPÓ'),
(545, 'SUBACHOQUE', 11, 769, '769-SUBACHOQUE'),
(546, 'SUESCA', 11, 772, '772-SUESCA'),
(547, 'SUPATA', 11, 777, '777-SUPATÁ'),
(548, 'SUSA', 11, 779, '779-SUSA'),
(549, 'SUTATAUSA', 11, 781, '781-SUTATAUSA'),
(550, 'TABIO', 11, 785, '785-TABIO'),
(551, 'TAUSA', 11, 793, '793-TAUSA'),
(552, 'TENA', 11, 797, '797-TENA'),
(553, 'TENJO', 11, 799, '799-TENJO'),
(554, 'TIBACUY', 11, 805, '805-TIBACUY'),
(555, 'TIBIRITA', 11, 807, '807-TIBIRITA'),
(556, 'TOCAIMA', 11, 815, '815-TOCAIMA'),
(557, 'TOCANCIPA', 11, 817, '817-TOCANCIPÁ'),
(558, 'TOPAIPI', 11, 823, '823-TOPAIPÍ'),
(559, 'UBALA', 11, 839, '839-UBALÁ'),
(560, 'UBAQUE', 11, 841, '841-UBAQUE'),
(561, 'VILLA DE SAN DIEGO DE UBATE', 11, 843, '843-VILLA DE SAN DIEGO DE UBATÉ'),
(562, 'UNE', 11, 845, '845-UNE'),
(563, 'UTICA', 11, 851, '851-ÚTICA'),
(564, 'VERGARA', 11, 862, '862-VERGARA'),
(565, 'VIANI', 11, 867, '867-VIANÍ'),
(566, 'VILLAGOMEZ', 11, 871, '871-VILLAGÓMEZ'),
(567, 'VILLAPINZON', 11, 873, '873-VILLAPINZÓN'),
(568, 'VILLETA', 11, 875, '875-VILLETA'),
(569, 'VIOTA', 11, 878, '878-VIOTÁ'),
(570, 'YACOPI', 11, 885, '885-YACOPÍ'),
(571, 'ZIPACON', 11, 898, '898-ZIPACÓN'),
(572, 'ZIPAQUIRA', 11, 899, '899-ZIPAQUIRÁ'),
(573, 'QUIBDO', 12, 1, '001-QUIBDÓ'),
(574, 'ACANDI', 12, 6, '006-ACANDÍ'),
(575, 'ALTO BAUDO', 12, 25, '025-ALTO BAUDÓ (PIE DE PATÓ)'),
(576, 'ATRATO', 12, 50, '050-ATRATO (YUTO)'),
(577, 'BAGADO', 12, 73, '073-BAGADÓ'),
(578, 'BAHIA SOLANO', 12, 75, '075-BAHÍA SOLANO (MUTIS)'),
(579, 'BAJO BAUDO', 12, 77, '077-BAJO BAUDÓ (PIZARRO)'),
(580, 'BOJAYA', 12, 99, '099-BOJAYÁ (BELLA VISTA)'),
(581, 'EL CANTON DEL SAN PABLO', 12, 135, '135-EL CANTÓN DEL SAN PABLO'),
(582, 'CARMEN DEL DARIEN', 12, 150, '150-CARMEN DEL DARIÉN'),
(583, 'CERTEGUI', 12, 160, '160-CÉRTEGUI'),
(584, 'CONDOTO', 12, 205, '205-CONDOTO'),
(585, 'EL CARMEN DE ATRATO', 12, 245, '245-EL CARMEN DE ATRATO'),
(586, 'EL LITORAL DEL SAN JUAN', 12, 250, '250-EL LITORAL DEL SAN JUAN'),
(587, 'ISTMINA', 12, 361, '361-ISTMINA'),
(588, 'JURADO', 12, 372, '372-JURADÓ'),
(589, 'LLORO', 12, 413, '413-LLORÓ'),
(590, 'MEDIO ATRATO', 12, 425, '425-MEDIO ATRATO (BETÉ)'),
(591, 'MEDIO BAUDO', 12, 430, '430-MEDIO BAUDÓ'),
(592, 'MEDIO SAN JUAN', 12, 450, '450-MEDIO SAN JUAN (ANDAGOYA)'),
(593, 'NOVITA', 12, 491, '491-NÓVITA'),
(594, 'NUQUI', 12, 495, '495-NUQUÍ'),
(595, 'RIO IRO', 12, 580, '580-RÍO IRÓ (SANTA RITA)'),
(596, 'RIO QUITO', 12, 600, '600-RÍO QUITO (PAIMADÓ)'),
(597, 'RIOSUCIO', 12, 615, '615-RIOSUCIO'),
(598, 'SAN JOSE DEL PALMAR', 12, 660, '660-SAN JOSÉ DEL PALMAR'),
(599, 'SIPI', 12, 745, '745-SIPÍ'),
(600, 'TADO', 12, 787, '787-TADÓ'),
(601, 'UNGUIA', 12, 800, '800-UNGUÍA'),
(602, 'UNION PANAMERICANA', 12, 810, '810-UNIÓN PANAMERICANA (LAS ÁNIMAS)'),
(603, 'NEIVA', 13, 1, '001-NEIVA'),
(604, 'ACEVEDO', 13, 6, '006-ACEVEDO'),
(605, 'AGRADO', 13, 13, '013-AGRADO'),
(606, 'AIPE', 13, 16, '016-AIPE'),
(607, 'ALGECIRAS', 13, 20, '020-ALGECIRAS'),
(608, 'ALTAMIRA', 13, 26, '026-ALTAMIRA'),
(609, 'BARAYA', 13, 78, '078-BARAYA'),
(610, 'CAMPOALEGRE', 13, 132, '132-CAMPOALEGRE'),
(611, 'COLOMBIA', 13, 206, '206-COLOMBIA'),
(612, 'ELIAS', 13, 244, '244-ELÍAS'),
(613, 'GARZON', 13, 298, '298-GARZÓN'),
(614, 'GIGANTE', 13, 306, '306-GIGANTE'),
(615, 'GUADALUPE', 13, 319, '319-GUADALUPE'),
(616, 'HOBO', 13, 349, '349-HOBO'),
(617, 'IQUIRA', 13, 357, '357-ÍQUIRA'),
(618, 'ISNOS', 13, 359, '359-ISNOS'),
(619, 'LA ARGENTINA', 13, 378, '378-LA ARGENTINA (LA PLATA VIEJA)'),
(620, 'LA PLATA', 13, 396, '396-LA PLATA'),
(621, 'NATAGA', 13, 483, '483-NÁTAGA'),
(622, 'OPORAPA', 13, 503, '503-OPORAPA'),
(623, 'PAICOL', 13, 518, '518-PAICOL'),
(624, 'PALERMO', 13, 524, '524-PALERMO'),
(625, 'PALESTINA', 13, 530, '530-PALESTINA'),
(626, 'PITAL', 13, 548, '548-PITAL'),
(627, 'PITALITO', 13, 551, '551-PITALITO'),
(628, 'RIVERA', 13, 615, '615-RIVERA'),
(629, 'SALADOBLANCO', 13, 660, '660-SALADOBLANCO'),
(630, 'SAN AGUSTIN', 13, 668, '668-SAN AGUSTÍN'),
(631, 'SANTA MARIA', 13, 676, '676-SANTA MARÍA'),
(632, 'SUAZA', 13, 770, '770-SUAZA'),
(633, 'TARQUI', 13, 791, '791-TARQUI'),
(634, 'TESALIA', 13, 797, '797-TESALIA (CARNICERÍAS)'),
(635, 'TELLO', 13, 799, '799-TELLO'),
(636, 'TERUEL', 13, 801, '801-TERUEL'),
(637, 'TIMANA', 13, 807, '807-TIMANÁ'),
(638, 'VILLAVIEJA', 13, 872, '872-VILLAVIEJA'),
(639, 'YAGUARA', 13, 885, '885-YAGUARÁ'),
(640, 'RIOHACHA', 14, 1, '001-RIOHACHA'),
(641, 'ALBANIA', 14, 35, '035-ALBANIA'),
(642, 'BARRANCAS', 14, 78, '078-BARRANCAS'),
(643, 'DIBULLA', 14, 90, '090-DIBULLA'),
(644, 'DISTRACCION', 14, 98, '098-DISTRACCIÓN'),
(645, 'EL MOLINO', 14, 110, '110-EL MOLINO'),
(646, 'FONSECA', 14, 279, '279-FONSECA'),
(647, 'HATONUEVO', 14, 378, '378-HATONUEVO'),
(648, 'LA JAGUA DEL PILAR', 14, 420, '420-LA JAGUA DEL PILAR'),
(649, 'MAICAO', 14, 430, '430-MAICAO'),
(650, 'MANAURE', 14, 560, '560-MANAURE'),
(651, 'SAN JUAN DEL CESAR', 14, 650, '650-SAN JUAN DEL CESAR'),
(652, 'URIBIA', 14, 847, '847-URIBIA'),
(653, 'URUMITA', 14, 855, '855-URUMITA'),
(654, 'VILLANUEVA', 14, 874, '874-VILLANUEVA'),
(655, 'SANTA MARTA', 15, 1, '001-SANTA MARTA'),
(656, 'ALGARROBO', 15, 30, '030-ALGARROBO'),
(657, 'ARACATACA', 15, 53, '053-ARACATACA'),
(658, 'ARIGUANI', 15, 58, '058-ARIGUANÍ'),
(659, 'CERRO SAN ANTONIO', 15, 161, '161-CERRO DE SAN ANTONIO'),
(660, 'CHIBOLO', 15, 170, '170-CHIBOLO'),
(661, 'CIENAGA', 15, 189, '189-CIÉNAGA'),
(662, 'CONCORDIA', 15, 205, '205-CONCORDIA'),
(663, 'EL BANCO', 15, 245, '245-EL BANCO'),
(664, 'EL PIÑON', 15, 258, '258-EL PIÑÓN'),
(665, 'EL RETEN', 15, 268, '268-EL RETÉN'),
(666, 'FUNDACION', 15, 288, '288-FUNDACIÓN'),
(667, 'GUAMAL', 15, 318, '318-GUAMAL'),
(668, 'NUEVA GRANADA', 15, 460, '460-NUEVA GRANADA'),
(669, 'PEDRAZA', 15, 541, '541-PEDRAZA'),
(670, 'PIJIÑO DEL CARMEN', 15, 545, '545-PIJIÑO DEL CARMEN'),
(671, 'PIVIJAY', 15, 551, '551-PIVIJAY'),
(672, 'PLATO', 15, 555, '555-PLATO'),
(673, 'PUEBLOVIEJO', 15, 570, '570-PUEBLOVIEJO'),
(674, 'REMOLINO', 15, 605, '605-REMOLINO'),
(675, 'SABANAS DE SAN ANGEL', 15, 660, '660-SABANAS DE SAN ÁNGEL'),
(676, 'SALAMINA', 15, 675, '675-SALAMINA'),
(677, 'SAN SEBASTIAN DE BUENAVISTA', 15, 692, '692-SAN SEBASTIÁN DE BUENAVISTA'),
(678, 'SAN ZENON', 15, 703, '703-SAN ZENÓN'),
(679, 'SANTA ANA', 15, 707, '707-SANTA ANA'),
(680, 'SANTA BARBARA DE PINTO', 15, 720, '720-SANTA BÁRBARA DE PINTO'),
(681, 'SITIONUEVO', 15, 745, '745-SITIONUEVO'),
(682, 'TENERIFE', 15, 798, '798-TENERIFE'),
(683, 'ZAPAYAN', 15, 960, '960-ZAPAYÁN'),
(684, 'ZONA BANANERA', 15, 980, '980-ZONA BANANERA'),
(685, 'VILLAVICENCIO', 16, 1, '001-VILLAVICENCIO'),
(686, 'ACACIAS', 16, 6, '006-ACACÍAS'),
(687, 'BARRANCA DE UPIA', 16, 110, '110-BARRANCA DE UPÍA'),
(688, 'CABUYARO', 16, 124, '124-CABUYARO'),
(689, 'CASTILLA LA NUEVA', 16, 150, '150-CASTILLA LA NUEVA'),
(690, 'CUBARRAL', 16, 223, '223-CUBARRAL'),
(691, 'CUMARAL', 16, 226, '226-CUMARAL'),
(692, 'EL CALVARIO', 16, 245, '245-EL CALVARIO'),
(693, 'EL CASTILLO', 16, 251, '251-EL CASTILLO'),
(694, 'EL DORADO', 16, 270, '270-EL DORADO'),
(695, 'FUENTE DE ORO', 16, 287, '287-FUENTEDEORO'),
(696, 'GRANADA', 16, 313, '313-GRANADA'),
(697, 'GUAMAL', 16, 318, '318-GUAMAL'),
(698, 'MAPIRIPAN', 16, 325, '325-MAPIRIPÁN'),
(699, 'MESETAS', 16, 330, '330-MESETAS'),
(700, 'LA MACARENA', 16, 350, '350-LA MACARENA'),
(701, 'URIBE', 16, 370, '370-URIBE'),
(702, 'LEJANIAS', 16, 400, '400-LEJANÍAS'),
(703, 'PUERTO CONCORDIA', 16, 450, '450-PUERTO CONCORDIA'),
(704, 'PUERTO GAITAN', 16, 568, '568-PUERTO GAITÁN'),
(705, 'PUERTO LOPEZ', 16, 573, '573-PUERTO LÓPEZ'),
(706, 'PUERTO LLERAS', 16, 577, '577-PUERTO LLERAS'),
(707, 'PUERTO RICO', 16, 590, '590-PUERTO RICO'),
(708, 'RESTREPO', 16, 606, '606-RESTREPO'),
(709, 'SAN CARLOS DE GUAROA', 16, 680, '680-SAN CARLOS DE GUAROA'),
(710, 'SAN JUAN DE ARAMA', 16, 683, '683-SAN JUAN DE ARAMA'),
(711, 'SAN JUANITO', 16, 686, '686-SAN JUANITO'),
(712, 'SAN MARTIN', 16, 689, '689-SAN MARTÍN DE LOS LLANOS'),
(713, 'VISTAHERMOSA', 16, 711, '711-VISTAHERMOSA'),
(714, 'PASTO', 17, 1, '001-PASTO'),
(715, 'ALBAN', 17, 19, '019-ALBÁN (SAN JOSÉ)'),
(716, 'ALDANA', 17, 22, '022-ALDANA'),
(717, 'ANCUYA', 17, 36, '036-ANCUYÁ'),
(718, 'ARBOLEDA', 17, 51, '051-ARBOLEDA'),
(719, 'BARBACOAS', 17, 79, '079-BARBACOAS'),
(720, 'BELEN', 17, 83, '083-BELÉN'),
(721, 'BUESACO', 17, 110, '110-BUESACO'),
(722, 'COLON', 17, 203, '203-COLÓN (GÉNOVA)'),
(723, 'CONSACA', 17, 207, '207-CONSACÁ'),
(724, 'CONTADERO', 17, 210, '210-CONTADERO'),
(725, 'CORDOBA', 17, 215, '215-CÓRDOBA'),
(726, 'CUASPUD', 17, 224, '224-CUASPÚD'),
(727, 'CUMBAL', 17, 227, '227-CUMBAL'),
(728, 'CUMBITARA', 17, 233, '233-CUMBITARA'),
(729, 'CHACHAGÜI', 17, 240, '240-CHACHAGÜÍ'),
(730, 'EL CHARCO', 17, 250, '250-EL CHARCO'),
(731, 'EL PEÑOL', 17, 254, '254-EL PEÑOL'),
(732, 'EL ROSARIO', 17, 256, '256-EL ROSARIO'),
(733, 'EL TABLON DE GOMEZ', 17, 258, '258-EL TABLÓN DE GÓMEZ'),
(734, 'EL TAMBO', 17, 260, '260-EL TAMBO'),
(735, 'FUNES', 17, 287, '287-FUNES'),
(736, 'GUACHUCAL', 17, 317, '317-GUACHUCAL'),
(737, 'GUAITARILLA', 17, 320, '320-GUAITARILLA'),
(738, 'GUALMATAN', 17, 323, '323-GUALMATÁN'),
(739, 'ILES', 17, 352, '352-ILES'),
(740, 'IMUES', 17, 354, '354-IMUÉS'),
(741, 'IPIALES', 17, 356, '356-IPIALES'),
(742, 'LA CRUZ', 17, 378, '378-LA CRUZ'),
(743, 'LA FLORIDA', 17, 381, '381-LA FLORIDA'),
(744, 'LA LLANADA', 17, 385, '385-LA LLANADA'),
(745, 'LA TOLA', 17, 390, '390-LA TOLA'),
(746, 'LA UNION', 17, 399, '399-LA UNIÓN'),
(747, 'LEIVA', 17, 405, '405-LEIVA'),
(748, 'LINARES', 17, 411, '411-LINARES'),
(749, 'LOS ANDES', 17, 418, '418-LOS ANDES (SOTOMAYOR)'),
(750, 'MAGÜI', 17, 427, '427-MAGÜÍ (PAYÁN)'),
(751, 'MALLAMA', 17, 435, '435-MALLAMA (PIEDRANCHA)'),
(752, 'MOSQUERA', 17, 473, '473-MOSQUERA'),
(753, 'NARIÑO', 17, 480, '480-NARIÑO'),
(754, 'OLAYA HERRERA', 17, 490, '490-OLAYA HERRERA'),
(755, 'OSPINA', 17, 506, '506-OSPINA'),
(756, 'FRANCISCO PIZARRO', 17, 520, '520-FRANCISCO PIZARRO'),
(757, 'POLICARPA', 17, 540, '540-POLICARPA'),
(758, 'POTOSI', 17, 560, '560-POTOSÍ'),
(759, 'PROVIDENCIA', 17, 565, '565-PROVIDENCIA'),
(760, 'PUERRES', 17, 573, '573-PUERRES'),
(761, 'PUPIALES', 17, 585, '585-PUPIALES'),
(762, 'RICAURTE', 17, 612, '612-RICAURTE'),
(763, 'ROBERTO PAYAN', 17, 621, '621-ROBERTO PAYÁN (SAN JOSÉ)'),
(764, 'SAMANIEGO', 17, 678, '678-SAMANIEGO'),
(765, 'SANDONA', 17, 683, '683-SANDONÁ'),
(766, 'SAN BERNARDO', 17, 685, '685-SAN BERNARDO'),
(767, 'SAN LORENZO', 17, 687, '687-SAN LORENZO'),
(768, 'SAN PABLO', 17, 693, '693-SAN PABLO'),
(769, 'SAN PEDRO DE CARTAGO', 17, 694, '694-SAN PEDRO DE CARTAGO'),
(770, 'SANTA BARBARA', 17, 696, '696-SANTA BÁRBARA'),
(771, 'SANTACRUZ', 17, 699, '699-SANTACRUZ'),
(772, 'SAPUYES', 17, 720, '720-SAPUYES'),
(773, 'TAMINANGO', 17, 786, '786-TAMINANGO'),
(774, 'TANGUA', 17, 788, '788-TANGUA'),
(775, 'SAN ANDRES DE TUMACO', 17, 835, '835-SAN ANDRÉS DE TUMACO'),
(776, 'TUQUERRES', 17, 838, '838-TÚQUERRES'),
(777, 'YACUANQUER', 17, 885, '885-YACUANQUER'),
(778, 'CUCUTA', 18, 1, '001-CÚCUTA'),
(779, 'ABREGO', 18, 3, '003-ÁBREGO'),
(780, 'ARBOLEDAS', 18, 51, '051-ARBOLEDAS'),
(781, 'BOCHALEMA', 18, 99, '099-BOCHALEMA'),
(782, 'BUCARASICA', 18, 109, '109-BUCARASICA'),
(783, 'CACOTA', 18, 125, '125-CÁCOTA DE VELASCO'),
(784, 'CACHIRA', 18, 128, '128-CÁCHIRA'),
(785, 'CHINACOTA', 18, 172, '172-CHINÁCOTA'),
(786, 'CHITAGA', 18, 174, '174-CHITAGÁ'),
(787, 'CONVENCION', 18, 206, '206-CONVENCIÓN'),
(788, 'CUCUTILLA', 18, 223, '223-CUCUTILLA'),
(789, 'DURANIA', 18, 239, '239-DURANIA'),
(790, 'EL CARMEN', 18, 245, '245-EL CARMEN'),
(791, 'EL TARRA', 18, 250, '250-EL TARRA'),
(792, 'EL ZULIA', 18, 261, '261-EL ZULIA'),
(793, 'GRAMALOTE', 18, 313, '313-GRAMALOTE'),
(794, 'HACARI', 18, 344, '344-HACARÍ'),
(795, 'HERRAN', 18, 347, '347-HERRÁN'),
(796, 'LABATECA', 18, 377, '377-LABATECA'),
(797, 'LA ESPERANZA', 18, 385, '385-LA ESPERANZA'),
(798, 'LA PLAYA', 18, 398, '398-LA PLAYA DE BELÉN'),
(799, 'LOS PATIOS', 18, 405, '405-LOS PATIOS'),
(800, 'LOURDES', 18, 418, '418-LOURDES'),
(801, 'MUTISCUA', 18, 480, '480-MUTISCUA'),
(802, 'OCAÑA', 18, 498, '498-OCAÑA'),
(803, 'PAMPLONA', 18, 518, '518-PAMPLONA'),
(804, 'PAMPLONITA', 18, 520, '520-PAMPLONITA'),
(805, 'PUERTO SANTANDER', 18, 553, '553-PUERTO SANTANDER'),
(806, 'RAGONVALIA', 18, 599, '599-RAGONVALIA'),
(807, 'SALAZAR', 18, 660, '660-SALAZAR DE LAS PALMAS'),
(808, 'SAN CALIXTO', 18, 670, '670-SAN CALIXTO'),
(809, 'SAN CAYETANO', 18, 673, '673-SAN CAYETANO'),
(810, 'SANTIAGO', 18, 680, '680-SANTIAGO'),
(811, 'SARDINATA', 18, 720, '720-SARDINATA'),
(812, 'SILOS', 18, 743, '743-SANTO DOMINGO DE SILOS'),
(813, 'TEORAMA', 18, 800, '800-TEORAMA'),
(814, 'TIBU', 18, 810, '810-TIBÚ'),
(815, 'TOLEDO', 18, 820, '820-TOLEDO'),
(816, 'VILLA CARO', 18, 871, '871-VILLA CARO'),
(817, 'VILLA DEL ROSARIO', 18, 874, '874-VILLA DEL ROSARIO'),
(818, 'ARMENIA', 19, 1, '001-ARMENIA'),
(819, 'BUENAVISTA', 19, 111, '111-BUENAVISTA'),
(820, 'CALARCA', 19, 130, '130-CALARCÁ'),
(821, 'CIRCASIA', 19, 190, '190-CIRCASIA'),
(822, 'CORDOBA', 19, 212, '212-CÓRDOBA'),
(823, 'FILANDIA', 19, 272, '272-FILANDIA'),
(824, 'GENOVA', 19, 302, '302-GÉNOVA'),
(825, 'LA TEBAIDA', 19, 401, '401-LA TEBAIDA'),
(826, 'MONTENEGRO', 19, 470, '470-MONTENEGRO'),
(827, 'PIJAO', 19, 548, '548-PIJAO'),
(828, 'QUIMBAYA', 19, 594, '594-QUIMBAYA'),
(829, 'SALENTO', 19, 690, '690-SALENTO'),
(830, 'PEREIRA', 20, 1, '001-PEREIRA'),
(831, 'APIA', 20, 45, '045-APÍA'),
(832, 'BALBOA', 20, 75, '075-BALBOA'),
(833, 'BELEN DE UMBRIA', 20, 88, '088-BELÉN DE UMBRÍA'),
(834, 'DOSQUEBRADAS', 20, 170, '170-DOSQUEBRADAS'),
(835, 'GUATICA', 20, 318, '318-GUÁTICA'),
(836, 'LA CELIA', 20, 383, '383-LA CELIA'),
(837, 'LA VIRGINIA', 20, 400, '400-LA VIRGINIA'),
(838, 'MARSELLA', 20, 440, '440-MARSELLA'),
(839, 'MISTRATO', 20, 456, '456-MISTRATÓ'),
(840, 'PUEBLO RICO', 20, 572, '572-PUEBLO RICO'),
(841, 'QUINCHIA', 20, 594, '594-QUINCHÍA'),
(842, 'SANTA ROSA DE CABAL', 20, 682, '682-SANTA ROSA DE CABAL'),
(843, 'SANTUARIO', 20, 687, '687-SANTUARIO'),
(844, 'BUCARAMANGA', 21, 1, '001-BUCARAMANGA'),
(845, 'AGUADA', 21, 13, '013-AGUADA'),
(846, 'ALBANIA', 21, 20, '020-ALBANIA'),
(847, 'ARATOCA', 21, 51, '051-ARATOCA'),
(848, 'BARBOSA', 21, 77, '077-BARBOSA'),
(849, 'BARICHARA', 21, 79, '079-BARICHARA'),
(850, 'BARRANCABERMEJA', 21, 81, '081-BARRANCABERMEJA'),
(851, 'BETULIA', 21, 92, '092-BETULIA'),
(852, 'BOLIVAR', 21, 101, '101-BOLÍVAR'),
(853, 'CABRERA', 21, 121, '121-CABRERA'),
(854, 'CALIFORNIA', 21, 132, '132-CALIFORNIA'),
(855, 'CAPITANEJO', 21, 147, '147-CAPITANEJO'),
(856, 'CARCASI', 21, 152, '152-CARCASÍ'),
(857, 'CEPITA', 21, 160, '160-CEPITÁ'),
(858, 'CERRITO', 21, 162, '162-CERRITO'),
(859, 'CHARALA', 21, 167, '167-CHARALÁ'),
(860, 'CHARTA', 21, 169, '169-CHARTA'),
(861, 'CHIMA', 21, 176, '176-CHIMA'),
(862, 'CHIPATA', 21, 179, '179-CHIPATÁ'),
(863, 'CIMITARRA', 21, 190, '190-CIMITARRA'),
(864, 'CONCEPCION', 21, 207, '207-CONCEPCIÓN'),
(865, 'CONFINES', 21, 209, '209-CONFINES'),
(866, 'CONTRATACION', 21, 211, '211-CONTRATACIÓN'),
(867, 'COROMORO', 21, 217, '217-COROMORO'),
(868, 'CURITI', 21, 229, '229-CURITÍ'),
(869, 'EL CARMEN DE CHUCURI', 21, 235, '235-EL CARMEN DE CHUCURÍ'),
(870, 'EL GUACAMAYO', 21, 245, '245-EL GUACAMAYO'),
(871, 'EL PEÑON', 21, 250, '250-EL PEÑÓN'),
(872, 'EL PLAYON', 21, 255, '255-EL PLAYÓN'),
(873, 'ENCINO', 21, 264, '264-ENCINO'),
(874, 'ENCISO', 21, 266, '266-ENCISO'),
(875, 'FLORIAN', 21, 271, '271-FLORIÁN'),
(876, 'FLORIDABLANCA', 21, 276, '276-FLORIDABLANCA'),
(877, 'GALAN', 21, 296, '296-GALÁN'),
(878, 'GAMBITA', 21, 298, '298-GÁMBITA'),
(879, 'GIRON', 21, 307, '307-GIRÓN'),
(880, 'GUACA', 21, 318, '318-GUACA'),
(881, 'GUADALUPE', 21, 320, '320-GUADALUPE'),
(882, 'GUAPOTA', 21, 322, '322-GUAPOTÁ'),
(883, 'GUAVATA', 21, 324, '324-GUAVATÁ'),
(884, 'GÜEPSA', 21, 327, '327-GÜEPSA'),
(885, 'HATO', 21, 344, '344-HATO'),
(886, 'JESUS MARIA', 21, 368, '368-JESÚS MARÍA'),
(887, 'JORDAN', 21, 370, '370-JORDÁN'),
(888, 'LA BELLEZA', 21, 377, '377-LA BELLEZA'),
(889, 'LANDAZURI', 21, 385, '385-LANDÁZURI'),
(890, 'LA PAZ', 21, 397, '397-LA PAZ'),
(891, 'LEBRIJA', 21, 406, '406-LEBRIJA'),
(892, 'LOS SANTOS', 21, 418, '418-LOS SANTOS'),
(893, 'MACARAVITA', 21, 425, '425-MACARAVITA'),
(894, 'MALAGA', 21, 432, '432-MÁLAGA'),
(895, 'MATANZA', 21, 444, '444-MATANZA'),
(896, 'MOGOTES', 21, 464, '464-MOGOTES'),
(897, 'MOLAGAVITA', 21, 468, '468-MOLAGAVITA'),
(898, 'OCAMONTE', 21, 498, '498-OCAMONTE'),
(899, 'OIBA', 21, 500, '500-OIBA'),
(900, 'ONZAGA', 21, 502, '502-ONZAGA'),
(901, 'PALMAR', 21, 522, '522-PALMAR'),
(902, 'PALMAS DEL SOCORRO', 21, 524, '524-PALMAS DEL SOCORRO'),
(903, 'PARAMO', 21, 533, '533-PÁRAMO'),
(904, 'PIEDECUESTA', 21, 547, '547-PIEDECUESTA'),
(905, 'PINCHOTE', 21, 549, '549-PINCHOTE'),
(906, 'PUENTE NACIONAL', 21, 572, '572-PUENTE NACIONAL'),
(907, 'PUERTO PARRA', 21, 573, '573-PUERTO PARRA'),
(908, 'PUERTO WILCHES', 21, 575, '575-PUERTO WILCHES'),
(909, 'RIONEGRO', 21, 615, '615-RIONEGRO'),
(910, 'SABANA DE TORRES', 21, 655, '655-SABANA DE TORRES'),
(911, 'SAN ANDRES', 21, 669, '669-SAN ANDRÉS'),
(912, 'SAN BENITO', 21, 673, '673-SAN BENITO'),
(913, 'SAN GIL', 21, 679, '679-SAN GIL'),
(914, 'SAN JOAQUIN', 21, 682, '682-SAN JOAQUÍN'),
(915, 'SAN JOSE DE MIRANDA', 21, 684, '684-SAN JOSÉ DE MIRANDA'),
(916, 'SAN MIGUEL', 21, 686, '686-SAN MIGUEL'),
(917, 'SAN VICENTE DE CHUCURI', 21, 689, '689-SAN VICENTE DE CHUCURÍ'),
(918, 'SANTA BARBARA', 21, 705, '705-SANTA BÁRBARA'),
(919, 'SANTA HELENA DEL OPON', 21, 720, '720-SANTA HELENA DEL OPÓN'),
(920, 'SIMACOTA', 21, 745, '745-SIMACOTA'),
(921, 'SOCORRO', 21, 755, '755-SOCORRO'),
(922, 'SUAITA', 21, 770, '770-SUAITA'),
(923, 'SUCRE', 21, 773, '773-SUCRE'),
(924, 'SURATA', 21, 780, '780-SURATÁ'),
(925, 'TONA', 21, 820, '820-TONA'),
(926, 'VALLE DE SAN JOSE', 21, 855, '855-VALLE DE SAN JOSÉ'),
(927, 'VELEZ', 21, 861, '861-VÉLEZ'),
(928, 'VETAS', 21, 867, '867-VETAS'),
(929, 'VILLANUEVA', 21, 872, '872-VILLANUEVA'),
(930, 'ZAPATOCA', 21, 895, '895-ZAPATOCA'),
(931, 'SINCELEJO', 22, 1, '001-SINCELEJO'),
(932, 'BUENAVISTA', 22, 110, '110-BUENAVISTA'),
(933, 'CAIMITO', 22, 124, '124-CAIMITO'),
(934, 'COLOSO', 22, 204, '204-COLOSÓ'),
(935, 'COROZAL', 22, 215, '215-COROZAL'),
(936, 'COVEÑAS', 22, 221, '221-COVEÑAS'),
(937, 'CHALAN', 22, 230, '230-CHALÁN'),
(938, 'EL ROBLE', 22, 233, '233-EL ROBLE'),
(939, 'GALERAS', 22, 235, '235-GALERAS'),
(940, 'GUARANDA', 22, 265, '265-GUARANDA'),
(941, 'LA UNION', 22, 400, '400-LA UNIÓN'),
(942, 'LOS PALMITOS', 22, 418, '418-LOS PALMITOS'),
(943, 'MAJAGUAL', 22, 429, '429-MAJAGUAL'),
(944, 'MORROA', 22, 473, '473-MORROA'),
(945, 'OVEJAS', 22, 508, '508-OVEJAS'),
(946, 'PALMITO', 22, 523, '523-PALMITO'),
(947, 'SAMPUES', 22, 670, '670-SAMPUÉS'),
(948, 'SAN BENITO ABAD', 22, 678, '678-SAN BENITO ABAD'),
(949, 'SAN JUAN DE BETULIA', 22, 702, '702-SAN JUAN DE BETULIA'),
(950, 'SAN MARCOS', 22, 708, '708-SAN MARCOS'),
(951, 'SAN ONOFRE', 22, 713, '713-SAN ONOFRE'),
(952, 'SAN PEDRO', 22, 717, '717-SAN PEDRO'),
(953, 'SAN LUIS DE SINCE', 22, 742, '742-SAN LUIS DE SINCÉ'),
(954, 'SUCRE', 22, 771, '771-SUCRE'),
(955, 'SANTIAGO DE TOLU', 22, 820, '820-SANTIAGO DE TOLÚ'),
(956, 'TOLU VIEJO', 22, 823, '823-TOLÚ VIEJO'),
(957, 'IBAGUE', 23, 1, '001-IBAGUÉ'),
(958, 'ALPUJARRA', 23, 24, '024-ALPUJARRA'),
(959, 'ALVARADO', 23, 26, '026-ALVARADO'),
(960, 'AMBALEMA', 23, 30, '030-AMBALEMA'),
(961, 'ANZOATEGUI', 23, 43, '043-ANZOÁTEGUI'),
(962, 'ARMERO', 23, 55, '055-ARMERO (GUAYABAL)'),
(963, 'ATACO', 23, 67, '067-ATACO'),
(964, 'CAJAMARCA', 23, 124, '124-CAJAMARCA'),
(965, 'CARMEN DE APICALA', 23, 148, '148-CARMEN DE APICALÁ'),
(966, 'CASABIANCA', 23, 152, '152-CASABIANCA'),
(967, 'CHAPARRAL', 23, 168, '168-CHAPARRAL'),
(968, 'COELLO', 23, 200, '200-COELLO'),
(969, 'COYAIMA', 23, 217, '217-COYAIMA'),
(970, 'CUNDAY', 23, 226, '226-CUNDAY'),
(971, 'DOLORES', 23, 236, '236-DOLORES'),
(972, 'ESPINAL', 23, 268, '268-ESPINAL'),
(973, 'FALAN', 23, 270, '270-FALAN'),
(974, 'FLANDES', 23, 275, '275-FLANDES'),
(975, 'FRESNO', 23, 283, '283-FRESNO'),
(976, 'GUAMO', 23, 319, '319-GUAMO'),
(977, 'HERVEO', 23, 347, '347-HERVEO'),
(978, 'HONDA', 23, 349, '349-HONDA'),
(979, 'ICONONZO', 23, 352, '352-ICONONZO'),
(980, 'LERIDA', 23, 408, '408-LÉRIDA'),
(981, 'LIBANO', 23, 411, '411-LÍBANO'),
(982, 'MARIQUITA', 23, 443, '443-SAN SEBASTIÁN DE MARIQUITA'),
(983, 'MELGAR', 23, 449, '449-MELGAR'),
(984, 'MURILLO', 23, 461, '461-MURILLO'),
(985, 'NATAGAIMA', 23, 483, '483-NATAGAIMA'),
(986, 'ORTEGA', 23, 504, '504-ORTEGA'),
(987, 'PALOCABILDO', 23, 520, '520-PALOCABILDO'),
(988, 'PIEDRAS', 23, 547, '547-PIEDRAS'),
(989, 'PLANADAS', 23, 555, '555-PLANADAS'),
(990, 'PRADO', 23, 563, '563-PRADO'),
(991, 'PURIFICACION', 23, 585, '585-PURIFICACIÓN'),
(992, 'RIOBLANCO', 23, 616, '616-RIOBLANCO'),
(993, 'RONCESVALLES', 23, 622, '622-RONCESVALLES'),
(994, 'ROVIRA', 23, 624, '624-ROVIRA'),
(995, 'SALDAÑA', 23, 671, '671-SALDAÑA'),
(996, 'SAN ANTONIO', 23, 675, '675-SAN ANTONIO'),
(997, 'SAN LUIS', 23, 678, '678-SAN LUIS'),
(998, 'SANTA ISABEL', 23, 686, '686-SANTA ISABEL'),
(999, 'SUAREZ', 23, 770, '770-SUÁREZ'),
(1000, 'VALLE DE SAN JUAN', 23, 854, '854-VALLE DE SAN JUAN'),
(1001, 'VENADILLO', 23, 861, '861-VENADILLO'),
(1002, 'VILLAHERMOSA', 23, 870, '870-VILLAHERMOSA'),
(1003, 'VILLARRICA', 23, 873, '873-VILLARRICA'),
(1004, 'CALI', 24, 1, '001-CALI'),
(1005, 'ALCALA', 24, 20, '020-ALCALÁ'),
(1006, 'ANDALUCIA', 24, 36, '036-ANDALUCÍA'),
(1007, 'ANSERMANUEVO', 24, 41, '041-ANSERMANUEVO'),
(1008, 'ARGELIA', 24, 54, '054-ARGELIA'),
(1009, 'BOLIVAR', 24, 100, '100-BOLÍVAR'),
(1010, 'BUENAVENTURA', 24, 109, '109-BUENAVENTURA'),
(1011, 'GUADALAJARA DE BUGA', 24, 111, '111-GUADALAJARA DE BUGA'),
(1012, 'BUGALAGRANDE', 24, 113, '113-BUGALAGRANDE'),
(1013, 'CAICEDONIA', 24, 122, '122-CAICEDONIA'),
(1014, 'CALIMA', 24, 126, '126-CALIMA (DARIEN)'),
(1015, 'CANDELARIA', 24, 130, '130-CANDELARIA'),
(1016, 'CARTAGO', 24, 147, '147-CARTAGO'),
(1017, 'DAGUA', 24, 233, '233-DAGUA'),
(1018, 'EL AGUILA', 24, 243, '243-EL ÁGUILA'),
(1019, 'EL CAIRO', 24, 246, '246-EL CAIRO'),
(1020, 'EL CERRITO', 24, 248, '248-EL CERRITO'),
(1021, 'EL DOVIO', 24, 250, '250-EL DOVIO'),
(1022, 'FLORIDA', 24, 275, '275-FLORIDA'),
(1023, 'GINEBRA', 24, 306, '306-GINEBRA'),
(1024, 'GUACARI', 24, 318, '318-GUACARÍ'),
(1025, 'JAMUNDI', 24, 364, '364-JAMUNDÍ'),
(1026, 'LA CUMBRE', 24, 377, '377-LA CUMBRE'),
(1027, 'LA UNION', 24, 400, '400-LA UNIÓN'),
(1028, 'LA VICTORIA', 24, 403, '403-LA VICTORIA'),
(1029, 'OBANDO', 24, 497, '497-OBANDO'),
(1030, 'PALMIRA', 24, 520, '520-PALMIRA'),
(1031, 'PRADERA', 24, 563, '563-PRADERA'),
(1032, 'RESTREPO', 24, 606, '606-RESTREPO'),
(1033, 'RIOFRIO', 24, 616, '616-RIOFRÍO'),
(1034, 'ROLDANILLO', 24, 622, '622-ROLDANILLO'),
(1035, 'SAN PEDRO', 24, 670, '670-SAN PEDRO'),
(1036, 'SEVILLA', 24, 736, '736-SEVILLA'),
(1037, 'TORO', 24, 823, '823-TORO'),
(1038, 'TRUJILLO', 24, 828, '828-TRUJILLO'),
(1039, 'TULUA', 24, 834, '834-TULUÁ'),
(1040, 'ULLOA', 24, 845, '845-ULLOA'),
(1041, 'VERSALLES', 24, 863, '863-VERSALLES'),
(1042, 'VIJES', 24, 869, '869-VIJES'),
(1043, 'YOTOCO', 24, 890, '890-YOTOCO'),
(1044, 'YUMBO', 24, 892, '892-YUMBO'),
(1045, 'ZARZAL', 24, 895, '895-ZARZAL'),
(1046, 'ARAUCA', 25, 1, '001-ARAUCA'),
(1047, 'ARAUQUITA', 25, 65, '065-ARAUQUITA'),
(1048, 'CRAVO NORTE', 25, 220, '220-CRAVO NORTE'),
(1049, 'FORTUL', 25, 300, '300-FORTUL'),
(1050, 'PUERTO RONDON', 25, 591, '591-PUERTO RONDÓN'),
(1051, 'SARAVENA', 25, 736, '736-SARAVENA'),
(1052, 'TAME', 25, 794, '794-TAME'),
(1053, 'YOPAL', 26, 1, '001-YOPAL'),
(1054, 'AGUAZUL', 26, 10, '010-AGUAZUL'),
(1055, 'CHAMEZA', 26, 15, '015-CHÁMEZA'),
(1056, 'HATO COROZAL', 26, 125, '125-HATO COROZAL'),
(1057, 'LA SALINA', 26, 136, '136-LA SALINA'),
(1058, 'MANI', 26, 139, '139-MANÍ'),
(1059, 'MONTERREY', 26, 162, '162-MONTERREY'),
(1060, 'NUNCHIA', 26, 225, '225-NUNCHÍA'),
(1061, 'OROCUE', 26, 230, '230-OROCUÉ'),
(1062, 'PAZ DE ARIPORO', 26, 250, '250-PAZ DE ARIPORO'),
(1063, 'PORE', 26, 263, '263-PORE'),
(1064, 'RECETOR', 26, 279, '279-RECETOR'),
(1065, 'SABANALARGA', 26, 300, '300-SABANALARGA'),
(1066, 'SACAMA', 26, 315, '315-SÁCAMA'),
(1067, 'SAN LUIS DE PALENQUE', 26, 325, '325-SAN LUIS DE PALENQUE'),
(1068, 'TAMARA', 26, 400, '400-TÁMARA'),
(1069, 'TAURAMENA', 26, 410, '410-TAURAMENA'),
(1070, 'TRINIDAD', 26, 430, '430-TRINIDAD'),
(1071, 'VILLANUEVA', 26, 440, '440-VILLANUEVA'),
(1072, 'MOCOA', 27, 1, '001-MOCOA'),
(1073, 'COLON', 27, 219, '219-COLÓN'),
(1074, 'ORITO', 27, 320, '320-ORITO'),
(1075, 'PUERTO ASIS', 27, 568, '568-PUERTO ASÍS'),
(1076, 'PUERTO CAICEDO', 27, 569, '569-PUERTO CAICEDO'),
(1077, 'PUERTO GUZMAN', 27, 571, '571-PUERTO GUZMÁN'),
(1078, 'LEGUIZAMO', 27, 573, '573-PUERTO LEGUÍZAMO'),
(1079, 'SIBUNDOY', 27, 749, '749-SIBUNDOY'),
(1080, 'SAN FRANCISCO', 27, 755, '755-SAN FRANCISCO'),
(1081, 'SAN MIGUEL', 27, 757, '757-SAN MIGUEL'),
(1082, 'SANTIAGO', 27, 760, '760-SANTIAGO'),
(1083, 'VALLE DEL GUAMUEZ', 27, 865, '865-VALLE DEL GUAMUEZ'),
(1084, 'VILLAGARZON', 27, 885, '885-VILLAGARZÓN'),
(1085, 'SAN ANDRES', 28, 1, '001-SAN ANDRÉS'),
(1086, 'PROVIDENCIA', 28, 564, '564-PROVIDENCIA'),
(1087, 'LETICIA', 29, 1, '001-LETICIA'),
(1088, 'EL ENCANTO', 29, 263, '263-EL ENCANTO'),
(1089, 'LA CHORRERA', 29, 405, '405-LA CHORRERA'),
(1090, 'LA PEDRERA', 29, 407, '407-LA PEDRERA'),
(1091, 'LA VICTORIA', 29, 430, '430-LA VICTORIA'),
(1092, 'MIRITI - PARANA', 29, 460, '460-MIRITÍ – PARANÁ'),
(1093, 'PUERTO ALEGRIA', 29, 530, '530-PUERTO ALEGRÍA'),
(1094, 'PUERTO ARICA', 29, 536, '536-PUERTO ARICA'),
(1095, 'PUERTO NARIÑO', 29, 540, '540-PUERTO NARIÑO'),
(1096, 'PUERTO SANTANDER', 29, 669, '669-PUERTO SANTANDER'),
(1097, 'TARAPACA', 29, 798, '798-TARAPACÁ'),
(1098, 'INIRIDA', 30, 1, '001-INÍRIDA'),
(1099, 'BARRANCO MINAS', 30, 343, '343-BARRANCOMINAS'),
(1100, 'MAPIRIPANA', 30, 663, '663-MAPIRIPANA'),
(1101, 'SAN FELIPE', 30, 883, '883-SAN FELIPE'),
(1102, 'PUERTO COLOMBIA', 30, 884, '884-PUERTO COLOMBIA'),
(1103, 'LA GUADALUPE', 30, 885, '885-LA GUADALUPE'),
(1104, 'CACAHUAL', 30, 886, '886-CACAHUAL'),
(1105, 'PANA PANA', 30, 887, '887-PANA PANA'),
(1106, 'MORICHAL', 30, 888, '888-MORICHAL NUEVO'),
(1107, 'SAN JOSE DEL GUAVIARE', 31, 1, '001-SAN JOSÉ DEL GUAVIARE'),
(1108, 'CALAMAR', 31, 15, '015-CALAMAR'),
(1109, 'EL RETORNO', 31, 25, '025-EL RETORNO'),
(1110, 'MIRAFLORES', 31, 200, '200-MIRAFLORES'),
(1111, 'MITU', 32, 1, '001-MITÚ'),
(1112, 'CARURU', 32, 161, '161-CARURÚ'),
(1113, 'PACOA', 32, 511, '511-PACOA'),
(1114, 'TARAIRA', 32, 666, '666-TARAIRA'),
(1115, 'PAPUNAUA', 32, 777, '777-PAPUNAHUA'),
(1116, 'YAVARATE', 32, 889, '889-YAVARATÉ'),
(1117, 'PUERTO CARREÑO', 33, 1, '001-PUERTO CARREÑO'),
(1118, 'LA PRIMAVERA', 33, 524, '524-LA PRIMAVERA'),
(1119, 'SANTA ROSALIA', 33, 624, '624-SANTA ROSALÍA'),
(1120, 'CUMARIBO', 33, 773, '773-CUMARIBO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordencompra`
--

CREATE TABLE `ordencompra` (
  `IdOrdencompra` int(11) NOT NULL,
  `IdSolicitante` int(11) NOT NULL,
  `IdArea` int(11) NOT NULL,
  `fsolicitud` date NOT NULL,
  `direnvio` varchar(45) DEFAULT NULL,
  `fcierre` date DEFAULT NULL,
  `fautorizado` date DEFAULT NULL,
  `comprado` date DEFAULT NULL,
  `recibido` date DEFAULT NULL,
  `derogada` tinyint(4) DEFAULT '0',
  `autorizada` int(11) DEFAULT NULL,
  `observaciones` varchar(100) DEFAULT NULL,
  `critico` tinyint(4) DEFAULT '0',
  `IdEmpresa` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ordencompra`
--

INSERT INTO `ordencompra` (`IdOrdencompra`, `IdSolicitante`, `IdArea`, `fsolicitud`, `direnvio`, `fcierre`, `fautorizado`, `comprado`, `recibido`, `derogada`, `autorizada`, `observaciones`, `critico`, `IdEmpresa`) VALUES
(1, 1, 1, '2023-12-20', 'calle 19', '2024-02-15', '2024-02-15', '2024-02-15', NULL, 0, 2, NULL, 1, 1),
(2, 2, 1, '2023-12-20', 'calle 19', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 1),
(3, 1, 1, '2023-12-26', 'calle 19', NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 1),
(4, 1, 2, '2024-01-21', 'calle 19', NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 1),
(5, 2, 3, '2024-01-21', 'calle con carrera', NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, 1),
(6, 3, 2, '2024-01-31', 'Calle 106 # 59 21', NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 1),
(7, 1, 2, '2024-04-15', 'calle 19', '2024-04-21', '2024-04-21', NULL, NULL, 0, 1, NULL, 0, 1),
(8, 1, 2, '2024-04-17', 'calle con carrera', NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 1),
(9, 1, 2, '2024-04-17', 'calle con carrera', '2024-04-21', '2024-04-21', NULL, NULL, 0, 1, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `IdProveedor` int(11) NOT NULL,
  `proveedor` varchar(65) DEFAULT NULL,
  `documento` varchar(11) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(60) DEFAULT NULL,
  `departamento` int(11) DEFAULT NULL,
  `ciudad` int(11) DEFAULT NULL,
  `contacto` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `email2` varchar(45) DEFAULT NULL,
  `email3` varchar(45) DEFAULT NULL,
  `IdSegmento` int(11) DEFAULT NULL,
  `claespe` text,
  `finscrip` date DEFAULT NULL,
  `replegal` varchar(45) DEFAULT NULL,
  `regimen` tinyint(4) DEFAULT '0',
  `celular` varchar(20) DEFAULT NULL,
  `fconstitucion` date DEFAULT NULL,
  `granc` tinyint(4) DEFAULT '0',
  `autoret` tinyint(4) DEFAULT '0',
  `declarante` tinyint(4) DEFAULT NULL,
  `rut` varchar(100) DEFAULT NULL,
  `fotced` varchar(100) DEFAULT NULL,
  `camcom` varchar(100) DEFAULT NULL,
  `fotresfac` varchar(100) DEFAULT NULL,
  `certbanc` varchar(100) DEFAULT NULL,
  `docauto` varchar(100) DEFAULT NULL,
  `resacr` varchar(100) DEFAULT NULL,
  `fictecnica` varchar(100) DEFAULT NULL,
  `cercalidad` varchar(100) DEFAULT NULL,
  `cercalibra` varchar(100) DEFAULT NULL,
  `licsegur` varchar(100) DEFAULT NULL,
  `lislabora` varchar(100) DEFAULT NULL,
  `regedu` varchar(100) DEFAULT NULL,
  `ficdot` varchar(100) DEFAULT NULL,
  `licamb` varchar(100) DEFAULT NULL,
  `psev` varchar(100) DEFAULT NULL,
  `licfunci` varchar(100) DEFAULT NULL,
  `tarpropsi` varchar(100) DEFAULT NULL,
  `IdBanco` int(11) DEFAULT NULL,
  `clasecuenta` tinyint(4) DEFAULT NULL,
  `cuenta` varchar(15) DEFAULT NULL,
  `observaeval` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`IdProveedor`, `proveedor`, `documento`, `telefono`, `direccion`, `departamento`, `ciudad`, `contacto`, `email`, `email2`, `email3`, `IdSegmento`, `claespe`, `finscrip`, `replegal`, `regimen`, `celular`, `fconstitucion`, `granc`, `autoret`, `declarante`, `rut`, `fotced`, `camcom`, `fotresfac`, `certbanc`, `docauto`, `resacr`, `fictecnica`, `cercalidad`, `cercalibra`, `licsegur`, `lislabora`, `regedu`, `ficdot`, `licamb`, `psev`, `licfunci`, `tarpropsi`, `IdBanco`, `clasecuenta`, `cuenta`, `observaeval`) VALUES
(1, 'OSCAR ARTURO CAICEDO GARZON', '80765206', '3132071482', 'CARRERA 16A # 185 - 82', 3, 149, 'OSCAR CAICEDO', 'oacaicedog@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3132071482', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '61214490527', NULL),
(2, 'ZULIBET SUMINISTROS', '10165637', '6066122095', 'CALLE 49 #3-18 SECTOR COMERCIAL', 3, 149, 'LIBARDO PONCIANO', 'suministroszulibet@hotmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '6066122095', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '22100012878', NULL),
(3, 'ALEXANDER VELEZ ARANGO', '15961599', '3127242556', 'CALLE 3  NO 7-03', 3, 149, 'ALEXANDER VELEZ', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3127242556', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '85500008686', NULL),
(4, 'CARLOS JULIO CALDERON BAUTISTA - ECORADIO STEREO', '19300752', '3123413964', NULL, 3, 149, 'CARLOS JULIO CALDERÓN BAUTISTA', 'ecoradio18@gmail.com', 'ecomunicar20@gmail.com', NULL, 0, '0', '2024-03-11', NULL, 1, '3123413964', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, '24051901765', NULL),
(5, 'EL ENCENILLO SOLUCIONES MADERABLES', '46367099', '3172368193', 'CARRERA 7 # 6-33', 11, 540, 'NATALIA PASTRANA', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3172368193', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '41100037856', NULL),
(6, 'NANCY MIRANDA', '52868074', '3156742517', 'CR 16 A 185 82 BRR VERBENAL', 3, 149, 'OSCAR CAICEDO', 'oacaicedog@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3156742517', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '34710178', NULL),
(7, 'KAREM BELTRÁN VARGAS', '53178731', '3107578916', 'CALLE 127 A BIS # 2A-12', 3, 149, 'KAREM BELTRÁN VARGAS', 'karembeltranvargas@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3107578916', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '18081383894', NULL),
(8, 'EDINAEL QUIROGA', '79132952', '3102729160', 'KRA 96 F NO 23 A 60', 3, 149, 'EDINAEL QUIROGA', 'quirogaedinael@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3102729160', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '91205240760', NULL),
(9, 'NORBERTO LOPEZ', '79274970', '3124997101', 'CL 163 A NO 7 33', 3, 149, 'NORBERTO LOPEZ', 'norbertolopez99@hotmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3124997101', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, '24084789174', NULL),
(10, 'GARARDO ARENAS', '79297308', '3005572764', 'CALLE 147 C NO. 100 – 69 CASA 30', 3, 149, 'GERARDO ARENAS', 'gerarenas@yahoo.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3005572764', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '9200321553', NULL),
(11, 'D Y S RED ENERGY', '80160164', '3028411185', '9009 CASA CALLE 106 NO. 59 - 21', 3, 149, 'DAVID NOVOA', 'davidnovoa973@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3028411185', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '3028411185', NULL),
(12, 'GUILLERMO RAMIREZ', '80168604', '3112868025', 'CALLE 137  # 85 - 76', 3, 149, 'GUILLERMO RAMIREZ', 'archeos@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3112868025', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '19223331869', NULL),
(13, 'COOPERATIVA MULTIACTIVA DE TRANSPORTES Y SERVICIOS INTEGRADOS DE ', '844001363', '3134610064', 'CR 21 9 47 BRR CENTRO', 3, 149, 'DARLENY HERNANDEZ', 'administracion.mani@cootrasic.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3134610064', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '36579604685', NULL),
(14, 'YONIS BORIS ZUÑIGA MORALES', '92228990', '3135797749', 'SANTIAGO DE TOLÚ', 22, 956, 'YONIS BORIS ZUÑIGA MORALES', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3135797749', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '50709753590', NULL),
(15, 'EBLIS JULIO JULIO', '92230597', '3046229961', 'SANTIAGO DE TOLÚ', 22, 956, 'EBLIS JULIO JULIO', 'juliojulioeblisarturo@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3046229961', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, '488000482', NULL),
(16, 'DUCON S.A.S', '800014574', '2889898', 'CRA 14 N° 99-33', 1, 87, 'FABIAN SEDANO', 'fabiansedano@ducon.com.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3223622419', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '61703261201', NULL),
(17, 'TECHNIK LTDA', '800042462', '3132099270', 'CARRERA 73 NO. 51-78 OFI 102.', 3, 149, 'CILIA MA. ARCE', 'ventas@technikltda.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3132099270', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '20165100583', NULL),
(18, 'PROASITEMAS S.A', '800042928', '4954800', 'CALLE 45 #22-18', 3, 149, 'DIEGO ALEJANDRO GÓMEZ', 'ventas@helisa.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '4954800', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '4704292801', NULL),
(19, 'GP GRÁFICAS PAJON', '800052705', '5575232', 'CARRERA 65 # 74 -75', 3, 149, 'LUIS FERNANDO PAJÓN', 'pajonmejoramiento@une.net.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '5575232', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '10042466967', NULL),
(20, 'AGQ COLOMBIA, S.A.S.', '800070853', '6715110', 'CLLE 153A 7H 72', 3, 149, 'MARIA CAMILA PULIDO', 'maria.diaz@agqlabs.com', NULL, NULL, 0, '0', '2024-03-11', ' LAURA MILENA CASTRILLON VALBUENA', 1, '6715110', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '5207085302', NULL),
(21, 'CARLOS ENRIQUE PARAMO LTDA', '800138695', '3416269', 'CALLE 14 #14-89', 3, 149, 'CARLOS PARAMO', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3112274759', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '19200000614', NULL),
(22, 'BLAMIS DOTACIONES LABORATORIO S.A.S', '800154351', '6360593', 'CARRERA 47 NO. 94 A - 06', 3, 149, 'MARIBEL CHAPARRO', 'blamis@blamis.com.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '6360593', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '4206115027', NULL),
(23, 'SODIMAC COLOMBIA S A', '800242106', '5460000', 'CARRERA 68D # 80 – 70', 3, 149, 'WWW.HOMECENTER.COM.CO', 'www.homecenter.com.co', NULL, NULL, 0, '0', '2024-03-11', 'MIGUEL PARDO BRIGARD ', 1, '3208899933', NULL, 1, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 32, 3, NULL, NULL),
(24, 'INTERRAPIDISIMO', '800251569', '5605000', 'CR 29 30 26', 3, 102, 'SERVICIO AL CLIENTE', 'tratamiento.datos.personales@interrapidisimo.', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '5605000', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 32, 3, NULL, NULL),
(25, 'ELECTRO AO SAS', '806013052', '3794541', 'CALLE 97 # 10-28', 1, 126, 'ESTEFANIA MARGARITA PERNETT', 'danielbeltran@almacenesao.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3016585475', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '12034390589', NULL),
(26, 'HUELLA VERDE S.A.S.', '811034331', '3115836788', 'CALLE 10 A 70  64', 1, 1, 'CONSUELO AGUDELO', 'huellaverde.yaneth@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3115836788', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '33144558320', NULL),
(27, 'INTECCON COLOMBIA S.A.S', '811043871', '9127201', 'CR 43 A 19 17 IN 9513', 1, 1, 'FRANCISCO ALVAREZ', 'falvarez@inteccon.com', 'danny-ramirez@intecconinc.com', 'gpalacio@intecconinc.com', 0, '0', '2024-03-11', NULL, 1, '3113568051', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '10873011986', NULL),
(28, 'TRANSPORTE CARGAS Y SERVIVIOS ESPECIALES S.A.S', '811044590', '3206824395', 'CARRERA 83 F 15 A 119', 1, 1, 'JULIO CESAR MORENO', 'transcares@yahoo.es', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3206824395', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '10322264702', NULL),
(29, 'SERVICIOS SANITARIOS PORTATILES BAÑOMOVIL S.A.S', '830008439', '2273800', 'CALLE 65 BIS # 88 - 67', 3, 149, 'KATHERINE MORENO', 'comercial3@banomovil.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3102366305', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '19102982077', NULL),
(30, 'MODERLINE SAS', '830036940', '2604667', 'CL 18 65 B 22 BRR ZONA INDUSTRIAL', 3, 149, 'ADRIANA MARIN', 'licitaciones@moderline.com', 'presidencia@moderline.com', NULL, 0, '0', '2024-03-11', NULL, 1, '3213781884', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '18313916388', NULL),
(31, 'PANAMERICANA LIBRERIA Y PAPELERIA SA.', '830037946', '6013649000', 'CALLE 12 # 34 - 30', 3, 149, 'PAGINA WEB', 'tiendavirtual@panamericana.com.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '6013649000', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 32, 3, NULL, NULL),
(32, 'EGAVAL SAS', '830043898', '3175049202', 'CARRERA 28 A # 71 - 88', 3, 149, 'JUANA VALENTINA CARDENAS', 'minoristas02@egaval.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3175049202', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '206-000003-19', NULL),
(33, 'PLASTEMPACK DE COLOMBIA', '830048718', '6012613005', 'CARRERA 65 # 4D -34 BARRIO PRADERA.', 3, 149, 'CLAUDIA', 'servicioalcliente@plastempack.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '6012613005', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, NULL, NULL),
(34, 'ORGANIZACIÓN SERIN LTDA.', '830062421', '5407700', 'CALLE 70A # 16 - 43', 3, 149, 'DORIS CAICEDO ORTIZ', 'dorisc@organizacionserin.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3105523842', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '7122605404', NULL),
(35, 'METROLABOR LTDA', '830082016', '3688091', 'CARRERA 28 A 39 A 45 PISO 2', 3, 149, 'FERNANDA TIQUE', 'comercial@metrolabor.com', 'facturacion@metrolabor.net', NULL, 0, '0', '2024-03-11', NULL, 1, '3108962343', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '1920685393-2', NULL),
(36, 'HIDROANALISIS LTDA', '830097842', '6682978', 'TORRE 10, CL. 169 #16C - 10 OFICINA 503', 3, 149, 'JESÚS RUBIANO', 'hidroanalisishotmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '6682978', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '605210111', NULL),
(37, 'EQUIPOS Y MEDICIONES TECNICAS', '830100716', '3183978821', 'CALLE 124 N° 7-35', 3, 149, 'JAZMIN ESCOBAR', 'info@equiposymediciones.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3183978821', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '201-372956-29', NULL),
(38, 'LAB&SERVICE', '830102766', '6016741061', 'CARRERA 67 NO. 167-61 OFICINA 209, CENTRO EMPRESARIAL COLINA', 3, 149, 'DIANA MARCELA CARDENAS SALDARRIAGA', 'comercial3@labserviceltda.com', 'info@labserviceltda.com', NULL, 0, '0', '2024-03-11', NULL, 1, '316-5211225', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '20165726762', NULL),
(39, 'CIAN LABORATORIO ANALISIS', '830502614', '3008107512', 'CARRERA 65 NO. 5A-45', 3, 149, 'AMELIA CASTRO', 'admoncianltda@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3008107512', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 2, '4569999230', NULL),
(40, 'TVL TRANSPORTES', '860003394', '4201044', 'CALLE 12 BIS 68 D 18', 3, 149, 'JULIAN CIFUENTES', 'comercial@tvl.com.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3153493295', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '33238635121', NULL),
(41, 'SFI SAS', '860055913', '747057', 'KR 106 # 15 - 25', 3, 149, 'ANDRES TOVAR', 'atovar@sfisas.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '7470191', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 2, '917001026', NULL),
(42, 'INDUSTRIA DE CALZADO JOVICAL S.A.S', '860069040', '3160246425', 'AVENIDA CALLE 13 #68B - 74', 3, 149, 'ALEJANDRA ALONSO ROMERO', 'montevideo@calzadojovical.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3160246425', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '17100880060', NULL),
(43, 'INDUSTRIAS ASOCIADAS', '860451201', '3208550744', 'CARRERA. 27 # 13 - 95', 3, 149, 'CRISTHIAN TORRES', 'ventas@industriasasociadas.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3208550744', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '2197-315003-8', NULL),
(44, 'SERVIENTREGA S A', '860512330', '6017700380', 'AVENIDA 6 34A 11', 3, 149, NULL, NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '6017700380', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 32, 3, NULL, NULL),
(45, 'INDUSTRIAS Y CONFECCIONES INDUCON S.A.S', '860519920', '7569100', 'CARRERA 34 NO 19-84', 3, 149, 'PILAR CAMACHO ORTIZ', 'pcamacho@confeccionesinducon.com', 'servicioalcliente@confeccionesinducon.com', NULL, 0, '0', '2024-03-11', NULL, 1, '3133209242', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '14177050202', NULL),
(46, 'UNIFORMES INDUSTRIALES ROPA Y CALZADO QUIN LOP S.A.S', '890913861', '3452128', 'AVENIDA CARRERA 68 # 11 - 66', 3, 149, 'MAICOL', 'servicioalcliente@uniroca.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3183998743', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '1601430161', NULL),
(47, 'INSTITUTO GEOGRÁFICO AGUSTÍN CODAZZI - IGAC', '899999004', '6531888', 'AVE CRA 30 #Nº 48-51', 3, 149, NULL, 'contactenos@igac.gov.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '6531888', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 2, '11990017', NULL),
(48, 'ICA DIRECCIÓN DE LABORATORIO E INNOVACIÓN AMBIENTAL', '899999062', '5801111', 'AVENIDA TRONCAL OCCIDENTE #18-76', 3, 149, 'EDWIN GARCIA; ASTRID LADINO', 'laboratorio@car.gov.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '5801111', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '35426613080', NULL),
(49, 'LABORATORIO DE HIGRÁULICA UNIVERSIDAD NACIONAL DE COLOMBIA', '899999063', '3165000', 'AV NQS (CRA 30) # 45-03', 3, 149, 'MARIA ESPERANZA ANGEL CARDENAS', 'lddonadog@unal.edu.co', 'meangelc@unal.edu.co', NULL, 0, '0', '2024-03-11', NULL, 1, '3165000', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, '12720074', NULL),
(50, 'HIGH TEC ENVIRONMENTAL LTDA', '900013343', '2499205', 'CARRERA 55 NO. 152B -68 OFICINA 706', 3, 149, 'GERMAN RODRIGUEZ', 'gerentecuentas@hteltda.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3108619395', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '10145928345', NULL),
(51, 'METAL DISEÑOS GMC', '900063867', '3242814081', 'CARRERA :CALLE 106 #59-21.', 3, 149, 'PAGINA WEB', 'PAGINA WEB', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3242814081', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL),
(52, 'LAB&SERVICE', '900084595', '3155672968', 'ENVIGADO', 3, 149, 'DIANA HINCAPIE', 'gerencia@negociosinstitucionales.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3155672968', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '21827132282', NULL),
(53, 'MERCURIO CENTRO COMERCIAL', '900151765', '3102153383', 'CARRERA 7 NO. 32-35', 11, 543, 'JUAN CARLOS', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3102153383', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '456800066148', NULL),
(54, 'X-CHEM', '900213141', '3133501195', 'CALLE 21 1-50', 3, 149, 'OSCAR ACEVEDO', 'comercial@xchemco.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3133501195', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '337000157-13', NULL),
(55, 'BIOPOLIMEROS INDUSTRIALES S.A.S.', '900246497', '3174300812', 'CRA. 18 # 63 A 50', 3, 149, 'FERNANDO SEPÚLVEDA ROBLES', 'comercial6@biopolab.com', 'administrativo@biopolab.com', NULL, 0, '0', '2024-03-11', 'MARIA LILIANA OLMOS', 1, '5405700', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '57381316400', NULL),
(56, 'OPHTHALMOS COLOMBIA LTDA', '900263767', '3132090515', 'KR 50 71A - 62', 3, 149, 'PAGINA WEB', 'asesora.pimperial@ophthalmos-ltda.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3132090515', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL),
(57, 'HANNA INSTRUMENTS', '900352772', '5189995', 'CRA 98 NO 25G-10 BODEGA 9', 3, 149, 'NATALIA LANCHEROS', 'natalia@hannacolombia.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '5189995', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 2, '037-55145-4', NULL),
(58, 'GRUPO ÉLITE', '900353432', '3906686', 'CRA. 13 A #NO 34 - 72 OFICINA 209,', 3, 149, 'CAROLINA VIVAS', 'cvivas@gelite.org', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3906686', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '15400001919', NULL),
(59, 'EQUIPOS Y LABORATORIO DE COLOMBIA SAS', '900355024', '4480388', 'CARRERA 57 # 74 - 04 BOD 117', 1, 59, 'ADRIANA EVERST', 'info@equiposylaboratorios.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '4480388', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '35393458967', NULL),
(60, 'SALUD OCUPACIONAL INTEGRAL PARA EL TRABAJADOR S. A. S.', '900364179', '3135675691', 'CR 5 N 15 43 P 1', 3, 149, 'FERNANDO GARCIA GARCIA', 'soitsas2010@hotmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3135675691', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '50764420478', NULL),
(61, 'CJC SALUD OCUPACIONAL SAS', '900407704', '3133766118', 'AV CARACAS: 14, Cra. 13 #13', 3, 149, 'MARIA FERNANDA ARDILA', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3133766118', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '23380582422', NULL),
(62, 'GRUPO DE PROFESIONALES INNOVA S.A.S', '900410466', '3183877131', 'CALLE 3A #15-7', 3, 149, 'JESUS MOVILLA', 'comercial.fundacion2@gpinnova.com.co', 'contabilidad@gpinnova.com.co', 'comercial@gpinnova.com.co', 0, '0', '2024-03-11', 'BELEÑO GOMEZ ARMANDO ENRIQUE', 1, '33244350743', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, NULL),
(63, 'WEATHER CONTROLS S.A.S.', '900433479', '3215684464', 'CALLE. 73 # 62 - 63', 3, 149, 'MARCELA ROJAS P.', 'ventas@weathercontrols.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3215684464', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 0, NULL, NULL),
(64, 'HIERROS DE OCCIDENTE FERRETERIAS SAS', '900448470', '3300404', 'CRA 9A LOTE 2 LA BADEA', 20, 834, NULL, 'contabilidad.armenia@hierrosdeoccidente.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3300404', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 27, 3, NULL, NULL),
(65, 'MINISTERIO DE JUSTICIA Y DEL DERECHO', '900457461', '4443100', 'CALLE 53 NO. 13-27', 3, 149, 'MINISTERIO DE JUSTICIA Y DEL DERECHO', 'gestión.documental@minjusticia.gov.co', 'notificaciones.judiciales@minjusticia.gov.co', 'uriel.ramirez@minjusticia.gov.co', 0, '0', '2024-03-11', NULL, 1, '5998961', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 0, NULL, NULL),
(66, 'EXTINTORES ABC', '900498806', '3928704', 'CARRERA 69 NO. 65-70 BOSQUE POPULAR', 3, 149, 'LORENA BARRERO', 'extintoresabccolombiasas@hotmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '315493111', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '0071-70496025', NULL),
(67, 'AMBIUS SAS', '900506483', '2698305', 'CALLE 3A #15-7', 3, 149, 'JAIME BERMUDEZ', 'j.bermudez@ambius.com.co', NULL, NULL, 0, '0', '2024-03-11', ' BERMUDEZ GUTIERREZ JAIME EDUARDO ', 1, '3008107512', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '550488413521813', NULL),
(68, 'GREENFOREST-SERVICIOS FORESTALES SAS', '900550746', '3286642', 'CALLE 17 NO. 37 A 80 OF. 308', 3, 149, 'GINA PAOLA BERRIO', 'paola.berrio@greenforestsas.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3286642', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '23687767691', NULL),
(69, 'SMERCHZPAIN / MEDICAL LAB IPS S.A.S', '900627708', '3219676603', 'CARRERA 14 BIS N° 16 BIS - 14', 11, 487, 'ANA BERNAL MORENO', 'comercialmedicallab@smerchz.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3219676603', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 2, '406000129477', NULL),
(70, 'CENTRO DE ENSEÑANZA AUTOMOVILISTICA EXPERTOS AL VOLANTE S A S', '900629288', '310788640', 'CR 6 11 04 P 1 SOACHA', 3, 149, NULL, 'ceaexpertosalvolante@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '310788640', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '22100012878', NULL),
(71, 'NUMBITECH', '900672953', '3044163696', 'CARRERA 12 # 90 - 20', 3, 149, 'PAOLA MARIN', 'e-mail: paola.marin@nimbutech.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3044163696', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '4016700679', NULL),
(72, 'AMBIENTALIA SAS', '900700933', '7174282', 'CALLE 96 NO. 68B-12', 3, 149, 'ALFONSO PINO', 'comercial@ambientalia.com.co', NULL, NULL, 0, '0', '2024-03-11', 'ALFONSO GARCIA DEL PINO BENEITEZ', 1, '3123295310', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '65840304502', NULL),
(73, 'MV DOTACIONES SAS', '900720041', '6014327959', 'CALLE 163 #18A-71', 3, 149, 'MARCELA BERMUDEZ', 'comercial@mvdotaciones.com.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3219002076', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '108900304768', NULL),
(74, 'PUERTAS AUTOMATICAS ASTERVI S.A.S', '900762631', '5262872', 'KR 16C NO .163-08', 3, 149, 'MAIRA GARZON', 'astervi@hotmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3002653413', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, '24047145852', NULL),
(75, 'FISIO HEALTH S.A.S', '900790887', '3008989445', 'CL 12 N 2 66', 6, 326, 'CAROLINA VARGAS', 'comercialmedicallab@smerchz.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3008989445', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '85000158064', NULL),
(76, 'MILIMETRICA DISEÑO SAS', '900801502', '3118075779', 'CALLE 106 # 59-21', 3, 149, 'CLAUDIA BARRERA RINCON', 'claus3d@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3118075779', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '1000125151', NULL),
(77, 'DOTACIONES PRISMA S.A.S.', '900821066', '3114826017', 'CARRERA 1F # 4-45 SUR', 3, 149, 'SERGIO ANDRES GUERRERO', 'dotacionesprisma@outlook.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3114826017', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '52538268224', NULL),
(78, 'GRAFICRUZ IMPRESIÓN', '900835614', '3102683172', 'CALLE 105 NO. 49-01', 3, 149, 'GRAFICRUZ', 'graficruz2012@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3102683172', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 2, '21003390420', NULL),
(79, 'ECOSEG COLOMBIA SAS', '900849371', '3178945574', 'CL 78 27 11', 3, 149, 'PAGINA WEB', 'facturaelectronicaecoseg.com.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3178945574', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '3303085717', NULL),
(80, 'PRL PREVENCION DE RIESGOS LABORALES S.A.S', '900908004', '3125660682', 'CR 66 A 4 G 62', 3, 149, 'LUIS SUAREZ', 'luis.prevencionyproteccion@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3125660682', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '8000722374', NULL),
(81, 'TECNILABOR S.A.S', '900940585', '3122984942', 'CARRERA 28A NO. 39A - 45 PISO 1', 3, 149, 'ASTRID LADINO', 'servicio@tecnilabo', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3122984942', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '77407104', NULL),
(82, 'QUIMICOMPANY', '900997618', '3165326905', 'CARRERA 34 C #17 B-80 SUR', 3, 149, 'NURY MEJIA', 'ventas@quimicompany.com.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3165326905', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '24700000365', NULL),
(83, 'PHARMASERSAS', '900999402', '3176583429', 'CARRERA 19B # 1-97 SUR', 3, 149, 'ORLANDO GONZALEZ', 'pharmasersas@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3176583429', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '4564690631', NULL),
(84, 'PALLETS PLAST SAS', '901070090', '3133286480', 'DIAG 2 # 79C-04', 3, 149, 'RONLAD GARCIA', 'gerencia.cabal2016@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3133286480', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '215-000005-30', NULL),
(85, 'METROLOGICAL CENTER S.A.S', '901079270', '3122984942', 'CALLE 73 BIS # -14', 3, 149, 'LAURA SÁENZ', 'dir.comercial@metrologicalcenter.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3122984942', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '20600000783', NULL),
(86, 'SIERRA INGENIERÍA Y AMBIENTE S.A.S', '901246558', '3505017305', 'MZ 65 CA 8 OF 201 CR 3A N 116 50 OF 201', 3, 149, 'JOHN ALEXANDER SIERRA GUAYARA', 'sierraingenieriayambiente@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3505017305', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, '24118792105', NULL),
(87, 'EQUIPSEG PLUS', '901247755', '7818162', 'CARRERA 4 # 42 - 26 BRR LOS LAURELES', 3, 149, 'JUAN SEBASTIAN HERNANDEZ VIELLARD', 'equipsegplus@outlook.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '7818162', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '68000011089', NULL),
(88, 'BIOTA SOLUCIONES AMBIENTALES SAS', '901405239', '3204106165', 'CRA 78B NO. 56 B- 46', 3, 149, 'LEIDY LANCHEROS', 'gerentecuentas@hteltda.com', NULL, NULL, 0, '0', '2024-03-11', 'CARLOS FELIPE URBINA', 1, '3506143310', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '99600000777', NULL),
(89, 'ENVIRON INGENIERÍA Y SERVICIOS S.A.S.', '901413014', '3012132810', 'CALLE 72 CR 41B 09 OF 402 ED 41 DOSANTO', 2, 126, 'JORGE RAMIREZ', 'ventas@environ.com.co', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3012132810', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '43400001562', NULL),
(90, 'UNION A&B SAS', '901435813', '3105714288', 'UBALÁ (CUNDINAMARCA)', 11, 559, 'ADRIANA  MARTÍNEZ', 'unionaybsas@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3105714288', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 2, '331740001234', NULL),
(91, 'INVERSIONES LA JIRA S.A.S - LA JIRA GRANJA RESTAURANTE', '901467907', '3175781012', 'VDA SANTA CRUZ KM 8 VIA SIBERIA', 11, 477, 'JOHANNA VILLANUEVA', 'comercial@lajiragranjarestaurante.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3175781012', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '468370005828', NULL),
(92, 'SHOPY MARKET', '901521553', '3012942145', 'CALLE 97 # 10-28', 3, 149, 'MAYRENA MONTES', 'mayrena@shopy-market.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3012942145', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '2600153965', NULL),
(93, 'UPS Y BATERIAS DE LA 21 SAS', '901592074', '3223051540', 'CALLE 21 NO 08 - 52', 3, 149, 'Marilce Moreno Orozco', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3142606592', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '108900224917', NULL),
(94, 'ALDEMAR GUZMAN E HIJOS SAS', '901602941', '3222514579', 'CARRERA 72 H NO.37 D - 50 SUR', 3, 149, 'ALDEMAR GUZMAN', 'facturasdotacionesgym@gmail.com', 'karen.guzman@dotaconfecciones.com', NULL, 0, '0', '2024-03-11', NULL, 1, '3222514579', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '108900221764', NULL),
(95, 'WENDY MARIAN MARTINEZ TRUJILLO', '1069751020', '3112734316', 'ARANZAZU', 6, 322, 'WENDY MARIAN MARTINEZ TRUJILLO', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3112734316', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '85949427388', NULL),
(96, 'PAPELERIA Y VARIEDADES CICLOTOLU', '1102832093', '3013702912', 'CALLE 16 NO 3-02', 3, 149, 'BLANCA GONZALEZ', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3013702912', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '3197997485', NULL),
(97, 'ERICK ANDRÉS MEDINA SOTOMAYOR', '1104865959', '3012285757', 'CALLE 10 # 2 -43', 3, 149, 'ERICK ANDRÉS MEDINA SOTOMAYOR', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3012285757', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '507-832656-37', NULL),
(98, 'THALYA ALEJANDRA LOPEZ TRUJILLO', '1110565269', '3052026716', 'CRA5 29 32 LC 116 CC LA QUINTA', 3, 149, 'THALYA ALEJANDRA LOPEZ TRUJILLO', 'contabilidaddesdecero1744@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3052026716', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '91219076571', NULL),
(99, 'AURA CRISTINA LOBATO', '1127592019', '3146896015', 'CALLE 3A #15-7', 3, 149, 'AURA CRISTINA LOBATO', 'aura.nabusimake@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3146896015', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '916943558-76', NULL),
(100, 'CARNICERIA CASTILLA', '1152684440', '3008614431', 'BRR VILLA NAZARETH MZ6 LT 10', 3, 149, 'RODRIGO ALBERTTO VALDERRAMA', 'rvalderramaro@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3008614431', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '3197997485', NULL),
(101, 'PROVEEL', '9004931434', '3001145', 'CARRERA 15 #77-5 CENTRO DE ALTA TECNOLOGÍA LOCAL 244', 3, 149, 'PAGINA WEB', 'proveelenlinea@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3001144', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '69800033705', NULL),
(102, 'ERGONOMUS SOLUCIONES ERGONOMICAS', '900642173', '7569100', 'Cl. 75 #69-47', 3, 149, 'PAGINA WEB', 'PAGINA WEB', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '7569100', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '13300010311', NULL),
(103, 'Central de Dotaciones', '800242586', '4463245', 'Carrera 69 a # 31-62 sur', 3, 149, NULL, 'www.centraldedotaciones.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3003866196', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, '73371742', NULL),
(104, 'VICTOR SAMUEL VELA OSORIO', '80175048', '3507255120', 'CR 58 N. 97A 04 LC-01', 3, 149, NULL, 'PUNTOECO58@GMAIL.COM', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3507255120', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 1, '24066981129 ', NULL),
(105, 'EQUIPOS Y LABORATORIOS DE COLOMBIA S.A.S', '900355024', '4480388', 'CARRERA 57 # 74 - 04 BOD 117', 1, 59, NULL, 'info@equiposylaboratorios.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '4480388', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '35393458967', NULL),
(106, 'PALLETS PLAST SAS', '901070090', '3133286480', 'DIAG 2 # 79C-04', 3, 149, 'Ronlad Garcia', 'gerencia.cabal2016@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3133286480', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '215-000005-30', NULL),
(107, 'MAJUA UNIFORMES', '800105194', '6017036314', 'CR 70 D 127 A 67', 3, 149, 'CLAUDIA', 'majuauniformes@gmail.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '6017036314', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 2, '8410519400', NULL),
(108, 'MOL LABS', '800158191', '3175107739', 'Cra 55B # 79B-34', 3, 149, 'THANIA GONZALEZ', 'cliente@mol-labs.com', NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3175107739', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, '4605960451', NULL),
(109, 'LAURA VALENTINA SANCHEZ MUÑOZ', '1001096860', '3245503919', 'NATAEL DISTRIBUCIONES DEL NORTE', 3, 149, 'LAURA VALENTINA SANCHEZ MUÑOZ', NULL, NULL, NULL, 0, '0', '2024-03-11', NULL, 1, '3245503919', NULL, 0, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 1, '055048841860367', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablagastos`
--

CREATE TABLE `tablagastos` (
  `IdTG` int(11) NOT NULL,
  `IdRegion` int(11) DEFAULT '0',
  `IdDepertamento` int(11) DEFAULT '0',
  `IdMunicipio` int(11) DEFAULT '0',
  `alojamiento` int(11) DEFAULT '0',
  `alimentacion` int(11) DEFAULT '0',
  `hidratacion` int(11) DEFAULT '0',
  `taeropuerto` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tablagastos`
--

INSERT INTO `tablagastos` (`IdTG`, `IdRegion`, `IdDepertamento`, `IdMunicipio`, `alojamiento`, `alimentacion`, `hidratacion`, `taeropuerto`) VALUES
(1, 1, 2, 0, 88000, 45000, 7000, 50000),
(2, 1, 4, 0, 85000, 45000, 7000, 50000),
(3, 1, 9, 0, 75000, 45000, 7000, 50000),
(4, 1, 10, 0, 80000, 45000, 7000, 50000),
(5, 1, 14, 0, 88000, 45000, 7000, 50000),
(6, 1, 15, 0, 85000, 45000, 7000, 50000),
(7, 1, 22, 0, 75000, 45000, 7000, 50000),
(8, 2, 1, 0, 90000, 45000, 7000, 54000),
(9, 2, 5, 0, 80000, 45000, 7000, 45000),
(10, 2, 6, 0, 85000, 45000, 7000, 45000),
(11, 2, 11, 0, 80000, 45000, 7000, 56000),
(12, 2, 13, 0, 75000, 45000, 7000, 45000),
(13, 2, 18, 0, 89000, 45000, 7000, 45000),
(14, 2, 19, 0, 85000, 45000, 7000, 45000),
(15, 2, 20, 0, 80000, 45000, 7000, 45000),
(16, 2, 21, 0, 75000, 45000, 7000, 45000),
(17, 2, 23, 0, 79000, 45000, 7000, 45000),
(18, 3, 8, 0, 88000, 45000, 7000, 50000),
(19, 3, 12, 0, 92000, 45000, 7000, 50000),
(20, 3, 17, 0, 75000, 45000, 7000, 50000),
(21, 3, 24, 0, 80000, 45000, 7000, 60000),
(22, 4, 16, 0, 90000, 45000, 7000, 44000),
(23, 4, 25, 0, 88000, 45000, 7000, 44000),
(24, 4, 26, 0, 88000, 45000, 7000, 44000),
(25, 4, 33, 0, 75000, 45000, 7000, 44000),
(26, 5, 7, 0, 70000, 45000, 7000, 45000),
(27, 5, 27, 0, 70000, 45000, 7000, 45000),
(28, 5, 29, 0, 90000, 45000, 7000, 45000),
(29, 5, 30, 0, 90000, 45000, 7000, 45000),
(30, 5, 31, 0, 85000, 45000, 7000, 45000),
(31, 5, 32, 0, 85000, 45000, 7000, 45000),
(32, 6, 28, 1085, 120000, 45000, 7000, 50000),
(33, 6, 28, 1086, 85000, 45000, 7000, 50000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IdUsuario` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `nivel` int(11) NOT NULL,
  `snivel` int(11) DEFAULT '0',
  `activado` tinyint(4) DEFAULT '0',
  `correo` varchar(45) DEFAULT NULL,
  `cargo` varchar(35) DEFAULT NULL,
  `cedula` varchar(11) DEFAULT NULL,
  `IdBanco` int(11) DEFAULT '0',
  `cuenta` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `usuario`, `clave`, `nombre`, `apellido`, `nivel`, `snivel`, `activado`, `correo`, `cargo`, `cedula`, `IdBanco`, `cuenta`) VALUES
(1, 'ricardo', '$2y$10$oUJ8t40jcMK8a7oNrbkdeeSbu5JxKYodzWbi9H2mNn53BfbrTVnui', 'RICARDO EMIRO', 'ARANGO MURCIA', 0, 0, 1, 'ricardoarangom@gmail.com', 'DESARROLLADOR', '79355327', 14, '01010101'),
(2, 'oscar', '$2y$10$oUJ8t40jcMK8a7oNrbkdeeSbu5JxKYodzWbi9H2mNn53BfbrTVnui', 'OSCAR', 'CAICEDO', 0, 0, 1, 'oacaicedog@gmail.com', 'DESARROLLADOR', NULL, 0, NULL),
(3, 'diana.corredor', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'DIANA MARCELA', 'CORREDOR ALARCON', 2, 0, 1, 'alexander.rodriguez@cpaingenieria.com', 'PROFESIONAL DE LICITACION', '1052394865', 0, '0'),
(4, 'pedro.rodriguez', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'PEDRO ALEXANDER', 'RODRIGUEZ GONZALEZ', 2, 0, 1, 'profesional.licitaciones@cpaingenieria.com', 'DIRECTOR COMERCIAL', '79487253', 0, '0'),
(5, 'lizeth.serrano', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'LIZETH YULIETH', 'SERRANO OLAYA', 2, 0, 1, 'lizethserrano20@gmail.com', 'SUPERVISORA SST', '1079179582', 0, '0'),
(6, 'jhonatan.sanabria', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'JHONATAN', 'SANABRIA PEREZ', 2, 0, 1, 'coordinador.hseq@cpaingenieria.com', 'COORDINADOR HSEQ', '80843310', 0, '0'),
(7, 'dilsa.pineda', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'DILSA YURANY', 'PINEDA LOPEZ', 2, 0, 1, 'yurany.pineda@paingenieria.com', 'DIRECTORA HSEQ', '52978877', 0, '0'),
(8, 'diana.roa', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'DIANA DEL PILAR', 'ROA ANGARITA', 2, 0, 1, 'diana.roa@cpaingenieria.com', 'PROFESIONAL DE PROYECTOS', '53121824', 0, '0'),
(9, 'hector.lopez', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'HECTOR JULIAN', 'LOPEZ VALDERRAMA', 2, 0, 1, 'julian.lopez@cpaingenieria.com', 'COORDINADOR DE PROYECTOS', '1020801630', 0, '0'),
(10, 'laura.rodriguez', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'LAURA TATIANA', 'RODRIGUEZ WILCHES', 2, 0, 1, 'laura.rodriguez@cpaingenieria.com', 'PROFESIONAL DE PROYECTOS', '1024567124', 0, '0'),
(11, 'lina.marin', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'LINA MARIA', 'MARIN MORA', 2, 0, 1, 'linamaria.marin@cpaingenieria.com', 'COORDINADORA', '52243584', 0, '0'),
(12, 'constanza.carrera', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'CONSTANZA', 'CARRERA SIERRA', 2, 0, 1, 'cosntanza.carrera@cpaingenieria.com', 'ARQUEOLOGO Y GESTION SOCIAL', '1014189286', 0, '0'),
(13, 'venus.gonzalez', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'VENUS', 'GONZALEZ', 2, 0, 1, 'venus.gonzalez@cpaingenieria.com', 'PROFESIONAL DE PROYECTOS', '59669241', 0, '0'),
(14, 'cristian.sanchez', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'CRISTIAN MAURICIO', 'SANCHEZ CALLE', 2, 0, 1, 'cristian.sanchez@cpaingenieria.com', 'ARQUEOLOGO LIDER', '1053775579', 0, '0'),
(15, 'ingrid.lopez', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'INGRID JOHANA', 'LOPEZ GARCIA', 2, 0, 1, 'ingrid.lopez@cpaingenieria.com', 'DIRECTORA DE GESTION HUMANA', '52900231', 0, '0'),
(16, 'jiley.melo', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'JILEY', 'MELO', 2, 0, 1, 'auxiliar.administrativo@cpaingenieria.com', 'AUXILIAR ADMINISTRATIVA', '1023908478', 0, '0'),
(17, 'hiss.moreno', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'HISS BRIGETTE', 'MORENO BURBANO', 2, 0, 1, 'recepcion@cpaingenieria.com', 'ASISTENTE ADMINISTRATIVA RECEPCION', '1022397412', 0, '0'),
(18, 'jenny.duenas', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'JENNY CAROLINA', 'DUEÑAS MUÑOZ', 2, 0, 1, 'jenny.duenas@cpaingenieria.com', 'JEFE TÉCNICO Y CALIDAD', '1012369641', 0, '0'),
(19, 'daniel.vargas', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'DANIEL CORDOBA', 'VARGAS', 2, 0, 1, 'analista.laboratorio@cpaingenieria.com', 'ANALISTA DE LABORATORIO', '1000855470', 0, '0'),
(20, 'luis.rubiano', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'LUIS HECTOR', 'RUBIANO VERGARA', 1, 0, 1, 'gerenciageneral@cpaingenieria.com', 'GERENTE GENERAL', '79315619', 0, '0'),
(21, 'martha.botero', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'MARTHA GABRIELA', 'BOTERO SERNA', 1, 0, 1, 'marthagabriela.botero@cpaingenieria.com', 'SUB GERENTE', '24434581', 0, '0'),
(22, 'juana.orjuela', '$2y$10$ca59RAM3K5.MqAkn4Dfk3uoM5EyXOfJ2wnluH0qyoHMjtg0/V6Qiu', 'JUANA MARIA', 'ORJUELA VENEGAS', 3, 0, 1, 'contabilidad@cpaingenieria.com', 'COORDINADOR DE COMPRAS', '1075874817', 0, '0');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`IdArea`);

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`IdBanco`);

--
-- Indices de la tabla `clasecuenta`
--
ALTER TABLE `clasecuenta`
  ADD PRIMARY KEY (`IdClasecuenta`);

--
-- Indices de la tabla `clasesisc`
--
ALTER TABLE `clasesisc`
  ADD PRIMARY KEY (`IdClase`);

--
-- Indices de la tabla `clasproveedores`
--
ALTER TABLE `clasproveedores`
  ADD PRIMARY KEY (`IdClasificacion`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`IdCompra`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`IdCotizacion`);

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`IdEmpresa`);

--
-- Indices de la tabla `fpago`
--
ALTER TABLE `fpago`
  ADD PRIMARY KEY (`IdFpago`);

--
-- Indices de la tabla `gviaje`
--
ALTER TABLE `gviaje`
  ADD PRIMARY KEY (`IdGviaje`);

--
-- Indices de la tabla `itemcompra`
--
ALTER TABLE `itemcompra`
  ADD PRIMARY KEY (`IdItemcompra`);

--
-- Indices de la tabla `itemgviaje`
--
ALTER TABLE `itemgviaje`
  ADD PRIMARY KEY (`IdItem`);

--
-- Indices de la tabla `itemoc`
--
ALTER TABLE `itemoc`
  ADD PRIMARY KEY (`IdItem`);

--
-- Indices de la tabla `mediosp`
--
ALTER TABLE `mediosp`
  ADD PRIMARY KEY (`IdMpago`);

--
-- Indices de la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  ADD PRIMARY KEY (`IdOrdencompra`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`IdProveedor`);

--
-- Indices de la tabla `tablagastos`
--
ALTER TABLE `tablagastos`
  ADD PRIMARY KEY (`IdTG`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `IdArea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT de la tabla `clasesisc`
--
ALTER TABLE `clasesisc`
  MODIFY `IdClase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `clasproveedores`
--
ALTER TABLE `clasproveedores`
  MODIFY `IdClasificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `IdCompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `IdCotizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `IdEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `fpago`
--
ALTER TABLE `fpago`
  MODIFY `IdFpago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `gviaje`
--
ALTER TABLE `gviaje`
  MODIFY `IdGviaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `itemcompra`
--
ALTER TABLE `itemcompra`
  MODIFY `IdItemcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `itemgviaje`
--
ALTER TABLE `itemgviaje`
  MODIFY `IdItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `itemoc`
--
ALTER TABLE `itemoc`
  MODIFY `IdItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `mediosp`
--
ALTER TABLE `mediosp`
  MODIFY `IdMpago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `ordencompra`
--
ALTER TABLE `ordencompra`
  MODIFY `IdOrdencompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `IdProveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT de la tabla `tablagastos`
--
ALTER TABLE `tablagastos`
  MODIFY `IdTG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
