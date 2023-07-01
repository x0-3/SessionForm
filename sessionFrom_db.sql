-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for sessform
CREATE DATABASE IF NOT EXISTS `sessform` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sessform`;

-- Dumping structure for table sessform.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sessform.category: ~6 rows (approximately)
INSERT INTO `category` (`id`, `name`, `image`) VALUES
	(1, 'BUREAUTIQUE', '/uploads/download-644195a029df2.jpg'),
	(2, 'DEV WEB', '/uploads/2-644191735abcd.png'),
	(4, 'test/test', ''),
	(6, '123', ''),
	(8, 'ghi', '/uploads/1-64423752b73e5.png'),
	(10, 'test system', '/uploads/market-place-644408d32fbac.png');

-- Dumping structure for table sessform.doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table sessform.doctrine_migration_versions: ~1 rows (approximately)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230406123921', '2023-04-06 12:40:03', 702);

-- Dumping structure for table sessform.messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sessform.messenger_messages: ~0 rows (approximately)

-- Dumping structure for table sessform.module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C24262812469DE2` (`category_id`),
  CONSTRAINT `FK_C24262812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sessform.module: ~11 rows (approximately)
INSERT INTO `module` (`id`, `category_id`, `name`) VALUES
	(1, 1, 'Word'),
	(2, 1, 'Excel'),
	(3, 1, 'Powerpoint'),
	(4, 2, 'PHP'),
	(5, 2, 'SQL'),
	(6, 2, 'JavaScript'),
	(8, 4, '1234567876'),
	(9, 4, '1234567876'),
	(10, 2, '123456'),
	(12, 6, 'test'),
	(14, 2, 'hi'),
	(15, 8, 'test'),
	(16, 10, '4567');

-- Dumping structure for table sessform.program
CREATE TABLE IF NOT EXISTS `program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int DEFAULT NULL,
  `module_id` int DEFAULT NULL,
  `duree` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92ED7784613FECDF` (`session_id`),
  KEY `IDX_92ED7784AFC2B591` (`module_id`),
  CONSTRAINT `FK_92ED7784613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_92ED7784AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sessform.program: ~47 rows (approximately)
INSERT INTO `program` (`id`, `session_id`, `module_id`, `duree`) VALUES
	(3, 1, 4, 23),
	(4, 1, 3, 12),
	(5, 2, 2, 5),
	(6, 2, 6, 10),
	(23, 1, 8, 7),
	(24, 1, 3, 7),
	(28, NULL, 1, 54),
	(29, NULL, 1, 54),
	(30, NULL, 1, 54),
	(31, 14, 1, 6),
	(32, 14, 6, 9),
	(33, 14, 9, 12),
	(34, 14, 5, 9),
	(36, 14, 3, 111),
	(42, 3, 8, 0),
	(43, 3, 1, 12),
	(44, 3, 1, 123),
	(45, NULL, 1, 123),
	(46, NULL, 1, 123),
	(47, NULL, 8, 12),
	(49, NULL, 2, 13),
	(50, NULL, 2, 13),
	(51, NULL, 4, 45),
	(52, NULL, 5, 54),
	(53, NULL, 2, 34),
	(54, NULL, 4, 6),
	(55, 16, 1, 12),
	(56, 16, 3, 5),
	(57, 16, 3, 6),
	(58, 16, 1, 7),
	(59, 16, 6, 6),
	(60, 1, 6, 9),
	(62, 1, 6, 10),
	(63, NULL, 3, 4),
	(64, NULL, 3, 4),
	(65, 2, 4, 4),
	(67, 2, 8, 5),
	(68, 2, 3, 6),
	(69, 2, 1, 9),
	(70, NULL, 1, 9),
	(71, 3, 1, 1),
	(72, 3, 5, 5),
	(73, 3, 3, 5),
	(75, 3, 9, 4),
	(76, 16, 1, 5),
	(78, NULL, 3, 5),
	(79, NULL, 3, 5),
	(80, NULL, 3, 5),
	(81, NULL, 1, 4),
	(83, 17, 10, 7),
	(84, 18, 6, 8),
	(85, 19, 1, 5),
	(86, 19, 12, 8);

