-- AdminNeo 5.0.0 MySQL 8.0.43-0ubuntu0.24.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `Post`;
CREATE DATABASE `Post` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `Post`;

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creation_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `blog` (`id`, `title`, `content`, `creation_date`) VALUES
(10,	'testing123',	'testing 123321',	'2025-10-25 02:33:01'),
(11,	'ididuddud',	'diddoiosisdi',	'2025-10-26 09:13:29'),
(12,	'ahaajajahajja',	'aauauajanaannana',	'2025-10-28 05:00:00'),
(13,	'titotirir',	'tieoeieie',	'2025-10-30 00:36:29'),
(22,	'content',	'content is amazing ',	'2025-11-04 16:37:03'),
(23,	'here is my current post',	'makes sense',	'2025-11-04 22:45:07');

-- 2025-11-04 17:08:36 UTC
