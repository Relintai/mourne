-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2013 at 02:27 PM
-- Server version: 5.5.29-MariaDB-log
-- PHP Version: 5.4.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mourne`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_settings`
--

CREATE TABLE IF NOT EXISTS `ai_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting` text NOT NULL,
  `value` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ai_settings`
--

INSERT INTO `ai_settings` (`id`, `setting`, `value`, `description`) VALUES
(1, 'on', '1', '1 if AI is on, 0 if AI is off.'),
(2, 'max_attack_village_limit', '15', 'Max number of Ai Village that can attack at the same time.'),
(3, 'attack_village_rand', '0', 'How much difference can there be from max_attack_village_limit'),
(4, 'ai_unit_max_diff', '10', 'How much different AI Units can attack at once.');

-- --------------------------------------------------------

--
-- Table structure for table `ai_units`
--

CREATE TABLE IF NOT EXISTS `ai_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `icon` text NOT NULL,
  `ability` int(11) NOT NULL,
  `can_carry` float NOT NULL,
  `attack` float NOT NULL,
  `defense` float NOT NULL,
  `rate` float NOT NULL,
  `per_score` int(11) NOT NULL,
  `turn` int(11) NOT NULL,
  `strong_against` int(11) NOT NULL,
  `weak_against` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ai_units`
--

INSERT INTO `ai_units` (`id`, `name`, `icon`, `ability`, `can_carry`, `attack`, `defense`, `rate`, `per_score`, `turn`, `strong_against`, `weak_against`) VALUES
(1, 'Soilder', 'E_NOTIMPL', 2, 1, 1, 1, 0.5, 3, 2, 0, 0),
(2, 'test2', 'E_NOTIMPL', 1, 0, 1, 1, 1, 5, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

--done
CREATE TABLE IF NOT EXISTS `assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitid` int(11) NOT NULL,
  `max` int(11) NOT NULL DEFAULT '1',
  `bonus_per_assigned` int(11) NOT NULL DEFAULT '1',
  `spellid` int(11) NOT NULL DEFAULT '0',
  `req_tech` int(11) NOT NULL DEFAULT '0',
  `mod_max_food` int(11) NOT NULL DEFAULT '0',
  `mod_max_wood` int(11) NOT NULL DEFAULT '0',
  `mod_max_stone` int(11) NOT NULL DEFAULT '0',
  `mod_max_iron` int(11) NOT NULL DEFAULT '0',
  `mod_max_mana` int(11) NOT NULL DEFAULT '0',
  `mod_rate_food` float NOT NULL DEFAULT '0',
  `mod_rate_wood` float NOT NULL DEFAULT '0',
  `mod_rate_stone` float NOT NULL DEFAULT '0',
  `mod_rate_iron` float NOT NULL DEFAULT '0',
  `mod_rate_mana` float NOT NULL DEFAULT '0',
  `mod_percent_food` int(11) NOT NULL DEFAULT '0',
  `mod_percent_wood` int(11) NOT NULL DEFAULT '0',
  `mod_percent_stone` int(11) NOT NULL DEFAULT '0',
  `mod_percent_iron` int(11) NOT NULL DEFAULT '0',
  `mod_percent_mana` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `unitid`, `max`, `bonus_per_assigned`, `spellid`, `req_tech`, `mod_max_food`, `mod_max_wood`, `mod_max_stone`, `mod_max_iron`, `mod_max_mana`, `mod_rate_food`, `mod_rate_wood`, `mod_rate_stone`, `mod_rate_iron`, `mod_rate_mana`, `mod_percent_food`, `mod_percent_wood`, `mod_percent_stone`, `mod_percent_iron`, `mod_percent_mana`, `description`) VALUES
(1, 1, 10, 2, 0, 0, 0, 0, 0, 0, 0, 0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'This building will produce more food, every 2 villager you assign.'),
(2, 1, 10, 5, 0, 0, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Every 5 Villager you assign, you get +30 Maximum Food.'),
(3, 1, 10, 10, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Assigning 10 Villager will grant you an awesome spell.'),
(4, 1, 10, 10, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Adds a spell, and tests the requirements.');

-- --------------------------------------------------------

--
-- Table structure for table `attacks`
--

CREATE TABLE IF NOT EXISTS `attacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `attackid` int(11) NOT NULL,
  `ai_unitid` int(11) NOT NULL,
  `ai_unitcount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `villageid` (`villageid`,`attackid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

