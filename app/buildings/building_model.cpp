#include "building_model.h"

#include "core/database/database.h"
#include "core/database/database_manager.h"
#include "core/database/query_builder.h"
#include "core/database/query_result.h"
#include "core/database/table_builder.h"

#include "core/hash/sha256.h"

#define BUILDING_TABLE_NAME "buildings"

void BuildingModel::create_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->create_table(BUILDING_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("userid", 11)->not_null()->next_row();
	tb->varchar("name", 60)->not_null()->next_row();
	tb->tiny_integer("score", 4)->not_null()->defval("100")->next_row();
	tb->tiny_integer("selected", 4)->not_null()->next_row();
	tb->tiny_integer("new_log", 4)->not_null()->defval("0")->next_row();
	tb->tiny_integer("ai_on", 4)->not_null()->defval("0")->next_row();
	tb->tiny_integer("ai_flagged", 4)->not_null()->defval("0")->next_row();
	tb->integer("weather", 11)->not_null()->defval("0")->next_row(); //foreigh key
	tb->integer("last_weather_change", 11)->not_null()->defval("0")->next_row();
	tb->integer("weather_change_to", 11)->not_null()->defval("0")->next_row(); //foreigh key

	tb->primary_key("id");
	tb->foreign_key("userid")->references("users", "id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();

}
void BuildingModel::drop_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->drop_table_if_exists(BUILDING_TABLE_NAME)->cdrop_table();
	
	tb->run_query();
}
void BuildingModel::migrate() {
	drop_table();
	create_table();
}

void BuildingModel::add_default_data() {

}


BuildingModel *BuildingModel::get_singleton() {
	return _self;
}

BuildingModel::BuildingModel() :
		Object() {

	if (_self) {
		printf("BuildingModel::BuildingModel(): Error! self is not null!/n");
	}

	_self = this;
}

BuildingModel::~BuildingModel() {
	if (_self == this) {
		_self = nullptr;
	}
}

BuildingModel *BuildingModel::_self = nullptr;
