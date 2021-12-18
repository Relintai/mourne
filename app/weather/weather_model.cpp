#include "weather_model.h"

#include "core/database/database.h"
#include "core/database/database_manager.h"
#include "core/database/query_builder.h"
#include "core/database/query_result.h"
#include "core/database/table_builder.h"

#include "core/hash/sha256.h"

#include "weather.h"

#define WEATHER_TABLE_NAME "weathers"

#define WEATHER_TABLE_COLUMNS "id, name, description, icon, rank, next_rank, time_to_build, creates, num_creates, score, defense, ability, cost_food, cost_wood, cost_stone, cost_iron, cost_mana, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, assignment1, assignment2, assignment3, assignment4, assignment5, req_tech, tech_group, tech_secondary_group"
#define WEATHER_TABLE_COLUMNS_NOID "name, description, icon, rank, next_rank, time_to_build, creates, num_creates, score, defense, ability, cost_food, cost_wood, cost_stone, cost_iron, cost_mana, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, assignment1, assignment2, assignment3, assignment4, assignment5, req_tech, tech_group, tech_secondary_group"

Ref<Weather> WeatherModel::get_weather(const int id) {
	if (id == 0) {
		return Ref<Weather>();
	}

	Ref<QueryBuilder> b = DatabaseManager::get_singleton()->ddb->get_query_builder();

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

	parse_row(r, weather);

	return weather;
}

Vector<Ref<Weather> > WeatherModel::get_all() {
	Ref<QueryBuilder> b = DatabaseManager::get_singleton()->ddb->get_query_builder();

	b->select(WEATHER_TABLE_COLUMNS);
	b->from(WEATHER_TABLE_NAME);
	b->end_command();
	//b->print();

	Vector<Ref<Weather> > weathers;

	Ref<QueryResult> r = b->run();

	while (r->next_row()) {
		Ref<Weather> weather;
		weather.instance();

		parse_row(r, weather);

		weathers.push_back(weather);
	}

	return weathers;
}

void WeatherModel::save_weather(Ref<Weather> &weather) {
	Ref<QueryBuilder> b = DatabaseManager::get_singleton()->ddb->get_query_builder();

	if (weather->id == 0) {
		b->insert(WEATHER_TABLE_NAME, WEATHER_TABLE_COLUMNS_NOID);

		b->values();

		b->val(weather->name);
		b->val(weather->description);
		b->val(weather->icon);

		b->val(weather->rank);
		b->val(weather->next_rank);
		b->val(weather->time_to_build);
		b->val(weather->creates);
		b->val(weather->num_creates);
		b->val(weather->score);
		b->val(weather->defense);
		b->val(weather->ability);

		b->val(weather->cost_food);
		b->val(weather->cost_wood);
		b->val(weather->cost_stone);
		b->val(weather->cost_iron);
		b->val(weather->cost_mana);

		b->val(weather->mod_max_food);
		b->val(weather->mod_max_wood);
		b->val(weather->mod_max_stone);
		b->val(weather->mod_max_iron);
		b->val(weather->mod_max_mana);

		b->vald(weather->mod_rate_food);
		b->vald(weather->mod_rate_wood);
		b->vald(weather->mod_rate_stone);
		b->vald(weather->mod_rate_iron);
		b->vald(weather->mod_rate_mana);

		b->val(weather->mod_percent_food);
		b->val(weather->mod_percent_wood);
		b->val(weather->mod_percent_stone);
		b->val(weather->mod_percent_iron);
		b->val(weather->mod_percent_mana);

		b->val(weather->assignment1);
		b->val(weather->assignment2);
		b->val(weather->assignment3);
		b->val(weather->assignment4);
		b->val(weather->assignment5);

		b->val(weather->req_tech);
		b->val(weather->tech_group);
		b->val(weather->tech_secondary_group);

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
		b->setp("icon", weather->icon);

		b->setp("userankrname", weather->rank);
		b->setp("next_rank", weather->next_rank);
		b->setp("time_to_build", weather->time_to_build);
		b->setp("creates", weather->creates);
		b->setp("num_creates", weather->num_creates);
		b->setp("score", weather->score);
		b->setp("defense", weather->defense);
		b->setp("ability", weather->ability);

		b->setp("cost_food", weather->cost_food);
		b->setp("cost_wood", weather->cost_wood);
		b->setp("cost_stone", weather->cost_stone);
		b->setp("cost_iron", weather->cost_iron);
		b->setp("cost_mana", weather->cost_mana);

		b->setp("mod_max_food", weather->mod_max_food);
		b->setp("mod_max_wood", weather->mod_max_wood);
		b->setp("mod_max_stone", weather->mod_max_stone);
		b->setp("mod_max_iron", weather->mod_max_iron);
		b->setp("mod_max_mana", weather->mod_max_mana);

		b->setpd("mod_rate_food", weather->mod_rate_food);
		b->setpd("mod_rate_wood", weather->mod_rate_wood);
		b->setpd("mod_rate_stone", weather->mod_rate_stone);
		b->setpd("mod_rate_iron", weather->mod_rate_iron);
		b->setpd("mod_rate_mana", weather->mod_rate_mana);

		b->setp("mod_percent_food", weather->mod_percent_food);
		b->setp("mod_percent_wood", weather->mod_percent_wood);
		b->setp("mod_percent_stone", weather->mod_percent_stone);
		b->setp("mod_percent_iron", weather->mod_percent_iron);
		b->setp("mod_percent_mana", weather->mod_percent_mana);

		b->setp("assignment1", weather->assignment1);
		b->setp("assignment2", weather->assignment2);
		b->setp("assignment3", weather->assignment3);
		b->setp("assignment4", weather->assignment4);
		b->setp("assignment5", weather->assignment5);

		b->setp("req_tech", weather->req_tech);
		b->setp("tech_group", weather->tech_group);
		b->setp("tech_secondary_group", weather->tech_secondary_group);

		b->cset();
		b->where()->wp("id", weather->id);

		//b->print();

		b->run_query();
	}
}

