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

HeroNode::HeroNode() :
		AdminNode() {
}

HeroNode::~HeroNode() {
}
