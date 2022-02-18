#include "hero_node.h"

#include "web/html/form_validator.h"
#include "web/html/html_builder.h"
#include "web/http/cookie.h"
#include "web/http/http_enums.h"
#include "web/http/http_session.h"
#include "web/http/request.h"
#include "web/http/session_manager.h"

#include "../html_macros.h"

#include "database/database.h"
#include "database/database_manager.h"
#include "database/query_builder.h"
#include "database/query_result.h"
#include "database/table_builder.h"

#include "crypto/hash/sha256.h"

void HeroNode::handle_request_default(Request *request) {
}

void HeroNode::admin_handle_request_main(Request *request) {
	request->send_error(404);
}
String HeroNode::admin_get_section_name() {
	return "Hero";
}
void HeroNode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Hero Editor", ""));
}
bool HeroNode::admin_full_render() {
	return false;
}

/*
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

*/

HeroNode::HeroNode() :
		AdminNode() {
}

HeroNode::~HeroNode() {
}
