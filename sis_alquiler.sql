-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-11-2023 a las 15:00:38
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sis_alquiler`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceso`
--

CREATE TABLE `acceso` (
  `idperfil` int(11) NOT NULL,
  `idopcion` int(11) NOT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acceso`
--

INSERT INTO `acceso` (`idperfil`, `idopcion`, `estado`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(2, 5, 1),
(2, 6, 1),
(2, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquiler`
--

CREATE TABLE `alquiler` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `h_inicio` time NOT NULL,
  `tiempo` tinyint(1) NOT NULL,
  `ingreso` tinyint(3) NOT NULL,
  `observacion` varchar(350) NOT NULL,
  `id_encargado` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_motocicleta` int(11) NOT NULL,
  `estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `alquiler`
--

INSERT INTO `alquiler` (`id`, `fecha`, `h_inicio`, `tiempo`, `ingreso`, `observacion`, `id_encargado`, `id_cliente`, `id_motocicleta`, `estado`) VALUES
(1, '2023-10-09', '09:00:00', 1, 20, 'S/O', 2, 1, 1, 1),
(2, '2023-10-09', '11:30:00', 2, 40, 'S/O', 2, 2, 2, 1),
(3, '2023-10-09', '14:00:00', 1, 20, 'S/O', 2, 3, 3, 1),
(4, '2023-10-10', '10:45:00', 1, 20, 'S/O', 3, 4, 4, 1),
(5, '2023-10-10', '13:45:00', 3, 60, 'S/O', 3, 5, 5, 1),
(6, '2023-10-10', '16:00:00', 1, 20, 'S/O', 3, 6, 6, 1),
(7, '2023-10-10', '18:30:00', 2, 20, 'S/O', 3, 7, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barrio`
--

CREATE TABLE `barrio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `barrio`
--

INSERT INTO `barrio` (`id`, `nombre`, `estado`) VALUES
(1, 'Los Tajibos', 1),
(2, 'Junin', 1),
(3, 'Copacabana', 1),
(4, '11 de Octubre', 1),
(5, 'Nazaria', 1),
(6, 'Paraiso', 1),
(7, 'Santa Clara', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apepat` varchar(20) NOT NULL,
  `apemat` varchar(20) NOT NULL,
  `nro_ci` int(11) NOT NULL,
  `id_procedencia_ci` int(11) NOT NULL,
  `id_barrio` int(11) NOT NULL,
  `d_calle` varchar(30) NOT NULL,
  `d_nrocasa` varchar(5) NOT NULL,
  `telefono` int(8) NOT NULL,
  `estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `apepat`, `apemat`, `nro_ci`, `id_procedencia_ci`, `id_barrio`, `d_calle`, `d_nrocasa`, `telefono`, `estado`) VALUES
(1, 'María', 'García', 'López', 4678001, 2, 3, 'Costa Rivero', '89', 69105678, 1),
(2, 'Juan', 'Rodríguez', 'Pérez', 7654321, 2, 4, 'Lucio Montero', '105', 77765432, 1),
(3, 'Ana', 'Martínez', 'González', 2345678, 2, 1, 'Roberto Galindo', 'S/N', 74789012, 1),
(4, 'Pedro', 'Fernández', 'Fernández', 8765432, 4, 2, 'Nicolas Suarez', 'S/N', 63654321, 1),
(5, 'Laura', 'López', 'Sánchez', 3456789, 1, 5, 'Luisa Jordan', '508', 77234567, 1),
(6, 'Carlos', 'Pérez', 'Rodríguez', 9876543, 2, 3, 'Victoria Rojas', 'S/N', 72321098, 1),
(7, 'Isabel', 'Torres', 'López', 4567890, 1, 7, 'Tomas Collins', 'S/N', 77107890, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargado`
--

CREATE TABLE `encargado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apepat` varchar(20) NOT NULL,
  `apemat` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `encargado`
--

INSERT INTO `encargado` (`id`, `nombre`, `apepat`, `apemat`) VALUES
(1, 'Leonardo', 'Vargas', 'Herrera'),
(2, 'Mario', 'Vargas', 'Flores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca_mo`
--

CREATE TABLE `marca_mo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `marca_mo`
--

INSERT INTO `marca_mo` (`id`, `nombre`, `estado`) VALUES
(1, 'SUMO', 1),
(2, 'KINGO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motocicleta`
--

CREATE TABLE `motocicleta` (
  `id` int(11) NOT NULL,
  `n_placa` varchar(8) NOT NULL,
  `id_marca_mo` int(11) NOT NULL,
  `estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `motocicleta`
--

INSERT INTO `motocicleta` (`id`, `n_placa`, `id_marca_mo`, `estado`) VALUES
(1, 'NN-2345', 2, 1),
(2, 'NN-7689', 2, 1),
(3, 'NN-6795', 2, 1),
(4, 'NN-3578', 2, 1),
(5, 'NN-7890', 1, 1),
(6, 'NN-6586', 2, 1),
(7, 'NN-8904', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE `opcion` (
  `idopcion` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `icono` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`idopcion`, `descripcion`, `icono`, `url`, `estado`) VALUES
(1, 'Perfiles', 'fa-user-circle', 'vista/perfiles.php', 1),
(2, 'Usuarios', 'fa-user-lock', 'vista/usuarios.php', 1),
(3, 'Marcas', 'fa-tags', 'vista/categorias.php', 1),
(4, 'Motocicletas', 'fa-motorcycle', 'vista/productos.php', 1),
(5, 'Clientes', 'fa-id-card', 'vista/clientes.php', 1),
(6, 'Alquiler', 'fa-biking', 'vista/alquileres.php', 1),
(7, 'Reportes', 'fa-chart-bar', 'vista/reportes.php ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idperfil` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` smallint(6) DEFAULT NULL COMMENT '0 -> INACTIVO \n1 -> ACTIVO\n2 -> ELIMINADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idperfil`, `nombre`, `estado`) VALUES
(1, 'ADMINISTRADOR', 1),
(2, 'ENCARGADO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedencia_ci`
--

CREATE TABLE `procedencia_ci` (
  `id` int(11) NOT NULL,
  `nombre` varchar(2) NOT NULL,
  `estado` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `procedencia_ci`
--

INSERT INTO `procedencia_ci` (`id`, `nombre`, `estado`) VALUES
(1, 'LP', 1),
(2, 'PD', 1),
(3, 'CO', 1),
(4, 'BE', 1),
(5, 'OR', 1),
(6, 'CH', 1),
(7, 'PO', 1),
(8, 'SC', 1),
(9, 'TJ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `clave` text DEFAULT NULL,
  `idperfil` int(11) NOT NULL,
  `urlimagen` varchar(200) NOT NULL DEFAULT 'imagen/usuario/default.jpg',
  `estado` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `usuario`, `clave`, `idperfil`, `urlimagen`, `estado`) VALUES
(1, 'SAMUEL MAMANI', 'samuel', '96dd15ef622d7c10a9d3ad98c8619ba4733e0812', 1, 'imagen/usuario/default.jpg', 1),
(2, 'LEONARDO VARGAS HERRERA', 'Leonardo', '7610bae85f2b530654cc716772f1fe653373e892', 2, 'imagen/usuario/default.jpg', 1),
(3, 'MARIO VARGAS FLORES', 'Mario', 'addb47291ee169f330801ce73520b96f2eaf20ea', 2, 'imagen/usuario/default.jpg', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceso`
--
ALTER TABLE `acceso`
  ADD PRIMARY KEY (`idperfil`,`idopcion`);

--
-- Indices de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_encargado` (`id_encargado`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_motocicleta` (`id_motocicleta`);

--
-- Indices de la tabla `barrio`
--
ALTER TABLE `barrio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_procedencia_ci` (`id_procedencia_ci`),
  ADD KEY `id_barrio` (`id_barrio`);

--
-- Indices de la tabla `encargado`
--
ALTER TABLE `encargado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marca_mo`
--
ALTER TABLE `marca_mo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `motocicleta`
--
ALTER TABLE `motocicleta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_marca_moto` (`id_marca_mo`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`idopcion`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idperfil`);

--
-- Indices de la tabla `procedencia_ci`
--
ALTER TABLE `procedencia_ci`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `barrio`
--
ALTER TABLE `barrio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `encargado`
--
ALTER TABLE `encargado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `marca_mo`
--
ALTER TABLE `marca_mo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `motocicleta`
--
ALTER TABLE `motocicleta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `idopcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idperfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `procedencia_ci`
--
ALTER TABLE `procedencia_ci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD CONSTRAINT `alquiler_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `alquiler_ibfk_3` FOREIGN KEY (`id_motocicleta`) REFERENCES `motocicleta` (`id`),
  ADD CONSTRAINT `alquiler_ibfk_4` FOREIGN KEY (`id_encargado`) REFERENCES `usuario` (`idusuario`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`id_barrio`) REFERENCES `barrio` (`id`),
  ADD CONSTRAINT `cliente_ibfk_2` FOREIGN KEY (`id_procedencia_ci`) REFERENCES `procedencia_ci` (`id`);

--
-- Filtros para la tabla `motocicleta`
--
ALTER TABLE `motocicleta`
  ADD CONSTRAINT `motocicleta_ibfk_1` FOREIGN KEY (`id_marca_mo`) REFERENCES `marca_mo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
