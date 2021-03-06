#include "building_node.h"

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


#define BUILDING_TABLE_NAME "buildings"

#define BUILDING_TABLE_COLUMNS "id, name, description, icon, rank, next_rank, time_to_build, creates, num_creates, score, defense, ability, cost_food, cost_wood, cost_stone, cost_iron, cost_mana, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, assignment1, assignment2, assignment3, assignment4, assignment5, req_tech, tech_group, tech_secondary_group"
#define BUILDING_TABLE_COLUMNS_NOID "name, description, icon, rank, next_rank, time_to_build, creates, num_creates, score, defense, ability, cost_food, cost_wood, cost_stone, cost_iron, cost_mana, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, assignment1, assignment2, assignment3, assignment4, assignment5, req_tech, tech_group, tech_secondary_group"


void BuildingNode::handle_request_default(Request *request) {
}

void BuildingNode::admin_handle_request_main(Request *request) {
	String seg = request->get_current_path_segment();

	if (seg == "") {
		admin_render_building_list(request);
		return;
	} else if (seg == "new") {
		request->push_path();
		Ref<Building> b;
		b.instance();

		admin_render_building(request, b);
		return;
	} else if (seg == "edit") {
		request->push_path();

		String seg_building_id = request->get_current_path_segment();

		if (!seg_building_id.is_int()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		int bid = seg_building_id.to_int();

		Ref<Building> b = db_get_building(bid);

		if (!b.is_valid()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		admin_render_building(request, b);
		return;
	}

	request->send_error(404);
}
String BuildingNode::admin_get_section_name() {
	return "Buildings";
}
void BuildingNode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Building Editor", ""));
}
bool BuildingNode::admin_full_render() {
	return false;
}

void BuildingNode::admin_render_building_list(Request *request) {
	Vector<Ref<Building> > buildings = db_get_all();

	HTMLBuilder b;

	b.div("back")->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Building Editor", "top_menu");
	b.br();
	b.div("top_menu")->fa(request->get_url_root("new"), "Create New")->cdiv();
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

			b.div("actionbox")->fa(request->get_url_root("edit/" + String::num(building->id)), "Edit")->cdiv();
		}
		b.cdiv();
	}

	b.cdiv();

	request->body += b.result;
}

