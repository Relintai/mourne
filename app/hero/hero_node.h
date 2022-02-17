#ifndef HERO_NODE_H
#define HERO_NODE_H

#include "core/containers/vector.h"
#include "core/string.h"

#include "web_modules/admin_panel/admin_node.h"

class Request;
class FormValidator;
class QueryResult;

class HeroNode : public AdminNode {
	RCPP_OBJECT(HeroNode, AdminNode);

public:
	void handle_request_default(Request *request);

	void admin_handle_request_main(Request *request);
	String admin_get_section_name();
	void admin_add_section_links(Vector<AdminSectionLinkInfo> *links);
	bool admin_full_render();

	HeroNode();
	~HeroNode();
};

#endif