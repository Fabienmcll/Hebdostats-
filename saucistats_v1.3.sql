-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 24 fév. 2024 à 17:45
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

-- --------------------------------------------------------

--
-- Structure de la table `anecdotes`
--

CREATE TABLE IF NOT EXISTS `anecdotes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `anecdotes`
--

INSERT INTO `anecdotes` (`id`, `body`) VALUES
(1, 'La weekly Smash au Meltdown de Lyon est une institution de la scène smash lyonnaise qui a été créée sur Smash 4.\r\n            Elle s\'appelle \"la Saucismash\" en référence au célèbre saucisson brioché de Lyon mais les joueurs ont commencé à\r\n            appeler ce tournoi \"la Saucisse\" pour une raison que j\'ignore. Les vainqueurs de la Saucismash s\'appellent donc \r\n            \"Les teneurs de Saucisse\".'),
(2, 'La toute première Saucismash sur Ultimate a été remportée par Foaya à l\'époque de nos grands frères.'),
(3, 'En voyant le nom de \"Francis\" certains ont lâché une larme de nostalgie.'),
(4, 'Qui de mieux placé que le Lyonnais de cœur et de sang Lil Marty pour avoir remporté la symbolique \r\n            69ème Saucismash ?'),
(5, 'Le plus grand nombre de victoires consécutives à la Saucismash est de 3. Les seuls y étant parvenus\r\n             sont Pandaroux, ALtek, Francis et Slacker. Pandaroux ayant égalé le record 2 fois (Saucismash 6,7,8 & 15,16,17).'),
(6, 'La 4ème Saucismash détient le record du plus grand nombre de participants avec 72 joueurs. Remportée par \r\n            le légendaire Yoyod face à Flynn (le TO) en grande finale.'),
(7, 'Seules 2 Saucismash n\'ont pas de vainqueur, la 28ème annulée car il n\'y avait pas assez de joueurs et la \r\n            44ème car elle a eu lieu juste avant le deuxième confinement à cause du Covid et le format bracket a été écarté \r\n            pour favoriser une \"session\".'),
(8, 'Au vu du faible nombre de joueurs inscrits à la Saucismash #28, il a été décidé que la Saucismash deviendra une monthly \r\n            avec 100 euros de Cashprize. On a appelé ça la Super Saucismash. 44 joueurs sont venus et c\'est Pandaroux qui l\'a emporté.\r\n            Malheureusement la Super Saucismash n\'a connu qu\'une seule édition, et il a fallu attendre 6 mois pour voir un retour de la \r\n            Saucismash après le premier confinement.'),
(9, 'Pendant la 1ère année du jeu Flynn était TO de 3 weeklies en même temps ce fou. #FlynnReviensStp'),
(10, 'L\'un des gagnants d\'une Saucismash a tenté de frapper un TO après avoir perdu. Heureusement ce dernier \r\n            ayant connu la banlieue, la misère et l\'immigration s\'en est sorti sans aucune blessure.'),
(11, 'La Saucismash et le seul tournoi du monde où tu peux être bousculé en plein match de bracket contre \r\n            \"porte-fenêtre\" ou encore \"ImSoFat\" car il y a une table de beer-pong à 20 cm de toi.'),
(12, 'Si tu n\'as pas déjà tenu une saucisse, tu ne peux pas t\'assoir à la table des OGs.'),
(13, 'Avant il y avait du CP à la saucisse, on appellait ça la Golden Sausage. Y\'a même une chaise Gaming qui a\r\n             été remportée par Mocra !'),
(14, 'Une édition de la Saucismash a pris tellement de retard que le top 8 s\'est joué en BO1.'),
(15, 'Mocra a dû DQ d\'une Saucismash car il n\'y avait aucun adaptateur dans la venue et sur les setups.'),
(16, 'Oxydion a un jour sauvé le sac d\'un saucismasheur en repérant de vilains garnements qui tentaient de le \r\n            subtiliser. Depuis Oxydion tient un barbecue avec une bonne flopée de saucisses.'),
(17, 'Le bar offre des verres d\'eau gratuitement ce qui est déjà mieux que le bar de S.Etienne ptdrrrr.'),
(18, 'La playlist du bar est validée par Gin.'),
(19, 'Des joueurs jettent leur manette en Round 1 de Saucismash et ceci m\'empêche de dormir.'),
(20, 'Le joueur ayant fait le plus de Saucismash est Hazmat avec 51 participations à son actif à date du \r\n            15/02/2022 (et j\'updaterai pas cette stat car j\'ai la flemme). Le 2ème est Shiko avec 49.'),
(21, 'Le tout premier tournoi Smash sur Ultimate organisé au Meltdown a été remporté par Nonocolors à la sortie\r\n             du jeu. Le tournoi ne s\'appelait même pas encore la Saucismash ce qui fait de Nonocolors le seul et \r\n             unique teneur de chipo.'),
(22, 'Un certain joueur dont nous respecterons l\'anonymat a DQ d\'une grande finale car son adversaire je cite \r\n            \"bourrait trop c\'est pas intéressant\". La source de cette anecdote a préféré rester anonyme (Lil Marty).'),
(23, 'JO2LY a battu Matth10 mdrrrrrrrrr'),
(24, 'La Saucismash #67 a marqué la dernière sauci de Lyord. Il finira 2ème battu par BenJ ce qui l\'empêchera \r\n            de partir sur une victoire et de quoi rajouter du tragique à son départ... Quelle tristesse Alexa joue la kiffance de Naps.'),
(25, 'Il y a pas vraiment de TO à la Saucismash, enfin si, enfin non, en fait on ne sait pas trop...'),
(26, 'Aspifouette gagne la Saucismash 91 sur une DQ de Zequar en Grande Finale. 7 éditions plus tard à la \r\n            Saucisse 98 Yoyo, le meilleur ami d\'Aspifouette, gagnera également sur une DQ de Nerraw.'),
(27, 'La Saucisse est un tournoi international : le Colombien Reridse a remporté la 87ème Saucisse tandis que Her a \r\n            ramené la 86ème aux Etats-Unis. La 76ème a même été remportée par un mec de Limoges.'),
(28, 'Un vainqueur de la Saucismash a déjà insulté un TO parce que ce dernier a pris la décision de passer le bracket en BO3 pour que les \r\n            finalistes puissent avoir le dernier métro.'),
(29, 'Saucismash 110, Shiko vs Sfar. Coup d\'envoi 21h. Après une game 1 très longue et très serrée Shiko place un Back air en last hit,\r\n            pense gagner la game et pop-off si fort que tout le bar l\'entend. Malheureusement pour lui Sfar ne meurt pas, revient sur le stage,\r\n            et remporte la game... et tout le bar pop-off pour se moquer de Shiko.'),
(30, 'Tu peux accéder à la fiche de joueur de n\'importe quel·le Saucismasheur·euse simplement en cliquant sur son pseudo dans le hall of Fame ou dans une fiche de tournoi.\r\n            Tu pourras y trouver ses stats personnelles et les titres qu\'iel a remporté. Sauf si la personne concernée a supp son compte pour changer d\'identité, la je peux rien faire sorry'),
(31, 'Semaine du 13 mars 2023 : Spectral, récemment sacré 8ème joueur de France, décide de passer toute la semaine à Lyon et participer à toutes\r\n            les weeklies en vue de la Dose2Sucre. Il remporte toutes les weeklies la main dans le slip... sauf la Saucismash #120 où il sera vaincu par Slacker,\r\n            un vrai saucismasheur bien de chez nous !'),
(32, 'Saucismash 133, 23h55. Underkowe et Sfar décident de faire la course sur 50 mètres devant le bar... Underkowe fait une chute terrible à mi-parcours mais arrive quand même à remporter la course. Bûch > S&B.'),
(33, 'Le Trophée Abe Froman du Roi de la Saucisse récompense lae smasheur·euse qui a remporté le plus de Saucismash sur une année civile. Qui remportera l\'édition \r\n            cette année ? La bataille fait rage... RDV le 1er janvier pour le résultat !'),
(34, 'Si vous ne savez pas qui est Abe Froman, allez voir le chef d\'oeuvre cinématographique La Folle Journée de Ferris Bueller ou demandez directement à JO2LY.'),
(35, 'Le Trophée de la Seringue récompense lae Saucismasheur·euse qui a le plus de participations sur une année civile. En 2022 le trophée est partagé entre Baskoy, Deskwam et Hazmat \r\n            qui sont arrivés ex-aequo avec 34 participations chacun sur 47 éditions ! Bravo les seringués...'),
(36, 'Deux saucismasheurs ont un jour interrompu leur match de bracket en plein milieu pour aller voir en direct un penalty de Karim à la télé... Et le TO ne leur a rien dit parce qu\'il regardait avec eux !'),
(37, 'En Juillet 2023 le Meltdown de Lyon annonce sa fermeture. Cette nouvelle est déjà bien triste mais en plus ça veut dire que Sorbexos va devoir rester sur ses 11 défaites d\'affilée en Grande Finale \r\n            avec 0 victoire... Il pleut.');

-- --------------------------------------------------------

--
-- Structure de la table `classement`
--

CREATE TABLE IF NOT EXISTS `classement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `debut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classement`
--

