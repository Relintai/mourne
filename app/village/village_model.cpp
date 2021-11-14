#include "village_model.h"

#include "core/database/database.h"
#include "core/database/database_manager.h"
#include "core/database/query_builder.h"
#include "core/database/query_result.h"
#include "core/database/table_builder.h"

#include "core/hash/sha256.h"

#define VILLAGE_TABLE_NAME "village"

void VillageModel::create_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->create_table(VILLAGE_TABLE_NAME);
	tb->integer("id")->auto_increment()->next_row();
	tb->varchar("username", 60)->not_null()->next_row();
	tb->varchar("email", 100)->not_null()->next_row();
	tb->integer("rank")->not_null()->next_row();
	tb->varchar("pre_salt", 100)->next_row();
	tb->varchar("post_salt", 100)->next_row();
	tb->varchar("password_hash", 100)->next_row();
	tb->integer("banned")->next_row();
	tb->varchar("password_reset_token", 100)->next_row();
	tb->integer("locked")->next_row();
	tb->primary_key("id");
	tb->ccreate_table();
	tb->run_query();
	//tb->print();
}
void VillageModel::drop_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->drop_table_if_exists(VILLAGE_TABLE_NAME)->run_query();
}
void VillageModel::migrate() {
	drop_table();
	create_table();
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
