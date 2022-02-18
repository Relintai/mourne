#include "unit_node.h"

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

void UnitNode::handle_request_default(Request *request) {
}

void UnitNode::admin_handle_request_main(Request *request) {
	request->send_error(404);
}
String UnitNode::admin_get_section_name() {
	return "News";
}
void UnitNode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- News Editor", ""));
}
bool UnitNode::admin_full_render() {
	return false;
}

/*
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


*/

UnitNode::UnitNode() :
		AdminNode() {
}

UnitNode::~UnitNode() {
}
