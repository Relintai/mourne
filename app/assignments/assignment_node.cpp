#include "assignment_node.h"

#include "web/html/form_validator.h"
#include "web/html/html_builder.h"
#include "web/http/cookie.h"
#include "web/http/http_enums.h"
#include "web/http/http_session.h"
#include "web/http/request.h"
#include "web/http/session_manager.h"

#include "database/database.h"
#include "database/database_manager.h"
#include "database/query_builder.h"
#include "database/query_result.h"
#include "database/table_builder.h"

#include "crypto/hash/sha256.h"

#include "../html_macros.h"


#define ASSIGNMENT_TABLE_NAME "assignments"

#define ASSIGNMENT_TABLE_COLUMNS "id, unitid, max, bonus_per_assigned, spellid, req_tech, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, description"
#define ASSIGNMENT_TABLE_COLUMNS_NOID "unitid, max, bonus_per_assigned, spellid, req_tech, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, description"


void AssignmentNode::handle_request_default(Request *request) {
}

void AssignmentNode::admin_handle_request_main(Request *request) {
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

		Ref<Assignment> b = db_get_assignment(bid);

		if (!b.is_valid()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		admin_render_assignment(request, b);
		return;
	}

	request->send_error(404);
}
String AssignmentNode::admin_get_section_name() {
	return "Assignments";
}
void AssignmentNode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Assignment Editor", ""));
}
bool AssignmentNode::admin_full_render() {
	return false;
}

