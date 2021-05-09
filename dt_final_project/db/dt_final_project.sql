-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-05-2021 a las 23:17:46
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dt_final_project`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `list`
--

CREATE TABLE `list` (
  `codProduct` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `amount` int(11) NOT NULL,
  `codUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `list`
--

INSERT INTO `list` (`codProduct`, `text`, `amount`, `codUser`) VALUES
(17002, 'tomato', 3, 1),
(17003, 'milk', 6, 1),
(17004, 'chicken', 1, 1),
(17005, 'bananas', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notes`
--

CREATE TABLE `notes` (
  `codNote` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `codUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `notes`
--

INSERT INTO `notes` (`codNote`, `text`, `codUser`) VALUES
(80, ' have to do page 86 of the book for next friday', 1),
(83, 'Films to watch:\r\n- Parasite\r\n- Gravity', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `codTask` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `codUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `code` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `passwd` varchar(500) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`code`, `name`, `passwd`, `mail`, `points`) VALUES
(1, 'juan', '$2y$10$9STReNpS32F3g74gHgzMKuZjvWoTRfD8gRyKY/wlo3SEwLKq5aJGK', 'invented@gmail.com', 350),
(3, 'maria', '$2y$10$O5eLnUplv5oa.4o6BBOTB.opeR2oEourcoRfOOt7/V.oLIxQ7U1b2', 'invented@gmail.com', 25);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`codProduct`),
  ADD KEY `codUser` (`codUser`);

--
-- Indices de la tabla `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`codNote`),
  ADD KEY `codUser` (`codUser`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`codTask`),
  ADD KEY `codUser` (`codUser`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`code`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `list`
--
ALTER TABLE `list`
  MODIFY `codProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17006;

--
-- AUTO_INCREMENT de la tabla `notes`
--
ALTER TABLE `notes`
  MODIFY `codNote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `codTask` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `list_ibfk_1` FOREIGN KEY (`codUser`) REFERENCES `users` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`codUser`) REFERENCES `users` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `codUser` FOREIGN KEY (`codUser`) REFERENCES `users` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
