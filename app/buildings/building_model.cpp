#include "building_model.h"

#include "core/database/database.h"
#include "core/database/database_manager.h"
#include "core/database/query_builder.h"
#include "core/database/query_result.h"
#include "core/database/table_builder.h"

#include "core/hash/sha256.h"

#include "building.h"

#define BUILDING_TABLE_NAME "buildings"

void BuildingModel::create_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

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
	String table_columns = "name, description, icon, rank, next_rank, time_to_build, creates, num_creates, score, defense, ability, cost_food, cost_wood, cost_stone, cost_iron, cost_mana, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, assignment1, assignment2, assignment3, assignment4, assignment5, req_tech, tech_group, tech_secondary_group";

	Ref<QueryBuilder> qb = DatabaseManager::get_singleton()->ddb->get_query_builder();

	qb->begin_transaction()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('empty', '', 'empty/empty.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('Build in Progress', '', 'bip/bip.png', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('Corn Field', 'Produces food.', 'corn_field/r1.png', 1, 7, 20, 0, 0, 20, 1, 0, 60, 100, 10, 5, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 4, 3, 0, 0, 2, 3)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('Lumber Mill', 'Your main wood producing building.', 'lumber_mill/r1.png', 1, 0, 1000, 0, 0, 20, 0, 0, 30, 40, 50, 10, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 2)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('Stone Mine', 'Your main stone producing building.', 'stone_mine/r1.png', 1, 0, 1000, 2, 20, 0, 0, 0, 30, 50, 20, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('House', 'Can create villagers.', 'house/r1.png', 1, 0, 20, 1, 10, 0, 0, 0, 50, 70, 30, 5, 0, 0, 0, 0, 0, 0, -0.005, -0.001, -0.001, -0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('Corn Field', '', 'corn_field/r2.png', 2, 0, 20, 0, 0, 0, 0, 0, 40, 60, 20, 10, 0, 0, 0, 0, 0, 0, 0.2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 0, 2, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('Farm', 'Creates villagers.', 'farm/r1.png', 1, 0, 80, 1, 20, 0, 0, 0, 50, 60, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('Iron Mine', 'Your main iron producing building.', 'iron_mine/r1.png', 1, 0, 1000, 2, 100000, 0, 0, 0, 70, 30, 70, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.01, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0)")->end_command()->nl();
	qb->insert(BUILDING_TABLE_NAME, table_columns)->nl()->w("VALUES('School', 'School', 'school/r1.png', 1, 0, 60, 2, 60, 0, 0, 0, 300, 300, 300, 300, 20, 0, 0, 0, 0, 0, 0.001, 0.001, 0.001, 0.001, 0.001, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, 2)")->end_command()->nl();
	qb->commit();

	qb->run_query();
	//qb->print();
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
