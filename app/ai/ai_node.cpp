#include "ai_node.h"

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

void AINode::handle_request_default(Request *request) {
}

void AINode::admin_handle_request_main(Request *request) {
	request->send_error(404);
}
String AINode::admin_get_section_name() {
	return "News";
}
void AINode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- News Editor", ""));
}
bool AINode::admin_full_render() {
	return false;
}

/*

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


*/

AINode::AINode() :
		AdminNode() {
}

AINode::~AINode() {
}
