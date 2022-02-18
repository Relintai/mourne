#include "mail_node.h"

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

void MailNode::handle_request_default(Request *request) {
}

void MailNode::admin_handle_request_main(Request *request) {
	request->send_error(404);
}
String MailNode::admin_get_section_name() {
	return "Mail";
}
void MailNode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Mail Editor", ""));
}
bool MailNode::admin_full_render() {
	return false;
}

/*
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


*/

MailNode::MailNode() :
		AdminNode() {
}

MailNode::~MailNode() {
}
