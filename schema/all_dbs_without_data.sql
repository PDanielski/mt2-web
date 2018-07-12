-- --------------------------------------------------------
-- Host:                         game.metin2warlords.net
-- Versione server:              10.2.13-MariaDB - FreeBSD Ports
-- S.O. server:                  FreeBSD10.3
-- HeidiSQL Versione:            9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dump della struttura del database account
CREATE DATABASE IF NOT EXISTS `account` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `account`;

-- Dump della struttura di tabella account.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(16) NOT NULL DEFAULT '' COMMENT 'LOGIN_MAX_LEN=30',
  `password` varchar(42) NOT NULL DEFAULT '' COMMENT 'PASSWD_MAX_LEN=16; default 45 size',
  `social_id` varchar(7) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `coins` smallint(10) NOT NULL DEFAULT 0,
  `securitycode` varchar(192) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT 'OK',
  `availDt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_play` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gold_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `silver_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `safebox_expire` datetime NOT NULL DEFAULT '2027-12-16 11:08:50',
  `autoloot_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fish_mind_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `marriage_fast_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `money_drop_rate_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `real_name` varchar(16) DEFAULT '',
  `question1` varchar(56) DEFAULT NULL,
  `answer1` varchar(56) DEFAULT NULL,
  `question2` varchar(56) DEFAULT NULL,
  `answer2` varchar(56) DEFAULT NULL,
  `cash` int(11) DEFAULT 0,
  `gold` bigint(255) DEFAULT 0,
  `warpoints` bigint(255) DEFAULT 0,
  `biscuits` bigint(255) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`) USING BTREE,
  KEY `social_id` (`social_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2824 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.account_activation_code
