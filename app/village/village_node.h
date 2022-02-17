#ifndef VILLAGE_NODE_H
#define VILLAGE_NODE_H

#include "core/containers/vector.h"
#include "core/string.h"

#include "web/http/web_node.h"

#include "village.h"

class Request;
class FormValidator;

class VillageNode : public WebNode {
	RCPP_OBJECT(VillageNode, WebNode);

public:
	virtual void handle_request_default(Request *request);

	void create_table();
	void drop_table();
	void create_default_entries();

	static VillageNode *get_singleton();

	VillageNode();
	~VillageNode();

protected:
	static VillageNode *_self;
};

#endif