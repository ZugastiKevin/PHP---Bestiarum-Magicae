-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jun 10, 2025 at 05:11 AM
-- Server version: 8.0.42
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codex`
--

-- --------------------------------------------------------

--
-- Table structure for table `bestiary`
--

CREATE TABLE `bestiary` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bestiary_type_id` int NOT NULL,
  `name_creature` varchar(255) NOT NULL,
  `describ_creature` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `img_creature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bestiary_type`
--

CREATE TABLE `bestiary_type` (
  `id` int NOT NULL,
  `type_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bestiary_type`
--

INSERT INTO `bestiary_type` (`id`, `type_name`) VALUES
(1, 'aquatique'),
(2, 'demoniaque'),
(3, 'mort vivante'),
(4, 'mi-bete');

-- --------------------------------------------------------

--
-- Table structure for table `elements_type`
--

CREATE TABLE `elements_type` (
  `id` int NOT NULL,
  `name_element` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `elements_type`
--

INSERT INTO `elements_type` (`id`, `name_element`) VALUES
(1, 'lumiere'),
(2, 'eau'),
(3, 'air'),
(4, 'feu');

-- --------------------------------------------------------

--
-- Table structure for table `spells`
--

CREATE TABLE `spells` (
  `id` int NOT NULL,
  `element_type_id` int NOT NULL,
  `spell_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `img_spell` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `spells`
--

INSERT INTO `spells` (`id`, `element_type_id`, `spell_name`, `img_spell`) VALUES
(14, 1, 'Soin', '68470a6046047.webp'),
(15, 1, 'Retribution', '68470aced378c.webp'),
(16, 1, 'Purification', '68470adb6e544.webp'),
(17, 1, 'Elementaire De Lumiere', '68470b09595a0.webp'),
(18, 1, 'Armure Celeste', '68470b32219ff.webp'),
(19, 4, 'Bouclier De Feu', '68470b5eb7abe.webp'),
(20, 4, 'Boule de Feu', '68470b6d7d98f.webp'),
(21, 4, 'Elementaire De Feu', '68470b8828aad.webp'),
(22, 4, 'Immolation', '68470b9a64f7b.webp'),
(23, 4, 'Tempete De Feu', '68470bb05ac6e.webp'),
(24, 2, 'Armure De Glace', '68470bcdf06c7.webp'),
(25, 2, 'Blizzard', '68470be0015e4.webp'),
(26, 2, 'Cerlce De L&#039;hiver', '68470bf7df1d5.webp'),
(27, 2, 'Elementaire D&#039;eau', '68470c1075e88.webp'),
(28, 2, 'Mur De Glace', '68470c1f16455.webp'),
(29, 3, 'Eclair', '68470c3f3f2d0.webp'),
(30, 3, 'Elementaire D&#039;air', '68470c515b7bd.webp'),
(31, 3, 'Vent Violent', '68470c611ffac.webp');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` varchar(255) NOT NULL,
  `user_role` int NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tokenValidate` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `pass`, `user_role`, `token`, `tokenValidate`) VALUES
(32, 'Catherine', '$argon2i$v=19$m=65536,t=4,p=1$QkJtUTg5VWhaZkxZZUE0cQ$Hgl82tLmbyVtrdVT9/8UIPNUF4Fir0J/SNgNPnrUg0c', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usersElements`
--

CREATE TABLE `usersElements` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `element_type_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usersElements`
--

INSERT INTO `usersElements` (`id`, `user_id`, `element_type_id`) VALUES
(29, 20, 4),
(30, 21, 3),
(31, 22, 1),
(32, 24, 0),
(33, 24, 0),
(34, 25, 1),
(35, 25, 2),
(36, 25, 3),
(37, 26, 1),
(38, 26, 2),
(39, 26, 3),
(40, 27, 1),
(41, 27, 2),
(42, 27, 3),
(43, 28, 1),
(44, 28, 2),
(45, 28, 3),
(46, 29, 3),
(47, 30, 2),
(48, 30, 3),
(49, 31, 2),
(50, 31, 4),
(51, 32, 1),
(52, 32, 2),
(53, 32, 3),
(54, 32, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bestiary`
--
ALTER TABLE `bestiary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bestiary_type`
--
ALTER TABLE `bestiary_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elements_type`
--
ALTER TABLE `elements_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spells`
--
ALTER TABLE `spells`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `usersElements`
--
ALTER TABLE `usersElements`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bestiary`
--
ALTER TABLE `bestiary`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bestiary_type`
--
ALTER TABLE `bestiary_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `elements_type`
--
ALTER TABLE `elements_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `spells`
--
ALTER TABLE `spells`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `usersElements`
--
ALTER TABLE `usersElements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
