#include "building.h"

void Building::set_strings(const String &p_name, const String &p_description, const String &p_icon) {
	name = p_name;
	description = p_description;
	icon = p_icon;
}
void Building::set_base_data(int p_rank, int p_next_rank, int p_time_to_build, int p_creates, int p_num_creates, int p_score, int p_defense, int p_ability) {
	rank = p_rank;
	next_rank = p_next_rank;
	time_to_build = p_time_to_build;
	creates = p_creates;
	num_creates = p_num_creates;
	score = p_score;
	defense = p_defense;
	ability = p_ability;
}
void Building::set_cost(int p_cost_food, int p_cost_wood, int p_cost_stone, int p_cost_iron, int p_cost_mana) {
	cost_food = p_cost_food;
	cost_wood = p_cost_wood;
	cost_stone = p_cost_stone;
	cost_iron = p_cost_iron;
	cost_mana = p_cost_mana;
}
void Building::set_mod_max(int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana) {
	mod_max_food = p_mod_max_food;
	mod_max_wood = p_mod_max_wood;
	mod_max_stone = p_mod_max_stone;
	mod_max_iron = p_mod_max_iron;
	mod_max_mana = p_mod_max_mana;
}
void Building::set_mod_rate(double p_mod_rate_food, double p_mod_rate_wood, double p_mod_rate_stone, double p_mod_rate_iron, double p_mod_rate_mana) {
	mod_rate_food = p_mod_rate_food;
	mod_rate_wood = p_mod_rate_wood;
	mod_rate_stone = p_mod_rate_stone;
	mod_rate_iron = p_mod_rate_iron;
	mod_rate_mana = p_mod_rate_mana;
}
void Building::set_mod_percent(int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana) {
	mod_percent_food = p_mod_percent_food;
	mod_percent_wood = p_mod_percent_wood;
	mod_percent_stone = p_mod_percent_stone;
	mod_percent_iron = p_mod_percent_iron;
	mod_percent_mana = p_mod_percent_mana;
}
void Building::set_assignments(int p_assignment1, int p_assignment2, int p_assignment3, int p_assignment4, int p_assignment5) {
	assignment1 = p_assignment1;
	assignment2 = p_assignment2;
	assignment3 = p_assignment3;
	assignment4 = p_assignment4;
	assignment5 = p_assignment5;
}
void Building::set_technologies(int p_req_tech, int p_tech_group, int p_tech_secondary_group) {
	req_tech = p_req_tech;
	tech_group = p_tech_group;
	tech_secondary_group = p_tech_secondary_group;
}

void Building::set_all(
		const String &p_name, const String &p_description, const String &p_icon,
		int p_rank, int p_next_rank, int p_time_to_build, int p_creates, int p_num_creates, int p_score, int p_defense, int p_ability,
		int p_cost_food, int p_cost_wood, int p_cost_stone, int p_cost_iron, int p_cost_mana,
		int p_mod_max_food, int p_mod_max_wood, int p_mod_max_stone, int p_mod_max_iron, int p_mod_max_mana,
		double p_mod_rate_food, double p_mod_rate_wood, double p_mod_rate_stone, double p_mod_rate_iron, double p_mod_rate_mana,
		int p_mod_percent_food, int p_mod_percent_wood, int p_mod_percent_stone, int p_mod_percent_iron, int p_mod_percent_mana,
		int p_assignment1, int p_assignment2, int p_assignment3, int p_assignment4, int p_assignment5,
		int p_req_tech, int p_tech_group, int p_tech_secondary_group) {

	set_strings(p_name, p_description, p_icon);
	set_base_data(p_rank, p_next_rank, p_time_to_build, p_creates, p_num_creates, p_score, p_defense, p_ability);
	set_cost(p_cost_food, p_cost_wood, p_cost_stone, p_cost_iron, p_cost_mana);
	set_mod_max(p_mod_max_food, p_mod_max_wood, p_mod_max_stone, p_mod_max_iron, p_mod_max_mana);
	set_mod_rate(p_mod_rate_food, p_mod_rate_wood, p_mod_rate_stone, p_mod_rate_iron, p_mod_rate_mana);
	set_mod_percent(p_mod_percent_food, p_mod_percent_wood, p_mod_percent_stone, p_mod_percent_iron, p_mod_percent_mana);
	set_assignments(p_assignment1, p_assignment2, p_assignment3, p_assignment4, p_assignment5);
	set_technologies(p_req_tech, p_tech_group, p_tech_secondary_group);
}

Building::Building() :
		Resource() {

	rank = 0;
	next_rank = 0;
	time_to_build = 0;
	creates = 0;
	num_creates = 0;
	score = 0;
	defense = 0;
	ability = 0;

	cost_food = 0;
	cost_wood = 0;
	cost_stone = 0;
	cost_iron = 0;
	cost_mana = 0;

	mod_max_food = 0;
	mod_max_wood = 0;
	mod_max_stone = 0;
	mod_max_iron = 0;
	mod_max_mana = 0;

	mod_rate_food = 0;
	mod_rate_wood = 0;
	mod_rate_stone = 0;
	mod_rate_iron = 0;
	mod_rate_mana = 0;

	mod_percent_food = 0;
	mod_percent_wood = 0;
	mod_percent_stone = 0;
	mod_percent_iron = 0;
	mod_percent_mana = 0;

	assignment1 = 0;
	assignment2 = 0;
	assignment3 = 0;
	assignment4 = 0;
	assignment5 = 0;

	req_tech = 0;
	tech_group = 0;
	tech_secondary_group = 0;
}

Building::~Building() {
}
