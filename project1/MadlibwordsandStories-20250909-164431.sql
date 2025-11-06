-- AdminNeo 5.0.0 MySQL 8.0.43-0ubuntu0.24.04.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `Madlibs`;
CREATE DATABASE `Madlibs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `Madlibs`;

DROP TABLE IF EXISTS `MadlibwordsandStories`;
CREATE TABLE `MadlibwordsandStories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `noun` varchar(20) NOT NULL,
  `verb` varchar(20) NOT NULL,
  `adverb` varchar(20) NOT NULL,
  `adjective` varchar(20) NOT NULL,
  `fullstory` varchar(254) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `MadlibwordsandStories` (`id`, `noun`, `verb`, `adverb`, `adjective`, `fullstory`) VALUES
(1,	'play',	'game',	'amazing',	'Beautiful',	'On a <strong>Beautiful</strong> day, I decided to <strong>game</strong> my favorite <strong>play</strong> while <strong>amazing</strong> dancing in the park. Everyone around me joined in, and we all had a great time!'),
(2,	'game',	'play',	'actively',	'Beautiful',	'On a <strong>Beautiful</strong> day, I decided to <strong>play</strong> my favorite <strong>game</strong> while <strong>actively</strong> dancing in the park. Everyone around me joined in, and we all had a great time!'),
(3,	'A',	'b',	'dD',	'c',	'On a <strong>c</strong> day, I decided to <strong>b</strong> my favorite <strong>A</strong> while <strong>dD</strong> dancing in the park. Everyone around me joined in, and we all had a great time!'),
(4,	'b',	'c',	'e',	'd',	'On a <strong>d</strong> day, \n        I decided to <strong>c</strong> my favorite <strong>b</strong> while <strong>e</strong> dancing in the park. \n        Everyone around me joined in, and we all had a great time!'),
(5,	'play',	'song',	'speedily',	'impressive',	'On a <strong>impressive</strong> day, \n        I decided to <strong>song</strong> my favorite <strong>play</strong> while <strong>speedily</strong> dancing in the park. \n        Everyone around me joined in, and we all had a great time!'),
(6,	'game',	'play',	'speedily',	'impressive',	'On a <strong>impressive</strong> day, \n        I decided to <strong>play</strong> my favorite <strong>game</strong> while <strong>speedily</strong> dancing in the park. \n        Everyone around me joined in, and we all had a great time!');

-- 2025-09-09 16:44:31 UTC