INSERT INTO `classement` (`id`, `nom`, `debut`, `fin`) VALUES
(1, 'Hiver-Printemps 2024', '1st January 2024', '1st July 2024');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
/*('DoctrineMigrations\\Version20211027162826', '2022-12-26 19:48:18', 1592),
('DoctrineMigrations\\Version20211027230734', '2022-12-26 19:48:20', 533),
('DoctrineMigrations\\Version20211111234613', '2022-12-26 19:48:20', 451),
('DoctrineMigrations\\Version20211119014545', '2022-12-26 19:51:04', 674),
('DoctrineMigrations\\Version20221211230825', '2022-12-26 19:51:05', 735),
('DoctrineMigrations\\Version20221212172448', '2022-12-26 19:51:06', 1952),
('DoctrineMigrations\\Version20221217154029', '2022-12-26 19:51:08', 1562),
('DoctrineMigrations\\Version20221217154728', '2022-12-26 19:51:09', 1363),
('DoctrineMigrations\\Version20221219003200', '2022-12-26 19:51:11', 3473),
('DoctrineMigrations\\Version20221222205505', '2022-12-26 19:51:14', 1879),
('DoctrineMigrations\\Version20230106235853', '2023-01-07 00:02:38', 1940),
('DoctrineMigrations\\Version20230523234823', '2023-05-23 23:49:59', 1682),
('DoctrineMigrations\\Version20230629180818', '2023-06-29 18:09:52', 1471),*/
('DoctrineMigrations\\Version20240127004947', '2024-01-27 00:51:46', 832);

