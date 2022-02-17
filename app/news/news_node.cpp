#include "news_node.h"

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

void NewsNode::handle_request_default(Request *request) {
}

void NewsNode::admin_handle_request_main(Request *request) {
	request->send_error(404);
}
String NewsNode::admin_get_section_name() {
	return "News";
}
void NewsNode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- News Editor", ""));
}
bool NewsNode::admin_full_render() {
	return false;
}

NewsNode::NewsNode() :
		AdminNode() {
}

NewsNode::~NewsNode() {
}
