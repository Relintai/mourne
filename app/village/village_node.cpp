#include "village_node.h"

#include "web/html/form_validator.h"
#include "web/html/html_builder.h"
#include "web/http/cookie.h"
#include "web/http/http_session.h"
#include "web/http/request.h"
#include "web/http/session_manager.h"

#include "database/database.h"
#include "database/database_manager.h"
#include "database/query_builder.h"
#include "database/query_result.h"
#include "database/table_builder.h"

#include "crypto/hash/sha256.h"

#define VILLAGE_TABLE_NAME "villages"
#define VILLAGE_RESOURCES_TABLE_NAME "village_resources"
#define VILLAGE_BUILDINGS_TABLE_NAME "village_buildings"
#define VILLAGE_TECHNOLOGIES_TABLE_NAME "village_technologies"
#define VILLAGE_UNITS_TABLE_NAME "village_units"
#define VILLAGE_BUILDING_ASSIGNMENTS_TABLE_NAME "village_building_assignments"
#define VILLAGE_BUILDING_SPELLS_TABLE_NAME "village_building_spells"
#define VILLAGE_BUILDING_SPELL_COOLDOWNS_TABLE_NAME "village_building_spell_cooldowns"

void VillageNode::handle_request_default(Request *request) {
}

void VillageNode::create_table() {
	Ref<TableBuilder> tb = get_table_builder();

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

	tb->create_table(VILLAGE_BUILDING_ASSIGNMENTS_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("villageid", 11)->not_null()->next_row();
	tb->integer("slotid", 11)->not_null()->next_row();
	tb->integer("unitid", 11)->not_null()->next_row();

	tb->integer("num_unit", 11)->not_null()->next_row();
	tb->integer("assignmentid", 11)->not_null()->next_row(); //foregign key
	tb->integer("num_bonus", 11)->not_null()->next_row();

	tb->primary_key("id");
	tb->foreign_key("villageid")->references(VILLAGE_TABLE_NAME, "id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();

	tb->result = "";

	tb->create_table(VILLAGE_BUILDING_SPELLS_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("villageid", 11)->not_null()->next_row();
	tb->integer("slotid", 11)->not_null()->next_row();
	tb->integer("assignmentid", 11)->not_null()->next_row(); //foregign key
	tb->integer("spellid", 11)->not_null()->next_row();//foregign key
	
	tb->primary_key("id");
	tb->foreign_key("villageid")->references(VILLAGE_TABLE_NAME, "id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();

	tb->result = "";

	tb->create_table(VILLAGE_BUILDING_SPELL_COOLDOWNS_TABLE_NAME);
	tb->integer("id", 11)->auto_increment()->next_row();
	tb->integer("villageid", 11)->not_null()->next_row();
	tb->integer("slotid", 11)->not_null()->next_row();
	tb->integer("spellid", 11)->not_null()->next_row();//foregign key
	tb->integer("cooldown_end", 11)->not_null()->next_row();
	
	tb->primary_key("id");
	tb->foreign_key("villageid")->references(VILLAGE_TABLE_NAME, "id");
	tb->ccreate_table();

	tb->run_query();
	//tb->print();

	tb->result = "";

	/*
	CREATE TABLE IF NOT EXISTS `attacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `attackid` int(11) NOT NULL,
  `ai_unitid` int(11) NOT NULL,
  `ai_unitcount` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `villageid` (`villageid`,`attackid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
*/

/*
CREATE TABLE IF NOT EXISTS `combat_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `new` tinyint(4) NOT NULL,
  `log` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;
*/

/*
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `villageid` int(11) NOT NULL,
  `slotid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `data1` int(11) NOT NULL,
  `data2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

*/

}

#define VILLAGE_BUILDING_SPELLS_TABLE_NAME "village_building_spells"
#define VILLAGE_BUILDING_SPELL_COOLDOWNS_TABLE_NAME "village_building_spell_cooldowns"

void VillageNode::drop_table() {
	Ref<TableBuilder> tb = get_table_builder();

	tb->drop_table_if_exists(VILLAGE_BUILDING_ASSIGNMENTS_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_BUILDING_SPELLS_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_BUILDING_SPELL_COOLDOWNS_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_UNITS_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_TECHNOLOGIES_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_BUILDINGS_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_RESOURCES_TABLE_NAME)->cdrop_table();
	tb->drop_table_if_exists(VILLAGE_TABLE_NAME)->cdrop_table();
	
	tb->run_query();
}

void VillageNode::create_default_entries() {

}


VillageNode *VillageNode::get_singleton() {
	return _self;
}

VillageNode::VillageNode() :
		WebNode() {

	if (_self) {
		printf("VillageNode::VillageNode(): Error! self is not null!/n");
	}

	_self = this;
}

VillageNode::~VillageNode() {
	if (_self == this) {
		_self = nullptr;
	}
}

VillageNode *VillageNode::_self = nullptr;
