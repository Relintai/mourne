#include "building_controller.h"

#include "core/html/form_validator.h"
#include "core/html/html_builder.h"
#include "core/http/cookie.h"
#include "core/http/http_session.h"
#include "core/http/request.h"
#include "core/http/session_manager.h"

#include "building_model.h"

void BuildingController::handle_request_default(Request *request) {
}

void BuildingController::admin_handle_request_main(Request *request) {
	String seg = request->get_current_path_segment();

	if (seg == "") {
		admin_render_building_list(request);
		return;
	} else if (seg == "new") {
		request->push_path();
		admin_render_building(request, Ref<Building>());
		return;
	} else if (seg == "edit") {
		request->push_path();
		admin_render_building(request, Ref<Building>());
		return;
	}

	request->send_error(404);
}
String BuildingController::admin_get_section_name() {
	return "Buildings";
}
void BuildingController::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Building Editor", ""));
}
bool BuildingController::admin_full_render() {
	return false;
}

void BuildingController::admin_render_building_list(Request *request) {
	Vector<Ref<Building> > buildings = BuildingModel::get_singleton()->get_all();

	HTMLBuilder b;

	b.div("back")->f()->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Building Editor", "top_menu");
	b.br();
	b.div("top_menu")->f()->fa(request->get_url_root("new"), "Create New")->cdiv();
	b.br();

	b.div("list_container");

	for (int i = 0; i < buildings.size(); ++i) {
		Ref<Building> building = buildings[i];

		if (!building.is_valid()) {
			continue;
		}

		if (i % 2 == 0) {
			b.div("row");
		} else {
			b.div("row second");
		}
		{
			b.fdiv(String::num(building->id), "attr_box");
			b.fdiv(String::num(building->rank), "attr_box");
			b.fdiv(String::num(building->next_rank), "attr_box");
			b.fdiv(building->name, "name");

			b.div("actionbox")->f()->fa(request->get_url_root("edit/" + String::num(building->id)), "Edit")->cdiv();
		}
		b.cdiv();
	}

	b.cdiv();

	request->body += b.result;
}

void BuildingController::admin_render_building(Request *request, Ref<Building> building) {
	Vector<Ref<Building> > buildings = BuildingModel::get_singleton()->get_all();

	HTMLBuilder b;

	b.div("back")->f()->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Building Editor", "top_menu");
	b.br();

	request->body += b.result;
}

void BuildingController::migrate() {
	BuildingModel::get_singleton()->migrate();
}
void BuildingController::add_default_data() {
	BuildingModel::get_singleton()->add_default_data();
}

BuildingController *BuildingController::get_singleton() {
	return _self;
}

BuildingController::BuildingController() :
		AdminController() {

	if (_self) {
		printf("BuildingController::BuildingController(): Error! self is not null!/n");
	}

	_self = this;
}

BuildingController::~BuildingController() {
	if (_self == this) {
		_self = nullptr;
	}
}

BuildingController *BuildingController::_self = nullptr;