-- --------------------------------------------------------

--
-- Structure de la table `pins`
--

CREATE TABLE IF NOT EXISTS `pins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '(DC2Type:datetime_immutable)',
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `smasheur`
--

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
-- Structure de la table `trophee`
--

CREATE TABLE IF NOT EXISTS `trophee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_player_api` bigint DEFAULT NULL,
  `emoji` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trophee`
--

INSERT INTO `trophee` (`id`, `nom`, `version`, `id_player_api`, `emoji`, `description`) VALUES
(1, 'Abe Froman du Roi de la Saucisse', '2019', 1079988, '🏆', 'Tu détiens le record du nombre de Saucisses remportées sur l\'année 2019'),
(2, 'Abe Froman du Roi de la Saucisse', '2020', 1079988, '🏆', 'Tu détiens le record du nombre de Saucisses remportées sur l\'année 2020'),
(3, 'de la Seringue de l\'année', '2020', 944414, '💉', 'Tu détiens le record du nombre de participations à la Saucisse sur l\'année 2020'),
(4, 'Abe Froman du Roi de la Saucisse', '2021', 1135625, '🏆', 'Tu détiens le record du nombre de Saucisses remportées sur l\'année 2021'),
(5, 'de la Seringue de l\'année', '2021', 2338906, '💉', 'Tu détiens le record du nombre de participations à la Saucisse sur l\'année 2021'),
(6, 'Abe Froman du Roi de la Saucisse', '2022', 256315, '🏆', 'Tu détiens le record du nombre de Saucisses remportées sur l\'année 2022'),
(7, 'de la Seringue de l\'année', '2022', 2186864, '💉', 'Tu détiens le record du nombre de participations à la Saucisse sur l\'année 2022'),
(8, 'de la Seringue de l\'année', '2022', 1971179, '💉', 'Tu détiens le record du nombre de participations à la Saucisse sur l\'année 2022'),
(9, 'de la Seringue de l\'année', '2022', 1971189, '💉', 'Tu détiens le record du nombre de participations à la Saucisse sur l\'année 2022'),
(10, 'Abe Froman du Roi de la Saucisse', '2023', 2590754, '🏆', 'Tu détiens le record du nombre de Saucisses remportées sur l\'année 2023'),
(11, 'de la Seringue de l\'année', '2023', 1197445, '💉', 'Tu détiens le record du nombre de participations à la Saucisse sur l\'année 2023');

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