void WeatherModel::parse_row(Ref<QueryResult> &result, Ref<Weather> &weather) {

	weather->id = result->get_cell_int(0);

	weather->name = result->get_cell(1);
	weather->description = result->get_cell(2);
	weather->icon = result->get_cell(3);

	weather->rank = result->get_cell_int(4);
	weather->next_rank = result->get_cell_int(5);
	weather->time_to_build = result->get_cell_int(6);
	weather->creates = result->get_cell_int(7);
	weather->num_creates = result->get_cell_int(8);
	weather->score = result->get_cell_int(9);
	weather->defense = result->get_cell_int(10);
	weather->ability = result->get_cell_int(11);

	weather->cost_food = result->get_cell_int(12);
	weather->cost_wood = result->get_cell_int(13);
	weather->cost_stone = result->get_cell_int(14);
	weather->cost_iron = result->get_cell_int(15);
	weather->cost_mana = result->get_cell_int(16);

	weather->mod_max_food = result->get_cell_int(17);
	weather->mod_max_wood = result->get_cell_int(18);
	weather->mod_max_stone = result->get_cell_int(19);
	weather->mod_max_iron = result->get_cell_int(20);
	weather->mod_max_mana = result->get_cell_int(21);

	weather->mod_rate_food = result->get_cell_double(22);
	weather->mod_rate_wood = result->get_cell_double(23);
	weather->mod_rate_stone = result->get_cell_double(24);
	weather->mod_rate_iron = result->get_cell_double(25);
	weather->mod_rate_mana = result->get_cell_double(26);

	weather->mod_percent_food = result->get_cell_int(27);
	weather->mod_percent_wood = result->get_cell_int(28);
	weather->mod_percent_stone = result->get_cell_int(29);
	weather->mod_percent_iron = result->get_cell_int(30);
	weather->mod_percent_mana = result->get_cell_int(31);

	weather->assignment1 = result->get_cell_int(32);
	weather->assignment2 = result->get_cell_int(33);
	weather->assignment3 = result->get_cell_int(34);
	weather->assignment4 = result->get_cell_int(35);
	weather->assignment5 = result->get_cell_int(36);

	weather->req_tech = result->get_cell_int(37);
	weather->tech_group = result->get_cell_int(38);
	weather->tech_secondary_group = result->get_cell_int(39);
}

void WeatherModel::create_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->create_table(WEATHER_TABLE_NAME);
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
}
void WeatherModel::drop_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->drop_table_if_exists(WEATHER_TABLE_NAME)->cdrop_table();

	tb->run_query();
}
void WeatherModel::migrate() {
	drop_table();
	create_table();
}

void WeatherModel::add_default_data() {
	String table_columns = "id, name, description, icon, rank, next_rank, time_to_build, creates, num_creates, score, defense, ability, cost_food, cost_wood, cost_stone, cost_iron, cost_mana, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, assignment1, assignment2, assignment3, assignment4, assignment5, req_tech, tech_group, tech_secondary_group";

	Ref<QueryBuilder> qb = DatabaseManager::get_singleton()->ddb->get_query_builder();

	qb->begin_transaction()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(1, 'empty', '', 'empty/empty.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(2, 'Build in Progress', '', 'bip/bip.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(3, 'Corn Field', 'Produces food.', 'corn_field/r1.png', 1, 7, 20, 0, 0, 20, 1, 0, 60, 100, 10, 5, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 4, 3, 0, 0, 2, 3)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(4, 'Lumber Mill', 'Your main wood producing weather.', 'lumber_mill/r1.png', 1, 0, 1000, 0, 0, 20, 0, 0, 30, 40, 50, 10, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 2)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(5, 'Stone Mine', 'Your main stone producing weather.', 'stone_mine/r1.png', 1, 0, 1000, 2, 20, 0, 0, 0, 30, 50, 20, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(6, 'House', 'Can create villagers.', 'house/r1.png', 1, 0, 20, 1, 10, 0, 0, 0, 50, 70, 30, 5, 0, 0, 0, 0, 0, 0, -0.005, -0.001, -0.001, -0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(7, 'Corn Field', '', 'corn_field/r2.png', 2, 0, 20, 0, 0, 0, 0, 0, 40, 60, 20, 10, 0, 0, 0, 0, 0, 0, 0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 0, 2, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(8, 'Farm', 'Creates villagers.', 'farm/r1.png', 1, 0, 80, 1, 20, 0, 0, 0, 50, 60, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(9, 'Iron Mine', 'Your main iron producing weather.', 'iron_mine/r1.png', 1, 0, 1000, 2, 100000, 0, 0, 0, 70, 30, 70, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(10, 'School', 'School', 'school/r1.png', 1, 0, 60, 2, 60, 0, 0, 0, 300, 300, 300, 300, 20, 0, 0, 0, 0, 0, 0.001, 0.001, 0.001, 0.001, 0.001, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 2)")->end_command()->nl();
	qb->commit();

	qb->run_query();
	//qb->print();
}

WeatherModel *WeatherModel::get_singleton() {
	return _self;
}

WeatherModel::WeatherModel() :
		Object() {

	if (_self) {
		printf("WeatherModel::WeatherModel(): Error! self is not null!/n");
	}

	_self = this;
}

WeatherModel::~WeatherModel() {
	if (_self == this) {
		_self = nullptr;
	}
}

WeatherModel *WeatherModel::_self = nullptr;
