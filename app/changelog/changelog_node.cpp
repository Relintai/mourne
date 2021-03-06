#include "changelog_node.h"

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

void ChangelogNode::handle_request_default(Request *request) {
}

void ChangelogNode::admin_handle_request_main(Request *request) {
	request->send_error(404);
}
String ChangelogNode::admin_get_section_name() {
	return "Changelog";
}
void ChangelogNode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Changelog Editor", ""));
}
bool ChangelogNode::admin_full_render() {
	return false;
}

/*
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

*/

ChangelogNode::ChangelogNode() :
		AdminNode() {
}

ChangelogNode::~ChangelogNode() {
}
