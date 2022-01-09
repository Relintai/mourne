#ifndef BUILDING_CONTROLLER_H
#define BUILDING_CONTROLLER_H

#include "core/string.h"
#include "core/containers/vector.h"

#include "modules/admin_panel/admin_node.h"

#include "building.h"

class Request;
class FormValidator;

class BuildingController : public AdminNode {
	RCPP_OBJECT(BuildingController, AdminNode);
	
public:
	void handle_request_default(Request *request);

	void admin_handle_request_main(Request *request);
	String admin_get_section_name();
	void admin_add_section_links(Vector<AdminSectionLinkInfo> *links);
	bool admin_full_render();

	void admin_render_building_list(Request *request);
	void admin_render_building(Request *request, Ref<Building> building);

	void migrate();
	virtual void add_default_data();

	static BuildingController *get_singleton();

	BuildingController();
	~BuildingController();

protected:
	static BuildingController *_self;
};

#endif