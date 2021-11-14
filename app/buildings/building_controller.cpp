#include "building_controller.h"

#include "core/html/form_validator.h"
#include "core/html/html_builder.h"
#include "core/http/cookie.h"
#include "core/http/http_session.h"
#include "core/http/request.h"
#include "core/http/session_manager.h"

#include "building_model.h"
#include "building_model.h"

void BuildingController::handle_request_default(Request *request) {
}

void BuildingController::admin_handle_request_main(Request *request) {
	String seg = request->get_current_path_segment();

	if (seg == "") {
		admin_render_building_list(request);
		return;
	}

	request->send_error(404);
}
String BuildingController::admin_get_section_name() {
	return "Building Editor";
}
void BuildingController::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("Editor", ""));
}
bool BuildingController::admin_full_render() {
	return false;
}

void BuildingController::admin_render_building_list(Request *request) {
	Vector<Ref<Building> > buildings = BuildingModel::get_singleton()->get_all();

	HTMLBuilder b;

	b.div()->cls("back")->f()->a()->href(request->get_url_root_parent())->f()->w("<--- Back")->ca()->cdiv();
	b.br();
	b.h4()->f()->w("Building Editor")->ch4();
	b.br();
	b.div()->cls("top_menu")->f()->a()->href(request->get_url_root("new"))->f()->w("Create New")->ca()->cdiv();
	b.br();

	b.div()->cls("list_container");

	for (int i = 0; i < buildings.size(); ++i) {
		Ref<Building> building = buildings[i];

		if (!building.is_valid()) {
			continue;
		}

		if (i % 2 == 0) {
			b.div()->cls("row");
		} else {
			b.div()->cls("row second");
		}
		{
			b.div()->cls("attr_box")->f()->w(String::num(building->id))->cdiv();
			b.div()->cls("attr_box")->f()->w(String::num(building->rank))->cdiv();
			b.div()->cls("attr_box")->f()->w(String::num(building->next_rank))->cdiv();
			b.div()->cls("name")->f()->w(building->name)->cdiv();
			b.div()->cls("actionbox")->f()->a()->href(request->get_url_root("edit/" + String::num(building->id)))->f()->w("Edit")->ca()->cdiv();
		}
		b.cdiv();
	}

	b.cdiv();

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