CREATE TABLE IF NOT EXISTS `account_activation_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT 0,
  `code` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.account_con_i_player_veri
CREATE TABLE IF NOT EXISTS `account_con_i_player_veri` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(16) NOT NULL DEFAULT '' COMMENT 'LOGIN_MAX_LEN=30',
  `password` varchar(42) NOT NULL DEFAULT '' COMMENT 'PASSWD_MAX_LEN=16; default 45 size',
  `social_id` varchar(7) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `coins` smallint(10) NOT NULL DEFAULT 0,
  `securitycode` varchar(192) NOT NULL DEFAULT '',
  `status` varchar(10) NOT NULL DEFAULT 'OK',
  `availDt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_play` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gold_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `silver_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `safebox_expire` datetime NOT NULL DEFAULT '2027-12-16 11:08:50',
  `autoloot_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fish_mind_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `marriage_fast_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `money_drop_rate_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `real_name` varchar(16) DEFAULT '',
  `question1` varchar(56) DEFAULT NULL,
  `answer1` varchar(56) DEFAULT NULL,
  `question2` varchar(56) DEFAULT NULL,
  `answer2` varchar(56) DEFAULT NULL,
  `cash` int(11) DEFAULT 0,
  `gold` bigint(255) DEFAULT 0,
  `warpoints` bigint(255) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`) USING BTREE,
  KEY `social_id` (`social_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.account_group
CREATE TABLE IF NOT EXISTS `account_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL DEFAULT 0,
  `name` char(30) COLLATE utf8_bin DEFAULT '0',
  `role` char(20) COLLATE utf8_bin DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Indice 2` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.block_exception
CREATE TABLE IF NOT EXISTS `block_exception` (
  `login` varchar(16) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.GameTime
CREATE TABLE IF NOT EXISTS `GameTime` (
  `UserID` varchar(16) NOT NULL DEFAULT '',
  `paymenttype` tinyint(2) NOT NULL DEFAULT 1,
  `LimitTime` int(11) unsigned DEFAULT 0,
  `LimitDt` datetime DEFAULT '1990-01-01 00:00:00',
  `Scores` int(11) DEFAULT 0,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.GameTimeIP
CREATE TABLE IF NOT EXISTS `GameTimeIP` (
  `ipid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '000.000.000.000',
  `startIP` int(11) NOT NULL DEFAULT 0,
  `endIP` int(11) NOT NULL DEFAULT 255,
  `paymenttype` tinyint(2) NOT NULL DEFAULT 1,
  `LimitTime` int(11) NOT NULL DEFAULT 0,
  `LimitDt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `readme` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`ipid`),
  UNIQUE KEY `ip_uniq` (`ip`,`startIP`,`endIP`),
  KEY `ip_idx` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.GameTimeLog
CREATE TABLE IF NOT EXISTS `GameTimeLog` (
  `login` varchar(16) DEFAULT NULL,
  `type` enum('IP_FREE','FREE','IP_TIME','IP_DAY','TIME','DAY') DEFAULT NULL,
  `logon_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logout_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `use_time` int(11) unsigned DEFAULT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '000.000.000.000',
  `server` varchar(56) NOT NULL DEFAULT '',
  KEY `login_key` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.iptocountry
CREATE TABLE IF NOT EXISTS `iptocountry` (
  `IP_FROM` varchar(16) DEFAULT NULL,
  `IP_TO` varchar(16) DEFAULT NULL,
  `COUNTRY_NAME` varchar(56) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella account.string
CREATE TABLE IF NOT EXISTS `string` (
  `name` varchar(64) NOT NULL DEFAULT '',
  `text` text DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.

-- Dump della struttura del database player
CREATE DATABASE IF NOT EXISTS `player` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `player`;

-- Dump della struttura di tabella player.affect
CREATE TABLE IF NOT EXISTS `affect` (
  `dwPID` int(10) unsigned NOT NULL DEFAULT 0,
  `bType` smallint(5) unsigned NOT NULL DEFAULT 0,
  `bApplyOn` tinyint(4) unsigned NOT NULL DEFAULT 0,
  `lApplyValue` int(11) NOT NULL DEFAULT 0,
  `dwFlag` int(10) unsigned NOT NULL DEFAULT 0,
  `lDuration` int(11) NOT NULL DEFAULT 0,
  `lSPCost` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`dwPID`,`bType`,`bApplyOn`,`lApplyValue`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.banword
CREATE TABLE IF NOT EXISTS `banword` (
  `word` varchar(24) NOT NULL DEFAULT '',
  PRIMARY KEY (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di funzione player.cnt_up_case
DELIMITER //
CREATE DEFINER=`warlords`@`%` FUNCTION `cnt_up_case`(str VARCHAR(255)) RETURNS varchar(255) CHARSET latin1
BEGIN

  SET @cnt = 0;
  SET @len = length(str);
  SET @i = 1;

  WHILE @i <= @len
  DO
    SET @c = substring(str, @i, 1);
    IF ascii(@c) > 64 AND ascii(@c) < 91 THEN
      SET @cnt = @cnt + 1;
    END IF;

    SET @i = @i + 1;
  END WHILE;

  RETURN @cnt;
END//
DELIMITER ;

-- Dump della struttura di tabella player.guild
CREATE TABLE IF NOT EXISTS `guild` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL DEFAULT '' COMMENT 'snprintf(12u)',
  `sp` smallint(6) NOT NULL DEFAULT 1000,
  `master` int(10) unsigned NOT NULL DEFAULT 0,
  `level` tinyint(2) DEFAULT NULL,
  `exp` int(11) DEFAULT NULL,
  `skill_point` tinyint(2) NOT NULL DEFAULT 0,
  `skill` tinyblob DEFAULT NULL,
  `win` int(11) NOT NULL DEFAULT 0,
  `draw` int(11) NOT NULL DEFAULT 0,
  `loss` int(11) NOT NULL DEFAULT 0,
  `ladder_point` int(11) NOT NULL DEFAULT 500,
  `gold` int(11) NOT NULL DEFAULT 0,
  `fight` int(11) NOT NULL DEFAULT 0,
  `land` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.guild_comment
CREATE TABLE IF NOT EXISTS `guild_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guild_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(8) DEFAULT NULL,
  `notice` tinyint(4) DEFAULT NULL,
  `content` varchar(50) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aaa` (`notice`,`id`,`guild_id`) USING BTREE,
  KEY `guild_id` (`guild_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=276 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.guild_grade
CREATE TABLE IF NOT EXISTS `guild_grade` (
  `guild_id` int(11) unsigned NOT NULL DEFAULT 0,
  `grade` tinyint(4) NOT NULL DEFAULT 0,
  `name` varchar(12) NOT NULL DEFAULT '' COMMENT 'strlen(s) <= 12',
  `auth` set('ADD_MEMBER','REMOVE_MEMEBER','NOTICE','USE_SKILL') DEFAULT NULL,
  PRIMARY KEY (`guild_id`,`grade`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.guild_member
CREATE TABLE IF NOT EXISTS `guild_member` (
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `guild_id` int(10) unsigned NOT NULL DEFAULT 0,
  `grade` tinyint(2) DEFAULT NULL,
  `is_general` tinyint(1) NOT NULL DEFAULT 0,
  `offer` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`guild_id`,`pid`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.guild_war
CREATE TABLE IF NOT EXISTS `guild_war` (
  `id_from` int(11) unsigned NOT NULL DEFAULT 0,
  `id_to` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_from`,`id_to`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.guild_war_bet
CREATE TABLE IF NOT EXISTS `guild_war_bet` (
  `login` varchar(16) NOT NULL DEFAULT '',
  `gold` int(10) unsigned NOT NULL DEFAULT 0,
  `guild` int(11) unsigned NOT NULL DEFAULT 0,
  `war_id` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`war_id`,`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.guild_war_reservation
CREATE TABLE IF NOT EXISTS `guild_war_reservation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `guild1` int(10) unsigned NOT NULL DEFAULT 0,
  `guild2` int(10) unsigned NOT NULL DEFAULT 0,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `warprice` int(10) unsigned NOT NULL DEFAULT 0,
  `initscore` int(10) unsigned NOT NULL DEFAULT 0,
  `started` tinyint(1) NOT NULL DEFAULT 0,
  `bet_from` int(10) unsigned NOT NULL DEFAULT 0,
  `bet_to` int(10) unsigned NOT NULL DEFAULT 0,
  `winner` int(11) NOT NULL DEFAULT -1,
  `power1` int(11) NOT NULL DEFAULT 0,
  `power2` int(11) NOT NULL DEFAULT 0,
  `handicap` int(11) NOT NULL DEFAULT 0,
  `result1` int(11) NOT NULL DEFAULT 0,
  `result2` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=153 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.horse_name
CREATE TABLE IF NOT EXISTS `horse_name` (
  `id` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(16) NOT NULL DEFAULT 'NONAME' COMMENT 'CHARACTER_NAME_MAX_LEN+1 so 24+null',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di procedura player.insertproc
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `insertproc`()
BEGIN
    DECLARE i int DEFAULT 1;
    WHILE i <= 20000 DO
        INSERT INTO player2 (id) VALUES (i);
        SET i = i + 1;
    END WHILE;
END//
DELIMITER ;

-- Dump della struttura di tabella player.item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) unsigned NOT NULL DEFAULT 0,
  `window` enum('INVENTORY','EQUIPMENT','SAFEBOX','MALL','DRAGON_SOUL_INVENTORY','BELT_INVENTORY','GROUND') NOT NULL DEFAULT 'INVENTORY',
  `pos` smallint(5) unsigned NOT NULL DEFAULT 0,
  `count` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `vnum` int(11) unsigned NOT NULL DEFAULT 0,
  `socket0` int(10) unsigned NOT NULL DEFAULT 0,
  `socket1` int(10) unsigned NOT NULL DEFAULT 0,
  `socket2` int(10) unsigned NOT NULL DEFAULT 0,
  `socket3` int(10) unsigned NOT NULL DEFAULT 0,
  `socket4` int(10) unsigned NOT NULL DEFAULT 0,
  `socket5` int(10) unsigned NOT NULL DEFAULT 0,
  `attrtype0` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue0` smallint(6) NOT NULL DEFAULT 0,
  `attrtype1` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue1` smallint(6) NOT NULL DEFAULT 0,
  `attrtype2` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue2` smallint(6) NOT NULL DEFAULT 0,
  `attrtype3` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue3` smallint(6) NOT NULL DEFAULT 0,
  `attrtype4` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue4` smallint(6) NOT NULL DEFAULT 0,
  `attrtype5` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue5` smallint(6) NOT NULL DEFAULT 0,
  `attrtype6` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue6` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `owner_id_idx` (`owner_id`),
  KEY `item_vnum_index` (`vnum`)
) ENGINE=MyISAM AUTO_INCREMENT=250271559 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.item_attr
CREATE TABLE IF NOT EXISTS `item_attr` (
  `apply` enum('MAX_HP','MAX_SP','CON','INT','STR','DEX','ATT_SPEED','MOV_SPEED','CAST_SPEED','HP_REGEN','SP_REGEN','POISON_PCT','STUN_PCT','SLOW_PCT','CRITICAL_PCT','PENETRATE_PCT','ATTBONUS_HUMAN','ATTBONUS_ANIMAL','ATTBONUS_ORC','ATTBONUS_MILGYO','ATTBONUS_UNDEAD','ATTBONUS_DEVIL','STEAL_HP','STEAL_SP','MANA_BURN_PCT','DAMAGE_SP_RECOVER','BLOCK','DODGE','RESIST_SWORD','RESIST_TWOHAND','RESIST_DAGGER','RESIST_BELL','RESIST_FAN','RESIST_BOW','RESIST_FIRE','RESIST_ELEC','RESIST_MAGIC','RESIST_WIND','REFLECT_MELEE','REFLECT_CURSE','POISON_REDUCE','KILL_SP_RECOVER','EXP_DOUBLE_BONUS','GOLD_DOUBLE_BONUS','ITEM_DROP_BONUS','POTION_BONUS','KILL_HP_RECOVER','IMMUNE_STUN','IMMUNE_SLOW','IMMUNE_FALL','SKILL','BOW_DISTANCE','ATT_GRADE_BONUS','DEF_GRADE_BONUS','MAGIC_ATT_GRADE_BONUS','MAGIC_DEF_GRADE_BONUS','CURSE_PCT','MAX_STAMINA','ATT_BONUS_TO_WARRIOR','ATT_BONUS_TO_ASSASSIN','ATT_BONUS_TO_SURA','ATT_BONUS_TO_SHAMAN','ATT_BONUS_TO_MONSTER','ATT_BONUS','MALL_DEFBONUS','MALL_EXPBONUS','MALL_ITEMBONUS','MALL_GOLDBONUS','MAX_HP_PCT','MAX_SP_PCT','SKILL_DAMAGE_BONUS','NORMAL_HIT_DAMAGE_BONUS','SKILL_DEFEND_BONUS','NORMAL_HIT_DEFEND_BONUS','PC_BANG_EXP_BONUS','PC_BANG_DROP_BONUS','EXTRACT_HP_PCT','RESIST_WARRIOR','RESIST_ASSASSIN','RESIST_SURA','RESIST_SHAMAN','ENERGY','DEF_GRADE','COSTUME_ATTR_BONUS','MAGIC_ATT_BONUS_PER','MELEE_MAGIC_ATT_BONUS_PER','RESIST_ICE','RESIST_EARTH','RESIST_DARK','RESIST_CRITICAL','RESIST_PENETRATE','BLEEDING_REDUCE','BLEEDING_PCT','ATT_BONUS_TO_WOLFMAN','RESIST_WOLFMAN','RESIST_CLAW') NOT NULL DEFAULT 'MAX_HP',
  `prob` int(11) unsigned NOT NULL DEFAULT 0,
  `lv1` int(11) unsigned NOT NULL DEFAULT 0,
  `lv2` int(11) unsigned NOT NULL DEFAULT 0,
  `lv3` int(11) unsigned NOT NULL DEFAULT 0,
  `lv4` int(11) unsigned NOT NULL DEFAULT 0,
  `lv5` int(11) unsigned NOT NULL DEFAULT 0,
  `weapon` int(11) unsigned NOT NULL DEFAULT 0,
  `body` int(11) unsigned NOT NULL DEFAULT 0,
  `wrist` int(11) unsigned NOT NULL DEFAULT 0,
  `foots` int(11) unsigned NOT NULL DEFAULT 0,
  `neck` int(11) unsigned NOT NULL DEFAULT 0,
  `head` int(11) unsigned NOT NULL DEFAULT 0,
  `shield` int(11) unsigned NOT NULL DEFAULT 0,
  `ear` int(11) unsigned NOT NULL DEFAULT 0,
  `costume_body` int(11) unsigned NOT NULL DEFAULT 0,
  `costume_hair` int(11) unsigned NOT NULL DEFAULT 0,
  `costume_weapon` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`apply`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.item_attr_rare
CREATE TABLE IF NOT EXISTS `item_attr_rare` (
  `apply` enum('MAX_HP','MAX_SP','CON','INT','STR','DEX','ATT_SPEED','MOV_SPEED','CAST_SPEED','HP_REGEN','SP_REGEN','POISON_PCT','STUN_PCT','SLOW_PCT','CRITICAL_PCT','PENETRATE_PCT','ATTBONUS_HUMAN','ATTBONUS_ANIMAL','ATTBONUS_ORC','ATTBONUS_MILGYO','ATTBONUS_UNDEAD','ATTBONUS_DEVIL','STEAL_HP','STEAL_SP','MANA_BURN_PCT','DAMAGE_SP_RECOVER','BLOCK','DODGE','RESIST_SWORD','RESIST_TWOHAND','RESIST_DAGGER','RESIST_BELL','RESIST_FAN','RESIST_BOW','RESIST_FIRE','RESIST_ELEC','RESIST_MAGIC','RESIST_WIND','REFLECT_MELEE','REFLECT_CURSE','POISON_REDUCE','KILL_SP_RECOVER','EXP_DOUBLE_BONUS','GOLD_DOUBLE_BONUS','ITEM_DROP_BONUS','POTION_BONUS','KILL_HP_RECOVER','IMMUNE_STUN','IMMUNE_SLOW','IMMUNE_FALL','SKILL','BOW_DISTANCE','ATT_GRADE_BONUS','DEF_GRADE_BONUS','MAGIC_ATT_GRADE_BONUS','MAGIC_DEF_GRADE_BONUS','CURSE_PCT','MAX_STAMINA','ATT_BONUS_TO_WARRIOR','ATT_BONUS_TO_ASSASSIN','ATT_BONUS_TO_SURA','ATT_BONUS_TO_SHAMAN','ATT_BONUS_TO_MONSTER','ATT_BONUS','MALL_DEFBONUS','MALL_EXPBONUS','MALL_ITEMBONUS','MALL_GOLDBONUS','MAX_HP_PCT','MAX_SP_PCT','SKILL_DAMAGE_BONUS','NORMAL_HIT_DAMAGE_BONUS','SKILL_DEFEND_BONUS','NORMAL_HIT_DEFEND_BONUS','PC_BANG_EXP_BONUS','PC_BANG_DROP_BONUS','EXTRACT_HP_PCT','RESIST_WARRIOR','RESIST_ASSASSIN','RESIST_SURA','RESIST_SHAMAN','ENERGY','DEF_GRADE','COSTUME_ATTR_BONUS','MAGIC_ATT_BONUS_PER','MELEE_MAGIC_ATT_BONUS_PER','RESIST_ICE','RESIST_EARTH','RESIST_DARK','RESIST_CRITICAL','RESIST_PENETRATE','BLEEDING_REDUCE','BLEEDING_PCT','ATT_BONUS_TO_WOLFMAN','RESIST_WOLFMAN','RESIST_CLAW') NOT NULL DEFAULT 'MAX_HP',
  `prob` int(11) unsigned NOT NULL DEFAULT 0,
  `lv1` int(11) unsigned NOT NULL DEFAULT 0,
  `lv2` int(11) unsigned NOT NULL DEFAULT 0,
  `lv3` int(11) unsigned NOT NULL DEFAULT 0,
  `lv4` int(11) unsigned NOT NULL DEFAULT 0,
  `lv5` int(11) unsigned NOT NULL DEFAULT 0,
  `weapon` int(11) unsigned NOT NULL DEFAULT 0,
  `body` int(11) unsigned NOT NULL DEFAULT 0,
  `wrist` int(11) unsigned NOT NULL DEFAULT 0,
  `foots` int(11) unsigned NOT NULL DEFAULT 0,
  `neck` int(11) unsigned NOT NULL DEFAULT 0,
  `head` int(11) unsigned NOT NULL DEFAULT 0,
  `shield` int(11) unsigned NOT NULL DEFAULT 0,
  `ear` int(11) unsigned NOT NULL DEFAULT 0,
  `costume_body` int(11) unsigned NOT NULL DEFAULT 0,
  `costume_hair` int(11) unsigned NOT NULL DEFAULT 0,
  `costume_weapon` int(11) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`apply`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.item_award
CREATE TABLE IF NOT EXISTS `item_award` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `login` varchar(16) NOT NULL DEFAULT '' COMMENT 'LOGIN_MAX_LEN=30',
  `vnum` int(6) unsigned NOT NULL DEFAULT 0,
  `count` int(10) unsigned NOT NULL DEFAULT 0,
  `given_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `taken_time` datetime DEFAULT NULL,
  `item_id` int(11) unsigned DEFAULT NULL,
  `why` varchar(128) DEFAULT NULL,
  `socket0` int(11) unsigned NOT NULL DEFAULT 0,
  `socket1` int(11) unsigned NOT NULL DEFAULT 0,
  `socket2` int(11) unsigned NOT NULL DEFAULT 0,
  `mall` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `pid_idx` (`pid`),
  KEY `given_time_idx` (`given_time`),
  KEY `taken_time_idx` (`taken_time`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.item_proto
CREATE TABLE IF NOT EXISTS `item_proto` (
  `vnum` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL DEFAULT 'Noname',
  `locale_name` varchar(50) NOT NULL DEFAULT 'Noname',
  `type` tinyint(2) NOT NULL DEFAULT 0,
  `subtype` tinyint(2) NOT NULL DEFAULT 0,
  `weight` tinyint(3) DEFAULT 0,
  `size` tinyint(3) DEFAULT 0,
  `antiflag` int(11) unsigned DEFAULT 0,
  `flag` int(11) unsigned DEFAULT 0,
  `wearflag` int(11) unsigned DEFAULT 0,
  `immuneflag` set('PARA','CURSE','STUN','SLEEP','SLOW','POISON','TERROR') NOT NULL DEFAULT '',
  `gold` int(11) DEFAULT 0,
  `shop_buy_price` int(10) unsigned NOT NULL DEFAULT 0,
  `refined_vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `refine_set` smallint(11) unsigned NOT NULL DEFAULT 0,
  `refine_set2` smallint(5) unsigned NOT NULL DEFAULT 0,
  `magic_pct` tinyint(4) NOT NULL DEFAULT 0,
  `limittype0` tinyint(4) DEFAULT 0,
  `limitvalue0` int(11) DEFAULT 0,
  `limittype1` tinyint(4) DEFAULT 0,
  `limitvalue1` int(11) DEFAULT 0,
  `applytype0` tinyint(4) DEFAULT 0,
  `applyvalue0` int(11) DEFAULT 0,
  `applytype1` tinyint(4) DEFAULT 0,
  `applyvalue1` int(11) DEFAULT 0,
  `applytype2` tinyint(4) DEFAULT 0,
  `applyvalue2` int(11) DEFAULT 0,
  `value0` int(11) DEFAULT 0,
  `value1` int(11) DEFAULT 0,
  `value2` int(11) DEFAULT 0,
  `value3` int(11) DEFAULT 0,
  `value4` int(11) DEFAULT 0,
  `value5` int(11) DEFAULT 0,
  `socket0` tinyint(4) DEFAULT -1,
  `socket1` tinyint(4) DEFAULT -1,
  `socket2` tinyint(4) DEFAULT -1,
  `socket3` tinyint(4) DEFAULT -1,
  `socket4` tinyint(4) DEFAULT -1,
  `socket5` tinyint(4) DEFAULT -1,
  `specular` tinyint(4) NOT NULL DEFAULT 0,
  `socket_pct` tinyint(4) NOT NULL DEFAULT 0,
  `addon_type` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`vnum`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.item_proto_old_meritocracy
CREATE TABLE IF NOT EXISTS `item_proto_old_meritocracy` (
  `vnum` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(50) NOT NULL DEFAULT 'Noname',
  `locale_name` varchar(50) NOT NULL DEFAULT 'Noname',
  `type` tinyint(2) NOT NULL DEFAULT 0,
  `subtype` tinyint(2) NOT NULL DEFAULT 0,
  `weight` tinyint(3) DEFAULT 0,
  `size` tinyint(3) DEFAULT 0,
  `antiflag` int(11) unsigned DEFAULT 0,
  `flag` int(11) unsigned DEFAULT 0,
  `wearflag` int(11) unsigned DEFAULT 0,
  `immuneflag` set('PARA','CURSE','STUN','SLEEP','SLOW','POISON','TERROR') NOT NULL DEFAULT '',
  `gold` int(11) DEFAULT 0,
  `shop_buy_price` int(10) unsigned NOT NULL DEFAULT 0,
  `refined_vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `refine_set` smallint(11) unsigned NOT NULL DEFAULT 0,
  `refine_set2` smallint(5) unsigned NOT NULL DEFAULT 0,
  `magic_pct` tinyint(4) NOT NULL DEFAULT 0,
  `limittype0` tinyint(4) DEFAULT 0,
  `limitvalue0` int(11) DEFAULT 0,
  `limittype1` tinyint(4) DEFAULT 0,
  `limitvalue1` int(11) DEFAULT 0,
  `applytype0` tinyint(4) DEFAULT 0,
  `applyvalue0` int(11) DEFAULT 0,
  `applytype1` tinyint(4) DEFAULT 0,
  `applyvalue1` int(11) DEFAULT 0,
  `applytype2` tinyint(4) DEFAULT 0,
  `applyvalue2` int(11) DEFAULT 0,
  `value0` int(11) DEFAULT 0,
  `value1` int(11) DEFAULT 0,
  `value2` int(11) DEFAULT 0,
  `value3` int(11) DEFAULT 0,
  `value4` int(11) DEFAULT 0,
  `value5` int(11) DEFAULT 0,
  `socket0` tinyint(4) DEFAULT -1,
  `socket1` tinyint(4) DEFAULT -1,
  `socket2` tinyint(4) DEFAULT -1,
  `socket3` tinyint(4) DEFAULT -1,
  `socket4` tinyint(4) DEFAULT -1,
  `socket5` tinyint(4) DEFAULT -1,
  `specular` tinyint(4) NOT NULL DEFAULT 0,
  `socket_pct` tinyint(4) NOT NULL DEFAULT 0,
  `addon_type` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`vnum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.land
CREATE TABLE IF NOT EXISTS `land` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `map_index` int(11) unsigned NOT NULL DEFAULT 0,
  `x` int(11) unsigned NOT NULL DEFAULT 0,
  `y` int(11) unsigned NOT NULL DEFAULT 0,
  `width` int(11) unsigned NOT NULL DEFAULT 0,
  `height` int(11) unsigned NOT NULL DEFAULT 0,
  `guild_id` int(10) unsigned NOT NULL DEFAULT 0,
  `guild_level_limit` tinyint(4) unsigned NOT NULL DEFAULT 0,
  `price` int(10) unsigned NOT NULL DEFAULT 0,
  `enable` enum('YES','NO') NOT NULL DEFAULT 'NO',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=293 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.lotto_list
CREATE TABLE IF NOT EXISTS `lotto_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `server` varchar(56) DEFAULT NULL COMMENT 'server%s=get_table_postfix(); std::string so dunno; at least 6',
  `pid` int(10) unsigned DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.marriage
CREATE TABLE IF NOT EXISTS `marriage` (
  `is_married` tinyint(4) NOT NULL DEFAULT 0,
  `pid1` int(10) unsigned NOT NULL DEFAULT 0,
  `pid2` int(10) unsigned NOT NULL DEFAULT 0,
  `love_point` int(11) unsigned DEFAULT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`pid1`,`pid2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.messenger_list
CREATE TABLE IF NOT EXISTS `messenger_list` (
  `account` varchar(16) NOT NULL DEFAULT '' COMMENT '24 at maximum',
  `companion` varchar(16) NOT NULL DEFAULT '' COMMENT '24 at maximum',
  PRIMARY KEY (`account`,`companion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.mob_proto
CREATE TABLE IF NOT EXISTS `mob_proto` (
  `vnum` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(24) NOT NULL DEFAULT 'Noname',
  `locale_name` varchar(50) NOT NULL DEFAULT 'Noname',
  `rank` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `type` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `battle_type` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `level` smallint(3) unsigned NOT NULL DEFAULT 1,
  `size` enum('SMALL','MEDIUM','BIG') NOT NULL DEFAULT 'SMALL',
  `ai_flag` set('AGGR','NOMOVE','COWARD','NOATTSHINSU','NOATTCHUNJO','NOATTJINNO','ATTMOB','BERSERK','STONESKIN','GODSPEED','DEATHBLOW','REVIVE') DEFAULT NULL,
  `mount_capacity` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `setRaceFlag` set('ANIMAL','UNDEAD','DEVIL','HUMAN','ORC','MILGYO','INSECT','FIRE','ICE','DESERT','TREE','ATT_ELEC','ATT_FIRE','ATT_ICE','ATT_WIND','ATT_EARTH','ATT_DARK') NOT NULL DEFAULT '',
  `setImmuneFlag` set('STUN','SLOW','FALL','CURSE','POISON','TERROR','REFLECT') NOT NULL DEFAULT '',
  `empire` tinyint(4) unsigned NOT NULL DEFAULT 0,
  `folder` varchar(100) NOT NULL DEFAULT '',
  `on_click` tinyint(4) unsigned NOT NULL DEFAULT 0,
  `st` smallint(5) unsigned NOT NULL DEFAULT 0,
  `dx` smallint(5) unsigned NOT NULL DEFAULT 0,
  `ht` smallint(5) unsigned NOT NULL DEFAULT 0,
  `iq` smallint(5) unsigned NOT NULL DEFAULT 0,
  `damage_min` smallint(5) unsigned NOT NULL DEFAULT 0,
  `damage_max` smallint(5) unsigned NOT NULL DEFAULT 0,
  `max_hp` int(10) unsigned NOT NULL DEFAULT 0,
  `regen_cycle` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `regen_percent` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `gold_min` int(11) NOT NULL DEFAULT 0,
  `gold_max` int(11) NOT NULL DEFAULT 0,
  `exp` int(10) unsigned NOT NULL DEFAULT 0,
  `def` smallint(5) unsigned NOT NULL DEFAULT 0,
  `attack_speed` smallint(6) unsigned NOT NULL DEFAULT 100,
  `move_speed` smallint(6) unsigned NOT NULL DEFAULT 100,
  `aggressive_hp_pct` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `aggressive_sight` smallint(10) unsigned NOT NULL DEFAULT 0,
  `attack_range` smallint(5) unsigned NOT NULL DEFAULT 0,
  `drop_item` int(10) unsigned NOT NULL DEFAULT 0,
  `resurrection_vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `enchant_curse` tinyint(4) unsigned NOT NULL DEFAULT 0,
  `enchant_slow` tinyint(4) unsigned NOT NULL DEFAULT 0,
  `enchant_poison` tinyint(4) unsigned NOT NULL DEFAULT 0,
  `enchant_stun` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `enchant_critical` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `enchant_penetrate` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `resist_sword` tinyint(4) NOT NULL DEFAULT 0,
  `resist_twohand` tinyint(4) NOT NULL DEFAULT 0,
  `resist_dagger` tinyint(4) NOT NULL DEFAULT 0,
  `resist_bell` tinyint(4) NOT NULL DEFAULT 0,
  `resist_fan` tinyint(4) NOT NULL DEFAULT 0,
  `resist_bow` tinyint(4) NOT NULL DEFAULT 0,
  `resist_fire` tinyint(4) NOT NULL DEFAULT 0,
  `resist_elect` tinyint(4) NOT NULL DEFAULT 0,
  `resist_magic` tinyint(4) NOT NULL DEFAULT 0,
  `resist_wind` tinyint(4) NOT NULL DEFAULT 0,
  `resist_poison` tinyint(4) NOT NULL DEFAULT 0,
  `dam_multiply` float DEFAULT NULL,
  `summon` int(11) DEFAULT NULL,
  `drain_sp` int(11) DEFAULT NULL,
  `mob_color` int(10) unsigned DEFAULT NULL,
  `polymorph_item` int(10) unsigned NOT NULL DEFAULT 0,
  `skill_level0` tinyint(3) unsigned DEFAULT NULL,
  `skill_vnum0` int(10) unsigned DEFAULT NULL,
  `skill_level1` tinyint(3) unsigned DEFAULT NULL,
  `skill_vnum1` int(10) unsigned DEFAULT NULL,
  `skill_level2` tinyint(3) unsigned DEFAULT NULL,
  `skill_vnum2` int(10) unsigned DEFAULT NULL,
  `skill_level3` tinyint(3) unsigned DEFAULT NULL,
  `skill_vnum3` int(10) unsigned DEFAULT NULL,
  `skill_level4` tinyint(3) unsigned DEFAULT NULL,
  `skill_vnum4` int(10) unsigned DEFAULT NULL,
  `sp_berserk` tinyint(4) NOT NULL DEFAULT 0,
  `sp_stoneskin` tinyint(4) NOT NULL DEFAULT 0,
  `sp_godspeed` tinyint(4) NOT NULL DEFAULT 0,
  `sp_deathblow` tinyint(4) NOT NULL DEFAULT 0,
  `sp_revive` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`vnum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.monarch
CREATE TABLE IF NOT EXISTS `monarch` (
  `empire` int(10) unsigned NOT NULL DEFAULT 0,
  `pid` int(10) unsigned DEFAULT NULL,
  `windate` datetime DEFAULT NULL,
  `money` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`empire`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.monarch_candidacy
CREATE TABLE IF NOT EXISTS `monarch_candidacy` (
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `date` datetime DEFAULT '0000-00-00 00:00:00',
  `name` varchar(16) DEFAULT NULL,
  `windate` datetime DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.monarch_election
CREATE TABLE IF NOT EXISTS `monarch_election` (
  `pid` int(10) unsigned NOT NULL DEFAULT 0,
  `selectedpid` int(10) unsigned DEFAULT 0,
  `electiondata` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.myshop_pricelist
CREATE TABLE IF NOT EXISTS `myshop_pricelist` (
  `owner_id` int(11) unsigned NOT NULL DEFAULT 0,
  `item_vnum` int(11) unsigned NOT NULL DEFAULT 0,
  `price` int(10) unsigned NOT NULL DEFAULT 0,
  UNIQUE KEY `list_id` (`owner_id`,`item_vnum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.object
CREATE TABLE IF NOT EXISTS `object` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `land_id` int(11) unsigned NOT NULL DEFAULT 0,
  `vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `map_index` int(11) unsigned NOT NULL DEFAULT 0,
  `x` int(11) NOT NULL DEFAULT 0,
  `y` int(11) NOT NULL DEFAULT 0,
  `x_rot` float NOT NULL DEFAULT 0,
  `y_rot` float NOT NULL DEFAULT 0,
  `z_rot` float NOT NULL DEFAULT 0,
  `life` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.object_proto
CREATE TABLE IF NOT EXISTS `object_proto` (
  `vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `name` varchar(32) NOT NULL DEFAULT '',
  `price` int(10) unsigned NOT NULL DEFAULT 0,
  `materials` varchar(64) NOT NULL DEFAULT '',
  `upgrade_vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `upgrade_limit_time` int(10) unsigned NOT NULL DEFAULT 0,
  `life` int(11) NOT NULL DEFAULT 0,
  `reg_1` int(11) NOT NULL DEFAULT 0,
  `reg_2` int(11) NOT NULL DEFAULT 0,
  `reg_3` int(11) NOT NULL DEFAULT 0,
  `reg_4` int(11) NOT NULL DEFAULT 0,
  `npc` int(10) unsigned NOT NULL DEFAULT 0,
  `group_vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `dependent_group` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`vnum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.offline_shop_item
CREATE TABLE IF NOT EXISTS `offline_shop_item` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) unsigned NOT NULL DEFAULT 0,
  `pos` smallint(5) unsigned NOT NULL DEFAULT 0,
  `count` int(10) unsigned NOT NULL DEFAULT 0,
  `vnum` int(11) unsigned NOT NULL DEFAULT 0,
  `socket0` int(10) unsigned NOT NULL DEFAULT 0,
  `socket1` int(10) unsigned NOT NULL DEFAULT 0,
  `socket2` int(10) unsigned NOT NULL DEFAULT 0,
  `socket3` int(10) unsigned NOT NULL DEFAULT 0,
  `socket4` int(10) unsigned NOT NULL DEFAULT 0,
  `socket5` int(10) unsigned NOT NULL DEFAULT 0,
  `attrtype0` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue0` smallint(6) NOT NULL DEFAULT 0,
  `attrtype1` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue1` smallint(6) NOT NULL DEFAULT 0,
  `attrtype2` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue2` smallint(6) NOT NULL DEFAULT 0,
  `attrtype3` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue3` smallint(6) NOT NULL DEFAULT 0,
  `attrtype4` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue4` smallint(6) NOT NULL DEFAULT 0,
  `attrtype5` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue5` smallint(6) NOT NULL DEFAULT 0,
  `attrtype6` tinyint(4) NOT NULL DEFAULT 0,
  `attrvalue6` smallint(6) NOT NULL DEFAULT 0,
  `applytype0` tinyint(4) NOT NULL DEFAULT 0,
  `applyvalue0` smallint(6) NOT NULL DEFAULT 0,
  `applytype1` tinyint(4) NOT NULL DEFAULT 0,
  `applyvalue1` smallint(6) NOT NULL DEFAULT 0,
  `applytype2` tinyint(4) NOT NULL DEFAULT 0,
  `applyvalue2` smallint(6) NOT NULL DEFAULT 0,
  `applytype3` int(11) NOT NULL DEFAULT 0,
  `applyvalue3` int(11) NOT NULL DEFAULT 0,
  `applytype4` int(11) NOT NULL DEFAULT 0,
  `applyvalue4` int(11) NOT NULL DEFAULT 0,
  `applytype5` int(11) NOT NULL DEFAULT 0,
  `applyvalue5` int(11) NOT NULL DEFAULT 0,
  `applytype6` int(11) NOT NULL DEFAULT 0,
  `applyvalue6` int(11) NOT NULL DEFAULT 0,
  `applytype7` int(11) NOT NULL DEFAULT 0,
  `applyvalue7` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `status` smallint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `owner_id_idx` (`owner_id`),
  KEY `item_vnum_index` (`vnum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.offline_shop_npc
CREATE TABLE IF NOT EXISTS `offline_shop_npc` (
  `owner_id` int(11) NOT NULL DEFAULT 0,
  `sign` varchar(32) DEFAULT NULL,
  `name` varchar(32) DEFAULT NULL,
  `time` int(11) DEFAULT 24,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `z` int(11) DEFAULT NULL,
  `mapIndex` int(11) DEFAULT NULL,
  `channel` int(2) DEFAULT NULL,
  PRIMARY KEY (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.pcbang_ip
CREATE TABLE IF NOT EXISTS `pcbang_ip` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pcbang_id` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(15) NOT NULL DEFAULT '000.000.000.000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`),
  KEY `pcbang_id` (`pcbang_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.player
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(24) NOT NULL DEFAULT 'NONAME',
  `job` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `voice` tinyint(1) NOT NULL DEFAULT 0,
  `dir` tinyint(2) NOT NULL DEFAULT 0,
  `x` int(11) NOT NULL DEFAULT 0,
  `y` int(11) NOT NULL DEFAULT 0,
  `z` int(11) NOT NULL DEFAULT 0,
  `map_index` int(11) NOT NULL DEFAULT 0,
  `exit_x` int(11) NOT NULL DEFAULT 0,
  `exit_y` int(11) NOT NULL DEFAULT 0,
  `exit_map_index` int(11) NOT NULL DEFAULT 0,
  `hp` int(11) NOT NULL DEFAULT 0,
  `mp` int(11) NOT NULL DEFAULT 0,
  `stamina` smallint(6) NOT NULL DEFAULT 0,
  `random_hp` smallint(5) unsigned NOT NULL DEFAULT 0,
  `random_sp` smallint(5) unsigned NOT NULL DEFAULT 0,
  `playtime` int(11) NOT NULL DEFAULT 0,
  `level` tinyint(2) unsigned NOT NULL DEFAULT 1,
  `level_step` tinyint(1) NOT NULL DEFAULT 0,
  `st` smallint(3) NOT NULL DEFAULT 0,
  `ht` smallint(3) NOT NULL DEFAULT 0,
  `dx` smallint(3) NOT NULL DEFAULT 0,
  `iq` smallint(3) NOT NULL DEFAULT 0,
  `exp` bigint(20) NOT NULL DEFAULT 0,
  `gold` int(11) NOT NULL DEFAULT 0,
  `stat_point` smallint(3) NOT NULL DEFAULT 0,
  `skill_point` smallint(3) NOT NULL DEFAULT 0,
  `quickslot` tinyblob DEFAULT NULL,
  `ip` varchar(15) DEFAULT '0.0.0.0',
  `part_main` mediumint(6) NOT NULL DEFAULT 0,
  `part_base` tinyint(4) NOT NULL DEFAULT 0,
  `part_hair` mediumint(4) NOT NULL DEFAULT 0,
  `part_acce` int(5) unsigned NOT NULL,
  `skill_group` tinyint(4) NOT NULL DEFAULT 0,
  `skill_level` blob DEFAULT NULL,
  `alignment` int(11) NOT NULL DEFAULT 0,
  `last_play` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `change_name` tinyint(1) NOT NULL DEFAULT 0,
  `mobile` varchar(24) DEFAULT NULL,
  `sub_skill_point` smallint(3) NOT NULL DEFAULT 0,
  `stat_reset_count` tinyint(4) NOT NULL DEFAULT 0,
  `horse_hp` smallint(4) NOT NULL DEFAULT 0,
  `horse_stamina` smallint(4) NOT NULL DEFAULT 0,
  `horse_level` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `horse_hp_droptime` int(10) unsigned NOT NULL DEFAULT 0,
  `horse_riding` tinyint(1) NOT NULL DEFAULT 0,
  `horse_skill_point` smallint(3) NOT NULL DEFAULT 0,
  `meriti` int(11) NOT NULL DEFAULT 0,
  `warpoints` int(11) NOT NULL DEFAULT 0,
  `mmr` int(11) NOT NULL DEFAULT 750,
  `afk_level` int(11) NOT NULL DEFAULT 0,
  `won` int(11) NOT NULL DEFAULT 0,
  `money` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `account_id_idx` (`account_id`),
  KEY `name_idx` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=3540 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.player2
CREATE TABLE IF NOT EXISTS `player2` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(24) NOT NULL DEFAULT 'NONAME',
  `job` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `voice` tinyint(1) NOT NULL DEFAULT 0,
  `dir` tinyint(2) NOT NULL DEFAULT 0,
  `x` int(11) NOT NULL DEFAULT 0,
  `y` int(11) NOT NULL DEFAULT 0,
  `z` int(11) NOT NULL DEFAULT 0,
  `map_index` int(11) NOT NULL DEFAULT 0,
  `exit_x` int(11) NOT NULL DEFAULT 0,
  `exit_y` int(11) NOT NULL DEFAULT 0,
  `exit_map_index` int(11) NOT NULL DEFAULT 0,
  `hp` int(11) NOT NULL DEFAULT 0,
  `mp` int(11) NOT NULL DEFAULT 0,
  `stamina` smallint(6) NOT NULL DEFAULT 0,
  `random_hp` smallint(5) unsigned NOT NULL DEFAULT 0,
  `random_sp` smallint(5) unsigned NOT NULL DEFAULT 0,
  `playtime` int(11) NOT NULL DEFAULT 0,
  `level` tinyint(2) unsigned NOT NULL DEFAULT 1,
  `level_step` tinyint(1) NOT NULL DEFAULT 0,
  `st` smallint(3) NOT NULL DEFAULT 0,
  `ht` smallint(3) NOT NULL DEFAULT 0,
  `dx` smallint(3) NOT NULL DEFAULT 0,
  `iq` smallint(3) NOT NULL DEFAULT 0,
  `exp` int(11) NOT NULL DEFAULT 0,
  `gold` int(11) NOT NULL DEFAULT 0,
  `stat_point` smallint(3) NOT NULL DEFAULT 0,
  `skill_point` smallint(3) NOT NULL DEFAULT 0,
  `quickslot` tinyblob DEFAULT NULL,
  `ip` varchar(15) DEFAULT '0.0.0.0',
  `part_main` mediumint(6) NOT NULL DEFAULT 0,
  `part_base` tinyint(4) NOT NULL DEFAULT 0,
  `part_hair` mediumint(4) NOT NULL DEFAULT 0,
  `part_acce` smallint(4) unsigned NOT NULL DEFAULT 0,
  `skill_group` tinyint(4) NOT NULL DEFAULT 0,
  `skill_level` blob DEFAULT NULL,
  `alignment` int(11) NOT NULL DEFAULT 0,
  `last_play` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `change_name` tinyint(1) NOT NULL DEFAULT 0,
  `mobile` varchar(24) DEFAULT NULL,
  `sub_skill_point` smallint(3) NOT NULL DEFAULT 0,
  `stat_reset_count` tinyint(4) NOT NULL DEFAULT 0,
  `horse_hp` smallint(4) NOT NULL DEFAULT 0,
  `horse_stamina` smallint(4) NOT NULL DEFAULT 0,
  `horse_level` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `horse_hp_droptime` int(10) unsigned NOT NULL DEFAULT 0,
  `horse_riding` tinyint(1) NOT NULL DEFAULT 0,
  `horse_skill_point` smallint(3) NOT NULL DEFAULT 0,
  `meriti` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `account_id_idx` (`account_id`),
  KEY `name_idx` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=20001 DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.player_deleted
CREATE TABLE IF NOT EXISTS `player_deleted` (
  `id` int(11) unsigned NOT NULL,
  `account_id` int(11) unsigned NOT NULL DEFAULT 0,
  `name` varchar(24) NOT NULL DEFAULT 'NONAME',
  `job` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `voice` tinyint(1) NOT NULL DEFAULT 0,
  `dir` tinyint(2) NOT NULL DEFAULT 0,
  `x` int(11) NOT NULL DEFAULT 0,
  `y` int(11) NOT NULL DEFAULT 0,
  `z` int(11) NOT NULL DEFAULT 0,
  `map_index` int(11) NOT NULL DEFAULT 0,
  `exit_x` int(11) NOT NULL DEFAULT 0,
  `exit_y` int(11) NOT NULL DEFAULT 0,
  `exit_map_index` int(11) NOT NULL DEFAULT 0,
  `hp` smallint(4) NOT NULL DEFAULT 0,
  `mp` smallint(4) NOT NULL DEFAULT 0,
  `stamina` smallint(6) NOT NULL DEFAULT 0,
  `random_hp` smallint(5) unsigned NOT NULL DEFAULT 0,
  `random_sp` smallint(5) unsigned NOT NULL DEFAULT 0,
  `playtime` int(11) NOT NULL DEFAULT 0,
  `level` tinyint(2) unsigned NOT NULL DEFAULT 1,
  `level_step` tinyint(1) NOT NULL DEFAULT 0,
  `st` smallint(3) NOT NULL DEFAULT 0,
  `ht` smallint(3) NOT NULL DEFAULT 0,
  `dx` smallint(3) NOT NULL DEFAULT 0,
  `iq` smallint(3) NOT NULL DEFAULT 0,
  `exp` int(11) NOT NULL DEFAULT 0,
  `gold` int(11) NOT NULL DEFAULT 0,
  `stat_point` smallint(3) NOT NULL DEFAULT 0,
  `skill_point` smallint(3) NOT NULL DEFAULT 0,
  `quickslot` tinyblob DEFAULT NULL,
  `ip` varchar(15) DEFAULT '0.0.0.0',
  `part_main` mediumint(6) NOT NULL DEFAULT 0,
  `part_base` tinyint(4) NOT NULL DEFAULT 0,
  `part_hair` mediumint(4) NOT NULL DEFAULT 0,
  `part_acce` int(5) unsigned NOT NULL DEFAULT 0,
  `skill_group` tinyint(4) NOT NULL DEFAULT 0,
  `skill_level` blob DEFAULT NULL,
  `alignment` int(11) NOT NULL DEFAULT 0,
  `last_play` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `change_name` tinyint(1) NOT NULL DEFAULT 0,
  `mobile` varchar(24) DEFAULT NULL,
  `sub_skill_point` smallint(3) NOT NULL DEFAULT 0,
  `stat_reset_count` tinyint(4) NOT NULL DEFAULT 0,
  `horse_hp` smallint(4) NOT NULL DEFAULT 0,
  `horse_stamina` smallint(4) NOT NULL DEFAULT 0,
  `horse_level` tinyint(2) unsigned NOT NULL DEFAULT 0,
  `horse_hp_droptime` int(10) unsigned NOT NULL DEFAULT 0,
  `horse_riding` tinyint(1) NOT NULL DEFAULT 0,
  `horse_skill_point` smallint(3) NOT NULL DEFAULT 0,
  `meriti` int(11) NOT NULL DEFAULT 0,
  `warpoints` int(11) NOT NULL DEFAULT 0,
  `mmr` int(11) NOT NULL DEFAULT 0,
  `afk_level` int(11) NOT NULL DEFAULT 0,
  `won` int(11) NOT NULL DEFAULT 0,
  `money` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.player_index
CREATE TABLE IF NOT EXISTS `player_index` (
  `id` int(11) unsigned NOT NULL DEFAULT 0,
  `pid1` int(11) unsigned NOT NULL DEFAULT 0,
  `pid2` int(11) unsigned NOT NULL DEFAULT 0,
  `pid3` int(11) unsigned NOT NULL DEFAULT 0,
  `pid4` int(11) unsigned NOT NULL DEFAULT 0,
  `pid5` int(10) unsigned NOT NULL DEFAULT 0,
  `empire` tinyint(4) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `pid1_key` (`pid1`),
  KEY `pid2_key` (`pid2`),
  KEY `pid3_key` (`pid3`),
  KEY `pid4_key` (`pid4`),
  KEY `pid5_key` (`pid5`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.quest
CREATE TABLE IF NOT EXISTS `quest` (
  `dwPID` int(10) unsigned NOT NULL DEFAULT 0,
  `szName` varchar(32) NOT NULL DEFAULT '',
  `szState` varchar(64) NOT NULL DEFAULT '',
  `lValue` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`dwPID`,`szName`,`szState`),
  KEY `pid_idx` (`dwPID`),
  KEY `name_idx` (`szName`),
  KEY `state_idx` (`szState`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.refine_proto
CREATE TABLE IF NOT EXISTS `refine_proto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(50) NOT NULL DEFAULT '0',
  `vnum0` int(10) unsigned NOT NULL DEFAULT 0,
  `count0` smallint(6) NOT NULL DEFAULT 0,
  `vnum1` int(10) unsigned NOT NULL DEFAULT 0,
  `count1` smallint(6) NOT NULL DEFAULT 0,
  `vnum2` int(10) unsigned NOT NULL DEFAULT 0,
  `count2` smallint(6) NOT NULL DEFAULT 0,
  `vnum3` int(10) unsigned NOT NULL DEFAULT 0,
  `count3` smallint(6) NOT NULL DEFAULT 0,
  `vnum4` int(10) unsigned NOT NULL DEFAULT 0,
  `count4` smallint(6) NOT NULL DEFAULT 0,
  `cost` int(11) NOT NULL DEFAULT 0,
  `src_vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `result_vnum` int(10) unsigned NOT NULL DEFAULT 0,
  `prob` smallint(6) NOT NULL DEFAULT 100,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=761 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.safebox
CREATE TABLE IF NOT EXISTS `safebox` (
  `account_id` int(10) unsigned NOT NULL DEFAULT 0,
  `size` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `password` varchar(6) NOT NULL DEFAULT '',
  `gold` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.shop
CREATE TABLE IF NOT EXISTS `shop` (
  `vnum` int(11) NOT NULL DEFAULT 0,
  `name` varchar(32) NOT NULL DEFAULT 'Noname',
  `npc_vnum` smallint(6) NOT NULL DEFAULT 0,
  PRIMARY KEY (`vnum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.shop_item
CREATE TABLE IF NOT EXISTS `shop_item` (
  `shop_vnum` int(11) NOT NULL DEFAULT 0,
  `item_vnum` int(11) NOT NULL DEFAULT 0,
  `count` smallint(5) unsigned NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.skill_proto
CREATE TABLE IF NOT EXISTS `skill_proto` (
  `dwVnum` int(11) NOT NULL DEFAULT 0,
  `szName` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `bType` tinyint(4) NOT NULL DEFAULT 0,
  `bLevelStep` tinyint(4) NOT NULL DEFAULT 0,
  `bMaxLevel` tinyint(4) NOT NULL DEFAULT 0,
  `bLevelLimit` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `szPointOn` enum('NONE','MAX_HP','MAX_SP','HP_REGEN','SP_REGEN','BLOCK','HP','SP','ATT_GRADE','DEF_GRADE','MAGIC_ATT_GRADE','MAGIC_DEF_GRADE','BOW_DISTANCE','MOV_SPEED','ATT_SPEED','POISON_PCT','RESIST_RANGE','RESIST_MELEE','CASTING_SPEED','REFLECT_MELEE','ATT_BONUS','DEF_BONUS','RESIST_NORMAL','DODGE','KILL_HP_RECOVER','KILL_SP_RECOVER','HIT_HP_RECOVER','HIT_SP_RECOVER','CRITICAL','MANASHIELD','SKILL_DAMAGE_BONUS','NORMAL_HIT_DAMAGE_BONUS','RESIST_CRITICAL','RESIST_PENETRATE') NOT NULL DEFAULT 'NONE',
  `szPointPoly` varchar(100) NOT NULL DEFAULT '',
  `szSPCostPoly` varchar(100) NOT NULL DEFAULT '',
  `szDurationPoly` varchar(100) NOT NULL DEFAULT '',
  `szDurationSPCostPoly` varchar(100) NOT NULL DEFAULT '',
  `szCooldownPoly` varchar(100) NOT NULL DEFAULT '',
  `szMasterBonusPoly` varchar(100) NOT NULL DEFAULT '',
  `szAttackGradePoly` varchar(100) NOT NULL DEFAULT '',
  `setFlag` set('ATTACK','USE_MELEE_DAMAGE','COMPUTE_ATTGRADE','SELFONLY','USE_MAGIC_DAMAGE','USE_HP_AS_COST','COMPUTE_MAGIC_DAMAGE','SPLASH','GIVE_PENALTY','USE_ARROW_DAMAGE','PENETRATE','IGNORE_TARGET_RATING','ATTACK_SLOW','ATTACK_STUN','HP_ABSORB','SP_ABSORB','ATTACK_FIRE_CONT','REMOVE_BAD_AFFECT','REMOVE_GOOD_AFFECT','CRUSH','ATTACK_POISON','TOGGLE','DISABLE_BY_POINT_UP','CRUSH_LONG','ATTACK_WIND','ATTACK_ELEC','ATTACK_FIRE','ATTACK_BLEEDING','PARTY','EUNHYUNG') NOT NULL DEFAULT '',
  `setAffectFlag` enum('YMIR','INVISIBILITY','SPAWN','POISON','SLOW','STUN','DUNGEON_READY','DUNGEON_UNIQUE','BUILDING_CONSTRUCTION_SMALL','BUILDING_CONSTRUCTION_LARGE','BUILDING_UPGRADE','MOV_SPEED_POTION','ATT_SPEED_POTION','FISH_MIND','JEONGWIHON','GEOMGYEONG','CHEONGEUN','GYEONGGONG','EUNHYUNG','GWIGUM','TERROR','JUMAGAP','HOSIN','BOHO','KWAESOK','MANASHIELD','MUYEONG','REVIVE_INVISIBLE','FIRE','GICHEON','JEUNGRYEOK','TANHWAN_DASH','PABEOP','CHEONGEUN_WITH_FALL','POLYMORPH','WAR_FLAG1','WAR_FLAG2','WAR_FLAG3','CHINA_FIREWORK','HAIR','GERMANY','RAMADAN_RING','BLEEDING','RED_POSSESSION','BLUE_POSSESSION') NOT NULL DEFAULT 'YMIR',
  `szPointOn2` enum('NONE','MAX_HP','MAX_SP','HP_REGEN','SP_REGEN','BLOCK','HP','SP','ATT_GRADE','DEF_GRADE','MAGIC_ATT_GRADE','MAGIC_DEF_GRADE','BOW_DISTANCE','MOV_SPEED','ATT_SPEED','POISON_PCT','RESIST_RANGE','RESIST_MELEE','CASTING_SPEED','REFLECT_MELEE','ATT_BONUS','DEF_BONUS','RESIST_NORMAL','DODGE','KILL_HP_RECOVER','KILL_SP_RECOVER','HIT_HP_RECOVER','HIT_SP_RECOVER','CRITICAL','MANASHIELD','SKILL_DAMAGE_BONUS','NORMAL_HIT_DAMAGE_BONUS','RESIST_CRITICAL','RESIST_PENETRATE') NOT NULL DEFAULT 'NONE',
  `szPointPoly2` varchar(100) NOT NULL DEFAULT '',
  `szDurationPoly2` varchar(100) NOT NULL DEFAULT '',
  `setAffectFlag2` enum('YMIR','INVISIBILITY','SPAWN','POISON','SLOW','STUN','DUNGEON_READY','DUNGEON_UNIQUE','BUILDING_CONSTRUCTION_SMALL','BUILDING_CONSTRUCTION_LARGE','BUILDING_UPGRADE','MOV_SPEED_POTION','ATT_SPEED_POTION','FISH_MIND','JEONGWIHON','GEOMGYEONG','CHEONGEUN','GYEONGGONG','EUNHYUNG','GWIGUM','TERROR','JUMAGAP','HOSIN','BOHO','KWAESOK','MANASHIELD','MUYEONG','REVIVE_INVISIBLE','FIRE','GICHEON','JEUNGRYEOK','TANHWAN_DASH','PABEOP','CHEONGEUN_WITH_FALL','POLYMORPH','WAR_FLAG1','WAR_FLAG2','WAR_FLAG3','CHINA_FIREWORK','HAIR','GERMANY','RAMADAN_RING','BLEEDING','RED_POSSESSION','BLUE_POSSESSION') NOT NULL DEFAULT 'YMIR',
  `szPointOn3` enum('NONE','MAX_HP','MAX_SP','HP_REGEN','SP_REGEN','BLOCK','HP','SP','ATT_GRADE','DEF_GRADE','MAGIC_ATT_GRADE','MAGIC_DEF_GRADE','BOW_DISTANCE','MOV_SPEED','ATT_SPEED','POISON_PCT','RESIST_RANGE','RESIST_MELEE','CASTING_SPEED','REFLECT_MELEE','ATT_BONUS','DEF_BONUS','RESIST_NORMAL','DODGE','KILL_HP_RECOVER','KILL_SP_RECOVER','HIT_HP_RECOVER','HIT_SP_RECOVER','CRITICAL','MANASHIELD','SKILL_DAMAGE_BONUS','NORMAL_HIT_DAMAGE_BONUS','RESIST_CRITICAL','RESIST_PENETRATE') NOT NULL DEFAULT 'NONE',
  `szPointPoly3` varchar(100) NOT NULL DEFAULT '',
  `szDurationPoly3` varchar(100) NOT NULL DEFAULT '',
  `szGrandMasterAddSPCostPoly` varchar(100) NOT NULL DEFAULT '',
  `prerequisiteSkillVnum` int(11) NOT NULL DEFAULT 0,
  `prerequisiteSkillLevel` int(11) NOT NULL DEFAULT 0,
  `eSkillType` enum('NORMAL','MELEE','RANGE','MAGIC') NOT NULL DEFAULT 'NORMAL',
  `iMaxHit` tinyint(4) NOT NULL DEFAULT 0,
  `szSplashAroundDamageAdjustPoly` varchar(100) NOT NULL DEFAULT '1',
  `dwTargetRange` int(11) NOT NULL DEFAULT 1000,
  `dwSplashRange` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`dwVnum`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.skill_proto_old
CREATE TABLE IF NOT EXISTS `skill_proto_old` (
  `dwVnum` int(11) NOT NULL DEFAULT 0,
  `szName` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `bType` tinyint(4) NOT NULL DEFAULT 0,
  `bLevelStep` tinyint(4) NOT NULL DEFAULT 0,
  `bMaxLevel` tinyint(4) NOT NULL DEFAULT 0,
  `bLevelLimit` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `szPointOn` enum('NONE','MAX_HP','MAX_SP','HP_REGEN','SP_REGEN','BLOCK','HP','SP','ATT_GRADE','DEF_GRADE','MAGIC_ATT_GRADE','MAGIC_DEF_GRADE','BOW_DISTANCE','MOV_SPEED','ATT_SPEED','POISON_PCT','RESIST_RANGE','RESIST_MELEE','CASTING_SPEED','REFLECT_MELEE','ATT_BONUS','DEF_BONUS','RESIST_NORMAL','DODGE','KILL_HP_RECOVER','KILL_SP_RECOVER','HIT_HP_RECOVER','HIT_SP_RECOVER','CRITICAL','MANASHIELD','SKILL_DAMAGE_BONUS','NORMAL_HIT_DAMAGE_BONUS') NOT NULL DEFAULT 'NONE',
  `szPointPoly` varchar(100) NOT NULL DEFAULT '',
  `szSPCostPoly` varchar(100) NOT NULL DEFAULT '',
  `szDurationPoly` varchar(100) NOT NULL DEFAULT '',
  `szDurationSPCostPoly` varchar(100) NOT NULL DEFAULT '',
  `szCooldownPoly` varchar(100) NOT NULL DEFAULT '',
  `szMasterBonusPoly` varchar(100) NOT NULL DEFAULT '',
  `szAttackGradePoly` varchar(100) NOT NULL DEFAULT '',
  `setFlag` set('ATTACK','USE_MELEE_DAMAGE','COMPUTE_ATTGRADE','SELFONLY','USE_MAGIC_DAMAGE','USE_HP_AS_COST','COMPUTE_MAGIC_DAMAGE','SPLASH','GIVE_PENALTY','USE_ARROW_DAMAGE','PENETRATE','IGNORE_TARGET_RATING','ATTACK_SLOW','ATTACK_STUN','HP_ABSORB','SP_ABSORB','ATTACK_FIRE_CONT','REMOVE_BAD_AFFECT','REMOVE_GOOD_AFFECT','CRUSH','ATTACK_POISON','TOGGLE','DISABLE_BY_POINT_UP','CRUSH_LONG','ATTACK_WIND','ATTACK_ELEC','ATTACK_FIRE','ATTACK_BLEEDING','PARTY') DEFAULT NULL,
  `setAffectFlag` enum('YMIR','INVISIBILITY','SPAWN','POISON','SLOW','STUN','DUNGEON_READY','DUNGEON_UNIQUE','BUILDING_CONSTRUCTION_SMALL','BUILDING_CONSTRUCTION_LARGE','BUILDING_UPGRADE','MOV_SPEED_POTION','ATT_SPEED_POTION','FISH_MIND','JEONGWIHON','GEOMGYEONG','CHEONGEUN','GYEONGGONG','EUNHYUNG','GWIGUM','TERROR','JUMAGAP','HOSIN','BOHO','KWAESOK','MANASHIELD','MUYEONG','REVIVE_INVISIBLE','FIRE','GICHEON','JEUNGRYEOK','TANHWAN_DASH','PABEOP','CHEONGEUN_WITH_FALL','POLYMORPH','WAR_FLAG1','WAR_FLAG2','WAR_FLAG3','CHINA_FIREWORK','HAIR','GERMANY','RAMADAN_RING','BLEEDING','RED_POSSESSION','BLUE_POSSESSION') NOT NULL DEFAULT 'YMIR',
  `szPointOn2` enum('NONE','MAX_HP','MAX_SP','HP_REGEN','SP_REGEN','BLOCK','HP','SP','ATT_GRADE','DEF_GRADE','MAGIC_ATT_GRADE','MAGIC_DEF_GRADE','BOW_DISTANCE','MOV_SPEED','ATT_SPEED','POISON_PCT','RESIST_RANGE','RESIST_MELEE','CASTING_SPEED','REFLECT_MELEE','ATT_BONUS','DEF_BONUS','RESIST_NORMAL','DODGE','KILL_HP_RECOVER','KILL_SP_RECOVER','HIT_HP_RECOVER','HIT_SP_RECOVER','CRITICAL','MANASHIELD','SKILL_DAMAGE_BONUS','NORMAL_HIT_DAMAGE_BONUS') NOT NULL DEFAULT 'NONE',
  `szPointPoly2` varchar(100) NOT NULL DEFAULT '',
  `szDurationPoly2` varchar(100) NOT NULL DEFAULT '',
  `setAffectFlag2` enum('YMIR','INVISIBILITY','SPAWN','POISON','SLOW','STUN','DUNGEON_READY','DUNGEON_UNIQUE','BUILDING_CONSTRUCTION_SMALL','BUILDING_CONSTRUCTION_LARGE','BUILDING_UPGRADE','MOV_SPEED_POTION','ATT_SPEED_POTION','FISH_MIND','JEONGWIHON','GEOMGYEONG','CHEONGEUN','GYEONGGONG','EUNHYUNG','GWIGUM','TERROR','JUMAGAP','HOSIN','BOHO','KWAESOK','MANASHIELD','MUYEONG','REVIVE_INVISIBLE','FIRE','GICHEON','JEUNGRYEOK','TANHWAN_DASH','PABEOP','CHEONGEUN_WITH_FALL','POLYMORPH','WAR_FLAG1','WAR_FLAG2','WAR_FLAG3','CHINA_FIREWORK','HAIR','GERMANY','RAMADAN_RING','BLEEDING','RED_POSSESSION','BLUE_POSSESSION') NOT NULL DEFAULT 'YMIR',
  `szPointOn3` varchar(100) NOT NULL DEFAULT 'NONE',
  `szPointPoly3` varchar(100) NOT NULL DEFAULT '',
  `szDurationPoly3` varchar(100) NOT NULL DEFAULT '',
  `szGrandMasterAddSPCostPoly` varchar(100) NOT NULL DEFAULT '',
  `prerequisiteSkillVnum` int(11) NOT NULL DEFAULT 0,
  `prerequisiteSkillLevel` int(11) NOT NULL DEFAULT 0,
  `eSkillType` enum('NORMAL','MELEE','RANGE','MAGIC') NOT NULL DEFAULT 'NORMAL',
  `iMaxHit` tinyint(4) NOT NULL DEFAULT 0,
  `szSplashAroundDamageAdjustPoly` varchar(100) NOT NULL DEFAULT '1',
  `dwTargetRange` int(11) NOT NULL DEFAULT 1000,
  `dwSplashRange` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`dwVnum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.sms_pool
CREATE TABLE IF NOT EXISTS `sms_pool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` int(11) NOT NULL DEFAULT 0,
  `sender` varchar(32) DEFAULT NULL,
  `receiver` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(32) DEFAULT NULL,
  `sent` enum('N','Y') NOT NULL DEFAULT 'N',
  `msg` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sent_idx` (`sent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di tabella player.string
CREATE TABLE IF NOT EXISTS `string` (
  `name` varchar(64) NOT NULL DEFAULT '',
  `text` text DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- L’esportazione dei dati non era selezionata.
-- Dump della struttura di trigger player.MakeCharacter
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `MakeCharacter` BEFORE INSERT ON `player` FOR EACH ROW BEGIN
	IF(new.`name` REGEXP '[^A-Za-z0-9]')THEN
		SET new.`name`=NULL;
	END IF;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dump della struttura di trigger player.MakeCharacter_copy1
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='';
DELIMITER //
CREATE TRIGGER `MakeCharacter_copy1` BEFORE INSERT ON `player2` FOR EACH ROW BEGIN
	IF(new.`name` REGEXP '[^A-Za-z0-9]')THEN
		SET new.`name`=NULL;
	END IF;
	
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
