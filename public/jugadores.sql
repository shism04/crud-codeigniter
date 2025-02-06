-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-02-2025 a las 22:29:47
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
-- Base de datos: `nba`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `equipo` varchar(100) NOT NULL,
  `posicion` varchar(50) NOT NULL,
  `altura` decimal(3,2) NOT NULL,
  `peso` decimal(5,2) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` mediumblob DEFAULT NULL,
  `trofeos_ganados` text DEFAULT NULL,
  `partidos_jugados` int(11) DEFAULT NULL,
  `salario` decimal(12,2) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `champion` int(11) DEFAULT NULL,
  `mvp` int(11) DEFAULT NULL,
  `all_nba` int(11) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id`, `nombre`, `equipo`, `posicion`, `altura`, `peso`, `fecha_nacimiento`, `created_at`, `foto`, `trofeos_ganados`, `partidos_jugados`, `salario`, `descripcion`, `champion`, `mvp`, `all_nba`, `edad`) VALUES
(1, 'LeBron James', 'Los Angeles Lakers', 'Alero', 2.06, 113.40, '1984-12-30', '2025-02-05 12:12:38', NULL, 'MVP 2009, MVP 2010, Campeón NBA 2012, 2013, 2020', 1300, 39.00, 'LeBron James es considerado uno de los mejores jugadores de la historia, conocido por su versatilidad, habilidades de liderazgo y capacidad para dominar en ambos extremos de la cancha.', 4, 4, 13, 40),
(2, 'Stephen Curry', 'Golden State Warriors', 'Base', 1.88, 84.00, '1988-03-14', '2025-02-05 12:12:38', NULL, 'MVP 2015, 2016, Campeón NBA 2015, 2017, 2018', 900, 45.50, 'Posiblemente el mejor tirador de la historia de la NBA, Curry ha transformado el juego con su habilidad, alcance y liderazgo.', 3, 2, 6, 36),
(3, 'Kevin Durant', 'Phoenix Suns', 'Alero', 2.08, 108.00, '1988-09-29', '2025-02-05 12:12:38', NULL, 'MVP 2014, Campeón NBA 2017, 2018', 950, 42.50, 'Un anotador letal y una amenaza ofensiva versátil, Durant sigue siendo uno de los jugadores más dominantes de la liga.', 2, 1, 6, 36),
(4, 'Giannis Antetokounmpo', 'Milwaukee Bucks', 'Ala-Pívot', 2.11, 110.00, '1994-12-06', '2025-02-05 12:12:38', NULL, 'MVP 2019, 2020, Campeón NBA 2021', 680, 40.50, 'Un fenómeno natural con una increíble combinación de tamaño, habilidad y atletismo, Giannis es una de las fuerzas más imparables en el juego.', 1, 2, 5, 30),
(5, 'Luka Dončić', 'Dallas Mavericks', 'Escolta', 2.01, 104.00, '1999-02-28', '2025-02-05 12:12:38', NULL, 'Ninguno', 300, 10.00, 'Dončić es un prodigio con un IQ de baloncesto y habilidades de juego elite, dominando a una edad temprana.', 0, 1, 3, 25),
(6, 'Nikola Jokić', 'Denver Nuggets', 'Pívot', 2.11, 129.00, '1995-02-19', '2025-02-05 12:12:38', NULL, 'MVP 2021, 2022', 550, 30.00, 'Un MVP de dos veces y un centro elite, Jokic es conocido por su increíble capacidad de pase e inteligencia en el baloncesto.', 1, 2, 5, 29),
(7, 'Jayson Tatum', 'Boston Celtics', 'Alero', 2.03, 95.00, '1998-03-03', '2025-02-05 12:12:38', NULL, 'Finalista MVP 2023, Campeón NBA 2022', 450, 28.50, 'La capacidad de anotación, el suave tiro y la tenacidad defensiva de Tatum lo convierten en una de las estrellas más brillantes de la NBA.', 0, 0, 4, 26),
(8, 'Joel Embiid', 'Philadelphia 76ers', 'Pívot', 2.13, 127.00, '1994-03-16', '2025-02-05 12:12:38', NULL, 'MVP 2023', 650, 32.00, 'Embiid es un pívot dominante con destrezas ofensivas y defensivas, combinando habilidad y tamaño para dominar la pintura.', 0, 0, 4, 30),
(9, 'Ja Morant', 'Memphis Grizzlies', 'Base', 1.88, 79.00, '1999-08-10', '2025-02-05 12:12:38', NULL, 'Ninguno', 120, 8.00, 'Morant es un base explosivo conocido por su atletismo, capacidad de hacer jugadas y estilo de juego electrizante.', 0, 0, 2, 25),
(10, 'Jimmy Butler', 'Miami Heat', 'Alero', 2.01, 104.00, '1989-09-14', '2025-02-05 12:12:38', NULL, 'Finalista MVP 2021, Campeón NBA 2012', 750, 33.00, 'Un competidor feroz y un jugador clave en momentos decisivos, Butler destaca por su liderazgo y habilidades defensivas.', 0, 0, 5, 35),
(11, 'Shai Gilgeous-Alexander', 'OKC Thunder', 'Base', 1.98, 88.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 60, NULL, NULL, 0, 0, 1, 25),
(12, 'Victor Wembanyama', 'San Antonio Spurs', 'Pivot', 2.24, 95.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 50, NULL, NULL, 0, 0, 0, 20),
(13, 'Anthony Davis', 'Los Angeles Lakers', 'Pivot', 2.08, 115.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 55, NULL, NULL, 1, 1, 4, 30),
(14, 'Jalen Brunson', 'New York Knicks', 'Base', 1.88, 86.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 58, NULL, NULL, 0, 0, 1, 27),
(15, 'Anthony Edwards', 'Minnesota Timberwolves', 'Escolta', 1.96, 102.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 60, NULL, NULL, 0, 0, 0, 22),
(16, 'Donovan Mitchell', 'Cleveland Cavaliers', 'Escolta', 1.85, 98.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 55, NULL, NULL, 0, 0, 1, 27),
(17, 'Karl-Anthony Towns', 'Minnesota Timberwolves', 'Pivot', 2.11, 112.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 50, NULL, NULL, 0, 0, 2, 28),
(18, 'Jaylen Brown', 'Boston Celtics', 'Alero', 1.98, 101.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 57, NULL, NULL, 0, 0, 1, 27),
(19, 'Paolo Banchero', 'Orlando Magic', 'Alero', 2.08, 113.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 59, NULL, NULL, 0, 0, 0, 21),
(20, 'Devin Booker', 'Phoenix Suns', 'Escolta', 1.96, 95.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 52, NULL, NULL, 0, 0, 2, 27),
(21, 'Kyrie Irving', 'Dallas Mavericks', 'Base', 1.88, 88.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 54, NULL, NULL, 1, 0, 3, 31),
(22, 'Lamelo Ball', 'Charlotte Hornets', 'Base', 2.01, 82.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 40, NULL, NULL, 0, 0, 0, 22),
(23, 'Tyrese Haliburton', 'Indiana Pacers', 'Base', 1.96, 86.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 55, NULL, NULL, 0, 0, 1, 24),
(24, 'Damian Lillard', 'Milwaukee Bucks', 'Base', 1.88, 88.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 56, NULL, NULL, 0, 0, 7, 33),
(25, 'Cade Cunningham', 'Detroit Pistons', 'Base', 2.02, 100.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 45, NULL, NULL, 0, 0, 0, 22),
(26, 'Trae Young', 'Atlanta Hawks', 'Base', 1.85, 74.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 60, NULL, NULL, 0, 0, 2, 25),
(27, 'Tyrese Maxey', 'Philadelphia 76ers', 'Escolta', 1.88, 86.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 58, NULL, NULL, 0, 0, 0, 24),
(28, 'Bam Adebayo', 'Miami Heat', 'Pivot', 2.06, 116.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 60, NULL, NULL, 0, 0, 1, 26),
(29, 'James Harden', 'Los Angeles Clippers', 'Escolta', 1.96, 100.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 55, NULL, NULL, 0, 1, 7, 34),
(30, 'Derrick White', 'Boston Celtics', 'Base', 1.93, 86.00, '0000-00-00', '2025-02-05 21:23:12', NULL, NULL, 60, NULL, NULL, 0, 0, 0, 29);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