void BuildingNode::admin_render_building(Request *request, Ref<Building> building) {
	if (!building.is_valid()) {
		RLOG_ERR("admin_render_building: !building.is_valid()\n");
		request->send_error(HTTP_STATUS_CODE_500_INTERNAL_SERVER_ERROR);
		return;
	}

	Vector<Ref<Building> > buildings = db_get_all();

	HTMLBuilder b;

	b.div("back")->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Building Editor", "top_menu");
	b.br();

	b.form_post(request->get_url_root());

	bool show_post = false; //request->get_method() == HTTP_METHOD_POST && validation errors;

	ADMIN_EDIT_INPUT_TEXT("Name:", "name", show_post, building->name, request->get_parameter("name"));
	ADMIN_EDIT_INPUT_TEXTAREA("Description:", "description", show_post, building->description, request->get_parameter("description"));

	b.div("row_edit");
	b.fdiv("Icon:", "edit_name");
	//todo I'm not sure yet how this worked originally
	//b.div("edit_input")->f()->input_image("icon", building->icon)->f()->cdiv();
	b.div("edit_input")->w("TODO")->cdiv();
	b.cdiv();

	ADMIN_EDIT_INPUT_TEXT("Rank:", "rank", show_post, String::num(building->rank), request->get_parameter("rank"));

	Vector<Ref<Building> > nrbs = db_get_all();
	b.div("row_edit");
	b.fdiv("Next Rank:", "edit_name");
	b.div("edit_input");
	{
		b.select("next_rank", "drop");
		{
			int current_id = building->id;
			int current_nr = building->next_rank;

			b.foption(String::num(0), "- None -", current_nr == 0);

			for (int i = 0; i < nrbs.size(); ++i) {
				Ref<Building> build = nrbs[i];

				int id = build->id;

				if (id == current_id) {
					continue;
				}

				b.foption(String::num(id), build->name + " R" + String::num(build->rank), current_nr == id);
			}
		}
		b.cselect();
	}
	b.cdiv();
	b.cdiv();

	ADMIN_EDIT_INPUT_TEXT("Time to Build:", "time_to_build", show_post, String::num(building->time_to_build), request->get_parameter("time_to_build"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Score:", "score", show_post, String::num(building->score), request->get_parameter("score"));
	ADMIN_EDIT_INPUT_TEXT("Defense:", "defense", show_post, String::num(building->defense), request->get_parameter("defense"));

	//TODO
	/*
		int ability;

		<div class="row_edit">
		<div class="edit_name">
		Ability:
		</div>
		<div class="edit_input">
		<?=form_dropdown('ability', $opt_ability, $sability, $attr_drop); ?>
		</div>
		</div>
	*/

	b.div("row_edit");
	b.fdiv("Ability:", "edit_name");
	b.div("edit_input")->w("TODO")->cdiv();
	b.cdiv();

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Cost Food:", "cost_food", show_post, String::num(building->cost_food), request->get_parameter("cost_food"));
	ADMIN_EDIT_INPUT_TEXT("Cost Wood:", "cost_wood", show_post, String::num(building->cost_wood), request->get_parameter("cost_wood"));
	ADMIN_EDIT_INPUT_TEXT("Cost Stone:", "cost_stone", show_post, String::num(building->cost_stone), request->get_parameter("cost_stone"));
	ADMIN_EDIT_INPUT_TEXT("Cost Iron:", "cost_iron", show_post, String::num(building->cost_iron), request->get_parameter("cost_iron"));
	ADMIN_EDIT_INPUT_TEXT("Cost Mana:", "cost_mana", show_post, String::num(building->cost_food), request->get_parameter("cost_mana"));

	ADMIN_EDIT_LINE_SPACER();

/*
	int creates;
	int num_creates;

	<div class="row_edit">
	<div class="edit_name">
	Creates:
	</div>
	<div class="edit_input">
	<?=form_dropdown($name_creates, $optcre, $screate, $attr_creates); ?>
	X (max) <?=form_input($attr_num_creates); ?>
	</div>
	</div>
*/

	b.div("row_edit");
	b.fdiv("Creates:", "edit_name");
	b.div("edit_input")->w("TODO")->cdiv();
	b.cdiv();

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Max Food:", "mod_max_food", show_post, String::num(building->mod_max_food), request->get_parameter("mod_max_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Wood:", "mod_max_wood", show_post, String::num(building->mod_max_wood), request->get_parameter("mod_max_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Stone:", "mod_max_stone", show_post, String::num(building->mod_max_stone), request->get_parameter("mod_max_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Iron:", "mod_max_iron", show_post, String::num(building->mod_max_iron), request->get_parameter("mod_max_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Mana:", "mod_max_mana", show_post, String::num(building->mod_max_mana), request->get_parameter("mod_max_mana"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Rate Food:", "mod_rate_food", show_post, String::num(building->mod_rate_food), request->get_parameter("mod_rate_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Rate Wood:", "mod_rate_wood", show_post, String::num(building->mod_rate_wood), request->get_parameter("mod_rate_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Rate Stone:", "mod_rate_stone", show_post, String::num(building->mod_rate_stone), request->get_parameter("mod_rate_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Rate Iron:", "mod_rate_iron", show_post, String::num(building->mod_rate_iron), request->get_parameter("mod_rate_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Rate Mana:", "mod_rate_mana", show_post, String::num(building->mod_rate_mana), request->get_parameter("mod_rate_mana"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Percent Food:", "mod_percent_food", show_post, String::num(building->mod_percent_food), request->get_parameter("mod_percent_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Wood:", "mod_percent_wood", show_post, String::num(building->mod_percent_wood), request->get_parameter("mod_percent_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Stone:", "mod_percent_stone", show_post, String::num(building->mod_percent_stone), request->get_parameter("mod_percent_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Iron:", "mod_percent_iron", show_post, String::num(building->mod_percent_iron), request->get_parameter("mod_percent_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Mana:", "mod_percent_mana", show_post, String::num(building->mod_percent_mana), request->get_parameter("mod_percent_mana"));

	ADMIN_EDIT_LINE_SPACER();

	//TODO <?=form_dropdown($name_assign1, $optass, $assign1, $attr_assign); ?>

	ADMIN_EDIT_INPUT_TEXT("Assignment 1:", "assignment1", show_post, String::num(building->assignment1), request->get_parameter("assignment1"));
	ADMIN_EDIT_INPUT_TEXT("Assignment 2:", "assignment2", show_post, String::num(building->assignment2), request->get_parameter("assignment2"));
	ADMIN_EDIT_INPUT_TEXT("Assignment 3:", "assignment3", show_post, String::num(building->assignment3), request->get_parameter("assignment3"));
	ADMIN_EDIT_INPUT_TEXT("Assignment 4:", "assignment4", show_post, String::num(building->assignment4), request->get_parameter("assignment4"));
	ADMIN_EDIT_INPUT_TEXT("Assignment 5:", "assignment5", show_post, String::num(building->assignment5), request->get_parameter("assignment5"));

	ADMIN_EDIT_LINE_SPACER();

	//TODO <?=form_dropdown($name_req_tech, $optreqtech, $selreqtech, $attr_req_tech); ?>
	ADMIN_EDIT_INPUT_TEXT("Required Technology:", "req_tech", show_post, String::num(building->req_tech), request->get_parameter("req_tech"));
	ADMIN_EDIT_LINE_SPACER();
	//TODO <?=form_dropdown($name_tech_group, $opttechgroup, $seltechgroup, $attr_assign);?>
	ADMIN_EDIT_INPUT_TEXT("Technology Group:", "tech_group", show_post, String::num(building->tech_group), request->get_parameter("tech_group"));
	ADMIN_EDIT_LINE_SPACER();
	//TODO <?=form_dropdown($name_tech_secondary_group, $opttechgroup, $seltechsecgroup, $attr_tech_secondary_group); ?>
	ADMIN_EDIT_INPUT_TEXT("Secondary Technology Group:", "tech_secondary_group", show_post, String::num(building->tech_secondary_group), request->get_parameter("tech_secondary_group"));

	b.div("edit_submit")->input_submit("Save", "submit")->cdiv();

	b.cform();

	request->body += b.result;
}

Ref<Building> BuildingNode::db_get_building(const int id) {
	if (id == 0) {
		return Ref<Building>();
	}

	Ref<QueryBuilder> b = get_query_builder();

	b->select(BUILDING_TABLE_COLUMNS);
	b->from(BUILDING_TABLE_NAME);

	b->where()->wp("id", id);

	b->end_command();

	Ref<QueryResult> r = b->run();

	if (!r->next_row()) {
		return Ref<Building>();
	}

	Ref<Building> building;
	building.instance();

	db_parse_row(r, building);

	return building;
}

Vector<Ref<Building> > BuildingNode::db_get_all() {
	Ref<QueryBuilder> b = get_query_builder();

	b->select(BUILDING_TABLE_COLUMNS);
	b->from(BUILDING_TABLE_NAME);
	b->end_command();
	//b->print();

	Vector<Ref<Building> > buildings;

	Ref<QueryResult> r = b->run();

	while (r->next_row()) {
		Ref<Building> building;
		building.instance();

		db_parse_row(r, building);

		buildings.push_back(building);
	}

	return buildings;
}

void BuildingNode::db_save_building(Ref<Building> &building) {
	Ref<QueryBuilder> b = get_query_builder();

	if (building->id == 0) {
		b->insert(BUILDING_TABLE_NAME, BUILDING_TABLE_COLUMNS_NOID);

		b->values();

		b->val(building->name);
		b->val(building->description);
		b->val(building->icon);

		b->val(building->rank);
		b->val(building->next_rank);
		b->val(building->time_to_build);
		b->val(building->creates);
		b->val(building->num_creates);
		b->val(building->score);
		b->val(building->defense);
		b->val(building->ability);

		b->val(building->cost_food);
		b->val(building->cost_wood);
		b->val(building->cost_stone);
		b->val(building->cost_iron);
		b->val(building->cost_mana);

		b->val(building->mod_max_food);
		b->val(building->mod_max_wood);
		b->val(building->mod_max_stone);
		b->val(building->mod_max_iron);
		b->val(building->mod_max_mana);

		b->vald(building->mod_rate_food);
		b->vald(building->mod_rate_wood);
		b->vald(building->mod_rate_stone);
		b->vald(building->mod_rate_iron);
		b->vald(building->mod_rate_mana);

		b->val(building->mod_percent_food);
		b->val(building->mod_percent_wood);
		b->val(building->mod_percent_stone);
		b->val(building->mod_percent_iron);
		b->val(building->mod_percent_mana);

		b->val(building->assignment1);
		b->val(building->assignment2);
		b->val(building->assignment3);
		b->val(building->assignment4);
		b->val(building->assignment5);

		b->val(building->req_tech);
		b->val(building->tech_group);
		b->val(building->tech_secondary_group);

		b->cvalues();

		b->end_command();
		b->select_last_insert_id();
		//b->print();

		Ref<QueryResult> r = b->run();

		building->id = r->get_last_insert_rowid();
	} else {
		b->update(BUILDING_TABLE_NAME);
		b->set();

		b->setp("name", building->name);
		b->setp("description", building->description);
		b->setp("icon", building->icon);

		b->setp("userankrname", building->rank);
		b->setp("next_rank", building->next_rank);
		b->setp("time_to_build", building->time_to_build);
		b->setp("creates", building->creates);
		b->setp("num_creates", building->num_creates);
		b->setp("score", building->score);
		b->setp("defense", building->defense);
		b->setp("ability", building->ability);

		b->setp("cost_food", building->cost_food);
		b->setp("cost_wood", building->cost_wood);
		b->setp("cost_stone", building->cost_stone);
		b->setp("cost_iron", building->cost_iron);
		b->setp("cost_mana", building->cost_mana);

		b->setp("mod_max_food", building->mod_max_food);
		b->setp("mod_max_wood", building->mod_max_wood);
		b->setp("mod_max_stone", building->mod_max_stone);
		b->setp("mod_max_iron", building->mod_max_iron);
		b->setp("mod_max_mana", building->mod_max_mana);

		b->setpd("mod_rate_food", building->mod_rate_food);
		b->setpd("mod_rate_wood", building->mod_rate_wood);
		b->setpd("mod_rate_stone", building->mod_rate_stone);
		b->setpd("mod_rate_iron", building->mod_rate_iron);
		b->setpd("mod_rate_mana", building->mod_rate_mana);

		b->setp("mod_percent_food", building->mod_percent_food);
		b->setp("mod_percent_wood", building->mod_percent_wood);
		b->setp("mod_percent_stone", building->mod_percent_stone);
		b->setp("mod_percent_iron", building->mod_percent_iron);
		b->setp("mod_percent_mana", building->mod_percent_mana);

		b->setp("assignment1", building->assignment1);
		b->setp("assignment2", building->assignment2);
		b->setp("assignment3", building->assignment3);
		b->setp("assignment4", building->assignment4);
		b->setp("assignment5", building->assignment5);

		b->setp("req_tech", building->req_tech);
		b->setp("tech_group", building->tech_group);
		b->setp("tech_secondary_group", building->tech_secondary_group);

		b->cset();
		b->where()->wp("id", building->id);

		//b->print();

		b->run_query();
	}
}

void BuildingNode::db_parse_row(Ref<QueryResult> &result, Ref<Building> &building) {

	building->id = result->get_cell_int(0);

	building->name = result->get_cell(1);
	building->description = result->get_cell(2);
	building->icon = result->get_cell(3);

	building->rank = result->get_cell_int(4);
	building->next_rank = result->get_cell_int(5);
	building->time_to_build = result->get_cell_int(6);
	building->creates = result->get_cell_int(7);
	building->num_creates = result->get_cell_int(8);
	building->score = result->get_cell_int(9);
	building->defense = result->get_cell_int(10);
	building->ability = result->get_cell_int(11);

	building->cost_food = result->get_cell_int(12);
	building->cost_wood = result->get_cell_int(13);
	building->cost_stone = result->get_cell_int(14);
	building->cost_iron = result->get_cell_int(15);
	building->cost_mana = result->get_cell_int(16);

	building->mod_max_food = result->get_cell_int(17);
	building->mod_max_wood = result->get_cell_int(18);
	building->mod_max_stone = result->get_cell_int(19);
	building->mod_max_iron = result->get_cell_int(20);
	building->mod_max_mana = result->get_cell_int(21);

	building->mod_rate_food = result->get_cell_double(22);
	building->mod_rate_wood = result->get_cell_double(23);
	building->mod_rate_stone = result->get_cell_double(24);
	building->mod_rate_iron = result->get_cell_double(25);
	building->mod_rate_mana = result->get_cell_double(26);

	building->mod_percent_food = result->get_cell_int(27);
	building->mod_percent_wood = result->get_cell_int(28);
	building->mod_percent_stone = result->get_cell_int(29);
	building->mod_percent_iron = result->get_cell_int(30);
	building->mod_percent_mana = result->get_cell_int(31);

	building->assignment1 = result->get_cell_int(32);
	building->assignment2 = result->get_cell_int(33);
	building->assignment3 = result->get_cell_int(34);
	building->assignment4 = result->get_cell_int(35);
	building->assignment5 = result->get_cell_int(36);

	building->req_tech = result->get_cell_int(37);
	building->tech_group = result->get_cell_int(38);
	building->tech_secondary_group = result->get_cell_int(39);
}

void BuildingNode::create_table() {
	Ref<TableBuilder> tb = get_table_builder();

	tb->create_table(BUILDING_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->varchar("name", 200)->not_null()->next_row();
	tb->varchar("description", 500)->not_null()->next_row();
	tb->varchar("icon", 500)->not_null()->next_row();
	tb->integer("rank", 11)->not_null()->next_row();
	tb->integer("next_rank", 11)->not_null()->next_row();
	tb->integer("time_to_build", 11)->not_null()->next_row();
	tb->integer("creates", 11)->not_null()->defval("0")->next_row();
	tb->integer("num_creates", 11)->not_null()->defval("0")->next_row();
	tb->integer("score", 11)->not_null()->next_row();
	tb->integer("defense", 11)->not_null()->next_row();
	tb->integer("ability", 11)->not_null()->defval("0")->next_row();

	tb->integer("cost_food", 11)->not_null()->next_row();
	tb->integer("cost_wood", 11)->not_null()->next_row();
	tb->integer("cost_stone", 11)->not_null()->next_row();
	tb->integer("cost_iron", 11)->not_null()->next_row();
	tb->integer("cost_mana", 11)->not_null()->next_row();

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

	tb->integer("assignment1", 11)->not_null()->defval("0")->next_row();
	tb->integer("assignment2", 11)->not_null()->defval("0")->next_row();
	tb->integer("assignment3", 11)->not_null()->defval("0")->next_row();
	tb->integer("assignment4", 11)->not_null()->defval("0")->next_row();
	tb->integer("assignment5", 11)->not_null()->defval("0")->next_row();

	tb->integer("req_tech", 11)->not_null()->defval("0")->next_row();
	tb->integer("tech_group", 11)->not_null()->defval("0")->next_row();
	tb->integer("tech_secondary_group", 11)->not_null()->defval("0")->next_row();

	tb->primary_key("id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();

	/*

CREATE TABLE IF NOT EXISTS `spells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `effect` int(11) NOT NULL DEFAULT '0',
  `duration` int(11) NOT NULL DEFAULT '0',
  `cooldown` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `description_admin` text NOT NULL,
  `weather_change_to` int(11) NOT NULL DEFAULT '0',
  `cost_food` int(11) NOT NULL DEFAULT '0',
  `cost_wood` int(11) NOT NULL DEFAULT '0',
  `cost_stone` int(11) NOT NULL DEFAULT '0',
  `cost_iron` int(11) NOT NULL DEFAULT '0',
  `cost_mana` int(11) NOT NULL DEFAULT '0',
  `mod_max_food` int(11) NOT NULL DEFAULT '0',
  `mod_max_wood` int(11) NOT NULL DEFAULT '0',
  `mod_max_stone` int(11) NOT NULL DEFAULT '0',
  `mod_max_iron` int(11) NOT NULL DEFAULT '0',
  `mod_max_mana` int(11) NOT NULL DEFAULT '0',
  `mod_rate_food` float NOT NULL DEFAULT '0',
  `mod_rate_wood` float NOT NULL DEFAULT '0',
  `mod_rate_stone` float NOT NULL DEFAULT '0',
  `mod_rate_iron` float NOT NULL DEFAULT '0',
  `mod_rate_mana` float NOT NULL DEFAULT '0',
  `mod_percent_food` int(11) NOT NULL DEFAULT '0',
  `mod_percent_wood` int(11) NOT NULL DEFAULT '0',
  `mod_percent_stone` int(11) NOT NULL DEFAULT '0',
  `mod_percent_iron` int(11) NOT NULL DEFAULT '0',
  `mod_percent_mana` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `spells`
--

INSERT INTO `spells` (`id`, `effect`, `duration`, `cooldown`, `description`, `description_admin`, `weather_change_to`, `cost_food`, `cost_wood`, `cost_stone`, `cost_iron`, `cost_mana`, `mod_max_food`, `mod_max_wood`, `mod_max_stone`, `mod_max_iron`, `mod_max_mana`, `mod_rate_food`, `mod_rate_wood`, `mod_rate_stone`, `mod_rate_iron`, `mod_rate_mana`, `mod_percent_food`, `mod_percent_wood`, `mod_percent_stone`, `mod_percent_iron`, `mod_percent_mana`) VALUES
(1, 0, 60, 70, 'Increases productivity of this building, by a small amount.', 'Test spell', 0, 400, 100, 100, 100, 100, 100, 100, 100, 100, 100, 0, 0, 0, 0, 0, 10, 10, 10, 10, 10),
(2, 0, 100, 100, 'Increases the food production rate of this building.', 'Test spell 2 (over the top crazy)', 0, 140, 140, 140, 140, 140, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0);


	*/

/*

CREATE TABLE IF NOT EXISTS `technologies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `score` int(11) NOT NULL DEFAULT '0',
  `cost_food` int(11) NOT NULL DEFAULT '0',
  `cost_wood` int(11) NOT NULL DEFAULT '0',
  `cost_stone` int(11) NOT NULL DEFAULT '0',
  `cost_iron` int(11) NOT NULL DEFAULT '0',
  `cost_mana` int(11) NOT NULL DEFAULT '0',
  `mod_max_food` int(11) NOT NULL DEFAULT '0',
  `mod_max_wood` int(11) NOT NULL DEFAULT '0',
  `mod_max_stone` int(11) NOT NULL DEFAULT '0',
  `mod_max_iron` int(11) NOT NULL DEFAULT '0',
  `mod_max_mana` int(11) NOT NULL DEFAULT '0',
  `mod_rate_food` float NOT NULL DEFAULT '0',
  `mod_rate_wood` float NOT NULL DEFAULT '0',
  `mod_rate_stone` float NOT NULL DEFAULT '0',
  `mod_rate_iron` float NOT NULL DEFAULT '0',
  `mod_rate_mana` float NOT NULL DEFAULT '0',
  `mod_percent_food` int(11) NOT NULL DEFAULT '0',
  `mod_percent_wood` int(11) NOT NULL DEFAULT '0',
  `mod_percent_stone` int(11) NOT NULL DEFAULT '0',
  `mod_percent_iron` int(11) NOT NULL DEFAULT '0',
  `mod_percent_mana` int(11) NOT NULL DEFAULT '0',
  `mod_create_id` int(11) NOT NULL DEFAULT '0',
  `mod_spell_id` int(11) NOT NULL DEFAULT '0',
  `flag_ai` int(11) NOT NULL DEFAULT '0',
  `is_secondary` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `technologies`
--

INSERT INTO `technologies` (`id`, `description`, `time`, `score`, `cost_food`, `cost_wood`, `cost_stone`, `cost_iron`, `cost_mana`, `mod_max_food`, `mod_max_wood`, `mod_max_stone`, `mod_max_iron`, `mod_max_mana`, `mod_rate_food`, `mod_rate_wood`, `mod_rate_stone`, `mod_rate_iron`, `mod_rate_mana`, `mod_percent_food`, `mod_percent_wood`, `mod_percent_stone`, `mod_percent_iron`, `mod_percent_mana`, `mod_create_id`, `mod_spell_id`, `flag_ai`, `is_secondary`) VALUES
(1, 'This will do something.', 0, 0, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0.001, 0.001, 0.001, 0.001, 0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Allows you to track bugs.', 0, 0, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0.1, 0.1, 0.1, 0.1, 0.1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'Corn F opt test', 60, 0, 100, 100, 100, 100, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 'Corn F opt test 2', 60, 0, 200, 200, 200, 200, 200, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 'Corn F test3', 60, 0, 100, 100, 100, 100, 100, 30, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'Test for the wicked.', 50, 10, 100000, 10000, 10000, 20000000, 20000, 30000, 20000, 20000, 20000, 20000, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `technology_groups`
--

CREATE TABLE IF NOT EXISTS `technology_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `technologyid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `technology_groups`
--

INSERT INTO `technology_groups` (`id`, `groupid`, `technologyid`) VALUES
(3, 1, 1),
(4, 1, 2),
(5, 2, 1),
(7, 3, 3),
(8, 3, 4),
(11, 2, 2),
(12, 2, 5),
(13, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `technology_group_descriptions`
--

CREATE TABLE IF NOT EXISTS `technology_group_descriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `technology_group_descriptions`
--

INSERT INTO `technology_group_descriptions` (`id`, `group_name`) VALUES
(1, 'Lumber Mill R1-5'),
(2, 'Corn Field R1-5'),
(3, 'Corn Field R1-5 Sec');

-- --------------------------------------------------------

--
-- Table structure for table `technology_have_requirements`
--

CREATE TABLE IF NOT EXISTS `technology_have_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `technologyid` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `technologyid` (`technologyid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `technology_have_requirements`
--

INSERT INTO `technology_have_requirements` (`id`, `technologyid`, `comment`) VALUES
(3, 2, 'test1'),
(5, 4, 'Corn F opt test r1-5 sec');

-- --------------------------------------------------------

--
-- Table structure for table `technology_requirements`
--

CREATE TABLE IF NOT EXISTS `technology_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `technologyid` int(11) NOT NULL,
  `req_tech_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `technologyid` (`technologyid`,`req_tech_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `technology_requirements`
--

INSERT INTO `technology_requirements` (`id`, `technologyid`, `req_tech_id`) VALUES
(7, 2, 1),
(8, 4, 3);


*/
}
void BuildingNode::drop_table() {
	Ref<TableBuilder> tb = get_table_builder();

	tb->drop_table_if_exists(BUILDING_TABLE_NAME)->cdrop_table();

	tb->run_query();
}

void BuildingNode::create_default_entries() {
	String table_columns = "id, name, description, icon, rank, next_rank, time_to_build, creates, num_creates, score, defense, ability, cost_food, cost_wood, cost_stone, cost_iron, cost_mana, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, assignment1, assignment2, assignment3, assignment4, assignment5, req_tech, tech_group, tech_secondary_group";

	Ref<QueryBuilder> qb = get_query_builder();

	qb->begin_transaction()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(1, 'empty', '', 'empty/empty.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(2, 'Build in Progress', '', 'bip/bip.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(3, 'Corn Field', 'Produces food.', 'corn_field/r1.png', 1, 7, 20, 0, 0, 20, 1, 0, 60, 100, 10, 5, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 4, 3, 0, 0, 2, 3)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(4, 'Lumber Mill', 'Your main wood producing building.', 'lumber_mill/r1.png', 1, 0, 1000, 0, 0, 20, 0, 0, 30, 40, 50, 10, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 2)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(5, 'Stone Mine', 'Your main stone producing building.', 'stone_mine/r1.png', 1, 0, 1000, 2, 20, 0, 0, 0, 30, 50, 20, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(6, 'House', 'Can create villagers.', 'house/r1.png', 1, 0, 20, 1, 10, 0, 0, 0, 50, 70, 30, 5, 0, 0, 0, 0, 0, 0, -0.005, -0.001, -0.001, -0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(7, 'Corn Field', '', 'corn_field/r2.png', 2, 0, 20, 0, 0, 0, 0, 0, 40, 60, 20, 10, 0, 0, 0, 0, 0, 0, 0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 0, 2, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(8, 'Farm', 'Creates villagers.', 'farm/r1.png', 1, 0, 80, 1, 20, 0, 0, 0, 50, 60, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(9, 'Iron Mine', 'Your main iron producing building.', 'iron_mine/r1.png', 1, 0, 1000, 2, 100000, 0, 0, 0, 70, 30, 70, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES(10, 'School', 'School', 'school/r1.png', 1, 0, 60, 2, 60, 0, 0, 0, 300, 300, 300, 300, 20, 0, 0, 0, 0, 0, 0.001, 0.001, 0.001, 0.001, 0.001, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 2)")->end_command()->nl();
	qb->commit();

	qb->run_query();
	//qb->print();
}

BuildingNode *BuildingNode::get_singleton() {
	return _self;
}

BuildingNode::BuildingNode() :
		AdminNode() {

	if (_self) {
		printf("BuildingNode::BuildingNode(): Error! self is not null!/n");
	}

	_self = this;
}

BuildingNode::~BuildingNode() {
	if (_self == this) {
		_self = nullptr;
	}
}

BuildingNode *BuildingNode::_self = nullptr;