void AssignmentNode::admin_render_assignment_list(Request *request) {
	Vector<Ref<Assignment> > assignments = db_get_all();

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

void AssignmentNode::admin_render_assignment(Request *request, Ref<Assignment> assignment) {
	if (!assignment.is_valid()) {
		RLOG_ERR("admin_render_assignment: !assignment.is_valid()\n");
		request->send_error(HTTP_STATUS_CODE_500_INTERNAL_SERVER_ERROR);
		return;
	}

	Vector<Ref<Assignment> > assignments = db_get_all();

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


Ref<Assignment> AssignmentNode::db_get_assignment(const int id) {
	if (id == 0) {
		return Ref<Assignment>();
	}

	Ref<QueryBuilder> b = get_query_builder();

	b->select(ASSIGNMENT_TABLE_COLUMNS);
	b->from(ASSIGNMENT_TABLE_NAME);

	b->where()->wp("id", id);

	b->end_command();

	Ref<QueryResult> r = b->run();

	if (!r->next_row()) {
		return Ref<Assignment>();
	}

	Ref<Assignment> assignment;
	assignment.instance();

	db_parse_row(r, assignment);

	return assignment;
}

Vector<Ref<Assignment> > AssignmentNode::db_get_all() {
	Ref<QueryBuilder> b = get_query_builder();

	b->select(ASSIGNMENT_TABLE_COLUMNS);
	b->from(ASSIGNMENT_TABLE_NAME);
	b->end_command();
	//b->print();

	Vector<Ref<Assignment> > assignments;

	Ref<QueryResult> r = b->run();

	while (r->next_row()) {
		Ref<Assignment> assignment;
		assignment.instance();

		db_parse_row(r, assignment);

		assignments.push_back(assignment);
	}

	return assignments;
}

void AssignmentNode::db_save_assignment(Ref<Assignment> &assignment) {
	Ref<QueryBuilder> b = get_query_builder();

	if (assignment->id == 0) {
		b->insert(ASSIGNMENT_TABLE_NAME, ASSIGNMENT_TABLE_COLUMNS_NOID);

		b->values();

		b->val(assignment->unitid);
		b->val(assignment->max);
		b->val(assignment->bonus_per_assigned);
		b->val(assignment->spellid);
		b->val(assignment->req_tech);

		b->val(assignment->mod_max_food);
		b->val(assignment->mod_max_wood);
		b->val(assignment->mod_max_stone);
		b->val(assignment->mod_max_iron);
		b->val(assignment->mod_max_mana);

		b->vald(assignment->mod_rate_food);
		b->vald(assignment->mod_rate_wood);
		b->vald(assignment->mod_rate_stone);
		b->vald(assignment->mod_rate_iron);
		b->vald(assignment->mod_rate_mana);

		b->val(assignment->mod_percent_food);
		b->val(assignment->mod_percent_wood);
		b->val(assignment->mod_percent_stone);
		b->val(assignment->mod_percent_iron);
		b->val(assignment->mod_percent_mana);

		b->val(assignment->description);

		b->cvalues();

		b->end_command();
		b->select_last_insert_id();
		//b->print();

		Ref<QueryResult> r = b->run();

		assignment->id = r->get_last_insert_rowid();
	} else {
		b->update(ASSIGNMENT_TABLE_NAME);
		b->set();
		
		b->setp("unitid", assignment->unitid);
		b->setp("max", assignment->max);
		b->setp("bonus_per_assigned", assignment->bonus_per_assigned);
		b->setp("spellid", assignment->spellid);
		b->setp("req_tech", assignment->req_tech);

		b->setp("mod_max_food", assignment->mod_max_food);
		b->setp("mod_max_wood", assignment->mod_max_wood);
		b->setp("mod_max_stone", assignment->mod_max_stone);
		b->setp("mod_max_iron", assignment->mod_max_iron);
		b->setp("mod_max_mana", assignment->mod_max_mana);

		b->setpd("mod_rate_food", assignment->mod_rate_food);
		b->setpd("mod_rate_wood", assignment->mod_rate_wood);
		b->setpd("mod_rate_stone", assignment->mod_rate_stone);
		b->setpd("mod_rate_iron", assignment->mod_rate_iron);
		b->setpd("mod_rate_mana", assignment->mod_rate_mana);

		b->setp("mod_percent_food", assignment->mod_percent_food);
		b->setp("mod_percent_wood", assignment->mod_percent_wood);
		b->setp("mod_percent_stone", assignment->mod_percent_stone);
		b->setp("mod_percent_iron", assignment->mod_percent_iron);
		b->setp("mod_percent_mana", assignment->mod_percent_mana);

		b->setp("description", assignment->description);

		b->cset();
		b->where()->wp("id", assignment->id);

		//b->print();

		b->run_query();
	}
}

void AssignmentNode::db_parse_row(Ref<QueryResult> &result, Ref<Assignment> &assignment) {

	assignment->id = result->get_cell_int(0);

	assignment->unitid = result->get_cell_int(1);
	assignment->max = result->get_cell_int(2);
	assignment->bonus_per_assigned = result->get_cell_int(3);
	assignment->spellid = result->get_cell_int(4);
	assignment->req_tech = result->get_cell_int(5);

	assignment->mod_max_food = result->get_cell_int(6);
	assignment->mod_max_wood = result->get_cell_int(7);
	assignment->mod_max_stone = result->get_cell_int(8);
	assignment->mod_max_iron = result->get_cell_int(9);
	assignment->mod_max_mana = result->get_cell_int(10);

	assignment->mod_rate_food = result->get_cell_double(11);
	assignment->mod_rate_wood = result->get_cell_double(12);
	assignment->mod_rate_stone = result->get_cell_double(13);
	assignment->mod_rate_iron = result->get_cell_double(14);
	assignment->mod_rate_mana = result->get_cell_double(15);

	assignment->mod_percent_food = result->get_cell_int(16);
	assignment->mod_percent_wood = result->get_cell_int(17);
	assignment->mod_percent_stone = result->get_cell_int(18);
	assignment->mod_percent_iron = result->get_cell_int(19);
	assignment->mod_percent_mana = result->get_cell_int(20);

	assignment->description = result->get_cell(21);
}

void AssignmentNode::create_table() {
	Ref<TableBuilder> tb = get_table_builder();

	tb->create_table(ASSIGNMENT_TABLE_NAME);

	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("unitid", 11)->not_null()->next_row(); //todo foreign key
	tb->integer("max", 11)->not_null()->defval("1")->next_row();
	tb->integer("bonus_per_assigned", 11)->not_null()->defval("1")->next_row();
	tb->integer("spellid", 11)->not_null()->defval("0")->next_row(); //todo foreign key
	tb->integer("req_tech", 11)->not_null()->defval("0")->next_row(); //todo foreign key

	tb->integer("mod_max_food", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_max_wood", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_max_stone", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_max_iron", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_max_mana", 11)->not_null()->defval("0")->next_row();

	tb->real_double("mod_rate_food")->not_null()->defval("0")->next_row();
	tb->real_double("mod_rate_wood")->not_null()->defval("0")->next_row();
	tb->real_double("mod_rate_stone")->not_null()->defval("0")->next_row();
	tb->real_double("mod_rate_iron")->not_null()->defval("0")->next_row();
	tb->real_double("mod_rate_mana")->not_null()->defval("0")->next_row();

	tb->integer("mod_percent_food", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_percent_wood", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_percent_stone", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_percent_iron", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_percent_mana", 11)->not_null()->defval("0")->next_row();

	tb->text("description")->not_null()->next_row();
	tb->primary_key("id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();
}
void AssignmentNode::drop_table() {
	Ref<TableBuilder> tb = get_table_builder();

	tb->drop_table_if_exists(ASSIGNMENT_TABLE_NAME)->cdrop_table();

	tb->run_query();
}

void AssignmentNode::create_default_entries() {
	String table_columns = "id, unitid, max, bonus_per_assigned, spellid, req_tech, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, description";

	Ref<QueryBuilder> qb = get_query_builder();

	qb->begin_transaction()->nl();
	qb->insert(ASSIGNMENT_TABLE_NAME, table_columns)->nl()->w("VALUES(1, 1, 10, 2, 0, 0, 0, 0, 0, 0, 0, 0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'This building will produce more food, every 2 villager you assign.')")->end_command()->nl();
	qb->insert(ASSIGNMENT_TABLE_NAME, table_columns)->nl()->w("VALUES(2, 1, 10, 5, 0, 0, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Every 5 Villager you assign, you get +30 Maximum Food.')")->end_command()->nl();
	qb->insert(ASSIGNMENT_TABLE_NAME, table_columns)->nl()->w("VALUES(3, 1, 10, 10, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Assigning 10 Villager will grant you an awesome spell.')")->end_command()->nl();
	qb->insert(ASSIGNMENT_TABLE_NAME, table_columns)->nl()->w("VALUES(4, 1, 10, 10, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Adds a spell, and tests the requirements.')")->end_command()->nl();
	qb->commit();

	qb->run_query();
	//qb->print();
}


AssignmentNode *AssignmentNode::get_singleton() {
	return _self;
}

AssignmentNode::AssignmentNode() :
		AdminNode() {

	if (_self) {
		printf("AssignmentNode::AssignmentNode(): Error! self is not null!/n");
	}

	_self = this;
}

AssignmentNode::~AssignmentNode() {
	if (_self == this) {
		_self = nullptr;
	}
}

AssignmentNode *AssignmentNode::_self = nullptr;
