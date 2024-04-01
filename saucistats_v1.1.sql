-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 07 jan. 2023 à 13:51
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `saucistats`
--
CREATE DATABASE IF NOT EXISTS `saucistats` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `saucistats`;

-- --------------------------------------------------------

--
-- Structure de la table `anecdotes`
--

DROP TABLE IF EXISTS `anecdotes`;
CREATE TABLE IF NOT EXISTS `anecdotes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `anecdotes`
--

INSERT INTO `anecdotes` (`id`, `body`) VALUES
(1, 'La toute première Saucismash a été remportée par Foaya à l\'époque de nos grands frères.'),
(2, 'En voyant le nom de \"Francis\" certains ont lâché une larme de nostalgie.'),
(3, 'Qui de mieux placé que le lyonnais de cœur et de sang Lil Marty pour avoir remporté la symbolique \n            69ème Saucismash ?'),
(4, 'Le plus grand nombre de victoires consécutives à la Saucismash est de 3. Les seuls y étant parvenus\n             sont Pandaroux, ALtek, et Francis. Pandaroux ayant égalé le record 2 fois (Saucismash 6,7,8 & 15,16,17).'),
(5, 'La 4ème Saucismash détient le record du plus grand nombre de particpants avec 72 joueurs. Remportée par \n            le légendaire Yoyod face à Flynn (le TO) en grande finale'),
(6, 'Tenir une saucisse est devenu hype uniquement grâce à l\'alliance BAB/MSF.'),
(7, 'Seul 2 Saucismash n\'ont pas de vainqueurs, la 28ème annulée car il n\'y avait pas assez de joueurs et la \n            44ème car elle marque les débuts du Covid et le format bracket a été écarté pour favoriser une \"session\".'),
(8, 'Pendant la 1ère année du jeu Flynn était TO de 3 weeklies en même temps ce fou. #FlynnReviensStp'),
(9, 'L\'un des gagnants d\'une Saucismash a tenté de frappé un TO après avoir perdu. Heureusement ce dernier \n            ayant connu la banlieue, la misère et l\'immigration s\'en est sorti sans aucune blessure.'),
(10, 'La Saucismash et le seul tournoi du monde où tu peux être bousculé en plein match de bracket contre \n            \"porte-fenêtre\" ou encore \"ImSoFat\" car il y a une table de beer-pong à 20 cm de toi.'),
(11, 'Si tu n\'as pas déjà tenu une saucisse, tu ne peux pas t\'assoir à la table des OGs.'),
(12, 'Avant il y avait du CP à la saucisse, on appellait ça la Golden Sausage. Y\'a même une chaise Gaming qui a\n             été remportée par Mocra !'),
(13, 'Une édition de la Saucismash a pris tellement de retard que le top 8 s\'est joué en BO1'),
(14, 'Mocra a dû DQ d\'une Saucismash car il n\'y avait aucun adaptateur dans la venue et sur les setup.'),
(15, 'Oxydion a un jour sauvé le sac d\'un saucismasheur en repérant de vilains garnements qui tentaient de le \n            subtiliser. Depuis Oxydion tiens un barbecue avec une bonne flopée de saucisses.'),
(16, 'Le bar offre des verres d\'eau gratuitement ce qui est déjà mieux que le bar de S.Etienne ptdrrrr.'),
(17, 'La playlist du bar est validée par Gin.'),
(18, 'Des joueurs jettent leur manette en Round 1 du Saucismash et ceci m\'empêche de dormir.'),
(19, 'Le joueur ayant fait le plus de Saucismash est Hazmat avec 50 participations à son actif à date du \n            01/01/2022 (et j\'updaterais pas cette stat car j\'ai la flemme). Le 2ème est Shiko avec 45.'),
(20, 'Le tout premier tournoi Smash sur Ultimate organisé au Meltdown a été remporté par Nonocolors à la sortie\n             du jeu. Le tournoi ne s\'appelait même pas encore la Saucismash ce qui fait de Nonocolors le seul et \n             unique teneur de chipo.'),
(21, 'Un certain joueur dont nous respecterons l\'identité a DQ d\'une grande finale car son adversaire je cite \n            \"bourrait trop c\'est pas intéressant\". La source de cette anecdote a préféré rester anonyme (Lil Marty).'),
(22, 'JO2LY a battu Matth10 mdrrrrrrrrr'),
(23, 'La Saucismash #67 a marqué la dernière sauci de Lyord. Il finira 2ème battu par BenJ ce qui l\'empêchera \n            de partir sur une victoire et de quoi rajouter du tragique à son départ, quel tristesse Alexa joue la kiffance de Naps.'),
(24, 'Il y a pas vraiment de TO à la saucismash, enfin si, enfin non, enfait on ne sait pas trop...'),
(25, 'Aspifouette gagne la Saucismash 91 sur une DQ de Zequar en Grande Finale. 7 édition plus tard à la \n            Saucisse 98 Yoyo, le meilleur ami d\'Aspifouette, gagnera également sur une DQ de Nerraw.'),
(26, 'La Saucisse est un tournoi international : le colombien Reridse a remporté la 87ème Saucisse tandis que Her a \n            ramené la 86ème aux Etats-Unis. La 76ème a même été remportée par un mec de Limoges.'),
(27, 'Saucismash 110, Shiko vs Sfar. Coup d\'envoi 21h. Après une game 1 très longue et très serrée Shiko place un Back air en last hit,\n            pense gagner la game et pop-off si fort que tout le bar l\'entend. Malheureusement pour lui Sfar ne meurt pas, revient sur le stage,\n            et remporte la game... et tout le bar pop-off pour se moquer de Shiko');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211027162826', '2022-12-26 19:48:18', 1592),
('DoctrineMigrations\\Version20211027230734', '2022-12-26 19:48:20', 533),
('DoctrineMigrations\\Version20211111234613', '2022-12-26 19:48:20', 451),
('DoctrineMigrations\\Version20211119014545', '2022-12-26 19:51:04', 674),
('DoctrineMigrations\\Version20221211230825', '2022-12-26 19:51:05', 735),
('DoctrineMigrations\\Version20221212172448', '2022-12-26 19:51:06', 1952),
('DoctrineMigrations\\Version20221217154029', '2022-12-26 19:51:08', 1562),
('DoctrineMigrations\\Version20221217154728', '2022-12-26 19:51:09', 1363),
('DoctrineMigrations\\Version20221219003200', '2022-12-26 19:51:11', 3473),
('DoctrineMigrations\\Version20221222205505', '2022-12-26 19:51:14', 1879),
('DoctrineMigrations\\Version20230106235853', '2023-01-07 00:02:38', 1940);

-- --------------------------------------------------------

--
-- Structure de la table `pins`
--

DROP TABLE IF EXISTS `pins`;
CREATE TABLE IF NOT EXISTS `pins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)',
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `smasheur`
--

