#ifndef BUILDING_NODE_H
#define BUILDING_NODE_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "web_modules/admin_panel/admin_node.h"

#include "building.h"

class Request;
class FormValidator;
class QueryResult;

class BuildingNode : public AdminNode {
	RCPP_OBJECT(BuildingNode, AdminNode);
	
public:
	void handle_request_default(Request *request);

	void admin_handle_request_main(Request *request);
	String admin_get_section_name();
	void admin_add_section_links(Vector<AdminSectionLinkInfo> *links);
	bool admin_full_render();

	void admin_render_building_list(Request *request);
	void admin_render_building(Request *request, Ref<Building> building);

	virtual Ref<Building> db_get_building(const int id);
	virtual Vector<Ref<Building> > db_get_all();
	virtual void db_save_building(Ref<Building> &building);
	
	virtual void db_parse_row(Ref<QueryResult> &result, Ref<Building> &building);

	void create_table();
	void drop_table();
	void create_default_entries();

	static BuildingNode *get_singleton();

	BuildingNode();
	~BuildingNode();

protected:
	static BuildingNode *_self;
};

#endif