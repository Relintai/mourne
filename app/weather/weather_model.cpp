#include "weather_model.h"

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

void WeatherModel::parse_row(Ref<QueryResult> &result, Ref<Weather> &weather) {

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

void WeatherModel::create_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

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
void WeatherModel::drop_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->drop_table_if_exists(WEATHER_TABLE_NAME)->cdrop_table();

	tb->run_query();
}

void WeatherModel::create_default_entries() {
	String table_columns = "id, name, description, art, css, effect, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana";

	Ref<QueryBuilder> qb = DatabaseManager::get_singleton()->ddb->get_query_builder();

	qb->begin_transaction()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(1, 'Sunny', 'Your maximum food increases by 1000, also increases food production by 10%.', 'E_NOTIMPL', 'sunny', 0, 1000, 0, 0, 0, 0, 10, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(WEATHER_TABLE_NAME, table_columns)->nl()->w("VALUES(2, 'Cold', 'Your max iron increases by 1000, also iron production increases by 10%.', 'E_NOTIMPL', 'cold', 0, 0, 0, 0, 1000, 0, 0, 0, 0, 10, 0)")->end_command()->nl();
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
