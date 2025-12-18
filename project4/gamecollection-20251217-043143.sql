-- AdminNeo 5.0.0 MySQL 8.0.43-0ubuntu0.24.04.2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `gamecollection`;
CREATE DATABASE `gamecollection` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `gamecollection`;

DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `purchase_date` date NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rating` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `games` (`id`, `user_id`, `title`, `purchase_date`, `status`, `rating`) VALUES
(4,	13,	'Super Mario 64 DS',	'2011-09-01',	'Playing',	10),
(5,	7,	'twitter',	'2011-09-15',	'Owned',	7),
(7,	22,	'Super Mario Odyssey',	'2025-09-15',	'Completed',	10),
(8,	23,	'Super mario Odyssey',	'2025-01-10',	'Completed',	8),
(10,	25,	'Sonic Unleashed',	'2022-11-11',	'Played',	9),
(11,	13,	'Mario Kart Wii',	'1994-09-15',	'Playing',	10),
(12,	13,	'Mario Kart',	'2011-06-06',	'Owned',	7),
(13,	27,	'Sonic Frontiers',	'2022-11-24',	'Playing',	8),
(15,	28,	'Super Mario Sunshine',	'2025-08-07',	'Played',	6),
(16,	29,	'Sonic Frontiers',	'2024-09-05',	'Completed',	10),
(19,	30,	'Mario Party 6',	'2000-09-06',	'Completed',	9)
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `purchase_date` = VALUES(`purchase_date`), `status` = VALUES(`status`), `rating` = VALUES(`rating`);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `user_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `name`, `user_name`, `password_hash`) VALUES
(5,	'',	'johnpow5',	'$2y$10$Li96x4SQemKdgFTLtWqxsO80NE5H02nFDtwcXg.eoIN7zZpFBVyIS'),
(6,	'',	'Bpowell5',	'$2y$10$neP1c2Bzm/Qxiwdaf2hlOOtUCNyDjZYbdggTizMdL0gjNsvaqGP0m'),
(7,	'',	'fred',	'$2y$10$2Ad69QA.VQl2hHMschzczOeddU5/rhVexmWh7kj2ovH6dQRFcT/bi'),
(8,	'',	'micheleshawn8',	'$2y$10$nqyLZtTRL7PViqyu7mpAoeSaVrKiB3MJUB6CgjhYUY6T0KdlyLPTu'),
(9,	'',	'hbk1996',	'$2y$10$Lo6QuGBjHsdWmjn28mJIAujcIvHFD6rrh8P7hw5L9MHdCpMq1i0yC'),
(10,	'',	'johnshawn',	'$2y$10$bon.jZxhuG7se6gr2.7CYODVzzBBPAAIGiasA5zV0dqh7kl1j7N4K'),
(11,	'',	'mynameispablo',	'$2y$10$Z.O5./.5nzh2V9RipMuE3.pVpTbt8htKqVCw9Dtj3Kq6tKOE.j/iS'),
(12,	'sonicthehedgehog',	'Gottagofast1',	'$2y$10$HW55e6bP8iJt6fKrxzezA.80BOHJmhay5OPAyZT032REIDm94THZS'),
(13,	'Miles \"tails\" Prower',	'flyingreallyhigh',	'$2y$10$F2oKMpRRZ27kRqQya1meZeZgNq846nDjUrItIsWMw.rkmYMZvbKVe'),
(14,	'John Cena',	'ucantcme',	'$2y$10$TS30l619HtJOH8NmqxdR6uztKNJTCW23S3H7s.4I7yTvJwEcP.fva'),
(15,	'Tommypickles',	'tompick',	'$2y$10$Z7Fq1qXv0vqmWMRt9A3trOR/8clGuwdYDVVNh8E9Xcr0pNoVEjqlO'),
(16,	'johnnyboy',	'johnboy1',	'$2y$10$HgtRARtRHCJk22ExqreA3eo1a7W2IK707z.B9KriKmGSQ.r.Ipfga'),
(17,	'testuser',	'testuser1',	'$2y$10$UVKzWL4uexXjOgpQEg35bu6.1d4o3uoaPAIA0oEu2LdcHMnL2U2PG'),
(18,	'RandyOrton',	'Randyisawesome',	'$2y$10$qtwDydlgHhNAS48pWOPWGeRjP.XuQ4Y/sjLRBA9Cg/1rIkIPMT19C'),
(19,	'Test',	'testing',	'$2y$10$EMUQ9CXE329ZIm2bQxCAOekDZ2LGZB3wilG3SX44ZAfS.MB6cl3cC'),
(20,	'tester',	'tester123',	'$2y$10$MBlDYy6PxoNUqd91vBnbQONoUyevyR96NqnVYvaCGvsGwOjKK3/Qe'),
(21,	'test123',	'testing123',	'$2y$10$HfNGzAQl..RFjuI2uO10t.I4mM9gB6kzayNSsSttvROYOyHSPQD6y'),
(22,	'testing456',	'testing456',	'$2y$10$t/pp6j6NEZaNu1qN4SLUze/sOAgZ.FFcqTWxLb/GQA.9.pUJDRApm'),
(23,	'testuser3',	'testuser3',	'$2y$10$wq7y8Gdvl2uH9KFxQWPJWeUuZZsI5MIay2TgGI7OeQNzo5I7L47pG'),
(24,	'test',	'test2',	'$2y$10$V0EyCTN1ePjexKKlCRkmle8I1LVDx4QI703v4hSmyAZ5Slo0t0Y0C'),
(25,	'testing',	'testing789',	'$2y$10$dXnzU0x36JEs.twHQBOblOxnVU6lx1lpKoTcLDEKGhP1xduHQXfLG'),
(26,	'buddieisgreat',	'buddieisawesome',	'$2y$10$Ju8xKxbpw83Fm9eFTtuPLuli8A.6sQViEN4isM3ykDElb2mk5s9uS'),
(27,	'testtest',	'testtest123',	'$2y$10$tyruDg06dG3JDxy3IDNnIu.xZ9IddPnnDB/k/Hh.nhQNeFsx.vIAa'),
(28,	'usertest',	'usertest',	'$2y$10$6U7q8m91ZY.FIDjzniqmdO7ZeG4iuuIZjRHWntYdjJzoDTwg4LJvK'),
(29,	'usertest3',	'usertest3',	'$2y$10$kqKK7IJbRHf6N4zTyrCQau.UuUkHWiUfWeRXS57aZaAl7JEw3cjgG'),
(30,	'testuser2',	'testuser2',	'$2y$10$CWiMK1KhrdHF58E.VyDVo.4TmzaF29fKaKgDIbI2uVRFAwEplOncK')
ON DUPLICATE KEY UPDATE `id` = VALUES(`id`), `name` = VALUES(`name`), `user_name` = VALUES(`user_name`), `password_hash` = VALUES(`password_hash`);

-- 2025-12-17 04:31:43 UTC
