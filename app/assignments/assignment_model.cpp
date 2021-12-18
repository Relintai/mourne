#include "assignment_model.h"

#include "core/database/database.h"
#include "core/database/database_manager.h"
#include "core/database/query_builder.h"
#include "core/database/query_result.h"
#include "core/database/table_builder.h"

#include "core/hash/sha256.h"

#include "assignment.h"

#define ASSIGNMENT_TABLE_NAME "assignments"

#define ASSIGNMENT_TABLE_COLUMNS "id, unitid, max, bonus_per_assigned, spellid, req_tech, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, description"
#define ASSIGNMENT_TABLE_COLUMNS_NOID "unitid, max, bonus_per_assigned, spellid, req_tech, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, description"

Ref<Assignment> AssignmentModel::get_assignment(const int id) {
	if (id == 0) {
		return Ref<Assignment>();
	}

	Ref<QueryBuilder> b = DatabaseManager::get_singleton()->ddb->get_query_builder();

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

	parse_row(r, assignment);

	return assignment;
}

Vector<Ref<Assignment> > AssignmentModel::get_all() {
	Ref<QueryBuilder> b = DatabaseManager::get_singleton()->ddb->get_query_builder();

	b->select(ASSIGNMENT_TABLE_COLUMNS);
	b->from(ASSIGNMENT_TABLE_NAME);
	b->end_command();
	//b->print();

	Vector<Ref<Assignment> > assignments;

	Ref<QueryResult> r = b->run();

	while (r->next_row()) {
		Ref<Assignment> assignment;
		assignment.instance();

		parse_row(r, assignment);

		assignments.push_back(assignment);
	}

	return assignments;
}

void AssignmentModel::save_assignment(Ref<Assignment> &assignment) {
	Ref<QueryBuilder> b = DatabaseManager::get_singleton()->ddb->get_query_builder();

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

void AssignmentModel::parse_row(Ref<QueryResult> &result, Ref<Assignment> &assignment) {

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

void AssignmentModel::create_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

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
void AssignmentModel::drop_table() {
	Ref<TableBuilder> tb = DatabaseManager::get_singleton()->ddb->get_table_builder();

	tb->drop_table_if_exists(ASSIGNMENT_TABLE_NAME)->cdrop_table();

	tb->run_query();
}
void AssignmentModel::migrate() {
	drop_table();
	create_table();
}

void AssignmentModel::add_default_data() {
	String table_columns = "id, unitid, max, bonus_per_assigned, spellid, req_tech, mod_max_food, mod_max_wood, mod_max_stone, mod_max_iron, mod_max_mana, mod_rate_food, mod_rate_wood, mod_rate_stone, mod_rate_iron, mod_rate_mana, mod_percent_food, mod_percent_wood, mod_percent_stone, mod_percent_iron, mod_percent_mana, description";

	Ref<QueryBuilder> qb = DatabaseManager::get_singleton()->ddb->get_query_builder();

	qb->begin_transaction()->nl();
	qb->insert(ASSIGNMENT_TABLE_NAME, table_columns)->nl()->w("VALUES(1, 1, 10, 2, 0, 0, 0, 0, 0, 0, 0, 0.001, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'This building will produce more food, every 2 villager you assign.')")->end_command()->nl();
	qb->insert(ASSIGNMENT_TABLE_NAME, table_columns)->nl()->w("VALUES(2, 1, 10, 5, 0, 0, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Every 5 Villager you assign, you get +30 Maximum Food.')")->end_command()->nl();
	qb->insert(ASSIGNMENT_TABLE_NAME, table_columns)->nl()->w("VALUES(3, 1, 10, 10, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Assigning 10 Villager will grant you an awesome spell.')")->end_command()->nl();
	qb->insert(ASSIGNMENT_TABLE_NAME, table_columns)->nl()->w("VALUES(4, 1, 10, 10, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Adds a spell, and tests the requirements.')")->end_command()->nl();
	qb->commit();

	qb->run_query();
	//qb->print();
}

AssignmentModel *AssignmentModel::get_singleton() {
	return _self;
}

AssignmentModel::AssignmentModel() :
		Object() {

	if (_self) {
		printf("AssignmentModel::AssignmentModel(): Error! self is not null!/n");
	}

	_self = this;
}

AssignmentModel::~AssignmentModel() {
	if (_self == this) {
		_self = nullptr;
	}
}

AssignmentModel *AssignmentModel::_self = nullptr;
