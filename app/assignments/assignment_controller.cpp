#include "assignment_controller.h"

#include "web/html/form_validator.h"
#include "web/html/html_builder.h"
#include "web/http/cookie.h"
#include "web/http/http_enums.h"
#include "web/http/http_session.h"
#include "web/http/request.h"
#include "web/http/session_manager.h"

#include "assignment_model.h"

#include "../html_macros.h"

void AssignmentController::handle_request_default(Request *request) {
}

void AssignmentController::admin_handle_request_main(Request *request) {
	String seg = request->get_current_path_segment();

	if (seg == "") {
		admin_render_assignment_list(request);
		return;
	} else if (seg == "new") {
		request->push_path();
		Ref<Assignment> b;
		b.instance();

		admin_render_assignment(request, b);
		return;
	} else if (seg == "edit") {
		request->push_path();

		String seg_assignment_id = request->get_current_path_segment();

		if (!seg_assignment_id.is_int()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		int bid = seg_assignment_id.to_int();

		Ref<Assignment> b = AssignmentModel::get_singleton()->get_assignment(bid);

		if (!b.is_valid()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		admin_render_assignment(request, b);
		return;
	}

	request->send_error(404);
}
String AssignmentController::admin_get_section_name() {
	return "Assignments";
}
void AssignmentController::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Assignment Editor", ""));
}
bool AssignmentController::admin_full_render() {
	return false;
}

void AssignmentController::admin_render_assignment_list(Request *request) {
	Vector<Ref<Assignment> > assignments = AssignmentModel::get_singleton()->get_all();

	HTMLBuilder b;

	b.div("back")->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Assignment Editor", "top_menu");
	b.br();
	b.div("top_menu")->fa(request->get_url_root("new"), "Create New")->cdiv();
	b.br();

	b.div("list_container");

	for (int i = 0; i < assignments.size(); ++i) {
		Ref<Assignment> assignment = assignments[i];

		if (!assignment.is_valid()) {
			continue;
		}

		if (i % 2 == 0) {
			b.div("row");
		} else {
			b.div("row second");
		}
		{
			b.fdiv(String::num(assignment->id), "attr_box");
			b.fdiv(assignment->description, "name");

			b.div("actionbox")->fa(request->get_url_root("edit/" + String::num(assignment->id)), "Edit")->cdiv();
		}
		b.cdiv();
	}

	b.cdiv();

	request->body += b.result;
}

void AssignmentController::admin_render_assignment(Request *request, Ref<Assignment> assignment) {
	if (!assignment.is_valid()) {
		RLOG_ERR("admin_render_assignment: !assignment.is_valid()\n");
		request->send_error(HTTP_STATUS_CODE_500_INTERNAL_SERVER_ERROR);
		return;
	}

	Vector<Ref<Assignment> > assignments = AssignmentModel::get_singleton()->get_all();

	HTMLBuilder b;

	b.div("back")->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Assignment Editor", "top_menu");
	b.br();

	b.form_post(request->get_url_root());

	bool show_post = false; //request->get_method() == HTTP_METHOD_POST && validation errors;

	//Todo make it a dropdown
	ADMIN_EDIT_INPUT_TEXT("Unitid:", "unitid", show_post, String::num(assignment->unitid), request->get_parameter("unitid"));
	ADMIN_EDIT_INPUT_TEXT("max:", "max", show_post, String::num(assignment->max), request->get_parameter("max"));
	ADMIN_EDIT_INPUT_TEXT("bonus_per_assigned:", "bonus_per_assigned", show_post, String::num(assignment->bonus_per_assigned), request->get_parameter("bonus_per_assigned"));
	ADMIN_EDIT_INPUT_TEXT("spellid:", "spellid", show_post, String::num(assignment->spellid), request->get_parameter("spellid"));
	//Todo make it a dropdown
	ADMIN_EDIT_INPUT_TEXT("req_tech:", "req_tech", show_post, String::num(assignment->req_tech), request->get_parameter("req_tech"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Max Food:", "mod_max_food", show_post, String::num(assignment->mod_max_food), request->get_parameter("mod_max_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Wood:", "mod_max_wood", show_post, String::num(assignment->mod_max_wood), request->get_parameter("mod_max_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Stone:", "mod_max_stone", show_post, String::num(assignment->mod_max_stone), request->get_parameter("mod_max_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Iron:", "mod_max_iron", show_post, String::num(assignment->mod_max_iron), request->get_parameter("mod_max_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Mana:", "mod_max_mana", show_post, String::num(assignment->mod_max_mana), request->get_parameter("mod_max_mana"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Rate Food:", "mod_rate_food", show_post, String::num(assignment->mod_rate_food), request->get_parameter("mod_rate_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Rate Wood:", "mod_rate_wood", show_post, String::num(assignment->mod_rate_wood), request->get_parameter("mod_rate_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Rate Stone:", "mod_rate_stone", show_post, String::num(assignment->mod_rate_stone), request->get_parameter("mod_rate_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Rate Iron:", "mod_rate_iron", show_post, String::num(assignment->mod_rate_iron), request->get_parameter("mod_rate_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Rate Mana:", "mod_rate_mana", show_post, String::num(assignment->mod_rate_mana), request->get_parameter("mod_rate_mana"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Percent Food:", "mod_percent_food", show_post, String::num(assignment->mod_percent_food), request->get_parameter("mod_percent_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Wood:", "mod_percent_wood", show_post, String::num(assignment->mod_percent_wood), request->get_parameter("mod_percent_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Stone:", "mod_percent_stone", show_post, String::num(assignment->mod_percent_stone), request->get_parameter("mod_percent_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Iron:", "mod_percent_iron", show_post, String::num(assignment->mod_percent_iron), request->get_parameter("mod_percent_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Mana:", "mod_percent_mana", show_post, String::num(assignment->mod_percent_mana), request->get_parameter("mod_percent_mana"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXTAREA("Description:", "description", show_post, assignment->description, request->get_parameter("description"));

	b.div("edit_submit")->input_submit("Save", "submit")->cdiv();

	b.cform();

	request->body += b.result;
}

void AssignmentController::create_table() {
	AssignmentModel::get_singleton()->create_table();
}
void AssignmentController::drop_table() {
	AssignmentModel::get_singleton()->drop_table();
}
void AssignmentController::create_default_entries() {
	AssignmentModel::get_singleton()->create_default_entries();
}

AssignmentController *AssignmentController::get_singleton() {
	return _self;
}

AssignmentController::AssignmentController() :
		AdminNode() {

	if (_self) {
		printf("AssignmentController::AssignmentController(): Error! self is not null!/n");
	}

	_self = this;
}

AssignmentController::~AssignmentController() {
	if (_self == this) {
		_self = nullptr;
	}
}

AssignmentController *AssignmentController::_self = nullptr;