DROP TABLE IF EXISTS `smasheur`;
CREATE TABLE IF NOT EXISTS `smasheur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_player_api` int DEFAULT NULL,
  `personnages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `smasheur`
--

INSERT INTO `smasheur` (`id`, `pseudo`, `tag`, `id_player_api`, `personnages`) VALUES
(1, 'Flynn', 'IA', 936065, 'Ike'),
(2, 'Francis', 'S&B', 147144, 'Fox,Mega Man,Mario'),
(3, 'Pandaroux', 'UBI', 1079988, 'Ness,Inkling'),
(4, 'Vanaheim', '', 72152, 'R.O.B.'),
(5, 'Foaya', NULL, 278459, 'Fox'),
(6, 'Aeron', NULL, 171762, 'Snake'),
(7, 'Yoyod', NULL, 257364, 'Zero Suit Samus');

-- --------------------------------------------------------

--
-- Structure de la table `tournoi`
--

DROP TABLE IF EXISTS `tournoi`;
CREATE TABLE IF NOT EXISTS `tournoi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `num_saucisse` int NOT NULL,
  `smasheur_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_18AFD9DFC8FD8EAB` (`smasheur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tournoi`
--

INSERT INTO `tournoi` (`id`, `num_saucisse`, `smasheur_id`) VALUES
(1, 1, 5),
(2, 2, 3),
(3, 3, 2),
(4, 4, 7),
(5, 5, 7),
(6, 6, 3),
(7, 7, 3),
(8, 8, 3),
(9, 9, 6),
(10, 10, 2),
(11, 11, 1),
(12, 12, 2),
(13, 13, 2),
(14, 14, 2),
(15, 15, 3),
(16, 16, 3),
(17, 17, 3),
(18, 18, 1),
(19, 19, 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tournoi`
--
ALTER TABLE `tournoi`
  ADD CONSTRAINT `FK_18AFD9DFC8FD8EAB` FOREIGN KEY (`smasheur_id`) REFERENCES `smasheur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
