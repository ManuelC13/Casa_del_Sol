-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2024 a las 22:13:49
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
-- Base de datos: `db_casa_del_sol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `Id` varchar(10) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`Id`, `Nombre`) VALUES
('1', 'Joyería'),
('2', 'Hogar'),
('3', 'Textiles'),
('4', 'Madera'),
('5', 'Cerámica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `usuario_id`, `total`, `fecha`) VALUES
(7, 0, 850.00, '2024-11-28 23:47:39'),
(8, 0, 700.00, '2024-11-28 23:53:02'),
(9, 0, 950.00, '2024-11-29 00:00:07'),
(10, 12, 1400.00, '2024-11-29 00:05:01'),
(11, 12, 1400.00, '2024-11-29 00:07:13'),
(12, 12, 150.00, '2024-11-29 00:08:20'),
(13, 12, 150.00, '2024-11-29 00:09:23'),
(14, 1672, 150.00, '2024-11-29 05:52:14'),
(15, 1672, 400.00, '2024-11-29 05:59:11'),
(16, 1672, 700.00, '2024-11-29 06:01:08'),
(17, 1672, 250.00, '2024-11-29 06:01:33'),
(18, 1672, 700.00, '2024-11-29 06:39:56'),
(19, 1672, 1000.00, '2024-11-29 23:22:13'),
(20, 1672, 1000.00, '2024-11-29 23:43:56'),
(21, 1674, 350.00, '2024-11-30 00:49:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `compra_id`, `sku`, `cantidad`, `precio`) VALUES
(7, 7, '123456789', 1, 700.00),
(8, 7, 'mfvehfljr', 1, 150.00),
(9, 8, '123456789', 1, 700.00),
(10, 9, '123456789', 1, 700.00),
(11, 9, 'ntksgrkfn', 1, 250.00),
(12, 10, '123456789', 2, 700.00),
(13, 11, '123456789', 2, 700.00),
(14, 12, 'mfvehfljr', 1, 150.00),
(15, 13, 'mfvehfljr', 1, 150.00),
(16, 14, 'hfkekdn69', 1, 150.00),
(17, 15, 'ntksgrkfn', 1, 250.00),
(18, 15, 'mfvehfljr', 1, 150.00),
(19, 16, '123456789', 1, 700.00),
(20, 17, 'ntksgrkfn', 1, 250.00),
(21, 18, '123456789', 1, 700.00),
(22, 19, 'hfkekdn69', 5, 150.00),
(23, 19, 'ntksgrkfn', 1, 250.00),
(24, 20, 'hfkekdn69', 5, 150.00),
(25, 20, 'ntksgrkfn', 1, 250.00),
(26, 21, 'djr493k49', 1, 350.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `Id` int(8) NOT NULL,
  `Calle` varchar(50) NOT NULL,
  `CodigoPostal` int(5) NOT NULL,
  `NumeroCasa` varchar(10) NOT NULL,
  `Cruzamiento` varchar(100) NOT NULL,
  `Ciudad` varchar(50) NOT NULL,
  `UsuarioId` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`Id`, `Calle`, `CodigoPostal`, `NumeroCasa`, `Cruzamiento`, `Ciudad`, `UsuarioId`) VALUES
(4, '12 a', 97610, 'SN', '35 y 37', 'Panabá', '167300ca'),
(8, '39', 97700, '346', '35 y 68', 'Mérdia', '1674a607');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Sku` varchar(10) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Descripcion` varchar(200) DEFAULT NULL,
  `Stock` int(11) DEFAULT NULL,
  `Precio` double DEFAULT NULL,
  `IdCategoria` varchar(10) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `FechaRegistro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Sku`, `Nombre`, `Descripcion`, `Stock`, `Precio`, `IdCategoria`, `Imagen`, `FechaRegistro`) VALUES
('123456789', 'Hamaca', 'Azul', 8, 700, '3', 'hamaca.jpg', '2024-11-26 17:01:07'),
('ASGTE6789', 'Florero Tejido', 'sjshshshshksksksckskkskcskk', 5, 800, '2', 'floreroTejido.jpg', '2024-11-30 17:02:03'),
('dgeckehsh', 'Tocado', 'Tocado', 5, 200, '3', 'tocado.jpg', '2024-11-26 17:03:08'),
('djr493k49', 'ChacMol', 'gris', 3, 350, '2', 'chacMol.jpg', '2024-11-29 16:33:23'),
('fvgegehfk', 'Silla', 'Silla', 5, 1000, '4', 'silla.jpg', '2024-11-26 17:07:20'),
('GNRKD5678', 'Blusa Bordada', 'Bordado a mano en punto de cruz', 4, 1500, '3', 'blusaBordada.jpg', '2024-11-29 23:33:24'),
('hfjevffek', 'Escultura', 'Esculrura', 10, 100, '5', 'escultura.jpg', '2024-11-26 17:05:58'),
('hfkekdn69', 'Alebrije', 'Colorido y elegante', -1, 150, '4', 'alebrije.jpg', '2024-11-29 05:43:10'),
('hgvskvghe', 'Cinturon', 'Cinturon', 4, 300, '3', 'cinturon.jpg', '2024-11-26 17:05:18'),
('JFNDH3456', 'Cuadro \"La Tortilla\"', 'la que sea', 3, 250, '2', 'pinturaTortilla.jpg', '2024-11-30 16:57:48'),
('kjlfgetui', 'Florero', 'Florero', 10, 280, '5', 'florero.jpg', '2024-11-26 17:06:48'),
('mfvehfljr', 'Jarrones', 'Jarrones', 25, 150, '4', 'jarrones.jpg', '2024-11-26 17:04:05'),
('ntksgrkfn', 'Aretes', 'Aretes', 55, 250, '1', 'aretes.jpg', '2024-11-26 17:04:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id` varchar(8) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Genero` char(1) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Edad` varchar(50) NOT NULL,
  `Contrasenia` varchar(20) NOT NULL,
  `Intereses` varchar(100) NOT NULL,
  `Rol` tinyint(1) NOT NULL,
  `FechaRegistro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id`, `Nombre`, `Apellido`, `Genero`, `Email`, `Telefono`, `Edad`, `Contrasenia`, `Intereses`, `Rol`, `FechaRegistro`) VALUES
('12d34fty', 'Pepe', 'Aguilar', 'M', 'pepe@gmail.com', '9863456567', '18-25', 'Pepe', 'Hogar', 0, '2024-11-25 03:39:33'),
('1672fe2f', 'Josue', 'Cab', 'M', 'josue@gmail.com', '9867867890', '45', 'Josue', 'Cerámica', 0, '2024-11-09 22:32:18'),
('167300ca', 'Manuel Enrique', 'Cupul May', 'M', 'manuelcupulmay@gmail.com', '9861004051', '18-24', '123', 'Decoración,Textiles,Madera', 1, '2024-11-10 01:30:21'),
('1674a607', 'Prueba', 'May', 'M', 'prueba@gmail.com', '9867432344', '35-44', '456', 'Decoración,Textiles,Cerámica', 0, '2024-11-30 00:46:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `sku` (`sku`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UsuarioId` (`UsuarioId`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Sku`),
  ADD KEY `CategoriaId` (`IdCategoria`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `Id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`),
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`sku`) REFERENCES `producto` (`Sku`);

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `UsuarioId` FOREIGN KEY (`UsuarioId`) REFERENCES `usuario` (`Id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`IdCategoria`) REFERENCES `categoria` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
