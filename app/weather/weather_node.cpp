#include "weather_node.h"

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

#include "weather.h"

#define WEATHER_TABLE_NAME "weathers"

#define WEATHER_TABLE_COLUMNS "id, name, description, art, css, effect, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana"
#define WEATHER_TABLE_COLUMNS_NOID "name, description, art, css, effect, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana"


void WeatherNode::handle_request_default(Request *request) {
}

void WeatherNode::admin_handle_request_main(Request *request) {
	String seg = request->get_current_path_segment();

	if (seg == "") {
		admin_render_weather_list(request);
		return;
	} else if (seg == "new") {
		request->push_path();
		Ref<Weather> b;
		b.instance();

		admin_render_weather(request, b);
		return;
	} else if (seg == "edit") {
		request->push_path();

		String seg_weather_id = request->get_current_path_segment();

		if (!seg_weather_id.is_int()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		int bid = seg_weather_id.to_int();

		Ref<Weather> b = db_get_weather(bid);

		if (!b.is_valid()) {
			request->send_error(HTTP_STATUS_CODE_404_NOT_FOUND);
			return;
		}

		admin_render_weather(request, b);
		return;
	}

	request->send_error(404);
}
String WeatherNode::admin_get_section_name() {
	return "Weathers";
}
void WeatherNode::admin_add_section_links(Vector<AdminSectionLinkInfo> *links) {
	links->push_back(AdminSectionLinkInfo("- Weather Editor", ""));
}
bool WeatherNode::admin_full_render() {
	return false;
}

void WeatherNode::admin_render_weather_list(Request *request) {
	Vector<Ref<Weather> > weathers = db_get_all();

	HTMLBuilder b;

	b.div("back")->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Weather Editor", "top_menu");
	b.br();
	b.div("top_menu")->fa(request->get_url_root("new"), "Create New")->cdiv();
	b.br();

	b.div("list_container");

	for (int i = 0; i < weathers.size(); ++i) {
		Ref<Weather> weather = weathers[i];

		if (!weather.is_valid()) {
			continue;
		}

		if (i % 2 == 0) {
			b.div("row");
		} else {
			b.div("row second");
		}
		{
			b.fdiv(String::num(weather->id), "attr_box");
			b.fdiv(weather->name, "name");

			b.div("actionbox")->fa(request->get_url_root("edit/" + String::num(weather->id)), "Edit")->cdiv();
		}
		b.cdiv();
	}

	b.cdiv();

	request->body += b.result;
}

void WeatherNode::admin_render_weather(Request *request, Ref<Weather> weather) {
	if (!weather.is_valid()) {
		RLOG_ERR("admin_render_weather: !weather.is_valid()\n");
		request->send_error(HTTP_STATUS_CODE_500_INTERNAL_SERVER_ERROR);
		return;
	}

	Vector<Ref<Weather> > weathers = db_get_all();

	HTMLBuilder b;

	b.div("back")->fa(request->get_url_root_parent(), "<--- Back")->cdiv();
	b.br();
	b.fdiv("Weather Editor", "top_menu");
	b.br();

	b.form_post(request->get_url_root());

	bool show_post = false; //request->get_method() == HTTP_METHOD_POST && validation errors;

	ADMIN_EDIT_INPUT_TEXT("Name:", "name", show_post, weather->name, request->get_parameter("name"));
	ADMIN_EDIT_INPUT_TEXTAREA("Description:", "description", show_post, weather->description, request->get_parameter("description"));
	//I think this was supposed to be an icon
	ADMIN_EDIT_INPUT_TEXT("Art:", "art", show_post, weather->art, request->get_parameter("art"));
	ADMIN_EDIT_INPUT_TEXT("CSS:", "css", show_post, weather->css, request->get_parameter("css"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Effect:", "effect", show_post, String::num(weather->effect), request->get_parameter("effect"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Max Food:", "mod_max_food", show_post, String::num(weather->mod_max_food), request->get_parameter("mod_max_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Wood:", "mod_max_wood", show_post, String::num(weather->mod_max_wood), request->get_parameter("mod_max_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Stone:", "mod_max_stone", show_post, String::num(weather->mod_max_stone), request->get_parameter("mod_max_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Iron:", "mod_max_iron", show_post, String::num(weather->mod_max_iron), request->get_parameter("mod_max_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Max Mana:", "mod_max_mana", show_post, String::num(weather->mod_max_mana), request->get_parameter("mod_max_mana"));

	ADMIN_EDIT_LINE_SPACER();

	ADMIN_EDIT_INPUT_TEXT("Mod Percent Food:", "mod_percent_food", show_post, String::num(weather->mod_percent_food), request->get_parameter("mod_percent_food"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Wood:", "mod_percent_wood", show_post, String::num(weather->mod_percent_wood), request->get_parameter("mod_percent_wood"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Stone:", "mod_percent_stone", show_post, String::num(weather->mod_percent_stone), request->get_parameter("mod_percent_stone"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Iron:", "mod_percent_iron", show_post, String::num(weather->mod_percent_iron), request->get_parameter("mod_percent_iron"));
	ADMIN_EDIT_INPUT_TEXT("Mod Percent Mana:", "mod_percent_mana", show_post, String::num(weather->mod_percent_mana), request->get_parameter("mod_percent_mana"));

	b.div("edit_submit")->input_submit("Save", "submit")->cdiv();

	b.cform();

	request->body += b.result;
}


Ref<Weather> WeatherNode::db_get_weather(const int id) {
	if (id == 0) {
		return Ref<Weather>();
	}

	Ref<QueryBuilder> b = get_query_builder();

	b->select(WEATHER_TABLE_COLUMNS);
	b->from(WEATHER_TABLE_NAME);

	b->where()->wp("id", id);

	b->end_command();

	Ref<QueryResult> r = b->run();

	if (!r->next_row()) {
		return Ref<Weather>();
	}

	Ref<Weather> weather;
	weather.instance();

	db_parse_row(r, weather);

	return weather;
}

Vector<Ref<Weather> > WeatherNode::db_get_all() {
	Ref<QueryBuilder> b = get_query_builder();

	b->select(WEATHER_TABLE_COLUMNS);
	b->from(WEATHER_TABLE_NAME);
	b->end_command();
	//b->print();

	Vector<Ref<Weather> > weathers;

	Ref<QueryResult> r = b->run();

	while (r->next_row()) {
		Ref<Weather> weather;
		weather.instance();

		db_parse_row(r, weather);

		weathers.push_back(weather);
	}

	return weathers;
}

void WeatherNode::db_save_weather(Ref<Weather> &weather) {
	Ref<QueryBuilder> b = get_query_builder();

	if (weather->id == 0) {
		b->insert(WEATHER_TABLE_NAME, WEATHER_TABLE_COLUMNS_NOID);

		b->values();

		b->val(weather->name);
		b->val(weather->description);
		b->val(weather->art);
		b->val(weather->css);

		b->val(weather->effect);

		b->val(weather->mod_max_food);
		b->val(weather->mod_max_wood);
		b->val(weather->mod_max_stone);
		b->val(weather->mod_max_iron);
		b->val(weather->mod_max_mana);

		b->val(weather->mod_percent_food);
		b->val(weather->mod_percent_wood);
		b->val(weather->mod_percent_stone);
		b->val(weather->mod_percent_iron);
		b->val(weather->mod_percent_mana);

		b->cvalues();

		b->end_command();
		b->select_last_insert_id();
		//b->print();

		Ref<QueryResult> r = b->run();

		weather->id = r->get_last_insert_rowid();
	} else {
		b->update(WEATHER_TABLE_NAME);
		b->set();

		b->setp("name", weather->name);
		b->setp("description", weather->description);
		b->setp("art", weather->art);
		b->setp("css", weather->css);

		b->setp("effect", weather->effect);

		b->setp("mod_max_food", weather->mod_max_food);
		b->setp("mod_max_wood", weather->mod_max_wood);
		b->setp("mod_max_stone", weather->mod_max_stone);
		b->setp("mod_max_iron", weather->mod_max_iron);
		b->setp("mod_max_mana", weather->mod_max_mana);

		b->setp("mod_percent_food", weather->mod_percent_food);
		b->setp("mod_percent_wood", weather->mod_percent_wood);
		b->setp("mod_percent_stone", weather->mod_percent_stone);
		b->setp("mod_percent_iron", weather->mod_percent_iron);
		b->setp("mod_percent_mana", weather->mod_percent_mana);

		b->cset();
		b->where()->wp("id", weather->id);

		//b->print();

		b->run_query();
	}
}

void WeatherNode::db_parse_row(Ref<QueryResult> &result, Ref<Weather> &weather) {

	weather->id = result->get_cell_int(0);

	weather->name = result->get_cell(1);
	weather->description = result->get_cell(2);
	weather->art = result->get_cell(3);
	weather->css = result->get_cell(4);

	weather->effect = result->get_cell_int(5);

	weather->mod_max_food = result->get_cell_int(6);
	weather->mod_max_wood = result->get_cell_int(7);
	weather->mod_max_stone = result->get_cell_int(8);
	weather->mod_max_iron = result->get_cell_int(9);
	weather->mod_max_mana = result->get_cell_int(10);

	weather->mod_percent_food = result->get_cell_int(11);
	weather->mod_percent_wood = result->get_cell_int(12);
	weather->mod_percent_stone = result->get_cell_int(13);
	weather->mod_percent_iron = result->get_cell_int(14);
	weather->mod_percent_mana = result->get_cell_int(15);
}

void WeatherNode::create_table() {
	Ref<TableBuilder> tb = get_table_builder();

	tb->create_table(WEATHER_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->varchar("name", 200)->not_null()->next_row();
	tb->text("description")->not_null()->next_row();
	tb->varchar("art", 500)->not_null()->next_row();
	tb->text("css")->not_null()->next_row();
	tb->integer("effect", 11)->not_null()->next_row();

	tb->integer("mod_max_food", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_max_wood", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_max_stone", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_max_iron", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_max_mana", 11)->not_null()->defval("0")->next_row();

	tb->integer("mod_percent_food", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_percent_wood", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_percent_stone", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_percent_iron", 11)->not_null()->defval("0")->next_row();
	tb->integer("mod_percent_mana", 11)->not_null()->defval("0")->next_row();

	tb->primary_key("id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();
}
void WeatherNode::drop_table() {
	Ref<TableBuilder> tb = get_table_builder();

	tb->drop_table_if_exists(WEATHER_TABLE_NAME)->cdrop_table();

	tb->run_query();
}

void WeatherNode::create_default_entries() {
	String table_columns = "id, name, description, art, css, effect, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana";

	Ref<QueryBuilder> qb = get_query_builder();

	qb->begin_transaction()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(1, 'Sunny', 'Your maximum food increases by 1000, also increases food production by 10%.', 'E_NOTIMPL', 'sunny', 0, 1000, 0, 0, 0, 0, 10, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(2, 'Cold', 'Your max iron increases by 1000, also iron production increases by 10%.', 'E_NOTIMPL', 'cold', 0, 0, 0, 0, 1000, 0, 0, 0, 0, 10, 0)")->end_command()->nl();
	qb->commit();

	qb->run_query();
	//qb->print();
}

WeatherNode *WeatherNode::get_singleton() {
	return _self;
}

WeatherNode::WeatherNode() :
		AdminNode() {

	if (_self) {
		printf("WeatherNode::WeatherNode(): Error! self is not null!/n");
	}

	_self = this;
}

WeatherNode::~WeatherNode() {
	if (_self == this) {
		_self = nullptr;
	}
}

WeatherNode *WeatherNode::_self = nullptr;
