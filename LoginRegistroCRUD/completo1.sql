-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-11-2020 a las 00:19:09
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `completo1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionrol`
--

CREATE TABLE `asignacionrol` (
  `DNI` varchar(20) NOT NULL,
  `IdRol` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignacionrol`
--

INSERT INTO `asignacionrol` (`DNI`, `IdRol`) VALUES
('9B', 1),
('101B', 1),
('1A', 1),
('30C', 1),
('9B', 2),
('A', 1),
('A', 2),
('B', 1),
('C', 1),
('C', 2),
('G', 1),
('G', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `IdRol` int(5) NOT NULL,
  `Descripcion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`IdRol`, `Descripcion`) VALUES
(1, 'Usuario Estándar'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `DNI` varchar(20) NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Tfno` varchar(20) NOT NULL,
  `Pass` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`DNI`, `Nombre`, `Tfno`, `Pass`) VALUES
('101B', 'Harpo', '     5555557', 'Chubaca2020'),
('1A', 'Menganito', '423423', 'Chubaca2020'),
('30C', 'ASIR2', ' 89996', 'Chubaca2020'),
('9B', 'Mariaaaa', '    333356665', 'Chubaca2020'),
('A', 'A', ' AA', 'A'),
('B', 'B', 'B', 'B'),
('C', 'C', 'C', 'C'),
('G', 'G', 'G', 'G');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignacionrol`
--
ALTER TABLE `asignacionrol`
  ADD KEY `fk_dni` (`DNI`),
  ADD KEY `fk_rol` (`IdRol`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`IdRol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`DNI`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignacionrol`
--
ALTER TABLE `asignacionrol`
  ADD CONSTRAINT `fk_dni` FOREIGN KEY (`DNI`) REFERENCES `usuarios` (`DNI`),
  ADD CONSTRAINT `fk_rol` FOREIGN KEY (`IdRol`) REFERENCES `roles` (`IdRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