--done
CREATE TABLE IF NOT EXISTS `buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `icon` text NOT NULL,
  `rank` int(11) NOT NULL,
  `next_rank` int(11) NOT NULL DEFAULT '0',
  `time_to_build` int(11) NOT NULL,
  `creates` int(11) NOT NULL DEFAULT '0',
  `num_creates` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL,
  `defense` int(11) NOT NULL,
  `ability` int(11) NOT NULL DEFAULT '0',
  `cost_food` int(11) NOT NULL,
  `cost_wood` int(11) NOT NULL,
  `cost_stone` int(11) NOT NULL,
  `cost_iron` int(11) NOT NULL,
  `cost_mana` int(11) NOT NULL,
  `mod_max_food` int(11) NOT NULL DEFAULT '0',
  `mod_max_wood` int(11) NOT NULL DEFAULT '0',
  `mod_max_stone` int(11) NOT NULL DEFAULT '0',
  `mod_max_iron` int(11) NOT NULL DEFAULT '0',
  `mod_max_mana` int(11) NOT NULL DEFAULT '0',
  `mod_rate_food` float NOT NULL DEFAULT '0',
  `mod_rate_wood` float NOT NULL DEFAULT '0',
  `mod_rate_stone` float NOT NULL DEFAULT '0',
  `mod_rate_iron` float NOT NULL DEFAULT '0',
  `mod_rate_mana` float NOT NULL DEFAULT '0',
  `mod_percent_food` int(11) NOT NULL DEFAULT '0',
  `mod_percent_wood` int(11) NOT NULL DEFAULT '0',
  `mod_percent_stone` int(11) NOT NULL DEFAULT '0',
  `mod_percent_iron` int(11) NOT NULL DEFAULT '0',
  `mod_percent_mana` int(11) NOT NULL DEFAULT '0',
  `assignment1` int(11) NOT NULL DEFAULT '0',
  `assignment2` int(11) NOT NULL DEFAULT '0',
  `assignment3` int(11) NOT NULL DEFAULT '0',
  `assignment4` int(11) NOT NULL DEFAULT '0',
  `assignment5` int(11) NOT NULL DEFAULT '0',
  `req_tech` int(11) NOT NULL DEFAULT '0',
  `tech_group` int(11) NOT NULL DEFAULT '0',
  `tech_secondary_group` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`id`, `name`, `description`, `icon`, `rank`, `next_rank`, `time_to_build`, `creates`, `num_creates`, `score`, `defense`, `ability`, `cost_food`, `cost_wood`, `cost_stone`, `cost_iron`, `cost_mana`, `mod_max_food`, `mod_max_wood`, `mod_max_stone`, `mod_max_iron`, `mod_max_mana`, `mod_rate_food`, `mod_rate_wood`, `mod_rate_stone`, `mod_rate_iron`, `mod_rate_mana`, `mod_percent_food`, `mod_percent_wood`, `mod_percent_stone`, `mod_percent_iron`, `mod_percent_mana`, `assignment1`, `assignment2`, `assignment3`, `assignment4`, `assignment5`, `req_tech`, `tech_group`, `tech_secondary_group`) VALUES
(1, 'empty', '', 'empty/empty.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Build in Progress', '', 'bip/bip.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'Corn Field', 'Produces food.', 'corn_field/r1.png', 1, 7, 20, 0, 0, 20, 1, 0, 60, 100, 10, 5, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 4, 3, 0, 0, 2, 3),
(4, 'Lumber Mill', 'Your main wood producing building.', 'lumber_mill/r1.png', 1, 0, 1000, 0, 0, 20, 0, 0, 30, 40, 50, 10, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 2),
(5, 'Stone Mine', 'Your main stone producing building.', 'stone_mine/r1.png', 1, 0, 1000, 2, 20, 0, 0, 0, 30, 50, 20, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'House', 'Can create villagers.', 'house/r1.png', 1, 0, 20, 1, 10, 0, 0, 0, 50, 70, 30, 5, 0, 0, 0, 0, 0, 0, -0.005, -0.001, -0.001, -0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'Corn Field', '', 'corn_field/r2.png', 2, 0, 20, 0, 0, 0, 0, 0, 40, 60, 20, 10, 0, 0, 0, 0, 0, 0, 0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 0, 2, 0, 0),
(8, 'Farm', 'Creates villagers.', 'farm/r1.png', 1, 0, 80, 1, 20, 0, 0, 0, 50, 60, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'Iron Mine', 'Your main iron producing building.', 'iron_mine/r1.png', 1, 0, 1000, 2, 100000, 0, 0, 0, 70, 30, 70, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0),
(10, 'School', 'School', 'school/r1.png', 1, 0, 60, 2, 60, 0, 0, 0, 300, 300, 300, 300, 20, 0, 0, 0, 0, 0, 0.001, 0.001, 0.001, 0.001, 0.001, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `building_assignments`
--

--done
CREATE TABLE IF NOT EXISTS `building_assignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `unitid` int(11) NOT NULL,
  `num_unit` int(11) NOT NULL,
  `assignmentid` int(11) NOT NULL,
  `num_bonus` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `building_assignments`
--

-- --------------------------------------------------------

--
-- Table structure for table `building_spells`
--

--done
CREATE TABLE IF NOT EXISTS `building_spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `assignmentid` int(11) NOT NULL,
  `spellid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `building_spells`
