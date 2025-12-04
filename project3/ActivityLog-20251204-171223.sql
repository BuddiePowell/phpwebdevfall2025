-- AdminNeo 5.0.0 MySQL 8.0.43-0ubuntu0.24.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `ActivityLog`;
CREATE DATABASE `ActivityLog` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ActivityLog`;

DROP TABLE IF EXISTS `exercise_log`;
CREATE TABLE `exercise_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date` date NOT NULL,
  `exercise_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time_in_minutes` int NOT NULL,
  `heartrate` int NOT NULL,
  `calories` smallint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `exercise_log` (`id`, `user_id`, `date`, `exercise_type`, `time_in_minutes`, `heartrate`, `calories`) VALUES
(21,	12,	'1994-09-15',	'Swimming',	90,	200,	1294),
(24,	12,	'2024-12-20',	'Running',	90,	150,	1361),
(25,	12,	'2024-12-20',	'Running',	90,	150,	1361),
(26,	12,	'2024-12-20',	'Running',	170,	120,	1802),
(27,	12,	'2024-12-20',	'Running',	170,	120,	1802),
(28,	12,	'2024-12-20',	'Running',	200,	150,	3025),
(34,	17,	'2024-12-20',	'Running',	200,	120,	1627),
(35,	17,	'2020-08-15',	'Walking',	120,	150,	1440),
(36,	17,	'1994-09-15',	'Weightlifting',	200,	120,	1627),
(37,	17,	'2025-12-03',	'Swimming',	90,	170,	1312),
(38,	17,	'1994-09-15',	'Running',	111,	111,	1481),
(39,	17,	'2025-11-27',	'Cycling',	90,	150,	1653),
(41,	17,	'1994-09-15',	'Walking',	200,	200,	3689),
(42,	17,	'1994-09-15',	'Running',	200,	120,	1627),
(69,	17,	'1994-09-15',	'Running',	110,	120,	904),
(70,	17,	'2025-11-12',	'Walking',	15,	111,	106),
(71,	17,	'1994-09-15',	'Running',	30,	120,	246),
(73,	19,	'2025-12-04',	'Running',	45,	135,	497),
(74,	19,	'2025-12-04',	'Walking',	45,	135,	381),
(75,	20,	'1994-09-15',	'Walking',	30,	150,	361)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `date` = VALUES(`date`), `exercise_type` = VALUES(`exercise_type`), `time_in_minutes` = VALUES(`time_in_minutes`), `heartrate` = VALUES(`heartrate`), `calories` = VALUES(`calories`);

DROP TABLE IF EXISTS `exercise_user`;
CREATE TABLE `exercise_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `birthdate` date NOT NULL,
  `weight` int NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `exercise_user` (`id`, `first_name`, `last_name`, `gender`, `birthdate`, `weight`, `user_name`, `password_hash`) VALUES
(15,	'johnny',	'Powell',	'Male',	'1994-09-15',	200,	'Johnnytest',	'$2y$10$F3fXKv4P/tSPzWITHS9i/.ULEVkvhG.W.N51rdT8McURhXtrU2FWC'),
(16,	'johnny',	'Powell',	'Male',	'2000-12-02',	200,	'Jpowell5',	'$2y$10$823pFxzl.wuiVta7HLPgfe9mpdkZjA5tAB7goDEFyt8.gG8b94moC'),
(17,	'michelle',	'Shawn',	'n',	'1995-11-11',	200,	'micheleshawn8',	'$2y$10$lbtsseQU5U6oVFtA3SXEAuFjkvEJ3m2nquwLCSpdsJJNIQ3Cnmy3e'),
(18,	'johnny',	'Powell',	'Male',	'1994-09-15',	180,	'johnpow5',	'$2y$10$OEe4xLBRJiQ1oZqafNXWPeAwWoJKPNdA78fA9/hooLnqaC5uRvkYS'),
(19,	'Fred',	'Flintstone',	'f',	'1963-01-01',	160,	'fred',	'$2y$10$QPPbb32zKHaGdpOC6pxPC.v8Lg7chrriXTDxUw1YvGYi29XsO2hs.'),
(20,	'Buddie',	'Powell',	'n',	'1994-09-15',	180,	'Bpowell5',	'$2y$10$uejk7f7alIEymHbLnCpq6.63RkXLc7fExpV9/0N/xP.S3bQ.Ja88C')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `first_name` = VALUES(`first_name`), `last_name` = VALUES(`last_name`), `gender` = VALUES(`gender`), `birthdate` = VALUES(`birthdate`), `weight` = VALUES(`weight`), `user_name` = VALUES(`user_name`), `password_hash` = VALUES(`password_hash`);

-- 2025-12-04 17:12:23 UTC
