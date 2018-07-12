-- --------------------------------------------------------
-- Host:                         localhost
-- Versione server:              10.1.25-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win32
-- HeidiSQL Versione:            9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dump della struttura di vista player.player_ranking_representation
-- Creazione di una tabella temporanea per risolvere gli errori di dipendenza della vista
CREATE TABLE `player_ranking_representation` (
	`id` INT(11) UNSIGNED NOT NULL,
	`account_id` INT(11) UNSIGNED NOT NULL,
	`name` VARCHAR(24) NOT NULL COLLATE 'latin1_swedish_ci',
	`level` TINYINT(2) UNSIGNED NOT NULL,
	`job` TINYINT(2) UNSIGNED NOT NULL,
	`playtime` INT(11) NOT NULL,
	`mmr` INT(11) NOT NULL,
	`empire` TINYINT(4) UNSIGNED NULL,
	`prestige` INT(11) NULL,
	`guild_name` VARCHAR(12) NULL COMMENT 'snprintf(12u)' COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;

-- Dump della struttura di vista player.player_ranking_representation
-- Rimozione temporanea di tabella e creazione della struttura finale della vista
DROP TABLE IF EXISTS `player_ranking_representation`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `player_ranking_representation` AS select `a`.`id` AS `id`,`a`.`account_id` AS `account_id`,`a`.`name` AS `name`,`a`.`level` AS `level`,`a`.`job` AS `job`,`a`.`playtime` AS `playtime`,`a`.`mmr` AS `mmr`,`b`.`empire` AS `empire`,`e`.`lValue` AS `prestige`,`d`.`name` AS `guild_name` from ((((`player` `a` left join `player_index` `b` on(`a`.`account_id` = `b`.`id`)) left join `guild_member` `c` on(`a`.`id` = `c`.`pid`)) left join `guild` `d` on(`c`.`guild_id` = `d`.`id`)) left join `quest` `e` on(`e`.`dwPID` = `a`.`id` and `e`.`szName` = 'prestige')); ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