--

-- --------------------------------------------------------

--
-- Table structure for table `building_spell_cooldowns`
--

--done
CREATE TABLE IF NOT EXISTS `building_spell_cooldowns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `spellid` int(11) NOT NULL,
  `cooldown_end` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `building_spell_cooldowns`
--

-- --------------------------------------------------------

--
-- Table structure for table `changelog_commits`
--

CREATE TABLE IF NOT EXISTS `changelog_commits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `versionid` int(11) NOT NULL,
  `text` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `changelog_versions`
--

CREATE TABLE IF NOT EXISTS `changelog_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(64) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `combat_logs`
--

CREATE TABLE IF NOT EXISTS `combat_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `new` tinyint(4) NOT NULL,
  `log` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `combat_logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_version`
--

CREATE TABLE IF NOT EXISTS `db_version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `db_version`
--

INSERT INTO `db_version` (`id`, `version`) VALUES
(1, 1363701677);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `data1` int(11) NOT NULL,
  `data2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `heroes`
--

CREATE TABLE IF NOT EXISTS `heroes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `level` smallint(6) NOT NULL DEFAULT '1',
  `experience` int(11) NOT NULL DEFAULT '0',
  `class` int(11) NOT NULL,
  `selected` tinyint(4) NOT NULL DEFAULT '1',
  `health` int(11) NOT NULL,
  `mana` int(11) NOT NULL,
  `max_health` int(11) NOT NULL,
  `max_mana` int(11) NOT NULL,
  `percent_max_health` smallint(6) NOT NULL DEFAULT '100',
  `percent_max_mana` smallint(6) NOT NULL DEFAULT '100',
  `nomod_max_health` int(11) NOT NULL,
  `nomod_max_mana` int(11) NOT NULL,
  `points` smallint(6) NOT NULL DEFAULT '0',
  `agility` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  `stamina` int(11) NOT NULL,
  `intellect` int(11) NOT NULL,
  `spirit` int(11) NOT NULL,
  `percent_agility` smallint(6) NOT NULL DEFAULT '100',
  `percent_strength` smallint(6) NOT NULL DEFAULT '100',
  `percent_stamina` smallint(6) NOT NULL DEFAULT '100',
  `percent_intellect` smallint(6) NOT NULL DEFAULT '100',
  `percent_spirit` smallint(6) NOT NULL DEFAULT '100',
  `nomod_agility` int(11) NOT NULL,
  `nomod_strength` int(11) NOT NULL,
  `nomod_stamina` int(11) NOT NULL,
  `nomod_intellect` int(11) NOT NULL,
  `nomod_spirit` int(11) NOT NULL,
  `points_agility` smallint(6) NOT NULL DEFAULT '0',
  `points_strength` smallint(6) NOT NULL DEFAULT '0',
  `points_stamina` smallint(6) NOT NULL DEFAULT '0',
  `points_intellect` smallint(6) NOT NULL DEFAULT '0',
  `points_spirit` smallint(6) NOT NULL DEFAULT '0',
  `attackpower` int(11) NOT NULL DEFAULT '0',
  `percent_attackpower` int(11) NOT NULL DEFAULT '100',
  `nomod_attackpower` int(11) NOT NULL DEFAULT '0',
  `armor` int(11) NOT NULL,
  `percent_armor` int(11) NOT NULL DEFAULT '100',
  `nomod_armor` int(11) NOT NULL,
  `dodge` double NOT NULL DEFAULT '0',
  `nomod_dodge` double NOT NULL DEFAULT '0',
  `parry` double NOT NULL DEFAULT '0',
  `nomod_parry` double NOT NULL DEFAULT '0',
  `hit` double NOT NULL DEFAULT '80',
  `crit` double NOT NULL DEFAULT '0',
  `nomod_crit` double NOT NULL DEFAULT '0',
  `damage_min` int(11) NOT NULL,
  `damage_max` int(11) NOT NULL,
  `percent_damage_min` smallint(6) NOT NULL DEFAULT '100',
  `percent_damage_max` smallint(6) NOT NULL DEFAULT '100',
  `nomod_damage_min` int(11) NOT NULL,
  `nomod_damage_max` int(11) NOT NULL,
  `ranged_damage_min` int(11) NOT NULL DEFAULT '0',
  `ranged_damage_max` int(11) NOT NULL DEFAULT '0',
  `percent_ranged_damage_min` smallint(6) NOT NULL DEFAULT '100',
  `percent_ranged_damage_max` smallint(6) NOT NULL DEFAULT '100',
  `nomod_ranged_damage_min` int(11) NOT NULL DEFAULT '0',
  `nomod_ranged_damage_max` int(11) NOT NULL DEFAULT '0',
  `heal_min` int(11) NOT NULL,
  `heal_max` int(11) NOT NULL,
  `percent_heal_min` smallint(6) NOT NULL DEFAULT '100',
  `percent_heal_max` smallint(6) NOT NULL DEFAULT '100',
  `nomod_heal_min` int(11) NOT NULL,
  `nomod_heal_max` int(11) NOT NULL,
  `life_leech` smallint(6) NOT NULL DEFAULT '0',
  `mana_leech` smallint(6) NOT NULL DEFAULT '0',
  `gender` int(11) NOT NULL DEFAULT '1',
  `on_quest` tinyint(4) NOT NULL DEFAULT '0',
  `avatar` text NOT NULL,
  `thumb_avatar` text NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `delete_name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `heroes`
