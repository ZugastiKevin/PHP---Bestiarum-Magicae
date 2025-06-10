-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql
-- Généré le : mar. 10 juin 2025 à 17:24
-- Version du serveur : 8.0.42
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `codex`
--

-- --------------------------------------------------------

--
-- Structure de la table `bestiary`
--

CREATE TABLE `bestiary` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bestiary_type_id` int NOT NULL,
  `name_creature` varchar(255) NOT NULL,
  `describ_creature` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `img_creature` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bestiary`
--

INSERT INTO `bestiary` (`id`, `user_id`, `bestiary_type_id`, `name_creature`, `describ_creature`, `img_creature`) VALUES
(1, 32, 1, 'elementaire d&#039;eau', 'elementaire d&#039;eau', '6847ed4b46931.jpg'),
(2, 32, 1, 'kappa', 'kappa', '6847ed91259b9.jpg'),
(3, 32, 1, 'kirin', 'kirin', '6847edcc5a082.jpg'),
(4, 32, 2, 'cerbere', 'cerbere', '6847ede788ab0.jpg'),
(5, 32, 2, 'seigneur des abimes', 'seigneur des abimes', '6847edfa327c9.jpg'),
(6, 32, 2, 'succube', 'succube', '6847ee0c82ac3.jpg'),
(7, 32, 2, 'tourmenteur', 'tourmenteur', '6847ee1f286af.jpg'),
(12, 32, 3, 'fantome', 'fantome', '6847eff78cabf.jpg'),
(13, 32, 3, 'lamasu', 'lamasu', '6847f00627dfc.jpg'),
(14, 32, 3, 'liche', 'liche', '6847f05451445.jpg'),
(15, 32, 3, 'squelette', 'squelette', '6847f0768e7f8.jpg'),
(17, 32, 4, 'centaure', 'centaure', '6847f10d070f6.jpg'),
(18, 32, 4, 'cyclope', 'cyclope', '6847f12276115.jpg'),
(19, 32, 4, 'harpie', 'harpie', '6847f1334fe72.jpg'),
(20, 32, 4, 'minotaure', 'minotaure', '6847f14a17e54.png');

-- --------------------------------------------------------

--
-- Structure de la table `bestiary_type`
--

CREATE TABLE `bestiary_type` (
  `id` int NOT NULL,
  `type_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bestiary_type`
--

INSERT INTO `bestiary_type` (`id`, `type_name`) VALUES
(1, 'aquatique'),
(2, 'demoniaque'),
(3, 'mort-vivant'),
(4, 'mi-bete');

-- --------------------------------------------------------

--
-- Structure de la table `elements_type`
--

CREATE TABLE `elements_type` (
  `id` int NOT NULL,
  `name_element` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `elements_type`
--

INSERT INTO `elements_type` (`id`, `name_element`) VALUES
(1, 'lumiere'),
(2, 'eau'),
(3, 'air'),
(4, 'feu');

-- --------------------------------------------------------

--
-- Structure de la table `spells`
--

CREATE TABLE `spells` (
  `id` int NOT NULL,
  `element_type_id` int NOT NULL,
  `spell_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `img_spell` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `spells`
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
-- Structure de la table `users`
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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `user_name`, `pass`, `user_role`, `token`, `tokenValidate`) VALUES
(32, 'Catherine', '$argon2i$v=19$m=65536,t=4,p=1$QkJtUTg5VWhaZkxZZUE0cQ$Hgl82tLmbyVtrdVT9/8UIPNUF4Fir0J/SNgNPnrUg0c', 100, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `usersElements`
--

CREATE TABLE `usersElements` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `element_type_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `usersElements`
--

INSERT INTO `usersElements` (`id`, `user_id`, `element_type_id`) VALUES
(51, 32, 1),
(52, 32, 2),
(53, 32, 3),
(54, 32, 4);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bestiary`
--
ALTER TABLE `bestiary`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bestiary_type`
--
ALTER TABLE `bestiary_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `elements_type`
--
ALTER TABLE `elements_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `spells`
--
ALTER TABLE `spells`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Index pour la table `usersElements`
--
ALTER TABLE `usersElements`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bestiary`
--
ALTER TABLE `bestiary`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `bestiary_type`
--
ALTER TABLE `bestiary_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `elements_type`
--
ALTER TABLE `elements_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `spells`
--
ALTER TABLE `spells`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `usersElements`
--
ALTER TABLE `usersElements`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
