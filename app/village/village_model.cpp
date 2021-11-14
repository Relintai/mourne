#include "village_model.h"

#include "core/database/database.h"
#include "core/database/database_manager.h"
#include "core/database/query_builder.h"
#include "core/database/query_result.h"
#include "core/database/table_builder.h"

#include "core/hash/sha256.h"

#define VILLAGE_TABLE_NAME "villages"
#define VILLAGE_RESOURCES_TABLE_NAME "village_resources"
#define VILLAGE_BUILDINGS_TABLE_NAME "village_buildings"
#define VILLAGE_TECHNOLOGIES_TABLE_NAME "village_technologies"
#define VILLAGE_UNITS_TABLE_NAME "village_units"

void VillageModel::create_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->create_table(VILLAGE_TABLE_NAME);
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

	tb->result = "";

	tb->create_table(VILLAGE_RESOURCES_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("villageid", 11)->not_null()->next_row();

	tb->real_double("food")->not_null()->defval("400")->next_row();
	tb->real_double("wood")->not_null()->defval("400")->next_row();
	tb->real_double("stone")->not_null()->defval("400")->next_row();
	tb->real_double("iron")->not_null()->defval("400")->next_row();
	tb->real_double("mana")->not_null()->defval("400")->next_row();

	tb->integer("max_food", 11)->not_null()->defval("1000")->next_row();
	tb->integer("max_wood", 11)->not_null()->defval("1000")->next_row();
	tb->integer("max_stone", 11)->not_null()->defval("1000")->next_row();
	tb->integer("max_iron", 11)->not_null()->defval("1000")->next_row();
	tb->integer("max_mana", 11)->not_null()->defval("1000")->next_row();

	tb->real_double("rate_nm_food")->not_null()->defval("0.1")->next_row();
	tb->real_double("rate_nm_wood")->not_null()->defval("0.1")->next_row();
	tb->real_double("rate_nm_stone")->not_null()->defval("0.1")->next_row();
	tb->real_double("rate_nm_iron")->not_null()->defval("0.1")->next_row();
	tb->real_double("rate_nm_mana")->not_null()->defval("0.1")->next_row();

	tb->real_double("rate_food")->not_null()->defval("0.1")->next_row();
	tb->real_double("rate_wood")->not_null()->defval("0.1")->next_row();
	tb->real_double("rate_stone")->not_null()->defval("0.1")->next_row();
	tb->real_double("rate_iron")->not_null()->defval("0.1")->next_row();
	tb->real_double("rate_mana")->not_null()->defval("0.1")->next_row();

	tb->small_integer("percent_rate_food", 6)->not_null()->defval("100")->next_row();
	tb->small_integer("percent_rate_wood", 6)->not_null()->defval("100")->next_row();
	tb->small_integer("percent_rate_stone", 6)->not_null()->defval("100")->next_row();
	tb->small_integer("percent_rate_iron", 6)->not_null()->defval("100")->next_row();
	tb->small_integer("percent_rate_mana", 6)->not_null()->defval("100")->next_row();

	tb->integer("last_updated", 11)->not_null()->next_row();

	tb->primary_key("id");
	tb->foreign_key("villageid")->references(VILLAGE_TABLE_NAME, "id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();

	tb->result = "";

	tb->create_table(VILLAGE_BUILDINGS_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("villageid", 11)->not_null()->next_row();
	tb->integer("slotid", 11)->not_null()->next_row();
	tb->integer("buildingid", 11)->not_null()->next_row(); //foreign key

	tb->primary_key("id");
	tb->foreign_key("villageid")->references(VILLAGE_TABLE_NAME, "id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();

	tb->result = "";

	tb->create_table(VILLAGE_TECHNOLOGIES_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("villageid", 11)->not_null()->next_row();
	tb->integer("slotid", 11)->not_null()->next_row();
	tb->integer("technologyid", 11)->not_null()->next_row(); //foreign key

	tb->primary_key("id");
	tb->foreign_key("villageid")->references(VILLAGE_TABLE_NAME, "id");

	//todo
	//KEY `villageid` (`villageid`,`slotid`,`technologyid`)

	tb->ccreate_table();

	tb->run_query();
	//tb->print();

	tb->result = "";

	tb->create_table(VILLAGE_UNITS_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("userid", 11)->not_null()->next_row();
	tb->integer("villageid", 11)->not_null()->next_row();
	tb->integer("unitid", 11)->not_null()->next_row();
	tb->integer("unitcount", 11)->not_null()->next_row();

	tb->primary_key("id");
	tb->foreign_key("villageid")->references(VILLAGE_TABLE_NAME, "id");
	tb->foreign_key("userid")->references("users", "id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();

	tb->result = "";
}
void VillageModel::drop_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->drop_table_if_exists(VILLAGE_UNITS_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_TECHNOLOGIES_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_BUILDINGS_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_RESOURCES_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_TABLE_NAME)->cdrop_table();
	
	tb->run_query();
}
void VillageModel::migrate() {
	drop_table();
	create_table();
}

void VillageModel::add_default_data() {

}


VillageModel *VillageModel::get_singleton() {
	return _self;
}

VillageModel::VillageModel() :
		Object() {

	if (_self) {
		printf("VillageModel::VillageModel(): Error! self is not null!/n");
	}

	_self = this;
}

VillageModel::~VillageModel() {
	if (_self == this) {
		_self = nullptr;
	}
}

VillageModel *VillageModel::_self = nullptr;