-- Dumping structure for table sessform.session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `begin_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `nb_place` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sessform.session: ~8 rows (approximately)
INSERT INTO `session` (`id`, `name`, `begin_date`, `end_date`, `nb_place`) VALUES
	(1, 'session1', '2023-04-06 00:00:00', '2024-05-06 00:00:00', 10),
	(2, 'session2', '2023-05-06 15:21:00', '2024-06-06 15:21:00', 15),
	(3, 'new session', '2021-04-05 00:00:00', '2025-04-02 00:00:00', 10),
	(13, 'marche', '2018-01-01 00:00:00', '2018-01-01 00:00:00', 6),
	(14, 'test', '2018-05-01 00:00:00', '2018-01-01 00:00:00', 7),
	(16, 'another test', '2018-01-01 00:00:00', '2018-01-01 00:00:00', 2),
	(17, 'tst', '2020-03-06 00:00:00', '2028-01-01 00:00:00', 4),
	(18, '&é"\'(', '2020-02-01 00:00:00', '2023-03-17 00:00:00', 6),
	(19, 'test', '2018-01-01 00:00:00', '2022-05-01 00:00:00', 13);

-- Dumping structure for table sessform.stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` datetime NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sessform.stagiaire: ~5 rows (approximately)
INSERT INTO `stagiaire` (`id`, `name`, `last_name`, `gender`, `birthday`, `adresse`, `city`, `zip_code`, `email`, `tel`) VALUES
	(1, 'Alain', 'Chesnay', 'M', '2018-02-24 00:00:00', '60, rue des Soeurs', 'LA CIOTAT', '13600', 'AlainChesnay@armyspy.com', '04.68.93.20.86'),
	(2, 'Honore ', 'Sevier', 'F', '1973-04-08 15:11:33', '10, Avenue De Marlioz', 'ANTIBES', '06600', 'HonoreSevier@rhyta.com', '04.20.22.27.25'),
	(3, 'Amedee', 'Charpie', 'F', '2000-08-17 15:13:25', '82, Place de la Gare', 'COLMAR', '68000 ', 'AmedeeCharpie@armyspy.com', '03.40.95.45.53'),
	(4, 'Raymond', 'Sarrazin', 'M', '2018-09-28 00:00:00', '30, rue du Gue Jacquet', 'CHATOU', '78400', 'RaymondSarrazin@dayrep.com', '01.11.99.09.54'),
	(5, 'Vail ', 'Longpré', 'M', '1966-05-07 15:15:41', '20, boulevard de Prague', 'NIORT', '79000 ', 'VailLongpre@rhyta.com', '05.51.84.15.77');

-- Dumping structure for table sessform.stagiaire_session
CREATE TABLE IF NOT EXISTS `stagiaire_session` (
  `stagiaire_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`stagiaire_id`,`session_id`),
  KEY `IDX_D32D02D4BBA93DD6` (`stagiaire_id`),
  KEY `IDX_D32D02D4613FECDF` (`session_id`),
  CONSTRAINT `FK_D32D02D4613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D32D02D4BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sessform.stagiaire_session: ~12 rows (approximately)
INSERT INTO `stagiaire_session` (`stagiaire_id`, `session_id`) VALUES
	(1, 3),
	(1, 14),
	(1, 19),
	(2, 1),
	(2, 2),
	(2, 3),
	(2, 14),
	(2, 16),
	(3, 1),
	(3, 2),
	(4, 1),
	(4, 2),
	(4, 3),
	(5, 2),
	(5, 16);

-- Dumping structure for table sessform.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sessform.user: ~0 rows (approximately)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `last_name`) VALUES
	(9, '123@gmail.com', '["ROLE_ADMIN"]', '$2y$13$EhMjCIf/SA1Te/sxU.e3geyx0.n7CzqDtITniZjQs6z1xesaaJXGu', 'test', 'test');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