--

-- --------------------------------------------------------

--
-- Table structure for table `heros_inventory`
--

CREATE TABLE IF NOT EXISTS `heros_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charid` int(11) NOT NULL DEFAULT '0',
  `itemid` int(11) NOT NULL DEFAULT '0',
  `is_soulbound` tinyint(4) NOT NULL DEFAULT '0',
  `stack_size` tinyint(4) NOT NULL DEFAULT '1',
  `container` tinyint(4) NOT NULL DEFAULT '1',
  `slot` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `charid` (`charid`,`container`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `heros_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `hero_inventory_templates`
--

CREATE TABLE IF NOT EXISTS `hero_inventory_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classid` tinyint(4) NOT NULL DEFAULT '0',
  `itemid` int(11) NOT NULL DEFAULT '0',
  `slotid` int(11) NOT NULL DEFAULT '0',
  `container` smallint(6) NOT NULL DEFAULT '0',
  `stack` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `classid` (`classid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hero_items`
--

CREATE TABLE IF NOT EXISTS `hero_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `quality` tinyint(4) NOT NULL DEFAULT '0',
  `itemlevel` int(11) NOT NULL DEFAULT '0',
  `stack` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `subtype` tinyint(4) NOT NULL DEFAULT '0',
  `subsubtype` smallint(6) NOT NULL DEFAULT '0',
  `sell_price` int(11) NOT NULL DEFAULT '0',
  `buy_price` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `soulbound` int(11) NOT NULL DEFAULT '0',
  `spell` int(11) NOT NULL DEFAULT '0',
  `proc` smallint(6) NOT NULL DEFAULT '0',
  `req_level` smallint(6) NOT NULL DEFAULT '0',
  `req_class` tinyint(4) NOT NULL DEFAULT '0',
  `nomod_max_health` int(11) NOT NULL DEFAULT '0',
  `nomod_max_mana` int(11) NOT NULL DEFAULT '0',
  `percent_max_health` smallint(6) NOT NULL DEFAULT '0',
  `percent_max_mana` smallint(6) NOT NULL DEFAULT '0',
  `nomod_agility` smallint(6) NOT NULL DEFAULT '0',
  `nomod_strength` smallint(6) NOT NULL DEFAULT '0',
  `nomod_stamina` smallint(6) NOT NULL DEFAULT '0',
  `nomod_intellect` smallint(6) NOT NULL DEFAULT '0',
  `nomod_spirit` smallint(6) NOT NULL DEFAULT '0',
  `percent_agility` smallint(6) NOT NULL DEFAULT '0',
  `percent_strength` smallint(6) NOT NULL DEFAULT '0',
  `percent_stamina` smallint(6) NOT NULL DEFAULT '0',
  `percent_intellect` smallint(6) NOT NULL DEFAULT '0',
  `percent_spirit` smallint(6) NOT NULL DEFAULT '0',
  `nomod_attackpower` int(11) NOT NULL DEFAULT '0',
  `percent_attackpower` smallint(6) NOT NULL DEFAULT '0',
  `nomod_armor` int(11) NOT NULL DEFAULT '0',
  `percent_armor` smallint(6) NOT NULL DEFAULT '0',
  `nomod_dodge` double NOT NULL DEFAULT '0',
  `nomod_parry` double NOT NULL DEFAULT '0',
  `hit` double NOT NULL DEFAULT '0',
  `nomod_crit` double NOT NULL DEFAULT '0',
  `nomod_damage_min` int(11) NOT NULL DEFAULT '0',
  `nomod_damage_max` int(11) NOT NULL DEFAULT '0',
  `percent_damage_min` smallint(6) NOT NULL DEFAULT '0',
  `percent_damage_max` smallint(6) NOT NULL DEFAULT '0',
  `nomod_ranged_damage_min` int(11) NOT NULL DEFAULT '0',
  `nomod_ranged_damage_max` int(11) NOT NULL DEFAULT '0',
  `percent_ranged_damage_min` smallint(6) NOT NULL DEFAULT '0',
  `percent_ranged_damage_max` smallint(6) NOT NULL DEFAULT '0',
  `nomod_heal_min` int(11) NOT NULL DEFAULT '0',
  `nomod_heal_max` int(11) NOT NULL DEFAULT '0',
  `percent_heal_min` smallint(6) NOT NULL DEFAULT '0',
  `percent_heal_max` smallint(6) NOT NULL DEFAULT '0',
  `life_leech` smallint(6) NOT NULL DEFAULT '0',
  `mana_leech` smallint(6) NOT NULL DEFAULT '0',
  `level_modifier` double NOT NULL DEFAULT '0',
  `level_modifier_max` int(11) NOT NULL DEFAULT '0',
  `data1` int(11) NOT NULL DEFAULT '0',
  `data2` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `qality` (`quality`,`type`,`subtype`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `hero_items`
--

-- --------------------------------------------------------

--
-- Table structure for table `hero_templates`
--

CREATE TABLE IF NOT EXISTS `hero_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(20) NOT NULL,
  `nomod_max_health` int(11) NOT NULL DEFAULT '1',
  `nomod_max_mana` int(11) NOT NULL DEFAULT '1',
  `max_health` int(11) NOT NULL DEFAULT '1',
  `max_mana` int(11) NOT NULL DEFAULT '1',
  `agility` smallint(6) NOT NULL DEFAULT '0',
  `strength` smallint(6) NOT NULL DEFAULT '0',
  `stamina` smallint(6) NOT NULL DEFAULT '0',
  `intellect` smallint(6) NOT NULL DEFAULT '0',
  `spirit` smallint(6) NOT NULL DEFAULT '0',
  `nomod_attackpower` int(11) NOT NULL DEFAULT '0',
  `attackpower` int(11) NOT NULL DEFAULT '0',
  `armor` int(11) NOT NULL DEFAULT '0',
  `dodge` double NOT NULL DEFAULT '0',
  `nomod_dodge` double NOT NULL DEFAULT '0',
  `parry` double NOT NULL DEFAULT '0',
  `nomod_parry` double NOT NULL DEFAULT '0',
  `hit` double NOT NULL DEFAULT '80',
  `crit` double NOT NULL DEFAULT '0',
  `nomod_crit` double NOT NULL DEFAULT '0',
  `nomod_damage_min` int(11) NOT NULL DEFAULT '0',
  `nomod_damage_max` int(11) NOT NULL DEFAULT '0',
  `damage_min` int(11) NOT NULL DEFAULT '0',
  `damage_max` int(11) NOT NULL DEFAULT '0',
  `ranged_damage_min` int(11) NOT NULL DEFAULT '0',
  `ranged_damage_max` int(11) NOT NULL DEFAULT '0',
  `nomod_ranged_damage_min` int(11) NOT NULL DEFAULT '0',
  `nomod_ranged_damage_max` int(11) NOT NULL DEFAULT '0',
  `nomod_heal_min` int(11) NOT NULL DEFAULT '0',
  `nomod_heal_max` int(11) NOT NULL DEFAULT '0',
  `heal_min` int(11) NOT NULL DEFAULT '0',
  `heal_max` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `class` (`classname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `hero_templates`
--

INSERT INTO `hero_templates` (`id`, `classname`, `nomod_max_health`, `nomod_max_mana`, `max_health`, `max_mana`, `agility`, `strength`, `stamina`, `intellect`, `spirit`, `nomod_attackpower`, `attackpower`, `armor`, `dodge`, `nomod_dodge`, `parry`, `nomod_parry`, `hit`, `crit`, `nomod_crit`, `nomod_damage_min`, `nomod_damage_max`, `damage_min`, `damage_max`, `ranged_damage_min`, `ranged_damage_max`, `nomod_ranged_damage_min`, `nomod_ranged_damage_max`, `nomod_heal_min`, `nomod_heal_max`, `heal_min`, `heal_max`) VALUES
(1, 'Warrior', 100, 50, 250, 150, 10, 10, 15, 10, 10, 100, 400, 0, 5.3333333333333, 5, 5.3333333333333, 5, 80, 5.75, 5, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 0, 0),
(2, 'Rogue', 100, 100, 200, 200, 15, 10, 10, 10, 10, 30, 0, 0, 5.5, 5, 5.3333333333333, 5, 85, 0, 5, 1, 2, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'Archer', 100, 150, 200, 250, 15, 10, 10, 10, 40, 0, 10, 0, 5.5, 5, 5.3333333333333, 5, 85, 0, 5, 1, 2, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `new` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner` (`owner`,`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `mails`
--

-- --------------------------------------------------------

--
-- Table structure for table `mail_drafts`
--

CREATE TABLE IF NOT EXISTS `mail_drafts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `friend` int(11) NOT NULL,
  `name` text NOT NULL,
  `X` int(11) NOT NULL,
  `Y` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `time` (`time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mail_drafts`
--

-- --------------------------------------------------------

--
-- Table structure for table `mail_sent`
--

CREATE TABLE IF NOT EXISTS `mail_sent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `to` text NOT NULL,
  `time` int(11) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mail_sent`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `written_by` varchar(32) NOT NULL,
  `text` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

--done
CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `food` double NOT NULL DEFAULT '400',
  `wood` double NOT NULL DEFAULT '400',
  `stone` double NOT NULL DEFAULT '400',
  `iron` double NOT NULL DEFAULT '400',
  `mana` double NOT NULL DEFAULT '400',
  `max_food` int(11) NOT NULL DEFAULT '1000',
  `max_wood` int(11) NOT NULL DEFAULT '1000',
  `max_stone` int(11) NOT NULL DEFAULT '1000',
  `max_iron` int(11) NOT NULL DEFAULT '1000',
  `max_mana` int(11) NOT NULL DEFAULT '1000',
  `rate_nm_food` double NOT NULL DEFAULT '0.1',
  `rate_nm_wood` double NOT NULL DEFAULT '0.1',
  `rate_nm_stone` double NOT NULL DEFAULT '0.1',
  `rate_nm_iron` double NOT NULL DEFAULT '0.1',
  `rate_nm_mana` double NOT NULL DEFAULT '0.1',
  `rate_food` double NOT NULL DEFAULT '0.1',
  `rate_wood` double NOT NULL DEFAULT '0.1',
  `rate_stone` double NOT NULL DEFAULT '0.1',
  `rate_iron` double NOT NULL DEFAULT '0.1',
  `rate_mana` double NOT NULL DEFAULT '0.1',
  `percent_food` smallint(6) NOT NULL DEFAULT '100',
  `percent_wood` smallint(6) NOT NULL DEFAULT '100',
  `percent_stone` smallint(6) NOT NULL DEFAULT '100',
  `percent_iron` smallint(6) NOT NULL DEFAULT '100',
  `percent_mana` smallint(6) NOT NULL DEFAULT '100',
  `last_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `resources`
--

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

--done
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

-- --------------------------------------------------------

--
-- Table structure for table `spells`
--

CREATE TABLE IF NOT EXISTS `spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `effect` int(11) NOT NULL DEFAULT '0',
  `duration` int(11) NOT NULL DEFAULT '0',
  `cooldown` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `description_admin` text NOT NULL,
  `weather_change_to` int(11) NOT NULL DEFAULT '0',
  `cost_food` int(11) NOT NULL DEFAULT '0',
  `cost_wood` int(11) NOT NULL DEFAULT '0',
  `cost_stone` int(11) NOT NULL DEFAULT '0',
  `cost_iron` int(11) NOT NULL DEFAULT '0',
  `cost_mana` int(11) NOT NULL DEFAULT '0',
  `mod_max_food` int(11) NOT NULL DEFAULT '0',
  `mod_max_wood` int(11) NOT NULL DEFAULT '0',
  `mod_max_stone` int(11) NOT NULL DEFAULT '0',
  `mod_max_iron` int(11) NOT NULL DEFAULT '0',
  `mod_max_mana` int(11) NOT NULL DEFAULT '0',
  `mod_rate_food` float NOT NULL DEFAULT '0',
  `mod_rate_wood` float NOT NULL DEFAULT '0',
  `mod_rate_stone` float NOT NULL DEFAULT '0',
  `mod_rate_iron` float NOT NULL DEFAULT '0',
  `mod_rate_mana` float NOT NULL DEFAULT '0',
  `mod_percent_food` int(11) NOT NULL DEFAULT '0',
  `mod_percent_wood` int(11) NOT NULL DEFAULT '0',
  `mod_percent_stone` int(11) NOT NULL DEFAULT '0',
  `mod_percent_iron` int(11) NOT NULL DEFAULT '0',
  `mod_percent_mana` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `spells`
--

INSERT INTO `spells` (`id`, `effect`, `duration`, `cooldown`, `description`, `description_admin`, `weather_change_to`, `cost_food`, `cost_wood`, `cost_stone`, `cost_iron`, `cost_mana`, `mod_max_food`, `mod_max_wood`, `mod_max_stone`, `mod_max_iron`, `mod_max_mana`, `mod_rate_food`, `mod_rate_wood`, `mod_rate_stone`, `mod_rate_iron`, `mod_rate_mana`, `mod_percent_food`, `mod_percent_wood`, `mod_percent_stone`, `mod_percent_iron`, `mod_percent_mana`) VALUES
(1, 0, 60, 70, 'Increases productivity of this building, by a small amount.', 'Test spell', 0, 400, 100, 100, 100, 100, 100, 100, 100, 100, 100, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10),
(2, 0, 100, 100, 'Increases the food production rate of this building.', 'Test spell 2 (over the top crazy)', 0, 140, 140, 140, 140, 140, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `technologies`
--

CREATE TABLE IF NOT EXISTS `technologies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `cost_food` int(11) NOT NULL DEFAULT '0',
  `cost_wood` int(11) NOT NULL DEFAULT '0',
  `cost_stone` int(11) NOT NULL DEFAULT '0',
  `cost_iron` int(11) NOT NULL DEFAULT '0',
  `cost_mana` int(11) NOT NULL DEFAULT '0',
  `mod_max_food` int(11) NOT NULL DEFAULT '0',
  `mod_max_wood` int(11) NOT NULL DEFAULT '0',
  `mod_max_stone` int(11) NOT NULL DEFAULT '0',
  `mod_max_iron` int(11) NOT NULL DEFAULT '0',
  `mod_max_mana` int(11) NOT NULL DEFAULT '0',
  `mod_rate_food` float NOT NULL DEFAULT '0',
  `mod_rate_wood` float NOT NULL DEFAULT '0',
  `mod_rate_stone` float NOT NULL DEFAULT '0',
  `mod_rate_iron` float NOT NULL DEFAULT '0',
  `mod_rate_mana` float NOT NULL DEFAULT '0',
  `mod_percent_food` int(11) NOT NULL DEFAULT '0',
  `mod_percent_wood` int(11) NOT NULL DEFAULT '0',
  `mod_percent_stone` int(11) NOT NULL DEFAULT '0',
  `mod_percent_iron` int(11) NOT NULL DEFAULT '0',
  `mod_percent_mana` int(11) NOT NULL DEFAULT '0',
  `mod_create_id` int(11) NOT NULL DEFAULT '0',
  `mod_spell_id` int(11) NOT NULL DEFAULT '0',
  `flag_ai` int(11) NOT NULL DEFAULT '0',
  `is_secondary` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`id`, `description`, `time`, `score`, `cost_food`, `cost_wood`, `cost_stone`, `cost_iron`, `cost_mana`, `mod_max_food`, `mod_max_wood`, `mod_max_stone`, `mod_max_iron`, `mod_max_mana`, `mod_rate_food`, `mod_rate_wood`, `mod_rate_stone`, `mod_rate_iron`, `mod_rate_mana`, `mod_percent_food`, `mod_percent_wood`, `mod_percent_stone`, `mod_percent_iron`, `mod_percent_mana`, `mod_create_id`, `mod_spell_id`, `flag_ai`, `is_secondary`) VALUES
(1, 'This will do something.', 0, 0, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0.001, 0.001, 0.001, 0.001, 0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Allows you to track bugs.', 0, 0, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0.1, 0.1, 0.1, 0.1, 0.1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'Corn F opt test', 60, 0, 100, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 'Corn F opt test 2', 60, 0, 200, 200, 200, 200, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 'Corn F test3', 60, 0, 100, 100, 100, 100, 100, 30, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'Test for the wicked.', 50, 10, 100000, 10000, 10000, 20000000, 20000, 30000, 20000, 20000, 20000, 20000, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `technology_groups`
--

CREATE TABLE IF NOT EXISTS `technology_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `technologyid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `technology_groups`
--

INSERT INTO `technology_groups` (`id`, `groupid`, `technologyid`) VALUES
(3, 1, 1),
(4, 1, 2),
(5, 2, 1),
(7, 3, 3),
(8, 3, 4),
(11, 2, 2),
(12, 2, 5),
(13, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `technology_group_descriptions`
--

CREATE TABLE IF NOT EXISTS `technology_group_descriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `technology_group_descriptions`
--

INSERT INTO `technology_group_descriptions` (`id`, `group_name`) VALUES
(1, 'Lumber Mill R1-5'),
(2, 'Corn Field R1-5'),
(3, 'Corn Field R1-5 Sec');

-- --------------------------------------------------------

--
-- Table structure for table `technology_have_requirements`
--

CREATE TABLE IF NOT EXISTS `technology_have_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `technologyid` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `technologyid` (`technologyid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `technology_have_requirements`
--

INSERT INTO `technology_have_requirements` (`id`, `technologyid`, `comment`) VALUES
(3, 2, 'test1'),
(5, 4, 'Corn F opt test r1-5 sec');

-- --------------------------------------------------------

--
-- Table structure for table `technology_requirements`
--

CREATE TABLE IF NOT EXISTS `technology_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `technologyid` int(11) NOT NULL,
  `req_tech_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `technologyid` (`technologyid`,`req_tech_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `technology_requirements`
--

INSERT INTO `technology_requirements` (`id`, `technologyid`, `req_tech_id`) VALUES
(7, 2, 1),
(8, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `name` text NOT NULL,
  `icon` text NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `can_defend` tinyint(4) NOT NULL DEFAULT '0',
  `defense` float NOT NULL DEFAULT '0',
  `attack` float NOT NULL DEFAULT '0',
  `weak_against` int(11) NOT NULL DEFAULT '0',
  `strong_against` int(11) NOT NULL DEFAULT '0',
  `turn` int(11) NOT NULL,
  `ability` int(11) NOT NULL,
  `time_to_create` int(11) NOT NULL,
  `cost_unit` int(11) NOT NULL DEFAULT '0',
  `cost_num_unit` int(11) NOT NULL DEFAULT '0',
  `cost_food` int(11) NOT NULL DEFAULT '0',
  `cost_wood` int(11) NOT NULL DEFAULT '0',
  `cost_stone` int(11) NOT NULL DEFAULT '0',
  `cost_iron` int(11) NOT NULL DEFAULT '0',
  `cost_mana` int(11) NOT NULL DEFAULT '0',
  `mod_rate_food` float NOT NULL DEFAULT '0',
  `mod_rate_wood` float NOT NULL DEFAULT '0',
  `mod_rate_stone` float NOT NULL DEFAULT '0',
  `mod_rate_iron` float NOT NULL DEFAULT '0',
  `mod_rate_mana` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `type`, `name`, `icon`, `score`, `can_defend`, `defense`, `attack`, `weak_against`, `strong_against`, `turn`, `ability`, `time_to_create`, `cost_unit`, `cost_num_unit`, `cost_food`, `cost_wood`, `cost_stone`, `cost_iron`, `cost_mana`, `mod_rate_food`, `mod_rate_wood`, `mod_rate_stone`, `mod_rate_iron`, `mod_rate_mana`) VALUES
(1, 0, 'Villager', 'E_NOTIMPL', 1, 1, 5, 2, 1, 0, 1, 0, 5, 0, 0, 100, 1, 1, 1, 0, 0.001, 0, 0, 0, 0),
(2, 0, 'Tester', 'E_NOTIMPL', 0, 0, 0, 0, 0, 0, 0, 0, 10, 1, 1, 5, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 0, 'Tester2', 'E_NOTIMPL', 0, 0, 0, 0, 0, 0, 0, 0, 30, 1, 2, 20, 30, 2, 2, 0, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

--done
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `passkey` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `userlevel` int(11) NOT NULL DEFAULT '1',
  `new_mail` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

--done
CREATE TABLE IF NOT EXISTS `villages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `name` text NOT NULL,
  `score` int(11) NOT NULL DEFAULT '100',
  `selected` tinyint(4) NOT NULL,
  `new_log` tinyint(4) NOT NULL DEFAULT '0',
  `ai_on` tinyint(4) NOT NULL DEFAULT '0',
  `ai_flagged` tinyint(4) NOT NULL DEFAULT '0',
  `weather` int(11) NOT NULL DEFAULT '0',
  `last_weather_change` int(11) NOT NULL DEFAULT '0',
  `weather_change_to` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `villages`
--

-- --------------------------------------------------------

--
-- Table structure for table `village_buildings`
--

--done
CREATE TABLE IF NOT EXISTS `village_buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `buildingid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `villageid` (`villageid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `village_buildings`
--

-- --------------------------------------------------------

--
-- Table structure for table `village_technologies`
--

--done
CREATE TABLE IF NOT EXISTS `village_technologies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `technologyid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `villageid` (`villageid`,`slotid`,`technologyid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `village_technologies`
--


-- --------------------------------------------------------

--
-- Table structure for table `village_units`
--

--done
CREATE TABLE IF NOT EXISTS `village_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `villageid` int(11) NOT NULL,
  `unitid` int(11) NOT NULL,
  `unitcount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `weathers`
--

--done
CREATE TABLE IF NOT EXISTS `weathers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `art` text NOT NULL,
  `css` text NOT NULL,
  `effect` int(11) NOT NULL DEFAULT '0',
  `mod_max_food` int(11) NOT NULL DEFAULT '0',
  `mod_max_wood` int(11) NOT NULL DEFAULT '0',
  `mod_max_stone` int(11) NOT NULL DEFAULT '0',
  `mod_max_iron` int(11) NOT NULL DEFAULT '0',
  `mod_max_mana` int(11) NOT NULL DEFAULT '0',
  `mod_percent_food` int(11) NOT NULL DEFAULT '0',
  `mod_percent_wood` int(11) NOT NULL DEFAULT '0',
  `mod_percent_stone` int(11) NOT NULL DEFAULT '0',
  `mod_percent_iron` int(11) NOT NULL DEFAULT '0',
  `mod_percent_mana` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `weathers`
--

INSERT INTO `weathers` (`id`, `name`, `description`, `art`, `css`, `effect`, `mod_max_food`, `mod_max_wood`, `mod_max_stone`, `mod_max_iron`, `mod_max_mana`, `mod_percent_food`, `mod_percent_wood`, `mod_percent_stone`, `mod_percent_iron`, `mod_percent_mana`) VALUES
(1, 'Sunny', 'Your maximum food increases by 1000, also increases food production by 10%.', 'E_NOTIMPL', 'sunny', 0, 1000, 0, 0, 0, 0, 10, 0, 0, 0, 0),
(2, 'Cold', 'Your max iron increases by 1000, also iron production increases by 10%.', 'E_NOTIMPL', 'cold', 0, 0, 0, 0, 1000, 0, 0, 0, 0, 10, 0);
